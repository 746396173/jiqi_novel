<?php
/**
 * ֧�������� *
 * @copyright   Copyright(c) 2014
 * @author      zhangxue
 * @version     1.0
 */
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
include_once(JIEQI_ROOT_PATH."/include/funsystem.php");
class payController extends chief_controller {

        public $caching = false;
		public $theme_dir = false;
		//public $cacheid = 'fff';
		//public $cachetime=5;
		//��ֵ��ҳ
		public function main($params){
            $params['in_weixin'] = 1;
            switch(get_user_agent()) {
                case 0:
                    $pay_wechat = 1;
                    $pay_alipay=1;
                    break;
                case 1:
                    $pay_wechat = 1;
                    $pay_alipay = 0;
                    break;
                case 2:
                    $pay_wechat = 0;
                    $pay_alipay = 1;
                    break;
            }

            if ($pay_wechat == 1 && $pay_alipay == 0) {
                header("location:/pay/wechat/");
                exit();
            }
            $params['pay_wechat'] = $pay_wechat;
            $params['pay_alipay'] = $pay_alipay;
			$this->display($params);
		}
		//������ ��ͨ
		public function unicom($params){
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'unicom', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    if($this->checklogin(true)){
					$dataObj = $this->model('pay');
					$data = $dataObj->unicom($params, $jieqiPayset);
					$this->display($data,'unicomcheck');
				}else{
					header('Location: '.$this->geturl('3g', 'login'));
				}
			}
			$this->display($jieqiPayset['unicom']);
		}
		//��������֤ ��ͨ
		public function yanunicom($params){
			$this->theme_dir = false;
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'unicom', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    $this->checklogin();
				$dataObj = $this->model('pay');
				$data = $dataObj->yanunicom($params, $jieqiPayset);
				$this->display($data,'paypop');
			}
		}
		//������֪ͨ ��ͨ
		public function checkunicom($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'unicom', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$dataObj->checkunicom($params, $jieqiPayset);
		}
		//����
		public function telecom($params){
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'telecom', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
				$this->theme_dir = false;
			    if($this->checklogin(true)){
					$dataObj = $this->model('pay');
					$data = $dataObj->telecom($params, $jieqiPayset);
					$this->display($data,'paypop');
				}else{
					header('Location: '.$this->geturl('3g', 'login'));
				}
			}
			$this->display($jieqiPayset['telecom']);
		}
		/**
		 * ���� H5�棺����֧��
		 */
		public function mobile2($params){
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'mobile', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    if($this->checklogin(true)){
					$dataObj = $this->model('pay');
					$data = $dataObj->mobile($params, $jieqiPayset);
//					$this->display($data,'mobilecodeyan');
				}else{
					header('Location: '.$this->geturl('3g', 'login'));
				}
			}
			$this->display($jieqiPayset['mobile'],'mobile');
		}
		/**
		 * ���� H5�棺�ص��ӿ�
		 */
		public function checkmobile($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'mobile', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$dataObj->checkmobile($params, $jieqiPayset);
		}
		//���¸�
        public function txfpay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'txfpay_wap', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    $this->checklogin();
				$dataObj = $this->model('pay');
				$data = $dataObj->txfpay($params, $jieqiPayset);
				$this->display($data,'confirm');
			}
			$this->display($jieqiPayset['txfpay'],'txfpay');
        } 
		public function checktxfpay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'txfpay_wap', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$dataObj->checktxfpay($params, $jieqiPayset);
		}
