<?php
/**
 * PayPal ������
 * ����URLΪsanbox���༴ɳ�У��������ڲ��Ի���
 * ��ʵ����Ϊhttps://api-3t.paypal.com/nvp
 * https://www.paypal.com/cgi-bin/webscr&cmd=_express-checkout&useraction=commit&token=
 */

//���Ե�ַ
// define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');
// define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr&cmd=_express-checkout&useraction=commit&token=');

//��ʽ��ַ
define ( 'API_ENDPOINT', 'https://api-3t.paypal.com/nvp' );
define ( 'PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr&cmd=_express-checkout&useraction=commit&token=' );
//��ʱ�����
define('API_PAYMENTACTION','sale');

class paypal {
	public $errMsg = array ();
	
	//API����
	private $api_parameter;

	public function __construct($api_parameter = array()) {
		$this->api_parameter = $api_parameter;
	}

	/**
	 * ��ȡ֧����ڵ�ַ
	 * @param unknown_type $params
	 * @return boolean|string
	 */
	public function SetExpressCheckout($params) {
		$token = '';

		$payAmount = $params ['amount'];
		$currency = $params ['currency'];
		$desc = $params ['desc'];
		$order = $params ['order'];

		$returnURL = urlencode($params['returnPage'].'?order='.$order);
		$cancelURL = urlencode($params ['cancelPage']);

		$nvpstr = "&PAYMENTREQUEST_0_AMT=" . $payAmount .
		"&PAYMENTREQUEST_0_PAYMENTACTION=" . API_PAYMENTACTION .
		"&RETURNURL=" . $returnURL .
		"&CANCELURL=" . $cancelURL .
		"&PAYMENTREQUEST_0_CURRENCYCODE=" . $currency .
		"&PAYMENTREQUEST_0_DESC=" . $desc;

		$resArray = $this->makeCall ( "SetExpressCheckout", $nvpstr );
//print_r($resArray);exit;
		if (! $resArray) {
			return false;
		}
		if (array_key_exists ( 'ACK', $resArray ) and strtoupper ( $resArray ['ACK'] ) == 'SUCCESS') {
			if (array_key_exists ( "TOKEN", $resArray )) {
				$token = urldecode ( $resArray ["TOKEN"] );
			}
			$payPalURL = PAYPAL_URL . $token;
		}
		return $payPalURL;
	}
	/**
	 * ȡ��һЩ�����ߵ���Ϣ  ʵ�ｻ��ʹ��
	 * @param unknown_type $params
	 * @return boolean|Ambigous <boolean, multitype:string >
	 */
	public function GetExpressCheckoutDetails($params) {
		$token = urlencode ( $params ['token'] );
		$nvpstr = "&TOKEN=" . $token;
		$resArray = self::makeCall ( "GetExpressCheckoutDetails", $nvpstr );
		if (! $resArray) {
			return false;
		}
		if (array_key_exists ( 'ACK', $resArray ) and strtoupper ( $resArray ['ACK'] ) == 'SUCCESS') {
			return $resArray;
		} else {
			//��������쳣����
			$this->errMsg = '��ȡ������Ϣʧ��';
			return false;
		}
	}

	/**
	 * ��ʽ����
	 * @param unknown_type $params
	 * http://www.shuhai.com/test/response.php?
	 * cmd=paypal
	 * &currency=USD
	 * &payAmount=1
	 * &token=EC-1VN00129F64422203
	 * &PayerID=VWB2HVGPT2F3C
	 */
	public function DoExpressCheckoutPayment($params) {
		$token = urlencode ( $params ['token'] );
		$payAmount = urlencode ( $params ['payAmount'] );
		$payerID = urlencode ( $params ['PayerID'] );
		$nvpstr = '&TOKEN=' . $token .
		'&PAYERID=' . $payerID .
		'&PAYMENTREQUEST_0_PAYMENTACTION=' . API_PAYMENTACTION .
		'&PAYMENTREQUEST_0_AMT=' . $payAmount;
		$resArray = $this->makeCall ( "DoExpressCheckoutPayment", $nvpstr );
		if (! $resArray) {
			return false;
		}
		if (array_key_exists ( 'ACK', $resArray ) and strtoupper ( $resArray ['ACK'] ) == 'SUCCESS') {
			return $resArray;
		} else {
			//��������쳣����
			$this->errMsg = '����ʧ��';
			return false;
		}
	}

