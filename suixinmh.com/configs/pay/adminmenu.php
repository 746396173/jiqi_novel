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

$jieqiAdminmenu['pay'][] = array('layer' => 0, 'caption' => '��������', 'command'=>JIEQI_URL.'/web_admin/?controller=configs&mod=pay', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['pay'][] = array('layer' => 0, 'caption' => 'Ȩ�޹���', 'command'=>JIEQI_URL.'/web_admin/?controller=power&mod=pay', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['pay'][] = array('layer' => 0, 'caption' => 'Ȩ������', 'command'=>JIEQI_URL.'/web_admin/?controller=right&mod=pay', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['pay'][] = array('layer' => 0, 'caption' => 'URL·������', 'command'=>JIEQI_URL.'/web_admin/?controller=url&mod=pay', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['pay'][] = array('layer' => 0, 'caption' => '�û���ֵ��¼', 'command'=>$GLOBALS['jieqiModules']['pay']['url'].'/admin/', 'target' => 0, 'publish' => 1);

$jieqiAdminmenu['pay'][] = array('layer' => 0, 'caption' => '��ֵ������ѯ', 'command'=>$GLOBALS['jieqiModules']['pay']['url'].'/admin/?method=pay', 'target' => 0, 'publish' => 1);

?>