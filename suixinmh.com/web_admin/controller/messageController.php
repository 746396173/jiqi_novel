<?php 
/** 
 * ϵͳ����->��(��)���� * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class messageController extends Admin_controller {
		public $template_name = 'outbox';
		public function __construct() { 
              parent::__construct();
			  //����������� Ȩ��
			  $this->checkpower('adminmessage');
        }
		
		//public $theme_dir = false;
        public function inbox($params = array()) {
			 $dataObj = $this->model('message');
			 $data = $dataObj->inbox($params);
//			 $data['tab'] = 1;
			 $this->display($data,'inbox');
        }

        public function outbox($params = array()) {
			 $dataObj = $this->model('message');
			 $data = $dataObj->outbox($params);
//			 $data['tab'] = 4;
			 $this->display($data,'outbox');
        } 
}
?>