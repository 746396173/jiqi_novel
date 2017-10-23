<?php
/*
	[Cms news] (C) 2010-2012 Cms Inc.
	$Id: collectset.inc.php  2010-07-29 10:55:09Z huliming $
*/
if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

//��ʼ�����ģ�������б�
$_OBJ['model'] = new Model();
//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
$_OBJ['category'] = new Category();
$_PAGE['posturl'] = $_OBJ['category']->getPosturl($catid);//���ύURL
$_PAGE['attachurl'] = $_OBJ['category']->getAttachurl($catid);//����URL������
include_once($_SGLOBAL['news']['path'].'/include/collect.class.php');
//��ʼ����ǩ����
$_OBJ['collect'] = new Collect();
if($op == 'add'){
    getparameter('collectid');
	//�ύ����
	if(submitcheck("dosubmit")){
	
		$data = getparameter('info');
	    //$data['modelid'] = $_PAGE['_POST']['modelid'] ?$_PAGE['_POST']['modelid'] :$_PAGE['_GET']['modelid'];
		$data['modelid'] = getparameter('modelid');
		if(!$data['modelid']) jieqi_printfail(LANG_ERROR_PARAMETER); 
		
		$data['setting'] = saddslashes(arrayeval($_REQUEST['setting']));
		//$data['task'] = saddslashes(arrayeval($_REQUEST['task']));
		$data['updatetime'] = $_SGLOBAL['timestamp'];
		$data['disabled'] = 0;
		 //��������
		 if($_PAGE['collectid']){
		     $statu = $_OBJ['collect']->edit($_PAGE['collectid'],$data); //�޸�
			 $collectid = $_PAGE['collectid'];
		 }else{
		     $data['inputtime'] = $_SGLOBAL['timestamp'];
			 $statu = $_OBJ['collect']->add($data);//���� 
			 $collectid = $statu;
		 }
		 //��Ϣ
		 if($statu){
		    $_OBJ['collect']->cacheOne($collectid);
		    jieqi_jumppage('?ac=collectset', lang_replace('message_notice'), LANG_DO_SUCCESS);
		 } else jieqi_printfail(LANG_DO_FAILURE); 
		
	}
	if($_PAGE['collectid']){
	    $_PAGE['collect'] = shtmlspecialchars($_OBJ['collect']->get($_PAGE['collectid']));
	}else $_PAGE['collect']['modelid'] = getparameter('modelid');
	
	if($_PAGE['collect']['modelid']){
		include_once($_SGLOBAL['news']['path'].'/include/fields/fields.inc.php');
		if($_SGLOBAL['modelfield'] = $_OBJ['model']->get($_PAGE['collect']['modelid'])){
			if($_SGLOBAL['modelfield']['disabled']) jieqi_printfail(lang_replace('model_not_exists')); 
		}else jieqi_printfail(lang_replace('model_not_exists'));
		//���ر�������
		include_once($_SGLOBAL['news']['path'].'/include/fields/formelements.class.php');
		$elements = new FormElements($_PAGE['collect']['modelid']);
		//$_PAGE['form'] = $elements->getElements(array());
		$_PAGE['form'] = $elements->getCollectElements($_PAGE['collect']['setting']['fields']);
	}
	
}elseif($op == 'task') {//�ɼ�����
	getparameter('collectid');
	$_PAGE['collect'] = $_OBJ['collect']->get($_PAGE['collectid']);
	$indexs = getparameter('index');
	//ɾ������
	if($step=='del'){
	    $data = $_PAGE['collect']['task'];
		if(!is_array($indexs)) $indexs = array($indexs);
		$statu = false;
		foreach($indexs as $k=>$index){
			if(!array_key_exists($index, $_PAGE['collect']['task'])) continue;
			unset($data[$index]);
		}
		$data = array_values($data);
		if($_OBJ['collect']->edit($_PAGE['collectid'],array('task'=>saddslashes(arrayeval($data))))){
			$_OBJ['collect']->cacheOne($_PAGE['collectid']);
		    jieqi_jumppage('?ac=collectset&op=task&collectid='.$_PAGE['collectid'], lang_replace('message_notice'), LANG_DO_SUCCESS);
		} else jieqi_printfail(LANG_DO_FAILURE); 
	}
	
    //�ύ����
	if(submitcheck("dosubmit")){
	    $data = $temp = array();
		if($_PAGE['collect']['task']) $data = $_PAGE['collect']['task'];
		
		    $temp = $_REQUEST['setting'];
		    $temp['fields'] = $_PAGE['collect']['setting']['fields'];
		    if($_REQUEST['setting']['fields']!=$_PAGE['collect']['setting']['fields']){
			    $temp['fields'] = $_REQUEST['setting']['fields'];
			}else{
				$temp['fields'] = array();
			}

	    //��������
		if(isset($_PAGE['index']) && $_PAGE['index']!=''){
		    
			if(!array_key_exists($_PAGE['index'], $_PAGE['collect']['task'])) jieqi_printfail(LANG_ERROR_PARAMETER); 
			$data[$_PAGE['index']] = $temp;
			
		}else{
		
		    $data[] = $temp;
			
		}
		if($_OBJ['collect']->edit($_PAGE['collectid'],array('task'=>saddslashes(arrayeval($data))))){
			$_OBJ['collect']->cacheOne($_PAGE['collectid']);
		    jieqi_jumppage('?ac=collectset&op=task&collectid='.$_PAGE['collectid'], lang_replace('message_notice'), LANG_DO_SUCCESS);
		} else jieqi_printfail(LANG_DO_FAILURE); 
	}
	
	//������������޸ı�
	if($_PAGE['collect']['modelid'] && $step=='add'){
		if(isset($_PAGE['index']) && $_PAGE['index']!=''){//�޸�����ʱִ��
		
		    if(!array_key_exists($_PAGE['index'], $_PAGE['collect']['task'])) jieqi_printfail(LANG_ERROR_PARAMETER); 
			$fields = $_PAGE['collect']['setting']['fields'];
			$_PAGE['collect']['setting'] = $_PAGE['collect']['task'][$_PAGE['index']];
		    if(!$_PAGE['collect']['task'][$_PAGE['index']]['fields']){
			    $_PAGE['collect']['setting']['fields'] = $fields;
			}
		}
		include_once($_SGLOBAL['news']['path'].'/include/fields/fields.inc.php');
		if($_SGLOBAL['modelfield'] = $_OBJ['model']->get($_PAGE['collect']['modelid'])){
			if($_SGLOBAL['modelfield']['disabled']) jieqi_printfail(lang_replace('model_not_exists')); 
		}else jieqi_printfail(lang_replace('model_not_exists'));
		//���ر�������
		include_once($_SGLOBAL['news']['path'].'/include/fields/formelements.class.php');
		$elements = new FormElements($_PAGE['collect']['modelid']);
		//$_PAGE['form'] = $elements->getElements(array());
		$_PAGE['collect'] = shtmlspecialchars($_PAGE['collect']);
		$_PAGE['form'] = $elements->getCollectElements($_PAGE['collect']['setting']['fields']);
		//��ȡ��Ŀ
		$_OBJ['category']->get_format();
	}else{//�����б�
	    $_PAGE['task'] = $_PAGE['collect']['task'];
	}
	
}elseif($op == 'order'){
    //����
	if(submitcheck("dosubmit")){
	     if($_OBJ['collect']->order(getparameter('order'))) jieqi_jumppage('?ac=collectset', lang_replace('message_notice'), LANG_DO_SUCCESS);
		 else jieqi_jumppage('?ac=collectset', lang_replace('message_notice'), LANG_DO_FAILURE); 
	}
}elseif($op == 'del') {//ɾ��
    $collect = getparameter('collectid');
	if(!is_array($collect)) $collect = array($collect);
	$statu = false;
	foreach($collect as $k=>$collectid){
	    if(!$collectid) continue;
		$statu = $_OBJ['collect']->delete($collectid);
	}
	if($statu) jieqi_jumppage('?ac=collectset', LANG_NOTICE, LANG_DO_SUCCESS);
	else jieqi_jumppage('?ac=collectset', LANG_NOTICE, LANG_DO_FAILURE);
}else {//���
	//�ڶ�����������£�����ַҪ�͸���������URL����һ�£����򸽼��ϴ������
	if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);
	getparameter('page');;
	$_OBJ['collect']->setHandler();
	$_OBJ['collect']->criteria->setSort('listorder');
	$_OBJ['collect']->criteria->setOrder('ASC');
	$_PAGE['rows'] = $_OBJ['collect']->lists(30, $_PAGE['page']);
	$_PAGE['url_jumppage'] = $_OBJ['collect']->getPage();
}
//$template = !$op ?'collectset' :"collectset_{$op}{$step}";
//template('admin/'.$template);
?>
