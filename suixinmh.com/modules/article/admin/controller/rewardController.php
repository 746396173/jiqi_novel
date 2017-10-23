<?php 
/**
 * ��ѹ���
 * @author chengyuan
 *
 */
class rewardController extends Admin_controller {
		public $template_name = 'copyrightlist';
		
		public function __construct() { 
              parent::__construct();
// 			  $this->checkpower('manageallarticle');//Ȩ����֤
        } 
        /**
         * ��Ȩ�����б�
         * @param unknown $params
         */
        public function main($params = array()) {
			$dataObj = $this->model('copyright');
            $this->display($dataObj->main($params));
        }
        /**
         * ������Ȩ��Ϣ
         * @param unknown $params
         */
        public function addContract($params = array()){
        	if($this->submitcheck()){
        		$dataObj = $this->model('copyright');
        		$dataObj->addContract($params);
        	}
        }
        /**
         * �޸İ�Ȩ��Ϣ
         * @param unknown $params
         */
        public function editContract($params = array()){
        	if($this->submitcheck()){
        		$dataObj = $this->model('copyright');
        		$dataObj->editContract($params);
        	}
        }
        /**
         * ɾ����Ȩ��Ϣ
         * @param unknown $params
         */
        public function deleteContract($params = array()){
        	$dataObj = $this->model('copyright');
        	$dataObj->deleteContract($params['id']);
        }
        
        /**
         * ajax json��Ȩ����
         * @param unknown $params
         */
        public function getCopyright($params = array()){
        	$dataObj = $this->model('copyright');
        	$dataObj->getCopyright($params['id']);
        }
        
        /**
         * ajax json������Ϣ
         * @param unknown $params
         */
        public function getArticle($params = array()){
        	$dataObj = $this->model('copyright');
        	$dataObj->getArticle($params['aid']);
        }
        
        
        
        /**
         * ��ѹ����б�
         * @param unknown $params
         */
        public function reward($params = array()) {
        	$dataObj = $this->model('reward');
        	$this->display($dataObj->reward($params),'rewardlist');
        }
        /**
         * ��Ȩ����-�����¼�б�
         * @param unknown $params
         */
        public function finance($params = array()) {
        	$dataObj = $this->model('finance');
        	$this->display($dataObj->main($params),'financelist');
        }
        
        /**
         * ��˲�����Ϣ�޸�����
         * @param unknown $params
         */
        public function audit($params = array()) {
        	$dataObj = $this->model('finance');
        	$dataObj->audit($params['ueaid'],$params['state']);
        }
        /**
         * ��ȡ�û��Ĳ�����Ϣ
         * @param unknown $params
         */
        public function getFinance($params = array()) {
        	$dataObj = $this->model('finance');
        	$dataObj->getFinance($params['ueid']);
        }
}
?>