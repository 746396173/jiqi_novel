<?php 
/** 
 * ϵͳ����->�û����� * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class usersController extends Admin_controller {
		public $template_name = 'users';
		//public $theme_dir = false;
		
		
		public function __construct() { 
              parent::__construct();
			  //�����û� Ȩ��
			  //$this->checkpower('adminuser');
			  $this->checkpower('viewuser');
			  //$this->checkpower('viewonline');
        }
		
        public function main($params = array()) {
			 $dataObj = $this->model('users');
			 $data = $dataObj->main($params);
             $this->display($data);
        } 
} 

?>