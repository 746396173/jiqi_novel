<?php
/*
    *�Ƽ�λ�����ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_form_posid.class.php 12398 2010-04-29 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_checkbox.class.php');
include_once($GLOBALS['jieqiModules']['news']['path'].'/include/position.class.php');
class Form_posid extends Form_checkbox
{

	//�����б���
	function setOptions(){
	    //$itemobj = new globaldata('position', 'posid', 'listorder');
		if(!is_object($_OBJ['position'])) $_OBJ['position'] = &new Position();
		foreach($_OBJ['position']->data as $k=>$v){
		    $this->addOption($k, $v['name']);
		}
		return true;
	}

    //��������
	function setValue($value){
		if($contentid = $this->formobj->getVar('contentid')){
		    global $_SGLOBAL, $_OBJ;
		    //$obj = new globaldata('position', 'posid', 'listorder');
			if(!is_object($_OBJ['position'])) $_OBJ['position'] = &new Position();
			$ret = array();
			foreach($_SGLOBAL['position'] as $k=>$v){
				if($v['data']){
				    if(in_array($contentid, explode(',', $v['data']))){
					   $ret[] = $k;
					}
				}
			}
			$this->value = $ret;
		}else{
		    $this->value = $value;
		}
	}

	//��ȡ���ύ����
	function getAdd($value){
	    $this->formobj->addListenter('posid', $value);
	    if(is_array($value)) return 1;
		else return 0;
	}
	
	//ɾ������ʱ����
	function getDelete(){
	    $this->formobj->addListenter('posid', '');
	}	
	
	//��ȡ�ֶ����ñ���
	function getFieldSetting($formtype){
	     global $_SGLOBAL, $_OBJ;
	     $this->setSetting();
		 
		 if(!is_object($_OBJ['position'])) $_OBJ['position'] = &new Position();
		 $defaultvalue = $this->setting['defaultvalue'] ?$this->setting['defaultvalue'] : array();
		 $position = '';
		 $checked = '';
		 $i = 0;
		 foreach($_SGLOBAL['position'] as $k=>$v){
			 $i++;
		     if(in_array($k, $defaultvalue)) $checked = 'checked';
			 $position.= "<span style=\"width:100px\"><input type=\"checkbox\" id='defaultvalue' boxid='defaultvalue' name=\"setting[defaultvalue][]\" value=\"{$k}\" {$checked}> {$v['name']} </span>";
			 if($i % 5 ==0) $position.= "<p>";
			 $checked = '';
		 }
	     include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form/posid.form.php');
	}
}
?>