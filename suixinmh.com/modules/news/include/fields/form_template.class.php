<?php
/*
    *ģ�������ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_template.class.php 12398 2010-05-24 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_select.class.php');

class Form_template extends Form_select
{
	//��ȡ���ݣ�ǰ̨��ʾ
	function getShow(){
		if($this->getValue()) $this->formobj->addListenter('template', $this->getValue());
	    return shtmlspecialchars($this->getValue());
	}
	
	//�����б���
	function setOptions(){
	    global $_SGLOBAL, $_OBJ;
		if($this->setting['items']) return false; //����Զ�����ģ���б���ʹ���Զ���ģ��
		else{ //�����Զ���ȡϵͳģ��
		    $items = array(''=>lang_replace('system_is_default'));
		    if($arr = gettemplate('file',"^show_{$this->formobj->model['tablename']}")) $items = array_merge($items, $arr);
			//print_r($arr);
			$this->addOptionArray($items);
		}
		return true;
	}	
	
}
?>