	/**
	 * �˿��
	 * @param unknown_type $params
	 */
	// 	public function RefundTransaction($params) {
	// 		$type = $params ['type'];
	// 		$transactionId = $params ['transactionId'];
	// 		$amount = urlencode ( $params ['amount'] );
	// 		$nvpstr = '&TRANSACTIONID=' . $transactionId . '&REFUNDTYPE=' . $type;
	// 		if ($type == 'Full')
		// 			$nvpstr .= '&PAYMENTREQUEST_0_AMT=' . $amount;
		// 		$resArray = self::makeCall ( "RefundTransaction", $nvpstr );
		// 		if (! $resArray) {
		// 			return false;
		// 		}
		// 		if (array_key_exists ( 'ACK', $resArray ) and strtoupper ( $resArray ['ACK'] ) == 'SUCCESS') {
		// 			return $resArray;
		// 		} else {
		// 			//��������쳣����
		// 		}
		// 	}

	public function getError(){
		return $this->errMsg;
	}

	// ͨ��curl�����������󣬱����ϵĺ�������
	private function makeCall($methodName, $nvpStr) {

		$version = '82.0';
		
		$array = $this->api_parameter;
		
		$API_UserName = $array['api_username'];
		$API_Password = $array['api_password'];
		$API_Signature = $array['pai_signatuer'];

		//  $nvp_Header;
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, API_ENDPOINT );
		curl_setopt ( $ch, CURLOPT_VERBOSE, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		//curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//��ֱֹ����ʾ��ȡ������ ��Ҫ
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		/*  if(USE_PROXY)//���ʹ�ô���
		 {
		curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT);
		}*/
		$nvpreq = "METHOD=" . urlencode ( $methodName ) . "&VERSION=" . urlencode ( $version ) . "&PWD=" . urlencode ( $API_Password ) . "&USER=" . urlencode ( $API_UserName ) . "&SIGNATURE=" . urlencode ( $API_Signature ) . $nvpStr;
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $nvpreq );//print_r($ch);echo $nvpreq;exit;
		$response = curl_exec( $ch );//print_r($response);exit;
		$nvpResArray = self::deformatNVP ( $response );
		if (! $response) {
			//��������쳣������
			return false;
		} else {
			curl_close ( $ch );
		}//print_r($nvpResArray);exit;
		return $nvpResArray;
		
//$data = array
//	(
//	'url' => API_ENDPOINT,
//	'submit' => 'submit',
//	"METHOD" => urlencode ( $methodName ) , 
//	"VERSION" => urlencode ( $version ) , 
//	"PWD" => urlencode ( $API_Password ) , 
//	"USER" => urlencode ( $API_UserName ) , 
//	"SIGNATURE" => urlencode ( $API_Signature ) . $nvpStr
//);
//
//$response = $this->Post(API_ENDPOINT, $data);
//echo '<pre>';
//var_dump(explode('&', $response));
//echo '</pre>';die;
//$reg = '#[\'"](http:(//|\\/\\/)t\.cn((/|\\/)([^\'"/]+)(/|\\/)?|(/|\\/)))[\'"]#';
//preg_match_all($reg, $response, $match);
//var_dump($match);die;
		
		
	}
function Post($url, $post = null) {
    if (is_array($post)) {
        ksort($post);
        $content = http_build_query($post);
        $content_length = strlen($content);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 
                "Content-type: application/x-www-form-urlencoded\r\n" . "Content-length: ".$content_length."\r\n",
                'content' => $content
            )
        );
        return file_get_contents($url, false, stream_context_create($options));
    }
}
	/**
	 * �ַ�������
	 * @param unknown_type $nvpstr
	 */
	private static function deformatNVP($nvpstr) {
		$intial = 0;
		$nvpArray = array ();
		while ( strlen ( $nvpstr ) ) {
			$keypos = strpos ( $nvpstr, '=' );
			$valuepos = strpos ( $nvpstr, '&' ) ? strpos ( $nvpstr, '&' ) : strlen ( $nvpstr );
			$keyval = substr ( $nvpstr, $intial, $keypos );
			$valval = substr ( $nvpstr, $keypos + 1, $valuepos - $keypos - 1 );
			$nvpArray [urldecode ( $keyval )] = urldecode ( $valval );
			$nvpstr = substr ( $nvpstr, $valuepos + 1, strlen ( $nvpstr ) );
		}
		return $nvpArray;
	}
}