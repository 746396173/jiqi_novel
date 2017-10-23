<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iapi.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/baseApi.php');
include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
class MyQq extends baseApi implements iApi {
	const GET_LOGIN_URL = 'http://open.book.qq.com/push/login';
	const GET_LASTUPDATE_CHAPTER = 'http://open.book.qq.com/push/getUpdateInfo';
	const ADD_BOOK_URL = 'http://open.book.qq.com/push/addBook';
	const ADD_CHAPTER_URL = 'http://open.book.qq.com/push/addChapter';
	function __construct() {
		parent::initDB();
		$this->setKey();
	}
	/**
	 * ��ȡ��ýCPID
	 * <p>
	 * 130053
	 * @return string
	 */
	protected function getCPID(){
		return "130053";
	}
	protected function getUsername(){
		return "shuhaihuyajie";
	}
	protected function getPassword(){
		return "chuanmeiqq2015";
	}
	/**
	 * ����qq�ܳ�
	 * @see baseApi::setKey()
	 */
	function setKey(){
		$this->KEY = $this->login();
	}
	/**
	 * ��½��ȡͨ��key
	 * @return boolean
	 * 2014-7-2 ����10:10:22
	 */
	private function login(){
		$url = MyQq::GET_LOGIN_URL.'?username='.$this->getUsername().'&password='.$this->getPassword();
		if($ret = $this->request($url, 'GET')){ //��½
			$ret = json_decode($ret);
			if($ret->code=='0'){//ִ�гɹ�
				return $ret->result->key;
			}else{
				$this->outMessage('---->��½������ˢ�����ԣ������ţ�'.$ret->code);exit;
				return false;
			}
		}else{
			$this->outMessage();
			return false;
		}
	}
	function outMessage($message = '�������'){
		echo $message.'<br>';
	}

	function get_lastupdate($cpbid){
		$url=MyQq::GET_LASTUPDATE_CHAPTER.'?key='.$this->KEY.'&b.cpid='.$this->getCPID().'&b.cpBid='.$cpbid;//exit($url);
		if($ret = $this->request($url,'GET')) { //echo($url.$ret);exit;
			$ret = json_decode($ret);
			if($ret->code=='-52')  return array('bookid'=>0,'cpcid'=>0,'chapterid'=>0);
			if($ret->code=='0'){//ִ�гɹ�
				return array('bookid'=>$ret->result->bookid,'cpcid'=>$ret->result->cpcid,'chapterid'=>$ret->result->chapterid,'chaptername'=>jieqi_utf82gb($ret->result->chaptername));
			}else{
				$this->outMessage('---->ȡ������Ϣ���������ţ�'.$ret->code);
				return false;
			}
		}else{
			$this->outMessage('---->ȡ������Ϣ����');
			return false;
		}
	}
	function addChapter($message){
		include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/SingleFileSender.php');
		$sfs=new SingleFileSender(MyQq::ADD_CHAPTER_URL);
		if($ret = $sfs->post($message,false)) { //echo $ret.'====<br>';
			$ret = '{"'.$this->get_str($ret,'{"','}').'}';//echo $ret;
			$ret = json_decode($ret);
			if($ret->code=='0'){//ִ�гɹ�
				//$this->KEY = $this->login();
				return true;
			}elseif($ret->code=='5'){
				$this->outMessage('---->�ظ��½ڣ�������');
				return true;
			}else{
				$this->outMessage('---->���½ڳ��������ţ�'.$ret->code);
				return false;
			}
		}else{
			$this->outMessage('---->���½ڳ���');
			return false;
		}
	}
	private function get_str($str,$start_str,$end_str){
		$this->str = $str;
		$this->start_str = $start_str;
		$this->end_str = $end_str;
		$this->start_pos = strpos($this->str,$this->start_str)+strlen($this->start_str);
		$this->end_pos = strpos($this->str,$this->end_str);
		$this->c_str_l = $this->end_pos - $this->start_pos;
		$this->contents = substr($this->str,$this->start_pos,$this->c_str_l);
		return $this->contents;
	}
	function addBook($cpBid,$data){//���͵�����
		if($C = $this->get_lastupdate($cpBid)){//print_r($C);exit;
			if($C['bookid']) return $C;//���͹�
			//������
			include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/SingleFileSender.php');
			$sfs=new SingleFileSender(MyQq::ADD_BOOK_URL);
			if($ret = $sfs->post($data,true) ){
				$ret = '{"'.$this->get_str($ret,'{"','}}').'}}';
				$ret = json_decode($ret);
				if($ret->code=='0'){//ִ�гɹ�
					//return $ret->result->bookid;
					return array('bookid'=>$ret->result->bookid,'cpcid'=>0,'chapterid'=>0,'chaptername'=>'');
				}else{
					$this->outMessage('---->������������ţ�'.$ret->code);
					return false;
				}
			}else{
				$this->outMessage('---->�������');
				return false;
			}
		}else{
			return false;
		}
	}

