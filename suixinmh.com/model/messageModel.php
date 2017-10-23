<?php 
/** 
 * ����Ϣģ�� * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class messageModel extends Model{
	
	/**
	 * �ռ���,������,�ݸ���ɾ��
	 * @param unknown $param
	 * @return boolean
	 */
    public function main($param){
    	$auth = $this->getAuth();
		$this->addLang('system', 'message');
		$jieqiLang['system'] = $this->getLang('system');
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		
		if(!isset($param['box']) || $param['box'] != 'outbox') $param['box']='inbox';
		if (empty($param['page']) || !is_numeric($param['page'])) $param['page']=1; //ҳ��
		
		//���������Ϣ����������Ϣ��
		$this->addConfig('system','honors');
		$jieqiHonors = $this->getConfig('system','honors');	
		$this->addConfig('system','right');
		$jieqiRight['system'] = $this->getConfig('system','right');
		
		$maxmessages = isset($jieqiConfigs['system']['maxmessages']) ? intval($jieqiConfigs['system']['maxmessages']) : 0;
		$honorid=jieqi_gethonorid($auth['score'], $jieqiHonors);
		if($honorid && isset($jieqiRight['system']['maxmessages']['honors'][$honorid]) && is_numeric($jieqiRight['system']['maxmessages']['honors'][$honorid])) $maxmessages = intval($jieqiRight['system']['maxmessages']['honors'][$honorid]); //����ͷ�����õ���Ϣ��
		//��������ɾ��
		if(is_array($param['checkid']) && count($param['checkid'])>0){
			$ids=$this->arrayToStr($param['checkid']);
			$this->db->init('message','messageid','system');
			if(!empty($ids)){
				if($param['op'] == 'inbox'){
					$sql='UPDATE '.jieqi_dbprefix('system_message').' SET todel=1 WHERE toid='.$auth['uid'].' AND fromdel=0 AND messageid IN ('.$ids.')';
					$this->db->query($sql);
					$sql='DELETE FROM '.jieqi_dbprefix('system_message').' WHERE toid='.$auth['uid'].' AND fromdel=1 AND messageid IN ('.$ids.')';
					$this->db->query($sql);
					$this->jumppage ($this->geturl ( 'system', 'userhub', 'SYS=method=inbox'), LANG_DO_SUCCESS,LANG_DO_SUCCESS);
				}elseif($param['op'] == 'outbox'){
					$sql='UPDATE '.jieqi_dbprefix('system_message').' SET fromdel=1 WHERE fromid='.$auth['uid'].' AND todel=0 AND messageid IN ('.$ids.')';
					$this->db->query($sql);
					$sql='DELETE FROM '.jieqi_dbprefix('system_message').' WHERE fromid='.$auth['uid'].' AND todel=1 AND messageid IN ('.$ids.')';
					$this->db->query($sql);
					$this->jumppage ($this->geturl ( 'system', 'userhub', 'SYS=method=outbox'), LANG_DO_SUCCESS,LANG_DO_SUCCESS);
				}elseif($param['op'] == 'draft'){
					//ɾ���ݸ���
					$sql='DELETE FROM '.jieqi_dbprefix('system_message').' WHERE  messageid IN ('.$ids.')';
					$this->db->query($sql);
					$this->jumppage ($this->geturl ( 'system', 'userhub', 'SYS=method=draft'), LANG_DO_SUCCESS,LANG_DO_SUCCESS);
				}
			}
		}
	}
	
	/**
	 * �ռ��䣬�б�
	 * @param unknown $param
	 * @return multitype:NULL number Ambigous <multitype:, number, string> Ambigous <>
	 */
	function inbox($param){
		//header('Content-Type:text/html;charset=gbk');
		$auth = $this->getAuth();
		$this->addLang('system', 'message');
		$jieqiLang['system'] = $this->getLang('system');
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		
		if(!isset($param['box']) || $param['box'] != 'outbox') $param['box']='inbox';
		if (empty($param['page']) || !is_numeric($param['page'])) $param['page']=1; //ҳ��
		
		//���������Ϣ����������Ϣ��
		$this->addConfig('system','honors');
		$jieqiHonors = $this->getConfig('system','honors');	
		$this->addConfig('system','right');
		$jieqiRight['system'] = $this->getConfig('system','right');
		
		$maxmessages = isset($jieqiConfigs['system']['maxmessages']) ? intval($jieqiConfigs['system']['maxmessages']) : 0;
		$honorid=jieqi_gethonorid($auth['score'], $jieqiHonors);
		if($honorid && isset($jieqiRight['system']['maxmessages']['honors'][$honorid]) && is_numeric($jieqiRight['system']['maxmessages']['honors'][$honorid])) $maxmessages = intval($jieqiRight['system']['maxmessages']['honors'][$honorid]); //����ͷ�����õ���Ϣ��

		$data = array();
		$data['box'] = $param['box'];
		$data['maxmessage'] = $maxmessages;
		$messagerows=array();		
		$data['boxname'] = $jieqiLang['system']['message_receive_box'];
		$data['usertitle'] = $jieqiLang['system']['table_message_sender'];
		$this->db->init('message','messageid','system');
		$this->db->setCriteria(new Criteria('toid', $auth['uid']));
		$this->db->criteria->add(new Criteria('todel', 0));
		$this->db->criteria->setSort('messageid');
		$this->db->criteria->setOrder('DESC');
		$data['inboxnum'] = $this->db->getCount();
		$data['page'] = $param['page'];
		$data ['maxpage'] = ceil($data['inboxnum']/$jieqiConfigs['system']['messagepnum']);
		$data ['messagerows'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG);
		// ����ҳ����ת
		$data ['url_jumppage'] = $this->db->getPage ($this->getUrl(JIEQI_MODULE_NAME,'userhub','evalpage=0','SYS=method=inbox'));
		
		$this->msgtotal($data);
		return $data;
	}
	/**
	 * draft
	 * @param unknown $param
	 * @return multitype:NULL number Ambigous <> multitype:
	 */
	function draft($param){
		header('Content-Type:text/html;charset=gbk');
		$auth = $this->getAuth();
		$this->addLang('system', 'message');
		$jieqiLang['system'] = $this->getLang('system');
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		
		if(!isset($param['box']) || $param['box'] != 'outbox') $param['box']='inbox';
		if (empty($param['page']) || !is_numeric($param['page'])) $param['page']=1; //ҳ��
		
		//���������Ϣ����������Ϣ��
		$this->addConfig('system','honors');
		$jieqiHonors = $this->getConfig('system','honors');
		$this->addConfig('system','right');
		$jieqiRight['system'] = $this->getConfig('system','right');
		
		$maxmessages = isset($jieqiConfigs['system']['maxmessages']) ? intval($jieqiConfigs['system']['maxmessages']) : 0;
		$honorid=jieqi_gethonorid($auth['score'], $jieqiHonors);
		if($honorid && isset($jieqiRight['system']['maxmessages']['honors'][$honorid]) && is_numeric($jieqiRight['system']['maxmessages']['honors'][$honorid])) $maxmessages = intval($jieqiRight['system']['maxmessages']['honors'][$honorid]); //����ͷ�����õ���Ϣ��
		
		$data = array();
		$data['maxmessage'] = $maxmessages;
		$messagerows=array();
		$data['boxname'] = $jieqiLang['system']['message_receive_box'];
		$data['usertitle'] = $jieqiLang['system']['table_message_sender'];
		$this->db->init('message','messageid','system');
		$this->db->setCriteria(new Criteria('fromid', $auth['uid']));
		$this->db->criteria->add(new Criteria('fromdel', 0));
		$this->db->criteria->add(new Criteria('messagetype', 1));
		$this->db->criteria->setSort('messageid');
		$this->db->criteria->setOrder('DESC');
		$data ['messagerows'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG);
		// ����ҳ����ת
		$data ['url_jumppage'] = $this->db->getPage ($this->getUrl('system','userhub','evalpage=0','SYS=method=draft'));
		$this->msgtotal($data);
		return $data;
	}
	/**
	 * outbox
	 * @param unknown $param
	 * @return multitype:NULL number Ambigous <> multitype:
	 */
	function outbox($param){$auth = $this->getAuth();
		header('Content-Type:text/html;charset=gbk');
		$this->addLang('system', 'message');
		$jieqiLang['system'] = $this->getLang('system');
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		
		if(!isset($param['box']) || $param['box'] != 'outbox') $param['box']='inbox';
		if (empty($param['page']) || !is_numeric($param['page'])) $param['page']=1; //ҳ��
		
		//���������Ϣ����������Ϣ��
		$this->addConfig('system','honors');
		$jieqiHonors = $this->getConfig('system','honors');	
		$this->addConfig('system','right');
		$jieqiRight['system'] = $this->getConfig('system','right');
		
		$maxmessages = isset($jieqiConfigs['system']['maxmessages']) ? intval($jieqiConfigs['system']['maxmessages']) : 0;
		$honorid=jieqi_gethonorid($auth['score'], $jieqiHonors);
		if($honorid && isset($jieqiRight['system']['maxmessages']['honors'][$honorid]) && is_numeric($jieqiRight['system']['maxmessages']['honors'][$honorid])) $maxmessages = intval($jieqiRight['system']['maxmessages']['honors'][$honorid]); //����ͷ�����õ���Ϣ��

		$data = array();
		$data['box'] = $param['box'];
		$data['maxmessage'] = $maxmessages;
		$messagerows=array();		
		$data['boxname'] = $jieqiLang['system']['message_receive_box'];
		$data['usertitle'] = $jieqiLang['system']['table_message_sender'];
		$this->db->init('message','messageid','system');
		$this->db->setCriteria(new Criteria('fromid', $auth['uid']));
		$this->db->criteria->add(new Criteria('fromdel', 0));
		$this->db->criteria->add(new Criteria('messagetype', 0));
		$this->db->criteria->setSort('messageid');
		$this->db->criteria->setOrder('DESC');
		$data ['messagerows'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG);
		// ����ҳ����ת
		$data ['url_jumppage'] = $this->db->getPage ($this->getUrl('system','userhub','evalpage=0','SYS=method=outbox'));
		$this->msgtotal($data);
		return $data;
	}


	/**
	 * ��Ϣ����
	 */
	function messagedetail($param){
		$auth = $this->getAuth();
		$this->addLang('system', 'message');
		$jieqiLang['system'] = $this->getLang('system');
		if(empty($param['id'])) $this->printfail($jieqiLang['system']['message_no_exists']);
		$param['id']=intval($param['id']);
		$this->db->init('message','messageid','system');
		$message=$this->db->get($param['id']);
		if(!$message) $this->printfail($jieqiLang['system']['message_no_exists']);
		if($message['fromid'] != $auth['uid'] && $message['toid'] != $auth['uid']) $this->printfail($jieqiLang['system']['message_no_exists']);
		
		$data = array();
		$data['messageid'] = $param['id'];
		$data['title'] = $message['title'];
		if($message['fromid']>0){
			$data['fromsys'] = 0;
			$data['fromid'] = $message['fromid'];
			$data['fromname'] = $message['fromname'];
		}else{
			$data['fromsys'] = 1;
			$data['fromid'] = 0;
			$data['fromname'] = '';
		}
		if($message['toid']>0){
			$data['tosys'] = 1;
			$data['toid'] = $message['toid'];
			$data['toname'] = $message['toname'];
		}else{
			$data['tosys'] = 1;
			$data['toid'] = 0;
			$data['toname'] = '';
		}
		$data['postdate'] = date(JIEQI_DATE_FORMAT.' '.JIEQI_TIME_FORMAT, $message['postdate']);
		
		include_once(JIEQI_ROOT_PATH.'/lib/text/textconvert.php');
		$ts=TextConvert::getInstance('TextConvert');
		$data['content'] = $ts->makeClickable($message['content']);
		if($message['toid'] == $auth['uid']){//�ռ���
			if($message['fromid'] == 0) $data['url_reply'] = $this->geturl('system', 'userhub', 'SYS=method=newmessage&reid='.$param['id'].'&tosys=1');
			else $data['url_reply'] = $this->geturl('system', 'userhub', 'SYS=method=newmessage&reid='.$param['id']);
			$box='inbox';
		}else{//������
			$data['url_reply'] = '';
			$box='outbox';
		}
		$data['box'] = $box;
		$data['url_forward'] = $this->geturl('system', 'userhub', 'SYS=method=newmessage&fwid='.$param['id']);
		$data['url_delete'] = $this->geturl('system', 'userhub', 'SYS=method='.$box.'&delid='.$param['id']);		
		
		//�����Ѷ���־
		if($message['isread'] != 1 && $message['toid'] == $auth['uid']){			
			if ($this->db->edit($message['messageid'],array('isread'=>1))){
				    //�������Ϣ��ʾ
				    if(isset($_SESSION['jieqiNewMessage']) && $_SESSION['jieqiNewMessage'] > 0){
					$_SESSION['jieqiNewMessage'] = $_SESSION['jieqiNewMessage']-1;
					if ($_SESSION['jieqiNewMessage'] < 0) $_SESSION['jieqiNewMessage'] = 0;
					$jieqi_user_info=array();
					if(!empty($_COOKIE['jieqiUserInfo'])) $jieqi_user_info=jieqi_strtosary($_COOKIE['jieqiUserInfo']);
					else $jieqi_user_info=array();
					if(isset($jieqi_user_info['jieqiNewMessage']) && $jieqi_user_info['jieqiNewMessage']>0) $jieqi_user_info['jieqiNewMessage']=$jieqi_user_info['jieqiNewMessage']-1;
					if ($jieqi_user_info['jieqiNewMessage'] < 0) $jieqi_user_info['jieqiNewMessage'] = 0;
					if(!empty($jieqi_user_info['jieqiUserPassword'])) $cookietime=JIEQI_NOW_TIME + 22118400;
					else $cookietime=0;
					@setcookie('jieqiUserInfo', jieqi_sarytostr($jieqi_user_info), $cookietime, '/',  JIEQI_COOKIE_DOMAIN, 0);
				}
			}
		}
		return $data;		
	}
	/**
	 * �ж��Ƿ��͸��Լ�,ֱ����ʾ��
	 * @param unknown $receiver	�ռ���
	 */
	private function sendSelf($receiver){
		$this->addLang('system', 'message');
		$jieqiLang['system'] = $this->getLang('system');
		$auth = $this->getAuth();
		//useruname�û��� 
		//username ��ʵ����
		if($receiver == $auth['useruname'] || $receiver == $auth['username']){
			$this->printfail($jieqiLang['system']['message_nosend_self']);
		}
	}
	/**
	 * ����Ϣ����δ������Ϣ��
	 * <br>
	 * nowmsg������Ϣ�� | newmsg��δ����Ϣ����
	 * @param unknown $data
	 */
	function  msgtotal(&$data){
		$auth = $this->getAuth();
		$this->db->init('message','messageid','system');
		//�շ�����Ϣ��
		$sql="SELECT COUNT(*) AS msgnum FROM ".jieqi_dbprefix('system_message')." WHERE (fromid=".$auth['uid']." AND fromdel=0) OR (toid=".$auth['uid']." AND todel=0)";
		$res = $this->db->query($sql);
		$row = $this->db->getRow($res);
		$data['nowmsg'] = (int)$row['msgnum'];
		//δ����Ϣ��
		$sql="SELECT COUNT(*) AS msgnum FROM ".jieqi_dbprefix('system_message')." WHERE toid=".$auth['uid']." AND todel=0 AND isread=0";
		$res = $this->db->query($sql);
		$row = $this->db->getRow($res);
		$data['newmsg'] = (int)$row['msgnum'];
	}
	/**
	 * ���ר������ͨ��������ָ���Ķ���Ϣ��
	 * @param unknown $toid		
	 * @param unknown $toname
	 * @param unknown $title
	 * @param unknown $msg
	 * @return boolean
	 */
	function auditApproval($toid, $toname, $title, $msg){
		$auth = $this->getAuth();
		$this->db->init('message','messageid','system');
		$newMessage = array();
		$newMessage['siteid']= JIEQI_SITE_ID;
		$newMessage['postdate']= JIEQI_NOW_TIME;
		$newMessage['fromid']= $auth['uid'];
		$newMessage['fromname']= $auth['username'];
		$newMessage['toid']= $toid;
		$newMessage['toname']= $toname;
		$newMessage['title']= $title;
		$newMessage['content']= $msg;
		$newMessage['messagetype']= 0;
		$newMessage['isread']= 0;
		$newMessage['fromdel']= 0;
		$newMessage['todel']= 0;
		$newMessage['enablebbcode']= 1;
		$newMessage['enablehtml']= 0;
		$newMessage['enablesmilies']= 1;
		$newMessage['attachsig']=0;
		$newMessage['attachment']= 0;
		if($this->db->add($newMessage)) return true;
		else return false;
	}
	/**
	 * ������Ϣ��ֱ�ӷ��ͣ����߲ݸ���
	 * @param unknown $param
	 */
	function sendMsg($param){
		$auth = $this->getAuth();
		$users_handler = $this->getUserObject();
		$jieqiUsers = $users_handler->get($auth['uid']);
		$this->addLang('system', 'message');
		$jieqiLang['system'] = $this->getLang('system');
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		$this->addConfig('system','power');
		$jieqiPower['system'] = $this->getConfig('system','power');
		
		//ȡ�����ÿ�췢��Ϣ��
		$this->addConfig('system','honors');
		$jieqiHonors = $this->getConfig('system','honors');	
		$this->addConfig('system','right');
		$jieqiRight['system'] = $this->getConfig('system','right');
		
		$maxdaymsg=intval($jieqiConfigs['system']['maxdaymsg']);
		$honorid=jieqi_gethonorid($auth['score'], $jieqiHonors);
		if($honorid && isset($jieqiRight['system']['maxdaymsg']['honors'][$honorid]) && is_numeric($jieqiRight['system']['maxdaymsg']['honors'][$honorid])) $maxdaymsg = intval($jieqiRight['system']['maxdaymsg']['honors'][$honorid]);
		
		//���ÿ�췢��Ϣ��������������ƣ���������
		if(!empty($maxdaymsg)){
			//��ȡ�û������ѷ�������
			$userset=unserialize($jieqiUsers->getVar('setting','n'));
			$today=date('Y-m-d');
		}
		if(!isset($param['tosys']) || empty($param['tosys'])) $param['tosys']=false;
		$param['receiver']=trim($param['receiver']);
		$param['title']=trim($param['title']);
		$this->sendSelf($param['receiver']);
		$errtext='';
		if(strlen($param['receiver'])==0 && !$param['tosys']) $errtext.=$jieqiLang['system']['message_need_receiver'].'<br />';
		if(strlen($param['title'])==0) $errtext.=$jieqiLang['system']['message_need_title'].'<br />';
		if(!empty($maxdaymsg) && isset($userset['msgdate']) && $userset['msgdate']==$today && (int)$userset['msgnum']>=(int)$maxdaymsg && $jieqiConfigs['system']['sendmsgscore']>0){
			if($auth['score'] < $jieqiConfigs['system']['sendmsgscore']) $errtext.=$jieqiLang['system']['low_sendmsg_score'];
		}
		if(empty($errtext)) {
			$data = array();
			if(!$param['tosys']){
				$touser=$users_handler->getByname($param['receiver'],3);
				if(!$touser) $this->printfail($jieqiLang['system']['message_no_receiver']);//���޴���
				$data['toid'] = $touser->getVar('uid', 'n');
				//name ������ uname
				if(strlen($touser->getVar('name', 'n')) > 0) $data['toname'] = $touser->getVar('name', 'n');
				else $data['toname'] = $touser->getVar('uname', 'n');
			}else{//��������Ա
				$data['toid'] = 0;
				$data['toname'] = '';
			}
			$this->db->init('message','messageid','system');
			$data['siteid'] = JIEQI_SITE_ID;
			$data['postdate'] = JIEQI_NOW_TIME;
			$data['fromid'] = $auth['uid'];
			$data['fromname'] =$auth['username'];
			$data['title'] = htmlspecialchars($param['title'],ENT_QUOTES);
			$data['content'] = htmlspecialchars(trim($param['content']),ENT_QUOTES);
			//0 ֱ�ӷ��ͣ�1�ݸ���
			$data['messagetype'] = $param['typeid'] ?$param['typeid'] :0;
			$data['isread'] = 0;
			$data['fromdel'] = 0;
			$data['todel'] = 0;
			$data['enablebbcode'] = 1;
			$data['enablehtml'] = 0;
			$data['enablesmilies'] = 1;
			$data['attachsig'] = 0;
			$data['attachment'] = 0;
			//<!--jieqi insert license check-->
			if(!($this->db->add($data))) $this->printfail($jieqiLang['system']['message_send_failure']);
			else{
				if(!empty($maxdaymsg)){
					//��¼���շ��Ͷ�����
					if(isset($userset['msgdate']) && $userset['msgdate']==$today){
						$userset['msgnum']=(int)$userset['msgnum']+1;
					}else{
						$userset['msgdate']=$today;
						$userset['msgnum']=1;
					}
					$jieqiUsers->setVar('setting', serialize($userset));
					$jieqiUsers->saveToSession();
					$users_handler->insert($jieqiUsers);
					//���Ͷ��ſۻ���
					if(isset($userset['msgdate']) && $userset['msgdate']==$today && (int)$userset['msgnum']>=(int)$maxdaymsg && $jieqiConfigs['system']['sendmsgscore']>0){
						$users_handler->changeScore($auth['uid'], $jieqiConfigs['system']['sendmsgscore'], false, false);
					}
				}
				if($data['messagetype'] == 0){//0 ֱ�ӷ������ѷ��ͣ�1�ݸ������ݸ���
					$this->jumppage($this->geturl('system', 'userhub', 'SYS=method=outbox'), LANG_DO_SUCCESS, $jieqiLang['system']['message_send_seccess']);
				}else if ($data['messagetype'] == 1){
					$this->jumppage($this->geturl('system', 'userhub', 'SYS=method=draft'), LANG_DO_SUCCESS, $jieqiLang['system']['message_send_seccess']);
				}
			}
		}else{
			$this->printfail($errtext);
		}
	}
	/**
	 * ����Ϣ
	 * @param unknown $param
	 * @return multitype:number NULL unknown Ambigous <> boolean string
	 */
	function newmessage($param){
		$auth = $this->getAuth();
		if (empty($param['page'])) $param['page'] = 1;		
		$users_handler = $this->getUserObject();
		$jieqiUsers = $users_handler->get($auth['uid']);
		$this->addLang('system', 'message');
		$jieqiLang['system'] = $this->getLang('system');
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		$this->addConfig('system','power');
		$jieqiPower['system'] = $this->getConfig('system','power');
		//ȡ�����ÿ�췢��Ϣ��
		$this->addConfig('system','honors');
		$jieqiHonors = $this->getConfig('system','honors');	
		$this->addConfig('system','right');
		$jieqiRight['system'] = $this->getConfig('system','right');
		$maxdaymsg=intval($jieqiConfigs['system']['maxdaymsg']);
		$honorid=jieqi_gethonorid($auth['score'], $jieqiHonors);
		if($honorid && isset($jieqiRight['system']['maxdaymsg']['honors'][$honorid]) && is_numeric($jieqiRight['system']['maxdaymsg']['honors'][$honorid])) $maxdaymsg = intval($jieqiRight['system']['maxdaymsg']['honors'][$honorid]);
		//���ÿ�췢��Ϣ��������������ƣ���������
		if(!empty($maxdaymsg)){
			//��ȡ�û������ѷ�������
			$userset=unserialize($jieqiUsers->getVar('setting','n'));
			$today=date('Y-m-d');
		}
		if (!isset($param['action'])) $param['action'] = 'message';
		switch($param['action']) {
			case 'message'://����Ϣ��ͼ
			default:
				$data = array();
				//��������ѷ�����������ÿ�������Ϣ����ֱ����ʾ��ֹ���ͻ�����ʾ�۷�
				$sendneedscore=false;
				if(!empty($maxdaymsg) && isset($userset['msgdate']) && $userset['msgdate']==$today && (int)$userset['msgnum']>=(int)$maxdaymsg){
					if($jieqiConfigs['system']['sendmsgscore']>0){
						$sendneedscore=true;
					}else{
						$this->printfail(sprintf($jieqiLang['system']['day_message_limit'], $maxdaymsg));
					}
				}
				//���������Ϣ����������Ϣ��
				$this->addConfig('system','honors');
				$jieqiHonors = $this->getConfig('system','honors');	
				$this->addConfig('system','right');
				$jieqiRight['system'] = $this->getConfig('system','right');
				$maxmessage=$jieqiConfigs['system']['messagelimit'];
				$honorid=jieqi_gethonorid($auth['score'], $jieqiHonors);
				if($honorid && isset($jieqiRight['system']['maxmessages']['honors'][$honorid]) && is_numeric($jieqiRight['system']['maxmessages']['honors'][$honorid])) $maxmessage = intval($jieqiRight['system']['maxmessages']['honors'][$honorid]); //����ͷ�����õ���Ϣ��
				$this->db->init('message','messageid','system');
				$this->msgtotal($data);
					$data['maxdaymsg'] = $maxdaymsg;
					$data['maxmessage'] = $maxmessage;
					$data['url_newmessage'] = $this->geturl('system', 'userhub', 'SYS=method=newmessage&do=submit');
					$message=false;
					if(!empty($param['reid']) || !empty($param['fwid'])){
						if(!empty($param['reid'])){
							$this->db->init('message','messageid','system');
							$this->db->setCriteria();
							$this->db->criteria->add(new Criteria('messageid',$param['reid']));
							$this->db->queryObjects();
							$message = $this->db->getObject();
						}elseif(!empty($param['fwid'])){
							$this->db->init('message','messageid','system');
							$this->db->setCriteria();
							$this->db->criteria->add(new Criteria('messageid',$param['fwid']));
							$this->db->queryObjects();
							$message = $this->db->getObject();
						}
					}
					if(is_object($message)){
						$param['receiver']=$message->getVar('fromname', 'e');
						$param['title']=$message->getVar('title', 'e');
						if(!empty($param['reid'])){
							$param['title']='Re:'.$param['title'];
							$param['content']='';
						}elseif(!empty($param['fwid'])){
							$param['title']='Fw:'.$param['title'];
							$param['content']=$message->getVar('content', 'e');
							$param['receiver']='';
						}
					}elseif(!empty($param['event']) && $param['event']=='applywriter'){
						if(empty($param['title'])) $param['title']=$jieqiLang['system']['message_appay_writer'];
						if(empty($param['content'])) $param['content']=$jieqiLang['system']['message_apply_reason'];
					}
					if(!isset($param['receiver'])) $param['receiver']='';
					if(!isset($param['title'])) $param['title']='';
					if(!isset($param['content'])) $param['content']='';
					if(isset($param['tosys']) && $param['tosys']==1){
						$data['tosys'] = 1;
						$data['receiver'] = $jieqiLang['system']['message_site_admin'];
					}else{
						$data['tosys'] = 0;
						$data['receiver'] = $param['receiver'];
					}
					$data['title'] = $param['title'];
					$data['content'] = $param['content'];
		
					if($sendneedscore){
						$data['needscore'] = 1;
						$data['sendmsgscore'] = $jieqiConfigs['system']['sendmsgscore'];
					}else{
						$data['needscore'] = 0;
					}
				//ѡ�����
				$this->db->init('users','uid','system');
				$this->db->setCriteria();
				$this->db->criteria->setTables($this->dbprefix('system_users').' as u ');
				$this->db->criteria->setFields('*,(select count(*) from '.$this->dbprefix('system_friends').' where yourid = u.uid ) as num ');			
				$this->db->criteria->add(new Criteria('u.uid','(select f.yourid from jieqi_system_friends AS f where f.myid ='.$auth['uid'].')','IN'));
				$p='[prepage]<a rel="nofollow" href="javascript:;" onclick="return showfriend(this,\'{$prepage}\',1)" id="'.$param['mid'].'">��һҳ</a>[/prepage][pages][pnum]6[/pnum][pnumchar] <em class="b">{$page}</em>[/pnumchar][pnumurl]<A href="javascript:;" onclick="return showfriend(this,\'{$pnumurl}\',1)" id="'.$param['mid'].'">{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]<a href="javascript:;" onclick="return showfriend(this,\'{$nextpage}\',1)" id="'.$param['mid'].'">��һҳ</a>[/nextpage] <em class="pr10">��{$page}/{$totalpage}ҳ</em>';
				$data['friendsrows'] = $this->db->lists($jieqiConfigs['system']['friendspnum'],$param['page'],$p);
				$data['url_jumppage'] = $this->db->getPage($this->getUrl('system','userhub','method=getfriend','evalpage=0','SYS=mid='.$param['mid']));
				$data['nowfriends'] = $this->db->getVar('totalcount');
				$data['mid'] = $param['mid'];
				$data['uid'] = $auth['uid'];
				return $data;
				
		}		
	}
}
?>