<?php
/** 
 * ��ֵ��̨������Ŀ����� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class Admin_controller extends Controller{
		public $theme_dir = '/templates/admindemo/main';
		public $caching = false;
		
        public function __construct() { 
              parent::__construct();
			  $this->checkpower('adminpaylog');
        } 
		
		//��̨Ȩ�޼��
		public function checkpower($pname, $isreturn=false){
//			$this->dump($GLOBALS);
		     //include_once('model/powerModel.php'); 
			 if($pname=='admin'){
			      if(!$this->checkisadmin()){
				      if(!$isreturn) jieqi_printfail(LANG_NEED_ADMIN);
					  else return false;
				  }else return true;
			 }else{
				 $powerObj = $this->model();
				 return parent::checkpower($powerObj->getDbPower(JIEQI_MODULE_NAME,$pname), $this->getUsersStatus(), $this->getUsersGroup(), $isreturn, true);
			 }
		}
		
		/**
		 * ��д��������дglobal�ڷ���
		 * ��ʽ���ߺ�ֱ��ɾ���˷�������
		 */
		public function getAdminurl($controller='', $p = '', $module = JIEQI_MODULE_NAME){
		    if($module == 'system' || $controller=='login'){
	//	    	echo $controller;die;
				if($controller) return JIEQI_URL.'/admindemo/?controller='.$controller.($p ? '&'.$p : '');
				else return JIEQI_URL.'/admindemo/';
			}else{
			    global $jieqiModules;
				$controller = $controller ? $controller : $_REQUEST['controller'];
			    if($controller) return $jieqiModules[$module]['url'].'/admindemo/?controller='.$controller.($p ? '&'.$p : '');
				else return $jieqiModules[$module]['url'].'/admindemo/';
			}
		}
}
?>