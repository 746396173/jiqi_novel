<?php
include_once ($GLOBALS['jieqiModules']['task']['path'] . '/class/TaskBase.php');
/**
 * ǩԼ����ģ�飺�̳���TaskBase������
 * @author liuxiangbin
 * @version 0.1
 */
class MySigntask extends TaskBase {

	// ʵ�ֵ�ǰ�Զ�����Ĺ�������
	protected $_rules = array(
	// keyΪ�����Ӧ�����ƣ�valueΪĬ��ֵ
	'groupid' => '0');

	// ʵ�ֵ�ǰ�Զ�����Ľ�����������
	protected $_rewards = array(
	// ��ʽ�����Զ��壬ֻҪ�Լ��ܿ���
	array('reward' => 'egold', 'name' => '�麣��', 'number' => '10'), array('reward' => 'esilver', 'name' => '��ȯ', 'number' => '100'));

	/**
	 * ������ɱ��
	 */
	protected function finishGroup($params) {
		return 'finished';
	}

	/**
	 * д��������������
	 */
	protected function recordsGroup($params) {
		$this -> addConfig('system', 'groups');
		$groups = $this -> getConfig('system', 'groups');
		// ���齱������
		if ($this -> _params['own_rewards'][0]['reward'] == 'egold') {
			$rewards_name = '�麣��';
		} else if ($this -> _params['own_rewards'][0]['reward'] == 'esilver') {
			$rewards_name = '��ȯ';
		}
		$str = '';
		$str .= "�����ǩԼ" . $groups[$this -> _params['own_rules']['groupid']] . '���񣬻���' . $this -> _params['own_rewards'][0]['number'] . $rewards_name . "��";
		return $str;
	}

	/**
	 * ���ӽ���
	 */
	protected function addReward($params) {
		if (isset($this -> _params['own_rewards'])) {
			$thisRewards = $this -> _params['own_rewards'];
		} else {
			$this -> db -> init('task', 'taskid', 'task');
			$this -> db -> setCriteria(new Criteria('taskid', $params['tid'], '='));
			$this -> db -> criteria -> setFields('rewards');
			$tmp = $this -> db -> lists();
			$thisRewards = json_decode($tmp[0]['rewards'], true);
		}
		$uid = $this -> _userCheck();
		$this -> db -> init('users', 'uid', 'system');
		$this -> db -> setCriteria(new Criteria('uid', $uid, '='));
		$res_uadd = $this -> db -> lists();
		// ѭ�����齱������
		$user_adds = array();
		foreach ($thisRewards as $k => $v) {
			$user_adds[$v['reward']] = $res_uadd[0][$v['reward']] + $v['number'];
		}
		$this -> db -> edit($uid, $user_adds);
	}

