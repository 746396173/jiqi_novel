<?php

/**
 *������alipay_service
 *���ܣ�֧����Wap����ӿڿ���
 *��ϸ����ҳ��������������Ĵ����ļ�������Ҫ�޸�
 *�汾��2.0
 *���ڣ�2011-09-01
 '˵����
 '���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 '�ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���
*/

require_once ("alipay_function.php");

class alipay_service {
	var $gateway_paychannel="https://mapi.alipay.com/cooperate/gateway.do?";
	var $gateway = "http://wappaygw.alipay.com/service/rest.htm?";	//���ص�ַ
	
	var $_key;				//��ȫУ����
	var $mysign;			//ǩ�����
	var $sign_type;			//ǩ������ �൱��config�ļ��е�sec_id
	var $parameter;			//��Ҫǩ���Ĳ�������
	var $format;			//�ַ������ʽ
	var $req_data='';		//post��������

	/**���캯��
	 */
	function alipay_service() {
	}

	/**
	 * ����mobile_merchant_paychannel�ӿ�
	 */
	function mobile_merchant_paychannel($parameter, $key, $sign_type) {
		$this->_key			= $key;																		//MD5У����
		$this->sign_type	= $sign_type; 																//ǩ�����ͣ��˴�ΪMD5
		$this->parameter	= para_filter($parameter); 													//��ȥ�����еĿ�ֵ��ǩ������
		$sort_array			= arg_sort($this->parameter); 												//�õ�����ĸa��z������ǩ����������
		$this->mysign		= build_mysign($sort_array, $this->_key, $this->sign_type); 				//����ǩ��
		$this->req_data		= create_linkstring($this->parameter).'&sign='.urlencode($this->mysign).'&sign_type='.$this->sign_type;	//����post�������ݣ�ע��signǩ����Ҫurlencode

		//ģ��get���󷽷�
		$result = $this->get($this->gateway_paychannel);
		//���ô���Json����
		$alipay_channel = $this->getJson($result);
		return $alipay_channel;
	}

	/**
	 * ��ǩ�������л�Json����
	 */
	function getJson($result)
	{
		//��ȡ���ص�Json
		$json = getDataForXML($result,'/alipay/response/alipay/result');
		//ƴװ�ɴ�ǩ��������
		$data = "result=" . $json . $this->_key;

		//���json
		//echo $json;

		//$json="{\"payChannleResult\":{\"supportedPayChannelList\":{\"supportTopPayChannel\":{\"name\":\"������֧��\",\"cashierCode\":\"DEBITCARD\",\"supportSecPayChannelList\":{\"supportSecPayChannel\":[{\"name\":\"ũ��\",\"cashierCode\":\"DEBITCARD_ABC\"},{\"name\":\"����\",\"cashierCode\":\"DEBITCARD_ICBC\"},{\"name\":\"����\",\"cashierCode\":\"DEBITCARD_CITIC\"},{\"name\":\"���\",\"cashierCode\":\"DEBITCARD_CEB\"},{\"name\":\"�չ\",\"cashierCode\":\"DEBITCARD_SDB\"},{\"name\":\"����\",\"cashierCode\":\"DEBITCARD\"}]}}}}}";

		//��ȡ����sign
		$aliSign = getDataForXML($result,'/alipay/sign');

		//ת����ǩ����ʽ���ݣ���Ϊ��mapi�ӿ�ͳһ������GBK����ģ�����Ҫ��Ĭ��UTF-8�ı���ת����GBK����������ǩ���᲻һ��
		$data_GBK = mb_convert_encoding($data, "GBK", "UTF-8");
		
		//�����Լ���sign
		$mySign = sign($data_GBK,$this->sign_type);
		
		//�ж�ǩ���Ƿ�һ��
		if($mySign==$aliSign){
			//ǩ����ͬ
			//echo "ǩ����ͬ";

			//php��ȡjson����
			return json_decode($json);
		}
		else{
			//��ǩʧ��
			//echo "��ǩʧ��";
			return "��ǩʧ��";
		}
	}

