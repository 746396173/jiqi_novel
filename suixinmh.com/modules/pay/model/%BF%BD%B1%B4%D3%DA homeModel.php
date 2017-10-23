<?php 
/** 
 * ��ֵģ�� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class homeModel extends Model{ 
		//֧����
        function alipay($params = array(), $jieqiPayset = array()){ 
		     define('JIEQI_PAY_TYPE', 'alipay');
			 $this->addLang('pay', 'pay');
			 $jieqiLang['pay'] = $this->getLang('pay'); //�������԰����ø�ֵ
			 //�жϴ���
			 $user_is_agent = '';
			 if($_SERVER['HTTP_X_FORWARDED_FOR'] || $_SERVER['HTTP_VIA'] || $_SERVER['HTTP_PROXY_CONNECTION'] || $_SERVER['HTTP_USER_AGENT_VIA'] || $_SERVER['HTTP_PROXY_CONNECTION']) {
			 	 $user_is_agent = 'agent';
			 }
			 $params['egold']=intval($params['egold']);
			 if(isset($params['egold']) && is_numeric($params['egold']) && $params['egold']>0){
				  if(!empty($jieqiPayset[JIEQI_PAY_TYPE]['paylimit'])){
					  if(!empty($jieqiPayset[JIEQI_PAY_TYPE]['paylimit'][$params['egold']])) $money=intval($jieqiPayset[JIEQI_PAY_TYPE]['paylimit'][$params['egold']] * 100);
					  else $this->printfail($jieqiLang['pay']['buy_type_error']);
				  }else{
					  $this->printfail($jieqiLang['pay']['buy_type_error']);
				  }
				  $auth = $this->getAuth();
				  
				    $this->db->init( 'paylog', 'payid', 'pay' );
					$paylog['siteid'] = JIEQI_SITE_ID;
					$paylog['buytime'] = JIEQI_NOW_TIME;
					$paylog['rettime'] = 0;
					$paylog['buyid'] = $auth['uid'];
					$paylog['buyname'] = $auth['username'];
					$paylog['buyinfo'] = '';
					$paylog['moneytype'] = $jieqiPayset[JIEQI_PAY_TYPE]['moneytype'];
					$paylog['money'] = $money;
					$paylog['egoldtype'] = $jieqiPayset[JIEQI_PAY_TYPE]['paysilver'];
					$paylog['egold'] = $params['egold'];
					$paylog['paytype'] = JIEQI_PAY_TYPE;
					$paylog['retserialno'] = '';
					$paylog['retaccount'] = '';
					$paylog['retinfo'] = $this->getip();
					$paylog['masterid'] = 0;
					$paylog['mastername'] = '';
					$paylog['masterinfo'] = '';
					$paylog['note'] = $user_is_agent;
					$paylog['payflag'] = 0;
					$paylog['source'] = $auth['source'];
					if(!$payid = $this->db->add($paylog)) $this->printfail($jieqiLang['pay']['add_paylog_error']);
					else{
						$urlvars=array();
						$urlvars['service']=$jieqiPayset[JIEQI_PAY_TYPE]['service']; //��������
						$urlvars['partner']=$jieqiPayset[JIEQI_PAY_TYPE]['payid']; //�����̻���
						//$urlvars['agent']=$jieqiPayset[JIEQI_PAY_TYPE]['agent']; //������id
						$urlvars['return_url']=$jieqiPayset[JIEQI_PAY_TYPE]['payreturn'];  //ͬ������
						$urlvars['notify_url']=$jieqiPayset[JIEQI_PAY_TYPE]['notify_url'];  //�첽����
						$urlvars['_input_charset']=$jieqiPayset[JIEQI_PAY_TYPE]['_input_charset'];  //�ַ�����Ĭ��ΪGBK
						
						$urlvars['subject']= JIEQI_EGOLD_NAME;  //��Ʒ���ƣ�����
						//$urlvars['body']= $jieqiPayset[JIEQI_PAY_TYPE]['body']; //��Ʒ����
						$urlvars['out_trade_no']=$payid; //��Ʒ�ⲿ���׺ţ�����,ÿ�β��Զ����޸�
						$urlvars['total_fee']=$money / 100;          //��Ʒ�ܼ�
						//$price=$total_fee; //��Ʒ����
						//$quantity=1; //��Ʒ����
						$urlvars['payment_type']=$jieqiPayset[JIEQI_PAY_TYPE]['payment_type']; // ��Ʒ֧������ 1 ����Ʒ���� 2�������� 3���������� 4������ 5���ʷѲ��� 6������
						$urlvars['show_url']=$jieqiPayset[JIEQI_PAY_TYPE]['show_url'];  //��Ʒ�����վ��˾
						$urlvars['seller_email']=$jieqiPayset[JIEQI_PAY_TYPE]['seller_email'];   //�������䣬����
						ksort($urlvars);
						reset($urlvars);
						$sign='';
						$query='';
						foreach($urlvars as $k=>$v){
							if(!empty($sign)) $sign.='&';
							$sign.=$k.'='.$v;
							if(!empty($query)) $query.='&';
							$query.=$k.'='.urlencode($v);
						}
						$sign=md5($sign.$jieqiPayset[JIEQI_PAY_TYPE]['paykey']);
						$query.='&sign_type='.$jieqiPayset[JIEQI_PAY_TYPE]['sign_type'].'&sign='.$sign;
						$query=$jieqiPayset['alipay']['payurl'].'?'.$query;
						header('Location: '.$query);
						exit;
					}
			 }else{
			      $this->printfail($jieqiLang['pay']['buy_type_error']);
			 }
        } 
		//֧�������ؽ��
		function checkalipay($params = array(), $jieqiPayset = array()){
		    define('JIEQI_PAY_TYPE', 'alipay');
			$this->addLang('pay', 'pay');
			$jieqiLang['pay'] = $this->getLang('pay'); //�������԰����ø�ֵ
			$mymerchant_id=$jieqiPayset[JIEQI_PAY_TYPE]['payid']; //�̻����
			$key=$jieqiPayset[JIEQI_PAY_TYPE]['paykey']; //��Կ
			
			$logflag = 0; //�Ƿ��¼��־
			if($logflag){
				ob_start();
				print_r($_REQUEST);
				$log = ob_get_contents();
				ob_end_clean();
				jieqi_writefile(JIEQI_ROOT_PATH.'/cache/alipayrecv.txt',$log,'ab');
			}
			
			if(!empty($_GET['notify_id']) && !empty($_GET['buyer_email']) && !empty($_GET['out_trade_no'])){
				//ֱ�ӷ���ģʽ
				$getvars=$_GET;
				$showmode=1;
			}elseif(!empty($_POST['notify_id']) && !empty($_POST['buyer_email']) && !empty($_POST['out_trade_no'])){
				//�첽����ģʽ
				$getvars=$_POST;
				$showmode=0;
				echo 'success';
			}else{
				echo 'fail';
				exit;
			}
			
			//��齻��״̬(�ǲ��Ǹ���ɹ�)
			if(strtoupper($getvars['trade_status']) != 'TRADE_FINISHED' && $getvars['trade_status'] != 'TRADE_SUCCESS'){
				if($showmode) $this->printfail($jieqiLang['pay']['pay_return_error'].'<br /><br />RETCODE:'.$getvars['trade_status']);
				else exit;
			}
			
			//֪ͨУ��
			if($logflag){
				$checkurl=$jieqiPayset[JIEQI_PAY_TYPE]['notifycheck'].'?msg_id='.urlencode($getvars['notify_id']).'&email='.urlencode($getvars['buyer_email']).'&order_no='.urlencode($getvars['out_trade_no']);
				$checkret=strtolower(file_get_contents($checkurl));  //success or failure
				$log=$checkurl.'['.$checkret.']';
				jieqi_writefile(JIEQI_ROOT_PATH.'/cache/alipaycheck.txt',$log,'ab');
			}
			//md5У��
			ksort($getvars);
			reset($getvars);
			$signtext='';
			$signdecode='';
			foreach($getvars as $k=>$v){
				if($k != 'sign' && $k != 'sign_type' && $k != 'controller' && $k != 'method'){
					if(!empty($signtext)){
						$signtext.='&';
						$signdecode.='&';
					}
					$signtext.=$k.'='.$v;
					$signdecode.=$k.'='.urldecode($v);
				}
			}
			if(strtolower($getvars['sign']) == strtolower(md5($signtext.$jieqiPayset[JIEQI_PAY_TYPE]['paykey'])) || strtolower($getvars['sign']) == strtolower(md5($signdecode.$jieqiPayset[JIEQI_PAY_TYPE]['paykey']))){
				$orderid=intval($getvars['out_trade_no']);
				$this->db->init( 'paylog', 'payid', 'pay' );
				$this->db->setCriteria(new Criteria( 'payid', $orderid, '=' ));
				$paylog=$this->db->get($this->db->criteria);
				if(is_object($paylog)){
					$buyname=$paylog->getVar('buyname');
					$buyid=$paylog->getVar('buyid');
					$payflag=$paylog->getVar('payflag');
					$egold=$paylog->getVar('egold');
					if($payflag == 0){
						$users_handler =  $this->getUserObject();
						$ret=$users_handler->income($buyid, $egold, $jieqiPayset[JIEQI_PAY_TYPE]['paysilver'], 0);
						if($ret) $note=sprintf($jieqiLang['pay']['add_egold_success'], $buyname, JIEQI_EGOLD_NAME, $egold);
						else $note=sprintf($jieqiLang['pay']['add_egold_failure'], $buyid, $buyname, JIEQI_EGOLD_NAME, $egold);
						$paylog->setVar('rettime', JIEQI_NOW_TIME);
						$paylog->setVar('note', $note);
						$paylog->setVar('payflag', 1);
						if(!$this->db->edit($orderid, $paylog)){ 
							if($showmode) $this->printfail($jieqiLang['pay']['save_paylog_failure']);
						}else{
							if($showmode) $this->msgwin(LANG_DO_SUCCESS,sprintf($jieqiLang['pay']['buy_egold_success'], $buyname, JIEQI_EGOLD_NAME, $egold));
						}
					}else{
						if($showmode) $this->msgwin(LANG_DO_SUCCESS,sprintf($jieqiLang['pay']['buy_egold_success'], $buyname, JIEQI_EGOLD_NAME, $egold));
					}
				}else{
					if($showmode) $this->printfail($jieqiLang['pay']['no_buy_record']);
				}
			}else{
				if($showmode) $this->printfail($jieqiLang['pay']['return_checkcode_error']);
			}
		}
		//����
        function yeepay($params = array(), $jieqiPayset = array()){ 
		     define('JIEQI_PAY_TYPE', 'yeepay');
			 require_once($GLOBALS['jieqiModules']['pay']['path'].'/function/yeepaycommon.php'); //�ױ�֧���ӿڹ�������
			 $this->addLang('pay', 'pay');
			 $jieqiLang['pay'] = $this->getLang('pay'); //�������԰����ø�ֵ
			 //�жϴ���
			 $user_is_agent = '';
			 if($_SERVER['HTTP_X_FORWARDED_FOR'] || $_SERVER['HTTP_VIA'] || $_SERVER['HTTP_PROXY_CONNECTION'] || $_SERVER['HTTP_USER_AGENT_VIA'] || $_SERVER['HTTP_PROXY_CONNECTION']) {
			 	 $user_is_agent = 'agent';
			 }
			 $params['egold']=intval($params['egold']);
			 if(isset($params['egold']) && is_numeric($params['egold']) && $params['egold']>0){
				  if(!empty($jieqiPayset[JIEQI_PAY_TYPE]['paylimit'])){
					  if(!empty($jieqiPayset[JIEQI_PAY_TYPE]['paylimit'][$params['egold']])) $money=intval($jieqiPayset[JIEQI_PAY_TYPE]['paylimit'][$params['egold']] * 100);
					  else $this->printfail($jieqiLang['pay']['buy_type_error']);
				  }else{
					  $this->printfail($jieqiLang['pay']['buy_type_error']);
				  }
				  $auth = $this->getAuth();
				  
				    $this->db->init( 'paylog', 'payid', 'pay' );
					$paylog['siteid'] = JIEQI_SITE_ID;
					$paylog['buytime'] = JIEQI_NOW_TIME;
					$paylog['rettime'] = 0;
					$paylog['buyid'] = $auth['uid'];
					$paylog['buyname'] = $auth['username'];
					$paylog['buyinfo'] = '';
					$paylog['moneytype'] = $jieqiPayset[JIEQI_PAY_TYPE]['moneytype'];
					$paylog['money'] = $money;
					$paylog['egoldtype'] = $jieqiPayset[JIEQI_PAY_TYPE]['paysilver'];
					$paylog['egold'] = $params['egold'];
					$paylog['paytype'] = JIEQI_PAY_TYPE;
					$paylog['retserialno'] = '';
					$paylog['retaccount'] = '';
					$paylog['retinfo'] = $this->getip();
					$paylog['masterid'] = 0;
					$paylog['mastername'] = '';
					$paylog['masterinfo'] = '';
					$paylog['note'] = $user_is_agent;
					$paylog['payflag'] = 0;
					$paylog['source'] = $auth['source'];
					if(!$payid = $this->db->add($paylog)) $this->printfail($jieqiLang['pay']['add_paylog_error']);
					else{
						$amount=$money / 100;
						//$p0_Cmd = $jieqiPayset[JIEQI_PAY_TYPE]['messageType'];    //֧�����󣬹̶�ֵ"Buy" 
						$merchantId = $jieqiPayset[JIEQI_PAY_TYPE]['payid'];  //�̻����
						$orderId = $payid;     //�������[�̻���վ]
						$cur = $jieqiPayset[JIEQI_PAY_TYPE]['cur'];    //���ҵ�λCNY
						$productId = empty($jieqiPayset[JIEQI_PAY_TYPE]['productId']) ? JIEQI_EGOLD_NAME : $jieqiPayset[JIEQI_PAY_TYPE]['productId'];    //��Ʒ����
						$productCat = $jieqiPayset[JIEQI_PAY_TYPE]['productCat'];    //���ҵ�λCNY
						$productDesc = $jieqiPayset[JIEQI_PAY_TYPE]['productDesc'];    //���ҵ�λCNY
						$sMctProperties = $jieqiPayset[JIEQI_PAY_TYPE]['sMctProperties'];    //sMctProperties
						$frpId = trim($_POST['pd_FrpId']) != '' ? trim($_POST['pd_FrpId']) : $jieqiPayset[JIEQI_PAY_TYPE]['frpId'];    //���ҵ�λCNY
						$frpId = 'ICBC-NET-B2C';
						$needResponse = $jieqiPayset[JIEQI_PAY_TYPE]['needResponse'];    //���ҵ�λCNY
						$nodeAuthorizationURL = $jieqiPayset[JIEQI_PAY_TYPE]['payurl'];    //���ҵ�λCNY
						$merchantCallbackURL = $jieqiPayset[JIEQI_PAY_TYPE]['payreturn'];    //���ҵ�λCNY
						$p0_Cmd = $jieqiPayset[JIEQI_PAY_TYPE]['messageType'];    //���ҵ�λCNY
						$addressFlag = $jieqiPayset[JIEQI_PAY_TYPE]['addressFlag'];    //���ҵ�λCNY
				
						
						$mac = getReqHmacString($orderId,$amount,$cur,$productId,$productCat,$productDesc,$merchantCallbackURL,$sMctProperties,$frpId,$needResponse); //�Բ���������˽Կ����ȡ��ֵ
						$urlvars=array();
						$urlvars['url_pay']= $jieqiPayset[JIEQI_PAY_TYPE]['payurl'];
						$urlvars['buyname']= $auth['username'];
						$urlvars['egold']= $params['egold'];
						$urlvars['egoldname']= JIEQI_EGOLD_NAME;
						$urlvars['money']= sprintf('%0.2f', $money / 100);
						$urlvars['p0_Cmd']= $p0_Cmd;
						$urlvars['p1_MerId']= $merchantId;
						$urlvars['p2_Order']= $orderId;
						$urlvars['p3_Amt']= $amount;
						$urlvars['p4_Cur']= $cur;
						$urlvars['p5_Pid']= $productId;
						$urlvars['p6_Pcat']= $productCat;
						$urlvars['p7_Pdesc']= $productDesc;
						$urlvars['p8_Url']= $merchantCallbackURL;
						$urlvars['p9_SAF']= $addressFlag;
						$urlvars['pa_MP']= $sMctProperties;
						$urlvars['pd_FrpId']= $frpId;
						$urlvars['pr_NeedResponse']= $needResponse;
						$urlvars['hmac']= $mac;
						 return array(
							  'urlvars'=>$urlvars,
						 );
					}
			 }else{
			      $this->printfail($jieqiLang['pay']['buy_type_error']);
			 }
		}
		//�������ؽ��
		function checkyeepay($params = array(), $jieqiPayset = array()){
		    define('JIEQI_PAY_TYPE', 'yeepay');
			 require_once($GLOBALS['jieqiModules']['pay']['path'].'/function/yeepaycommon.php'); //�ױ�֧���ӿڹ�������
			$this->addLang('pay', 'pay');
			$jieqiLang['pay'] = $this->getLang('pay'); //�������԰����ø�ֵ
			$merchantId = $jieqiPayset[JIEQI_PAY_TYPE]['payid'];  //�̻����
			$keyValue = $jieqiPayset[JIEQI_PAY_TYPE]['paykey'];
			$paytype=JIEQI_PAY_TYPE;
			if(isset($_REQUEST['rb_BankId'])) $_REQUEST['rb_BankId']=trim($_REQUEST['rb_BankId']);
			if(!empty($_REQUEST['rb_BankId']) && isset($jieqiPayset[JIEQI_PAY_TYPE]['paytype'][$_REQUEST['rb_BankId']])) $paytype=$jieqiPayset[JIEQI_PAY_TYPE]['paytype'][$_REQUEST['rb_BankId']];
			$return = getCallBackValue($sCmd,$sErrorCode,$sTrxId,$amount,$cur,$productId,$orderId,$userId,$MP,$bType,$svrHmac);
			$bRet = CheckHmac($sCmd,$sErrorCode,$sTrxId,$orderId,$amount,$cur,$productId,$userId,$MP,$bType,$svrHmac);
			if($bRet){
				if($sErrorCode=='1'){
					$orderid=intval($getvars['out_trade_no']);
					$this->db->init( 'paylog', 'payid', 'pay' );
					$this->db->setCriteria(new Criteria( 'payid', $orderid, '=' ));
					$paylog=$this->db->get($this->db->criteria);
					include_once($jieqiModules['pay']['path'].'/class/paylog.php');
					$paylog_handler=JieqiPaylogHandler::getInstance('JieqiPaylogHandler');
					$paylog=$paylog_handler->get($orderid);
					if(is_object($paylog)){
						$buyname=$paylog->getVar('buyname');
						$buyid=$paylog->getVar('buyid');
						$payflag=$paylog->getVar('payflag');
						$egold=$paylog->getVar('egold');
						if($payflag == 0){
							if(intval($amount)>5){
//								include_once(JIEQI_ROOT_PATH.'/class/users.php');
								$users_handler = $this->getUserObject();
								$ret=$users_handler->income($buyid, $egold, $jieqiPayset[JIEQI_PAY_TYPE]['paysilver'], $jieqiPayset[JIEQI_PAY_TYPE]['payscore'][$egold]);
							}
							if($ret) $note=sprintf($jieqiLang['pay']['add_egold_success'], $buyname, JIEQI_EGOLD_NAME, $egold);
							else $note=sprintf($jieqiLang['pay']['add_egold_failure'], $buyid, $buyname, JIEQI_EGOLD_NAME, $egold);
							$paylog->setVar('rettime', JIEQI_NOW_TIME);
							$paylog->setVar('money', intval($amount * 100));
							$paylog->setVar('paytype', $paytype);
							$paylog->setVar('note', $note);
							$paylog->setVar('payflag', 1);
							if(!$this->db->edit($paylog)) $this->printfail($jieqiLang['pay']['save_paylog_failure']);
						}
						if($bType=="2") echo "success";
						$this->msgwin(LANG_DO_SUCCESS,sprintf($jieqiLang['pay']['buy_egold_success'], $buyname, JIEQI_EGOLD_NAME, $egold));
					}
				}else{
					$this->printfail($jieqiLang['pay']['pay_return_error']);
				}
			}else{
				$this->printfail($jieqiLang['pay']['return_checkcode_error']);
			
			}
		}
		//�ֻ���ֵ
        function cardpay($params = array()){ 
		     
        } 
		//ʢ��
        function sdopay($params = array()){ 
		     
        } 
		//Q��
        function qpay($params = array()){ 
		     
        } 
		//����
        function jcardpay($params = array()){ 
		     
        } 
		//Paypal
        function paypal($params = array()){ 
		     
        } 
} 

?>