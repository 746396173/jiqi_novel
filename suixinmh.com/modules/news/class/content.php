<?php 
/**
 * ���ݱ���(jieqi_news_content  - ������Ϣ��)
 *
 * ���ݱ���(jieqi_news_content  - ������Ϣ��)
 * 
 * ����ģ�壺��
 * 
 * @category   cms
 * @package    news
 * @copyright  Copyright (c) huliming
 * @author     $Author: huliming $
 * @version    $Id: content.php 300 2010-06-02 04:36:06Z huliming QQ329222795 $
 */

jieqi_includedb();

class JieqiContent extends JieqiObjectData
{
	//��������
	function JieqiContent()
	{
		$this->JieqiObjectData();
		$this->initVar('contentid', JIEQI_TYPE_INT, 0, '���', false, 8);
		$this->initVar('siteid', JIEQI_TYPE_INT, 0, '��վ���', false, 6);
		$this->initVar('catid', JIEQI_TYPE_INT, 0, '��ĿID', false, 5);
		$this->initVar('typeid', JIEQI_TYPE_INT, 0, '����ID', false, 5);
		$this->initVar('areaid', JIEQI_TYPE_INT, 0, '����ID ', false, 5);
		$this->initVar('title', JIEQI_TYPE_TXTBOX, '', '����', false, 80);
		$this->initVar('style', JIEQI_TYPE_TXTAREA, '', '������ʽ', false, 5);
		$this->initVar('thumb', JIEQI_TYPE_TXTAREA, '', '����ͼ', false, 100);
		$this->initVar('keywords', JIEQI_TYPE_TXTBOX, '', '�ؼ���', false, 40);
		$this->initVar('description', JIEQI_TYPE_TXTBOX, '', '���²���', false, 255);
		$this->initVar('posids', JIEQI_TYPE_INT, 0, '�Ƽ�λ', false, 1);
		$this->initVar('url', JIEQI_TYPE_TXTBOX, '', '���ӵ�ַ', false, 50);
		$this->initVar('status', JIEQI_TYPE_INT, 0, '״̬', false, 3);
		$this->initVar('userid', JIEQI_TYPE_INT, 0, '�û�ID', false, 8);
		$this->initVar('username', JIEQI_TYPE_TXTBOX, '', '�û���', true, 20);
		$this->initVar('inputtime', JIEQI_TYPE_INT, 0, '����ʱ�� ', false, 10);
		$this->initVar('updatetime', JIEQI_TYPE_INT, 0, '����ʱ�� ', false, 10);
		$this->initVar('prefix', JIEQI_TYPE_TXTBOX, '', '�����ļ���', false, 20);
		//$this->initVar('hits', JIEQI_TYPE_INT, 0, '����� ', false, 8);
	}
}

//------------------------------------------------------------------------
//------------------------------------------------------------------------

//���ݾ��
class JieqiContentHandler extends JieqiObjectHandler
{

	function JieqiContentHandler($db='')
	{
		$this->JieqiObjectHandler($db);
		$this->basename='content';
		$this->autoid='contentid';
		$this->dbname='news_content';
	}
}

?>