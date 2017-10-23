<?php
/*
    *�ı������ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_text.class.php 12398 2010-04-18 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}
class Form_text extends JieqiObject
{
    var $formobj;             //������
    var $field;               //�ֶ���
	var $value;               //�ֶ�ֵ
	var $pagefield = false;   //��ҳ�ֶ�
	var $fieldinfo = array(); //�ֶ�����
	var $setting = array();   //�ֶ�������Ϣ
	var $element;             //���ɱ����ݶ���
	var $fieldpre = 'info';   //�ֶ�������������

//���캯����ʼ������
	function __construct($formobj, $field, $value = ''){
	    $this->formobj = $formobj;
	    $this->field = $field;
		$this->setValue($value);
		$this->fieldinfo = $this->formobj->fields[$this->field];
		if($this->formobj->model['pagefield']==$this->field) $this->pagefield = true;
		elseif(!$this->formobj->model['pagefield'] &&  $this->fieldinfo['formtype']=='editor') $this->pagefield = true;
	}

    //��������
	function setValue($value){
	    $this->value = $value;
	}

    //��ȡ����
	function getValue(){
	    return $this->value;
	}
	
    //���ñ�����
    function setFormObject(){
	    $this->fieldinfo['maxlength'] = !$this->fieldinfo['maxlength'] ? 100 :$this->fieldinfo['maxlength'];
	    $this->element = new JieqiFormText('', "{$this->fieldpre}[{$this->field}]", $this->setting['size'], $this->fieldinfo['maxlength'], $this->getValue());
	}
	
	//���ñ�����
	function setForm(){
		$this->element->setExtra($this->fieldinfo['formattribute']);
		return $this->element->render();
	}
	
    //��ȡ������
	function getForm(){
	    return $this->setForm();
	}
	
	//��ȡ���ύ����
	function getAdd($value){
	    return shtmlspecialchars($this->getValue());
	}
	
	//��ȡ���ݣ�ǰ̨��ʾ
	function getShow(){
	    //return shtmlspecialchars($this->getValue());
		return trim($this->getValue());
	}
		
	//ɾ������ʱ����
	function getDelete(){
	    //
	}	
	
	//����ȫ�������Ĵ�������
	function setFullText(){
	    return $this->value;
	}	
	
	// ȫ�������Ĵ�������
	function getFullText(){
	    return $this->setFullText();
	}

    //����ɼ�����
	function formatCollect($collectObj){
	    return $this->value;
	}

    //����ɼ�����
	function getCollectForm($data){
	     global $_SGLOBAL;
	     extract($this->fieldinfo);
	     $star = $this->fieldinfo['minlength'] ? 1 : 0;
		 //$this->setSetting();
		 if($data) $page_action = 'edit';
		 else $page_action = 'add';
		 $tempform = $GLOBALS['jieqiModules']['news']['path'].'/include/fields/form/'.$formtype.'.collect.php';
		 $tempform = is_file($tempform) ? $tempform : $GLOBALS['jieqiModules']['news']['path'].'/include/fields/form/text.collect.php';
		 ob_start();
	     include($tempform);
		 $formstr = ob_get_contents();
		 ob_end_clean();
		 return $formstr;
	}
		
	//�����ֶ�setting
	function setSetting(){
		if($this->fieldinfo['setting']!=''){
			eval('$setting['.$this->field.'] = '.$this->fieldinfo['setting'].';');
			$this->setting = $setting[$this->field];
			if(!$this->getValue() && !$this->formobj->getVar('contentid')) $this->setValue($this->setting['defaultvalue']);
		}
	}
	
    //��ȡ������
	function getContent(){
		$this->setSetting();
		$errortips = $this->fieldinfo['errortips'];
		$this->fieldinfo['errortips'] = $errortips ?$errortips :lang_replace('form_data_error');
		if($this->fieldinfo['minlength']) $this->fieldinfo['formattribute'].='require="true" datatype="limit" msg="'.$this->fieldinfo['errortips'].'" ';
		elseif($errortips) $this->fieldinfo['formattribute'].='require="false" datatype="limit" msg="'.$this->fieldinfo['errortips'].'" ';
		
	  	//���ñ�����
		if(!is_object($this->element)) $this->setFormObject();
		return $this->formatContent($this->getForm());
	}
	
	//��ȡ�ֶ����ñ���
	function getFieldSetting($formtype){
	     global $_OBJ,$_SCONFIG,$_SGLOBAL;
	     $this->setSetting();
		 if($this->fieldinfo['formtype']) $classname = $this->fieldinfo['formtype'];
		 else  $classname = $formtype;
		 //��ʼ������
		 $thumb_width = $thumb_height = $attachwimage = $defaultvalue = '';
		 $width = '100%';//�༭���Ŀ�͸�
		 $height = 250;
		 $enabledescription = 0; //ͼƬ�����ϴ�����Ƿ�����ͼƬ���Զ����䱸ע
		 $maxnumber = '1';
		 $thumb_enable = $attachwater = '-1';
		 $enablesaveimage = $enablesaveflash = $enablehtml = $multiple = $decimaldigits = $enablesavefile = 0;
		 $maxsize = '1024';
		 $fieldtype = 'CHAR';
		 if(!in_array($classname,array('file','files','video'))) $fileextname = 'jpg,jpeg,gif,png,bmp';
		 elseif($classname=='video') $fileextname = 'rm,wma,wmv,mp4,flv';
		 else $fileextname = '';
		 $savefileext = 'mp3|rar|zip';
		 $isselectimage = $minnumber = $defaulttype = 1;
		 $toolbar = 'basic';
		 $items = '';//lang_replace('model_default_items');
		 if(!in_array($classname,array('select', 'template'))) $size = 50; else $size = 1;
		 $rows = 10;
		 $cols = 60;
		 $format = 'Y-m-d H:i:s';

		 if($this->setting){
		    $page_action = 'edit';
			extract($this->setting);
		 }else $page_action = 'add';
		 $tempform = $GLOBALS['jieqiModules']['news']['path'].'/include/fields/form/'.$classname.'.form.php';
		 $tempform = is_file($tempform) ? $tempform : $GLOBALS['jieqiModules']['news']['path'].'/include/fields/form/text.form.php';
	     include_once($tempform);
	}
	
	function formatContent($content){
		//��������
		$farray = array();
		$rarray = array();
		
		$farray[] = "/id=\"{$this->fieldpre}\[.*?\]\"/i";
		$rarray[] = "id=\"{$this->field}\"";
		//if($this->fieldinfo['css']){
		$farray[] = "/class=\"(textarea|text)\"/i";
		$rarray[]=$this->fieldinfo['css'] ?"class=\"{$this->fieldinfo['css']}\"" :'';
		//}
		if(!$this->setting['size']){
			$farray[] = "/size=\".*?\"/i";
			$rarray[]='';
		}
/*		if(!$this->setting['maxlength']){
			$farray[] = "/maxlength=\".*?\"/i";
			$rarray[]='';
		}*/
		return preg_replace($farray, $rarray, $content);
	}
}
?>