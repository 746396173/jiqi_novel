<?php
/*
    *�û�ID�����ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_userid.class.php 12398 2010-07-19 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_hidden.class.php');

class Form_userid extends form_Hidden
{

    //��������
	function setValue($value){
	    global $_SGLOBAL;
	    $this->value = $_SGLOBAL['supe_uid'];
	}
	//��ȡ�ֶ����ñ���
	function getFieldSetting($data = array()){
	    //
	}
}
?>