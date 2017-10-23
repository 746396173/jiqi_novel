<?php
/**
 * ��־�����ຯ��
 *
 * ��־�����ຯ��
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    system
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: hlm $
 */

/**
 * ��������ʵ�����󣬷����ʺ�ģ�帳ֵ��������Ϣ����
 * 
 * @param      object      $ary ��־��������
 * @access     public
 * @return     array
 */
 
     function jieqi_logs_set($ary){
	     if(is_array($ary)){
				include_once(JIEQI_ROOT_PATH.'/class/userlog.php');
				//��¼��־
				$userlog_handler = JieqiUserlogHandler::getInstance('JieqiUserlogHandler');
				$newlog=$userlog_handler->create();
				$newlog->setVar('siteid', JIEQI_SITE_ID);
				$newlog->setVar('logtime', JIEQI_NOW_TIME);
				$newlog->setVar('fromid', $_SESSION['jieqiUserId']);
				$newlog->setVar('fromname', $_SESSION['jieqiUserName']);
				$newlog->setVar('toid', $ary['toid']);
				$newlog->setVar('toname', $ary['toname']);
				$newlog->setVar('reason', $ary['reason']);
				$newlog->setVar('chginfo', jieqi_userip().$ary['chginfo'].$_SERVER['HTTP_REFERER']);
				$newlog->setVar('chglog', serialize($ary['chglog']));
				$newlog->setVar('isdel', $ary['isdel'] ?$ary['isdel'] :0);
				$newlog->setVar('userlog', $ary['userlog']);
				if($userlog_handler->insert($newlog)) return true;
				else return true;
		 }
		 return false;
     }
?>