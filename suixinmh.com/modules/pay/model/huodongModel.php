<?php 
/** 
 * ��ֵģ�� * @copyright   Copyright(c) 2014 
 * @author      zhangxue* @version     1.0 
 */ 
class huodongModel extends Model{ 
	//�麣��
	function main($params = array()){
//		define('JIEQI_EGOLD_NAME', '����');
		$params['cardno'] = trim($params['cardno']);
		$params['cardpass'] = trim($params['cardpass']);
		$auth = $this->getAuth();
		$this->db->init( 'paycard', 'cardid', 'pay' );
		$this->db->setCriteria(new Criteria( 'cardno', $params['cardno'], '=' ));
		if($paycard = $this->db->get($this->db->criteria)){
			if($paycard->getVar('ispay','n')) $this->printfail('��ֵ�����Ѿ���ʹ���ˣ��벻Ҫ�ظ��ύ��');
			if(strlen($params['cardno'])==14 && $paycard->getVar('cardpass','n')!=$params['cardpass']) $this->printfail('��ֵ�����벻��Ӧ���뷵�����ԣ�');
			include_once(JIEQI_ROOT_PATH.'/class/users.php');
			$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
			if($users_handler->income($auth['uid'], $paycard->getVar('payemoney','n'), $paycard->getVar('emoneytype','n'), 0)){
				$cardid = $paycard->getVar('cardid','n');
				$paycard->setVar('ispay',1);
				$paycard->setVar('paytime',JIEQI_NOW_TIME);
				$paycard->setVar('payuid',$auth['uid']);
				$paycard->setVar('payname',$auth['username']);
				if(!$this->db->edit($cardid, $paycard)){
					$this->printfail('ϵͳ���������ԣ�');
				}else{
					$buy_egold_success='��ϲ����%s:<br /><br />��ʹ�ó�ֵ��(%s)��%s �������Ѿ����ʣ����� <a href="/user" class="f14 f_blue" title="�����������">�����ʺ�</a>��<br /><br />��л�������ǵ�֧�֣�';
					$this->jumppage($_SERVER['HTTP_REFERER'], LANG_DO_SUCCESS, sprintf($buy_egold_success,$auth['username'],$paycard->getVar('cardno','n'),$paycard->getVar('payemoney','n')));
				}
			}else{
				$this->printfail('ϵͳ���������ԣ�');
			}
		}else{
			$this->printfail('���Ų�����!');
		}
	} 
} 

?>