<?php
/*
	[Cms news] (C) 2010-2012 Cms Inc.
	$Id: gameonline.inc.php  2011-03-31 10:55:09Z huliming $
*/
if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
$_OBJ['category'] = new Category();
$_PAGE['posturl'] = $_OBJ['category']->getPosturl($catid);//�����ύURL
if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);
//��ʼ�����ģ�������б�
$_OBJ['model'] = new Model();

//��ʼ��������ͼ
$_OBJ['pay'] = new View('pay', 'orderid');

if($op == 'view') {//Ԥ��
	
}elseif($op == 'del') {//ɾ��

} else {//���
    include($_SGLOBAL['news']['path'].'/include/fields/formelements.class.php');
    include_once($_SGLOBAL['news']['path'].'/include/fields/form_typeid.class.php');
	$elementObject = new Form_typeid(new FormElements(30), 'typeid');
	$elementObject->setSetting();
	$array = explode("\n", $elementObject->setting['items']);
	$_PAGE['types'] = array();
	foreach($array as $k=>$v){
		$items = explode("|", $v);
		$_PAGE['types'][trim($items[0])] = trim($items[1]);
	}
    getparameter('uid');
	getparameter('gameid');
	getparameter('payflag');
	getparameter('start');
	getparameter('end');
	getparameter('page');
	$_OBJ['pay']->setHandler();
	//��Ϸ����
	if($_PAGE['gameid']) $_OBJ['pay']->criteria->add(new Criteria('gameid', $_PAGE['gameid']));
	//�û�
	if($_PAGE['uid']) $_OBJ['pay']->criteria->add(new Criteria('uid', $_PAGE['uid']));
	if($_PAGE['payflag']) $_OBJ['pay']->criteria->add(new Criteria('payflag', 1)); 
	if($_PAGE['start']) $_OBJ['pay']->criteria->add(new Criteria('time', strtotime($_PAGE['start']), '>=')); 
	if($_PAGE['end']) $_OBJ['pay']->criteria->add(new Criteria('time', strtotime($_PAGE['end']), '<=')); 
	$_OBJ['pay']->handler->dbname = 'news_pay';
	$_PAGE['allamount'] = $_OBJ['pay']->handler->getsum('amount',$_OBJ['pay']->criteria);
	$_OBJ['pay']->criteria->setSort('orderid');
	$_OBJ['pay']->criteria->setOrder('DESC');
	$_PAGE['rows'] = $_OBJ['pay']->lists(30, $_PAGE['page']);
	$_PAGE['url_jumppage'] = $_OBJ['pay']->getPage();

}
?>