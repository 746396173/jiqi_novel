<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iapi.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iSynchronization.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/baseApi.php');
include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * �й����������Ķ������ͽӿ��࣬
 * <p>
 * �̳�baseApi������
 * <p>
 * ʵ��iApi�ӿ�
 * <p>
 * ���ӿ�ֻ�ṩ������ƽ̨���½ڸ��¹��ܣ���Ϊ������������cpmƽ̨������
 * �����½ڸ���ͨ������cmpƽ̨�ṩ��api�ӿ����͡�
 * @author chengyuan
 *
 */
class MyTelecom extends baseApi implements iApi,iSynchronization {
	/**
	 * ����
	 * <p>
	 * test(����)|produce(����)
	 * @var unknown
	 */
	const ENVIRONMENT = 'test';
	/**
	 * ��ѯ��¼URL
	 * @var unknown
	 */
	const QUERY_URL = '/ReadPlatformClient_Content/servlet/getContentIdByContentNameAuthor';
	/**
	 * ����URL
	 * @var unknown
	 */
	const UPDATE_URL = '/ReadPlatformClient_Content/servlet/updateContentInterface';
	
	/**
	 * 1000002629854
	 * @var unknown
	 */
	const CPID = '1000002629854';
	const PASSWORD = 'ytxt@123';
	/**
	 * ������ö������
	 * @var unknown
	 */
	var $msg =  array(
			'001'=>'token������Ȩ��',
			'002'=>'zip����ʽ����',
			'003'=>'�½ڸ�ʽ����',
			'004'=>'�걾�����ϴ�',
			'005'=>'�ֽ��� >20000 �� < 1000',
			'006'=>'�����½�δ��ˣ��������أ�',
			'007'=>'����model�������� 0��1',
			'008'=>'finishFlag ��������',
			'009'=>'cpδ��Ȩ',
			'010'=>'�鼮δ��Ȩ',
			'011'=>'�鼮id��xml�е��鼮id����Ӧ',
			'012'=>'�鼮�½������Ѿ�����',
			'013'=>'�ϴ��鼮�½ڲ�����',
			'014'=>'�ϴ�������'
	);

