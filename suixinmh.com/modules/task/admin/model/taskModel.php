<?php
/**
 * ����ģ����
 * @author chengyuan
 *
 */
class taskModel extends Model{
	
	// �洢��ǰ���˵Ĳ�����
	protected $_params = array();
	// ��ǰģ�Ͳ�������
	protected $_taskType = '';
	// ���ﶨ�����������б�
	protected $_types = array(
		'sign'			=> 'ǩԼ����',
		'consume'		=> '������������',
		'vipup'			=> '��Ա��������',
		'signin'		=> '�ۼ�ǩ������',
		'applogin'		=> '�ͻ��˵�¼',
		'recharge'		=> '��ֵ����',
		'quest'			=> '�齱����'
	);
	// ���ò����ظ����������
	protected $_no_type = array('vipup', 'signin');
	
	/**
	 * �����б�
	 * @param unknown $params
	 */
	public function main($params) {
		$data = $this->getTaskList('main', $params['page']);
		return $data;
	}
	
	/**
	 * �첽����������
	 */
	public function getTaskRule($params, $isAjax = true) {
		$this->addLang('task','task');
		$jieqiLang['task'] =  $this->getLang('task');
		
		if (!isset($params['type']))
			$this->printfail($jieqiLang['task']['need_task_type']);
		$thisType = trim($params['type']);
		if (!array_key_exists($thisType, $this->_types))
			$this->printfail($jieqiLang['task']['task_type_error']);
		$reHtml = '';
		$taskLib = $this->load($thisType.'task', 'task');
		$reHtml .= $taskLib->getRules(true);
		$reHtml .= $taskLib->getRewards(true);
		if ($reHtml == '')
			$this->printfail($jieqiLang['task']['need_define_rule']);
		if ($isAjax) {
			$this->msgbox('', $reHtml);
		} else {
			return $reHtml;
		}
	}
	
	/**
	 * ���һ�������Ĭ�Ϸ���
	 */
	public function addTask($params) {
		$this->addLang('task','task');
		$jieqiLang['task'] =  $this->getLang('task');
		
		if (!isset($params['type']))
			$this->printfail($jieqiLang['task']['need_task_type']);
		$thisType = trim($params['type']);
		// �ֶ���֤
		if (trim($params['taskname'])=='' || mb_strlen($params['taskname'])>20)
			$this->printfail('�������Ʋ���Ϊ�ջ򳬹�20����');
		if (trim($params['description'])=='' || mb_strlen($params['description'])>200)
			$this->printfail('������������Ϊ�ջ򳬹�200����');
		// ǩ��������������һ��
		if (in_array($thisType, $this->_no_type)) {
			$this->db->init('task', 'taskid', 'task');
			$this->db->setCriteria(new Criteria('type', $thisType, '='));
			$res = $this->db->lists();
			if (!empty($res))
				$this->printfail($this->_types[$thisType].'�������ظ�����');
		}
		if (!array_key_exists($thisType, $this->_types))
			$this->printfail($jieqiLang['task']['task_type_error']);
		$data = array();
		$taskLib = $this->load($thisType.'task', 'task');
		$data = $taskLib->getTaskForm($params);
		$this->db->init('task', 'taskid', 'task');
		$this->db->add($data);
		$this->msgbox('', array('msg'=>LANG_DO_SUCCESS));
	}
	
	/**
	 * �༭һ�������Ĭ�Ϸ���
	 */
	public function editTask($params) {//$this->dump($params);
//		$uid = $this->_userCheck();
		$this->addLang('task','task');
		$jieqiLang['task'] =  $this->getLang('task');
		
		// ������֤
		if (!isset($params['type']))
			$this->printfail($jieqiLang['task']['need_task_type']);
		$thisType = trim($params['type']);
		// �ֶ���֤
		if (trim($params['taskname'])=='' || mb_strlen($params['taskname'])>20)
			$this->printfail('�������Ʋ���Ϊ�ջ򳬹�20����');
		if (trim($params['description'])=='' || mb_strlen($params['description'])>200)
			$this->printfail('������������Ϊ�ջ򳬹�200����');
		// ǩ��������������һ��
		if (in_array($thisType, $this->_no_type)) {
			$this->db->init('task', 'taskid', 'task');
			$this->db->setCriteria(new Criteria('type', $thisType, '='));
			$res = $this->db->lists();
			if ($params['taskid']!=$res[0]['taskid'])
				$this->printfail($this->_types[$thisType].'�������ظ�����');
		}
		if (!array_key_exists($thisType, $this->_types))
			$this->printfail($jieqiLang['task']['task_type_error']);
		// �������taskid
		if (!isset($params['taskid']) || intval($params['taskid'])==0) 
			$this->printfail($jieqiLang['task']['need_taskid']);
		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', intval($params['taskid'])));
		// ��֤�Ƿ���ڵ�ǰtaskid������
		if (!$this->db->getCount())
			$this->printfail($jieqiLang['task']['task_not_exists']);
		$data = array();
		$taskLib = $this->load($thisType.'task', 'task');
		$data = $taskLib->getTaskForm($params, false);
		$this->db->edit($params['taskid'], $data);
		$this->msgbox('', array('msg'=>LANG_DO_SUCCESS));
	}
	
