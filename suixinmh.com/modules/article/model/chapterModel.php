<?php
/**
 * �½�ģ��
 * @author chengyuan  2014-4-4
 *
 */
class chapterModel extends Model{
		/**
		 * �Զ��½�ǰ׺��ʱ������
		 * @var unknown
		 */
		public $auto_chatper_prefix_timestamp = 1430366400;
		/**
		 * �½ڡ���༭��ͼ
		 * @param  $cId		�½�ID
		 * @return $data	form string
		 */
		function editChapterView($param){
			//�����Զ�����
			$articleLib =  $this->load('article',false);
			$data = $articleLib->getSources ();
			$data['article'] = $articleLib->isExists($param['aid']);
			$articleLib->canedit($data['article']);//�˴���֤Ȩ��
			$this->db->init('chapter','chapterid','article');
			if(!$data['chapter'] = $this->getFormat($this->db->get($param['cid']),'e')){
			    if($param['chaptertype']==1) $typename=$articleLib->jieqiLang['article']['volume_name'];
				else $typename=$articleLib->jieqiLang['article']['chapter_name'];
				$this->printfail(sprintf($articleLib->jieqiLang['article']['chapter_volume_notexists'], $typename));
			}
			if($data['chapter']['chaptertype'] == 0){
				$data['wordsperegold'] = $articleLib->jieqiConfigs['article']['wordsperegold'];
				//�½�
				$data['authtypeset'] = $articleLib->jieqiConfigs['article']['authtypeset'];
				$articleLib->instantPackage ( $param['aid'] );
				$data['chapter']['context']= $articleLib->getContent ( $param['cid'], ENT_QUOTES );
				//�Զ���۸��Ȩ��
				if($this->checkpower($articleLib->jieqiPower['article']['customprice'], $this->getUsersStatus (), $this->getUsersGroup (), true)){
					$data['article']['customprice'] = 1;
				}
				//��������
				$data['maxfilenum'] = 0;
				$canupload = $this->checkpower($articleLib->jieqiPower['article']['articleupattach'], $this->getUsersStatus(), $this->getUsersGroup(), true);
				if($canupload && is_numeric($articleLib->jieqiConfigs['article']['maxattachnum']) && $articleLib->jieqiConfigs['article']['maxattachnum']>0){
					$data['maxfilenum'] = $articleLib->jieqiConfigs['article']['maxattachnum'];
				}
				//���ϴ��ĸ���
				$tmpvar = $data['chapter']['attachment'];
				$attachnum = 0;
				if (! empty ( $tmpvar )) {
					$attachary = unserialize ( htmlspecialchars_decode($tmpvar) );//print_r($attachary);
					if (! is_array ( $attachary ))
						$attachary = array ();
					$attachnum = count ( $attachary );
					if ($attachnum > 0) {
						$data['chapter']['attachary'] = $attachary;
					}
				}
				//����½����ƺ�ǰ׺
				/*if($data['article']['postdate'] >= $this->auto_chatper_prefix_timestamp){
					if(mb_strpos($data['chapter']['chaptername'], ' ')){
						$space_index = strpos($data['chapter']['chaptername'], ' ');
						$data['chapter']['chaptername_prefix']=array(substr($data['chapter']['chaptername'],0,$space_index));
						$data['chapter']['chaptername']=substr($data['chapter']['chaptername'],$space_index+1);
					}else{
						$data['chapter']['chaptername_prefix'] = "";
					}
				}*/
			}
			return $data;
		}
		/**
		 * �޸��½�
		 */
		function editChapter($param){
			//�����½�
			$articleLib =  $this->load('article','article');
			$article = $articleLib->isExists($param['aid']);
			$articleLib->canedit($article);
			$this->db->init('chapter','chapterid','article');
			if(!$chapter = $this->db->get($param['cid'])){
			    if($param['chaptertype']==1) $typename=$articleLib->jieqiLang['article']['volume_name'];
				else $typename=$articleLib->jieqiLang['article']['chapter_name'];
				$this->printfail(sprintf($articleLib->jieqiLang['article']['chapter_volume_notexists'], $typename));
			}
			//�������������ֻ���޸Ķ�Сʱ�ڵ�����
			$auth = $this->getAuth();
			if($article['authorid']==$auth['uid']){
			    $canedittime = 7200;
			    if(JIEQI_NOW_TIME-$chapter['postdate']>$canedittime && (!$chapter['display'] || $chapter['display']==2)){
				     $this->printfail(sprintf($articleLib->jieqiLang['article']['chapter_2hours_edit'], $canedittime/3600));
				}
			}
			
			$data = array();
			//$param['chaptername'] = $param['chaptername_prefix'].' '.$param['chaptername'];
			$data['chaptername'] = trim($param['chaptername']);
			$data['oldattach'] = $param['oldattach'];
			$data['isvip'] = $param['isvip'];
			$data['saleprice'] = $param['saleprice'];
			$data['manual'] = $param['manual'];
			$data['fullflag'] = $param['fullflag'];
			$data['chaptertype'] = 0;//1=>volume 0=>chapter
			$data['chaptercontent'] = trim($param['chaptercontent']);
			$data['articleid'] = $param['aid'];
			$data['chapterid'] = $param['cid'];
			if(isset($param['postdate'])) $data['postdate'] = $param['postdate'];
			$data['typeset'] = $param['typeset'];
			$data['attachfile'] = $_FILES['attachfile'];
			$data =  $articleLib->updateChapter($article,$data);
			$this->jumppage ( $this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid=' . $param['aid'] ), LANG_DO_SUCCESS, $articleLib->jieqiLang ['article'] ['chapter_edit_success'] );
		}
		/**
		 * �����½�����
		 */
		function saveChapter($param){
		    $this->addConfig('article','power');
		    $jieqiPower['article'] = $this->getConfig('article','power');
			$power = $this->checkpower($jieqiPower['article']['manageallarticle'], $this->getUsersStatus(), $this->getUsersGroup(), true );
			$ip = $this->getIp();
			if(empty($power) && $ip != '113.140.9.50'){//û�й�����������Ȩ�ޣ���Ҫ��֤��
				//�����֤��
				if(empty($param['checkcode']) || strtolower($param['checkcode']) != $_SESSION['jieqiCheckCode']){
					$this->addLang('system', 'users');
					$jieqiLang['system'] = $this->getLang('system');
					$this->printfail($jieqiLang['system']['error_checkcode']);
				}
			}
			$articleLib =  $this->load('article','article');
			$article = $articleLib->isExists($param['aid']);
			$articleLib->canedit($article);
			$data = array();
			$data['articleid'] = $param['aid'];
			$data['chaptertype'] = 0;//0=chapter 1=volume
			//$param['chaptername'] = $param['chaptername_prefix'].' '.$param['chaptername'];
			$data['chaptername'] = trim($param['chaptername']);
			$data['manual'] = trim($param['manual']);//�շ��½ڵ����⻰
			$data['fullflag'] = $param['fullflag'];
			$data['typeset'] = trim($param['typeset']);
			$data['isvip'] = trim($param['isvip']);
			$data['saleprice'] = trim($param['saleprice']);
			$data['postdate'] = trim($param['postdate']);
			$data['chaptercontent'] = trim($param['chaptercontent']);
			//��ID������һ���߼�ID��������ʵ��chapterid
			$data['volumeid'] = trim($param['volumeid']);
			//��������
			$data['attachfile'] = $_FILES['attachfile'];
			return $articleLib->saveChapter($data);
		}
		/**
		 * �ڶ������ϴ�������ͼ
		 * @param unknown $param
		 */
		function set2View($param){
			header('Content-Type:text/html;charset=gbk');//����ˢ��ʱ��������
			$data = array();
			$articleLib =  $this->load('article',false);
			$article = $articleLib->isExists($param['aid']);
			$canupload = $this->checkpower($articleLib->jieqiPower['article']['articleupattach'], $this->getUsersStatus(), $this->getUsersGroup(), true);
			$data['article'] = $article;
			$data['authtypeset'] = $articleLib->jieqiConfigs['article']['authtypeset'];
			//��������
			if($canupload && is_numeric($articleLib->jieqiConfigs['article']['maxattachnum']) && $articleLib->jieqiConfigs['article']['maxattachnum']>0){
				$data['maxfilenum'] = $articleLib->jieqiConfigs['article']['maxattachnum'];
			}
			//Ĭ�����������ľ�
			$this->db->init('chapter','chapterid','article');
			$this->db->setCriteria ( new Criteria ( 'articleid', $param['aid']));
			$this->db->criteria->setSort('chapterorder');
			$this->db->criteria->setOrder('DESC');
			//�����½�+��
			$chaptercount = $this->db->getCount($this->db->criteria);
			$volumeid=$chaptercount+1;
			$tmpvar=$volumeid;
			$k=0;
			//���о�
			$this->db->queryObjects();
			while($v = $this->db->getObject()){
				if($v->getVar('chaptertype')==1){//��
					$volumerows[$k]['volumeid'] = $tmpvar;
					$volumerows[$k]['vid'] = $v->getVar('chapterid');
					$volumerows[$k]['volumename'] = $v->getVar('chaptername');
					$tmpvar=$volumeid-$k-1;
				}
				$k++;
			}
			$data['volumes'] = $volumerows;
			//�½�����ǰ׺
			$data['chaptername_prefix'] =  $this->autoChapterNamePrefix($article);
			return $data;
		}
		/**
		 * ���������½���ͼ
		 */
		function addChapterView($param){
		    $this->addConfig('article','power');
		    $jieqiPower['article'] = $this->getConfig('article','power');
			header('Content-Type:text/html;charset=gbk');//����ˢ��ʱ��������
			$aid = $param['aid'];
			$auth = $this->getAuth();
			$articleLib =  $this->load('article','article');
			$data = $articleLib->getSources ();
			$data['wordsperegold'] = $articleLib->jieqiConfigs['article']['wordsperegold'];
			if(!empty($aid)){
				//�����½�,����й����������µ�Ȩ��Ҳ����ʹ��
				$article = $articleLib->isExists($aid);
				$articleLib->canedit($article);
				$data['articles'] = array();
			}else{
				$data['articles'] = $articleLib->articleByAuthorid($auth['uid']);
				//���������½�
				if(empty($data['articles'])){
					$this->msgwin (LANG_NOTICE,sprintf ( $articleLib->jieqiLang['article']['noper_create_chapter'],$this->geturl ( 'article', 'article', 'SYS=method=step1View')));
				}else{
					$aid = $data['articles'][0]['articleid'];
					$article = $data['articles'][0];
				}
			}
			$data['authtypeset'] = $articleLib->jieqiConfigs['article']['authtypeset'];
			$canupload = $this->checkpower($articleLib->jieqiPower['article']['articleupattach'], $this->getUsersStatus(), $this->getUsersGroup(), true);
			//��������
			$data['maxfilenum'] = 0;
			if($canupload && is_numeric($articleLib->jieqiConfigs['article']['maxattachnum']) && $articleLib->jieqiConfigs['article']['maxattachnum']>0){
				$data['maxfilenum'] = $articleLib->jieqiConfigs['article']['maxattachnum'];
			}
			$data['article'] = $articleLib->article_vars($article);
			$articleLib->handleManageallarticle($data['articles'], $data['article']);
			//����vip,�Զ���۸�Ȩ��
			$data['article']['customprice'] = 0;

			if($data['article']['articletype'] && $this->checkpower($articleLib->jieqiPower['article']['customprice'], $this->getUsersStatus (), $this->getUsersGroup (), true)){
				$data['article']['customprice'] = 1;//��V���Զ���۸�
			}
			$this->db->init('chapter','chapterid','article');
			$this->db->setCriteria ( new Criteria ( 'articleid', $aid));
			$this->db->criteria->setSort('chapterorder');
			$this->db->criteria->setOrder('DESC');
			//�����½�+��
			$chaptercount = $this->db->getCount($this->db->criteria);
			$volumeid=$chaptercount+1;
			$tmpvar=$volumeid;
			$k=0;
			$this->db->queryObjects();
			while($v = $this->db->getObject()){
				if($v->getVar('chaptertype')==1){//���о�
					$volumerows[$k]['volumeid'] = $tmpvar;
					$volumerows[$k]['vid'] = $v->getVar('chapterid');
					$volumerows[$k]['volumename'] = $v->getVar('chaptername');
					$tmpvar=$volumeid-$k-1;
				}
				$k++;
			}
			//ָ��ѡ��ľ�
			if(!empty($param['vid'])){
				$data['vid'] = $param['vid'];
			}
			$data['volumes'] = $volumerows;
			$data['power'] = $this->checkpower($jieqiPower['article']['manageallarticle'], $this->getUsersStatus(), $this->getUsersGroup(), true );
			//�½�����ǰ׺
			//$data['chaptername_prefix'] =  $this->autoChapterNamePrefix($article);
			return $data;
		}
		private function str2int($string, $concat = true) {
			$length = strlen($string);
			for ($i = 0, $int = '', $concat_flag = true; $i < $length; $i++) {
				if (is_numeric($string[$i]) && $concat_flag) {
					$int .= $string[$i];
				} elseif(!$concat && $concat_flag && strlen($int) > 0) {
					$concat_flag = false;
				}
			}
			return (int) ++$int;
		}
		//�Զ��½�����ǰ׺
		private function autoChapterNamePrefix($article){
			$chaptername_prefix  = "";
			//ͨ�����õ�ʱ����postdate�����Ƿ������°��Զ��½����
			//2015-4-28 00:00:00
			if($article['postdate'] >= $this->auto_chatper_prefix_timestamp){
				$this->db->init ( 'chapter', 'chapterid', 'article' );
				$this->db->setCriteria ( new Criteria ( 'articleid', $article ['articleid'] ) );
				$this->db->criteria->add ( new Criteria ( 'chaptertype', 0, '=' ) );
				$this->db->criteria->setSort ( 'chapterorder' );
				$this->db->criteria->setOrder ( 'DESC' );
				$this->db->criteria->setLimit ( 1 );
				$this->db->queryObjects ();
				$last_chapter = $this->db->getObject();
				if(is_object ($last_chapter)){//���½ڣ�ȡ���һ���½�
					//�п����� ��or��X��
					$chaptername = $last_chapter->getVar ( 'chaptername', 'n' );
					if(strpos($chaptername, '�� ') === 0){//��+�ո�
						$chaptername_prefix=array("��1��");
					}else{
						$chaptername_prefix=array("��".$this->str2int($chaptername,false)."��");
					}
				}else{//û���½ڣ�����Ĭ��ֵ���򣬵�1��
					$chaptername_prefix=array("��",'��1��');
				}
			}
			return $chaptername_prefix;
		}
		/**
		 * �������ػ�����ʾ�½�
		 * @param unknown $aid			aid
		 * @param unknown $chapterids	cid����
		 * @param number $setdisplay	0��ʾ��1����
		 */
		function hideChapter($aid,$chapterids,$setdisplay=0){
			$articleLib =  $this->load('article','article');
			$canedit=$this->checkpower($articleLib->jieqiPower['article']['manageallarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true);
			if(!$canedit) $this->printfail($articleLib->jieqiLang['article']['noper_edit_article']);

			if(empty($chapterids)) $this->printfail($articleLib->jieqiLang['article']['noselect_delete_chapter']);
			$cids=$this->arrayToStr($chapterids);
			if($cids != '' && !empty($chapterids)){
					$now=time();
					$sql="UPDATE jieqi_article_chapter SET display=".$setdisplay.",lastupdate='$now',postdate='$now' WHERE articleid=".$aid." AND chapterid IN (".$cids.")";
					$this->db->init('chapter','chapterid','article');
					$this->db->query($sql);
					//����������ҳ�ʹ��
					$ptypes=array('makeopf'=>1, 'makehtml'=>$articleLib->jieqiConfigs['article']['makehtml'], 'makezip'=>$articleLib->jieqiConfigs['article']['makezip'], 'makefull'=>$articleLib->jieqiConfigs['article']['makefull'], 'maketxtfull'=>$articleLib->jieqiConfigs['article']['maketxtfull'], 'makeumd'=>$articleLib->jieqiConfigs['article']['makeumd'], 'makejar'=>$articleLib->jieqiConfigs['article']['makejar']);
					$articleLib->article_repack($aid, $ptypes, 0);
			}
		}
	/**
	 * �������û���ȡ��VIP
	 * @param unknown $aid			aid
	 * @param unknown $chapterids	cid����
	 * @param number $setdisplay	0��ѣ�1�շ�
	 */
	function vipChapter($aid,$chapterids,$setvip=0){
		$articleLib =  $this->load('article','article');
		$canedit=$this->checkpower($articleLib->jieqiPower['article']['manageallarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true);
		if(!$canedit) $this->printfail($articleLib->jieqiLang['article']['noper_edit_article']);

		if(empty($chapterids)) $this->printfail($articleLib->jieqiLang['article']['noselect_delete_chapter']);
		$cids=$this->arrayToStr($chapterids);
		if($cids != '' && !empty($chapterids)){
			$now=time();
			$sql="UPDATE jieqi_article_chapter SET isvip=".$setvip.",lastupdate='$now',postdate='$now' WHERE articleid=".$aid." AND chapterid IN (".$cids.")";
			$this->db->init('chapter','chapterid','article');
			$this->db->query($sql);
			//����������ҳ�ʹ��
			$ptypes=array('makeopf'=>1, 'makehtml'=>$articleLib->jieqiConfigs['article']['makehtml'], 'makezip'=>$articleLib->jieqiConfigs['article']['makezip'], 'makefull'=>$articleLib->jieqiConfigs['article']['makefull'], 'maketxtfull'=>$articleLib->jieqiConfigs['article']['maketxtfull'], 'makeumd'=>$articleLib->jieqiConfigs['article']['makeumd'], 'makejar'=>$articleLib->jieqiConfigs['article']['makejar']);
			$articleLib->article_repack($aid, $ptypes, 0);
		}
	}
		/**
		 * ����ɾ���½�
		 * @param unknown $param
		 */
		function batchDelChapter($aid,$chapterids){
			if(empty($chapterids)) $this->printfail($this->jieqiLang['article']['noselect_delete_chapter']);
			$articleLib =  $this->load('article',false);
			//���Ȩ��
			$articleLib->delPower($aid);
			$article = $articleLib->isExists($aid);
			//ִ��ɾ��
			$cids='';
			foreach ($chapterids as $cid){
				$cid = intval($cid);
				if($cid){
					if($cids != '') $cids .= ', ';
					$cids .= $cid;
				}
			}
			if($cids != ''){
				$articleLib->batchDelChapter($article, $cids, true);
			}
		}
		/**
		 * ɾ��һƪ�½�/��
		 */
		function delChapter($param){
			$articleLib =  $this->load('article','article');
			$aid = $param['aid'];
			$articleLib->delPower($aid);
			$cid = $param['cid'];
			$ctype = $param['ctype'];
			$articleLib->delChapterById($aid,$cid,$ctype);
			$this->jumppage($this->geturl('article','chapter','SYS=method=cmView&aid='.$aid), LANG_DO_SUCCESS, $articleLib->jieqiLang['article']['chapter_delete_success_'.$ctype]);
		}
		/**
		 * �½�����
		 */
		function chapterSort($param){
			$aid = $param['aid'];
			$fromid = $param['fromid'];
			$toid = $param['toid'];
			$articleLib =  $this->load('article','article');
			$article=$articleLib->isExists($aid);
			$this->db->init ('chapter','chapterid','article' );
			$this->db->setCriteria ( new Criteria ( 'articleid',$aid));
			$chaptercount = $this->db->getCount();
			if(!isset($fromid) || $fromid<1 || $fromid>$chaptercount || !isset($toid) || $toid<0 || $toid>$chaptercount){
				$this->printfail($articleLib->jieqiLang['article']['chapter_sort_errorpar']);
			}
			//����html
		    $this->addConfig('article','url');
		    $setreader = $this->getConfig('article','url','reader_main');
			$package = $this->load('article','article');//�������´�����
			$package->article_repack($aid, array('makeopf'=>1, 'makehtml'=>$setreader['ishtml']));
			if($fromid==$toid || $fromid==$toid){
				$this->jumppage($this->geturl('article','chapter','SYS=method=cmView&aid='.$aid), LANG_DO_SUCCESS, $articleLib->jieqiLang['article']['chapter_edit_success']);
			}else{
				$articleLib->chapterSort($article,$fromid,$toid);
				$this->jumppage($this->geturl('article','chapter','SYS=method=cmView&aid='.$aid), LANG_DO_SUCCESS, $articleLib->jieqiLang['article']['chapter_sort_success']);
			}
		}
		/**
		 * �־������ͼ��Դ
		 * @param unknown $param
		 * @return unknown
		 */
		function volumeManage($param){
			header('Content-Type:text/html;charset=gbk');//����ˢ��ʱ��������
			$aid = $param['aid'];
			$auth = $this->getAuth();
			$articleLib =  $this->load('article','article');
			$article = $articleLib->isExists($aid);
			$articleLib->canedit($article);
			$data['articles'] = $articleLib->articleByAuthorid($auth['uid']);
			$articleLib->handleManageallarticle($data['articles'], $article);
			$data['article'] =$articleLib->article_vars($article);
			$this->db->init('chapter','chapterid','article');
			$this->db->setCriteria ( new Criteria ( 'articleid', $aid));
			$this->db->criteria->setSort('chapterorder');
			$this->db->criteria->setOrder('ASC');
			$this->db->queryObjects();
			$chapterrows = array ();
			$k = 0;
			while ( $chapter = $this->db->getObject () ) {
				$chapterrows [$k] ['chapterid'] = $chapter->getVar ( 'chapterid' );
				$chapterrows [$k] ['chaptertype'] = $chapter->getVar ( 'chaptertype' );
				$chapterrows [$k] ['chaptername'] = $chapter->getVar ( 'chaptername','n');
				$chapterrows [$k] ['chapterorder'] = $chapter->getVar ( 'chapterorder' );
				$chapterrows [$k] ['comment'] = $chapter->getVar ( 'comment' );
				$chapterrows [$k] ['commentdate'] = $chapter->getVar ( 'commentdate' );
				$chapterrows [$k] ['display'] = $chapter->getVar ( 'display' );
				$chapterrows [$k] ['isvip'] = $chapter->getVar ( 'isvip' );
				$chapterrows [$k] ['postdate'] = $chapter->getVar ( 'postdate' );
				$chapterrows [$k] ['size_c'] = ceil($chapter->getVar ( 'size' )/2);
				$k ++;
			}
			$data['chapterrows'] = $chapterrows;
			$this->db->criteria->setOrder('DESC');
			//�����½�+��
			$chaptercount = $this->db->getCount($this->db->criteria);
			$volumeid=$chaptercount+1;
			$tmpvar=$volumeid;
			$k=0;
			//���о�
			$this->db->queryObjects();
			while($v = $this->db->getObject()){
				if($v->getVar('chaptertype')==1){//��
					$volumerows[$k]['volumeid'] = $tmpvar;
					$volumerows[$k]['cid'] = $v->getVar('chapterid');
					$volumerows[$k]['volumename'] = $v->getVar('chaptername','n');
					$tmpvar=$volumeid-$k-1;
				}
				$k++;
			}
			$data['volumes'] = $volumerows;
			$data['hasvolume'] = 0;
			if(!empty($volumerows)){
				$data['hasvolume'] = 1;
			}
			return $data;
		}
		
		function checkChapter($params = array(), $isreturn = false){
		    include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
		    $retmsg = array();
		    $errtext = '';
			if($errtext){
				 $retmsg['error'] = $errtext;
			}else  $retmsg['ok'] = '�½�������'.ceil(jieqi_strlen(jieqi_utf82gb($params['chaptercontent']))/2);
			if(!$isreturn) exit($this->json_encode($retmsg));
			else return $errtext;
		}
		
		
		/**
		 * ���$chapterName�ĺϷ��ԣ���֤2����Ŀ��Ӱ����ҳ���ַ���ͬ�����½������ظ���������ǰ׺����
		 * @author chengyuan 2015-5-6 ����10:41:27
		 * @param unknown $aid				���			����
		 * @param unknown $cid				�½ں�		�ɿգ��������ظ��ж����½ںţ����磺�޸��½�
		 * @param unknown $chapterName		�½�����		����
		 * @param string $isreturn			�Ƿ񷵻���֤��Ϣ��Ĭ��false��json�����֤�����true������֤���
		 * @return string
		 */
		function checkChapterName($aid,$cid,$chapterName,$isreturn = false){
				
			include_once (JIEQI_ROOT_PATH . '/lib/text/textfunction.php');
			$articleLib = $this->load ( 'article', 'article' );
			$string = trim($chapterName);
			$retmsg = array();
			$errtext = '';
			// ������
			if (!jieqi_safestring ($string)){
				$errtext .= $articleLib->jieqiLang ['article'] ['limit_chapter_title'] . '<br />';
			}
			// 			if(!empty( $articleLib->jieqiConfigs ['system'] ['postdenywords'] )){// ������ͼ����û��Υ������
			// 				include_once (JIEQI_ROOT_PATH . '/include/checker.php');
			// 				$checker = new JieqiChecker ();
			// 				$matchwords1 = $checker->deny_words ($string, $articleLib->jieqiConfigs ['system'] ['postdenywords'], true );
			// 				if (is_array($matchwords1 )) {
			// 					if (! isset ( $articleLib->jieqiLang ['system'] ['post'] )){
			// 						$this->addLang('system','post');
			// 						$articleLib->jieqiLang['system'] =  $this->getLang('system');
			// 					}
			// 					$errtext .= sprintf ( $articleLib->jieqiLang ['system'] ['post_words_deny'], implode ( ' ', jieqi_funtoarray ( 'htmlspecialchars', $matchwords1 ) ) );
			// 				}
			// 			}
			//����½������Ƿ��ظ������ж��½����Ƶ�ǰ׺
			$article = $articleLib->isExists($aid);
			if($article['postdate'] >= $this->auto_chatper_prefix_timestamp){
				$this->db->init ( 'chapter', 'chapterid', 'article' );
				$this->db->setCriteria ( new Criteria ( 'articleid', $aid) );
				$this->db->criteria->add ( new Criteria ( 'chaptertype', 0, '=' ) );
				if ($cid && !empty($cid)) {
					$this->db->criteria->add ( new Criteria ( 'chapterid',$cid, '!=' ) );
				}
				//regexp ����Ҫ�������� =
				$this->db->criteria->add(new Criteria('chaptername REGEXP', '^(��|��[0-9]+��) '.$string.'$',''));
				$this->db->criteria->setSort ( 'chapterorder' );
				$this->db->criteria->setOrder ( 'DESC' );
				$this->db->criteria->setLimit ( 1 );
				$this->db->queryObjects ();
				$same_chapter = $this->db->getObject();
				if(is_object ($same_chapter)){//���½�
					$errtext .= "�½����ظ���". $same_chapter->getVar ( 'chaptername', 'n' ). '<br />';
				}
			}
			// 			echo $this->db->returnSql($this->db->criteria);
			// 			echo $errtext;
			// 			if($articleLib->jieqiConfigs ['article'] ['samearticlename'] != 1) {
			// 				$this->db->init ( 'article', 'articleid', 'article' );
			// 				$this->db->setCriteria ( new Criteria ( 'articlename', $string) );
			// 				if(!empty($aid) && $aid>0){
			// 					$this->db->criteria->add ( new Criteria ( 'articleid', $aid, '!=' ));
			// 				}
			// 				if ($this->db->getCount () > 0) {
			// 					$errtext .= sprintf ( $articleLib->jieqiLang ['article'] ['articletitle_has_exists'], jieqi_htmlstr ($string) ) ;
			// 				}
			// 			}
				
			if($errtext){
				$retmsg['error'] = $errtext;
			}else  $retmsg['ok'] = "";
			if(!$isreturn) exit($this->json_encode($retmsg));
			else return $errtext;
		}
}
?>