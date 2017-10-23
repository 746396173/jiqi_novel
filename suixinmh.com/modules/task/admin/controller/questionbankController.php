<?php
/**
 * ����̨������
 * @author liuxiangbin  2015-02-04
 *
 */
class questionbankController extends Controller {
	public $theme_dir = '/templates/admin/main';
	public $caching = false;
	
	/**
	 * Ȩ����֤
	 */
	public function __construct() {
		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		 parent::__construct();
		 $this->checkpower('questioneditor', false, 'task');
	}
	
	/**
	 * Ȩ����֤����
	 */
	public function checkpower($pname, $isreturn=false, $module = JIEQI_MODULE_NAME){
	     //include_once('model/powerModel.php'); 
		 if($pname=='admin'){
		      if(!$this->checkisadmin()){
			      if(!$isreturn) jieqi_printfail(LANG_NEED_ADMIN);
				  else return false;
			  }else return true;
		 }else{
			 $powerObj = $this->model();
			 return parent::checkpower($powerObj->getDbPower($module,$pname), $this->getUsersStatus(), $this->getUsersGroup(), $isreturn, true);
		 }
	}
	
	/**
	 * ����б�
	 */
	public function main($params = array()) {
		$questionbankModel = $this->model('questionbank', 'task');
		$data = $questionbankModel->getAllData($params);
		$this->display($data, 'questionbank_list');
	}
	
	/**
	 * �첽�����һ������
	 */
	public function addQuestion($params = array()) {
		$questionbankModel = $this->model('questionbank', 'task');
		$data = $questionbankModel->setOneData($params, 'add');
	}
	
	/**
	 * �첽���༭һ������
	 */
	public function editQuestion($params = array()) {
		$questionbankModel = $this->model('questionbank', 'task');
		$data = $questionbankModel->setOneData($params, 'edit');
	}
	
	/**
	 * �첽��ɾ��һ������
	 */
	public function delOneQuestion($params = array()) {
		$questionbankModel = $this->model('questionbank', 'task');
		$data = $questionbankModel->delData($params);
	}
	
	/**
	 * �첽��չʾһ����������
	 */
	public function showOneQuestion($params = array()) {
		$questionbankModel = $this->model('questionbank', 'task');
		$data = $questionbankModel->viewOneData($params);
	}
	
	public function getArticleName($params = array()) {
		$questionbankModel = $this->model('questionbank', 'task');
		$data = $questionbankModel->getArticleName($params);
	}
	
	
}















