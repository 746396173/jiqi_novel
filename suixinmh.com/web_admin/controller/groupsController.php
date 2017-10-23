<?php 
/** 
 * ϵͳ����->�û������ * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class groupsController extends Admin_controller {
		public $template_name = 'groups';
		public function __construct() { 
              parent::__construct();
			  //����������� Ȩ��
			  $this->checkpower('adminconfig');
			  $this->checkpower('admingroup');
        }
		
        public function main($params = array()) {
			 $dataObj = $this->model('groups');
			 $dataModel = $dataObj->main($params);
			 $data = array(
				 'groups'=>$dataModel['groups'],
				 'form_addgroup'=>$dataModel['form_addgroup'],
			 );
			 $this->display($data);
        }
		/** 
		 * edit view
		 */ 
		public function edit_view($params = array()){
			$dataObj = $this->model('groups');
			$jieqi_contents = $dataObj->editForm($params['groupid']);
			//exit;
			$this->display(array('jieqi_contents'=>$jieqi_contents),'main');
		}
		/** 
		 * modify
		 */
		public function modify($params = array()){
			$dataObj = $this->model('groups');
			$_REQUEST = $this->getRequest();
			$obj = array('id'=>$params['groupid'],'name'=>$params['groupname'],'description'=>$params['description']);
			$dataObj->modify($obj);
		}
		/** 
		 * del
		 */ 
		public function del($params = array()){
			$dataObj = $this->model('groups');
			$data = $dataObj->del($params['id']);
			$this->display($data);
		}
}
?>