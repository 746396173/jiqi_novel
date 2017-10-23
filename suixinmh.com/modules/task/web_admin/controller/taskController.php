<?php
/**
 * ������������
 * @author chengyuan  2014-6-11
 *
 */
class taskController extends Admin_controller {
	public $template_name = 'task_list';

	/**
	 * Ĭ����ڣ������б�
	 * @param unknown $params
	 */
	public function main($params = array()) {
		$data = array();
		$types = array();
		$taskModel = $this->model('task');
		$data = $taskModel->main($params);
		$data['taskTypes'] = $taskModel->getTypesLists();
//		$this->dump($data);
		$this->display($data);
	}
	
	/**
	 * ����������͵Ĺ���(�첽��������)
	 */
	public function getTaskTypeRule($params = array()) {
		$taskModel = $this->model('task');
		$taskModel->getTaskRule($params);
	}
	
	/**
	 * ���һ���µ�����
	 */
	public function addNewTask($params) {
		$taskModel = $this->model('task');
		$taskModel->addTask($params);
	}
	
	/**
	 * �޸�һ������
	 */
	public function editOneTask($params) {
		$taskModel = $this->model('task');
		$taskModel->editTask($params);
	}
	
	/**
	 * ɾ��һ������
	 */
	public function delOneTask($params) {
		$taskModel = $this->model('task');
		$taskModel->delTask($params);
	}
	
	/**
	 * ��ʾһ���ɱ༭����������
	 */
	public function showOneTask($params) {
		$data = array();
		$taskModel = $this->model('task');
		$data = $taskModel->getOneTask($params);
	}

}












