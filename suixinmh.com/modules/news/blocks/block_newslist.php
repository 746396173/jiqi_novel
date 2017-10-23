<?php
/**
 * �����б�����
 *
 * ���Ը��ݲ�����ͬ��ʾ�������������а��
 * 
 * ����ģ�壺/modules/news/templates/blocks/block_newslist.html
 * 
 * @category   Cms
 * @package    news
 * @copyright  Copyright (c) HULIMING QQ329222795
 * @author     $Author: huliming $
 * @version    $Id: block_newslist.php 332 2010-06-30 10:55:08Z HULIMING $
 */

class BlockNewsNewslist extends JieqiBlock
{
	var $module = 'news';
	var $template = 'block_newslist.html';
	
	var $exevars=array('field'=>'updatetime', 'listnum'=>30, 'catid'=>'0', 'asc'=>0, 'typeid'=>0, 'othor'=>0, 'length'=>50);  //ִ������
	
	//listnum ��ʾ����
	//sortid 0��ʾ������𣬿����Ƕ����� '1|2|3'
	//asc  0��ʾ�Ӵ���С�ţ�1��ʾ��С����
	function BlockNewsNewslist(&$vars){
		$this->JieqiBlock($vars);
		if(!empty($this->blockvars['vars'])){
			$varary=explode(',', trim($this->blockvars['vars']));
			$arynum=count($varary);
			if($arynum>0){
				$varary[0]=trim($varary[0]);
				//if(in_array($varary[0], array('inputtime', 'updatetime', 'typeid'))) 
				$this->exevars['field']=$varary[0];
			}

			if($arynum>1){
				$varary[1]=trim($varary[1]);
				if(is_numeric($varary[1]) && $varary[1]>0) $this->exevars['listnum']=intval($varary[1]);
			}

			if($arynum>2){
				$varary[2]=trim($varary[2]);
				$temparr = array();
				if($varary[2]){
					if(substr_count($varary[2],'|')) $catids = explode('|',$varary[2]);
					else $catids = explode(',',$varary[2]);
					foreach($catids as $k=>$v){
					    if($v && is_numeric($v)) $temparr[] = $v;
					}
					$this->exevars['catid'] = array_unique($temparr);
				}
			}
			if($arynum>3){
				$varary[3]=trim($varary[3]);
				if(in_array($varary[3], array('0', '1'))) $this->exevars['asc']=$varary[3];
			}
			if($this->exevars['asc']==1) $this->exevars['asc'] = 'ASC';
			else $this->exevars['asc'] = 'DESC';
			if($arynum>4){
				$varary[4]=trim($varary[4]);
				if(is_numeric($varary[4])) $this->exevars['typeid']=$varary[4];
			}
			
			if($arynum>5){
				$varary[5]=trim($varary[5]);
				if(is_numeric($varary[5]) && $varary[5]>0) $this->exevars['othor']=intval($varary[5]);
			}
			
			if($arynum>6){
				$varary[6]=trim($varary[6]);
				$this->exevars['length']=$varary[6];
			}
		}
		$this->blockvars['cacheid']=md5(serialize($this->exevars).'|'.$this->blockvars['template']);	
	}


	function setContent($isreturn=false){
		global $jieqiTpl;
		global $jieqiConfigs;
		global $_SCONFIG, $_SGLOBAL;
		@define('IN_JQNEWS', TRUE);
		//������ش�����
		include_once($GLOBALS['jieqiModules']['news']['path'].'/include/loadclass.php');
		//include_once($GLOBALS['jieqiModules']['news']['path'].'/class/content.php');
		if(!isset($_SCONFIG)){
			jieqi_getconfigs('news', 'configs');
			//��ֵ�����ļ�
			$_SCONFIG = $jieqiConfigs['news'];
        }
		//����content��
		$content = & new Content();
		if(count($this->exevars['catid'])>0){
			//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
			if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
			//��ȡ��Ŀ����
			if(!($SGLOBAL['cate'] = $_OBJ['category']->get($this->exevars['catid'][0], true))) return false;
			//����ģ��
			if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();

			//�����ѯ��
			$tables = array();
			if($this->exevars['othor']){
				//if($this->exevars['othor']) $tables[$content->tablepre.'c_'.$_SGLOBAL['model'][$SGLOBAL['cate']['modelid']]['tablename']] = '*';  //���¸��ӱ����
				if($this->exevars['othor']>1) $tables[$content->table_count] = 'hits,hits_day,hits_week,hits_month,hits_time,comments,comments_checked'; //����ͳ�Ʊ����
				if($this->exevars['othor']>2) $tables[$content->table_digg] = 'supports,againsts,supports_day,againsts_day,supports_week,againsts_week,supports_month,againsts_month'; //����DIGG�����
			}
			$tag = $tables ? 'tables' : NULL;
			$tabletag = ($tag ?'news_content.' :'');
			$content->setHandler($tag);
			if($tables){
				$tablestr = $fields = '';
				foreach($tables as $table=>$field){
					$tablestr.= " LEFT JOIN ".jieqi_dbprefix($table)." AS {$table} ON {$tabletag}contentid={$table}.contentid ";
					$fields.= ",{$table}.{$field}";
				}
				$content->criteria->setFields("{$tabletag}*{$fields}");
				$content->criteria->setTables(jieqi_dbprefix('news_content')." AS news_content {$tablestr}");
			}
		}else $content->setHandler();
		//if($this->exevars['field']!='typeid'){
			if($this->exevars['catid']){
				if(count($this->exevars['catid'])>1){
					$catids = implode(',',$this->exevars['catid']);
					$content->criteria->add(new Criteria('catid', "($catids)", 'in'));
				}elseif(count($this->exevars['catid'])==1){
				    if($SGLOBAL['cate']['child']){
					    $catids = $SGLOBAL['cate']['arrchildid'];
					    $content->criteria->add(new Criteria('catid', "($catids)", 'in'));
						
					} else $content->criteria->add(new Criteria('catid', $this->exevars['catid'][0]));
				}else{
					//$content->criteria->add(new Criteria('catid', '', '<>'));
				}
			}
		//}
		
		switch($this->exevars['field']){
/*		    case 'typeid':
				$content->criteria->add(new Criteria('typeid', $this->exevars['typeid']));
				$content->criteria->setSort('contentid');
			break;*/
			case 'updatetime':
			    $content->criteria->setSort("{$tabletag}updatetime");
			break;
			case 'inputtime':
				$content->criteria->setSort("{$tabletag}contentid");
			break;
			default:
				$content->criteria->setSort($this->exevars['field']);
			break;
		}
		$content->criteria->add(new Criteria('status', 99));
		$content->criteria->setOrder($this->exevars['asc']);
		$_PAGE['rows'] = $content->lists($this->exevars['listnum']);
		$jieqiTpl->assign('length', $this->exevars['length']);
        $jieqiTpl->assign('articlerows', $_PAGE['rows']);
		$jieqiTpl->assign('_SGLOBAL', $SGLOBAL);
		$jieqiTpl->assign('url_more', jieqi_geturl('news', 'lists', $this->exevars['catid'][0], 1));
	}
}

?>