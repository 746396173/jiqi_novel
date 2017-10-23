<?php
/**
 * ��������
 *
 * ���Ը��ݲ�����ͬ��ʾ����
 * 
 * ����ģ�壺/modules/news/templates/blocks/block_sort.html
 * 
 * @category   Cms
 * @package    news
 * @copyright  Copyright (c) HULIMING QQ329222795
 * @author     $Author: huliming $
 * @version    $Id: block_content.php 332 2010-06-30 10:55:08Z HULIMING $
 */

class BlockNewsSort extends JieqiBlock
{
	var $module = 'news';
	var $template = 'block_sort.html';
	var $cachetime = -1;
	var $exevars=array('parentid'=>'0','target'=>'_blank');  //ִ������
	
	//parentid �ϼ�Ŀ¼ID
	function BlockNewsSort(&$vars){
		$this->JieqiBlock($vars);
		if(!empty($this->blockvars['vars'])){
			$varary=explode(',', trim($this->blockvars['vars']));
			$arynum=count($varary);

			if($arynum>0){
				$varary[0]=trim($varary[0]);
				if(is_numeric($varary[0])) $this->exevars['parentid']=$varary[0];
			}
			if($arynum>1){
				$varary[1]=trim($varary[1]);
				$this->exevars['target']=$varary[1];
			}
		}
		$this->blockvars['cacheid']=md5(serialize($this->blockvars).'|'.$this->blockvars['template']);	
	}


	function setContent($isreturn=false){
		global $jieqiTpl;
		global $jieqiConfigs;
		global $jieqiConfigs;
		global $_SCONFIG, $_SGLOBAL,$_OBJ;
		@define('IN_JQNEWS', TRUE);
		//������ش�����
		include_once($GLOBALS['jieqiModules']['news']['path'].'/include/loadclass.php');
		if(!isset($_SCONFIG)){
			jieqi_getconfigs('news', 'configs');
			//��ֵ�����ļ�
			$_SCONFIG = $jieqiConfigs['news'];
        }
		//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
		$_OBJ['category'] = new Category();
		//��ʽ����Ŀ���������
		$_OBJ['category']->get_format($this->exevars['parentid']);
		$jieqiTpl->assign('_SGLOBAL', $_SGLOBAL);
        $jieqiTpl->assign('target', $this->exevars['target']);
		
	}
}

?>