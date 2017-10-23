<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iapi.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iSynchronization.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/baseApi.php');
include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * mobile���ͽӿ��࣬�̳�baseApi�����࣬ʵ��iApi�ӿ�
 * @author chengyuan  2014-7-3
 *
 */
class MyMobile extends baseApi implements iApi,iSynchronization {
	//�ƶ�ƽ̨MCP��ʶ�������ڵ�½�û���
	const MCPID = 'szcb0514';
	const HOST = '202.91.242.108';
// 	const QQ_URL = 'http://open.book.qq.com/';
// 	const USERNAME = 'shuhaihuyajie';
	const PASSWORD = 'szcb#0514$20120313289';
	const GET_LOGIN_URL = 'http://open.book.qq.com/push/login?username=shuhaihuyajie&password=shuhai2012';
	const GET_LASTUPDATE_CHAPTER = 'http://open.book.qq.com/push/getUpdateInfo';
	const ADD_BOOK_URL = 'http://open.book.qq.com/push/addBook';
	const ADD_CHAPTER_URL = 'http://open.book.qq.com/push/addChapter';
	var $msg =  array(
			'0'=>'�ƶ�ƽ̨���յ��麣�� MCPƽ̨�����ݸ���ͬ�������Ѽ��봦�����',
			'1000'=>'�����Ƿ�',
			'1001'=>'��ȫУ��ʧ��',
			'2001'=>'�Ƿ������ݱ�ʶ',
			'2002'=>'�Ƿ��ľ�˳���',
			'2003'=>'�Ƿ����½�˳���',
			'2004'=>'�½��ظ�',
			'100'=>'�����½ڳɹ����ύ���ʧ��',
			'101'=>'�½ڶ������',
			'102'=>'����������������������������',
			'103'=>'�����ظ�[����������]�������ӵľ������ͬ���ڵľ������ظ�',
			'2997'=>'XML���Ķ���ʱ',
			'2998'=>'XML���Ľ���ʧ��',
			'2999'=>'��������',
			'3999'=>'ͼ�����ڸ�����',
			'9999'=>'ϵͳ����׼���С�ע��ֻ��������׼���н׶βŻ᷵�أ�����Ѿ����������׶Σ���CP�����ʱ����Ϊ����������9999�������Ӹô�������ҪΪ�˱�֤������ʱ��Ҫ���ڴ������½�ʱ����������ݲ������ԡ�'
	);


