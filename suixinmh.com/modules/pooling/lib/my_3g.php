<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iapi.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/baseApi.php');
include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * 3g���ͽӿ��࣬�̳�baseApi�����࣬ʵ��iApi�ӿ�
 * @author chengyuan  2014-7-3
 *
 */
class My3g extends baseApi implements iApi {



	const HOST = 'book.interface.3gsc.com.cn';
// 	const USERNAME = "testuser";
// 	const PASSWORD = "C7FA8E2E-8BBE-4128-A28F-5DAC4725C081";
	const USERNAME = "shuhai";
	const PASSWORD = "1964EDD5-3747-4659-B514-A590B8832427";
// 	const SIGN = md5("shuhai1964EDD5-3747-4659-B514-A590B8832427");

	var $errmsg = array (
			"001" => "�ʺŻ��������",
			"002" => "IP��ַδ�Ǽ�",
			"003" => "���������Ϊ��",
			"004" => "�鼮�Ѵ���",
			"005" => "�������鼮IdΪ0",
			"006" => "�������ʧ��",
			"007" => "�ύ���ݴ��ڿ�����",
			"008" => "�½��Ѵ���",
			"009" => "�鼮������",
			"010" => "�½�������",
			"011" => "��Ʒ״̬����Ϊ��",
			"012" => "����಻����",
			"013" => "С�������",
			"014" => "�鼮id�Ѵ���",
			"015" => "�ύ���鼮id�������Ʒ�Χ"
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
		$this->KEY = md5(My3g::USERNAME.My3g::PASSWORD);
	}
	/**
	 * ������ת��Ϊ��&���ӵ��ַ���,����ʹ��urlencode���롣
	 * <br>key=value&key=value
	 * @param unknown $arr
	 * 2014-7-11 ����3:43:37
	 */
	private function flat($arr) {
		if (is_array($arr)){
			$sets = array();
			foreach ($arr AS $key => $val)
				$sets[] = $key . '=' . urlencode($val);
			return implode("&",$sets);
		}
	}
	function get_lastupdate($cpbid){
		$reqStr = array('username'=>My3g::USERNAME,'sign'=>$this->KEY,'cpbookid'=>$cpbid);
		$responseData =  $this->fsockPost('/index.php?m=PartnerBookInsert&a=getlastmenu',My3g::HOST,$this->flat($reqStr));
		$responseData = strstr($responseData, '{');
		$patton = strstr($responseData, '}');
		$responseData = str_replace($patton,"",$responseData)."}";
		$de_json = json_decode($responseData, true);
		if($de_json["result"] == true){
			return $de_json;//���ϴ�������Ϣ
		}else if($de_json["errorCode"] == "009"){
			return true;//�����ͼ�¼
		}else{
			$this->out_msg('---->ȡ������Ϣ����,ԭ��'.$this->errmsg[$de_json["errorCode"]]);
			return false;//û���ϴ����͵���Ϣ
		}
	}
	function addChapter($data){
		extract($data);
// 		global $username;
// 		global $password;
// 		global $sign;
// 		global $host;
// 		//$cpbookid ��������ID;$cpmenuid �������½�ID;$menuName �½�����;$isvip �Ƿ��շ�(0Ϊ���,1Ϊ�շ�);$username �½�����
// 		$num_args=func_num_args();
// 		if($num_args>0){
// 			$args=func_get_args();
// 			$cpbookid=$args[0];
// 			$cpmenuid=$args[1];
// 			$menuName=$args[2];
// 			$isvip=$args[3];
// 			$content=$args[4];
// 		}

		$reqStr = array('username'=>My3g::USERNAME,'sign'=>$this->KEY,'cpbookid'=>$cpbookid,'cpmenuid'=>$cpmenuid,'menuName'=>$menuName,'isvip'=>$isvip, 'content'=>$content);
// 		$header = "POST /index.php?m=PartnerBookInsert&a=menuinfo HTTP/1.1\r\n";
// 		$header .= "Host: ".My3g::HOST.":80\r\n";
// 		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
// 		$header .= "Content-length: ".strlen($this->flat($reqStr))."\r\n";
// 		$header .= "Connection: Close\r\n\r\n";		// POST������
// 		$header .= $this->flat($reqStr)."\r\n";
// 		$fp = fsockopen(My3g::HOST , 80, $errno, $errstr, 30);
// 		fwrite($fp, $header);
// 		$responseData = '';
// 		while (!feof($fp)) {
// 			$responseData .= fgets($fp, 1024);
// 		}
// 		fclose($fp);
		$responseData = $this->fsockPost('/index.php?m=PartnerBookInsert&a=menuinfo', My3g::HOST, $this->flat($reqStr));
		$responseData = strstr($responseData, '{');
		$patton = strstr($responseData, '}');
		$responseData = str_replace($patton,"",$responseData)."}";
		$de_json = json_decode($responseData, true);
		if($de_json["errorCode"]=="" && $de_json["result"]==true){
			return true;
		}else{
			$this->out_msg ( '---->������Ϣ��'.$this->errmsg[$de_json["errorCode"]]);
			return false;
		}
	}
	/**
	 * �������ͼ�¼���鷵��{"result":true,"CPMenuId":"11111","MenuName":"XXX","IsVip":"1"}��ʽ����,
	 * <br>�������ͳɹ�������true
	 * <br>���󣬷���false
	 * (non-PHPdoc)
	 * @see iApi::addBook()
	 */
	function addBook($cpBid,$data){
		if($book = $this->get_lastupdate($cpBid)){
			if($book['result']) return $book;//�ϴ�������Ϣ
			//������
			$responseData =  $this->fsockPost('/index.php?m=PartnerBookInsert&a=bookinfo',My3g::HOST,$this->flat($data));
			$responseData = strstr($responseData, '{');
			$patton = strstr($responseData, '}');
			$responseData = str_replace($patton,"",$responseData)."}";
			$de_json = json_decode($responseData, true);
			if($de_json["errorCode"]=="" && $de_json["result"]==true){
				return true;
			}else{
				$this->out_msg('---->������������ţ�'.$de_json["errorCode"].'������Ϣ��'.$this->errmsg[$de_json["errorCode"]]);
				return false;
			}
		}else{
			$this->out_msg('---->���ͳ���');
			return false;
		}







// 		return $responseData;
	}
// 	function addBook($bookname, $author, $cpbookid, $detail, $category, $stype, $status, $cover, $tag){
// // 		$header = "POST /index.php?m=PartnerBookInsert&a=bookinfo HTTP/1.1\r\n";
// // 		$header .= "Host: {$host}:80\r\n";
// // 		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
// // 		$header .= "Content-length: ".strlen(flat($reqStr))."\r\n";
// // 		$header .= "Connection: close\r\n\r\n";		// POST������
// // 		$header .= flat($reqStr)."\r\n";//echo $header;exit;
// // 		$fp = fsockopen($host , 80, $errno, $errstr, 30);
// // 		fwrite($fp, $header);
// // 		$responseData = '';
// // 		while (!feof($fp)) {
// // 			$responseData .= fgets($fp, 1024);
// // 		}
// // 		fclose($fp);


// 		$responseData =  $this->fsockPost('/index.php?m=PartnerBookInsert&a=bookinfo',$this->HOST,$this->flat($reqStr));


// 		$responseData = strstr($responseData, '{');
// 		$patton = strstr($responseData, '}');
// 		$responseData = str_replace($patton,"",$responseData)."}";

// 		return $responseData;
// 	}
	function request($url, $mode, $params=array(), $header = 'Content-Type: text/plain; charset=utf-8;'){
	}
// 	//��ȡ��ȫ�ܳ�
// 	private function getSecurityid($mcpBookId){
// 		if(!$mcpBookId)
// 			$this->printfail(LANG_ERROR_PARAMETER);
// 		return strtoupper ( sha1 ( MyMobile::MCPID . $mcpBookId . MyMobile::PASSWORD ) );
// 	}
	/**
	 * 3g����
	 * <br>ʵ��iapi�ӿ��ж�������ͷ���
	 *
	 * @param unknown $channleid
	 * @param unknown $paid			paid����
	 * 2014-7-1 ����8:58:18
	 */
	function push($channleid, $article) {
			// include_once($jieqiModules['article']['path'].'/class/article.php');

		// include_once($jieqiModules['obook']['path'].'/class/obook.php');
			// $obook_handler =& JieqiObookHandler::getInstance('JieqiObookHandler');
			// include_once($jieqiModules['obook']['path'].'/class/ochapter.php');
			// $ochapter_handler =& JieqiOchapterHandler::getInstance('JieqiOchapterHandler');

		// $jqdb=new JieqiDatabase();
			// $dbcon=$jqdb->getInstance();
			// include_once($jieqiModules['article']['path'].'/api/g3/function.php');
			// $errmsg = array("001"=>"�ʺŻ��������", "002"=>"IP��ַδ�Ǽ�", "003"=>"���������Ϊ��", "004"=>"�鼮�Ѵ���", "005"=>"�������鼮IdΪ0", "006"=>"�������ʧ��", "007"=>"�ύ���ݴ��ڿ�����", "008"=>"�½��Ѵ���", "009"=>"�鼮������", "010"=>"�½�������");

		// $usebook = "(".$_REQUEST['id'].")";//��ֹ�鵥
			// $sql="SELECT id,articleid,articlename,process,start FROM ".jieqi_dbprefix('article_api')." WHERE articleid in ".$usebook." AND type=7 and process=0";
		$articleid = $article ['articleid'];
		$setting = $article ['setting'];
		// $article_handler =& JieqiArticleHandler::getInstance('JieqiArticleHandler');
		// $article=$article_handler->get($articleid);
		// if(!is_object($article)){$errorMessage = "���ش��������Ϣ== &gt����ϸ����鼮";$latestchap= "";continue;}
		$articlename = preg_replace ( '/&#(\d+);|&amp;nbsp;|<br\s\/>|&nbsp;/', '', $article ['articlename'] );
		$bookname = jieqi_gb2utf8 ( $articlename );
		$author = preg_replace ( '/&#(\d+);|&amp;nbsp;|<br\s\/>|&nbsp;/', '', $article ['author'] );
		$author = jieqi_gb2utf8 ( $author );
		$intro = preg_replace ( '/&#(\d+);|&amp;nbsp;|<br\s\/>|&nbsp;/', '', $article ['intro'] );
		$detail = jieqi_gb2utf8 ( $intro );
		// $bookCategory=array(0, 1, 10, 7, 32, 6, 7, 10, 16, 16, 9, 5, 4);
		//�麣����1-12
		$bookCategory = array (
				0,//ռλ
				1,
				10,
				7,
				8,
				6,
				7,
				8,
				16,
				16,
				9,
				30,
				26
		);
		$sbookCategory = array (
				0,//ռλ
				33,
				60,
				49,
				53,
				40,
				153,
				55,
				77,
				171,
				56,
				222,
				92
		);
		// $shuhai_cata= $article->getVar('sortid');
		$category = $bookCategory [$article ['sortid']]?$bookCategory [$article ['sortid']]:26;
		$stype = $sbookCategory [$article ['sortid']]?$sbookCategory [$article ['sortid']]:92;
		if ($article ['full'] == 0) {
			$status = 1;//����
		} else {
			$status = 2;//�걾
		} // echo $articlename."<hr>".$author."<hr>".$articleid."<hr>".$intro."<hr>".$category."<hr>".$stype."<hr>".$status."<hr>".$cover;exit;
		$cover = jieqi_geturl ( 'article', 'cover', $articleid, 's', $article ['imgflag'] );
		// $tag = "";
		$tag = $article ['keywords'];
		if (! $tag) {
			$tag = $article ['articlename'];
		}
		$tag = jieqi_gb2utf8 ( str_replace ( " ", ',', $tag ) );
		$data = array (
				'username' => My3G::USERNAME,
				'sign' => $this->KEY,
				'bookname' => $bookname,
				'author' => $author,
				'cpbookid' => $articleid,
				'detail' => $detail,
				'category' => $category,
				'stype' => $stype,
				'status' => $status,
				'cover' => $cover,
				'tag' => $tag
		);
		$ret = $this->addBook ( $articleid, $data );
		if (! $ret) {
			$this->out_msg_err ( '---->��API���͡�' . $article ['articlename'] . '��ʱ�����������飡' );
			return;
		} else {
			$startupdate = false; // ��ʼ���ͱ�ʶ
			if ($ret ['CPMenuId']) {
				$this->out_msg ( '---->�ϴ�������Ϣ' );
				$this->out_msg ( '---->CPMenuId��' . $ret ['CPMenuId'] );
				$this->out_msg ( '---->shuhaiId��' . $articleid );
				$this->out_msg ( '---->�½����ƣ�' . jieqi_utf82gb ( $ret ['MenuName'] ) );
				$this->out_msg ( '---->IsVip��' . $ret ['IsVip'] );
				// ���µ����½�λ��
				if (! $article ['lastchapterid']) {
					$this->out_msg_err ( '---->�ֶ�ά��������͵��½�Id' );
					return;
				}
			} else {
				$this->out_msg ( '---->�����һ������' );
				$startupdate = true;
			}
		}
		$chapters = $this->getChapters ( $articleid );
		$totalchapter = count ( $chapters );
		for($i = 0, $order = 1, $ps = 0; $i < $totalchapter; $i ++, $order ++) {
			$c = $chapters [$i];
			if (! $startupdate) {
				// ��λ�ϴ����͵��½�
				if ($article ['lastchapterid'] != $c ['cpchapterid']) {
					continue;
				} else {
					$startupdate = true;
					if (($totalchapter - $order) > 0) {
						$this->out_msg ( '---->��' . $article ['articlename'] . '�����͵�[' . $c ['chaptername'] . '],����<b>' . ($totalchapter - $order) . '</b>ƪ��Ҫ����' );
					} else {
						$this->out_msg ( '---->���½���Ҫ���¡�' );
						return;
					}
				}
			} else {
				$ps ++; // �����½ڼ�����
				       // ��ʼ����
				if ($order == 1) {
					// ���飬��һ�¿�ʼ����
					$this->out_msg ( '---->��' . $article ['articlename'] . '����<b>' . ($totalchapter) . '</b>ƪ�½���Ҫ����' );
				}
				$data = array (
						'cpbookid' => $articleid,
						'cpmenuid' => $c ['cpchapterid'],
						'menuName' => jieqi_gb2utf8 ( $c ['chaptername'] ),
						'isvip' => $c ['isvip'],
						'content' => jieqi_gb2utf8 ( $c ['content'] )
				);
				// $responseData = addChapter($articleid, $av->getVar('chapterid'), iconv("GBK","UTF-8//IGNORE",$chaptername), 0, iconv("GBK","UTF-8//IGNORE",$content));
				if ($this->addChapter ($data)) {
					$outchapters = $article ['outchapters'] + $ps;
					$this->db->init ( 'article', 'paid', 'pooling' );
					$this->db->edit ( $article ['paid'], array (
							'lastchapterid' => $c ['cpchapterid'],
							'lastchapter' => $c ['chaptername'],
							'outchapters' => $outchapters,
							'fullflag' => $article ['full'],
							'lastdate' => JIEQI_NOW_TIME
					) );
					$this->out_msg ( '---->' . $ps . '��' . $c ['chaptername'] . '...ok' );
					if ($setting ['daychapter'] && is_numeric ( $setting ['daychapter'] ) && $setting ['daychapter'] > 0 && $setting ['daychapter'] == $ps) {
						$this->out_msg ( '---->ÿ��ֻ����' . $ps . '��' );
						break;
					}
				} else {
					$this->out_msg_err ( '---->' . $ps . '��' . $c ['chaptername'] . '����ʧ�ܣ���������������ͣ�' );
					return;
				}
				// ָ���½ڻ��ߵ�һ���½�
			}
		}
		if (! $startupdate) {
			$this->out_msg_err ( '---->δƥ��������͵��½ڣ�ͨ���½������ֶ�ά��������͵��½�ID' );
		}
	}
}
?>