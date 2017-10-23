<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iapi.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/baseApi.php');
include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * �������ͽӿ��࣬�̳�baseApi�����࣬ʵ��iApi�ӿ�
 * @author chengyuan  2014-7-3
 *
 */
class MySuning extends baseApi implements iApi {
	/**
	 * ���Ի���
	 * @var unknown
	 */
	const HOST = '58.240.86.161';//test
	/**
	 * ��������
	 */
// 	const HOST = 'openesb.suning.com';//produce

	/**
	 *Ʒ�Ʊ���
	 * @var unknown
	 */
	const SUPPLYID = "Z688";//����
// 	const SUPPLYID = "Y549";//����

	var $errmsg = array (
			0 => "�ɹ�",
			1 => "�鼮�½���Ϣ��ͼƬ�Ѵ���",
			2 => "�鼮����ʧ��",
			3 => "�鼮��Ϣδͬ��",
			4 => "�½�δͬ��",
			5 => "�ж���",
			6 => "�����½�δͬ��",
			7 => "ȱ�ٷ���",
			8 => "��Ʒ��������ʧ�ܣ�����ϵ������ά����",
			9 => "ͼƬ����ʧ��",
			10 => "�鼮��ͬ������x�£����ύ����x��",
			11 => "���鼮�´���δͬ���κ��½�",
			12 => "δע�����ϵĹ�Ӧ�̣����Ƚ���ע�ᣬ������Ϣ",
			13 => "��Ȩ��Ϣ����ǩ����֤ʧ��",
			14 => "��Ӧ����δ��ˣ�����ϵ������ά�������",
			15 => "������Ҫ��Ϣ����ǩ����֤ʧ��",
			16 => "������Ҫ��Ϣ����ǩ����֤ʧ��",
			17 => "�鼮�����أ�����ϵ������ά",
			18 => "�ύ���½�����Ч",
			19 => "����ͬ�������ݲ��ó������Ƶ�����"
	);
	function __construct() {
		parent::initDB();
		$this->setKey();
	}
	/**
	 * ����3g�ܳ�
	 * @see baseApi::setKey()
	 */
	function setKey(){
		$this->KEY = 'GTV8Sj40327i5WT0CP8e';//����
// 		$this->KEY = '57B316WuiI27q68QkSb9';//����
	}
	/**
	 * ��ȡ�ϴ����ͼ�¼
	 * @param unknown $cpbid
	 * @return multitype:unknown |boolean
	 * 2014-9-9 ����11:16:12
	 */
	function get_lastupdate($cpbid){
		$digitalSignature = sha1($cpbid.MySuning::SUPPLYID.'0'.$this->KEY);
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
				<Resource>\r\n
					<Book>\r\n
						<bookId>{$cpbid}</bookId>\r\n
						<supplyId>".MySuning::SUPPLYID."</supplyId>\r\n
						<chapterNums>0</chapterNums>\r\n
						<digitalSignature>{$digitalSignature}</digitalSignature>\r\n
					</Book>\r\n
				</Resource>";
		//����ķ��ؽ�����������
		$responseData =  $this->fsockPost('/esbadapter/EbookArticleContentMgmt_ALL/submitEbookChapter',MySuning::HOST,$xml);
		$responseData = jieqi_utf82gb($responseData);
		if($responseData){
			preg_match ( "/(.+)\<respCode\>(.+)\<\/respCode\>/isU", $responseData, $matches );
			if(count($matches) == 0){
				//�ϴ����͵ļ�¼
				preg_match ( "/(.+)\<chapterNo\>(.+)\<\/chapterNo\>/isU", $responseData, $matches );
				$chapterNo = $matches[2];
				preg_match ( "/(.+)\<chapterName\>(.+)\<\/chapterName\>/isU", $responseData, $matches );
				$chapterName = $matches[2];
				preg_match ( "/(.+)\<upDate\>(.+)\<\/upDate\>/isU", $responseData, $matches );
				$upDate = $matches[2];
				return array('chapterNo'=>$chapterNo,'chapterName'=>$chapterName,'upDate'=>$upDate);
			}elseif(count($matches) == 3){
				//���鼮�´���δͬ���κ��½�
				$respCode = intval($matches[2]);
				preg_match ( "/(.+)\<respDes\>(.+)\<\/respDes\>/isU", $responseData, $matches );
				$respDes = $matches[2];
				return array('code'=>$respCode);
			}else{
				$this->out_msg_err('---->���ͼ�¼���������ţ�'.$respCode.'������Ϣ��'.$respDes);
				return false;
			}
		}else{
			$this->out_msg_err ( '---->last update socket response data null');
			exit;
		}

	}
	/**
	 *	�����½�
	 * @param unknown $data	[articleid,chapterNo,chaptername,content]
	 * @return unknown
	 * 2014-9-10 ����4:56:04
	 */
	function addChapter($data){
		extract($data);
		$chaptername = $this->safeStrXml ( $chaptername);
		$digitalSignature = sha1(jieqi_gb2utf8($articleid.$chaptername.MySuning::SUPPLYID.$chapterNo.$this->KEY));
// 		echo jieqi_gb2utf8($articleid.$chaptername.MySuning::SUPPLYID.$chapterNo.$this->KEY).'<br>'.$digitalSignature;
// 		exit;
		//����content��������2��ȫ�ǿո�
		//1ȥ�����������֮��Ļ���,4����ǿո��滻Ϊ2��ȫ�ǿո��Կ��ƶ�������
		//2��һ������½����Ʋ�����
		$content = str_replace(array(PHP_EOL.PHP_EOL,'    '), array(PHP_EOL,'����'), $content);
		$addStr = '����'.$chaptername;
		if(substr($content,0,strlen($addStr)) ==  $addStr){//��һ�����½����ƣ�������һ�в�����
			$content = substr($content,4);//һ��ȫ��2������
		}else{//��һ��û���½����ƣ�����½����ƣ���������������
			$content = $chaptername.PHP_EOL.$content;
		}
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
		<Resource>\r\n
			<Book>\r\n
				<bookId>{$articleid}</bookId>\r\n
				<supplyId>".MySuning::SUPPLYID."</supplyId>\r\n
				<chapterNo>{$chapterNo}</chapterNo>\r\n
				<chapterName><![CDATA[{$chaptername}]]></chapterName>\r\n
				<content><![CDATA[{$content}]]></content>\r\n
				<digitalSignature>{$digitalSignature}</digitalSignature>\r\n
			</Book>\r\n
		</Resource>";
		$responseData =  $this->fsockPost('/esbadapter/EbookArticleContentMgmt_ALL/synEbookChapterContent',MySuning::HOST,jieqi_gb2utf8 ($this->saleXml($xml)));
		$responseData = jieqi_utf82gb($responseData);
		if($responseData){
			preg_match ( "/(.+)\<respCode\>(.+)\<\/respCode\>/isU", $responseData, $matches );
			$respCode = intval($matches[2]);
			preg_match ( "/(.+)\<respDes\>(.+)\<\/respDes\>/isU", $responseData, $matches );
			$respDes = $matches[2];
			return array('code'=>$respCode,'msg'=>$respDes);
		}else{
			$this->out_msg_err ( '---->add chapter socket response data null');
			exit;
		}
	}
	/**
	 * �ύ���͵��½�
	 * @param unknown $data
	 * 2014-9-10 ����3:32:28
	 */
	function submit($data){
		extract($data);
		$digitalSignature = sha1(jieqi_gb2utf8($articleid.MySuning::SUPPLYID.$chapterNums.$this->KEY));
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
		<Resource>\r\n
		<Book>\r\n
		<bookId>{$articleid}</bookId>\r\n
		<supplyId>".MySuning::SUPPLYID."</supplyId>\r\n
		<chapterNums>{$chapterNums}</chapterNums>\r\n
		<digitalSignature>{$digitalSignature}</digitalSignature>\r\n
		</Book>\r\n
		</Resource>";
		$responseData =  $this->fsockPost('/esbadapter/EbookArticleContentMgmt_ALL/submitEbookChapter',MySuning::HOST,jieqi_gb2utf8 ($xml));
		$responseData = jieqi_utf82gb($responseData);
		if($responseData){
			preg_match ( "/(.+)\<respCode\>(.+)\<\/respCode\>/isU", $responseData, $matches );
			$respCode = intval($matches[2]);
			preg_match ( "/(.+)\<respDes\>(.+)\<\/respDes\>/isU", $responseData, $matches );
			$respDes = $matches[2];
			// 		return $respCode;
			return array('code'=>$respCode,'msg'=>$respDes);
		}else{
			$this->out_msg_err ( '---->submit socket response data null');
			exit;
		}

	}
	/**
	 * (non-PHPdoc)
	 * @see iApi::addBook()
	 */
	function addBook($article,$data){
			// ������
		$responseData = $this->fsockPost ( '/esbadapter/EbookArticleContentMgmt_ALL/synEbookBooksInfo', MySuning::HOST, $data );
		$responseData = jieqi_utf82gb ( $responseData );
		if ($responseData) {
			preg_match ( "/(.+)\<respCode\>(.+)\<\/respCode\>/isU", $responseData, $matches );
			$respCode = intval ( $matches [2] );
			preg_match ( "/(.+)\<respDes\>(.+)\<\/respDes\>/isU", $responseData, $matches );
			$respDes = $matches[2];
			if ($matches && ($respCode === 0 || $respCode === 1)) {
				if ($respCode === 0) {
					// ��ӷ���
					$digitalSignature = sha1 ( jieqi_gb2utf8 ( MySuning::SUPPLYID . $this->KEY ) );
					$coverStream = jieqi_readfile ( JIEQI_ROOT_PATH . "/api/api_image" . $article ['image'] );
					$imgContent = base64_encode ( $coverStream );
					$xmlCover = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
					<Resource>\r\n
					<Book>\r\n
					<bookId>{$article['articleid']}</bookId>\r\n
					<supplyId>" . MySuning::SUPPLYID . "</supplyId>\r\n
					<imgContent>{$imgContent}</imgContent>\r\n
					<digitalSignature>{$digitalSignature}</digitalSignature>\r\n
					</Book>\r\n
					</Resource>";
					$responseData = $this->fsockPost ( '/esbadapter/EbookArticleContentMgmt_ALL/synEbookBooksCover', MySuning::HOST, $xmlCover );
					$responseData = jieqi_utf82gb ( $responseData );
					if($responseData){
						preg_match ( "/(.+)\<respCode\>(.+)\<\/respCode\>/isU", $responseData, $matches );
						$respCode = intval ( $matches [2] );
						preg_match ( "/(.+)\<respDes\>(.+)\<\/respDes\>/isU", $responseData, $matches );
						$respDes = $matches [2];
						if ($respCode === 0 || $respCode === 1) {
							return 0;
						} else {
							$this->out_msg_err ( '---->������������ţ�' . $respCode . '������Ϣ��' . $respDes );
							return false;
						}
					}else{
						$this->out_msg_err ( '---->add cover socket response data null');
						return false;
					}
				}
				return 1;
			} else {
				$this->out_msg_err ( '---->������������ţ�' . $respCode . '��������Ϣ��' . $respDes );
				return false;
			}
		} else {
			$this->out_msg_err ( '---->add book socket response data null');
			return false;
		}
	}
	//����Ҫʵ�֣���ͨ������baseApi�ṩ��fsockPostʵ��
	function request($url, $mode, $params=array(), $header = 'Content-Type: text/plain; charset=utf-8;'){
	}

