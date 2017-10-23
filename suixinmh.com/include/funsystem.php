<?php
/**
 * ������ϵͳ��غ���
 *
 * ������ϵͳ��غ���
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    system
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: funsystem.php 243 2008-11-28 02:59:57Z juny $
 */

/**
 * ��ȡzend optimizer �汾
 * 
 * @param      void
 * @access     public
 * @return     string
 */
function jieqi_zendoptimizerver(){
	ob_start();
	phpinfo();
	$phpinfo=ob_get_contents();
	ob_end_clean();
	preg_match('/Zend(\s|&nbsp;)Optimizer(\s|&nbsp;)v([\.\d]*),/is', $phpinfo, $matches);
    if(!empty($matches[3])) return $matches[3]; 
    else return '';
}
function is_weixin()
{
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
		return true;
	}
	return false;
}
function is_weibo()
{
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'Weibo') !== false ) {
		return true;
	}
	return false;
}
function get_user_agent() {
	if (is_weixin()) {
		return 1;
	}
	elseif (is_weibo()) {
		return 2;
	}
	else {
		return 0;
	}
}
?>