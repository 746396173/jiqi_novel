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
 * @version    2014-5-12 �޶���
 */

class BlockArticleArticlelist extends JieqiBlock
{
	var $module = 'article';
	var $template = 'block_articlelist.html';
	
	var $exevars=array('field'=>'totalvisit', 'listnum'=>15, 'sortid'=>'0', 'isauthor'=>0, 'isfull'=>0, 'asc'=>0, 'articletype'=>0, 'firstflag'=>'','siteid'=>JIEQI_SITE_ID);  //ִ������
	
	//listnum ��ʾ����
	//sortid 0��ʾ������𣬿����Ƕ����� '1|2|3'
	//isauthor 0 ��ʾ����, 1��ʾԭ����2��ʾת��
	//isfull 0 ��ʾ����, 1��ʾȫ����2����
	//asc  0��ʾ�Ӵ���С�ţ�1��ʾ��С����
	//permission ��Ȩ�ȼ� �ձ�ʾ����� 0-3 ��Ȩ�ȼ�,���Զ���ȼ� 1|2|3
	//firstflag �Ƿ��׷� �ձ�ʾ����� 0��վ�׷� 1��վ�׷�
	function BlockArticleArticlelist(&$vars){
		global $jieqiArticleuplog;
		$this->JieqiBlock($vars);
		if(!empty($this->blockvars['vars'])){
			$varary=explode(',', trim($this->blockvars['vars']));
			$arynum=count($varary);
			if($arynum>0){
				$varary[0]=trim($varary[0]);
				if($varary[0]=='mouthvisit') $varary[0]='monthvisit';
				elseif($varary[0]=='mouthvote') $varary[0]='monthvote';
				if(!in_array($varary[0], array('lastupdate','totalvisit', 'monthvisit', 'weekvisit','dayvisit','totalsale', 'monthsale', 'weeksale','daysale','totalvipvote', 'monthvipvote', 'weekvipvote',  'totalvote', 'monthvote', 'weekvote', 'dayvote', 'postdate', 'size','monthsize','weeksize','daysize', 'signdate', 'vipdate','totalgoodnum', 'monthgoodnum', 'weekgoodnum'))) $this->exevars['field']='lastupdate';
				else $this->exevars['field']=$varary[0];
			}

			if($arynum>1){
				$varary[1]=trim($varary[1]);
				if(is_numeric($varary[1]) && $varary[1]>0) $this->exevars['listnum']=intval($varary[1]);
			}

			if($arynum>2){
				$varary[2]=trim($varary[2]);
				$tmpvar=str_replace('|', '', $varary[2]);
				if(is_numeric($tmpvar)) $this->exevars['sortid']=$varary[2];
				elseif($this->getRequest($tmpvar) && is_numeric($this->getRequest($tmpvar))){
					$this->exevars['sortid']=$this->getRequest($tmpvar);
				} 
			}
			if($arynum>3){
				//�Ƿ�ԭ����Ĭ�� 0 ��ʾ���жϣ���1 ��ʾֻ��ʾԭ����Ʒ��2 ��ʾת����Ʒ
				$varary[3]=trim($varary[3]);
				if(in_array($varary[3], array('0', '1', '2')) || $varary[3] > 2) $this->exevars['isauthor']=$varary[3];
			}
// 			if($arynum>3){
// 				//�Ƿ�ԭ����Ĭ�� 0 ��ʾ���жϣ���1 ��ʾֻ��ʾarticletype=1����Ʒ��
// 				$varary[3]=trim($varary[3]);
// 				if(in_array($varary[3], array('0', '1', '2')) || $varary[3] > 1) $this->exevars['articletype']=$varary[3];
// 			}
			if($arynum>4){
				//�Ƿ�ȫ����Ĭ�� 0 ��ʾ���жϣ���1 ��ʾֻ��ʾȫ����Ʒ��2 ��ʾ������Ʒ
				$varary[4]=trim($varary[4]);
				if(in_array($varary[4], array('0', '1', '2'))) $this->exevars['isfull']=$varary[4];
			}
			if($arynum>5){
				//��ʾ˳��Ĭ�� 0 ��ʾ���Ӵ�С���򣩣�1 ��ʾ��С��������
				$varary[5]=trim($varary[5]);
				if(in_array($varary[5], array('0', '1'))) $this->exevars['asc']=$varary[5];
			}
			//articletype
			if($arynum>6){
				//�Ƿ�vip���£�Ĭ�� 0 ��ʾ���жϣ���1 ��ʾvip���£�2 ��ʾ��vip����
				$varary[6]=trim($varary[6]);
				if(in_array($varary[6], array('0', '1', '2')) || $varary[6] > 2) $this->exevars['articletype']=$varary[6];
			}
			
			if($arynum>7){
				$varary[7]=trim($varary[7]);
				if(in_array($varary[7], array('0', '1'))) $this->exevars['firstflag']=$varary[7];
			}
			
			if($arynum>8){
				$varary[8]=trim($varary[8]);
				if(is_numeric($varary[8])) $this->exevars['siteid']=$varary[8];
				// ����main��Ӧ��ѯ
				if(is_string($varary[8]) && 'main'==$varary[8]) $this->exevars['siteid']='main';
			}else $this->exevars['siteid']=JIEQI_SITE_ID;
		}
		$this->blockvars['cacheid']=md5(serialize($this->exevars).'|'.$this->blockvars['template']);	
		/*if($this->exevars['field']=='lastupdate' || $this->exevars['field']=='postdate'){
			jieqi_getcachevars('article', 'articleuplog');
			if(!is_array($jieqiArticleuplog)) $jieqiArticleuplog=array('articleuptime'=>0, 'chapteruptime'=>0);
			$this->blockvars['overtime'] = $jieqiArticleuplog['articleuptime'] > $jieqiArticleuplog['chapteruptime'] ? intval($jieqiArticleuplog['articleuptime']) : intval($jieqiArticleuplog['chapteruptime']);
		}*/
	}

