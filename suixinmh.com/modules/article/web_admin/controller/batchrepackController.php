<?php 
/** 
 * С˵����->����HTML * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class batchrepackController extends Admin_controller {
		public $template_name = 'batchrepack';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallarticle');//Ȩ����֤
        } 
		
        public function main($params = array()) {
			 $dataObj = $this->model('batchrepack');//ʵ�����Զ���������
             $this->display($dataObj->main($params));
        } 
}

?>