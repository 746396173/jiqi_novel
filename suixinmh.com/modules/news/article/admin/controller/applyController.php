<?php 
/**
 * ���������¼������
 * @author chengyuan  2014-4-24
 *
 */
class applyController extends Admin_controller {
		public $template_name = 'applylist';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallarticle');//Ȩ����֤
			  //����������Ȩ��
			  $this->checkpower('setwriter');
        } 
		/**
		 * �����б���ͼ
		 * @param unknown $params
		 */
        public function main($params = array()) {
			 $apply = $this->model('apply','article');
			$data = $apply->applyList($params);
             $this->display($data);
        } 
}

?>