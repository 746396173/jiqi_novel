<?php 
/** 
 * С˵����->�������� * @copyright   Copyright(c) 2014 
 * @author            liujilei* @version     1.0 
 */ 
class repliesController extends Admin_controller {
		public $template_name = 'replies';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallreview');//Ȩ����֤
        } 
		
        public function main($params = array()) {
		
			 $modelObj = $this->model('replies');
             $this->display($modelObj->main($params));
        } 
		
		//����ID��ɾ�������۵Ļظ�����������Ӧ�Ļ���
	public function delReply($params = array())
	{
		 $modelObj = $this->model('replies');
         $this->display($modelObj->delReply($params));
	}
	
	//����ID ɾ�����ۣ���ɾ�������۵Ļظ�����������Ӧ�Ļ���
	public function batchDel($params = array()){
		 $modelObj = $this->model('replies');
		 $this->display($modelObj->batchDel($params));
	}
	
}
?>