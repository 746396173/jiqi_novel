<?php 
/**
 * ��������ͳ�ƿ�����
 * @author chengyuan  2014-4-24
 *
 */
class statisticsController extends Admin_controller {
		public $template_name = 'statistics';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallarticle');//Ȩ����֤
			  //����������Ȩ��
			  $this->checkpower('setwriter');
        } 
		/**
		 * ����ͳ��Ĭ�����
		 * @param unknown $params
		 */
        public function main($params = array()) {
        		$apply = $this->model('statistics','article');
        		$data = $apply->statistics($params);
        		$this->display($data);
			
        } 
}

?>