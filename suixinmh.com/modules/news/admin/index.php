<?php
/**
 * ��̨ͨ�õ�ҳ������ļ�
 *
 * ҳ����ã����ع���ģ��
 * 
 * ����ģ�壺��
 * 
 * @category   cms
 * @package    news
 * @copyright  Copyright (c) huliming QQ329222795.
 * @author     $Author: huliming QQ329222795 $
 * @version    $Id: index.php 332 2010-04-09 09:15:08Z huliming $
 */
header ( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" );
//if(!defined('ADMIN_DIR')) define('ADMIN_DIR', 'admin/');//�����̨����ͷ�ļ�
define('IN_ADMIN', true);//�����̨����ͷ�ļ�
include_once('../common.php');
include_once('../include/loadclass.php');
//jieqi_loadlang('showmessage', 'news');
//����ķ���
$acs = array('content','model','category','selectfile','cutimage','position','collect','collectset','create','comment','set');
$ac = getparameter('ac');
$ac = (empty($ac) || !in_array($ac, $acs))?'content':$ac;
//����
$op = getparameter('op');
//����
$step = getparameter('step');
//�ļ�[Ϊ��Ĭ��Ϊ$ac]
$file = getparameter('file');
//����Ȩ�ޱ�ʶ
$powerkey = 'admin'.$ac.($op ?'_'.$op :'');

if(in_array($ac, array('model','category')) && $op=='add' && ($_PAGE['_GET']['catid'] || $_PAGE['_GET']['modelid'])){//�޸���Ŀ����ģ��

	new Power('admin'.$ac.'_edit', $_SCONFIG['_POWER']['admin'.$ac.'_edit'], false);
	
}elseif($ac=='content' && $op=='check' && $_PAGE['_GET']['catid']){//���µ�����Ŀ�������Ȩ��
    
	$power = new Power();
	$power->addPower($powerkey, $_SCONFIG['_POWER'][$powerkey]);
	if($power->checkPower($powerkey, true)){
	    //ȡ����Ŀ��Ȩ������
		$_OBJ['category'] = new Category();
		$_SGLOBAL['cate'] = $_OBJ['category']->get($_PAGE['_GET']['catid'], false);
		$power->addPower($powerkey, $_SGLOBAL['cate']['setting']['check']);
		$power->checkPower($powerkey, false);
	}
	
}elseif(isset($_SCONFIG['_POWER'][$powerkey])){//�������Ȩ�ޱ�ʶ��ص�Ȩ���趨

    new Power($powerkey, $_SCONFIG['_POWER'][$powerkey], false);
	
}elseif($ac=='model' && in_array($op, array('model_field', 'deletefield', 'copyfield'))){

    new Power('adminmodel_fields', $_SCONFIG['_POWER']['adminmodel_fields'], false);
	
}elseif(($ac=='content' && (!isset($op) || $op=='manage')) || in_array($ac,array('selectfile','cutimage'))){//���ݹ����������

    new Power('admincontent', $_SCONFIG['_POWER']['admincontent'], false);
	
}else{ new Power('admin'.$ac, $_SCONFIG['_POWER']['admin'.$ac], false);}
//����ģ��
include_once($_SGLOBAL[_MODULE_]['path'].'/admin/'.$ac.'.inc.php');
$temp = "{$file}{$op}{$step}";
template("admin/{$ac}".($temp ? "_{$temp}" : ""));
include_once(_ROOT_.'/admin/footer.php');
?>