	function __construct() {
		parent::initDB();
		$this->setKey();
	}
	/**
	 * �������л�������
	 * @return string
	 */
	private function getHost(){
		$host = '115.239.135.2';
		if(MyTelecom::ENVIRONMENT == 'produce'){
			$host = '61.130.247.180';
		}
		return $host;
	}
	/**
	 * �������л�������
	 * @return string
	 */
	private function getPort(){
		$port = 8104;
		if(MyTelecom::ENVIRONMENT == 'produce'){
			$port = 6001;
		}
		return $port;
	}
	/**
	 * @param $format ȱʡ��Y-m-d
	 * @return date($format)
	 */
	private function getTimestamp($format="Y-m-d"){
		return date($format);
	}
	/**
	 * �����ܳ�
	 * @see baseApi::setKey()
	 */
	function setKey(){
	}
	function get_lastupdate($params){
		$query = http_build_query($params);
		$res = $this->fsockPost(MyTelecom::QUERY_URL,$this->getHost(),$query,$this->getPort());	
		if($res){
			$json = $this->parseJson($res);
			if(is_object($json)){
				return $json;
			}else{
				return false;
			}
		}else{
			$this->out_msg_err('response is null');
			return false;
		}

	}
	/**
	 * ��ȡsocket��Ӧ��json��ʽ���ݣ����ҽ���Ϊjson����
	 * @return json object
	 */
	private function parseJson($res){
		$start = strpos($res, '{', 1);
		$len = strrpos($res, '}', 1) - $start+1;
		$jsontxt = substr($res, $start, $len);
		$jsontxt = str_replace(array('	','true','false'),array('','"true"','"false"'), $jsontxt);//ASCII=09��ˮƽ�Ʊ����json_decode�����쳣��ת��ʧ��
		$jsontxt = str_replace('{', '{"', $jsontxt);
		$jsontxt = str_replace(',', ',"', $jsontxt);
		$jsontxt = str_replace(':"', '":"', $jsontxt);//���⣬�½���������:���ţ�����
		//�ַ�������true,falseת��boolean���� true,false
		$jsontxt = str_replace(array('"true"','"false"'),array('true','false'), $jsontxt);
		$json = json_decode($jsontxt);
		return $json;
	}
	function addChapter($data){
		$res = $this->fsockPost(MyTelecom::UPDATE_URL,$this->getHost(),$data,$this->getPort());
		$json = $this->parseJson($res);
		if(is_object($json)){
			return $json;
		}else{
			return false;
		}
// 		include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/SingleFileSender.php');
// 		$sfs=new SingleFileSender("http://".$this->getHost().MyTelecom::UPDATE_URL);
// 		//set sfs prot(default prot 80)
// 		$sfs->setPort($this->getPort());
// 		if($ret = $sfs->post($data,true)){
			
// 			echo $ret;
			
// 			$json = $this->parseJson($ret);
// 			if(is_object($json)){
// 				return $json;
// 			}else{
// 				return false;
// 			}
// 		}
	}
	function addBook($cpBid,$data){
		//��ʵ�ִ˷���
	}
	function request($url, $mode, $params=array(), $header = 'Content-Type: text/plain; charset=utf-8;'){
	}
	/**
	 * �������͵��½�ѹ������$filename��
	 * @param unknown $contentId
	 * @param unknown $chapters
	 * @param unknown $filename
	 * @return boolean
	 */
	private function makeZip($contentId,$chapters=array(),$filename){
		include_once (JIEQI_ROOT_PATH . '/lib/compress/zip.php');
		include_once $GLOBALS ['jieqiModules'] [JIEQI_MODULE_NAME] ['path'] . '/admin/controller/channelController.php';
		$controller = new channelController ();
		$controller->theme_dir = false;
		
		$old_display = Application::$_DISPLAY;
		$old_runpath = Application::$_HLM_RUN_PATH;
		$old_viewpath = Application::$_HLM_VIEW_PATH;
		Application::$_DISPLAY = false;
		Application::$_HLM_RUN_PATH = $GLOBALS ['jieqiModules'] [JIEQI_MODULE_NAME] ['path'];
		Application::$_HLM_VIEW_PATH = Application::$_HLM_RUN_PATH . '/templates/telecom';
		
		
		$zip = new JieqiZip ();
		if (! $zip->zipstart ( $filename )){
			return false;
		}
		
		$book_content = $controller->display ( array (
				'contentId' => $contentId,
				'chapters' => $chapters
		), 'book' );echo $book_content;exit('stop');
		$zip->zipadd ( 'book.xml', '<?xml version="1.0" encoding="UTF-8"?>' . jieqi_gb2utf8 ( $book_content ) );// bookģ��ʹ��html��ʽ�����ģ���������Ҫ����ͷxml��ʶ������ת��
		foreach ( $chapters as $c ) {// chapters/chapter.html�ļ�����
			if($c['chaptertype'] == 0){//�½�
				$chaptername = 'chapters/' . $c ['cpchapterid'] . '.html'; // ���λ�ã��ļ����ƻ��Զ��������ı���
				$c['content'] = jieqi_htmlstr($c['content']);
				$chapter_content = $controller->display ( array ('chapter' => $c ), 'chapter' );
				$zip->zipadd ( $chaptername, str_replace('#&nbsp;#','��',jieqi_gb2utf8($chapter_content)));
			}
			
		}
		$zip->setComment ( "Content Provider by Shuhai" );
		if ($zip->zipend ()) {
			@chmod ( $filename, 0777 );
		}
		if(!is_file($filename)){
			return false;
		}
		Application::$_DISPLAY = $old_display;
		Application::$_HLM_RUN_PATH = $old_runpath;
		Application::$_HLM_VIEW_PATH = $old_viewpath;
		return true;
	}
	/**
	 * mobile����
	 * <br>ʵ��iapi�ӿ��ж�������ͷ���
	 *
	 * @param unknown $channleid
	 * @param unknown $article			���͵����ݳ�����
	 *        	2014-7-1 ����8:58:18
	 */
	function push($channleid, $article) {
		$articleLib = $this->load ( 'article', 'article' );
		$articleLib->instantPackage ( $article ['articleid'] );
		$channleLib = $this->load ( 'channel', 'pooling' ); // ����channel�Զ�����
		$channle = $channleLib->get ( $channleid );
		$cpname = "CP" . MyTelecom::CPID;
		$token = strtolower ( md5 ( jieqi_gb2utf8 ( $cpname . MyTelecom::PASSWORD . $this->getTimestamp () . $article ['articlename'] . $article ['author'] ) ) );
		$params = array (
				'cpName' => $cpname,
				'timestamp' => $this->getTimestamp (),
				'token' => $token,
				'bookName' => jieqi_gb2utf8 ( $article ['articlename'] ),
				'bookAuthor' => jieqi_gb2utf8 ( $article ['author'] ) 
		);
		$date = $this->get_lastupdate ( $params );
		if (!$date || !$date->success) {
			$this->out_msg_err ( '---->MCPƽ̨����Ч���¼�¼��' );
		} else {
			$this->out_msg ( "---->��" . $article ['articlename'] . "���ϴ����ͼ�¼" );
			$this->out_msg ( "<table border=1><tr><th>���ݱ��</th><th>����½�����</th><th>����½ڱ�ţ���+�½ڣ�</th><th>������</th></tr>", false );
			$this->out_msg ( "<tr><td>{$date->contentId}</td><td>" . jieqi_utf82gb ( $date->latestChapter ) . "</td><td>{$date->lastId}</td><td>{$date->lastColumnId}</td></tr></table>", false );
			if (! $article ['lastchapterid'] || ! is_numeric ( $article ['lastchapterid'] )) {
				$this->out_msg_err ( '---->��ά����' . $article ['articlename'] . '�����ϴ����͵��½�ID' );
			} else {
				// all chapter
				// shuhai->0 or pooling->1
				if (intval ( $channle ['setting'] ['getdata'] ['chaptersource'] ) === 1) {
					$chapters = $this->getChaptersByPooling($article['paid'], 2 );
				} else {
					$chapters = $this->getChapters ( $article ['articleid'], 2 );
				}
				if(empty($chapters)){
					$this->out_msg_err ( '---->û�������½�' );
					return;
				}
				$startupdate = false; // ���±��
				$pass = true; // ��֤ͨ����ʶ
// 				$lastvolumeid = 0;
// 				$lastvolume = '';
				$k = $pc = $cc = 0;
				$split = false;
				$first_chapter_type = 0;//���͵ĵ�һ���½�����
				$first_volume_index = -1;//��һ����λ��
				$pushChapters = array (); // ��ȡ��Ҫ���͵��½�
				foreach ( $chapters as $c ) {
// 					if ($c ['chaptertype'] == 1) { // ��¼�����½����ڵľ�
// 						$lastvolumeid = $c ['cpchapterid'];
// 						$lastvolume = $c ['chaptername'];
// 						continue;
// 					}
					$k ++;
					if (! $startupdate) {
						// ��λ����λ��
						if ($article ['lastchapterid'] != $c ['cpchapterid']) {
							continue;
						} else {
							$startupdate = true;
						}
					} else {
						//��+�½���
						$pc ++;
						if($pc == 1){
							$first_chapter_type = $c ['chaptertype'];//��¼��һ���½�����
						}
						if($c['chaptertype'] == 1 && $first_volume_index == -1){//��һ����λ��,��1��ʼ������-1
							$first_volume_index = $pc;
						}
						if($c['chaptertype'] == 0){//�½���
							$cc++;
						}
						//��һ�����½ڣ��������¾�
						if($first_chapter_type == 0 && $c ['chaptertype'] == 1){
							$split = true;//�˱�ʶ���㣬�費��Ҫ�������
						}
						if ($pc === 1) {
							$this->out_msg ( '---->��ʼ����ȡ��Ҫ���͵��½�' );
							$this->out_msg ( "<table border=1><tr><th>��</th><th>�½�ID</th><th>�½�����</th><th>�½�����</th><th>�½ڱ��</th><th>�ֽڣ�1000<һ���½����ݵ��ֽ���<20000��</th><th>��֤</th></tr>", false );
						}
						$bytesize = $c ['size'];
						$chk = 'ͨ��';
						if ((1000 >= $bytesize || $bytesize >= 20000) && $c ['chaptertype'] == 0) {
							$chk = '<font color="red">ʧ��</font>';
							$pass = false;
						}
						$c ['order'] = $date->lastId + $pc; // �±��
						$chaptertype = $c ['chaptertype'] == 1 ? '<font color="green">��</font>' : '�½�';
						$this->out_msg ( "<tr><td>{$pc}</td><td>{$c ['cpchapterid']}</td><td>{$c ['chaptername']}</td><td>{$chaptertype}</td><td>{$c['order']}</td><td>{$bytesize}</td><td>{$chk}</td></tr>", false );
						if ($article ['setting'] ['daychapter'] && is_numeric ( $article ['setting'] ['daychapter'] ) && $article ['setting'] ['daychapter'] > 0) {
							$pushChapters [] = $c;
							if ($article ['setting'] ['daychapter'] == $cc) {
								break;
							}
						} else {
							$pushChapters [] = $c;
						}
					}
				}
				$this->out_msg ( "</table>", false );
				$this->out_msg ( '---->��������ȡ��Ҫ���͵��½�' );
				if ($pass) {
					if ($startupdate) {
						if (! empty ( $pushChapters )) {
							//���$pushChapters
							if($split){
								$this->out_msg ( '---->�����¾���Ҫ�������������' );
								$first = array_slice($pushChapters,0,$first_volume_index-1);
								$second = array_slice($pushChapters,$first_volume_index-1);
								if(!empty($first) && !empty($second)){
									$this->out_msg ( '---->��ֳɹ�' );
									$this->out_msg ( '---->��ʼ���͵�һ����' );
									$this->pushChapters($article,$date,array_slice($pushChapters,0,$first_volume_index-1));
									$this->out_msg ( '---->�������͵�һ����' );
									$this->out_msg ( '---->----------�������ķָ���------------' );
									$this->out_msg ( '---->��ʼ���͵ڶ�����' );
									$this->pushChapters($article,$date,array_slice($pushChapters,$first_volume_index-1));
									$this->out_msg ( '---->�������͵ڶ�����' );
								}else{
									$this->out_msg_err ( '---->���ʧ��' );
								}
							}else{
								$this->pushChapters($article,$date,$pushChapters);
							}
						} else {
							$this->out_msg ( '---->���½���Ҫ����' );
						}
					} else {
						$this->out_msg_err ( '---->δƥ��������͵��½ڣ��ֶ�ά��������͵��½�ID' );
					}
				} else {
					$this->out_msg_err ( '---->���޸Ĳ��ϸ���½�' );
				}
			}
		}
	}
	
