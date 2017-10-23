<?php
/**
 * ��ǩ�������
 * @author liuxiangbin
 * @create 2015-03-24 11:38:15
 */
class positiontypeController extends Admin_Controller {
	
	/**
	 * ��֤�Ƿ��й����ǩ��Ȩ��
	 */
	public function __construct() { 
      	parent::__construct();
	  	$this->checkpower('adminblock');
    }
	
	/**
	 * ��ǩ�б�
	 */
	public function main($params = array()) {
		$ptModel = $this->model('positiontype');
		$data = $ptModel->getAllData($params);
		$this->display($data);
	}
	
	/**
	 * ���һ����ǩ
	 */
	public function add($params = array()) {
		$this->display();
	}
	
	/**
	 * ��ģ�壺��ӷ�������
	 */
	public function addData($params = array()) {
//		echo 111;die;
		$ptModel = $this->model('positiontype');
		$ptModel->setData($params, 'add');
	}
	
	/**
	 * �༭һ����ǩ
	 */
	public function edit($params = array()) {
		$ptModel = $this->model('positiontype');
		$data = $ptModel->getOne($params);
		$this->display($data);
	}
	
	/**
	 * ��ģ�壺�༭һ����ǩ
	 */
	public function editData($params = array()) {
		$ptModel = $this->model('positiontype');
		$ptModel->setData($params);
	}
	
	/**
	 * �첽������ɾ��һ����ǩ����Ҫ��֤�Ƿ���ʹ��
	 */
	public function del($params = array()) {
		$ptModel = $this->model('positiontype');
		$ptModel->delData($params);
	}
	
	
	
}
 
 
 
 
