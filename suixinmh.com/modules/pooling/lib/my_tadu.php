<?php
//3GAPI������
include_once ($GLOBALS['jieqiModules']['pooling']['path'] . '/class/iapi.php');
include_once ($GLOBALS['jieqiModules']['pooling']['path'] . '/class/baseApi.php');
include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
class MyTadu extends baseApi implements iApi{
	public $COPYRIGHTID = '55';
	public $SECRE = '3487aafa50e307b50f3e7f603c42d635';
	public $GET_LASTUPDATE_CHAPTER = 'http://openapi.tadu.com/api/getUpdateInfo';
	public $ADD_BOOK_URL = 'http://openapi.tadu.com/api/addBook';
	public $ADD_CHAPTER_URL = 'http://openapi.tadu.com/api/addChapter';
// 	var $KEY;
	//���캯��
	function MyTadu(){
		parent::initDB();
		$this->setKey();
	}
	/**
	 * ����tadu�ܳ�
	 * @see baseApi::setKey()
	 */
	function setKey(){
		$this->KEY = sha1($this->COPYRIGHTID.$this->SECRE);
	}
	/////////////��������鼮�ӿ�/////////////
	/*�ӿڵ�ַ��http://183.61.112.45:88/PartnersBookInsert/BookInfo.aspx
	 ����ʽ��POST
	�̶�������
	��������	˵��	����	�Ƿ��Ҫ����
	username	�������û���	�ַ���	��
	sign	ǩ������	�ַ���	��
	bookname	�鼮����	�ַ���	��
	author	��������	�ַ���	��
	cpbookid	��������ID	��ֵ	��
	detail	�鼮���	�ַ���	��
	category	����Id(���3G��Ƿ����)	��ֵ	��(Ĭ��0)
	status	����״̬(1Ϊ���� 2Ϊ���)	��ֵ	��(Ĭ������)
	����ֵ��json��ʽ���ؽ������ʽ���£�
	�ɹ���{"result":true,"errorCode":""}
	ʧ�ܣ�{"result":false,"errorCode":"001"}
	*/
	function addBook($cpid,$data){//���͵�����
		if($data){ 
			extract($data);
		}else{return false;}
		//�ж������Ƿ����
		if(!$retBook = $this->get_lastupdate($cpid)) {//����ѯ����״̬����ֱ�ӷ��ش��󣬳��������Ȿ��
			return false;
		}
		if($retBook->result->bookid) return $retBook;//�������ڣ����Ǿ�ֱ�ӷ���������ĸ���״̬����

		if(!$bookname || !$authorname || !$cpid || !$coverimage || !$url){
			$this->outMessage('---->���ݲ�������');
			return false;//�Ա����������֤
		}else{
			$message = array(
					'key' => $this->KEY,
					'cpid' => $cpid,
					'copyrightid' => $this->COPYRIGHTID,
					'coverimage' => $coverimage,
					'bookname' => $bookname,
					'authorname' => $authorname,
					'intro' => $intro,
					'classid' => $this->getCategory($classid),
					'serial' => $serial,
					'isvip' => $isvip,
					'url' => $url
			);
			if($ret = $this->request($this->ADD_BOOK_URL, 'POST', $message)){ //���鼮�ӿڷ���ָ��
				$ret = json_decode($ret);
				if($ret->code=='0'){//ִ�гɹ�
					return $ret;
				}else{
					$this->outMessage('---->������������ţ�'.$ret->code.'.������Ϣ��'.$ret->message);
					return false;
				}
			}else{
				$this->outMessage('---->�������!�������');
				return false;
			}
		}
		//}
	}

