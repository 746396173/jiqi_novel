<?php 
/** 
 * ���» * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
class huodongController extends Controller { 

        public $template_name = 'huodong'; 
		public $caching = false;
		public $theme_dir = false;
		public function __construct() {
			parent::__construct ();
			//����½
			$this->checklogin();
		} 	
        public function main($params = array()) {
			 $dataObj = $this->model('huodong');
             $this->display($dataObj->main($params)); 
        }
		//�Ƽ�
        public function vote($params = array()) {
			 $dataObj = $this->model('huodong');
             $this->display($dataObj->vote($params)); 
        } 
		//��Ʊ
        public function vipvote($params = array()) {
			 $dataObj = $this->model('huodong');
             $this->display($dataObj->vipvote($params)); 
        } 
		//����
        public function reward($params = array()) {
			 $dataObj = $this->model('huodong');
             $this->display($dataObj->reward($params)); 
        } 
		//�߸�
        public function cuigeng($params = array()) {
			 $dataObj = $this->model('huodong');
             $this->display($dataObj->cuigeng($params)); 
        } 
		//����
        public function reviews($params = array()) {
			 $dataObj = $this->model('huodong');
             $this->display($dataObj->reviews($params)); 
        } 
		
		//�������
		function addBookCase($params = array()){
		   $dataObj = $this->model('huodong');
		   
           $dataObj->addBookCase($params); 
		}
		/**
		 * �Զ������ǩ
		 * @author chengyuan 2015-6-3 ����2:43:15
		 * @param unknown $params
		 */
		function autoAddBookCase($params = array()){
			$dataObj = $this->model('huodong');
			$dataObj->autoAddBookCase($params['aid'],$params['cid']);
		}
		/**
		 * ��½�û����鼮�Ƿ�������
		 * @author chengyuan 2015-6-4 ����4:11:56
		 * @param unknown $params
		 */
		function asyncBookcaseState($params = array()){
			$dataObj = $this->model('huodong');
			$dataObj->asyncBookcaseState($params['aid']);
		}
} 
?>