<?php
/*
	[Cms news] (C) 2009-2010 Cms Inc.
	$Id: position.inc.php  2010-07-07 10:55:09Z huliming $
*/
if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}
//$op = empty($_PAGE['_GET']['op']) ? "" : $_PAGE['_GET']['op'];
//$step = empty($_PAGE['_GET']['step']) ? "" : $_PAGE['_GET']['step'];

//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
$_OBJ['category'] = new Category();
$_PAGE['posturl'] = $_OBJ['category']->getPosturl($catid);//���ύURL
$_PAGE['attachurl'] = $_OBJ['category']->getAttachurl($catid);//����URL������
//��ʼ����ǩ����
$_OBJ['position'] = new Position();

if($op == 'view') {//Ԥ��
	$_PAGE['content'] = jieqi_geturl('news','tags',array('id'=>$_PAGE['_GET']['posid']));
}elseif($op == 'del') {//ɾ��

	if($_OBJ['position']->delete($_PAGE['_GET']['posid'])) jieqi_jumppage('?ac=position', LANG_NOTICE, LANG_DO_SUCCESS);
	else jieqi_jumppage('?ac=position', LANG_NOTICE, LANG_DO_FAILURE);
	
}elseif($op == 'order'){
    //����
	if(submitcheck("dosubmit")){
	     if($_OBJ['position']->order($_PAGE['_POST']['order'])) jieqi_jumppage('?ac=position', lang_replace('message_notice'), LANG_DO_SUCCESS);
		 else jieqi_jumppage('?ac=position', lang_replace('message_notice'), LANG_DO_FAILURE); 
	}
}elseif($op == 'add'){
	include_once(JIEQI_ROOT_PATH.'/class/blocks.php');
	$blocks_handler =& JieqiBlocksHandler::getInstance('JieqiBlocksHandler');
	
	//�ύ����
	if(submitcheck("dosubmit")){
	
	     //������Զ������飬�����ȴ���
		 if($_REQUEST['setting']['custom']){
			 
			 if($block=$blocks_handler->get($_REQUEST['setting']['bid'])){
				 //�Զ�������
				 if($block->getVar('canedit')==1){
					 $block->setVar('content', $_REQUEST['setting']['content']);
				 }
			 }
			 if($blocks_handler->insert($block)){
			   $blocks_handler->saveContent($block->getVar('bid'), $block->getVar('modname'), JIEQI_CONTENT_HTML, $_REQUEST['setting']['content']);
			 }
			 $_REQUEST['setting']['content'] = '';
		 }
		 $data = $_PAGE['_POST']['info'];
		 $data['setting'] = saddslashes(arrayeval($_REQUEST['setting']));
		 
		 //��������
		 if($_PAGE['_GET']['posid']){
		     $statu = $_OBJ['position']->edit($_PAGE['_GET']['posid'],$data); //�޸�
			 $posid = $_PAGE['_GET']['posid'];
		 }else{
			 $statu = $_OBJ['position']->add($data);//���� 
			 $posid = $statu;
		 }
		 //��Ϣ
		 if($statu){
		    $_OBJ['position']->cacheOne($posid);
		    jieqi_jumppage('?ac=position', lang_replace('message_notice'), LANG_DO_SUCCESS);
		 } else jieqi_printfail(LANG_DO_FAILURE); 
	}
	//�ڶ�����������£�����ַҪ�͸���������URL����һ�£����򸽼��ϴ������
	if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);
	////////////////////////////�����//////////////////////////////
	//����޸�״̬
	if($_PAGE['_GET']['posid']){
		 //��ȡ�޸���Ŀ����
		 $_SGLOBAL['position'] = $_OBJ['position']->get($_PAGE['_GET']['posid']);
		 //print_r($_SGLOBAL['position']);
	}else{//���״̬
		$_SGLOBAL['position']['type'] = $_PAGE['_POST']['type'];
		if($_SGLOBAL['position']['type']!=2) $_SGLOBAL['position']['setting']['bid'] = $_PAGE['_POST']['bid'];
	}
	if($step){
	    //������ݱ�
		//ȡ������
		$criteria=new CriteriaCompo();//new Criteria('modname','news')
		//$criteria->add(new Criteria('custom',0,'='));
		$criteria->setSort('weight');
		$criteria->setOrder('ASC');
		$blocks_handler->queryObjects($criteria);
		$blockary = array();
		while($v = $blocks_handler->getObject()){
			$blockary[$k]['bid']=$v->getVar('bid');
			$blockary[$k]['blockname']=$v->getVar('blockname');
			$blockary[$k]['modname']=$modules[$v->getVar('modname', 'n')];
			$blockary[$k]['side']=$blocks_handler->getSide($v->getVar('side', 'n'));
			$blockary[$k]['weight']=$v->getVar('weight');
			$blockary[$k]['weight']=$v->getVar('weight');
			$blockary[$k]['template']=$blocks_handler->getPublish($v->getVar('template', 'n'));
			$k++;
		}
		$_PAGE['block'] = $blockary;
	}
		if($_SGLOBAL['position']['type']==1){//��ѯ����
			 if(($block = $blocks_handler->get($_SGLOBAL['position']['setting']['bid']))){
				 //$_SGLOBAL['position']['setting'] = array();
				 foreach($block->vars as $k=>$v){
				     if(!in_array($k,array('template', 'vars'))){
						 $_SGLOBAL['position']['setting'][$k] = $block->getVar($k,'n');
					 }
				 }
				 //$_SGLOBAL['position']['setting']['filename'] = $block->getVar('filename','n');
				 //$_SGLOBAL['position']['setting']['description'] = $block->getVar('description','n');
				 $_SGLOBAL['position']['setting']['module'] = $block->getVar('modname','n');
			 }
		}

	//����Ĭ������Ȩֵ
	$_SGLOBAL['position']['listorder'] = $_SGLOBAL['position']['listorder'] ?$_SGLOBAL['position']['listorder'] :'0';
	//����Ĭ��ģ��
	if(!$_SGLOBAL['position']['setting']['template']){
	    switch($_SGLOBAL['position']['type']){
		    case '0':
			     $_SGLOBAL['position']['setting']['template'] = 'block_commend.html';
			break;
		    case '2':
			     $_SGLOBAL['position']['setting']['template'] = 'block_content.html';
			break;
		}
	}
} else {//���
	//�ڶ�����������£�����ַҪ�͸���������URL����һ�£����򸽼��ϴ������
	if($_PAGE['posturl']!= 'http://'.$_SERVER['HTTP_HOST']) header("location:".$_PAGE['posturl'].$_SERVER['REQUEST_URI']);
	$_PAGE['ltag'] = '{?';
	$_PAGE['rtag'] = '?}';
	$_PAGE['page'] = $_PAGE['_GET']['page'] ?$_PAGE['_GET']['page'] :$_PAGE['_POST']['page'];
	$_PAGE['page'] = $_PAGE['page'] ?$_PAGE['page'] :1;
	$_OBJ['position']->setHandler();
	$_OBJ['position']->criteria->setSort('listorder');
	$_OBJ['position']->criteria->setOrder('ASC');
	$_PAGE['rows'] = $_OBJ['position']->lists(30, $_PAGE['page']);
	$_PAGE['url_jumppage'] = $_OBJ['position']->getPage();

}
//$template = !$op ?'position' :"position_{$op}{$step}";
//template('admin/'.$template);
?>