	/**
	 * ɾ��һ�������Ĭ�Ϸ���
	 */
	public function delTask($params) {
		$this->addLang('task','task');
		$jieqiLang['task'] =  $this->getLang('task');
		
		// �������taskid
		if (!isset($params['taskid']) || intval($params['taskid'])==0) 
			$this->printfail($jieqiLang['task']['need_taskid']);
		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', intval($params['taskid'])));
		// ��֤�Ƿ���ڵ�ǰtaskid������
		if (!$this->db->getCount())
			$this->printfail($jieqiLang['task']['task_not_exists']);
		$this->db->delete(intval($params['taskid']));
		$this->msgbox('', array('msg'=>LANG_DO_SUCCESS));
	}
	
	
	/**
	 * ��������б��Ĭ�Ϸ���
	 * @param	string	: $methodName 	- ��ǰ���������ƣ���������page��ת��ַ
	 * @param	string	: $page 			- ��ǰҳ��
	 * @param	string	: $pageNum 		- ��ҳ�������ֶ����ã�Ĭ��ȡϵͳֵ
	 */
	public function getTaskList($methodName, $page = 1, $pageNum = 0) {
		// �����ҳ����
		$this->addConfig('article','configs');
    		$jieqiConfigs['article'] = $this->getConfig('article', 'configs');
		$pagenum = $jieqiConfigs['article']['pagenum'];
		// ��ʼ����ǰҳ��
		$thisPage = intval($page)<=0 ? 1 : $page;
		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->setSort('createtime');
        $this->db->criteria->setOrder('DESC');
		$thisController = ($_REQUEST['controller']) ? $_REQUEST['controller'] : 'taskController';
		$data['lists'] = $this->db->lists($pagenum, $thisPage, JIEQI_PAGE_TAG);
		if (empty($data)) 
			return $data;
		$reData = $data;
		foreach ($data['lists'] as $k => $v) {
			$reData['lists'][$k]['rule'] = json_decode($v['rule'], true);
			$reData['lists'][$k]['rewards'] = json_decode($v['rewards'], true);
		}
		$reData['url_jumppage'] = $this->db->getPage($this->getUrl(JIEQI_MODULE_NAME, $thisController,'evalpage=0','SYS=method='.$methodName));
		return $reData;
	}
	
	/**
	 * ���һ����¼
	 */
	public function getOneTask($params, $isAjax = true) {
		$this->addLang('task','task');
		$jieqiLang['task'] =  $this->getLang('task');
		
		if (intval($params['tid'])<=0)
			$this->printfail($jieqiLang['task']['need_taskid']);
		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', intval($params['tid'])));
		$res = $this->db->lists();
		if (empty($res))
			$this->printfail($jieqiLang['task']['task_not_exists']);
		$reData = array(
			'taskid'		=> $res[0]['taskid'],
			'type'			=> $res[0]['type'],
			'taskname'		=> $res[0]['taskname'],
			'description'	=> $res[0]['description'],
			'rule'			=> json_decode($res[0]['rule'], true),
			'rewards'		=> json_decode($res[0]['rewards'], true),
			'createtime'	=> $res[0]['createtime'],
			'starttime'		=> $res[0]['starttime'],
			'endtime'		=> $res[0]['endtime'],
			'isshow'		=> $res[0]['isshow']
		);
		if ($isAjax) {
			// ���������ʾ��ʽ
			$taskModel = $this->load($reData['type'].'task', 'task');
			$reData['ruleForm'] = $taskModel->getRuleHtml($reData['rule']);
			$reData['rewardsForm'] = $taskModel->getRewardsHtml($reData['rewards']);//print_r($reData);
			$this->msgbox('', $reData);
		} else {
			return $reData;
		}
	}
	
	/**
	 * ��õ�ǰ���������б�
	 */
	public function getTypesLists() {
		return $this->_types;
	}
}
?>