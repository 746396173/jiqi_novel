<?php
/*
	[Cms news] (C) 2009-2010 Cms Inc.
	$Id: model.inc.php  2010-04-13 17:15:09Z huliming $
*/
if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}
getparameter('modelid');
//��ʼ�����ģ�������б�
$_OBJ['model'] = new Model();

//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
$_OBJ['category'] = new Category();
$_PAGE['posturl'] = $_OBJ['category']->getPosturl($catid);//���ύURL
//�ڶ�����������£�����ַҪ�͸���������URL����һ�£����򸽼��ϴ������
if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);

$statu = false;

if($op == 'del') {//ɾ��

	if($_OBJ['model']->deleteModel($_PAGE['modelid'])) jieqi_jumppage('?ac=model', LANG_NOTICE, LANG_DO_SUCCESS);
	else jieqi_jumppage('?ac=model', lang_replace('message_notice'), LANG_DO_FAILURE);
	
}elseif($op == 'disable'){//����
    getparameter('disabled');
	if($_PAGE['modelid'] && isset($_PAGE['disabled'])){
	    if($_OBJ['model']->edit($_PAGE['modelid'],array('disabled'=>$_PAGE['disabled']))){
		   jieqi_jumppage('?ac=model', lang_replace('message_notice'), LANG_DO_SUCCESS);
		}else jieqi_printfail(LANG_DO_FAILURE); 
	}
	
}elseif($op == 'order'){//����
    //��Ŀ����
	if(submitcheck("dosubmit")){
	     if($_OBJ['model']->order($_PAGE['modelid'], getparameter('order'))) jieqi_jumppage('?ac=model&op=fields&modelid='.$_PAGE['modelid'], LANG_NOTICE, LANG_DO_SUCCESS);
		 else jieqi_printfail(LANG_DO_FAILURE); 
	}
}elseif($op == 'add'){
	//�ύ����
	if(submitcheck("dosubmit")){
		 $data = getparameter('info');
		 //��������
		 if($_PAGE['modelid']){
		     unset($data['tablename']);//�����������޸�
		     $statu = $_OBJ['model']->edit($_PAGE['modelid'],$data); //�޸�
		 }else{
		     $data['pagefield'] = 'content';
			 if(!$_OBJ['model']->checkTable($data['tablename'])) jieqi_printfail(lang_replace('modeltable_error'));
			 elseif($_OBJ['model']->tableExists($data['tablename'])) jieqi_printfail(lang_replace('modeltable_is_exists'));
			 else $statu = $_OBJ['model']->addModel($data);//���� 
		 }
		 //��Ϣ
		 if($statu) jieqi_jumppage('?ac=model', lang_replace('message_notice'), LANG_DO_SUCCESS);
		 else jieqi_printfail(LANG_DO_FAILURE); 
	}

	//���ع���������
	new GlobalData('workflow', 'workflowid');
    //����޸�״̬
	if($_PAGE['modelid']){
		 //��ȡģ������
		 $_SGLOBAL['modelfield'] = $_OBJ['model']->get($_PAGE['modelid']);
		//�����ֶ�����
		include_once($_SGLOBAL['news']['path'].'/include/fields/fields.inc.php');
		//��ȡ��ҳ�ֶ�
		if(is_array($_SGLOBAL['fields_canpage'])){
			$_PAGE['fieldrows'] = $_OBJ['model']->getfields($_PAGE['modelid']);
			$_SGLOBAL['pagefields'] = array();
			foreach($_PAGE['fieldrows'] as $fieldinfo){
				if(in_array($fieldinfo['formtype'],$_SGLOBAL['fields_canpage'])){
					$_SGLOBAL['pagefields'][$fieldinfo['field']] = $fieldinfo['name'];
				}
			}
		}
	}
}elseif($op == 'deletefield'){

    if($_OBJ['model']->deleteField($_PAGE['modelid'], getparameter('fieldid'))){
	     jieqi_jumppage('?ac=model&op=fields&modelid='.$_PAGE['modelid'], lang_replace('message_notice'), LANG_DO_SUCCESS);
	} else jieqi_printfail(LANG_DO_FAILURE); 
    
}elseif($op == 'checktable'){
    header('Content-Type:text/html; charset='.USER_CHARSET); 
    $value = getparameter('value');

	if(!$_OBJ['model']->checkTable($value)){
	
		exit(lang_replace('modeltable_error'));
		
	}elseif($_OBJ['model']->tableExists($value)){
	
		exit(lang_replace('modeltable_is_exists'));
	}
	else{
		exit('success');
	}
}elseif($op == 'checkfield'){
    header('Content-Type:text/html; charset='.USER_CHARSET); 
    $value = getparameter('value');
	
	if(!$_OBJ['model']->check($value)){
	
		exit(lang_replace('modelfield_error'));
		
	}elseif($_OBJ['model']->exists($_PAGE['modelid'], $value)){
	
		exit(lang_replace('modelfield_is_exists'));
	}
	else{
		exit('success');
	}
    
}elseif($op == 'setting_add'){

	header('Content-Type:text/html; charset='.USER_CHARSET); 
	header ("Cache-Control: no-cache");
	getparameter('formtype');
	include($_SGLOBAL['news']['path'].'/include/fields/formelements.class.php');
    $incFile = $_SGLOBAL['news']['path'].'/include/fields/form_'.$_PAGE['formtype'].'.class.php';
	if(!is_file($incFile)) exit('');
    include_once($incFile);
	$className = "Form_{$_PAGE['formtype']}";
	$elementObject = new $className(new FormElements($_PAGE['modelid']), getparameter('field'));
	exit($elementObject->getFieldSetting($_PAGE['formtype']));
	
}elseif($op == 'model_field' || $op == 'copyfield'){
    getparameter('fieldid');
	//�ύ����
	if(submitcheck("dosubmit")){
	     $data = getparameter('info');
		 if(is_array(getparameter('unsetgroupids'))) $data['unsetgroupids'] = implode(',', $_PAGE['unsetgroupids']);
		 else $data['unsetgroupids'] = $_PAGE['unsetgroupids'];
		 $data['setting'] = saddslashes(arrayeval($_REQUEST['setting']));
		 if($_PAGE['fieldid']) $statu = $_OBJ['model']->editField($_PAGE['modelid'],$_PAGE['fieldid'],$data); //�޸�
		 else {//����
		     if(!$_OBJ['model']->check($data['field'])) jieqi_printfail(lang_replace('modelfield_error'));
			 elseif($_OBJ['model']->exists($_PAGE['modelid'], $data['field'])) jieqi_printfail(lang_replace('modelfield_is_exists'));
			 else $statu = $_OBJ['model']->addField($_PAGE['modelid'], $data);
		 }
		 //��Ϣ
		 if($statu) jieqi_jumppage('?ac=model&op=fields&modelid='.$_PAGE['modelid'], lang_replace('message_notice'), LANG_DO_SUCCESS);
		 else jieqi_printfail(LANG_DO_FAILURE); 
    }
	$_PAGE['active'] = $op;
    //�����ֶ�����
    include_once($_SGLOBAL['news']['path'].'/include/fields/fields.inc.php');
    $_PAGE['model'] = $_OBJ['model']->get($_PAGE['modelid']);//��ȡģ����ϸ����
	$_PAGE['field']['unsetgroupids'] = array();
	if($_PAGE['fieldid']){
	
		if(!$_PAGE['field'] = shtmlspecialchars($_OBJ['model']->getfieldid($_PAGE['modelid'], $_PAGE['fieldid']))){
		     jieqi_printfail(lang_replace('modelfield_not_exists'));
		}
		 
		$_PAGE['field']['unsetgroupids'] = explode(',', $_PAGE['field']['unsetgroupids']);
		
	}else unset($_SGLOBAL['fields']['pages']);
	unset($_SGLOBAL['_GROUPS'][JIEQI_GROUP_ADMIN]);
	
	$op = 'model_field';
	if($_PAGE['active']=='copyfield'){
	     unset($_PAGE['field']['fieldid']);
		 unset($_PAGE['field']['field']);
		 unset($_PAGE['field']['name']);
    }
	
}elseif($op == 'fields'){
    getparameter('disabled');
	getparameter('fieldid');
    if($_PAGE['fieldid'] && isset($_PAGE['disabled'])){//�޸��ֶ�
	    if($_OBJ['model']->editField($_PAGE['modelid'], $_PAGE['fieldid'], array('disabled'=>$_PAGE['disabled']))){
		   jieqi_jumppage('?ac=model&op=fields&modelid='.$_PAGE['modelid'], lang_replace('message_notice'), LANG_DO_SUCCESS);
		}else jieqi_printfail(LANG_DO_FAILURE);
	}
	
    include_once($_SGLOBAL['news']['path'].'/include/fields/fields.inc.php');
    $_PAGE['model'] = $_OBJ['model']->get($_PAGE['modelid']);
    //���ݻ�ȡ
	/*$_OBJ['model']->table = $_OBJ['model']->tablepre.'model_field';
	$_OBJ['model']->idfield = 'fieldid';
	$_OBJ['model']->setHandler();
	$_OBJ['model']->criteria->add(new Criteria('modelid', $_PAGE['modelid']));
	$_OBJ['model']->criteria->setSort('listorder');
	$_OBJ['model']->criteria->setOrder('ASC');*/
	$_PAGE['fieldrows'] = $_OBJ['model']->getfields($_PAGE['modelid']);
}else {//���
	
}
//$template = !$op ?'model' :"model_{$op}";
//template('admin/'.$template);
?>