	private function pushChapters($article,$date,$pushChapters){
		$this->out_msg ( '---->��ʼ�����������½�zip��' );
		$fileName = jieqi_uploadpath ( 'zip', JIEQI_MODULE_NAME ) . '/telecom.zip';
		if (! $this->makeZip ( $date->contentId, $pushChapters, $fileName )) {
			$this->out_msg_err ( '---->zip���쳣' );
			return;
		}
		$this->out_msg ( '---->�������½�zip�������ɹ�' );
		$zipFile = jieqi_readfile ( $fileName );
		$this->out_msg ( '---->��ʼ�������½�ѹ����' );
		$token = strtolower ( md5 ( MyTelecom::CPID . MyTelecom::PASSWORD . strval ( $this->getTimestamp () ) ) );
		$data = pack ( 'a17a19a32a20aa', MyTelecom::CPID, $this->getTimestamp ( "Y-m-d H:i:s" ), $token, $date->contentId, '0', '1' );
		$data .= $zipFile;
		$date = $this->addChapter ( $data );
		if ($date && $date->success) {
			$this->out_msg ( '---->�������½�ѹ�������ͳɹ�' );
			$this->out_msg ( '---->��ʼ����������λ��' );
			$lastChapter = end ( $pushChapters );
			$this->db->init ( 'article', 'paid', 'pooling' );
			if (! $this->db->edit ( $article ['paid'], array (
					'lastchapterid' => $lastChapter ['cpchapterid'],
					'lastchapter' => $lastChapter ['chaptername'],
					'outchapters' => $k,
					'fullflag' => $article ['full'],
					'lastdate' => JIEQI_NOW_TIME
			) )) {
				$this->out_msg_err ( '---->��������¼����λ��ʧ��' );
			}else{
				$this->out_msg ( '---->��������¼����λ�óɹ�' );
			}
		} else {
			$this->out_msg_err ( '---->�½�ѹ��������ʧ�ܣ�ԭ��' . $this->msg [$date->errorCode] );
		}
	}
	
	function handlePoolChapter(&$poolChapter){
		if($poolChapter && $poolChapter['chaptername'] && $poolChapter['content']){
			$poolChapter['chaptername'] = str_replace('������','�ڶ���',$poolChapter['chaptername']);//������
		}
	}
}
?>