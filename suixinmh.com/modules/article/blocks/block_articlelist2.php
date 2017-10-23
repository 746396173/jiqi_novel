<?php
/**
 * �����б�����
 *
 * ���Ը��ݲ�����ͬ��ʾ�������������а��
 * 
 * ����ģ�壺/modules/article/templates/blocks/block_articlelist.html
 * 
 * @category   jieqicms
 * @package    article
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: block_articlelist.php 332 2009-02-23 09:15:08Z juny $
 */

class BlockArticleArticlelist2 extends JieqiBlock
{
	var $module = 'article';
	var $template = 'block_articlelist.html';
	
	var $exevars=array('field'=>'allvisit', 'listnum'=>15, 'sortid'=>'0', 'isauthor'=>0, 'isfull'=>0, 'asc'=>0, 'permission'=>'', 'firstflag'=>'', 'power'=>'', 'siteid'=>JIEQI_SITE_ID);  //ִ������
	
	//listnum ��ʾ����
	//sortid 0��ʾ������𣬿����Ƕ����� '1|2|3'
	//isauthor 0 ��ʾ����, 1��ʾԭ����2��ʾת��
	//isfull 0 ��ʾ����, 1��ʾȫ����2����
	//asc  0��ʾ�Ӵ���С�ţ�1��ʾ��С����
	//permission ��Ȩ�ȼ� �ձ�ʾ����� 0-3 ��Ȩ�ȼ�,���Զ���ȼ� 1|2|3
	//firstflag �Ƿ��׷� �ձ�ʾ����� 0��վ�׷� 1��վ�׷�
	//power ״̬��� �ձ�ʾ����� 0-��ͨ 1-ǩԼ��2-vip��3-ǩԼ+vip
	//game �Ƿ����  ����Ʊ��  ������1   ͶƱ >1  
	//firstgame �Ƿ����  ����Ʊ��  ������1   ͶƱ >1 	
	function BlockArticleArticlelist2(&$vars){
		global $jieqiArticleuplog;
		$this->JieqiBlock($vars);
		if(!empty($this->blockvars['vars'])){
			$varary=explode(',', trim($this->blockvars['vars']));
			$arynum=count($varary);
			if($arynum>0){
				if(strpos($varary[0], '|') !== false){
				     $p = explode('|',$varary[0]);
					 $varary[0]=$p[0];
					 $this->exevars['keyword']=trim($p[1]);
				}
				$varary[0]=trim($varary[0]);
				if($varary[0]=='mouthvisit') $varary[0]='monthvisit';
				elseif($varary[0]=='mouthvote') $varary[0]='monthvote';
				if(in_array($varary[0], array('allvisit', 'monthvisit', 'weekvisit', 'dayvisit', 'allvote', 'monthvote', 'weekvote', 'dayvote', 'postdate', 'toptime', 'goodnum', 'size', 'lastupdate', 'goodnew', 'signdate','dayflower','weekflower','monthflower','allflower', 'goodauthor', 'signnew', 'vipvotenow', 'vipvotepreview', 'published', 'television', 'game','firstgame'))) $this->exevars['field']=$varary[0];
			}

			if($arynum>1){
				$varary[1]=trim($varary[1]);
				if(is_numeric($varary[1]) && $varary[1]>0) $this->exevars['listnum']=intval($varary[1]);
			}

			if($arynum>2){
				$varary[2]=trim($varary[2]);
				$tmpvar=str_replace('|', '', $varary[2]);
				if(is_numeric($tmpvar)) $this->exevars['sortid']=$varary[2];
				elseif(isset($_REQUEST[$tmpvar]) && is_numeric($_REQUEST[$tmpvar])) $this->exevars['sortid']=$_REQUEST[$tmpvar];
			}
			if($arynum>3){
				$varary[3]=trim($varary[3]);
				if(in_array($varary[3], array('0', '1', '2'))) $this->exevars['isauthor']=$varary[3];
			}
			if($arynum>4){
				$varary[4]=trim($varary[4]);
				if(in_array($varary[4], array('0', '1', '2'))) $this->exevars['isfull']=$varary[4];
			}
			if($arynum>5){
				$varary[5]=trim($varary[5]);
				if(in_array($varary[5], array('0', '1'))) $this->exevars['asc']=$varary[5];
			}
			
			if($arynum>6){
				$varary[6]=trim($varary[6]);
				//if(in_array($varary[6], array('0', '1', '2', '3'))) $this->exevars['permission']=$varary[6];
				$tmpvar=str_replace('|', '', $varary[6]);
				if(is_numeric($tmpvar)) $this->exevars['permission']=$varary[6];
			}
			
			if($arynum>7){
				$varary[7]=trim($varary[7]);
				if(in_array($varary[7], array('0', '1'))) $this->exevars['firstflag']=$varary[7];
			}
			
			if($arynum>8){
				$varary[8]=trim($varary[8]);
				if(in_array($varary[8], array('0', '1', '2', '3'))) $this->exevars['power']=$varary[8];
			}
			
			if($arynum>9){
				$varary[9]=trim($varary[9]);
				if(is_numeric($varary[9])) $this->exevars['siteid']=$varary[9];
			}
			if($arynum>10){
				$varary[10]=trim($varary[10]);
				if(is_numeric($varary[10])) $this->exevars['game']=$varary[10];
			}
			if($arynum>11){
				$varary[11]=trim($varary[11]);
				if(is_numeric($varary[11])) $this->exevars['firstgame']=$varary[11];
			}
		}
		$this->blockvars['cacheid']=md5(serialize($this->exevars).'|'.$this->blockvars['template']);	
		if($this->exevars['field']=='lastupdate' || $this->exevars['field']=='postdate'){
			jieqi_getcachevars('article', 'articleuplog');
			if(!is_array($jieqiArticleuplog)) $jieqiArticleuplog=array('articleuptime'=>0, 'chapteruptime'=>0);
			$this->blockvars['overtime'] = $jieqiArticleuplog['articleuptime'] > $jieqiArticleuplog['chapteruptime'] ? intval($jieqiArticleuplog['articleuptime']) : intval($jieqiArticleuplog['chapteruptime']);
		}
	}


