<?php
/*
	[Cms news] (C) 2009-2010 Cms Inc.
	$Id: content.inc.php  2010-04-09 17:15:09Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}
$catid = getparameter('catid');

//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
$_OBJ['category'] = new Category();
$_PAGE['posturl'] = $_OBJ['category']->getPosturl($catid);//���ύURL
$_PAGE['attachurl'] = $_OBJ['category']->getAttachurl($catid);//����URL������
//���ݻ�ȡ��
$_OBJ['content'] = new Content();
$_OBJ['model'] = new Model();
//���ر�������
include_once($_SGLOBAL['news']['path'].'/include/fields/formelements.class.php');
if($op == 'check_title'){//�������Ƿ����

	header('Content-Type:text/html; charset='.USER_CHARSET);
	if($_OBJ['content']->checkTitle($_PAGE['_POST']['title'], array('modelid'=>$_SGLOBAL['category'][$catid]['modelid']))) exit((lang_replace('article_title_exists')));
	else exit(lang_replace('article_title_noexists'));
	
}elseif($op == 'check_field'){//��������������Ƿ����
    
	header('Content-Type:text/html; charset='.USER_CHARSET);
	$table = '';
	if(getparameter('mod')) $table = 'news_c_'.$_PAGE['mod'];
	if($_OBJ['content']->checkFields($_PAGE['_POST'], $table, array('modelid'=>$_SGLOBAL['category'][$catid]['modelid']))) exit(lang_replace('data_is_exists'));
	else exit(lang_replace('data_not_exists'));
	
}elseif($op == 'dict_word'){

	header('Content-Type:text/html; charset='.USER_CHARSET); 
	$word = dictwrod($_PAGE['_POST']['data']);
	exit($word ?implode(' ', $word) :'');
	
}elseif($op == 'keywords'){
    if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);
	$contentid = $_PAGE['_GET']['contentid'] ?$_PAGE['_GET']['contentid'] :$_PAGE['_POST']['contentid'];
	if(!$contentid || !getparameter('keywords')) printfail(LANG_ERROR_PARAMETER);
	$keywords = explode(' ', $_PAGE['keywords']);
	$contentids = array();//��Ŵ�ɾ��������ID����
	if(!is_array($contentid))  $contentids[] = $contentid;
	else  $contentids = $contentid;
	foreach($contentids as $k=>$contentid){
	    $tempkey = '';
        if(is_array($_PAGE['data'] = $_OBJ['content']->get($contentid, false))){
		    $keyarr = explode(' ', $_PAGE['data']['keywords']);
		    foreach($keywords as $k){
			    if(!in_array($k,$keyarr)) $tempkey.= $k.' ';
			}
			$tempkey = $tempkey.$_PAGE['data']['keywords'];
			
			$_OBJ['content']->edit(array('contentid'=>$contentid,'catid'=>$_PAGE['data']['catid'],'keywords'=>$tempkey));
		}
	}
	jumppage();
}elseif($op == 'del'){
    if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);
	$contentid = $_PAGE['_GET']['contentid'] ?$_PAGE['_GET']['contentid'] :$_PAGE['_POST']['contentid'];
	if(!$contentid) printfail(LANG_ERROR_PARAMETER);
	$contentids = array();//��Ŵ�ɾ��������ID����
	if(!is_array($contentid))  $contentids[] = $contentid;
	else  $contentids = $contentid;
	$i = 0;
	foreach($contentids as $k=>$contentid){
        if(is_array($_PAGE['data'] = $_OBJ['content']->get($contentid, true))){
			$catid = $_PAGE['data']['catid'];
			if($_SCONFIG['deletearticletorecycle'] && $_PAGE['_GET']['action']!='recycle'){//�������վ
			    if($_OBJ['content']->edit(array('contentid'=>$contentid,'catid'=>$catid,'status'=>0))) $i++;
			}else{
				//���ر�������
				$elements = new FormElements($_SGLOBAL['category'][$catid]['modelid'], $catid);
				if($elements->delete($_PAGE['data'])) $i++;
			}
		}
	}
	if($_SCONFIG['deletearticletorecycle'] && $_PAGE['_GET']['action']!='recycle') $lang = 'article_recycle_success';
	else $lang = 'article_delete_success';
	$param['content'] = lang_replace($lang, array($i));
	if($i) jumppage($param);
	else printfail(); 	
}elseif($op == 'check' && $_PAGE['_GET']['do']){
    $contentid = $_PAGE['_GET']['contentid'] ?$_PAGE['_GET']['contentid'] :$_PAGE['_POST']['contentid'];
	if(!$contentid) printfail(LANG_ERROR_PARAMETER);
	$contentids = array();//�������ID����
	if(!is_array($contentid))  $contentids[] = $contentid;
	else  $contentids = $contentid;
	if($_PAGE['_GET']['action']=='pass') $status = 99;
	elseif($_PAGE['_GET']['action']=='reject') $status = 1;
	else $status = intval($_PAGE['_GET']['action']);
	$i = 0;
	if($status==99){
	    //���ؾ�̬���ɶ�����
		include_once($_SGLOBAL['news']['path'].'/include/html.class.php');
		$_OBJ['html'] = new Html();
	}
	foreach($contentids as $k=>$contentid){
	     if(is_array($_PAGE['data'] = $_OBJ['content']->get($contentid, false))){
		     $catid = $_PAGE['data']['catid'];
			 if($_OBJ['content']->edit(array('contentid'=>$contentid,'catid'=>$catid,'status'=>$status))) $i++;
			 if($status==99) if($_OBJ['content']->isHtml(array('catid'=>$catid))) $_OBJ['html']->content($contentid);
		 }
	}
	if($i) jumppage();
	else printfail(); 
}elseif($op == 'add') {
    $_PAGE['data'] = array();
	//����޸�״̬
	if($_PAGE['_GET']['contentid']){
	    if(!is_array($_PAGE['data'] = $_OBJ['content']->get($_PAGE['_GET']['contentid']))) printfail(lang_replace('data_not_exists'));
		$catid = $_PAGE['data']['catid'];
	}
	
	$elements = new FormElements($_SGLOBAL['category'][$catid]['modelid'], $catid);
	
	//�ύ����
	if(submitcheck("dosubmit")){
		 if($_PAGE['_POST']['info']['contentid']){
		     if($elements->add($_PAGE['_POST']['info'])){ //�޸�
				 jumppage(array('content'=>lang_replace('edit_success')));
			 }else printfail(); 
		 }else{
		     //�жϱ����Ƿ����
			 if($_SCONFIG['samearticlename']<9){
			    if($elements->model['tablename']=='down'){
					if($_OBJ['content']->checkFields(array('title'=>$_PAGE['_POST']['info']['title'],'version'=>$_PAGE['_POST']['info']['version']), 'news_c_'.$elements->model['tablename'],array('modelid'=>$elements->model['modelid']))) printfail(lang_replace('article_title_exists'));
				} else {
					if($_OBJ['content']->checkTitle($_PAGE['_POST']['info']['title'],array('modelid'=>$elements->model['modelid']))) printfail(lang_replace('article_title_exists'));
				}
			 }
		     if($elements->add($_PAGE['_POST']['info'])){ //���
				 jumppage(array('content'=>lang_replace('add_success')));
			 }else printfail(); 
		 }
	}
	//�ڶ�����������£�����ַҪ�͸���������URL����һ�£����򸽼��ϴ������
	if($_PAGE['attachurl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['attachurl'].$_SERVER['REQUEST_URI']);
	
	//��ȡ��Ԫ���б�
	$_PAGE['form'] = $elements->getElements($_PAGE['data']);
	$_PAGE['form']['catid'] = $catid;
	
}elseif($op == 'manage' || $op == 'check') {//��Ϣ�б�
    if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);
    $_PAGE['page'] = getparameter('page');
	getparameter('modelid');
	if(getparameter('action')=='recycle') $_PAGE['_GET']['status']=0;
	
	new View('status', 'status');
	$_OBJ['content']->setHandler('count');
	$_OBJ['content']->criteria->setFields("a.*,c.hits,c.hits_day,c.hits_week,c.hits_month,c.hits_time,c.comments,c.comments_checked");
	$_OBJ['content']->criteria->setTables(jieqi_dbprefix('news_content')." AS a LEFT JOIN ".jieqi_dbprefix('news_content_count')." AS c ON a.contentid=c.contentid");

	if(!$catid){
		if($_PAGE['modelid']){
			foreach($_SGLOBAL['category'] as $k=>$v){
				if($v['modelid']==$_PAGE['modelid'] && $_OBJ['category']->islist($v['catid'])) $catids[] = $v['catid'];
			}
		}
		if($catids){
			if(count($catids)>1){
				$catids = implode(',',$catids);
				$_OBJ['content']->criteria->add(new Criteria('catid', "($catids)", 'in'));
			}elseif(count($catids)==1){
				$_OBJ['content']->criteria->add(new Criteria('catid', $catids[0]));
			}
		}
	}else{
	    $_SGLOBAL['cate'] = $_OBJ['category']->get($catid, false);
		if($_SGLOBAL['cate']['child']){
		
		    $catids = $_SGLOBAL['cate']['arrchildid'];
			$_OBJ['content']->criteria->add(new Criteria('catid', "($catids)", 'in'));
			
		} else $_OBJ['content']->criteria->add(new Criteria('catid', $catid));
	}
	if(isset($_PAGE['_GET']['status'])){
	    $_OBJ['content']->criteria->add(new Criteria('status', $_PAGE['_GET']['status']));
	}else $_OBJ['content']->criteria->add(new Criteria('status', 99));
	
	if($keywors = getparameter('key')){
	    $keywors = explode(' ',$keywors);
		foreach($keywors as $k){
			$_OBJ['content']->criteria->add(new Criteria('title', '%'.$k.'%', 'like'));
		}
	}
	
	$_OBJ['content']->criteria->setSort('a.contentid');
	$_OBJ['content']->criteria->setOrder('DESC');
	$_PAGE['rows'] = $_OBJ['content']->lists($_SCONFIG['adminpagenum'] ?$_SCONFIG['adminpagenum'] :30, $_PAGE['page']);
	$_PAGE['url_jumppage'] = $_OBJ['content']->getPage();
} else {//���
	//��ʽ����Ŀ���������
	$_OBJ['category']->get_format();
}
?>
