<?php
/**
 * ��̨��������������
 *
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

// $jieqiAdminmenu['pooling'][] = array('layer' => 0, 'caption' => '��������', 'command'=>JIEQI_URL.'/web_admin/?controller=configs&mod=pooling', 'target' => 0, 'publish' => 1);


// $jieqiAdminmenu['pooling'][] = array('layer' => 0, 'caption' => 'Ȩ�޹���', 'command'=>JIEQI_URL.'/web_admin/?controller=power&mod=pooling', 'target' => 0, 'publish' => 1);
// $jieqiAdminmenu['pooling'][] = array('layer' => 0, 'caption' => '��������', 'command'=>$GLOBALS['jieqiModules']['pooling']['url'].'/admin/?controller=channel&mod=pooling', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['pooling'][] = array('layer' => 0, 'caption' => 'Ȩ������', 'command'=>JIEQI_URL.'/web_admin/?controller=right&mod=pooling', 'target' => 0, 'publish' => 1);


$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => '��������', 'command'=>JIEQI_URL.'/web_admin/?controller=configs&mod=tingshu', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => 'Ȩ�޹���', 'command'=>JIEQI_URL.'/web_admin/?controller=power&mod=tingshu', 'target' => 0, 'publish' => 1);

// $jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => 'Ȩ������', 'command'=>JIEQI_URL.'/web_admin/?controller=right&mod=tingshu', 'target' => 0, 'publish' => 1);



$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => 'URL·������', 'command'=>JIEQI_URL.'/web_admin/?controller=url&mod=tingshu', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => '�������', 'command'=>$GLOBALS['jieqiModules']['tingshu']['url'].'/admin/?controller=sortmanage', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => '���¹���', 'command'=>$GLOBALS['jieqiModules']['tingshu']['url'].'/admin/?controller=article', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => '���¼�¼', 'command'=>$GLOBALS['jieqiModules']['tingshu']['url'].'/admin/?controller=chapter', 'target' => 0, 'publish' => 1);


$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => '��ƪ�ɼ�', 'command'=>$GLOBALS['jieqiModules']['tingshu']['url'].'/admin/?controller=collect', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => '�����ɼ�', 'command'=>$GLOBALS['jieqiModules']['tingshu']['url'].'/admin/?controller=batchcollect', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tingshu'][] = array('layer' => 0, 'caption' => '�ɼ�����', 'command'=>$GLOBALS['jieqiModules']['tingshu']['url'].'/admin/?controller=collectset', 'target' => 0, 'publish' => 1);



?>