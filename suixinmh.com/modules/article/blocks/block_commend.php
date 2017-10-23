<?php
/**
 * �����Ƽ�����
 *
 * ��ʾ���������Ƽ��ļ�ƪ����
 * 
 * ����ģ�壺/modules/article/templates/blocks/block_commend.html
 * 
 * @category   jieqicms
 * @package    article
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: block_commend.php 332 2009-02-23 09:15:08Z juny $
 */

class BlockArticleCommend extends JieqiBlock
{
	var $module = 'article';
	var $template = 'block_commend.html';

	var $exevars=array();  //ִ������

	function BlockArticleCommend(&$vars){
		$this->JieqiBlock($vars);
		$pos = strpos($this->blockvars['vars'],"=");
		if(!empty($this->blockvars['vars'])){
			$tmpary=explode('|', trim($this->blockvars['vars']));
			foreach($tmpary as $v){
				$v=trim($v);
				if($pos === false && is_numeric($v)){
					$this->exevars[]=intval($v);
				}else{
					$this->exevars[]=$v;
				}
			}
			$this->exevars=array_unique($this->exevars);
		}
		$this->blockvars['cacheid']=md5(serialize($this->exevars).'|'.$this->blockvars['template']);
	}

	function setContent($isreturn=false){
		
		
		global $jieqiTpl;
		global $jieqiConfigs;
		global $jieqiSort;

// 		include_once($GLOBALS['jieqiModules']['article']['path'].'/class/article.php');
		//������ش�������
// 		include_once($GLOBALS['jieqiModules']['article']['path'].'/include/funarticle.php');
		$pos = strpos($this->blockvars['vars'],"=");		//�������ݵ���û�Ⱥ�
		$articleLib = Application::newLib('article', 'article');
		$this->db->init ( 'article', 'articleid', 'article' );
		$this->db->setCriteria();
		
		jieqi_getconfigs('article', 'configs');
		jieqi_getconfigs('article', 'sort');
// 		$article_static_url = (empty($jieqiConfigs['article']['staticurl'])) ? $GLOBALS['jieqiModules']['article']['url'] : $jieqiConfigs['article']['staticurl'];
// 		$article_dynamic_url = (empty($jieqiConfigs['article']['dynamicurl'])) ? $GLOBALS['jieqiModules']['article']['url'] : $jieqiConfigs['article']['dynamicurl'];
// 		$jieqiTpl->assign('article_static_url',$article_static_url);
// 		$jieqiTpl->assign('article_dynamic_url',$article_dynamic_url);
		$articlerows=array();
		if(count($this->exevars) > 0){
			if($pos != false){
				$tmpary=explode('|', trim($this->blockvars['vars']));
				foreach($tmpary as $v){
					$v=trim($v);
					$this->exestr[]=intval($v);				//����ֻ��id
					$srt = strpos($v,'=');
					$strarr = substr($v,$srt+1);
					$this->exeff[intval($v)] = $strarr;		//�����ü�ֵ�Ա�ʾid�Ͷ�����
				}
			}
// 			$article_handler =& JieqiArticleHandler::getInstance('JieqiArticleHandler');
// 			$sql='SELECT * FROM '.jieqi_dbprefix('article_article').' WHERE articleid IN (0,'.implode(',', $this->exevars).')';
			if($pos === false){
				$this->db->criteria->add(new Criteria('','articleid IN ('.implode(',', $this->exevars).')',''));
			}else{
				$this->db->criteria->add(new Criteria('','articleid IN ('.implode(',', $this->exestr).')',''));
			}
// 			$sql.=' LIMIT 0, 100';
			$this->db->criteria->setLimit(100);
// 			$res=$article_handler->db->query($sql);
			$k=0;
// 			while($v = $article_handler->getObject($res)){
			$this->db->queryObjects();
			while($v = $this->db->getObject()){
				$articlerows[$k] = $articleLib->article_vars($v);
				$articlerows[$k]['order']=$k+1;
				$k++;
			}
		}

		$i=0;
		$maxrow=count($articlerows);
		$sortrows=array();
		if($pos === false){		//�������û�еȺ�
			foreach ($this->exevars as $aid){
				$k=0;
				while($k < $maxrow && $articlerows[$k]['articleid'] != $aid) $k++;
				if($k < $maxrow){
					$articlerows[$k]['order']=$i+1;
					$sortrows[$i] = &$articlerows[$k];
					$i++;
				}
			}
		}else{			//��������еȺ�
			foreach ($this->exestr as $aid){
				$k=0;
				while($k < $maxrow && $articlerows[$k]['articleid'] != $aid) $k++;
				if($k < $maxrow){
					$articlerows[$k]['order']=$i+1;
					$articlerows[$k]['articlename']=$this->exeff[$articlerows[$k]['articleid']];
					$sortrows[$i] = &$articlerows[$k];
					$i++;
				}
			}
		}

		$jieqiTpl->assign_by_ref('articlerows', $sortrows);
	}
}

?>