	/**
	 * ģ��https��get���󣬲�����Ĭ��utf-8�����ݷ���
	 */
/*
	function get($gateway_url){
		$url = $gateway_url . $this->req_data;
		$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		
		//https ��get������Ҫ���¶���2�����
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  // this line makes it work under https
		
		//��ȡhtml���ؽ��
		echo $result=curl_exec ($ch);echo "<hr>";
        echo(curl_error($ch));exit;
		curl_close ($ch);
		return $result;
	}
*/
function get($gateway_url, $input_charset = '', $time_out = "60") {
	$url = $gateway_url . $this->req_data;
	$urlarr     = parse_url($url);
	$errno      = "";
	$errstr     = "";
	$transports = "";
	$responseText = "";
	if($urlarr["scheme"] == "https") {
		$transports = "ssl://";
		$urlarr["port"] = "443";
	} else {
		$transports = "tcp://";
		$urlarr["port"] = "80";
	}
	$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
	if(!$fp) {
		die("ERROR: $errno - $errstr<br />\n");
	} else {
		if (trim($input_charset) == '') {
			fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
		}
		else {
			fputs($fp, "POST ".$urlarr["path"].'?_input_charset='.$input_charset." HTTP/1.1\r\n");
		}
		fputs($fp, "Host: ".$urlarr["host"]."\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $urlarr["query"] . "\r\n\r\n");
		while(!feof($fp)) {
			$responseText .= @fgets($fp, 1024);
		}
		fclose($fp);
		$responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");
		
		return $responseText;
	}
}
	/**
	 * ����alipay.wap.trade.create.direct�ӿ�
	 */
	function alipay_wap_trade_create_direct($parameter, $key, $sign_type) {
		$this->_key			= $key;																		//MD5У����
		$this->sign_type	= $sign_type; 																//ǩ�����ͣ��˴�ΪMD5
		$this->parameter	= para_filter($parameter); 													//��ȥ�����еĿ�ֵ��ǩ������
		$this->req_data		= $parameter['req_data'];
		$this->format		= $this->parameter['format']; 												//�����ʽ���˴�Ϊutf-8
		$sort_array			= arg_sort($this->parameter); 												//�õ�����ĸa��z������ǩ����������
		$this->mysign		= build_mysign($sort_array, $this->_key, $this->sign_type); //echo $this->mysign;				//����ǩ��
		$this->req_data		= create_linkstring($this->parameter).'&sign='.urlencode($this->mysign);	//����post�������ݣ�ע��signǩ����Ҫurlencode
		//echo $this->req_data;exit();
		//Post�ύ����
		$result	= $this->post($this->gateway);
		
		//����GetToken������������token
		return $this->getToken($result);															
	}

	/**
	 * ����alipay_Wap_Auth_AuthAndExecute�ӿ�
	 */
	function alipay_Wap_Auth_AuthAndExecute($parameter,$key) {
		$this->parameter	= para_filter($parameter);
		$sort_array			= arg_sort($this->parameter); 
		$this->sign_type	= $this->parameter['sec_id'];
		$this->_key			= $key;
		$this->mysign		= build_mysign($sort_array, $this->_key, $this->sign_type);
		$RedirectUrl		= $this->gateway . create_linkstring($this->parameter) . '&sign=' . urlencode($this->mysign);
		
		//���post�����ַ����������ã�
		//echo $RedirectUrl;

		//��ת���õ�ַ
		Header("Location: $RedirectUrl");
	}

	/**
	 * ����token����
	 * ���� result ��Ҫ��urldecode
	 */
	function getToken($result)
	{
		$result	= urldecode($result);				//URLת��
		$Arr = explode('&', $result);				//���� & ���Ų��
		
		$temp = array();							//��ʱ��Ų�ֵ�����
		$myArray = array();							//��ǩ��������
		//ѭ������key��value����
		for ($i = 0; $i < count($Arr); $i++) {
			$temp = explode( '=' , $Arr[$i] , 2 );
			$myArray[$temp[0]] = $temp[1];
		}
//print_r($myArray);
		$sign = $myArray['sign'];	//echo ' aaaa'.$sign;exit();											//֧��������ǩ��
		$myArray = para_filter($myArray);										//�����Ϻ������

		$sort_array = arg_sort($myArray);										//��������
		$this->mysign = build_mysign($sort_array,$this->_key,$this->sign_type);	//���챾�ز���ǩ�������ڶԱ�֧���������ǩ��

		if($this->mysign == $sign)	//�ж�ǩ���Ƿ���ȷ
		{
			return getDataForXML($myArray['res_data'],'/direct_trade_create_res/request_token');	//����token
		}
		else
		{
			echo('ǩ������ȷ');		//���жϳ�ǩ������ȷ���벻Ҫ��ǩͨ��
			return 'ǩ������ȷ';
		}
	}













	/**
	 * PHP Crul�� ģ��Post�ύ��֧��������
	 * ���ʹ��Crul ����Ҫ��һ�����php.ini�ļ������ã��ҵ�php_curl.dllȥ��ǰ���";"������
	 * ���� $data
	 */
	function post($gateway_url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $gateway_url);				//�������ص�ַ
		curl_setopt($ch, CURLOPT_HEADER, 0);						//����HTTPͷ
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);							//����post�ύ
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->req_data);		//post��������
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}


}

?>