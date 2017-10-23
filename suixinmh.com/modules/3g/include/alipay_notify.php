<?php
/*
 *������alipay_notify
 *���ܣ���������з�����֪ͨ��
 *��ϸ����ҳ����֪ͨ���غ��Ĵ����ļ�������Ҫ�޸�
 *�汾��2.0
 *���ڣ�2011-09-01
 *˵����
 *���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 *�ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���
*/

////////////////////ע��/////////////////////////
//����֪ͨ����ʱ���ɲ鿴���дlog��־��д��TXT������ݣ������֪ͨ�����Ƿ�����
/////////////////////////////////////////////////

require_once("alipay_function.php");

class alipay_notify {
    var $gateway;           //���ص�ַ
    var $_key;			  	//��ȫУ����
    var $partner;           //�������ID
    var $sign_type;         //ǩ����ʽ ϵͳĬ��
    var $mysign;            //ǩ�����
    var $_input_charset;    //�ַ������ʽ

    /**���캯��
	 * �������ļ��г�ʼ������
	 * $partner ���������ID
	 * $key ��ȫУ����
	 * $sign_type ǩ������
	 * $_input_charset �ַ������ʽ
     */
    function alipay_notify($partner,$key,$sign_type,$_input_charset) {
		$this->gateway = "http://wappaygw.alipay.com/service/rest.htm?";
		
        $this->partner          = $partner;
        $this->_key				= $key;
        $this->mysign           = "";
        $this->sign_type	    = $sign_type;
        $this->_input_charset   = $_input_charset;
    }

    /********************************************************************************/

    /**��notify_url����֤
	 *���ص���֤�����true/false
     */
    function notify_verify() {
		//�ж�POST���������Ƿ�Ϊ��
		if(empty($_POST)) {
			return false;
		}
		else {
			//�˴�Ϊ�̶�˳��֧����Notify������Ϣ֪ͨ�Ƚ����⣬���ﲻ��Ҫ��������
			$notifyarray = array(
				"service"		=> $_POST['service'],
				"v"				=> $_POST['v'],
				"sec_id"		=> $_POST['sec_id'],
				"notify_data"	=> $_POST['notify_data']
			);

			$this->mysign = build_mysign($notifyarray,$this->_key,$this->sign_type);
			
			//��¼��־�������ã�
			//log_result($this->mysign . ' ' . $_POST["sign"]);
	
			//�ж�veryfy_result�Ƿ�Ϊture�����ɵ�ǩ�����mysign���õ�ǩ�����sign�Ƿ�һ��
			//mysign��sign���ȣ��밲ȫУ���롢����ʱ�Ĳ�����ʽ���磺���Զ�������ȣ��������ʽ�й�
			if ($this->mysign == $_POST["sign"]) 
			{
				return true;
			} 
			else 
			{
				return false;
			}
		}
    }

    /********************************************************************************/

    /**��return_url����֤
	 *return ��֤�����true/false
     */
    function return_verify() {
        //�ж�GET���������Ƿ�Ϊ��
		if(empty($_GET)) {
			return false;
		}
		else {
			$get          = para_filter($_GET);	    //������GET��������������ȥ��
			$sort_get     = arg_sort($get);		    //������GET������������������
			$this->mysign = build_mysign($sort_get,$this->_key,$this->sign_type);    //����ǩ�����
	
			if ($this->mysign == $_GET["sign"]) {            
				return true;
			}else {
				return false;
			}
		}
    }
}
?>