	function request($url, $mode, $params=array(), $header = 'Content-Type: text/plain; charset=utf-8;'){
		if($params) $this->arrayRecursive($params, 'urlencode', true);
		$curlHandle = curl_init();
		curl_setopt($curlHandle, CURLOPT_TIMEOUT,  30);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

		if($mode=='POST'){
			curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array($header));
			curl_setopt($curlHandle, CURLOPT_POST, true);
			curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));
		}else{
			$url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
		}

		curl_setopt($curlHandle, CURLOPT_URL, $url);
		if(substr($url, 0, 5) == 'https'){
			curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, false);
		}

		$result = curl_exec($curlHandle);

		curl_close($curlHandle);
		return $result;
	}
	/**
	 * QQ����
	 * <br>ʵ��iapi�ӿ��ж�������ͷ���
	 *
	 * @param unknown $channleid
	 * @param unknown $paid
	 *        	2014-7-1 ����8:58:18
	 */
	function push($channleid, $article) {
		$articleLib = $this->load ( 'article', 'article' );
		$articleLib->instantPackage ( $article ['articleid'] );
// 		$setting = array ();
		$_OBJ ['outapi'] = $this->load ( 'channel', 'pooling' );
		$_SGLOBAL ['outapi'] = $_OBJ ['outapi']->get ( $channleid );
		$fullflag = $i = $k = $kk = 0;
		$chapters = array ();
// 		$setting = array ();
		// ��������
// 		if ($article ['setting']) {
// 			eval ( '$article[\'setting\'] = ' . $article ['setting'] . ';' ); // �����������
// 			$setting = $article ['setting'];
// 		} else
// 			$setting = $_SGLOBAL ['outapi'] ['setting'];
			// �������ý���
		if ($article ['keywords']) { // ����ؼ���,ȡ5��
			$article ['keywords'] = explode ( ' ', $article ['keywords'] );
			$ak = 0;
			$keys = array ();
			foreach ( $article ['keywords'] as $key ) {
				$key = trim ( $key );
				if (! $key)
					continue;
				if ($ak < 5) {
					$keys [$ak] = $key;
				}
				$ak ++;
			}
			$article ['keywords'] = implode ( ',', $keys );
		}
		$setarticle = $this->db->selectsql ( 'select * from ' . jieqi_dbprefix ( "pooling_article" ) . " where channelid=" . $channleid . " and articleid=" . $article ['articleid'] );
		if(!$setarticle [0] ['image']){
			$this->out_msg_err ( '---->����ӷ��棨��' );
			return;
		}
		/*
		 * $message = array( 'title' => $article['articlename'], 'author' => $article['author'], 'cpbid' => $article['articleid'], 'intro' => $article['intro'], 'category' => $article['sortid'], 'finished' => $article['fullflag'] ? 1 :0, 'sex' => 1, 'keyword' => $article['keywords'] ? $article['keywords'] : $article['author'], 'tag' => $article['keywords'] ? $article['keywords'] : $article['author'] //'cover' => jieqi_geturl('article', 'cover', $v['articleid'], 's', $v['imgflag']) );
		 */
		$this->db->init ( 'chapter', 'chapterid', 'article' );
		$this->db->setCriteria ( new Criteria ( 'articleid', $article ['articleid'] ) );
		$this->db->criteria->setFields ( 'chapterid,chaptername,lastupdate' );
		$this->db->criteria->add ( new Criteria ( 'display', 0, '=' ) );
		$this->db->criteria->add ( new Criteria ( 'isvip', 0 ) ); // ��ѵ�
		$this->db->criteria->add ( new Criteria ( 'chaptertype', 0 ) );
		$this->db->criteria->setSort ( 'chapterorder' );
		$this->db->criteria->setOrder ( 'ASC' );
		$maxFreeChapter = $this->db->getCount ( $this->db->criteria ); // ;exit;

		$fileName = JIEQI_ROOT_PATH . "/api/api_image" . $setarticle [0] ['image'];
		$handle = @fopen ( $fileName, "r" );
		$file = fread ( $handle, filesize ( $fileName ) );
		fclose ( $handle );
		$message = array (
				array (
						"postName" => "b.cover",
						"fileName" => $fileName,
						"file" => $file,
						"type" => "image/pjpeg"
				),
				array (
						"name" => "key",
						"value" => $this->KEY
				),
				array (
						"name" => "b.cpid",
						"value" => $this->getCPID()
				),
				array (
						"name" => "b.cpBid",
						"value" => $article ['articleid']
				),
				array (
						"name" => "b.title",
						"value" => jieqi_gb2utf8 ( $article ['articlename'] )
				),
				array (
						"name" => "b.author",
						"value" => jieqi_gb2utf8 ( $article ['author'] )
				),
				array (
						"name" => "b.finish",
						"value" => $article ['fullflag'] ? 1 : 0
				),
				array (
						"name" => "b.intro",
						"value" => jieqi_gb2utf8 ( $article ['intro'] )
				),
				array (
						"name" => "b.form",
						"value" => "0"
				),
				array (
						"name" => "b.free",
						"value" => "0"
				),
				array (
						"name" => "b.language",
						"value" => "0"
				),
				array (
						"name" => "b.category",
						"value" => ""
				),
				array (
						"name" => "b.maxFreeChapter",
						"value" => $maxFreeChapter
				),
				array (
						"name" => "b.tag",
						"value" => ""
				)
		);
		if (! $retArticle = $this->addBook ( $article ['articleid'], $message )) {
			$msg = '---->��API���͡�' . $article ['articlename'] . '��ʱ�����������飡';
			$this->out_msg_err ( $msg );
			return ;
		} else { // �����½ڿ�ʼ
			$startupdate = false;//��ʼ���ͱ�ʶ
			if($retArticle['cpcid'] === 0 && $retArticle['chapterid'] === 0 && $retArticle['chaptername'] === ''){
				$this->out_msg ( '---->�����һ������' );
				$startupdate = true;
			}else{
				$this->out_msg ( '---->�ϴ�������Ϣ��' );
				$this->out_msg ( '---->�½�ID��' . $retArticle['chapterid'] );
				$this->out_msg ( '---->�½����ƣ�' .  $retArticle['chaptername']);
				// ���µ����½�λ��
				$cpcid = $setarticle [0] ['lastchapterid'];
				if (!$cpcid) {
					$this->out_msg_err ( '---->�ֶ�ά��������͵��½�Id' );
					return;
				}
			}
			//
// 			if($C['bookid']) return $C;
			//$C['bookid']=0
// 			if (! $cpcid && $retArticle->cpcid && $retArticle->cpcid != $setarticle [0] ['lastchapterid']) {
// 				$cpcid = $retArticle->result->chapterid;
// 			}
			$this->db->setCriteria ( new Criteria ( 'articleid', $article ['articleid'] ) );
			$this->db->criteria->add ( new Criteria ( 'display', 0, '=' ) );
			$this->db->criteria->add ( new Criteria ( 'chaptertype', 0 ) );
			$this->db->criteria->setSort ( 'chapterorder' );
			$this->db->criteria->setOrder ( 'ASC' );
			$this->db->queryObjects ();
			while ( $chapter = $this->db->getObject () ) {
				$txtpath = $articleLib->getDir ( 'txtdir', true, false ) . '/' . $chapter->getVar ( 'chapterid' ) . '.txt';
				// echo @jieqi_readfile($txtpath);exit;
				$chapters [$i] = array (
						// 'bopid' => $retArticle->bopid,
						// 'chapterid' => $i+1,
						'isvip' => $chapter->getVar ( 'isvip' ),
						'cpchapterid' => $chapter->getVar ( 'chapterid' ),
						'chaptername' => jieqi_gb2utf8 ( $chapter->getVar ( 'chaptername', 'n' ) ),
						'content' => jieqi_gb2utf8 ( @jieqi_readfile ( $txtpath ) )
				);
				$i ++;
			}
		}
		$totalchapter = count ( $chapters );
		// ��ʼ������
		 // ��ʼ�����±��
		foreach ( $chapters as $c ) {
			$fullflag = 0;
			$k ++;
			if (! $retArticle ['cpcid'] && $retArticle ['chapterid']) {
				if ($k <= $retArticle ['chapterid'])
					continue;
			}
			if (! $startupdate) { // Ѱ���ϴθ��µ��½�λ��
				if ($cpcid != $c ['cpchapterid']) {
					continue;
				} else {
					$startupdate = true;
					if (($totalchapter - $k) > 0) {
						$this->out_msg ( '---->��' . $article ['articlename'] . '�����µ�[' . jieqi_utf82gb ( $c ['chaptername'] ) . '],����<b>' . ($totalchapter - $k) . '</b>ƪ��Ҫ����' );
					} else{
						$this->out_msg ( '---->���½���Ҫ����!' );
						return;
					}
				}
			} else { // ��ʼ�����½�
				if ($k == 1) {
					$this->out_msg( '---->��' . $article ['articlename'] . '����<b>' . ($totalchapter) . '</b>ƪ�½���Ҫ����');
				}
				// ���Ƹ����½�
				// if ($setting ['open']) {
				// if ($setting ['data'] != 'allchapter') {
				// // �ո����½���
				// if (date ( 'Ymd', $article ['lastupdate'] ) == date ( 'Ymd', time () ) && $article ['daychapters'] > 0) { // ��ǰ�и���
				// $daychapters = $article ['daychapters'] + $kk + 1;
				// } else {
				// $daychapters = $kk + 1;
				// }
				// if ($setting ['daychapter'] > 0 && $daychapters > $setting ['daychapter']) {
				// out_msg ( '<font color=red>����ֹͣ��ϵͳ����ÿ�����Ƹ���' . $setting ['daychapter'] . '��</font>' );
				// break;
				// }
				// } else {
				$daychapters = $kk + 1;
				// }
				// // ���վ��������
				// if ($setting ['sleepchapter'] > 0) {
				// if (($totalchapter - $k) < $setting ['sleepchapter'] && ! $article ['full']) {
				// out_msg ( '<font color=red>����ֹͣ��ϵͳ����ʼ�����վ' . $setting ['sleepchapter'] . '��</font>' );
				// break;
				// }
				// }
				// }
				// $chapterid++;
				// $c['chapterid'] = $chapterid;
				$message = array (
						array (
								"name" => "key",
								"value" => $this->KEY
						),
						array (
								"name" => "c.cpid",
								"value" => $this->getCPID()
						),
						array (
								"name" => "c.bookid",
								"value" => $retArticle ['bookid']
						),
						array (
								"name" => "c.cpcid",
								"value" => $c ['cpchapterid']
						),
						array (
								"name" => "c.title",
								"value" => $c ['chaptername']
						),
						array (
								"name" => "c.content",
								"value" => $c ['content']
						)
				);
				if ($this->addChapter ( $message )) {
					$kk ++;
					$lastchapterid = $c ['cpchapterid'];
					$lastchapter = $c ['chaptername'];
					if ($article ['full'] && $chapters [$totalchapter - 1] ['cpchapterid'] == $c ['cpchapterid'])
						$fullflag = 1;

						// if(!$retArticle->chapterid) $postdate = time();
						// else $postdate = $article['postdate'];
						// $postdate = $article['postdate'];
					$lastupdate = time ();
					// if(!$lastchapterid) $lastchapterid = $article['lastchapterid'];
					// if(!$lastchapter) $lastchapter = $article['lastchapter'];
					// if(!$fullflag) $fullflag = $article['fullflag'];
					if (! $kk)
						$outchapters = $article ['outchapters'];
					else
						$outchapters = $article ['outchapters'] + $kk;
						// /echo $setarticle[0]['id'];
					$this->db->init ( 'article', 'paid', 'pooling' );
					$this->db->edit ( $setarticle [0] ['paid'], array (
							'lastchapterid' => $lastchapterid,
							'lastchapter' => jieqi_utf82gb ( $lastchapter ),
							// 'daychapters' => $daychapters,
							'outchapters' => $outchapters,
							'fullflag' => $fullflag,
							// 'adddate' => $postdate,
							'lastdate' => $lastupdate
					) );

					$this->out_msg ( '---->'.$kk . '��' . jieqi_utf82gb ( $c ['chaptername'] ) . '...ok' );
					if($article ['setting']['daychapter']
					&& is_numeric($article ['setting']['daychapter'])
					&& $article ['setting']['daychapter'] > 0
					&& $article ['setting']['daychapter'] == $kk){
						$this->out_msg ('---->ÿ��ֻ����'.$kk.'��' );
						break;
					}
				} else {
					$kk ++;
					$this->out_msg_err ( '---->'.$kk . '��' . jieqi_utf82gb ( $c ['chaptername'] ) . '����ʧ�ܣ���������������£�' );
					return ;
				}
				// echo ($totalchapter-$k+1).'-'.count($chapters);exit;
			}
		}
		$this->db->init ( 'article', 'paid', 'pooling' );
		if (! $kk && $article ['articleid']) { // �������û�и���һ���½�
			$this->db->edit ( $setarticle [0] ['paid'], array (
					'postdate' => time ()
			) );
		}
		if (! $startupdate) {
			$this->out_msg_err ( '---->δƥ��������͵��½ڣ�ͨ���½������ֶ�ά��������͵��½�ID' );
		}
		$daychapters = 0;
		$lastchapterid = $lastchapter = '';
	}
}
?>