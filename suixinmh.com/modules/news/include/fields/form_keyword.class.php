<?php
/*
    *�ؼ��������ֶ�ģ��
	[Cms News] (C) 2010-2012 Cms Inc.
	$Id: form_keyword.class.php 12398 2010-11-17 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_text.class.php');

class Form_keyword extends Form_text
{
	//���ñ�����
	function setForm(){
		$this->element->setExtra($this->fieldinfo['formattribute']);
		$fieldtext = $this->element->render();
		return $fieldtext.$this->setFormHtml();
	}
	
	//��ȡ���ύ����
	function getAdd($value){
	    global $_SGLOBAL;
	    $value = $this->getValue();
		if($value && !$this->formobj->getVar('contentid')){//������ڹؼ���,����Ϊ���޸�״̬
			$_OBJ['view'] = &new View('keyword', 'tag');//�趨KEYIDΪTAG�������ѯ
			$temparr = explode(' ', $value);
			foreach($temparr as $k => $v){
			    if(!$_OBJ['view']->get($v, true)){//������������
				    $_OBJ['view']->add(array('tag'=>$v,'usetimes'=>1,'lastusetime'=>$_SGLOBAL['timestamp'],'parentid'=>0,'issystem'=>0));
				}else{
				    $_OBJ['view']->edit($v, array('usetimes'=>'++','lastusetime'=>$_SGLOBAL['timestamp']));
				}
			}
			//print_r($temparr);exit;
		}
	    return shtmlspecialchars($this->getValue());
	}
		
	//���ñ����
	function setFormHtml(){
	    global $_OBJ;
	    $catid = $this->formobj->category['catid'];
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = &new Category();
		$attachurl = $_OBJ['category']->getAttachurl($catid);
	    $_OBJ['view'] = new View('keyword', 'id');
		$_OBJ['view']->setHandler();
		$_OBJ['view']->criteria->add(new Criteria('issystem', 1));
		$_OBJ['view']->criteria->add(new Criteria('parentid', 0));
		$_OBJ['view']->criteria->setSort("listorder DESC,id");
		$_OBJ['view']->criteria->setOrder('DESC');
		$_PAGE['rows'] = $_OBJ['view']->lists();
		ob_start();
		include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/keyword.inc.php');
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}
}
?>