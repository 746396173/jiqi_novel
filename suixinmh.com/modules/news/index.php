<?php
/**
 * ͨ�õ�ҳ��Ԥ�����ļ�
 *
 * ҳ��Ԥ�������ع���ģ��
 * 
 * ����ģ�壺��
 * 
 * @category   Cms
 * @package    news
 * @copyright  Copyright (c) Hangzhou Network Technology Co.,Ltd.
 * @author     $Author: huliming QQ329222795 $
 * @version    $Id: index.php 332 2010-03-24 09:15:08Z huliming $
 */
define('IN_ADMIN', false);//�����̨����ͷ�ļ�
include_once('./common.php');
include_once('./include/loadclass.php');//echo exechars('<p>!!!!</p>','aa');exit;
//jieqi_loadlang('showmessage', 'news');
//����ķ���
$acs = array('list', 'show', 'comment', 'blockshow', 'top', 'history','qidian');
$ac = getparameter('ac');
$ac = $_PAGE['ac'] = (empty($ac) || !in_array($ac, $acs))?'index':$ac;

//����
$op = getparameter('op');

//����ģ��
include_once($_SGLOBAL['news']['path'].'/source/'.$ac.'.inc.php');
include_once($_SGLOBAL['rootpath'].'/footer.php');
?>