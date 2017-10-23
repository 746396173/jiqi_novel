<?php
include_once ($GLOBALS['jieqiModules']['task']['path'] . '/class/TaskBase.php');

/**
 * ��ֵ����ģ�飺�̳���TaskBase������
 * @author zhangxue
 * @version 0.1
 */
 class MyRechargetask extends TaskBase {
 	
	// ʵ�ֵ�ǰ�Զ�����Ĺ�������
	protected $_rules = array(
		// keyΪ�����Ӧ�����ƣ�valueΪĬ��ֵ
//		'groupid'			=> '0'
	);
	
	// ʵ�ֵ�ǰ�Զ�����Ľ�����������
	protected $_rewards = array(
		// ��ʽ�����Զ��壬ֻҪ�Լ��ܿ���
//		'percentage'	=> 0.05
		array('reward'=>'egold', 'name'=>'�麣��', 'percentage'=>0.05),
		array('reward'=>'esilver', 'name'=>'��ȯ', 'percentage'=>0.1)
	);
	
	/**
	 * ������ɱ��
	 */
	protected function finishGroup($params) {
		return date("Y-m-d H:i:s", JIEQI_NOW_TIME);
	}
 	
	/**
	 * ���ӽ���
	 */
 	protected function addReward($params) {//print_r($params);
   		$uid = $params['uid'];
		
 		$this->db->init('users', 'uid', 'system');
		$this->db->setCriteria(new Criteria('uid', $uid));
		$res_uadd = $this->db->lists();
		// ѭ�����齱������
		$user_adds = array();
		foreach ($thisRewards as $k => $v) {
			$user_adds[$this->_params['type']] = $res_uadd[0][$this->_params['type']] + $addesilver;
		}
		$this->db->edit($uid, $user_adds);
 	}
	
	/**
	 * �����ɹ���վ����
	 */
 	protected function addRewardAfter($params) {//$this->dump($params);
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
		$newMessage['title']= '��ֵ�ͺ��';
		$newMessage['content']= '������ж���������ֵ���ʹ����������γ�ֵ��XXԪ������'.$value.'�麣�ҡ�'.$value.'��ȯ����ע����ա�';
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
	 * ʵ�ַ������û��Ƿ��������񣬼������Ƿ񶩹��½ڻ����
	 */
	protected function haveAchevable($uid, $tid) {
//		else return false;
	}
	
	/**
	 * �ж��Ƿ������
	 */
	protected function haveFinished($uid, $tid) {
		return false;
	}
	
	/**
	 * ���html��ʽ�Ĺ���(��д����)
	 */
	public function getRuleHtml() {
		$htmls = '';
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
		$htmls .= '<tr class="sign_option"><th class="td_title">������1</th><td class="td_contents"><select name="rewards[0][reward]">';
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
//		$htmls = '';
//		$htmls .= '<tr class="sign_option"><td class="td_title">������֤��</td><td class="td_contents"><select name="rule[groupid]">';
//		foreach ($groups as $k => $v) {
//			$htmls .= '<option value="'.$k.'">'.$v.'</option>';
//		}
//		$htmls .= '</select></td><td class="td_span"><span>*�����������û���</span></td></tr>';
//		return $htmls;
	}
	/*
	 * ��ɼ�¼�ı�ע�ֶ�
	 */
	protected function recordsGroup($params){
		$msg = '���γ�ֵ��'.$params['reach'].'Ԫ������'.$params['value'].'�麣�ҡ�'.$params['value'].'��ȯ��';
		return $msg;
	}
	/*
	 * ��ȡ��ϸ������Ϣ�����ڱ�ע
	 */
	private function getReward($params){
 		$uid = $this->_userCheck();
 		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', $params['tid']));
		$this->db->criteria->setFields('rewards');
		$tmp = $this->db->lists();
		$thisRewards = json_decode($tmp[0]['rewards'], true);//print_r($thisRewards);//exit;
		$this->_params['type'] = $thisRewards[0]['reward'];
		$consumeegold = $this->haveAchevable($uid, $params['tid']);//echo $params['tid'];exit;
		$this->_params['consumeegold'] = $consumeegold;
		$addesilver = round($consumeegold*$thisRewards[0]['percentage'],2);
		$this->_params['addesilver'] = $addesilver;
	}
	/**
	 * ��ֵ�жϣ�income֮ǰ
	 */
	function judge($uid, $uname, $money){
		if(JIEQI_NOW_TIME>=1422720000 && JIEQI_NOW_TIME<1425139200){
			if($money>=2000 && $money<5000){
				$value = 200;
				$reach = 20;
			}else if($money>=5000 && $money<10000){
				$value = 500;
				$reach = 50;
			}else if($money>=10000){
				$value = 1000;
				$reach = 100;
			}
			if($value >0){
				$this->db->init('task', 'taskid', 'task');
				$this->db->setCriteria(new Criteria('type', 'recharge'));
				$task = $this->db->get($this->db->criteria);//print_r($task);exit;
				$tid = $task->getVar('taskid');
			
				$thisAddTask = array(
					'userid' 		=> $uid,
					'taskid'			=> $tid,
					'finish'			=> $this->finishGroup($params),
					'createtime'		=> JIEQI_NOW_TIME,
					'records'		=> '��ڼ��ֵ��'.$reach.'Ԫ������'.$value.'�麣�ҡ�'.$value.'��ȯ��'
				);
				$this->db->init('complete', 'tcid', 'task');
				$this->db->add($thisAddTask);
				
				$users_handler =  $this->getUserObject();
				$users_handler->income($uid, $value);
				$users_handler->income($uid, $value, 1);
//				if($ret){
					$this->db->init('message','messageid','system');
					$newMessage = array();
					$newMessage['siteid']= JIEQI_SITE_ID;
					$newMessage['postdate']= JIEQI_NOW_TIME;
					$newMessage['fromid']= 6;
					$newMessage['fromname']= 'ϵͳ����Ա';
					$newMessage['toid']= $uid;
					$newMessage['toname']= $uname;
					$newMessage['title']= '��ֵ�ͺ��';
					$newMessage['content']= '������ж���������ֵ���ʹ����������γ�ֵ��'.$reach.'Ԫ������'.$value.'�麣�ҡ�'.$value.'��ȯ����ע����ա�';
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
//				}
			}
			$this->db->init( 'paylog', 'payid', 'pay' );
		}
	}
}
?>
 
 
 
 
 
 
 
 
 