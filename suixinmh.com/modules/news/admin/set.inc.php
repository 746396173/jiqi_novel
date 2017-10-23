<?php
/*
	[Cms news] (C) 2009-2010 Cms Inc.
	$Id: content.inc.php  2010-04-09 17:15:09Z huliming $
*/
if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}
//��ҳ����
getparameter('page','int');


//��ʼ������
$table = $file;
$idfield = 'id';
$listorder = 'listorder';

$_OBJ['view'] = new View($table, $idfield);
$_OBJ['view']->setHandler();

if($op == 'add'){
    //�ύ����
	if(submitcheck("dosubmit")){
	   //д������
	   if($file=='keyword'){
	       $_PAGE['data'] = getparameter('info');
	       if(getparameter('id','int')){//�޸�
		       if(getparameter('parentids')=='') unset($_PAGE['data']['parentid']);
		       if($_OBJ['view']->edit($_PAGE['id'],$_PAGE['data'],false)) jieqi_jumppage(getparameter('jumpurl'), LANG_NOTICE, LANG_DO_SUCCESS);
			   else jieqi_jumppage(getparameter('jumpurl'), LANG_NOTICE, LANG_DO_FAILURE); 
		   }else{//�ؼ�������¼��
			   $data = explode("\r\n", $_PAGE['data']['tag']);
			   foreach($data as $k=>$v){
				   $_PAGE['data']['tag'] = $v;
				   $_OBJ['view']->add($_PAGE['data']);
			   }
			   jieqi_jumppage($_SGLOBAL['refer'], LANG_NOTICE, LANG_DO_SUCCESS);
		   }
	   }else{
		   if($_OBJ['view']->add(getparameter('info'))) jieqi_jumppage($_SGLOBAL['refer'], LANG_NOTICE, LANG_DO_SUCCESS);
		   else jieqi_jumppage($_SGLOBAL['refer'], LANG_NOTICE, LANG_DO_FAILURE); 
	   }
	}
	if($file=='keyword'){
		$_OBJ['view']->criteria->add(new Criteria('issystem', 1));
		$_OBJ['view']->criteria->add(new Criteria('parentid', 0));
		if($listorder){
			$_OBJ['view']->criteria->setSort("{$listorder} DESC,{$idfield}");
			$_OBJ['view']->criteria->setOrder('DESC');
		}else{
			$_OBJ['view']->criteria->setSort($idfield);
			$_OBJ['view']->criteria->setOrder('DESC');
		}
		$_PAGE['rows'] = $_OBJ['view']->lists();
		getparameter('id','int');
		if($_PAGE['id']) $_PAGE['data'] = $_OBJ['view']->get($_PAGE['id']);
	}
}elseif($op == 'del'){
	if(!getparameter('id','int')) jieqi_printfail(LANG_ERROR_PARAMETER);
	$ids = array();//��Ŵ�ɾ��������ID����
	if(!is_array($_PAGE['id']))  $ids[] = $_PAGE['id'];
	else  $ids = $_PAGE['id'];
	foreach($ids as $k=>$id){
	    $_OBJ['view']->delete($id);
	}
	jieqi_jumppage("?ac=set&file={$_PAGE['file']}", LANG_NOTICE, LANG_DO_SUCCESS); 
}elseif($op == 'order'){
    //����
	if(submitcheck("dosubmit")){
	     if($_OBJ['view']->order(getparameter('order'))) jieqi_jumppage($_SGLOBAL['refer'], lang_replace('message_notice'), LANG_DO_SUCCESS);
		 else jieqi_jumppage($_SGLOBAL['refer'], lang_replace('message_notice'), LANG_DO_FAILURE); 
	}
}else {
    if($file=='keyword'){
	    getparameter('keytype');
	    if($_PAGE['keytype']=='keyword') $_OBJ['view']->criteria->add(new Criteria('tag', '%'.getparameter('keyword').'%', 'like'));
		elseif($_PAGE['keytype']=='parentid') $_OBJ['view']->criteria->add(new Criteria('parentid', getparameter('keyword','int')));
		elseif($_PAGE['keytype']=='id') $_OBJ['view']->criteria->add(new Criteria('id', getparameter('keyword','id','int')));
		elseif($_PAGE['keytype']=='issystem') $_OBJ['view']->criteria->add(new Criteria('issystem', 1)); 
	}
	if($listorder){
		$_OBJ['view']->criteria->setSort("{$listorder} ASC,{$idfield}");
		$_OBJ['view']->criteria->setOrder('DESC');
	}else{
	    $_OBJ['view']->criteria->setSort($idfield);
		$_OBJ['view']->criteria->setOrder('DESC');
	}
	$_PAGE['rows'] = $_OBJ['view']->lists($_SCONFIG['pagenum'] ?$_SCONFIG['pagenum'] :40, $_PAGE['page']);
	$_PAGE['url_jumppage'] = $_OBJ['view']->getPage('');
	$_PAGE['totalcount'] = $_OBJ['view']->getVar('totalcount');
}
?>
