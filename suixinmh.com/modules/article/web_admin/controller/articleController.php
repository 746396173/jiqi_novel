<?php 
/** 
 * С˵����->���¹��� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class articleController extends Admin_controller {
		public $template_name = 'articlelist';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallarticle');//Ȩ����֤
        } 
		
        public function main($params = array()) {
			 $dataObj = $this->model('article');//ʵ�����Զ���������
             $this->display($dataObj->main($params));
        } 
		public function doauthor($params = array()) {
			 $dataObj = $this->model('article');//ʵ�����Զ���������
             $this->display($dataObj->doauthor($params));
        } 
        /*public function doarticle($params = array()) {
			 $dataObj = $this->model('article');//ʵ�����Զ���������
             $this->display($dataObj->doarticle($params));
        } */		
		
		//����ɾ������
		public function batchdel($params = array()) {exit();
			//�ύ����
			if($this->submitcheck()){
				 $dataObj = $this->model('article');
				 $dataObj->batchdel($params);
			}
        } 
		//����vip
		function setvip($params = array()){
			  $this->checkpower('delallarticle');//Ȩ����֤
			 $dataObj = $this->model('article');
			 $data = $dataObj->setvip($params);//print_r($data);
             $this->display($data,'setvip');
		}
}

?>