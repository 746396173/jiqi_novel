<?php
/*
    *��̬���������ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_vars.class.php 12398 2011-01-07 09:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_textarea.class.php');

class Form_vars extends Form_textarea
{
	//���ñ�����
	function setForm(){
	    global $_SCONFIG;
		$this->fieldinfo['formattribute'] .=' style="display:none"';
		$this->element->setExtra($this->fieldinfo['formattribute']);
		$fieldtext = $this->element->render();
		return $fieldtext.$this->setFormHtml();

	}
	
	//��ȡ���ύ����
	function getAdd($value){
	    $this->setSetting();
		$value = $_REQUEST[$this->field.'_content'];
		if(!$this->setting['enablehtml'] && $value) $value = shtmlspecialchars($value);
		$envalue = is_array($value) ? serialize($value) : '';
		$this->setValue($envalue);
	    return saddslashes($envalue);
	}
	
	//���ñ����
	function setFormHtml(){
	    global $_OBJ,$_SCONFIG;
		$catid = $this->formobj->category['catid'];
		$modelid = $this->formobj->category['modelid'];
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = &new Category();
		$attachurl = $_OBJ['category']->getAttachurl($catid);
		$vars = array();
		if($this->getValue()){
			$vars = unserialize($this->getValue());
		}elseif(!$this->formobj->getVar('contentid')){
		    $vars = $this->setting['vars'];
		}
		ob_start();
		include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/vars.inc.php');
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}
	
	//��ȡ���ݣ�ǰ̨��ʾ
	function getShow(){
	    global $_OBJ;
		if($this->getValue()) $ret = unserialize($this->getValue());
		if($this->formobj->model['pagefield']==$this->field) $this->formobj->setVar('___content', array("content"=>$ret));
		return $ret;
	}
	//��ȡȫ�������Ĵ�������
	function setFullText(){
	    $ret = '';
	    if($this->getValue()){
		   $ret = unserialize($this->getValue());
		   $ret = implode(' ', $ret);
		}
		return $ret;
	}	
}
?>