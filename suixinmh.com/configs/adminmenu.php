<?php 
/**
 * ��̨ϵͳ����������
 *
 * ��̨ϵͳ����������
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    system
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

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'ϵͳ����', 'command'=>JIEQI_URL.'/web_admin/?controller=configs&mod=system&define=1', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '��������', 'command'=>JIEQI_URL.'/web_admin/?controller=configs&mod=system', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'Ȩ������', 'command'=>JIEQI_URL.'/web_admin/?controller=power&mod=system', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'Ȩ������', 'command'=>JIEQI_URL.'/web_admin/?controller=right&mod=system', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '�û������', 'command'=>JIEQI_URL.'/web_admin/?controller=groups', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'ͷ�ι���', 'command'=>JIEQI_URL.'/web_admin/?controller=honors', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'VIP�������', 'command'=>JIEQI_URL.'/web_admin/?controller=vipgrade', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '�������', 'command'=>JIEQI_URL.'/web_admin/?controller=blocks', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '��ǩ�������', 'command'=>JIEQI_URL.'/web_admin/?controller=positiontype', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '��ǩ����', 'command'=>JIEQI_URL.'/web_admin/?controller=position', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'URL·������', 'command'=>JIEQI_URL.'/web_admin/?controller=url', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '���������ļ�����', 'command'=>JIEQI_URL.'/web_admin/?controller=manageblocks', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'ģ�����ù���', 'command'=>JIEQI_URL.'/web_admin/?controller=managemodules', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '�û�����', 'command'=>JIEQI_URL.'/web_admin/?controller=users', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '�û���־', 'command'=>JIEQI_URL.'/web_admin/?controller=userlog', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '�û�����', 'command'=>JIEQI_URL.'/web_admin/?controller=report', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '�����û�����', 'command'=>JIEQI_URL.'/web_admin/?controller=online', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'ϵͳ�ռ���', 'command'=>JIEQI_URL.'/web_admin/?controller=message&method=inbox', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => 'ϵͳ������', 'command'=>JIEQI_URL.'/web_admin/?controller=message&method=outbox', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '���Ͷ���', 'command'=>JIEQI_URL.'/web_admin/?controller=newmessage', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['system'][] = array('layer' => 0, 'caption' => '���ɾ�̬��ҳ', 'command'=>JIEQI_URL.'/?controller=indexs&refresh=1', 'target' => 0, 'publish' => 1);

//==========================================================
//���ݿ�ά������
//==========================================================

$jieqiAdminmenu['database'][] = array('layer' => 0, 'caption' => '���ݿⱸ��', 'command'=>JIEQI_URL.'/web_admin/?controller=dbmanage&method=export_view', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['database'][] = array('layer' => 0, 'caption' => '���ݿ�ָ�', 'command'=>JIEQI_URL.'/web_admin/?controller=dbmanage&method=import_view', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['database'][] = array('layer' => 0, 'caption' => '���ݿ��Ż�', 'command'=>JIEQI_URL.'/web_admin/?controller=dbmanage&method=optimize_view', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['database'][] = array('layer' => 0, 'caption' => '���ݿ��޸�', 'command'=>JIEQI_URL.'/web_admin/?controller=dbmanage&method=repair_view', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['database'][] = array('layer' => 0, 'caption' => '���ݿ�����', 'command'=>JIEQI_URL.'/web_admin/?controller=dbmanage&method=upgrade_view', 'target' => 0, 'publish' => 1);

//==========================================================
//ϵͳ���ߵ���
//==========================================================

//$jieqiAdminmenu['tools'][] = array('layer' => 0, 'caption' => 'ˢ�¾�̬��ҳ', 'command'=>JIEQI_URL.'/?controller=indexs&refresh=1', 'target' => 0, 'publish' => 1);

//$jieqiAdminmenu['tools'][] = array('layer' => 0, 'caption' => '�������黺��', 'command'=>JIEQI_URL.'/web_admin/?controller=syscleancache&target=blockcache', 'target' => 0, 'publish' => 1);
$jieqiAdminmenu['tools'][] = array('layer' => 0, 'caption' => '�������黺��', 'command'=>JIEQI_URL.'/web_admin/?controller=sysTools&method=cleancache_view&target=blockcache', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tools'][] = array('layer' => 0, 'caption' => '������ҳ����', 'command'=>JIEQI_URL.'/web_admin/?controller=sysTools&method=cleancache_view&target=cache', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tools'][] = array('layer' => 0, 'caption' => '���������뻺��', 'command'=>JIEQI_URL.'/web_admin/?controller=sysTools&method=cleancache_view&target=compiled', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tools'][] = array('layer' => 0, 'caption' => 'ϵͳ��Ϣ���Ż�����', 'command'=>JIEQI_URL.'/web_admin/?controller=sysinfo', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['tools'][] = array('layer' => 0, 'caption' => 'ϵͳ�ռ���', 'command'=>JIEQI_URL.'/web_admin/?controller=message&method=inbox', 'target' => 0, 'publish' => 1);

?>