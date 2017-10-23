<?php
/**
 * ������ǩ�����ģ��
 * @author liuxiangbin
 * @create 2045-03-24 13:40:24
 */
class positiontypeModel extends Model {
	
	/**
	 * ��ȡȫ�����ݣ�����������
	 */
	public function getAllData($params, $pagenum=20) {
		// ��ʼ�����������ݿ�ģ��
		$data = array();
		$thisController = ($_REQUEST['controller']) ? $_REQUEST['controller'] : 'taskController';
		$thisPage = isset($params['page']) ? intval($params['page']) : 1;
		$this->db->init('positiontype', 'id', 'system');
		$this->db->setCriteria();
		// �Ӳ�ѯ����
		$this->db->criteria->add(new Criteria('flag', 1, '='));
		if (isset($params['name']) && ''!=htmlspecialchars(trim($params['name'])))
			$this->db->criteria->add(new Criteria('name', '%'.htmlspecialchars(trim($params['name'])).'%', 'LIKE'));
		// ��ȡ���ݲ�����
		$data['lists'] = $this->db->lists($pagenum, $thisPage, JIEQI_PAGE_TAG);
		$data['url_jumppage'] = $this->db->getPage($this->getAdminurl('positiontype'));
		return $data;
	}
	
	/**
	 * ����һ�������¼
	 */
	public function getOne($params) {
		if (!isset($params['ptid'])) $this->printfail('ȱ�ٲ���');
		$this->db->init('positiontype', 'id', 'system');
		$this->db->setCriteria(new Criteria('id', intval($params['ptid']), '='));
		$this->db->criteria->add(new Criteria('flag', 1, '='));
		$result = $this->db->lists();
		if (empty($result)) $this->printfail('�����ڵ�ҳ��');
		return $result[0];
	}
	
	/**
	 * ����һ����¼��Ĭ��Ϊupdate
	 * @param $mod-addΪ����
	 */
	public function setData($params, $mod = 'edit') {
		// ����֤
		if ('edit'===$mod && !isset($params['ptid'])) $this->printfail('ȱ�ٲ���');
		$setName = htmlspecialchars(trim($params['name']));
		if (strlen($setName)<=0 || strlen($setName)>40) $this->printfail('���Ƴ��ȱ�����2~20������֮��');
		$setModule = htmlspecialchars(trim($params['module']));
		if (!preg_match('/^[a-zA-z1-9]{1,20}$/', $setModule)) $this->printfail('ģ��ֻ��ʹ��Ӣ���б�����1~20����ĸ֮��');
		$setDescription = htmlspecialchars(trim($params['description']));
		if (strlen($setDescription)>160) $this->printfail('�������ֲ��ܳ���80����');
		// ����д������
		$setData = array(
			'name'			=> $setName,
			'module'		=> $setModule,
			'description'	=> $setDescription
		);
		// �������ݿ�����
		$this->db->init('positiontype', 'id', 'system');
		if ('add'===$mod) {
			$setData['createtime'] = JIEQI_NOW_TIME;
			$this->db->add($setData);
		} else if ('edit'===$mod) {
			$this->db->edit(intval($params['ptid']), $setData);
		} else {
			$this->printfail('�����ڵ�setData��ʽ');
		}
		jieqi_jumppage($this->getAdminurl('positiontype'));
		die;
	}
	
	/**
	 * ɾ��һ����¼��Ĭ��Ϊ���ɾ��
	 * @param $mod-delΪ��ʵɾ��
	 */
	public function delData($params, $mod = 'mark') {
		// ������ʹ����֤
		if (!isset($params['ptid'])) $this->printfail('ȱ�ٲ���');
		$this->db->init('position', 'postid', 'system');
		$this->db->setCriteria(new Criteria('ptypeid', intval($params['ptid']), '='));
		$result = $this->db->lists();
		if (!empty($result)) $this->printfail('����ɾ���������ڴ�ģ��ı�ǩ');
		// ���б�ǻ�ɾ��
		$this->db->init('positiontype', 'id', 'system');
		if ('delete'!==$mod) {
			$this->db->edit(intval($params['ptid']), array('flag'=>2));
		} else {
			$this->db->delete(intval($params['ptid']));
		}
		jieqi_jumppage($this->getAdminurl('positiontype'));
		die;
	}
	
	/**
	 * ��÷����б�
	 * @return һά���飺array(id=>module)
	 */
	public function getSort() {
		$this->db->init('positiontype', 'id', 'system');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('flag', 1, '='));
		$this->db->criteria->setFields('id,name,module');
		$result = $this->db->lists();
		// �������ݣ�idΪ�±������
		$data = array();
		foreach ($result as $k=>$v) {
			$data[$v['id']]['name'] = $v['name'];
			$data[$v['id']]['module'] = $v['module'];
		}
		return $data;
	}
}
 
 
 
 
 
 
