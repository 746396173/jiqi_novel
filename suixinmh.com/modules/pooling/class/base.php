<?php
class  base extends JieqiObject{
	/**
	 * �Ƿ��һ���������һ�����������仺����
	 * @var unknown
	 */
	private $first_out = true;
	/**
	 * echoˢ�����
	 * @param unknown $msg	�������
	 * @param string $br	�Ƿ��<br/>
	 * 2014-9-9 ����11:36:25
	 */
	 public function out_msg($msg,$br=true) {
		if($br)$msg = $msg.'<br>';
		$this->out($msg);
	}
	/**
	 * ������쳣�����ɫ��Ϣ
	 *
	 * @param unknown $msg
	 *        	2014-7-17 ����10:05:18
	 */
	public function out_msg_err($msg) {
		$msg =  '<font color=red>' . $msg . '</font><br>';
		$this->out($msg);
	}
	/**
	 * �ײ��������������ݷ������Ĳ�ͬ�Զ���仺������
	 * @param unknown $msg
	 */
	private function out($msg){
		$sapi = php_sapi_name();
		if($sapi == 'cgi-fcgi'){
			echo str_pad($msg,1024*64);
		}else{
			if($this->first_out){
				echo str_repeat(' ',4096);
				$this->first_out = false;
			}
			echo $msg;
		}
		ob_flush();
		flush();
	}
	/**
	 * ��ʼ��DB�������Ҫ�������ݿ⣬��������Ĺ��캯���е��ã��Ա�֤������Է������ݿ����
	 * 2014-7-1 ����4:22:15
	 */
 	protected function initDB(){
		if (! is_object ( $this->db )) {
			$this->db = Application::$_lib ['database'];
		}
	}
	/**
	 * ��ȫxml
	 * <p>
	 * \v����ֱ���з���ASCII=11��֮�������xml�޷�����
	 * <p>
	 *  xml�����<![CDATA[ ]]>����Ȼ���ԷŸ��ָ����������ַ�����������Щ�ַ��Ų���ȥ��
	 *  ��Ϊxml������ַ���Χ��"#x9 | #xA | #xD | [#x20-#xD7FF] | [#xE000-#xFFFD] | [#x10000-#x10FFFF]"��
	 *  Ҳ����˵\x00-\x08,\x0b-\x0c,\x0e-\x1f�������ַ��ǲ�������ֵ�
	 * @param unknown $xml
	 * @return unknown
	 */
	protected function saleXml($xml){
		$xml = preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/","",$xml);
		return $xml;
	}
}
?>