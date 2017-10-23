<?php
/**
 * ������������
 * @author liuxiangbin  2015-1-26
 *
 */
class sourcesController extends Admin_controller {
	
	/**
	 * ���캯������Ȩ��
	 */
	public function __construct() {
		parent::__construct();
		$user = $this->getAuth();
		// Ȩ����֤������ǰ����
		if ($user['groupid']!=2) {
			$this->printfail('�Բ�������Ȩ���ʸ�ҳ��');
		}
	}
		
	/**
	 * ��̨������ҳ
	 */
	public function main($params = array()) {
		$sourceModel = $this->model('sourcemanage');
		$data = $sourceModel->getDataList($params);
		$this->display($data, 'sources_list');
	}
	
	/**
	 * ���һ������
	 */
	public function addSource($params = array()) {
		$this->display($data, 'sources_add');
	}
	
	/**
	 * �첽�����������
	 */
	public function addData($params = array()) {
		$sourceModel = $this->model('sourcemanage');
		$data = $sourceModel->setData($params);
	}
	
	/**
	 * �༭һ������
	 */
	public function editSource($params = array()) {
		$sourceModel = $this->model('sourcemanage');
		$data = $sourceModel->getOneData($params);
		$this->display($data, 'sources_edit');
	}
	
	/**
	 * �첽�޸���������
	 */
	public function editData($params = array()) {
		$sourceModel = $this->model('sourcemanage');
		$data = $sourceModel->setData($params, 'edit');
	}
	
	/**
	 * �첽ɾ��һ������
	 */
	public function delData($params = array()) {
		$sourceModel = $this->model('sourcemanage');
		$data = $sourceModel->delData($params);
	}
	
	/**
	 * �첽�޸�����
	 */
	public function ordorData($params = array()) {
		$sourceModel = $this->model('sourcemanage');
		$data = $sourceModel->setOrder($params);
	}
}