	function __construct() {
		parent::initDB();
		$this->setKey();
	}
	/**
	 * ����qq�ܳ�
	 * @see baseApi::setKey()
	 */
	function setKey(){
	}
	function get_lastupdate($cpbid){
	}
	function addChapter($message){
	}
	function addBook($cpBid,$data){
		//�ƶ�ƽ̨��ʵ�ִ˷�����ͨ���ƶ�MCPƽ̨���飬�����ƶ���ID
	}
	function request($url, $mode, $params=array(), $header = 'Content-Type: text/plain; charset=utf-8;'){
	}
	//��ȡ��ȫ�ܳ�
	private function getSecurityid($mcpBookId){
		if(!$mcpBookId)
			$this->printfail(LANG_ERROR_PARAMETER);
		return strtoupper ( sha1 ( MyMobile::MCPID . $mcpBookId . MyMobile::PASSWORD ) );
	}
	protected  function commendBookInfoUpdate($mcpBookId,$articleId){
// 		$host = '211.140.7.155'; // <!-- host����û��д -->
// 		$securityid = strtoupper ( sha1 ( MyMobile::MCPID . $mcpBookId . MyMobile::PASSWORD ) );
		// <!-- ��ѯ�����½�-->
// 		$this->db->init ( 'article', 'articleid', 'article');
// 		$this->db->setCriteria ( new Criteria ( 's.articleid', $articleId ) );
// 		$this->db->criteria->setTables ( jieqi_dbprefix ( 'article_article' ) . "  AS a LEFT JOIN " . jieqi_dbprefix ( 'article_statamout' ) . " AS s ON a.articleid=s.articleid" );
// 		$this->db->criteria->setFields ( 'a.size,s.visit,s.vote,s.goodnum');

		$setarticle = $this->db->selectsql ('SELECT a.size,s.visit,s.vote,s.goodnum FROM '.jieqi_dbprefix ( 'article_article' ).' a left join '.jieqi_dbprefix ( 'article_statamout' ).' s on a.articleid = s.articleid where  s.articleid = '.$articleId);
		if(!$setarticle[0]){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		$size = ceil($setarticle[0]['size']/2); // <!-- ������ -->
		$allvisit = $setarticle[0]['visit'] ? $setarticle[0]['visit'] : 0; // <!-- ����� -->
		$allvote = $setarticle[0][ 'vote' ] ? $setarticle[0]['vote'] : 0;// <!-- �Ƽ��� -->
		$goodnum = $setarticle[0][ 'goodnum' ] ? $setarticle[0]['goodnum'] : 0; // <!-- �ղ��� -->
		                                        // <!-- /��ѯ�����½�-->

		$datas = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
		<commendBookInfoUpdate>\r\n
		<mcpId>".MyMobile::MCPID."</mcpId>\r\n
		<books>\r\n
		<book>\r\n
		<bookId>{$mcpBookId}</bookId>\r\n
		<wordsCount>{$size}</wordsCount>\r\n
		<stowCount>{$goodnum}</stowCount>\r\n
		<viewCount>{$allvisit}</viewCount>\r\n
		<commendCount>{$allvote}</commendCount>\r\n
		<securityId>".$this->getSecurityid($mcpBookId)."</securityId>\r\n
			</book>\r\n
			</books>\r\n
			</commendBookInfoUpdate>";
		$datas = jieqi_gb2utf8 ( $datas );
		$length = strlen ( $datas ); // ��������
		                          // <!-- ����socket���� -->
		$fp = fsockopen ( MyMobile::HOST, 80, $errno, $errstr, 30 );
		if(!$fp){
			echo "ERROR: $errno - $errstr<br />\n";
			break;
		}
		$header = "POST /CP/commendBookInfoUpdate HTTP/1.1\r\n";
		$header .= "Host:".MyMobile::HOST.":80\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: {$length}\r\n";
		$header .= "Connection: Close\r\n\r\n";
		$header .= $datas . "\r\n";
		fwrite ( $fp, $header );
		$backdata = '';
		while ( ! feof ( $fp ) ) {
			$backdata .= fgets ( $fp, 1024 );
		}
		fclose ( $fp );
		preg_match ( '/.*(close)\s*(\d*)\s*/is', $backdata, $match );
		$backinfoNo = $match [2];
		switch ($backinfoNo) {
			case 0 :
				$backinfo = "ƽ̨���յ�MCPƽ̨�ĸ�����Ϣ������ɹ�!";
				break;
			case 1000 :
				$backinfo = "�����Ƿ�";
				break;
			case 1001 :
				$backinfo = "��ȫУ��ʧ��";
				break;
			case 2999 :
				$backinfo = "��������";
				break;
		}
		$this->out_msg('---->ͬ��ͼ����Ϣ�����'.$backinfo);
// 		if ($backinfoNo == 0) {
// // 			jieqi_jumppage ( 'http://www.shuhai.com/modules/api/admin/articles.php?api=mobile', LANG_DO_SUCCESS, $backinfo );
// 		} else {
// // 			jieqi_jumppage ( 'http://www.shuhai.com/modules/api/admin/articles.php?api=mobile', '�鼮��Ϣ����ʧ�ܣ�', $backinfo );
// 		}

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
		$setting = $article ['setting'];//����
			// header('Content-Type:text/xml;');//����ʹ��
			// mobile:395908003
			// shuhai:4248
			// �½���ţ��½����ƺ��½�id�ű����޸�
			// $host = '211.140.7.155';
			// $host = '211.140.7.155'; //(����ƽ̨)**
			// $host = '211.140.17.94'; //(�ƶ�����)**
			// $host = '202.91.242.108'; // (���Ż���)**
			// $mcpid = "szcb0514";
			// $bookId = $_POST ['bookMobileId']; // <!-- �鼮�ƶ�ƽ̨ID-->
			// $bookShuhaiId = $_POST ['bookShuhaiId'];
			// 370250019 317
			// $again = 0;//��һ�γ���
		if (! $article ['apiId']) {
			$this->out_msg_err ( '---->��ά����' . $article ['articlename'] . '���ƶ�MCP�ϵ�ID' );
		} else {
			$articleLib = $this->load ( 'article', 'article' );
			$articleLib->instantPackage ( $article ['articleid'] );
			$bookShuhaiId = $article ['articleid'];
			$bookId = $article ['apiId']; // <!-- �鼮�ƶ�ƽ̨ID-->
			$securityid = $this->getSecurityid ( $bookId );




			// <!-- ��ȡͼ����Ϣ-->
// 			$header = "GET /CP/queryContent?mcpid=" . MyMobile::MCPID . "&bookid=$bookId&securityid=$securityid HTTP/1.1\r\n";
// 			$header .= "Host: " . MyMobile::HOST . ":80\r\n";
// 			$header .= "Connection: keep-alive\r\n\r\n";
// 			$fp = fsockopen ( MyMobile::HOST, 80, $errno, $errstr, 30 );
// 			fwrite ( $fp, $header );
// 			$backdata = '';
// 			while ( ! feof ( $fp ) ) {
// 				$backdata .= fgets ( $fp, 128 );
// 			}
// 			fclose ( $fp );



			$backdata = $this->fsockPost("/CP/queryContent?mcpid=" . MyMobile::MCPID . "&bookid=$bookId&securityid=$securityid", MyMobile::HOST);






			$backdata = jieqi_utf82gb ( $backdata );
			// <!-- ����ͼ����Ϣ-->
			preg_match ( "/(.+)\<bookId\>(.+)\<\/bookId\>/isU", $backdata, $matches );
			$bookId = $matches [2]; // �ֻ��Ķ�ƽ̨�鼮ID

			preg_match ( "/(.+)\<chapterId\>(.+)\<\/chapterId\>/isU", $backdata, $matches );
			$mcp_chapterId = $matches [2]; // �����½�ID
			preg_match ( "/(.+)\<chapterIdx\>(.+)\<\/chapterIdx\>/isU", $backdata, $matches );
			$chapterIdx = $matches [2]; // �����½�˳���
			preg_match ( "/(.+)\<name\>(.*?)\<\/name\>/isU", $backdata, $matches );
			$name = $matches [2]; // �����½�����
			preg_match ( "/(.+)\<volumeIdx\>(.+)\<\/volumeIdx\>/isU", $backdata, $matches );
			$volumeIdx = $matches [2]; // ���¾����
			preg_match ( "/(.+)\<volumeName\>(.+)\<\/volumeName\>/isU", $backdata, $matches );
			$volumeName = $matches [2]; // ���¾�����

			$this->out_msg ( "---->��" . $article ['articlename'] . "���ϴ����ͼ�¼" );
			$this->out_msg ( "---->MCPID=>{$bookId}" );
			$this->out_msg ( "---->�����=>{$volumeIdx}" );
			$this->out_msg ( "---->������=>{$volumeName}" );
			$this->out_msg ( "---->�½�ID=>{$mcp_chapterId}" );
			$this->out_msg ( "---->�½����=>{$chapterIdx}" );
			$this->out_msg ( "---->�½�����=>" . $name );
			if (! $name || ! $chapterIdx || ! $bookId) {
				$this->out_msg_err ( '---->MCPƽ̨������Ч����,MCPID='.$article ['apiId'].'������ϸ�˶�MCPID' );
			} elseif (! $article ['lastchapterid']) {
				$this->out_msg_err ( '---->��ά����' . $article ['articlename'] . '����������͵��½�ID' );
			} else {
				// ��ȡ���ݳ����������½� jieqi_pooling_chapter
				$this->db->init ( 'chapter', 'pcid', 'pooling' );
				$this->db->setCriteria ( new Criteria ( 'paid', $article ['paid'] ) );
				$this->db->criteria->add ( new Criteria ( 'channelid', $channleid ) );
				// $this->db->criteria->add ( new Criteria ( 'chaptertype', 0 ) );//�½�
				$this->db->criteria->setSort ( 'chapterorder' );
				$this->db->criteria->setOrder ( 'ASC' );
				$this->db->queryObjects ();
				$chapters = array ();
				$av = $i = $k = $pc = 0;
				while ( $chapter = $this->db->getObject ()) {
					if ($chapter->getVar ( 'chaptertype' ) == 1) {
						// �ܾ���
						$av ++;
					}
// 					$txtpath = $articleLib->getDir ( 'txtdir', true, false ) . '/' . $chapter->getVar ( 'chapterid' ) . '.txt';
					$chapters [$i] = array (
							'isvip' => $chapter->getVar ( 'isvip' ),
							'cpchapterid' => $chapter->getVar ( 'pcid' ),
							'lastupdate' => $chapter->getVar ( 'adddate' ),
							'chaptertype' => $chapter->getVar ( 'chaptertype' ),
							'chaptername' => $chapter->getVar ( 'chaptername', 'n' ),
							'content' => $chapter->getVar ( 'content', 'n' )
// 							'content' => @jieqi_readfile ( $txtpath )
					);
					$i ++;
				}
				$totalchapter = count ( $chapters ) - $av; // ���½���
				                                           // ��λ�ϴ����͵��½�λ��
				if (! $article ['lastchapterid'])
					$startupdate = true;
				else
					$startupdate = false; // ��ʼ�����±��
						                      // ������һ�½�ֵmcpƽ̨
				$lastvolumeid = 0;
				$lastvolume = '';
				foreach ( $chapters as $c ) {
					if ($c ['chaptertype'] == 1) { // ��¼�����½����ڵľ�
						$lastvolumeid = $c ['cpchapterid'];
						$lastvolume = $c ['chaptername'];
						continue;
					}
					$fullflag = 0;
					$k ++;
					if (! $startupdate) {
						// ��λ����λ��
						if ($article ['lastchapterid'] != $c ['cpchapterid']) {
							continue;
						} else {
							$startupdate = true;
							if (($totalchapter - $k) > 0) {
								$this->out_msg ( '---->��' . $article ['articlename'] . '���ϴθ��µ�[' . $name . '],����<b>' . ($totalchapter - $k) . '</b>ƪ��Ҫ����' );
							} else {
								$this->out_msg ( '---->���½���Ҫ����!' );
							}
						}
					} else {
						$chapterIdx = $chapterIdx + 1;
						// ��֯��������
						$securityid = strtoupper ( sha1 ( MyMobile::MCPID . $bookId . $c ['cpchapterid'] . 'true' . MyMobile::PASSWORD ) );
						$isFree = $c ['isvip'] == 0 ? 1 : 0; // mcpƽ̨ 1���
						$updateTime = date ( "Y-m-d H:i:s", $c ['lastupdate'] );
						// �����ƶ�������Ϣ�ȶ�
						if ($lastvolume && $volumeName && $lastvolume != $volumeName) {
							$volumeIdx = $volumeIdx + 1;
							$volumeName = $lastvolume;
						}
						$datas = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n
						<AddNewChapter>\r\n
							<mcpId>" . MyMobile::MCPID . "</mcpId>\r\n
											<bookId>{$bookId}</bookId>\r\n
											<submit>true</submit>\r\n
											<securityId>{$securityid}</securityId>\r\n
											<ChapterInfo>\r\n
											<volumeIdx>{$volumeIdx}</volumeIdx>\r\n
											<volumeName>{$volumeName}</volumeName>\r\n
											<chapterIdx>{$chapterIdx}</chapterIdx>\r\n
											<chapterId>{$c['cpchapterid']}</chapterId>\r\n
													<chapterName>" . $this->safeStrXml ( $c ['chaptername'] ) . "</chapterName>\r\n
													<isFree>{$isFree}</isFree>\r\n
													<updateTime>{$updateTime}</updateTime>\r\n
													<content><![CDATA[{$c['content']}]]></content>\r\n
													</ChapterInfo>\r\n
													</AddNewChapter>";
						$datas = jieqi_gb2utf8 ( $datas );
// 						$length = strlen ( $datas ); // ��������
// 						$header = "POST /CP/addNewChapter HTTP/1.1\r\n";
// 						$header .= "Host:" . MyMobile::HOST . ":80\r\n";
// 						$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
// 						$header .= "Content-Length: {$length}\r\n";
// 						$header .= "Connection: Close\r\n\r\n";
// 						$header .= $datas . "\r\n";
// 						unset ( $fp );
// 						$fp = fsockopen ( MyMobile::HOST, 80, $errno, $errstr, 30 );
// 						fwrite ( $fp, $header );
// 						$backdata = '';
// 						while ( ! feof ( $fp ) ) {
// 							$backdata .= fgets ( $fp, 1024 );
// 						}
// 						fclose ( $fp );


						$backdata = $this->fsockPost("/CP/addNewChapter", MyMobile::HOST,$datas);
						
						





						preg_match ( '/appendinfo:(.*)Content-Type/is', $backdata, $match );
						$appendinfo = $match [1];
						
						// echo jieqi_utf82gb(urldecode ( $appendinfo ));
						preg_match ( '/Connection: close(.*)/is', $backdata, $match );
						$lastline = $match [1];
						preg_match ( '/\s*(\d*)\s*(\d*)\s*(\d*)\s*/is', $lastline, $match );
						$backinfono = $match [2];
						if(is_numeric($backinfono)){
							if ($backinfono == 0 || $backinfono == 100) {
								$pc ++; // ���͵��½���
								$this->out_msg ( '---->' . $c ['chaptername'] . '...���ͳɹ�' );
								// ͬ�����ݳص������µ�
								$article ['lastvolumeid'] = $lastvolumeid;
								$article ['lastvolume'] = $lastvolume;
								$article ['lastchapterid'] = $c ['cpchapterid'];
								$article ['lastchapter'] = $c ['chaptername'];
								$article ['outchapters'] = $k;
								$article ['fullflag'] = $article ['full'];
								$article ['lastdate'] = JIEQI_NOW_TIME; // ����ʱ��
								$article ['setting'] = $this->arrayeval ( $setting );
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
									$this->out_msg_err ( '---->���ݳ����¡�' . $article ['articlename'] . '����״̬ͬ��ʧ�ܣ�' );
								}
								if ($setting ['daychapter'] && is_numeric ( $setting ['daychapter'] ) && $setting ['daychapter'] > 0 && $setting ['daychapter'] == $pc) {
									$this->out_msg ( '---->ÿ��ֻ����' . $pc . '��' );
									break;
								}
							} else {
								// ͬ������ɹ����ؼ�����ֵΪ0 or 100���ٷ�����һ�£�������ͣ�������������½ڣ����������ų����ٽ���ͬ����һ�£���ֹ�½ڴ��ң�ȱ�¡��ظ��ȣ�
								$this->out_msg_err ( '---->' . $c ['chaptername'] . '->����ʧ�ܡ�' . $this->msg [$backinfono] );
								$this->out_msg_err ( '---->ԭ��' . $this->msg [$backinfono] );
								break;
								// if($again == 0){
								// $a--;//again
								// $this->out_msg ( '�ٴ�����һ��...');
								// $again == 1;
								// }else{
								// $again == 0;
								// break;//��һ����
								// }
							}
						}else{
							$this->out_msg_err ( '---->ԭ��'.jieqi_utf82gb(urldecode($appendinfo)) );
							break;
						}
					}
				}
				if (! $startupdate) {
					$this->out_msg_err ( '---->δƥ��������͵��½ڣ��ֶ�ά��������͵��½�ID' );
				}
				$this->out_msg ( '---->��ʼͬ��ͼ����Ϣ:���������ղ�������������Ƽ���' );
				$this->commendBookInfoUpdate ( $bookId, $bookShuhaiId );
			}
		}
	}
	
	function handlePoolChapter(&$poolChapter){
		if($poolChapter && $poolChapter['chaptername'] && $poolChapter['content']){
			//�ƶ�apiȥ���½��ڵ��½�����
			$tmp = '    '.$poolChapter['chaptername'];
			if(substr($poolChapter['content'],0,strlen($tmp)) ==  $tmp){//��һ�����½�����
				$poolChapter['content'] = substr($poolChapter['content'],strlen($tmp.PHP_EOL));//������
			}
		}
	}
}
?>