	function addChapter($data){//���͵�����
		
		$rpfrom = array("", "&nbsp;", "", "",">","<","	");
		$tofrom = array(" ", " ", "", "","","","");

		if($data) extract($data);
		else return false;
		if(!$content) return true;
		if(!$bookid || !$title || !$content || !$chapterid || !$updatemode) return false;//�Ա����������֤
		else{
			$message = array(
					'key' => $this->KEY,
					'bookid' => $bookid,
					'copyrightid' => $this->COPYRIGHTID,
					'title' => str_replace($rpfrom, $tofrom, $title),
					'content' => $content,
					'chapternum' => $chapternum,
					'isvip' => $isvip,
					'chapterid' => $chapterid,
					'updatemode' => $updatemode

			);
			if($ret = $this->request($this->ADD_CHAPTER_URL, 'POST', $message)){//print_r($ret);exit;
				//if($isvip){//echo $ret;
				//print_r($message);exit;
				//}
				$ret = json_decode($ret);
				if($ret->code=='0'){//ִ�гɹ�
					return true;
				}else{//print_r($ret);print_r($message);exit;
					$this->outMessage('---->�½ڳ��������ţ�'.$ret->code.'������Ϣ��'.$ret->message);
					return false;
				}
			}else return false;
		}
	}
	
	function outMessage($message = '�������'){
		echo $message.'<br>';
	}

	//��ȡ��������½�
	function get_lastupdate($cpid){
		if(!$cpid) {return false;}
		$message = array(
				'key' => $this->KEY,
				'cpid' => $cpid,
				'copyrightid' => $this->COPYRIGHTID
		);
		//$message = array('key'=>'79ae07826f9b22d0c42aaba2a13e4d8d7dd8f8a9','cpid'=>'1416','copyrightid'=>'55');
		if($ret = $this->request($this->GET_LASTUPDATE_CHAPTER, 'POST', $message)){//echo $ret;exit;
			$ret = str_replace('	', '', $ret);//ASCII=09��ˮƽ�Ʊ����json_decode����һ����ת��ʧ��
			$ret = json_decode($ret);
			return $ret;
		}else{
			return false;
		}
	}