	/**
	 * article ���� article_stat �� articleΪ׼��ѯ
	 * @see JieqiBlock::setContent()
	 */
	function setContent($isreturn=false){
	    global $jieqiTpl;
		$package = $this->load('article','article');

		$this->db->init('article','articleid','article');

		if(!in_array($this->exevars['field'],array('monthsize','weeksize','daysize'))){//�����������
			// ��ȡȫ���б�����ѧ����-200��
			if('main'==$this->exevars['siteid']){
				$this->db->setCriteria(new Criteria ( 'siteid',200, '<' ));
			}else{
				$this->db->setCriteria(new Criteria ( 'siteid',$this->exevars['siteid'], '=' ));
			}
			$this->db->criteria->add ( new Criteria ( 'display',0 ));
			$this->db->criteria->add ( new Criteria ( 'firstflag',4, "<>" ));
			$statArray = $package->getStatArray();
			$statstr = $package->getStatStr();
			if(preg_match('/'.$statstr.'$/',$this->exevars['field'])){
				$this->db->criteria->setTables(jieqi_dbprefix('article_stat').' s RIGHT JOIN '.jieqi_dbprefix('article_article').' a ON s.articleid=a.articleid');
				$this->db->criteria->setFields('a.*,s.mid,s.total,s.month,s.week,s.day,s.totalnum,s.monthnum,s.weeknum,s.daynum,s.lasttime');
				$order = preg_replace("/$statstr/",'',$this->exevars['field']);
				$mid = str_replace($order,'',$this->exevars['field']);
				$midname = $statArray[$mid]['name'];
				$visitfield = $order;
				$this->db->criteria->add ( new Criteria ( 's.mid',$mid, '=' ));
				if($order!='total'){
					$this->db->criteria->add ( new Criteria ( 's.lasttime',$this->getTime($order), '>=' ));
				}
				$this->db->criteria->setSort( "s.$order" );
				$havastat = true;
			}else{
			    $this->db->criteria->add ( new Criteria ( 'chapters',0 ,'>')); 
				$visitfield = $this->exevars['field'];
				switch($this->exevars['field']){
					case 'size'://������
						$this->db->criteria->setSort( "size" );
						$midname = "������";
					break;
					case 'signdate'://����
						$this->db->criteria->setSort( "signdate" );
						$this->db->criteria->add ( new Criteria ( 'permission','3', '>' ));
						$midname = "����ǩԼ";
					break;
					case 'vipdate'://����
						$this->db->criteria->setSort( "vipdate" );
						$this->db->criteria->add ( new Criteria ( 'articletype',0, '>' ));
						$midname = "�����ϼ�";
					break;
					case 'postdate'://����
						$this->db->criteria->setSort( "postdate" );
						$midname = "��������";
					break;
					default:
						$this->db->criteria->setSort( "lastupdate" );
						$midname = "����";
					break;
				}
				$havastat = false;
			}
		}else{
		     $visitfield = $this->exevars['field'];
		     // ��ȡȫ���б�����ѧ����-200��
			 if('main'==$this->exevars['siteid']){
				 $this->db->setCriteria(new Criteria ( 'a.siteid',200, '<' ));
			 }else{
				 $this->db->setCriteria(new Criteria ( 'a.siteid',$this->exevars['siteid'], '=' ));
			 }
		     $this->db->criteria->add ( new Criteria ( 'a.display',0 ));
		     $this->db->criteria->setTables($this->dbprefix('article_chapter ').' c RIGHT JOIN '.$this->dbprefix('article_article').' a ON c.articleid=a.articleid');
		     $this->db->criteria->setFields('a.*,sum( c.size ) AS '.$this->exevars['field']);
			 $this->db->criteria->add ( new Criteria ( 'a.articletype',0, '>' ));
			 $this->db->criteria->add ( new Criteria ( 'c.postdate',$this->getTime(str_replace('size','',$this->exevars['field'])), '>=' ));
			 $this->db->criteria->add ( new Criteria ( 'c.display',0, '=' ));
			 $this->db->criteria->setGroupby ('c.articleid');
			 $this->db->criteria->setSort( $this->exevars['field'] );
			 if($this->exevars['field']=='monthsize') $midname = "�¸�������";
			 elseif($this->exevars['field']=='weeksize') $midname = "�ܸ�������";
			 elseif($this->exevars['field']=='daysize') $midname = "�ո�������";
		}
		if(!empty($this->exevars['sortid'])){
			$sortstr='';
			$sortnum=0;
			$sortary=explode('|', $this->exevars['sortid']);
			foreach($sortary as $v){
				if(is_numeric($v)){
					if(!empty($sortstr)) $sortstr.=',';
					$sortstr.=intval($v);
					$sortnum++;
				}
			}
			if($sortnum==1) $this->db->criteria->add ( new Criteria ( 'sortid', $sortstr ));
			elseif($sortnum>1) $this->db->criteria->add ( new Criteria ( 'sortid', '('.$sortstr.')', 'IN' ));
		}
		
		if($this->exevars['isauthor']==1) $this->db->criteria->add ( new Criteria ( 'authorid', '0', '>' ));
		elseif($this->exevars['isauthor']==2) $this->db->criteria->add ( new Criteria ( 'authorid', '0', '>' ));
		if($this->exevars['isfull']==1) $this->db->criteria->add ( new Criteria ( 'fullflag', '1', '=' ));
		elseif($this->exevars['isfull']==2) $this->db->criteria->add ( new Criteria ( 'fullflag', '0', '=' ));
		if($this->exevars['articletype'] == 1) $this->db->criteria->add ( new Criteria ( 'articletype', '0', '>' ));//�����ϰ汾�������д���1�ģ��°汾������1
		elseif($this->exevars['articletype']==2) $this->db->criteria->add ( new Criteria ( 'articletype', '0', '=' ));
		 
		//��Ȩ���
		if(strlen($this->exevars['permission'])>0){
			$perstr='';
			$pernum=0;
			$perary=explode('|', $this->exevars['permission']);
			foreach($perary as $v){
				if(is_numeric($v)){
					if(!empty($perstr)) $perstr.=',';
					$perstr.=intval($v);
					$pernum++;
				}
			}
			if($pernum==1) $this->db->criteria->add ( new Criteria ( 'permission', $perstr ));
			elseif($pernum>1) $this->db->criteria->add ( new Criteria ( 'permission', '('.$perstr.')', 'IN' ));
		}
		//�Ƿ��׷�
		if(strlen($this->exevars['firstflag'])>0){
			$this->db->criteria->add ( new Criteria ( 'firstflag',intval($this->exevars['firstflag']), '=' ));
		}
		
		 if($this->exevars['asc']==1) $this->db->criteria->setOrder( 'ASC' );
		 else  $this->db->criteria->setOrder( 'DESC' );
		 $this->db->criteria->setLimit($this->exevars['listnum']);
		 $this->db->queryObjects($this->db->criteria);
		 
		 $k=0;
		 while($v = $this->db->getObject()){
		      $articlerows[$k] = $package->article_vars($v);
			  $articlerows[$k]['visitnum']=ceil($v->getVar($visitfield));
			  $articlerows[$k]['visitnum_w']=number_format($articlerows[$k]['visitnum']/10000,1,".","");//����
			  if(in_array($visitfield,array('size','monthsize','weeksize','daysize'))){ 
			  	$articlerows[$k]['visitnum']=ceil($articlerows[$k]['visitnum']/2);
			  	$articlerows[$k]['visitnum_w']=number_format($articlerows[$k]['visitnum']/10000,1,".","");//����
			  }
			  elseif($visitfield=='lastupdate' || $visitfield=='postdate' || $visitfield=='signdate' || $visitfield=='vipdate') {
			  	$articlerows[$k]['visitnum']=date('Y-m-d', $articlerows[$k]['visitnum']);
			  }
			  $k++;
		 }
		 $jieqiTpl->assign_by_ref('articlerows', $articlerows);
		 $jieqiTpl->assign('url_more', $this->geturl(JIEQI_MODULE_NAME, 'top',  'method=toplist', 'type='.$this->exevars['field'], 'SYS=sortid='.$this->exevars['sortid'].'&page=1'));
    }
}
?>