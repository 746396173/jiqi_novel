<?php
/**
 * ��̨ϵͳ����->�������������
 * @author chengyuan  2014-6-12
 *
 */
class channelModel extends Model{

	/**
	 * �б�
	 * @param unknown $params
	 * @return multitype:unknown
	 */
	public function main($params = array()){
		$this->addConfig('pooling','configs');
		$this->addConfig('pooling','power');
		$_PAGE['apiurl'] = $this->getConfig('pooling','configs','apiurl');
		$_PAGE['apijoinurl'] = $this->getConfig('pooling','configs','apijoinurl');
		//������������Ȩ��
		$_PAGE['manageallarticle'] = $this->checkpower($this->getConfig('pooling','power','manageallarticle'), $this->getUsersStatus (), $this->getUsersGroup (), true);
	    //��ʼ����ǩ����
		$channel = $this->load('channel', 'pooling');
		$channel->setCriteria();
// 		$channel->criteria->add(new Criteria('siteid', JIEQI_SITE_ID));
		if(!$this->checkisadmin() && !$_PAGE['manageallarticle']){//�ǹ���Ա����ѯ�Լ����������
			$auth = $this->getAuth();
			$uid = $this->getFormat($auth['uid'],'q');
			$channel->criteria->add(new Criteria('FIND_IN_SET('.$uid, '',',uid)'));
		}
		
		//��ý��˾���� ���⴦��
		//2015-5-12 add chengyuan
		$articleLib = $this->load('article','article');
		if($articleLib->mediaUser()){
			//���ε��麣����
			$channel->criteria->add(new Criteria('channelid', '62','!='));
		}
		
		if($params['keyword']){
			$channel->criteria->add(new Criteria('channelname', '%'.$params['keyword'].'%', 'LIKE'));
			$_PAGE['keyword']=$params['keyword'];
		}
		$channel->criteria->setSort('listorder,type');
		$channel->criteria->setOrder('ASC');
		$_PAGE['rows'] = $channel->lists(30, $params['page']);
		foreach($_PAGE['rows'] as $k=>$v){
			eval('$setting = '.$v['setting'].';');//�ַ���ת����
			$v['setting'] = $setting;
			if($v['uid']){
				//
				//SELECT IF( realName !='', GROUP_CONCAT(realName), GROUP_CONCAT(uname) ) AS unames FROM `jieqi_system_users`
// 				$resutl = $this->db->selectsql ("SELECT GROUP_CONCAT(uname) AS unames FROM `jieqi_system_users` WHERE uid in ({$v['uid']})");
				$resutl = $this->db->selectsql ("SELECT IF( realName !='', GROUP_CONCAT(realName), GROUP_CONCAT(uname) ) AS unames FROM `jieqi_system_users` WHERE uid in ({$v['uid']})");
				$v['unames'] = $resutl[0]['unames'];
			}
			$_PAGE['rows'][$k] = $v;
		}
		$_PAGE['url_jumppage'] = $channel->getPage();
		if($_PAGE['manageallarticle']){
			$_PAGE['agents'] = $this->getUsers();
		}
		return array('_PAGE'=>$_PAGE);
	}
	/**
	 * ��ȡ���п��Խ�������������û��б�
	 */
	private function getUsers(){
		$this->addConfig('pooling','power');
		$power = $this->getConfig('pooling','power','authorpanel');
		if($power['groups']){
			$group_array = $power['groups'];
			if(is_array($group_array)){
				$this->db->init('users','uid','system');
				$this->db->setCriteria();
				$this->db->criteria->setFields("uid,uname,realName,name,groupid");
				foreach($group_array as $k=>$groupid){
					$this->db->criteria->add(new Criteria('groupid', $groupid), 'OR');
				}
				$this->db->criteria->setSort('uid');
				$this->db->criteria->setOrder('ASC');
				$agents = $this->db->lists();
			}
		}
		return $agents;
	}
	/**
	 * ������������Ա
	 * @param unknown $uids	uid array
	 */
	public function schedule($channelid,$uids){
		if($this->submitcheck() && $channelid){
			if(is_array($uids) && !empty($uids)){
				$uids_str = implode(',',$uids);
			}
			$channel = $this->load('channel', 'pooling');//����channel�Զ�����
			if(!$channel->edit($channelid,array('uid'=>$uids_str))){
				$this->printfail(LANG_ERROR_PARAMETER);
			}else{
				$this->jumppage(null,null);
			}
		}else{
			$this->printfail(LANG_ERROR_PARAMETER);
		}
	}
	/**
	 * ɾ��
	 * @param unknown $params
	 */
	public function del($params = array()){
		if($params['cid']){
			$_OBJ['channel'] = $this->load('channel', 'pooling');
			if($_OBJ['channel']->delete($params['cid'])){
				//ɾ�� ���ݳ����£��½�
				$this->db->init ( 'article', 'paid', 'pooling' );
				$this->db->setCriteria(new Criteria('channelid', $params['cid']));
				if($this->db->delete( $this->db->criteria )){
					$this->db->init ( 'chapter', 'pcid', 'pooling' );
					$this->db->setCriteria(new Criteria('channelid', $params['cid']));
					if($this->db->delete( $this->db->criteria )){
						$this->jumppage($this->getAdminurl('channel','','pooling'));
					}else{
						$this->printfail('�½�ɾ��ʧ��');
					}
				}else{
					$this->printfail('����ɾ��ʧ��');
				}
			}else{
				$this->printfail('����ɾ��ʧ��');
			}
		}else{
			$this->printfail(LANG_ERROR_PARAMETER);
		}
	}
	/**
	 * ����
	 * @param unknown $params
	 * 2014-6-12
	 */
	public function order($params = array()){
	    $_OBJ['channel'] = $this->load('channel', 'pooling');
		if($this->submitcheck()){
			 if($_OBJ['channel']->order($_OBJ['channel']->order, $params['order'])){
			     $_OBJ['channel']->cache();//���»���
			     jieqi_jumppage($this->getAdminurl('channel','','pooling'));
			 }else jieqi_printfail();
		}
	}
	/**
	 * �������޸ĺ������ͼ��ת
	 * @param unknown $params
	 * @return multitype:string unknown
	 */
	public function add($params = array()){
		$this->db->init( 'channel', 'channelid', 'pooling' );
		$_OBJ['channel'] = $this->load('channel', 'pooling');//����channel�Զ�����
		//add or edit
		if($this->submitcheck()){
		//print_r($params);exit;
			 //������Զ������飬�����ȴ���
			 /*if($_REQUEST['setting']['custom']){

				 if($block=$blocks_handler->get($_REQUEST['setting']['bid'])){
					 //�Զ�������
					 if($block->getVar('canedit')==1){
						 $block->setVar('content', $_REQUEST['setting']['content']);
					 }
				 }
				 if($blocks_handler->insert($block)){
				   $blocks_handler->saveContent($block->getVar('bid'), $block->getVar('modname'), JIEQI_CONTENT_HTML, $_REQUEST['setting']['content']);
				 }
				 $_REQUEST['setting']['content'] = '';
			 }*/
			 $data = $params['info'];
			 $data['editdate'] = JIEQI_NOW_TIME;
			 
			 //regexp handle
			 preg_match_all ( "/(.+)=(.+)|\\".PHP_EOL."/", trim($params['setting']['getdata']['category']), $matches );
			 if($matches[1] && $matches[2]){
			 	$params['setting']['getdata']['category'] = array_filter(array_combine($matches[1],$matches[2]));
			 }else{
			 	$params['setting']['getdata']['category'] = '';
			 }
			 //split handle 
			 // 			 $category = array();
			 // 			 foreach(explode(PHP_EOL,$params['setting']['getdata']['category']) as $k=>$v){
			 // 			 	$tmp = explode("=",$v);
			 // 			 	$category[$tmp[0]] = $tmp[1];
			 // 			 }
			 // 			 $params['setting']['getdata']['category'] = $category;
			 
			 
			 
			 $data['setting'] = ($this->arrayeval($params['setting']));
			 //addslashes_array
			 //��������
			 if($params['cid']){//channelid ����
				 $statu = $_OBJ['channel']->edit($params['cid'],$data); //�޸�
				 $cid = $params['cid'];
			 }else{
			 	 $data['postdate'] = JIEQI_NOW_TIME;
				 $statu = $_OBJ['channel']->add($data);//����
				 $cid = $statu;
			 }
			 //��Ϣ
			 if($statu){
				$_OBJ['channel']->cacheOne($cid);
				jieqi_jumppage($this->getAdminurl('channel','','pooling'));
			 } else jieqi_printfail();
		}

		////////////////////////////�����//////////////////////////////
		//����޸�״̬
		if($params['cid']){
			 //��ȡ�޸���Ŀ����
			 $_SGLOBAL['channel'] = $_OBJ['channel']->get($params['cid']);
// 			 print_r($_SGLOBAL['channel']);exit;
		}else{//���״̬
			$_SGLOBAL['position']['type'] = $params['type'];
			if($_SGLOBAL['position']['type']!=2) $_SGLOBAL['position']['setting']['bid'] = $params['bid'];
		}
		if($params['step']){
			//������ݱ�
			//ȡ������
			$this->db->setCriteria(new Criteria('custom',0,'='));
			$this->db->criteria->setSort('weight');
			$this->db->criteria->setOrder('ASC');
			$this->db->queryObjects($criteria);
			$blockary = array();
			while($v = $this->db->getObject()){
				$blockary[$k]['bid']=$v->getVar('bid');
				$blockary[$k]['blockname']=$v->getVar('blockname');
				$blockary[$k]['modname']=$v->getVar('modname', 'n');
				//$blockary[$k]['side']=$blocks_handler->getSide($v->getVar('side', 'n'));
				$blockary[$k]['weight']=$v->getVar('weight');
				//$blockary[$k]['weight']=$v->getVar('weight');
				//$blockary[$k]['template']=$blocks_handler->getPublish($v->getVar('template', 'n'));
				$k++;
			}
			$_PAGE['block'] = $blockary;
		}
		if($_SGLOBAL['position']['type']==1){//��ѯ����
		     $this->db->setCriteria(new Criteria('bid', $_SGLOBAL['position']['setting']['bid']));
			 if(($block = $this->db->get($this->db->criteria))){//echo $_SGLOBAL['position']['setting']['bid'];
				 //$_SGLOBAL['position']['setting'] = array();
				 foreach($block->vars as $k=>$v){
					 if(in_array($k,array('template', 'vars')) && $params['posid']) continue;
					 $_SGLOBAL['position']['setting'][$k] = $block->getVar($k,'n');
				 }
				 //$_SGLOBAL['position']['setting']['filename'] = $block->getVar('filename','n');
				 //$_SGLOBAL['position']['setting']['description'] = $block->getVar('description','n');
				 $_SGLOBAL['position']['setting']['module'] = $block->getVar('modname','n');
			 }
		}

		//����Ĭ������Ȩֵ
		$_SGLOBAL['position']['listorder'] = $_SGLOBAL['position']['listorder'] ?$_SGLOBAL['position']['listorder'] :'0';
		//����Ĭ��ģ��
		if(!$_SGLOBAL['position']['setting']['template']){
			switch($_SGLOBAL['position']['type']){
				case '2':
					 $_SGLOBAL['position']['setting']['template'] = 'block_content.html';
				break;
			}
		}
		$this->addConfig('article','option');
		$this->jieqiConfigs['option'] = $this->getConfig('article','option');
		$_SGLOBAL['position']['firstflag'] = $this->jieqiConfigs['option']['firstflag'];
		return array('_PAGE'=>$_PAGE,'_SGLOBAL'=>$_SGLOBAL);
	}
	/**
	 * ɾ�����͵����£��������Զ�����id��id[]����ɾ����ʽ
	 * @param unknown $channelid	����ID
	 * @param unknown $id	id����id����
	 * 2014-6-13 ����1:27:38
	 */
	public function delArticle($channelid,$id){
		if(!$id || !$channelid) $this->printfail(LANG_ERROR_PARAMETER);
		$ids = array();//��Ŵ�ɾ��������ID����
		if(!is_array($id))  $ids[] = $id;
		else  $ids = $id;
		foreach($ids as $id){
			$this->db->init('article', 'paid', 'pooling');
			if($article = $this->db->get($id)){
				$this->db->delete($id);
				//todo 2014-11-17��ӹ���
				//��¼���ݳ�����ɾ����־
				$this->db->init ( 'articlelog', 'logid', 'article' );
				$newlog = array ();
				$newlog ['siteid'] = JIEQI_SITE_ID;
				$newlog ['logtime'] = JIEQI_NOW_TIME;
				$newlog ['userid'] = $_SESSION ['jieqiUserId'];
				$newlog ['username'] = $_SESSION ['jieqiUserName'];
				$newlog ['articleid'] = $article ['articleid'];
				$newlog ['articlename'] = $article ['articlename'];
				$newlog ['chapterid'] = 0;
				$newlog ['chaptername'] = '';
				$newlog ['reason'] = '';
				$newlog ['chginfo'] = 'ɾ�����ݳ�����';
				$newlog ['chglog'] = '';
				$newlog ['ischapter'] = '0';
				$newlog ['isdel'] = '1';
				$newlog ['databak'] = serialize ( $article );
				$this->db->add ( $newlog );
			}
		}
		//ɾ������ص��½�
		//2014-9-23���
		$this->db->init('chapter', 'pcid', 'pooling');
		foreach($ids as $id){
			$this->db->setCriteria ( new Criteria ( 'paid',$id ) );
			$this->db->criteria->add(new Criteria('channelid', $channelid));
			$this->db->delete ( $this->db->criteria );
		}
		$this->jumppage($this->getAdminurl('channel','method=pushView&cid='.$channelid,'pooling'));
	}
	/**
	 * ��������
	 * @param unknown $channelid	����id
	 * @param unknown $id			����id��id[]����
	 * @param unknown $statu		��������
	 * 2014-6-13 ����2:24:38
	 */
	public function editStatu($channelid,$id,$statu){
		if(!$channelid || !$id || !isset($statu)) $this->printfail(LANG_ERROR_PARAMETER);
		$this->db->init('article', 'paid', 'pooling');
		$ids = array();//��Ŵ�ɾ��������ID����
		if(!is_array($id))  $ids[] = $id;
		else  $ids = $id;
		foreach($ids as $id){
			$this->db->edit($id,array('pushflag'=>$statu));
		}
		$this->jumppage($this->getAdminurl('channel','method=pushView&cid='.$channelid,'pooling'));
	}
	/**
	 * �����������͵�����
	 * @param unknown $cid
	 * @param unknown $aids	1,2,3,4,5��ʽ
	 * 2014-6-12 ����2:59:09
	 */
	public function pushArticles($cid,$aids,$statu){
		$channelLib = $this->load('channel', 'pooling');
		$channel = $channelLib->get($cid,true);
		
		
		$data = explode(",", $aids);
		//�ȼ�����Ч��articleid
		$temp = array();//��Ч��article
		$this->db->init( 'article', 'articleid', 'article' );
		foreach($data as $k=>$v){
			$articleid = trim($v);
			if($article = $this->db->get($articleid)){
				$temp[] = $article;
			}
		}
		//ͳһ���
		$this->db->init('article', 'paid', 'pooling');
		foreach($temp as $k=>$v){
			//���˵��Ѿ����ڵ�
			$this->db->setCriteria ( new Criteria ( 'channelid', $cid ) );
			$this->db->criteria->add ( new Criteria ( 'articleid', $v['articleid'] ) );
			$this->db->criteria->setLimit ( 1 );
			$this->db->queryObjects ();
			$tmpa = $this->db->getObject ();
			if (is_object ( $tmpa )) {
				continue;
			}
			$_PAGE['data'] = array();
			$_PAGE['data']['channelid'] = $cid;
			$_PAGE['data']['articleid'] = $v['articleid'];
			$_PAGE['data']['articlename'] = $v['articlename'];
			if($channel['url'] == '360.com'){//�������
				$_PAGE['data']['sort'] = $this->getCategory_360($v['sortid']);//�麣��������
			}
			$_PAGE['data']['intro'] = $v['intro'];
			$_PAGE['data']['fullflag'] = $v['fullflag'];
			$_PAGE['data']['pushflag'] = $statu;
			$_PAGE['data']['adddate'] = JIEQI_NOW_TIME;
			$this->db->add($_PAGE['data']);
		}
		$this->jumppage($this->getAdminurl('channel','method=pushView&cid='.$cid,'pooling'));
		//��ӳɹ�
	}
	private function getCategory_360($category = 0) { // 360�ķ���
		$sort = array (
				1 => '����',
				2 => '����',
				3 => '����',
				4 => '��Ϸ',
				5 => '�ƻ�',
				6 => '����',
				7 => '���',
				8 => '��ʷ',
				9 => '����',
				10 => '����',
				11 => '����ͬ��',
				12 => '�ִ�����'
		);
		if (isset ( $sort [$category] ))
			return $sort [$category];
		else
			return '����';
	}
	/**
	 * ��ȡapi�ɼ���
	 * <p>
	 * Ĭ��my_collectDefault�ɼ���
	 * <p>
	 * �Զ���my_$channel["url"]�ɼ���
	 * @param unknown $channel
	 */
	private function getCollectLib($channel){
		//Ĭ�ϲɼ��� ���� �Զ�����ɼ���
		$url = "collectDefault";
		if($channel["url"] && file_exists($GLOBALS ['jieqiModules'] ['pooling'] ['path']."/lib/my_{$channel["url"]}.php")){
			$url = $channel["url"];
		}
		return $this->load($url,'pooling');
	}
	public function collectList($cid,$page){
		define ( 'JIEQI_USE_GZIP', '0' );
		ini_set ( 'zlib.output_compression', 0 );
		ini_set ( 'implicit_flush', 1 );
		ini_set("max_execution_time", 120); // s 40 ����
		ob_start ();
		ob_end_flush ();
		ob_implicit_flush ();
		@set_time_limit ( 0 );
		@session_write_close ();
		$this->db->init( 'channel', 'channelid', 'pooling' );
		$channelLib = $this->load('channel', 'pooling');
		$channel = $channelLib->get($cid,true);
		//Ĭ�ϲɼ��� ���� �Զ�����ɼ���
		$collectLib = $this->getCollectLib($channel);
		return $collectLib->collectList($cid,$page);
	}
	/**
	 * ��������api�ɼ��ӿ��е����������|����
	 * <p>
	 * modify 2015-7-17 11:44 by chengyuan �ɼ�һ���½ڣ���¼λ�á� 
	 * @param unknown $cid	����id
	 * @param unknown $aid	�ӿ�articleid
	 * @param number $page	�ӿ��ڵ�ҳ
	 * 2014-8-22 ����9:47:06
	 */
	public function newArticle($cid,$aid = array(),$page=1){
		if(!$cid || empty($aid)){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		define ( 'JIEQI_USE_GZIP', '0' );
		ini_set ( 'zlib.output_compression', 0 );
		ini_set ( 'implicit_flush', 1 );
		ini_set("max_execution_time", 0); // s 40 ����
		ob_start ();
		ob_end_flush ();
		ob_implicit_flush ();
		@set_time_limit ( 0 );
		@session_write_close ();
		$channelLib = $this->load('channel', 'pooling');
		$channel = $channelLib->get($cid,true);
// 		$collectLib = $this->load($channel['url'],'pooling');
		$collectLib = $this->getCollectLib($channel);
		$this->db->init( 'channel', 'channelid', 'pooling' );
		$data = $collectLib->collectList($cid,$page,$aid);
		$articleLib = $this->load('article','article');
		foreach ( $aid as $id ){
			if(array_key_exists($id,$data['rows'])){
				$timing = false;
				$article = $data['rows'][$id];
				$collectLib->out_msg('�벻Ҫ�رմ�ҳ�棬��ֹ�ɼ��жϣ�������');
				$collectLib->out_msg($article['articlename'].'....�ɼ���ʼ!�벻Ҫ�رմ�ҳ�棬��ֹ�ɼ��жϡ�');
				//�����߸���
				if($article['new']){//���
					if($article['fullflag']){
						$timing = true;//ȫ��������У���ʱ������
					}
					$article['articlelpic'] = array('name'=>$article['articlelpic'],'tmp_name'=>$article['articlelpic']);
					$article['articlespic'] = array('name'=>$article['articlespic'],'tmp_name'=>$article['articlespic']);
					$apiId = $article['articleid'];
					unset($article['articleid']);//����ǵ�����վ���е����
					$article['fullflag'] = 0;//ͳһ״̬������
					$localArticle =  $articleLib->newArticle($article);
					if(is_array($localArticle) && $localArticle['articleid']){
						$collectLib->out_msg('��'.$localArticle['articlename'].'����ӳɹ�');
						$lastchapterid = 0;
						//����->���ݳ�->�麣
						//���ݳؼ�¼�ɼ���Ϣ
						//ǰ���Ѿ������Ƿ�������жϣ�����ֱ�������ݳؼ�¼��
						$this->db->init('article', 'paid', 'pooling');
						$paid = $this->db->add(array(
								'channelid'=>$cid,//����id
								'articlename'=>$localArticle['articlename'],//����������
								'articleid'=>$localArticle['articleid'],//�麣id
								'lastvolumeid'=>0,
								'lastvolume'=>"",
								'lastchapterid'=>0,
								'lastchapter'=>"",
								'adddate'=>JIEQI_NOW_TIME,
								'intro'=>$article['intro'],//���������
								'apiId'=>$apiId//���������
						));
						if($paid){
							$collectLib->out_msg('���ݳ�ӳ��ɹ�');
							$article['mappingArticle']['paid']=$paid;
						}
					}
				}else{//����
					$lastchapterid = $article['mappingArticle']['lastchapterid'];
					$this->db->init('article', 'articleid', 'article');
					$localArticle = $this->db->get($article['mappingArticle']['articleid']);
// 					$update = 0;
// 					$localArticle = $article['localArticle'];
// 					if($localArticle['lastupdate'] != $article['lastupdate']){
// 						$localArticle['lastupdate'] = $article['lastupdate'];
// 						$update = 1;
// 					}
// 					if($localArticle['sortid'] != $article['sortid']){
// 						$localArticle['sortid'] = $article['sortid'];
// 						$update = 1;
// 					}
// 					if($localArticle['articletype'] != $article['isvip']){
// 						$localArticle['articletype'] = $article['isvip'];
// 						$update = 1;
// 					}
// // 					if($localArticle['fullflag'] != $article['fullflag']){
// // 						$localArticle['fullflag'] = $article['fullflag'];
// // 						$update = 1;
// // 					}
// 					if($update){
// 						$this->db->init('article','articleid','article');
// 						$this->db->edit($localArticle['articleid'],$localArticle);
// 					}
					//�Ѿ������½�����
// 					$this->db->init('chapter','chapterid','article');
// 					$this->db->setCriteria(new Criteria('articleid', $localArticle['articleid']));
// 					$chapterCount = $this->db->getCount($this->db->criteria);
				}
// 				$collect = false;
				//�ϴθ��µ���Ϣ
				$lastvolumeid = $article['mappingArticle']['lastvolumeid'];
				$lastvolume = $article['mappingArticle']['lastvolume'];
				$lastchapter = $article['mappingArticle']['lastchapter'];
// 				if($lastchapterid == 0){
// 					$collect = true;
// 				}
				//�������߸���ͳһ����
				//����½�
				//print_r($article);exit;
				if($article['chaptersurl']){
					$items =$collectLib->parseChapters($article['chaptersurl'],$lastchapterid);
					if(!empty($items)){
						$end_item = end($items);
						$end_chapter = $collectLib->packingChapter($end_item);
						if($end_chapter['cid']){
							if($lastchapterid == $end_chapter['cid']){
								$collectLib->out_msg('û����Ҫ���µ��½ڡ�');
							}else{
								//���Ѿ������½���һ�¿�ʼ
								$collectLib->out_msg ( '<table border=1><tr><th>��</th><th>����</th><th>�½�����</th><th>״̬</th><th>ʱ��</th><th>�ɼ����</th><th>��¼�ɼ�λ��</th></tr>',false);
								$ps= 0;
								$day= 1;
								for ($i = 0;$i < count($items);$i++){//���˵��ϴθ���
// 									if($i ==6)break;
									$chapter = $collectLib->packingChapter($items[$i]);
									// 							if(!$collect){//��λ
									// 								if($lastchapterid == $chapter['cid']){
									// 									$collect = true;//��ʼ�ɼ�
									// 									continue;//������Բ���д��ֻ��Ϊ�˱�ʶ�߼�
									// 								}
									// 							}else{
									$chapter['articleid'] =$localArticle['articleid'];
									if($timing){//����ʱ����
										//�״η������½�����ÿ����µ��½�������������Ϊ(һ����������)��ǰ�����ۼ�+1;
										//�ȴ����״η������½���
										if(is_numeric($channel['setting']['getdata']['firstnum']) && $channel['setting']['getdata']['firstnum'] && $channel['setting']['getdata']['postnum'] && is_array($channel['setting']['getdata']['postdate']) && !empty($channel['setting']['getdata']['postdate'][0])){
											//Ĭ��
											if(($i) >= $channel['setting']['getdata']['firstnum']){//���˵��׷����½���
												//����ʱ
												$posttime = $channel['setting']['getdata']['postdate'][$ps];
												//��������
												//��ǰ���ڵ�ʱ����
												//���ڣ�����strtotime("+1 day"))��+ʱ�䣨$posttime��
												$chapter['postdate'] =  strtotime(date("Y-m-d",strtotime("+".$day." day")).' '.$posttime);
												$ps++;
												if($ps == count($channel['setting']['getdata']['postdate'])){
													$ps= 0;
													$day++;
												}
											}
										}
									}
									$name = '�½�';
									if($chapter['chaptertype'] == 1){//��
										$name = '��';
										$newChapter = $articleLib->saveVolume($localArticle,null,$chapter['chaptername'],'',$chapter['postdate']);
										$lastvolumeid = $chapter['cid'];
										$lastvolume = $chapter['chaptername'];
									}else{//�½�
										// ���ݹ���
										if ($channel['setting']['getdata']['filter']) {
											$filterary = explode ( PHP_EOL, $channel['setting']['getdata']['filter']);
											$chapter ['chaptercontent'] = str_replace ( $filterary, '', $chapter ['chaptercontent'] );
										}
										//���p��ǩ�Ļ��С�
										$chapter ['chaptercontent'] = str_replace ( array('</p><p>','<p>','</p>'), array(PHP_EOL,'',''), $chapter ['chaptercontent'] );
										$newChapter = $articleLib->saveChapter($chapter);
										$lastchapterid = $chapter['cid'];
										$lastchapter = $chapter['chaptername'];
									}
									if(is_array($newChapter) && $newChapter['chapterid']){
										$tmp = date('Y-m-d H:i:s',$chapter['postdate']);
										$state = '����';
										if($chapter['postdate'] > JIEQI_NOW_TIME){
											$state = '<font color="red">��ʱ</font>';
										}
										$collectLib->out_msg ( "<tr><td>".($i+1)."</td><td>{$name}</td><td>{$newChapter['chaptername']}</td><td>{$state}</td><td>{$tmp}</td><td>�ɹ�</td>",false);
									
										//�������ݳ�ӳ��ģ��
										$this->db->init('article', 'paid', 'pooling');
										if($this->db->edit($article['mappingArticle']['paid'],array(
												'lastvolumeid'=>$lastvolumeid,
												'lastvolume'=>$lastvolume,
												'lastchapterid'=>$lastchapterid,
												'lastchapter'=>$lastchapter,
												'outchapters'=>$article['mappingArticle']['outchapters']+($i-1),
												'lastdate'=>JIEQI_NOW_TIME
										))){
											$collectLib->out_msg('<td>�ɹ�</td></tr>',false);
										}else{
											$collectLib->out_msg('<td>ʧ��</td></tr>',false);
											break;
										}
									}
									// 							}
								}
								$collectLib->out_msg( "</table>",false);
							}
						}else{
							$collectLib->out_msg_err('��Ч���½�ID');
						}
					}else{
						$collectLib->out_msg_err('�޷���λ�ϴθ���λ�ã��½����ƣ�'.$lastchapter);
					}
				}
				$collectLib->out_msg($article['articlename'].'....�ɼ�����!');
			}
		}
	}
	/**
	 * �������͵������б���ͼ
	 * @param unknown $params
	 * 2014-6-12 ����2:45:28
	 */
	public function pushView($params = array()){
		$this->db->init( 'channel', 'channelid', 'pooling' );
		$_OBJ['channel'] = $this->load('channel', 'pooling');//����channel�Զ�����
		if(!$_PAGE['channel'] = $_OBJ['channel']->get($params['cid'],true)) jieqi_jumppage('?ac=apisite', LANG_NOTICE, LANG_DO_FAILURE);
		//getparameter('page');
		//$_OBJ['view'] = new View('apiarticle', 'id', 'manage');
		//getparameter('type');
// 		if($_PAGE['type']=='del'){
// 			$id = $_PAGE['_GET']['id'] ?$_PAGE['_GET']['id'] :$_PAGE['_POST']['ids'];
// 			if(!$id) printfail(LANG_ERROR_PARAMETER);
// 			$ids = array();//��Ŵ�ɾ��������ID����
// 			if(!is_array($id))  $ids[] = $id;
// 			else  $ids = $id;
// 			foreach($ids as $id){
// 				$_OBJ['view']->delete($id);
// 			}
// 			jumppage();
// 		}
// 		if($_PAGE['type']=='statu'){
// 			$value = $_PAGE['_GET']['value'];
// 			$id = $_PAGE['_GET']['id'] ?$_PAGE['_GET']['id'] :$_PAGE['_POST']['ids'];
// 			if(!$id) printfail(LANG_ERROR_PARAMETER);
// 			$ids = array();//��Ŵ�ɾ��������ID����
// 			if(!is_array($id))  $ids[] = $id;
// 			else  $ids = $id;
// 			foreach($ids as $id){
// 				$_OBJ['view']->edit($id,array('statu'=>$value));
// 			}
// 			jumppage();
// 		}
// 		//�ύ�����������
// 		if($_PAGE['type']=='add'){
// 			if(submitcheck("dosubmit")){
// 				$_OBJ['article'] = new View('article', 'articleid', 'article');
// 				$_PAGE['data'] = getparameter('info');
// 				$articleids = getparameter('articleids');
// 				$data = explode(",", $articleids);
// 				foreach($data as $k=>$v){
// 					$_PAGE['data'] = array();
// 					$articleid = trim($v);
// 					if(!$article = $_OBJ['article']->get($articleid,true)) continue;
// 					$_PAGE['data']['sid'] = $_PAGE['_GET']['sid'];
// 					$_PAGE['data']['articleid'] = $articleid;
// 					$_PAGE['data']['articlename'] = $article['articlename'];
// 					$_PAGE['data']['intro'] = saddslashes($article['intro']);
// 					$_PAGE['data']['fullflag'] = 0;
// 					$_PAGE['data']['postdate'] = _NOW_;
// 					$_PAGE['data']['lastupdate'] = _NOW_;
// 					$_OBJ['view']->add($_PAGE['data'],true);
// 				}
// 				jumppage();
// 			}
// 		}
		$this->db->init( 'article', 'paid', 'pooling' );
		$this->db->setCriteria(new Criteria('channelid', $params['cid']));
		//����	����ʱ������
		//չʾ
		//�ɼ�
		if($_PAGE['channel']['type'] == 1){
			$this->db->criteria->setSort('adddate');
			$this->db->criteria->setOrder('desc');
		}else{
			$this->db->criteria->setSort('lastdate desc,adddate');
			$this->db->criteria->setOrder('desc');
		}
		$_PAGE['rows'] = $this->db->lists(200, $params['page']);
		$_PAGE['url_jumppage'] = $this->db->getPage();//print_r($_PAGE['rows']);
		return $_PAGE;
		/*	if(isset($_PAGE['apisite']['setting']['getdata']['articleids']) && $_PAGE['apisite']['setting']['getdata']['articleids']!=''){
		 $_OBJ['view'] = new View('article', 'articleid', 'article');
		$_OBJ['view']->setHandler('article');
		$_OBJ['view']->criteria->setFields('r.articleid,r.articlename,r.author,if(r.lastupdate>a.lastupdate,r.lastupdate,a.lastupdate) as lastupdate');
		$_OBJ['view']->criteria->setTables(jieqi_dbprefix('article_article')."  AS r LEFT JOIN ".jieqi_dbprefix('obook_obook')." AS a ON r.articleid=a.articleid");
		$_OBJ['view']->criteria->add(new Criteria('r.articleid', '('.$_PAGE['apisite']['setting']['getdata']['articleids'].')','in'));
		//$_OBJ['view']->criteria->add(new Criteria('r.display', 0));
		//$_OBJ['view']->criteria->add(new Criteria('r.siteid',0,'='));
		$_OBJ['view']->criteria->add(new Criteria('r.sortid', 30,'!='));
		$_OBJ['view']->criteria->add(new Criteria('r.size', 0,'>'));
		//$_OBJ['view']->criteria->setSort('lastupdate');
		//$_OBJ['view']->criteria->setOrder('DESC');
		$_PAGE['rows'] = $_OBJ['view']->lists(200, $_PAGE['page']);
		$_PAGE['url_jumppage'] = $_OBJ['view']->getPage();
		}*/
	}
	public function editArticle($params = array()){
		$data = array();
		$this->db->init( 'article', 'paid', 'pooling' );
		if(!$data['article'] = $this->db->get($params['paid'])) $this->jumppage('?ac=apisite', LANG_NOTICE, LANG_ERROR_PARAMETER);
		if($data['article']['setting']){
			eval('$setting = '.$data['article']['setting'].';');//�ַ���ת����
			$data['article']['setting'] = $setting;
		}
// 		$_OBJ['view'] = new View('apiarticle', 'id', 'manage');
		//�ύ����
		if($this->submitcheck()){//�޸�
			$article = $params['info'];
			//setting���úϲ����ã������Ǹ���ԭsetting��
			$setting = $params['setting'];
			if(is_array($data['article']['setting']) && is_array($setting)){
				$setting = array_merge($data['article']['setting'],$setting);
			}
			$article['setting'] = $this->arrayeval($setting);//����ת�ַ��ṹ
			if($_FILES['articleimage']['name']){
				include_once(JIEQI_ROOT_PATH.'/lib/my_httpupload.php');
				// �ϴ�����λ�ã�Ĭ��Ϊ��ǰ�ļ��С�./��
				$savepath = JIEQI_ROOT_PATH."/api/api_image";
				// �ϴ��ļ�Ҫ���mime���ͣ�Ĭ��Ϊtext,image
				$mimetype = "image";
				// �ļ���չ��Ҫ��Ĭ��Ϊ��jpg,bmp,png,gif,jpeg��
				$fileextname = "jpg,jpeg,gif,png";
				// �ļ���СҪ��Ĭ��Ϊ512000 ��500K��
				$maxsize = 1024000;
				// �Ƿ���������0Ϊ����������1Ϊ��������Ĭ��Ϊ1
				$filerename = 1;
				// �����������ļ���
				$savedir = date('Y/md', time());
				// �����ò������������ļ�����ʱ�Ƿ񸲸� 0Ϊ�����ǣ�1Ϊ���ǲ��ϴ���2Ϊ���������ϴ�
				$overwrite = 1;

				$upload = new HttpUpload('articleimage',$savepath,$mimetype,$fileextname, $maxsize, $filerename, $savedir, $overwrite);
				if($params['old_image']) $upload->__set("upload_filename",$savepath.$params['old_image']);
				$up = $upload -> upfile();
				if($up[upfile_file_error]) $this->printfail('�ϴ�����ʱ�������󣬴�����ţ�'.$up[upfile_file_error]);
				else{
					$article['image']  = str_replace($savepath,'',$up[upfile_file_path]);
					//��ͼ
					if($_FILES['larticleimage']['name']){
						$upload = new HttpUpload('larticleimage',$savepath,$mimetype,$fileextname, $maxsize, $filerename, $savedir, $overwrite);
						if($params['lold_image']) $upload->__set("upload_filename",$savepath.$params['lold_image']);
						$up = $upload -> upfile();
						$article['limage']  = str_replace($savepath,'',$up[upfile_file_path]);
					}
					//Сͼ
					if($_FILES['sarticleimage']['name']){
						$upload = new HttpUpload('sarticleimage',$savepath,$mimetype,$fileextname, $maxsize, $filerename, $savedir, $overwrite);
						if($params['sold_image']) $upload->__set("upload_filename",$savepath.$params['sold_image']);
						$up = $upload -> upfile();
						$article['simage']  = str_replace($savepath,'',$up[upfile_file_path]);
					}
				}
			}
// 			$data['lastdate'] = JIEQI_NOW_TIME;
			//if($_REQUEST['setting']['open']) $data['setting'] = saddslashes(arrayeval($_REQUEST['setting']));
			//else $data['setting'] = '';
			if($this->db->edit($params['paid'],$article)) $this->jumppage($this->getAdminurl('channel','method=pushView&cid='.$params['cid'],'pooling'));//�޸�
			else $this->printfail();
		}
// 		if($_PAGE['data']['chapterids']){
// 			eval('$apisiteSetting['.$_PAGE['_GET']['id'].'] = '.$_PAGE['data']['chapterids'].';');
// 			$_PAGE['data']['chapterids'] = $apisiteSetting[$_PAGE['_GET']['id']];
// 			$_SGLOBAL['api'] = $_PAGE['data']['chapterids'];//print_r($_SGLOBAL['api']);
// 		}
		$this->db->init( 'channel', 'channelid', 'pooling' );
		$data['channel'] = $this->db->get($params['cid']);
		return $data;
	}
	/**
	 * ��ƪ�������ͣ�����api�Զ�����ʵ����iapi�ӿڣ��ӿ��ڶ���push�ķ�����������cid����Id��paid��������Id��������ͨ��api�������ö�Ӧ�Զ�������ʵ�ֵĽӿڷ���
	 * @param unknown $params
	 * 2014-7-1 ����3:16:36
	 */
	public function push($params){
		if($params['cid']){
			$channelLib = $this->load('channel', 'pooling');//����channel�Զ�����
			if(!$channel = $channelLib->get($params['cid'])){
				$this->printfail(LANG_ERROR_PARAMETER);//LANG_ERROR_PARAMETER
			}
			if(!$channel['statu']){
				$this->printfail('api '.$channel["channelname"].' is close!');
			}
			$mod = $channel['url'];
			if($mod && file_exists($GLOBALS ['jieqiModules'] ['pooling'] ['path']."/lib/my_{$mod}.php")){
				$apiLib = $this->load($mod,'pooling');
				$paids = array();
				$paid = $params['paid'];
				if($paid){
					//ָ����������
					if(strchr($paid,',') !== false){
						$paids = explode(',',$paid);
					}else{
						$paids[] = $paid;
					}
				}elseif ($params['paids']){
					//form����
					$paids = $params['paids'];
				}
				/*-- ��ʼ���� begin--*/
				$articles = $apiLib->poolArticle($params['cid'],$paids);
				if($articles){
					@set_time_limit('0');
					@session_write_close();
					ini_set('memory_limit', '800M');
					ini_set("max_execution_time",'0');
// 					for($i=0;$i<40;$i++) {
// 						$apiLib->out_msg($i);
// 						sleep(1);
// 					}
// 					exit;
					$apiLib->out_msg ( '-->������'.$channel['channelname'].' ��ȡ' . count ( $articles ) . '����׼�����ͣ�' );
					$i = 0;
					
					foreach ( $articles as $article){
						if($article['setting']){
							eval('$setting = '.$article['setting'].';');//�ַ���ת����
							$article['setting'] = $setting;
						}
						$i++;
						$apiLib->out_msg ( '-----------------------------------------------------' );
						$apiLib->out_msg ( '-->��'.$i.'���顶'.$article['articlename'].'����ʼ����' );
						if(!$article ['size']){
							$apiLib->out_msg_err ( '-->article size is 0' );
						}else{
// 							if ($article['setting']['daychapter']
// 									&& is_numeric($article['setting']['daychapter'])
// 									&& $article['setting']['daychapter'] > 0
// 									&& date('Y-m-d', $article['lastdate']) == date("Y-m-d")){
// 								$apiLib->out_msg_err ( '-->�����Ѿ����͹��ˣ����������ɣ�' );
// 							}else{
								$apiLib->push($params['cid'],$article);
// 							}
						}
						$apiLib->out_msg ( '-->��'.$i.'���顶'.$article['articlename'].'����������' );
					}
					$apiLib->out_msg ( '-----------------------------------------------------' );
					$apiLib->out_msg ( '-->������'.$channel['channelname'].' �������' );
				}else{
					$apiLib->out_msg('-->'.$channel['channelname'].'���������͵�����');
				}
				/*-- ��ʼ���� end--*/
			}else{
				$this->printfail(LANG_ERROR_PARAMETER);
			}
		}else $this->printfail(LANG_ERROR_PARAMETER);
	}
}
?>