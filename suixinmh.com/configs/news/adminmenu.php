<?php 
/**
 * ��̨����ϵͳ��������
 *
 * ��̨����ϵͳ��������
 * 
 * ����ģ�壺��
 * 
 * @category   cms
 * @package    news
 * @copyright  Copyright (c) Hangzhou Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: huliming $
 * @version    $Id: adminmenu.php 187 2010-04-09 11:30:03Z huliming $
 */

/**
'layer'     - �˵���ȣ�Ĭ�� 0
'caption'   - �˵�����
'command'   - ���ӵ���ַ
'target'    - ��������Ƿ���´���(0-���¿���1-�¿�)
'publish'   - �Ƿ���ʾ��0-����ʾ��1-��ʾ��
*/

$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '��������', 'command'=>JIEQI_URL.'/web_admin/?controller=configs&mod=news', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => 'Ȩ������', 'command'=>JIEQI_URL.'/web_admin/?controller=power&mod=news', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => 'Ȩ������', 'command'=>JIEQI_URL.'/web_admin/?controller=right&mod=news', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '��Ŀ����', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=category', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => 'ģ�͹���', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=model', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '���ݹ���', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=content', 'target' => 0, 'publish' => 1, 'ajaxurl'=>$GLOBALS['jieqiModules']['news']['url'].'/load.php?field=tree');

$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '���۹���', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=comment', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '�ؼ��ʹ���', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=set&file=keyword', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '��ǩ����', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=position', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '���²ɼ�', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=collect', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '�ɼ�����', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=collectset', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['news'][] = array('layer' => 0, 'caption' => '����HTML', 'command'=>$GLOBALS['jieqiModules']['news']['url'].'/admin/?ac=create', 'target' => 0, 'publish' => 1);
?>