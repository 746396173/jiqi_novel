<?php 
/**
 * ������־
 * @author chengyuan  2014-6-5
 *
 */
class statlogController extends Admin_controller {
		public $template_name = 'statlog';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallarticle');//Ȩ����֤
			  //����������Ȩ��
			  $this->checkpower('setwriter');
        } 
		/**
		 * Ĭ�����
		 * @param unknown $params
		 */
        public function main($params = array()) {
        		$apply = $this->model('statlog','article');
        		$data = $apply->statlog($params);
        		$this->display($data);
			
        } 
}

?>