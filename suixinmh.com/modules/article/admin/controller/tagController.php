<?php 
/**
 * ��ǩ����
 * @author chengyuan
 *
 */
class tagController extends Admin_controller {
		public $template_name = 'tag_list';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallarticle');//Ȩ����֤
        } 
        
        public function main($params = array()) {
        	$dataObj = $this->model('tag');
        	//			 print_r($params);
        	$this->display($dataObj->main($params));
        }
        
        
        public function addTag($params = array()){
        	$dataObj = $this->model('tag');
        	//			 print_r($params);
        	$this->display($dataObj->addTag($params['tname'],$params['channel']));
        }
        
        public function getTag($params = array()){
        	$dataObj = $this->model('tag');
        	$dataObj->getTag($params['id']);
        }
        
        public function editTag($params = array()){
        	$dataObj = $this->model('tag');
        	$dataObj->editTag($params);
        }
        
}

?>