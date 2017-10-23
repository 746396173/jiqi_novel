<?php
/**
 * �����б�����
 *
 * ���Ը��ݲ�����ͬ��ʾ�������������а��
 * 
 * ����ģ�壺/modules/news/templates/blocks/block_content.html
 * 
 * @category   Cms
 * @package    news
 * @copyright  Copyright (c) HULIMING QQ329222795
 * @author     $Author: huliming $
 * @version    $Id: block_content.php 332 2010-06-30 10:55:08Z HULIMING $
 */

class BlockNewsContent extends JieqiBlock
{
	var $module = 'news';
	var $template = 'block_content.html';
	var $cachetime = -1;
	var $exevars=array();  //ִ������
	
	//listnum ��ʾ����
	//sortid 0��ʾ������𣬿����Ƕ����� '1|2|3'
	//asc  0��ʾ�Ӵ���С�ţ�1��ʾ��С����
	function BlockNewsContent(&$vars){
		$this->JieqiBlock($vars);
		if(!empty($this->blockvars['vars'])){
			$this->blockvars['vars']=trim($this->blockvars['vars']);
		}
		$this->blockvars['cacheid']=md5(serialize($this->blockvars).'|'.$this->blockvars['template']);	
	}


	function setContent($isreturn=false){
		global $jieqiTpl;
		global $jieqiConfigs;
		global $_SCONFIG;
		@define('IN_JQNEWS', TRUE);
		if(!isset($_SCONFIG)){
			jieqi_getconfigs('news', 'configs');
			//��ֵ�����ļ�
			$_SCONFIG = $jieqiConfigs['news'];
        }
        $jieqiTpl->assign('content', $this->blockvars['vars']);
	}
}

?>