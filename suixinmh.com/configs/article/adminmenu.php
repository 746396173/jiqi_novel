<?php
/**
 * ��̨С˵���ص�������
 *
 * ��̨С˵���ص�������
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    article
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: adminmenu.php 187 2008-11-24 09:30:03Z juny $
 */

/**
'layer'     - �˵���ȣ�Ĭ�� 0
'caption'   - �˵�����
'command'   - ���ӵ���ַ
'target'    - ��������Ƿ���´���(0-���¿���1-�¿�)
'publish'   - �Ƿ���ʾ��0-����ʾ��1-��ʾ��
*/

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '��������', 'command'=>JIEQI_URL.'/admin/?controller=configs&mod=article', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => 'Ȩ�޹���', 'command'=>JIEQI_URL.'/admin/?controller=power&mod=article', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => 'Ȩ������', 'command'=>JIEQI_URL.'/admin/?controller=right&mod=article', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => 'URL·������', 'command'=>JIEQI_URL.'/admin/?controller=url&mod=article', 'target' => 0, 'publish' => 1);
//$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '�������', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=sortmanage', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '���¹���', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=article', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '���µ���', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=inbook', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '������������', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=batchclean', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '���¼�¼', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=chapter', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '����ͳ��', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=chapter&method=chapterStatistics', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '��������', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=reviews', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '��������', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=replies', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '������������', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=batchrepack', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => 'α��̬ҳ������', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=makefake', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '��ƪ�ɼ�', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=collect', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '�����ɼ�', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=batchcollect', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '�ɼ�����', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=collectset', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '�����滻', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=batchreplace', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '�����ؼ���', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=search', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '����ɾ����־', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=articlelog', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '���º�����', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=articleblacklist', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '���������¼', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=apply', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '���¶��ļ�¼', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=salelog', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '��������ͳ��', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=salestat', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '��ѹ���', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=reward', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '�������', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=sortmanage', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '�����������', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=bookpackagemanage', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '�������ͳ��', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=bookpackagemanage&method=bpsalecount', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '����Ķ�ͳ��', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=bookpackagemanage&method=bpclick', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['article'][] = array('layer' => 0, 'caption' => '��ǩ����', 'command'=>$GLOBALS['jieqiModules']['article']['url'].'/admin/?controller=tag', 'target' => 0, 'publish' => 1);
?>