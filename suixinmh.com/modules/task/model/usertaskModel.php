<?php
/**
 * �������ģ�ͣ�ǰ̨�û�����ģ��
 * @auther by: liuxiangbin
 * @createtime : 2015-01-13
 */

class usertaskModel extends Model {
	
	/**
	 * ��ȡ�û���ǰ��������
	 */
	public function getUserList($params) {
		// �����ҳ����
		$this->addConfig('article','configs');
    		$jieqiConfigs['article'] = $this->getConfig('article', 'configs');
		$pagenum = $jieqiConfigs['article']['pagenum'];
		// ��ʼ����ǰҳ��
		$thisPage = intval($params['page'])<=0 ? 1 : $params['page'];
		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->setFields('taskid,type,taskname,description,createtime,starttime,endtime');
		// �Ƿ���ʾ���صĲ�ѯ����
		$this->db->criteria->add(new Criteria('isshow', 1, '='));
		// ����ʾǩ������
		$this->db->criteria->add(new Criteria('type', 'signin', '<>'));
		$this->db->criteria->setSort('createtime');
        $this->db->criteria->setOrder('DESC');
		$thisController = ($_REQUEST['controller']) ? $_REQUEST['controller'] : 'taskController';
		$data['lists'] = $this->db->lists($pagenum, $thisPage, JIEQI_PAGE_TAG);
		$data['url_jumppage'] = $this->db->getPage($this->getUrl(JIEQI_MODULE_NAME, $thisController,'evalpage=0','SYS=method='.$methodName));
		if (empty($data['lists'])) 
			return $data;
		// �����Ƿ���ɵĲ���(1-�������δ��ɣ�2-����ɣ�3-�������)
		foreach ($data['lists'] as $k => $v) {
			// ��̬��ȡÿһ��������жϹ���
			$taskLib = $this->load($v['type'].'task', 'task');
			$timeRule = $taskLib->getTimeRule();
			// ��ʼʱ���ж�
			if ($timeRule['stime'] == true) {
				if (JIEQI_NOW_TIME<$v['starttime']) {
					unset($data['lists'][$k]);
					continue;
				}
			}
			// ����ʱ���ж�
			if ($timeRule['etime'] == true) {
				if (JIEQI_NOW_TIME>$v['endtime']) {
					unset($data['lists'][$k]);
					continue;
				}
			}
			// ��̬�жϼ�����ɱ��
			if ($taskLib->isFinished($v['taskid'])) {
				$data['lists'][$k]['iscomplete'] = 2;
			} else if ($taskLib->isAchevable($v['taskid'])) {
				$data['lists'][$k]['iscomplete'] = 1;
			} else {
				$data['lists'][$k]['iscomplete'] = 3;
			}
		}
		return $data;
	}
	
	/**
	 * ��ȡ�û�������������б�
	 */
	public function getUsreFinished($params) {
		$auth = $this->getAuth();
		// �����ҳ����
		$this->addConfig('article','configs');
    		$jieqiConfigs['article'] = $this->getConfig('article', 'configs');
		$pagenum = $jieqiConfigs['article']['pagenum'];
		// ��ʼ����ǰҳ��
		$thisPage = intval($params['page'])<=0 ? 1 : $params['page'];
		$this->db->init('complete', 'tcid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('userid', $auth['uid'], '='));
		$this->db->criteria->setFields('records,createtime');
		$this->db->criteria->setSort('createtime');
        $this->db->criteria->setOrder('DESC');
		$thisController = ($_REQUEST['controller']) ? $_REQUEST['controller'] : 'taskController';
		$data['lists'] = $this->db->lists($pagenum, $thisPage, JIEQI_PAGE_TAG);
		$data['url_jumppage'] = $this->db->getPage($this->getUrl(JIEQI_MODULE_NAME, $thisController,'evalpage=0','SYS=method='.$methodName));
		return $data;
	}
	
	/**
	 * ����������ɣ��첽��ʽ����
	 */
	public function setComplete($params) {
		$taskType = $this->_getType($params['tid']);
		$taskLib = $this->load($taskType . 'task', 'task');
		if ($taskType == 'vipup') {
			$res = $taskLib->setFinish($params, true);
		} else {
			$res = $taskLib->setFinish($params);
		}
		if ($res['status']=='OK') {
			$this->msgbox('');
		} else {
			$this->printfail($res['msg']);
		}
	}
	
	/**
	 * ����taskid��ȡ��ǰ�������͵�˽�з���
	 */
	private function _getType($tid) {
		if (intval($tid) <= 0) 
			$this->printfail('ȱ�ٱ�Ҫ����');
		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', $tid, '='));
		$this->db->criteria->setFields('type');
		$res = $this->db->lists();
		if (empty($res)) {
			$this->printfail('�������ͻ�ȡʧ��');
		} else {
			return $res[0]['type'];
		}
	}
}
	