<?php
/*
    *��ѡ��Ŧ�����ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_radio.class.php 12398 2010-04-18 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_checkbox.class.php');

class Form_radio extends Form_checkbox
{

	function setFormObject(){
	    $this->element = new JieqiFormRadio('', "{$this->fieldpre}[{$this->field}]", $this->getValue());
	}
		//��ȡ���ύ����
	function getAdd($value){
	    if($value){
		   if(is_array($value)){
		       return implode(',', $value);
		   }else return $value;
		}else return '';
	}    //��������
	function setValue($value){
	    $this->value = $value;
	}
}
?>