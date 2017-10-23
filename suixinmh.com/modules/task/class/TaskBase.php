<?php
/**
 * �������ģ������ࣺ������������Զ�����Ķ�����
 * ʹ��˵�����ھ���ʵ��ʱ������ʵ�ֳ��󷽷�
 * @Create_Time: 2015-01-12 10:19:30
 * @Author:liuxiangbin
 */
abstract class TaskBase extends JieqiObject{
	
	// �ڲ�ʹ�õĲ�������
	protected $_params = array();
	// ��ʼʱ���жϱ��
	protected $_stime = false;
	// ����ʱ���жϱ��
	protected $_etime = false;
	// ��ʾ/���ؿ��ر��
	protected $_isshow = false;
	// ��ǰ��������(����ʵ�ַ���)
	protected $_rules = array();
	// ��ǰ��������(����ʵ�ַ���)
	protected $_rewards = array();
	
	/**
	 * ���캯����ʼ��һ��db���ݿ����ģ��
	 */
	public function __construct() {
		if (! is_object ( $this->db )) {
			$this->db = Application::$_lib ['database'];
		}
	}
	
	/**��ǰ̨���÷���**/
	/**
	 * �ж��û��Ƿ���������
	 * @param	: $uid		�û�id
	 * @param	: $tid		����id
	 */
	public function isAchevable($tid) {
		// ����û��Ƿ��¼
		$uid = $this->_userCheck();
		// ���þ������
		$thisRule = $this->haveAchevable($uid, $tid);
		if ($thisRule) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * �����û��������
	 * @param	: $params	����������
	 */
	public function setFinish($params, $is_add = false) {
		$this->addLang('task','task');
		$jieqiLang['task'] =  $this->getLang('task');
		if(isset($params['uid']))
			$uid = $params['uid'];
		else 
			$uid = $this->_userCheck();
		// �ж��û��Ƿ�����������
		if (!$this->isAchevable($params['tid']))
			return array('status'=>'ER01', 'msg'=>$jieqiLang['task']['task_not_complete']);
		// ��֤�������Ƿ��Ѿ�������ɼ�¼
		$userIsFinished = $this->isFinished($params['tid']);
		if ($userIsFinished) 
			return array('status'=>'ER02', 'msg'=>$jieqiLang['task']['task_has_complete']);
		// д���û�������ɼ�¼
		$thisAddTask = array(
			'userid' 		=> $uid,
			'taskid'			=> $params['tid'],
			'finish'			=> $this->finishGroup($params),
			'createtime'		=> JIEQI_NOW_TIME,
			'records'		=> $this->recordsGroup($params)
			
		);
		$this->db->init('complete', 'tcid', 'task');
		$this->db->setCriteria(new Criteria('userid', $uid, '='));
		$this->db->criteria->add(new Criteria('taskid', $params['tid'], '='));
		$res_com = $this->db->lists();
		// �����¼������Ϊ���¼�¼��������״̬�������½�һ����¼
		if (!empty($res_com) && date('Ym', JIEQI_NOW_TIME)==date('Ym', $res_com[0]['createtime'])) {
			// �������ǿ������complete��¼�ı�ʶ����ǿ��insertһ���¼�¼
			if ($is_add) {
				$this->db->add($thisAddTask);
			} else {
				$update = array('finish'=>$thisAddTask['finish'], 'records'=>$thisAddTask['records']);
				$this->db->edit($res_com[0]['tcid'], $update);
			}
		} else {
			$this->db->add($thisAddTask);
		}
		$this->addReward($params);
		$this->addRewardAfter($params);
		return array('status'=>'OK');
	}

	/**
	 * �ж��û��Ƿ����������
	 * @param	: $uid		�û�id
	 * @param	: $tid		����id
	 */
	public function isFinished($tid) {
		// ����û��Ƿ��¼
		$uid = $this->_userCheck();
		// ����������ɼ�¼��������֤
		$userFinished = $this->haveFinished($uid, $tid);
		if ($userFinished) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ��ȡ��ǰ�Զ�����Ĺ�������
	 */
	public function getRules($isHtml = false, $htmlType = 1) {
		if (empty($this->_rules))
			return false;
		// ����html��ʽ
		if ($isHtml) {
			return $this->setRuleHtml($htmlType);
		}
		return $this->_rules;
	}
	
	/**
	 * ��ȡ��ǰ�Զ�����Ľ�������
	 */
	public function getRewards($isHtml = false, $htmlType = 1) {
		if (empty($this->_rewards))
			return false;
		// ����html��ʽ
		if ($isHtml) {
			return $this->setRewardsHtml($htmlType);
		}
		return $this->_rewards;
	}
	
	/**
	 * ���ص�ǰ�Զ������ʱ���ж�״̬
	 */
	public function getTimeRule() {
		return array('stime'=>$this->_stime, 'etime'=>$this->_etime);
	}
	
	
	/**
	 * �����Զ��������˺���������
	 */
	public function getTaskForm($params, $isAdd = true) {
		$reData = array();
		$this->filterTask($params);
		$reData = array(
			'type'			=> $this->_params['type'],
			'taskname'		=> $this->_params['taskname'],
			'description'	=> $this->_params['description'],
			'rule'			=> json_encode($this->_params['rule']),
			'rewards'		=> json_encode($this->_params['rewards']),
			'isshow'			=> $this->_params['isshow']
		);
		if ($this->_stime == true) 
			$reData['starttime'] = $this->_params['starttime'];
		if ($this->_etime == true)
			$reData['endtime'] = $this->_params['endtime'];
		if ($isAdd)
			$reData['createtime'] = time();
		return $reData;
	}
	
	/**���ڲ���װ����**/
	/**
	 * ��֤�û�Ȩ��
	 * @param	: $uid		�û�id
	 * @param	: $isAdmin	��̨Ȩ����Ϊtrue
	 */
	protected function _userCheck($isAdmin = false) {
		// TODO::��֤ǰ̨�û����ǹ���Ա����½Ȩ��
		$auth = $this->getAuth();
		if (!isset($auth['uid']) || intval($auth['uid'])<=0) 
			$this->checkLogin();
		$uid = $auth['uid'];
		if (!$isAdmin) {
			return $uid;
		} else {
			// TODO::��̨������Ȩ����
		}
	}
	
	/**
	 * ���˷�����Ĭ��ʹ��htmlspecialchars��trim���ˣ�����������ʽ�򼯳ɲ���ӹ��򼴿�
	 */
	protected function filterTask($params = array()) {
		if (empty($params)) 
			return true;
		// ���˹���Ĭ�Ϲ��򣬿���д��
		foreach ($params as $k => $v) {
			if (!is_array($v)) {
				$this->_params[$k] = htmlspecialchars(trim($v));
			} else {
				$this->_params[$k] = $v;
			}
		}
	}
	
	/**
	 * ����һ��html��ʽ�ķ�����
	 * ��չ��$type���������Զ��壬����type��ͬ�Ӷ����ò�ͬ��html��ʽ
	 */
	public function setRuleHtml($type = '') {
		// TODO::��Ҫ�Զ���
		return $this->_rules;
	}
		
	/**
	 * ����һ��html��ʽ�ķ�����
	 * ��չ��$type���������Զ��壬����type��ͬ�Ӷ����ò�ͬ��html��ʽ
	 */
	public function setRewardsHtml($type = '') {
		// TODO::��Ҫ�Զ���
		return $this->_rewards;
	}

	/**
	 * �û��������֮����¼��������������ʲôҲ����
	 */
	protected function addRewardAfter($params = array()) {
		// TODO::Ĭ��ʲô������
	}
	
	
	// *************������д�ĳ��󷽷�*****************
	
	// �û������������ӽ���(ֻ��������������)
	abstract protected function addReward($params);
	// ������������֤��ǰ�û��Ƿ����ɣ�������/�٣�
	abstract protected function haveAchevable($uid, $tid);
	// ���û��������д�����������ɸ�ʽ�����json_encodeѹ��
	abstract protected function finishGroup($params);
	// ����������д�����������������ݴ������ݿ�(�ַ���)
	abstract protected function recordsGroup($params);
	// �û��Ƿ�����ɾ�������Ĺ�����в�ͬ��������д
	abstract protected function haveFinished($uid, $tid);
}