//		
//		//֧����
//      public function alipay($params = array()) {
//		    global $jieqiPayset;
//	        jieqi_getconfigs('pay', 'alipay_wap', 'jieqiPayset');
//			//�ύ����
//		    if($this->submitcheck()){
//			    $this->checklogin();
//				$dataObj = $this->model('pay');
//				//$data = 
//				$dataObj->alipay($params, $jieqiPayset);
//				//$this->display($data,'confirm');
//			}
//			$this->display($jieqiPayset['alipay'],'alipay');
//      } 
//		public function checkalipayw($params = array()) {
//		    global $jieqiPayset;
//	        jieqi_getconfigs('pay', 'alipay', 'jieqiPayset');
//			$dataObj = $this->model('pay');
//			$dataObj->checkalipayw($params, $jieqiPayset);
//		}
		//֧����
        public function alipay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'alipay_wap', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    if($this->checklogin(true)){
					$dataObj = $this->model('pay');
					$dataObj->alipay($params, $jieqiPayset);
				}else{
					header('Location: '.$this->geturl('3g', 'login'));
				}
			}
			$auth = $this->getAuth();
			/*if($auth['uid'] && $auth['vip']>0){
			    unset($jieqiPayset['alipay_wap']['paylimit']['900']);
				unset($jieqiPayset['alipay_wap']['paylimit']['2000']);
			}else unset($jieqiPayset['alipay_wap']['paylimit']['3000']);*/
			$this->display($jieqiPayset['alipay_wap']);
        } 
		public function checkalipay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'alipay_wap', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$data = $dataObj->checkalipay($params, $jieqiPayset);
            if ($_SESSION['jieqi_readurl']) {
                $data['readurl'] = $_SESSION['jieqi_readurl'];
            }
            else {
                $data['readurl'] = JIEQI_HTTP_HOST;
            }
			$this->display($data,'paypop');
		}
		public function alipay_notify($params = array()){
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'alipay_wap', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$dataObj->alipay_notify($params, $jieqiPayset);
		}
		/**
		 * ��ά
		 */
        public function mobile($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'zhangwei', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    if($this->checklogin(true)){
					$dataObj = $this->model('pay');
					$dataObj->zhangwei($params, $jieqiPayset);
				}else{
					header('Location: '.$this->geturl('3g', 'login'));
				}
			}
			$this->display($jieqiPayset['zhangwei']);
        } 
		/**
		 * ��άͬ����ת
		 */
		public function checkzhangwei($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'zhangwei', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$data = $dataObj->checkzhangwei($params, $jieqiPayset);
			$this->display($data,'paypop');
		}
		/**
		 * ��ά�첽֪ͨ
		 */
		public function zhangwei_notify($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'zhangwei', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$dataObj->zhangwei_notify($params, $jieqiPayset);
		}
		//����
        public function yeepay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'yeepay_wap', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    if($this->checklogin(true)){
					$dataObj = $this->model('pay');
					$dataObj->yeepay($params, $jieqiPayset);
				}else{
					header('Location: '.$this->geturl('3g', 'login'));
				}
			}
			$this->display($jieqiPayset['yeepay_wap']);
        } 
		public function checkyeepay($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'yeepay_wap', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$data = $dataObj->checkyeepay($params, $jieqiPayset);
			$this->display($data,'paypop');
		}
		public function yeepay_notify($params = array()){
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'yeepay_wap', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$dataObj->yeepay_notify($params, $jieqiPayset);
		}
		/**
		 * �����죺΢��
		 */
		public function wechat($params = array()){
			//print_r($params);
            //echo 'money='.$params['money'];
			$user = $this->getAuth();
			if (!$user['uid'] && is_weixin()) {
				header("location:".$GLOBALS['jieqiModules'][JIEQI_MODULE_NAME]['url']."/wxlogin/?jumpurl=/pay/wechat/");
				exit();
			}
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'wechat_wap', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
				//echo "---------0----------<br>";
			    if($this->checklogin(true)){
					$dataObj = $this->model('pay');
					//echo "---------1--------<br>";
					if(isset($_SERVER['ESHUKU_SUB'])){
						//echo "---------2--------<br>";
						$jieqiPayset['wechat_wap']['wx_result'] = $dataObj->wechat_sub($params, $jieqiPayset);
					}else{
						$dataObj->wechat($params, $jieqiPayset);
					}
				}else{
					header('Location: '.$this->geturl('3g', 'login'));
				}
			}
			foreach($jieqiPayset['wechat_wap']['paylimit'] as $money=>$gold) {
				$z=$gold-$money*100;
				$jieqiPayset['wechat_wap']['zk'][$money] = round($money*100/$gold*100)/10;
			}
			if ($params['baonian'])
				$this->display($jieqiPayset, 'pay_wechat_baonian');
			else
				$this->display($jieqiPayset['wechat_wap']);
        }

        /*
         * ��΢��֧��
         */
        public function wechat_zwx($params = array()){
            global $jieqiPayset;
            jieqi_getconfigs('pay', 'wechat_zwx', 'jieqiPayset');
            //�ύ����
            if($this->submitcheck()){
                if($this->checklogin(true)){
					$dataObj = $this->model('pay');
					if(isset($_SERVER['ESHUKU_SUB'])){
						$jieqiPayset['wechat_wap']['wx_result'] = $dataObj->wechat_sub($params, $jieqiPayset);
					}else{
						$dataObj->wechat($params, $jieqiPayset);
					}
                }else{
                    header('Location: '.$this->geturl('3g', 'login'));
                }
            }
            $this->display($jieqiPayset['wechat_zwx'],'pay_wechat_zwx');
        }
		/**
		 * ΢�� �첽
		 */
		public function wechat_notify($params = array()){
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'wechat_wap', 'jieqiPayset');
			$dataObj = $this->model('pay');
			if(isset($_SERVER['ESHUKU_SUB'])){
				$dataObj->wechat_sub_notify($params, $jieqiPayset);
			}else{
				$dataObj->wechat_notify($params, $jieqiPayset);
			}
		}
		/**
		 * ΢�� ͬ����ת
		 */
		public function checkwechat($params = array()) {
		    global $jieqiPayset;
	        jieqi_getconfigs('pay', 'wechat_wap', 'jieqiPayset');
			$dataObj = $this->model('pay');
			$data = $dataObj->checkwechat($params, $jieqiPayset);
			if ($_SESSION['jieqi_readurl']) {
				$data['readurl'] = $_SESSION['jieqi_readurl'];
			}
			else {
				$data['readurl'] = "http://".JIEQI_HTTP_HOST;
			}
			$this->display($data,'paypop');
		}


	/**
	 * ΢�� �첽
	 */
	public function wechat_zwx_notify($params = array()){
		global $jieqiPayset;
		jieqi_getconfigs('pay', 'wechat_zwx', 'jieqiPayset');
		$dataObj = $this->model('pay');
		$dataObj->wechat_zwx_notify($params, $jieqiPayset);
	}
	/**
	 * ΢�� ͬ����ת
	 */
	public function checkwechat_zwx($params = array()) {
		global $jieqiPayset;
		jieqi_getconfigs('pay', 'wechat_wap', 'jieqiPayset');
		$dataObj = $this->model('pay');
		$data = $dataObj->checkwechat($params, $jieqiPayset);
		if ($_SESSION['jieqi_readurl']) {
			$data['readurl'] = $_SESSION['jieqi_readurl'];
		}
		else {
			$data['readurl'] = "http://".JIEQI_HTTP_HOST;
		}
		$this->display($data,'paypop');
	}

	/**
	 * �����죺QQ
	 */
	public function qq($params = array()){
		global $jieqiPayset;
		jieqi_getconfigs('pay', 'qq_wap', 'jieqiPayset');
		//�ύ����
		if($this->submitcheck()){
			if($this->checklogin(true)){
				$dataObj = $this->model('pay');
				$dataObj->qq($params, $jieqiPayset);
			}else{
				header('Location: '.$this->geturl('3g', 'login'));
			}
		}

		/*$auth = $this->getAuth();
        if($auth['uid'] && $auth['vip']>0){
            unset($jieqiPayset['wechat_wap']['paylimit']['900']);
            unset($jieqiPayset['wechat_wap']['paylimit']['2000']);
        }else unset($jieqiPayset['wechat_wap']['paylimit']['3000']);*/
		$this->display($jieqiPayset['qq_wap']);
	}
	/**
	 * QQ �첽
	 */
	public function qq_notify($params = array()){
		global $jieqiPayset;
		jieqi_getconfigs('pay', 'qq_wap', 'jieqiPayset');
		$dataObj = $this->model('pay');
		$dataObj->qq_notify($params, $jieqiPayset);
	}
	/**
	 * QQ ͬ����ת
	 */
	public function checkqq($params = array()) {
		global $jieqiPayset;
		jieqi_getconfigs('pay', 'qq_wap', 'jieqiPayset');
		$dataObj = $this->model('pay');
		$data = $dataObj->checkqq($params, $jieqiPayset);
		$this->display($data,'paypop');
	}


	/**
	 * rdo
	 */
	public function rdo($params = array()){
		global $jieqiPayset;
		jieqi_getconfigs('pay', 'rdo_wap', 'jieqiPayset');
		//�ύ����
		if($this->submitcheck()){
			if($this->checklogin(true)){
				$dataObj = $this->model('pay');
				$dataObj->rdo($params, $jieqiPayset);
			}else{
				header('Location: '.$this->geturl('3g', 'login'));
			}
		}

		/*$auth = $this->getAuth();
        if($auth['uid'] && $auth['vip']>0){
            unset($jieqiPayset['wechat_wap']['paylimit']['900']);
            unset($jieqiPayset['wechat_wap']['paylimit']['2000']);
        }else unset($jieqiPayset['wechat_wap']['paylimit']['3000']);*/
		$this->display($jieqiPayset['rdo_wap']);
	}
	/**
	 * RDO �첽
	 */
	public function rdo_notify($params = array()){
		global $jieqiPayset;
		jieqi_getconfigs('pay', 'rdo_wap', 'jieqiPayset');
		$dataObj = $this->model('pay');
		$dataObj->rdo_notify($params, $jieqiPayset);
	}


}

?>