	/////////////�����޸Ľӿ�/////////////
	function updateBook($data){//���͵�����
		if($data) extract($data);
		$message = array(
				'key' => $this->KEY,
				'cpid' => $cpid,
				'copyrightid' => $this->COPYRIGHTID,
				'classid' => $this->getCategory($classid),
				'serial' => $serial

		);
		if($ret = $this->request(UPDATE_BOOK_URL, 'POST', $message)){ //���鼮�ӿڷ���ָ��
			$ret = json_decode($ret);
			if($ret->code=='0'){//ִ�гɹ�
				return true;
			}else{
				$this->outMessage('---->�޸��걾״̬���������ţ�'.$ret->code.'.������Ϣ��'.$ret->message);
				return false;
			}
		}else{
			$this->outMessage('---->�޸��걾״̬����!������ϣ�');
			return false;
		}
	}
	/////////��ȡ����/////////
	/*	����Id	������	������	Ƶ��
	 1	����	��ô�½	��Ƶ
	2	���	�������	����
	3	����	�̽�����	��Ƶ
	4	����	��������	����
	5	ͬ��	ͬ����ƪ	ŮƵ
	6	�ƻ�	�ƻ�ʱ��	��Ƶ
	7	����	��������	��Ƶ
	8	����	���ξ���	��Ƶ
	9	����	�������	��Ƶ
	10	����	���鶼��	��Ƶ
	11	�ഺ	�ഺУ԰	ŮƵ
	12	����	��ѧ����	����
	13	����	����ٿ�	����
	16	��ʷ	��ʷ����	��Ƶ
	17	����	��Ѫ����	��Ƶ
	18	����	����	����
	19	����	���˴���	����
	23	�ഺ	�ഺ	����
	26	�Ŵ�	�Ŵ�	ŮƵ
	27	�ִ�	�ִ�	ŮƵ
	28	����	����	ŮƵ
	29	����	����	ŮƵ
	30	�ܿ�	�ܿ�	ŮƵ
	31	��Խ	��Խ	ŮƵ
	32	����	����	ŮƵ
	33	���	���	��Ƶ
	34	����	����	��Ƶ
	35	����	����	����
	36	���	���	����
	37	����	����	����
	38	��־	��־	����
	39	����	����	ŮƵ
	41	У԰	У԰	ŮƵ*/
	function getCategory($category=0){
		//��ʽ��array(��վ����=>3G����);
		$sort = array(
				1=>99,
				2=>103,
				3=>107,
				4=>112,
				5=>111,
				6=>109,
				7=>112,
				8=>108,
				9=>113,
				10=>128,
				11=>109,
				12=>104
		);
		if(isset($sort[$category])) return $sort[$category];
		else return 103;
	}
	function request($url, $mode, $params=array(), $header = 'Content-Type: text/plain; charset=utf-8;') {
		if($params) $this->arrayRecursive($params, 'urlencode', true);
		$query = http_build_query($params);
		$urlarr = parse_url($url);
		$responseText = $this->fsockPost($urlarr["path"], $urlarr["host"],$query);
// 		$this->out_msg ( '---->����ֵlen:'.strlen($responseText));
		$start = strpos($responseText, '{', 1);
		$len = strrpos($responseText, '}', 1) - $start + 1;
		$responseText = substr($responseText, $start, $len);
		return $responseText;
		// 		}
	}
// 	function request($url, $mode, $params=array(), $header = 'Content-Type: text/plain; charset=utf-8;') {
// 		$time_out = "60";
// 		if($params) $this->arrayRecursive($params, 'urlencode', true);
// 		$query = http_build_query($params);
// 		$urlarr     = parse_url($url);
// 		$errno      = "";
// 		$errstr     = "";
// 		$transports = "";
// 		$responseText = "";
// 		if($urlarr["scheme"] == "https") {
// 			$transports = "ssl://";
// 			$urlarr["port"] = "443";
// 		} else {
// 			$transports = "tcp://";
// 			if(!isset($urlarr['port'])){$urlarr['port'] = "80";}
// 		}
// // 		$fp=@fsockopen($urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
// // 		if(!$fp) {
// // 			die("ERROR: $errno - $errstr<br />\n");
// // 		}else{
// 			// 			fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
// 			// 			fputs($fp, "Host: ".$urlarr["host"].':'.$urlarr["port"]."\r\n");
// 			// 			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
// 			// 			fputs($fp, "Content-length: ".strlen($query)."\r\n");
// 			// 			fputs($fp, "Connection: close\r\n\r\n");
// 			// // 			fputs($fp, "Connection: keep-alive\r\n\r\n");
// 			// 			fputs($fp, $query . "\r\n");
// 			// 			while(!feof($fp)) {
// 			// 				$responseText .= @fgets($fp, 1024);
// 			// 			}
// 			// 			fclose($fp);
// 			print_r($urlarr);
// 			echo $url;
// 			exit;
// 			$responseText = $this->fsockPost($urlarr["path"], $urlarr["host"],$query);
				
				
// 			$start = strpos($responseText, '{', 1);
// 			$len = strrpos($responseText, '}', 1) - $start + 1;
// 			$responseText = substr($responseText, $start, $len);
// 			return $responseText;
// // 		}
// 	}
	/**
	 * ��������
	 * <br>ʵ��iapi�ӿ��ж�������ͷ���
	 *
	 * @param unknown $channleid
	 * @param unknown $article
	 *        	2014-7-1 ����8:58:18
	 */
	function push($channleid, $article) {
		$articleLib = $this->load ( 'article', 'article' );
		$channleLib = $this->load ( 'channel', 'pooling' ); // ����channel�Զ�����
		$channle = $channleLib->get ( $channleid );
		$rpfrom = array (
				"",
				"&nbsp;",
				"",
				"",
				">",
				"<",
				" "
		);
		$tofrom = array (
				" ",
				"&",
				"",
				"",
				"",
				"",
				""
		);
		$startupdate = false; // ��ʼ�����±��

		$fullflag = $cpcid = $chapternum = $i = $k = $kk = 0;
		$chapters = array ();
// 		$setting = array ();
// 		// ��������
// 		if ($article ['setting']) {
// 			eval ( '$article[\'setting\'] = ' . $article ['setting'] . ';' ); // �����������
// 			$setting = $article['setting'];
// 		} else
// 			$setting = $channle['setting'];
		// ��ʼ����VIP�½�
		$isvip = 0;
		$articletype = intval ( $article ['articletype'] );
		if ($articletype > 0) {
			$isvip = 1;
		}
		if ($article['image']) {
			$cover = JIEQI_URL . "/api/api_image" . $article['image'];
		} else {
			$cover = jieqi_geturl ( 'article', 'cover', $article ['articleid'], 's', $article ['imgflag'] );
		}

		$message = array (
				'cpid' => $article ['articleid'],
				'coverimage' => $cover,
				'bookname' => jieqi_gb2utf8 ( $article ['articlename'] ),
				'authorname' => jieqi_gb2utf8 ( $article ['author'] ),
				'intro' => jieqi_gb2utf8 ( $article ['intro'] ),
				'classid' => $article ['sortid'],
				'serial' => 1,
				'isvip' => $isvip,
				'url' => JIEQI_URL . '/book/' . $article ['articleid'] . '.htm'
		);
		if (!$retArticle = $this->addBook ( $article ['articleid'], $message )) {
			$this->out_msg_err ( '---->��API���͡�' . $article ['articlename'] . '��ʱ�����������飡' );
			return;
		} else { // �����½ڿ�ʼ
			$startupdate = false;
			if($retArticle->result->chapterid && $retArticle->result->chapternum){
				$this->out_msg ( '---->�ϴ�������Ϣ��' );
				$this->out_msg ( '---->�½����ƣ�' . jieqi_utf82gb ( $retArticle->result->chaptername ) );
				$this->out_msg ( '---->�½�ID��' . $retArticle->result->chapterid );
				// ���µ����½�λ��
				if (!$article ['lastchapterid']) {
					$this->out_msg_err ( '---->�ֶ�ά��������͵��½�Id' );
					return;
				}
			}else{
				$this->out_msg ( '---->�����һ������' );
				$startupdate = true;
			}
			$chapternum = $retArticle->result->chapternum ? $retArticle->result->chapternum : 1;
		} // �����½ڽ���
		$chapters = $this->getChapters ( $article ['articleid'] );
		$totalchapter = count ( $chapters );
		// ��ʼ������
// 		if (! $cpcid)
// 			$startupdate = true;
// 		else
// 			$startupdate = false; // ��ʼ�����±��
				                      // $chapterid = $retArticle->chapterid ? $retArticle->chapterid :0;
				                      
		foreach ( $chapters as $c ) {
			$fullflag = 0;
			$k ++;
			if (! $startupdate) {
				if ($article ['lastchapterid'] == $c ['cpchapterid']) {
					$startupdate = true;
					if (($totalchapter - $k) > 0) {
						$this->out_msg ( '---->��' . $article ['articlename'] . '�����͵�[' . $c ['chaptername'] . '],����<b>' . ($totalchapter - $k) . '</b>ƪ��Ҫ����' );
					} else{
						$this->out_msg ( '---->���½���Ҫ����!' );
						return;
					}
				} else {
					continue;
				}
			} else { // ��ʼ�����½�
				if ($k == 1) {
					$this->out_msg( '---->��' . $article ['articlename'] . '����<b>' . ($totalchapter) . '</b>ƪ�½���Ҫ����');
				}
				// ���Ƹ����½�
				// if($setting['open']){
				// if($setting['data']!='allchapter'){
				// //�ո����½���
				// if(date('Ymd',$article['lastupdate'])==date('Ymd',time()) && $article['daychapters']>0){//��ǰ�и���
				// $daychapters = $article['daychapters']+$kk+1;
				// }else{
				// $daychapters = $kk+1;
				// }
				// if($setting['daychapter']>0 && $daychapters>$setting['daychapter']){
				// $ApiCP->out_msg('<font color=red>����ֹͣ��ϵͳ����ÿ�����Ƹ���'.$setting['daychapter'].'��</font>');
				// break;
				// }
				// }else{
// 				$daychapters = $kk + 1;
				// }
				// ���վ��������
				// if($setting['sleepchapter']>0){
				// if(($totalchapter-$k)<$setting['sleepchapter'] && !$article['full']){
				// $ApiCP->out_msg('<font color=red>����ֹͣ��ϵͳ����ʼ�����վ'.$setting['sleepchapter'].'��</font>');
				// break;
				// }
				// }
				// }
				// $chapterid++;
				$message = array (
						'bookid' => $article ['articleid'] . '0' . $this->COPYRIGHTID,
						'title' => jieqi_gb2utf8 ( str_replace ( $rpfrom, $tofrom, $c ['chaptername'] ) ),
						'content' => jieqi_gb2utf8 ( $c ['content'] ),
						'chapternum' => $chapternum,
						'isvip' => $c ['isvip'],
						'chapterid' => $c ['cpchapterid'],
						'updatemode' => 1
				);
				if ($this->addChapter ( $message )) {
					$kk ++;
					$chapternum ++;
					$lastchapterid = $c ['cpchapterid'];
					$lastchapter = $c ['chaptername'];
					//full=1 �� cpchapterid�����һ���½�
					if ($article ['full'] && $chapters [$totalchapter - 1] ['cpchapterid'] == $c ['cpchapterid']) {
						$fullflag = 1;
						//û�и��µ�url
// 						$this->updateBook ( array (
// 								'cpid' => $article ['articleid'],
// 								'classid' => $article ['sortid'],
// 								'serial' => 0
// 						) );
					}
					if (! $kk)
						$outchapters = $article ['outchapters'];
					else
						$outchapters = $article ['outchapters'] + $kk;
// 					$this->db->init ( 'article', 'paid', 'pooling' );
// 					$this->db->edit ( $article['paid'], array (
// 							'lastchapterid' => $lastchapterid,
// 							'lastchapter' => $lastchapter,
// 							'outchapters' => $outchapters,
// 							'fullflag' => $fullflag,
// 							'lastdate' => JIEQI_NOW_TIME
// 					) );
					
					$this->out_msg ('---->'. $kk . '��' . $c ['chaptername'] . '...ok' );
					// ͬ�����ݳص������µ�
					$article ['lastvolumeid'] = 0;
					$article ['lastvolume'] = '';
					$article ['lastchapterid'] = $lastchapterid;
					$article ['lastchapter'] = $lastchapter;
					$article ['outchapters'] = $outchapters;
					$article ['fullflag'] = $fullflag;
					$article ['lastdate'] = JIEQI_NOW_TIME; // ����ʱ��
					if(is_array($article ['setting'])){//��һ��ͬ��ʱ������ת�ַ���
						$article ['setting'] =  $this->arrayeval($article ['setting']);
					}
					unset ( $article ['author'] );
					unset ( $article ['sortid'] );
					unset ( $article ['keywords'] );
					unset ( $article ['siteid'] );
					unset ( $article ['size'] );
					unset ( $article ['articletype'] );
					unset ( $article ['full'] );
					unset ( $article ['imgflag'] );
					$this->db->init ( 'article', 'paid', 'pooling' );
					if (!$this->db->edit ( $article ['paid'], $article )) {
						$this->out_msg_err ( '---->���ݳ����¡�' . $article ['articlename'] . '����״̬ͬ��ʧ�ܣ�' );
					}
				} else {
					$kk ++;
					$this->out_msg_err ( '---->'.$kk . '�� ' . $c ['chaptername'] . '������ʧ�ܣ���������������ͣ�' );
					return;
				}
			}
		}
		if (! $startupdate) {
			$this->out_msg_err ( '---->δƥ��������͵��½ڣ��ֶ�ά��������͵��½�ID' );
		}
// 		$daychapters = 0;
// 		$lastchapterid = $lastchapter = '';
	}
}
?>