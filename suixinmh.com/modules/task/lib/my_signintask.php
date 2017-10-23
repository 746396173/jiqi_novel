<?php
include_once ($GLOBALS['jieqiModules']['task']['path'] . '/class/TaskBase.php');
/**
 * ǩ������ģ�飺�̳���TaskBase������
 * @author liuxiangbin
 * @version 0.1
 */
 class MySignintask extends TaskBase {
 	// �Զ�������ֶ�
 	protected $_rules = array(7,15,99);
	// �Զ��影�������ֶ�
 	protected $_rewards = array(
		array('reward'=>'egold', 'name'=>'�麣��', 'number'=>'10'),
		array('reward'=>'esilver', 'name'=>'��ȯ', 'number'=>'100'),
		array('reward'=>'score', 'name'=>'����', 'number'=>'100')
	);
	
	/**
	 * ʵ�ַ������û��Ƿ���������
	 */
	protected function haveAchevable($uid, $tid) {
		// ��ȡ��ǰ�������
		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', $tid, '='));
//		$this->db->criteria->setFields('rule');
		$tmpRule = $this->db->lists();
		// д�뱾�ι���������в�������
		$this->_params['own_rules'] = json_decode($tmpRule[0]['rule'], true);
		$this->_params['own_rewards'] = json_decode($tmpRule[0]['rewards'], true);
		// ��ȡ�û�ǩ����¼
		$now_time = time();
		$thisMonth = date('Ym', $now_time);
		$thisDay = date('d', $now_time);
		$this->db->init('signin', 'sid', 'task');
		$this->db->setCriteria(new Criteria('uid', $uid, '='));
		$this->db->criteria->add(new Criteria('month', $thisMonth, '='));
		$this->db->criteria->setFields('days');
		$sign_days = $this->db->lists();	
		if (empty($sign_days)) {
			return false;
		} else {
			// �����û����µ�ǩ������
			$user_sdays = count(array_filter(explode(',',$sign_days[0]['days'])));
			if (in_array($user_sdays, $this->_params['own_rules'])) {
				// д��������в�������
				$this->_params['own_signs'] = $user_sdays;
				return true;
			} else {
				// ������ĩ���һ����ж�
				$tomorrow = date('d', $now_time+(24*3600));
				if ($thisDay>$tomorrow && $thisDay==$user_sdays+1) {
					$this->_params['own_signs'] = 99;
					// ��ĩ���һ���򷵻ؿ�ִ�в���
					return true;
				}
				// ���򲻿����
				return false;
			}
		}
	}

	/**
	 * �ж��Ƿ������
	 */
	protected function haveFinished($uid, $tid) {
		// �������԰�
		$this->addLang('task','task');
		$jieqiLang['task'] =  $this->getLang('task');
		// ��õ�ǰ����ɼ�¼
		$month_Ym = date('Ym', JIEQI_NOW_TIME);
		$first_day = $this->getTime('month');
		$this->db->init('complete', 'tcid', 'task');
		$this->db->setCriteria(new Criteria('userid', $uid, '='));
		$this->db->criteria->add(new Criteria('taskid', $tid, '='));
		// ֻ�жϱ��¼�¼
		$this->db->criteria->add(new Criteria('createtime', $first_day, '>='));
		$tmp = $this->db->lists();
//		$this->dump($tmp, 0);
		if (empty($tmp)) {
			return false;
		} else {
			// ��¼��ֵ����������
			$this->_params['own_records'] = $tmp[0]['records'];
			$user_signs = 0;
			// ����ڲ����������û�ǩ����¼��ֱ�Ӹ�ֵ��������������ѯһ���û�ǩ����
			if (isset($this->_params['own_signs'])) {
				$user_signs = $this->_params['own_signs'];
			} else {
				// ��ȡ�û�ǩ����¼
				$this->db->init('signin', 'sid', 'task');
				$this->db->setCriteria(new Criteria('uid', $uid, '='));
				$this->db->criteria->add(new Criteria('month', $month_Ym, '='));
				$this->db->criteria->setFields('days');
				$sign_days = $this->db->lists();	
				$user_sdays = count(array_filter(explode(',',$sign_days[0]['days'])));
				if (empty($sign_days)) {
					// ����ֵӦ����ʾ����
					return array('status'=>'ER01', 'msg'=>$jieqiLang['task']['task_not_complete']);
				} else {
					// ���ǩ���������ڵ�����������������
					if ($this->getTime('month')==$user_sdays) {
						$user_signs = 99;
					} else {
						$user_signs = $user_sdays;
					}
				}
			}
			// �ж��߼�
			$finish_data = json_decode($tmp[0]['finish'], true);
			$this->_param['own_finish'] = $finish_data;
			if (in_array($user_signs, $finish_data)) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	/**
	 * ������ɱ��
	 */
	protected function finishGroup($params) {
		// ��õ�ǰ��ɵ��ۼ�����
		$total_days = $this->_params['own_signs'];
		// ������Ҫд����������
		$finish_data = $this->_param['own_finish'];
		// ����������
		$finish_data[] = $total_days;
//		$this->dump($this->_params);
		return json_encode($finish_data);
	}
	
	/**
	 * д��������������
	 */
	protected function recordsGroup($params) {
		$this_month = date('m', JIEQI_NOW_TIME);
		$this_year = date('Y', JIEQI_NOW_TIME);
		// ���ݺ������������ڸ�ֵ
		if ($this->_params['own_signs'] == 99) 
			$own_sign_days = cal_days_in_month(CAL_GREGORIAN, intval($this_month), intval($this_year));
		else 
			$own_sign_days = $this->_params['own_signs'];
		if ($this->_params['own_records']=='')
			$str = '';
		else 
			$str = $this->_params['own_records'];
		// ���齱������
		switch ($this->_params['own_rewards'][$own_sign_days]['reward']) {
			case 'esilver'	:
				$rewards_name = '��ȯ';break;
			case 'egold'	:
				$rewards_name = '�麣��';break;
			case 'score'	:
				$rewards_name = '����';break;
		}
		$str .= '��������ۼ�ǩ��'.$own_sign_days.'������񣬻���'.$this->_params['own_rewards'][$this->_params['own_signs']]['number'].$rewards_name.'��';
		return $str;
	}
	
	/**
	 * ���ӽ����ľ������ݿ����
	 */
	protected function addReward($params) {
		$uid = $this->_userCheck();
 		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', $params['tid'], '='));
		$this->db->criteria->setFields('rewards');
		$tmp = $this->db->lists();
		$thisRewards = json_decode($tmp[0]['rewards'], true);
		$this->db->init('users', 'uid', 'system');
		$this->db->setCriteria(new Criteria('uid', $uid, '='));
		$tmp_user = $this->db->lists();
		$user_sum = $tmp_user[0][$thisRewards[$this->_params['own_signs']]['reward']];
		$add_data = array(
			$thisRewards[$this->_params['own_signs']]['reward'] => $user_sum + $thisRewards[$this->_params['own_signs']]['number']
		);
		$this->db->edit($uid, $add_data);
	}
	
	/**
	 * ���html��ʽ�Ĺ���(��д����)
	 */
	public function setRuleHtml() {
		$htmls = '';
		$htmls .= '<tr class="sign_option"><th class="td_title">�������</th><td class="td_contents">';
		foreach ($this->_rules as $key => $val) {
			$htmls .= '<label>����:</label><input readonly="true" style="width: 40px" name="rule[]" placeholder="����:3" value="'.$val.'" />&nbsp;&nbsp;<label>����:</label><select name="rewards['.$val.'][reward]">';
			foreach ($this->_rewards as $k => $v) {
				$htmls .= '<option value="'.$v['reward'].'">'.$v['name'].'</option>';
			}
			$htmls .= '</select>&nbsp;&nbsp;<input style="width: 80px" class="text" type="text" name="rewards['.$val.'][number]" placeholder="����:5000" /><br />';
		}
		$htmls .= '</td><td class="td_span"><span>*99���ʾ��ĩ���һ��</span></td></tr>';
		return $htmls;
	}
	
	/**
	 * ���html��ʽ�Ľ���(��д����)
	 */
	public function setRewardsHtml() {
		$htmls = '';
		return $htmls;
	}
	
	/**
	 * �Զ��巽��������չ
	 */
	public function getRuleHtml($params) {
		$htmls = '';
		return $htmls;
	}
	
	/**
	 * ���html��ʽ�Ľ���(��д����)
	 */
	public function getRewardsHtml($params) {
		$htmls = '';
		$htmls .= '<tr class="sign_option"><th class="td_title">�������</th><td class="td_contents">';
		foreach ($params as $key => $val) {
			$htmls .= '<label>����:</label><input readonly="true" style="width: 40px" name="rule[]" placeholder="����:3" value="'.$key.'" />&nbsp;&nbsp;<label>����:</label><select name="rewards['.$key.'][reward]">';
			foreach ($this->_rewards as $k => $v) {
				if ($val['reward'] == $v['reward']) {
					$htmls .= '<option value="'.$v['reward'].'" selected="selected">'.$v['name'].'</option>';
				} else {
					$htmls .= '<option value="'.$v['reward'].'">'.$v['name'].'</option>';
				}
			}
			$htmls .= '</select>&nbsp;&nbsp;<input style="width: 80px" class="text" type="text" name="rewards['.$key.'][number]" placeholder="����:5000" value="'.$val['number'].'" /><br />';
		}
		$htmls .= '</td><td class="td_span"><span>*99���ʾ�������ǩ��</span></td></tr>';
		return $htmls;
	}
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 