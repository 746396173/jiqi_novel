<?php
/*
	[Cms news] (C) 2010-2012 Cms Inc.
	$Id: comment.inc.php  2011-03-31 10:55:09Z huliming $
*/
if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
$_OBJ['category'] = new Category();
$_PAGE['posturl'] = $_OBJ['category']->getPosturl($catid);//���ύURL
if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);
$_OBJ['content'] = new Content();
//��ʼ��������ͼ
$_OBJ['comment'] = new View('comment', 'commentid');

if($op == 'view') {//Ԥ��
	
}elseif($op == 'del') {//ɾ��

	$commentid = getparameter('commentid');
	if(!$commentid) jieqi_printfail(LANG_ERROR_PARAMETER);
	$commentids = array();//��Ŵ�ɾ��������ID����
	if(!is_array($commentid))  $commentids[] = $commentid;
	else  $commentids = $commentid;
	foreach($commentids as $k=>$commentid){
	    if($data = $_OBJ['comment']->get($commentid)){
			if($_OBJ['comment']->delete($commentid)){
				$fields['comments'] = "--";
				if($data['status']) $fields['comments_checked'] = "--";
				updatetable($_OBJ['content']->table_count, $fields, "contentid={$data['contentid']}");
			}
		}
		unset($data);
		unset($fields);
	}
	jieqi_jumppage($_SGLOBAL['refer'], LANG_NOTICE, LANG_DO_SUCCESS);
	
}elseif($op == 'pass'){

	$commentid = getparameter('commentid');
	if(!$commentid) jieqi_printfail(LANG_ERROR_PARAMETER);
	$commentids = array();//��Ŵ�ɾ��������ID����
	if(!is_array($commentid))  $commentids[] = $commentid;
	else  $commentids = $commentid;
	foreach($commentids as $k=>$commentid){
	    if($data = $_OBJ['comment']->get($commentid)){
		    if($data['status']) continue;
			if($_OBJ['comment']->edit($commentid, array('status'=>1) )){
				updatetable($_OBJ['content']->table_count, array('comments_checked'=>"++"), "contentid={$data['contentid']}");
			}
		}
		unset($data);
	}
	jieqi_jumppage($_SGLOBAL['refer'], LANG_NOTICE, LANG_DO_SUCCESS);

} else {//���
	getparameter('page');
	getparameter('status');
	getparameter('keywords');
	getparameter('contentid');
	getparameter('timeid');
	$_OBJ['comment']->setHandler();
	//���������²�ѯ
	if($_PAGE['contentid'] && $_PAGE['data'] = $_OBJ['content']->get($_PAGE['contentid'])){
		$_OBJ['comment']->criteria->add(new Criteria('contentid', $_PAGE['contentid']));
	}
	//��״̬��ѯ
	if(isset($_PAGE['status']) && $_PAGE['status']!='') $_OBJ['comment']->criteria->add(new Criteria('status', $_PAGE['status']));
	//ʱ�䷶Χ�ڲ�ѯ
	if($_PAGE['timeid']){
	    $fromtime = $_SGLOBAL['timestamp']-$_PAGE['timeid']*86400;
		$_OBJ['comment']->criteria->add(new Criteria('addtime', $fromtime, '>='));
	}
	$_OBJ['comment']->criteria->setSort('commentid');
	$_OBJ['comment']->criteria->setOrder('DESC');
	$_PAGE['rows'] = $_OBJ['comment']->lists(30, $_PAGE['page']);
	$_PAGE['url_jumppage'] = $_OBJ['comment']->getPage();

}
?>
