<?php
/**
 * ·������jieqi_system_url - ϵͳ���ò�����)
 * @category   jieqicms
 * @package    system
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: chengyuan $
 * @version    $Id: url.php 312 2008-12-29 05:30:54Z juny $
 */

jieqi_includedb();
//������
class JieqiUrl extends JieqiObjectData
{

    //��������
    function JieqiUrl()
    {
        $this->initVar('id', JIEQI_TYPE_INT, 0, 'id', false, 8);
		$this->initVar('caption', JIEQI_TYPE_TXTBOX, '', '��������', true, 50);
        $this->initVar('modname', JIEQI_TYPE_TXTBOX, '', 'ģ������', true, 50);
        $this->initVar('controller', JIEQI_TYPE_TXTBOX, '', '������', true, 10);
		$this->initVar('method', JIEQI_TYPE_TXTBOX, '', '��������', true, 20);
		$this->initVar('rule', JIEQI_TYPE_TXTBOX, '', 'α��̬����', true, 50);
		$this->initVar('params', JIEQI_TYPE_TXTBOX, '', '����', true, 50);
		$this->initVar('description', JIEQI_TYPE_TXTAREA, '', '��������', false, NULL);
    }
	
}
//������
class JieqiUrlHandler extends JieqiObjectHandler
{
	function JieqiUrlHandler($db='')
	{
	    $this->JieqiObjectHandler($db);
	    $this->basename='url';
	    $this->autoid='id';	
	    $this->dbname='system_url';
	}
}
?>