	/**
	 * ��ȡ��վ���·���ӳ��������ɹ����࣬Ĭ�ϣ�����R9000155����
	 * @param unknown $sortid		��վ����Id
	 * @return Ambigous <string>	��Ӧ�������ɹ�����
	 * 2014-9-9 ����3:11:37
	 */
	private function getCateg($sortid){
		$category = array(
				1=>'R9000155',
				2=>'R9000159',
				3=>'R9000158',
				4=>'R9000164',
				5=>'R9000165',
				6=>'R9000157',
				7=>'R9000166',
				8=>'R9000163',
				9=>'R9000161',
				10=>'R9000162',
				11=>'R9000167',
				12=>'R9000160'
		);
		if(!$sortid || !array_key_exists($sortid, $category)){
			$sortid = 1;//Ĭ�ϣ�R9000155����
		}
		return $category[$sortid];

	}
	/**
	 * ��ȡ��վ���·���ӳ��������ɱ���࣬Ĭ�ϣ�����110100�ɱ����
	 * @param unknown $sortid		��վ����Id
	 * @return Ambigous <string>	��Ӧ�������ɱ����
	 * 2014-9-9 ����3:13:39
	 */
	private function getNewCateg($sortid){
		$category = array(
				1=>'110100',
				2=>'150400',
				3=>'140300',
				4=>'230100',
				5=>'220200',
				6=>'130100',
				7=>'240100',
				8=>'170200',
				9=>'160200',
				10=>'210200',
				11=>'250100',
				12=>'260200'
		);
		if(!$sortid || !array_key_exists($sortid, $category)){
			$sortid = 1;//Ĭ�ϣ�110100
		}
		return $category[$sortid];
	}
	/**
	 * ʵ�ֽӿڶ�������ͷ���
	 * @param unknown $channleid
	 * @param unknown $article
	 * 2014-9-10 ����9:19:27
	 */
	function push($channleid, $article) {
		$setting = $article ['setting'];//����
		if (!$article ['image']) {
			$this->out_msg_err ( '---->���ϴ�����棬����Ҫ�����£�' );
			$this->out_msg_err ( '---->1.���۷�����������Ҫ��ߣ�ͼƬ���أ�ԭ����Ҫ�����ԭͼ����Ϊ600x800�����ϣ�' );
			$this->out_msg_err ( '---->2.���޷��ṩ600x800�����ϵķ��棬���������Ƚ���300x400���ϵķ��棬�������ԭ��Ϊ�Ŵ�600*800��Ȼ�����' );
			$this->out_msg_err ( '---->3.�ɵ�����ͼƬ����Ϊ600x800�ķ��治���ܣ�' );
			$this->out_msg_err ( '---->4.300x400���µķ��治���ܣ�' );
			$this->out_msg_err ( '---->5.����������˾LOGO�ȣ�Ҫȥ����' );
			$this->out_msg_err ( '---->6.���ա�ɨ������ķ������ڻް���ʧ�桢���ε�����������ܣ�����ɨ����ɨ������������������ܣ�;' );
			$this->out_msg_err ( '---->7.���治��Ϊ������棻' );
		} else {
			$coverUrl = JIEQI_LOCAL_URL . "/api/api_image" . $article ['image'];
			$freeChapter = $this->getChapters ( $article ['articleid'], 0, 0 );
			$freeCont = count ( $freeChapter );
			$categ = $this->getCateg ( $article ['sortid'] );
			$newCateg = $this->getNewCateg ( $article ['sortid'] );
			$digitalSignature = sha1 ( jieqi_gb2utf8 ( $article ['articleid'] . $article ['articlename'] . MySuning::SUPPLYID . $this->KEY ) );
			$xmldata = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
				<Resource>\r\n
					<Book>\r\n
						<bookId>{$article ['articleid']}</bookId>\r\n
						<bookName><![CDATA[{$article ['articlename']}]]></bookName>\r\n
						<author><![CDATA[{$article ['author']}]]></author>\r\n
						<bookState>2</bookState>\r\n
						<description><![CDATA[{$article ['intro']}]]></description>\r\n
						<coverUrl><![CDATA[{$coverUrl}]]></coverUrl>\r\n
						<supplyId>" . MySuning::SUPPLYID . "</supplyId>\r\n
						<categ>{$categ}</categ>\r\n
						<newCateg>{$newCateg}</newCateg>\r\n
						<local>1</local>\r\n
						<pricingMode>1</pricingMode>\r\n
						<freeChapter>{$freeCont}</freeChapter>\r\n
						<paperPrice>0.03</paperPrice>\r\n
						<deadline>2020-01-01</deadline>\r\n
						<authorSummary></authorSummary>\r\n
						<mediaComment></mediaComment>\r\n
						<digitalSignature>{$digitalSignature}</digitalSignature>\r\n
					</Book>\r\n
				</Resource>";
			// xml��ʽת��utf-8����
			$chapters_ch = $this->getChapters ( $article ['articleid']);//�½�
			$result = $this->addBook ( $article, jieqi_gb2utf8 ( $xmldata ) );
			$startupdate = false; // ��ʼ���ͱ�ʶ
			if ($result === 0) { // �½�
				$this->out_msg ( '---->�½��ɹ�����'.count($chapters_ch).'�½���Ҫ���͡�' );
				$startupdate = true;
			} elseif ($result === 1) {// �Ѿ�����
				$data = $this->get_lastupdate ( $article ['articleid'] );
				if ($data ['code'] && $data ['code'] == 11) {
					$this->out_msg ( '---->���鼮�´���δͬ���κ��½ڣ���'.count($chapters_ch).'�½���Ҫ���͡�' );
					$startupdate = true;
				} else {
					$this->out_msg ( '---->�ϴ�������Ϣ��' );
					$this->out_msg ( '---->�½�ID��' . $data ['chapterNo'] );
					$this->out_msg ( '---->�½����ƣ�' . $data ['chapterName'] );
					$this->out_msg ( '---->����ʱ�䣺' . $data ['upDate'] );
					// ���µ����½�λ��
					if (!$article ['lastchapterid']) {
						$this->out_msg_err ( '---->�ֶ�ά��������͵��½�Id' );
						return;
					}
				}
			} else {
				$this->out_msg_err ( '---->��API���͡�' . $article ['articlename'] . '��ʱ�����������飡' );
				return;
			}
			$chapters = $this->getChapters ( $article ['articleid'], 2 );//�½�+��
			// ��ʼ����
			$totalchapter = count ( $chapters_ch ); // ���½���
			$lastvolumeid = 0;
			//$k:�ۼ������½���
			//$s:�������͵��½���
			//$a:$chapters���½�+����λ�ñ�ʶ
			//$v:��λ�ñ�ʶ
			$k = $s = $a = $v = 0;
			$lastvolume = '';
			foreach ( $chapters as $c ) {
				$a++;
				if ($c ['chaptertype'] == 1) { // ��¼�����½����ڵľ�
					$lastvolumeid = $c ['cpchapterid'];
					$lastvolume = $c ['chaptername'];
					$v = $a;
// 					continue;//bug������ϴ����͵����һ���Ǿ��ᵼ���޷���λ�ڵ�
				}
				$k ++;
				if (! $startupdate) {
					// ��λ����λ��
					if ($article ['lastchapterid'] != $c ['cpchapterid']) {
						continue;
					} else {
						$startupdate = true;
						if (($totalchapter - $k) > 0) {
							$this->out_msg ( '---->��' . $article ['articlename'] . '���ϴθ��µ�[' . $c['chaptername'] . '],����<b>' . ($totalchapter - $k) . '</b>ƪ��Ҫ����' );
						} else {
							$this->out_msg ( '---->���½���Ҫ����!' );
						}
					}
				} else {
					$s++;
					if($s === 1){
						$this->out_msg ( '<table border=1><tr><th>��</th><th>�½�����</th><th>����</th><th>�ύ</th></tr>',false);
					}
					//ÿ����ĵ�һ���½����Ƹ�ʽ����XX�� XXX ��һ�� XXX
					if($lastvolumeid && $lastvolume && $v+1 == $a){
						$c['chaptername'] = $lastvolume.' '.$c['chaptername'];
					}
					$result = $this->addChapter(array('articleid'=>$article ['articleid'],'chapterNo'=>$k,'chaptername'=>$c['chaptername'],'content'=>$c['content']));
					if($result['code'] === 0){
						$submitResutl = $this->submit(array('articleid'=>$article ['articleid'],'chapterNums'=>$k));
						if($submitResutl['code'] === 0){
							$submit = '�ɹ�';
						}else{
							$submit = 'ʧ�ܣ�'.$submitResutl['msg'];
						}
						$this->out_msg ( "<tr><td>{$s}</td><td>{$c['chaptername']}</td><td>�ɹ�</td><td>{$submit}</td></tr>",false);
						if($s == $totalchapter){//���һ��
							$this->out_msg( "</table>",false);
						}
						// ͬ�����ݳص������µ�
						$article ['lastvolumeid'] = $lastvolumeid;
						$article ['lastvolume'] = $lastvolume;
						$article ['lastchapterid'] = $c ['cpchapterid'];
						$article ['lastchapter'] = $c ['chaptername'];
						$article ['outchapters'] = $k;//�ۼ����͵��½��������½���ţ�
						$article ['fullflag'] = $article ['full'];
						$article ['lastdate'] = JIEQI_NOW_TIME; // ����ʱ��
						$article ['setting'] =  $this->arrayeval($setting);
						unset ( $article ['author'] );
						unset ( $article ['sortid'] );
						unset ( $article ['keywords'] );
						unset ( $article ['siteid'] );
						unset ( $article ['size'] );
						unset ( $article ['articletype'] );
						unset ( $article ['full'] );
						unset ( $article ['imgflag'] );
						$this->db->init ( 'article', 'paid', 'pooling' );
						if (! $this->db->edit ( $article ['paid'], $article )) {
							$this->out_msg_err ( '---->���ݳ����¡�' . $article ['articlename'] . '�������ͼ�¼ͬ��ʧ�ܣ�' );
						}
						if($setting['daychapter']
						&& is_numeric($setting['daychapter'])
						&& $setting['daychapter'] > 0
						&& $setting['daychapter'] == $s){
							$this->out_msg ('</table>---->ÿ��ֻ����'.$s.'��' );
							break;
						}
					}else{
						if($result['code'] === 1){
							//�Ѿ����͵������ύ
							$submitResutl = $this->submit(array('articleid'=>$article ['articleid'],'chapterNums'=>$k));
							if($submitResutl['code'] === 0){
								$submit = '�����ύ�ɹ�';
								$this->out_msg ( "<tr><td>{$s}</td><td>{$c['chaptername']}</td><td><font color='red'>ʧ��:".$result['msg']."</font></td><td>{$submit}</td></tr>",false);
							}else{
								$submit = '�����ύʧ�ܣ�'.$submitResutl['msg'];
								$this->out_msg ( "<tr><td>{$s}</td><td>{$c['chaptername']}</td><td><font color='red'>ʧ��:".$result['msg']."</font></td><td>{$submit}</td></tr></table>",false);
								return;
							}
						}else{
							$this->out_msg ( "<tr><td>{$s}</td><td>{$c['chaptername']}</td><td><font color='red'>ʧ��:".$result['msg']."</font></td><td>δ�ύ</td></tr></table>",false);
							return;
						}
						
					}
				}
			}
			if (!$startupdate) {
				$this->out_msg_err ( '---->δƥ��������͵��½ڣ��ֶ�ά��������͵��½�ID' );
			}
		}
	}
}
?>