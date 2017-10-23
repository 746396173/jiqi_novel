<?php 
/** 
 * ��ֵ���Ŀ����� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class homeController extends pay_controller { 

//        public $template_name = 'index'; 
		public $caching = false;
		public function main($params = array()) {
		    header('location:'.$this->geturl('pay','home', 'SYS=method=alipay'));
		}
		//֧����
        public function alipay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'alipay', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    $this->checklogin();
				$dataObj = $this->model('home');
				$dataObj->alipay($params, $jieqiPayset);
			}
			$this->display($jieqiPayset['alipay'],'alipay');
        } 
		public function checkalipay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'alipay', 'jieqiPayset');
			$dataObj = $this->model('home');
			$dataObj->checkalipay($params, $jieqiPayset);
		}
		//����
        public function yeepay($params = array(),$tpl = 'yeepay') {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'yeepay', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    $this->checklogin();
				$dataObj = $this->model('home');
				$data = $dataObj->yeepay($params, $jieqiPayset);
				$this->display($data,'confirm');
			}
			$this->display($jieqiPayset['yeepay'],$tpl);
        } 
		public function checkyeepay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'yeepay', 'jieqiPayset');
			$dataObj = $this->model('home');
			$dataObj->checkyeepay($params, $jieqiPayset);
		}
		//�ֻ���ֵ��
        public function cardpay($params = array()) {
		     $this->yeepay($params,'cardpay');
		}
		//��Ϸ�㿨
        public function gcardpay($params = array()) {
		     $this->yeepay($params,'gcardpay');
		}
		//Q�ҿ�
        public function qcardpay($params = array()) {
		     $this->yeepay($params,'qcardpay');
		}
		//paypal
        public function paypal($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'paypal', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    $this->checklogin();
				$dataObj = $this->model('home');
				$data = $dataObj->paypal($params, $jieqiPayset);
				$this->display($data,'confirm');
			}
			$this->display($jieqiPayset['paypal'],'paypal');
        } 
		/**
		 * paypalȷ�Ͻ��
		 */
		public function confirm($params = array()){//print_r($params);exit;
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'paypal', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    $this->checklogin();
				$dataObj = $this->model('home');
				$data = $dataObj->paypal($params, $jieqiPayset);
				$this->display($data,'confirm');
			}
		}
		public function checkpaypal($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'paypal', 'jieqiPayset');
			$dataObj = $this->model('home');
			$dataObj->checkpaypal($params, $jieqiPayset);
		}
		//���¸�
        public function txfpay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'txfpay', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    $this->checklogin();
				$dataObj = $this->model('home');
				$data = $dataObj->txfpay($params, $jieqiPayset);
				$this->display($data,'confirm');
			}
			$this->display($jieqiPayset['txfpay'],'txfpay');
        } 
		public function checktxfpay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'txfpay', 'jieqiPayset');
			$dataObj = $this->model('home');
			$dataObj->checktxfpay($params, $jieqiPayset);
		}
		//����ͨ ΢��
		public function wftpay($params = array()){
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'wftpay', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    $this->checklogin();
				$dataObj = $this->model('home');
				$data = $dataObj->wftpay($params, $jieqiPayset);
				$this->display($data,'erwei');
			}
			$this->display($jieqiPayset['wftpay'],'wftpay');
		}
		public function checkwftpay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'wftpay', 'jieqiPayset');
			$dataObj = $this->model('home');
			$dataObj->checkwftpay($params, $jieqiPayset);
		}
} 
?>