	/**
	 * ʵ�ַ������û��Ƿ���������
	 */
	protected function haveAchevable($uid, $tid) {
		$this -> db -> init('task', 'taskid', 'task');
		$this -> db -> setCriteria(new Criteria('taskid', $tid, '='));
		$tmpRule = $this -> db -> lists();
		$rules = json_decode($tmpRule[0]['rule'], true);
		$this -> _params['own_rewards'] = json_decode($tmpRule[0]['rewards'], true);
		$this -> _params['own_rules'] = $rules;
		$this -> db -> init('users', 'uid', 'system');
		$this -> db -> setCriteria(new Criteria('uid', $uid, '='));
		$this -> db -> criteria -> setFields('groupid');
		$gid = $this -> db -> lists();
		if (empty($gid)) {
			return false;
		} else if ($gid[0]['groupid'] != $rules['groupid']) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * �ж��Ƿ������
	 */
	protected function haveFinished($uid, $tid) {
		$this->db->init('complete', 'tcid', 'task');
		$this->db->setCriteria(new Criteria('userid', $uid, '='));
		$this->db->criteria->add(new Criteria('taskid', $tid, '='));
		$this->db->criteria->setFields('finish');
		$finish = $this->db->lists();
		if (!empty($finish)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * �����ɹ���վ����
	 */
 	protected function addRewardAfter($params) {
		$this->addLang('task','msg');
		$this->jieqiLang['task'] =  $this->getLang('task'); 
		$auth = $this->getAuth();	
		// ����Ⱥ�����
		$this -> addConfig('system', 'groups');
		$groups = $this -> getConfig('system', 'groups');
		// ���齱������
		if ($this -> _params['own_rewards'][0]['reward'] == 'egold') {
			$rewards_name = '�麣��';
		} else if ($this -> _params['own_rewards'][0]['reward'] == 'esilver') {
			$rewards_name = '��ȯ';
		}
		$this->db->init('message','messageid','system');
		$newMessage = array();
		$newMessage['siteid']= JIEQI_SITE_ID;
		$newMessage['postdate']= JIEQI_NOW_TIME;
		$newMessage['fromid']= 6;
		$newMessage['fromname']= 'ϵͳ����Ա';
		$newMessage['toid']= $auth['uid'];
		$newMessage['toname']= $auth['useruname'];
		$newMessage['title']= sprintf($this->jieqiLang['task']['sign_writer_title'], $groups[$this -> _params['own_rules']['groupid']]);
		$newMessage['content']= sprintf($this->jieqiLang['task']['sign_writer_text'], $groups[$this -> _params['own_rules']['groupid']],$this -> _params['own_rewards'][0]['number'], $rewards_name);
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
	 * ���html��ʽ�Ĺ���(��д����)
	 */
	public function setRuleHtml() {
		$this -> addConfig('system', 'groups');
		$groups = $this -> getConfig('system', 'groups');
		$htmls = '';
		$htmls .= '<tr class="sign_option"><th class="td_title">������֤��</th><td class="td_contents"><select name="rule[groupid]">';
		foreach ($groups as $k => $v) {
			$htmls .= '<option value="' . $k . '">' . $v . '</option>';
		}
		$htmls .= '</select></td><td class="td_span"><span>*�����������û���</span></td></tr>';
		return $htmls;
	}

	/**
	 * ���html��ʽ�Ľ���(��д����)
	 */
	public function setRewardsHtml() {
		$htmls = '';
		$htmls .= '<tr class="sign_option"><th class="td_title">������</th><td class="td_contents"><select name="rewards[0][reward]">';
		foreach ($this->_rewards as $k => $v) {
			$htmls .= '<option value="' . $v['reward'] . '">' . $v['name'] . '</option>';
		}
		$htmls .= '</select>&nbsp;&nbsp;<input class="text" type="text" name="rewards[0][number]" placeholder="���磺5000" />';
		$htmls .= '</td><td class="td_span"><span>*��д������ʽ</span></td></tr>';
		return $htmls;
	}

	/**
	 * �Զ��巽��������չ
	 */
	public function getRuleHtml($params) {
		$this -> addConfig('system', 'groups');
		$groups = $this -> getConfig('system', 'groups');
		$htmls = '';
		$htmls .= '<tr class="sign_option"><th class="td_title">������֤��</th><td class="td_contents"><select name="rule[groupid]">';
		foreach ($groups as $k => $v) {
			if ($params['groupid'] == $k) {
				$htmls .= '<option value="' . $k . '" selected="selected"">' . $v . '</option>';
			} else {
				$htmls .= '<option value="' . $k . '">' . $v . '</option>';
			}
		}
		$htmls .= '</select></td><td class="td_span"><span>*�����������û���</span></td></tr>';
		return $htmls;
	}

	/**
	 * ���html��ʽ�Ľ���(��д����)
	 */
	public function getRewardsHtml($params) {
		$htmls = '';
		foreach ($params as $key => $val) {
			$htmls .= '<tr class="sign_option"><th class="td_title">������</th><td class="td_contents"><select name="rewards[' . $key . '][reward]">';
			foreach ($this->_rewards as $k => $v) {
				if ($val['reward'] == $v['reward']) {
					$htmls .= '<option value="' . $v['reward'] . '" selected="selected" >' . $v['name'] . '</option>';
				} else {
					$htmls .= '<option value="' . $v['reward'] . '">' . $v['name'] . '</option>';
				}
			}
			$htmls .= '</select>&nbsp;&nbsp;<input class="text" type="text" name="rewards[' . $key . '][number]" placeholder="���磺5000" value="' . $params[$key]['number'] . '" />';
			$htmls .= '</td><td class="td_span"><span>*��д������ʽ</span></td></tr>';
		}
		return $htmls;
	}

}