	function setContent($isreturn=false){
		global $jieqiTpl;
		global $jieqiConfigs;
		global $jieqiSort;
		
		include_once($GLOBALS['jieqiModules']['article']['path'].'/class/article.php');
		//������ش�����
		include_once($GLOBALS['jieqiModules']['article']['path'].'/include/funarticle.php');
		jieqi_getconfigs('article', 'configs');
		jieqi_getconfigs('article', 'sort');
		$article_static_url = (empty($jieqiConfigs['article']['staticurl'])) ? $GLOBALS['jieqiModules']['article']['url'] : $jieqiConfigs['article']['staticurl'];
		$article_dynamic_url = (empty($jieqiConfigs['article']['dynamicurl'])) ? $GLOBALS['jieqiModules']['article']['url'] : $jieqiConfigs['article']['dynamicurl'];
		$jieqiTpl->assign('article_static_url',$article_static_url);
		$jieqiTpl->assign('article_dynamic_url',$article_dynamic_url);

		$tmpvar=explode('-',date('Y-m-d',JIEQI_NOW_TIME));
		$daystart=mktime(0,0,0,(int)$tmpvar[1],(int)$tmpvar[2],(int)$tmpvar[0]);
		$monthstart=mktime(0,0,0,(int)$tmpvar[1],1,(int)$tmpvar[0]);
		$tmpvar=date('w',JIEQI_NOW_TIME);
		if($tmpvar==0) $tmpvar=7; //��������0������ϰ����Ϊ��Ϊһ���ڵ����һ��
		$weekstart=$daystart;
		if($tmpvar>1) $weekstart-=($tmpvar-1) * 86400;

		$article_handler =& JieqiArticleHandler::getInstance('JieqiArticleHandler');
		$sql='SELECT * FROM '.jieqi_dbprefix('article_article').' WHERE display=0 AND size>0 AND siteid='.$this->exevars['siteid'];
        //$sql='SELECT * FROM '.jieqi_dbprefix('article_article').' WHERE siteid='.$this->exevars['siteid'];
		if(!empty($this->exevars['sortid'])){
			$sortstr='';
			$sortnum=0;
			$sortary=explode('|', $this->exevars['sortid']);
			foreach($sortary as $v){
				if(is_numeric($v)){
					if(!empty($sortstr)) $sortstr.=' OR ';
					$sortstr.='sortid='.intval($v);
					$sortnum++;
				}
			}
			if($sortnum==1) $sql.=' AND '.$sortstr;
			elseif($sortnum>1) $sql.=' AND ('.$sortstr.')';
		}
		if($this->exevars['isauthor']==1) $sql.=' AND authorid>0';
		elseif($this->exevars['isauthor']==2) $sql.=' AND authorid=0';
		if($this->exevars['isfull']==1) $sql.=' AND fullflag=1';
		elseif($this->exevars['isfull']==2) $sql.=' AND fullflag=0';
		//��Ȩ���
		if(strlen($this->exevars['permission'])>0){
			$perstr='';
			$pernum=0;
			$perary=explode('|', $this->exevars['permission']);
			foreach($perary as $v){
				if(is_numeric($v)){
					if(!empty($perstr)) $perstr.=' OR ';
					$perstr.='permission='.intval($v);
					$pernum++;
				}
			}
			if($pernum==1) $sql.=' AND '.$perstr;
			elseif($pernum>1) $sql.=' AND ('.$perstr.')';
		}
		//�Ƿ��׷�
		if(strlen($this->exevars['firstflag'])>0){
			$sql.=' AND firstflag='.intval($this->exevars['firstflag']);
		}
		//״̬��־
		if(strlen($this->exevars['power'])>0){
			$sql.=' AND power='.intval($this->exevars['power']);
		}
		//�ؼ���
		if(strlen($this->exevars['keyword'])>0){
		    $w = explode(' ',$this->exevars['keyword']);
			$sq = '';
			foreach($w as $k=>$v){
			    $t = explode('=',$v);
				if($t[0] && $t[1]){
				     if($sq) $sq.= ' or '.$t[0].' like \'%'.$t[1].'%\'';
					 else $sq= $t[0].' like \'%'.$t[1].'%\'';
				}
			}
		    if($sq) $sql.=' AND ('.$sq.')';
		}	
		switch($this->exevars['field']){
			case 'monthvisit':
			$sql.=' AND lastvisit>='.$monthstart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'monthvote':
			$sql.=' AND lastvote>='.$monthstart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'weekvisit':
			$sql.=' AND lastvisit>='.$weekstart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'weekvote':
			$sql.=' AND lastvote>='.$weekstart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'dayvisit':
			$sql.=' AND lastvisit>='.$daystart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'dayvote':
			$sql.=' AND lastvote>='.$daystart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'goodnew':
			$sql.=' AND postdate>='.(JIEQI_NOW_TIME - (3600*24*30));
			$sql.=' ORDER BY allvisit + allvote * 10 + goodnum * 20';
			break;
			case 'dayflower':
			$sql.=' AND lastflower>='.$daystart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'weekflower':
			$sql.=' AND lastflower>='.$weekstart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'monthflower':

			$sql.=' AND lastflower>='.$monthstart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'allflower':
			//$sql.=' AND lastflower>='.$daystart;
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
			case 'goodauthor':
			$sql.=' AND size>100000 AND size<400000 AND postdate>='.(JIEQI_NOW_TIME - (3600*24*30));
			$sql.=' ORDER BY weekvisit / 100 + weekvote * 20 + goodnum / 2';
			break;
			case 'signnew':
			$sql.=' AND permission=3';
			$sql.=' ORDER BY signdate';
			break;
			case 'published':
			$sql.=' AND published=1';
			$sql.=' ORDER BY lastupdate';
			break;
			case 'television':
			$sql.=' AND television=1';
			$sql.=' ORDER BY lastupdate';
			break;
			case 'vipvotenow':
			$sql.=' AND vipvotetime>='.$monthstart.' AND vipvotenow>0';
			//$sql.=' AND vipvotenow>0';
			$sql.=' ORDER BY vipvotenow desc,vipvotetime ';
			break;
			case 'vipvotepreview':
			if((int)date('m')==1){
				$premonthday = cal_days_in_month(CAL_GREGORIAN, 12, date('Y')-1);
			}else{
				$premonthday = cal_days_in_month(CAL_GREGORIAN, date('n')-1, date('Y'));
			}
			$sql.=' AND vipvotepretime>='.($monthstart-$premonthday*86400);
			$sql.=' ORDER BY vipvotepreview desc,vipvotepretime';
			break;
			default:
			$sql.=' ORDER BY '.$this->exevars['field'];
			break;
		}
		if($this->exevars['asc']==1) $sql.=' ASC';
		else  $sql.=' DESC';
		$sql.=' LIMIT 0, '.$this->exevars['listnum'];
		$res=$article_handler->db->query($sql);
		$articlerows=array();
		$k=0;
		while($v = $article_handler->getObject($res)){
			$articlerows[$k] = jieqi_article_vars($v);
                         $articlerows[$k]['game'] = $v->getVar('game');
                         $articlerows[$k]['firstgame'] = $v->getVar('firstgame');
			$articlerows[$k]['order']=$k+1;
			if($this->exevars['field']=='goodnew') $articlerows[$k]['visitnum']=$v->getVar('allvisit');
			else $articlerows[$k]['visitnum']=$v->getVar($this->exevars['field']);
			if($this->exevars['field']=='size') $articlerows[$k]['visitnum']=ceil($articlerows[$k]['visitnum']/1024).'K';
			elseif($this->exevars['field']=='lastupdate' || $this->exevars['field']=='postdate' || $this->exevars['field']=='toptime') $articlerows[$k]['visitnum']=date('m-d', $articlerows[$k]['visitnum']);
			$k++;
		}
		$jieqiTpl->assign_by_ref('articlerows', $articlerows);
		$topsort=$this->exevars['field'];
		if($topsort=='lastupdate'){
			if($this->exevars['isauthor']==1) $topsort='authorupdate';
			elseif($this->exevars['isauthor']==2) $topsort='masterupdate';
		}
		if($jieqiConfigs['article']['faketoplist']){
			if(!empty($jieqiConfigs['article']['fakeprefix'])) $tmpvar='/'.$jieqiConfigs['article']['fakeprefix'].'top'.$topsort;
			else $tmpvar='/files/article/top'.$topsort;
			$jieqiTpl->assign('url_more', jieqi_geturl('article', 'toplist', 1, $topsort));
		}else{
			$jieqiTpl->assign('url_more', $article_dynamic_url.'/toplist.php?sort='.$topsort);
		}
	}
}

?>