<?php
include_once ($GLOBALS['jieqiModules']['task']['path'] . '/class/TaskBase.php');

/**
 * �ͻ��˵�½ģ�飺�̳���TaskBase������
 * @author zhangxue
 * @version 0.1
 */
 class MyApplogintask extends TaskBase {
 	
	// ʵ�ֵ�ǰ�Զ�����Ĺ�������
	protected $_rules = array(
		// keyΪ�����Ӧ�����ƣ�valueΪĬ��ֵ
//		'field'	=> array(
//			'isvip' => 'VIP�ȼ�',
//			'score' => '�ƺŵȼ�'
//		)
	);
	
	// ʵ�ֵ�ǰ�Զ�����Ľ�����������
	protected $_rewards = array(
	);
	
	/**
	 * ������ɱ��
	 */
	protected function finishGroup($params) {
		return 'finished';
	}
 	
	/**
	 * ���ӽ���
	 */
 	protected function addReward($params) {//print_r($params);ֻ��tid
 		$uid = $params['uid'];
 		$this->db->init('users', 'uid', 'system');
		$this->db->setCriteria(new Criteria('uid', $uid));
		$res_uadd = $this->db->lists();
		// ѭ�����齱������
		$user_adds = array();
		$user_adds['egold'] = $res_uadd[0]['egold'] + 200;
		$this->db->edit($uid, $user_adds);
 	}
	
	/**
	 * �����ɹ���վ����
	 */
 	protected function addRewardAfter($params) {//$this->dump($params);ֻ��tid
		$users_handler = $this->getUserObject();
		$jieqiUsers = $users_handler->get($params['uid']);//print_r($jieqiUsers);exit;
		$uid = $jieqiUsers->getVar('uid');
		$uname = $jieqiUsers->getVar('uname', 'n');
			
		$this->db->init('message','messageid','system');
		$newMessage = array();
		$newMessage['siteid']= JIEQI_SITE_ID;
		$newMessage['postdate']= JIEQI_NOW_TIME;
		$newMessage['fromid']= 6;
		$newMessage['fromname']= 'ϵͳ����Ա';
		$newMessage['toid']= $uid;
		$newMessage['toname']= $uname;
		$newMessage['title']= '��¼�麣�ֻ��ͻ�������';
		$newMessage['content']= '�麣ӭ���������죬�ֻ��ͻ��������������ڻ�ڼ��¼�麣�ֻ��ͻ��ˣ�����200�麣�ң���ע����ա�';
		$newMessage['messagetype']= 0;
		$newMessage['isread']= 0;
		$newMessage['fromdel']= 0;
		$newMessage['todel']= 0;
		$newMessage['enablebbcode']= 1;
		$newMessage['enablehtml']= 0;
		$newMessage['enablesmilies']= 1;
		$newMessage['attachsig']=0;
		$newMessage['attachment']= 0;
		$this->db->add($newMessage);	
 	}
	
	/**
	 * ʵ�ַ������û��Ƿ���������
	 */
	protected function haveAchevable($uid, $tid) {
		$stime = 1422720000;
		$etime = 1423584000;
		if(JIEQI_NOW_TIME>=$stime && JIEQI_NOW_TIME<$etime) return true;
		else return false;
	}
	
	/**
	 * �ж��Ƿ�����ɣ��ж��Ƿ������
	 */
	protected function haveFinished($uid, $tid) {
		$this->db->init('complete', 'tcid', 'task');
		$this->db->setCriteria(new Criteria('userid', $uid));
		$this->db->criteria->add(new Criteria('taskid', $tid));
		$finish = $this->db->lists();//print_r($finish);
		if (!empty($finish)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ���html��ʽ�Ĺ���(��д����)
	 */
	public function getRuleHtml() {
		$htmls = 'qqqq';
//		$htmls .= '<tr class="sign_option"><th class="td_title">������֤��</th>';
//		$htmls .= '<td class="td_contents">sale+reward</td>';
//		$htmls .= '<td class="td_span"><span>*�����������û���</span></td></tr>';
		return $htmls;	
	}
	
	/**
	 * ���html��ʽ�Ľ���(��д����)
	 */
	public function getRewardsHtml($params) {
		$htmls = '';
//		$htmls .= '<tr class="sign_option"><th class="td_title">��������</th><td class="td_contents">';
//		$htmls .= '<input class="text" type="text" name="rewards[percentage]" value="'.$params['percentage'].'" />';
//		$htmls .= '</td><td class="td_span"><span>*��������ʾ</span></td></tr>';
		foreach ($params as $key => $val) {
			$htmls .= '<tr class="sign_option"><th class="td_title">������</th><td class="td_contents"><select name="rewards['.$key.'][reward]">';
			foreach ($this->_rewards as $k => $v) {
				if ($val['reward'] == $v['reward']) {
					$htmls .= '<option value="'.$v['reward'].'" selected="selected" >'.$v['name'].'</option>';
				} else {
					$htmls .= '<option value="'.$v['reward'].'">'.$v['name'].'</option>';
				}
			}
			$htmls .= '</select>&nbsp;&nbsp;<input class="text" type="text" name="rewards['.$key.'][percentage]" placeholder="���磺5000" value="'.$params[$key]['percentage'].'" />';
			$htmls .= '</td><td class="td_span"><span>*��д������ʽ</span></td></tr>';
		}
		return $htmls;
	}
	
	/**
	 * ���html��ʽ�Ľ���(��д����)
	 */
	public function setRewardsHtml() {
		$htmls = '';
		$htmls .= '<tr class="sign_option"><th class="td_title">������</th><td class="td_contents"><select name="rewards[0][reward]">';
		foreach ($this->_rewards as $k => $v) {
			$htmls .= '<option value="'.$v['reward'].'">'.$v['name'].'</option>';
		}
		$htmls .= '</select>&nbsp;&nbsp;<input class="text" type="text" name="rewards[0][percentage]" value="'.$this->_rewards[0]['percentage'].'" />';
		$htmls .= '</td><td class="td_span"><span>*��д������ʽ</span></td></tr>';
		return $htmls;
	}
	
	/**
	 * ���html��ʽ�Ĺ���(��д����)
	 */
	public function setRuleHtml() {
//		$this->addConfig('system', 'groups');
//		$groups = $this->getConfig('system', 'groups');
		$htmls = '';
//		$htmls .= '<tr class="sign_option"><td class="td_title">������֤��</td><td class="td_contents"><select name="rule[groupid]">';
//		foreach ($groups as $k => $v) {
//			$htmls .= '<option value="'.$k.'">'.$v.'</option>';
//		}
//		$htmls .= '</select></td><td class="td_span"><span>*�����������û���</span></td></tr>';
		return $htmls;
	}
	/*
	 * ��ɼ�¼�ı�ע�ֶ�
	 */
	protected function recordsGroup($params){
		$msg = '��ڼ��¼�麣�ֻ��ͻ��ˣ�����200�麣�ҡ�';
		return $msg;
	}
	/**
	 * �ͻ��˵�½����
	 */
	 public function isFinish($uid, $uname){
		if(JIEQI_NOW_TIME>=1422720000 && JIEQI_NOW_TIME<1423584000){
			$this->db->init('task', 'taskid', 'task');
			$this->db->setCriteria(new Criteria('type', 'applogin'));
			$task = $this->db->get($this->db->criteria);//print_r($task);exit;
			$tid = $task->getVar('taskid');
			
			$userFinished = $this->haveFinished($uid, $tid);
			if ($userFinished) {
				
			} else {
				$thisAddTask = array(
					'userid' 		=> $uid,
					'taskid'			=> $tid,
					'finish'			=> $this->finishGroup($params),
					'createtime'		=> JIEQI_NOW_TIME,
					'records'		=> $this->recordsGroup($params)
				);
				$this->db->init('complete', 'tcid', 'task');
				$this->db->add($thisAddTask);
				
				$users_handler =  $this->getUserObject();
				$ret=$users_handler->income($uid, 200);	//���죬����income
				if($ret){
					$this->db->init('message','messageid','system');
					$newMessage = array();
					$newMessage['siteid']= JIEQI_SITE_ID;
					$newMessage['postdate']= JIEQI_NOW_TIME;
					$newMessage['fromid']= 6;
					$newMessage['fromname']= 'ϵͳ����Ա';
					$newMessage['toid']= $uid;
					$newMessage['toname']= $uname;
					$newMessage['title']= '��¼�麣�ֻ��ͻ�������';
					$newMessage['content']= '�麣ӭ���������죬�ֻ��ͻ��������������ڻ�ڼ��¼�麣�ֻ��ͻ��ˣ�����200�麣�ң���ע����ա�';
					$newMessage['messagetype']= 0;
					$newMessage['isread']= 0;
					$newMessage['fromdel']= 0;
					$newMessage['todel']= 0;
					$newMessage['enablebbcode']= 1;
					$newMessage['enablehtml']= 0;
					$newMessage['enablesmilies']= 1;
					$newMessage['attachsig']=0;
					$newMessage['attachment']= 0;
					$this->db->add($newMessage);	
				}
			}
		}
	 }
}
?>
 
 
 
 
 
 
 
 
 