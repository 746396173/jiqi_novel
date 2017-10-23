<?php 
/**
 * ��������
 *
 * ������������������������
 * 
 * ����ģ�壺/modules/article/templates/searchresult.html
 * 
 * @category   jieqicms
 * @package    article
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: search.php 332 2009-02-23 09:15:08Z juny $
 */
 
 class searchModel extends Model {
 	function search($params = array())
	{
		global $jieqiModules;
		$this->addConfig('article','configs');
		$this->addLang('article', 'search');
		$jieqiConfigs['article'] = $this->getConfig('article','configs');
		$jieqiLang['article'] = $this->getLang('article');
		if($params['searchkey']=='�����ٰ���') $params['searchkey']='ǿ�������ܲ�����';
		//if($params['searchkey']=='���֮����Ů�Ѳ��ǹԹ���') $params['searchkey']='���֮��:Ů�Ѳ��ǹԹ���';
		$params['searchkey'] = urldecode($params['searchkey']);
		//print_r($params);exit;
		//�ؼ����ж�
		if(isset($params['searchkey'])){
			$params['searchkey']=trim($params['searchkey']);
		}// print_r($params);
		
        if(empty($params['searchkey'])) {
			$this->printfail($jieqiLang['article']['need_search_keywords']);
		}
		
		//�ؼ��ֳ���
        if(!empty($jieqiConfigs['article']['minsearchlen']) && strlen($params['searchkey'])<intval($jieqiConfigs['article']['minsearchlen'])) {
			$this->printfail(sprintf($jieqiLang['article']['search_minsize_limit'], $jieqiConfigs['article']['minsearchlen']));
		} 
		
		//���ʱ�䣬�Ƿ���������
		if(!empty($jieqiConfigs['article']['minsearchtime']) && empty($params['page'])){
			$jieqi_visit_time=jieqi_strtosary($_COOKIE['jieqiVisitTime']);
			if(!empty($_SESSION['jieqiArticlesearchTime'])) $logtime=$_SESSION['jieqiArticlesearchTime'];
			elseif(!empty($jieqi_visit_time['jieqiArticlesearchTime'])) $logtime=$jieqi_visit_time['jieqiArticlesearchTime'];
			else $logtime=0;
			if(($logtime>0) && JIEQI_NOW_TIME-$logtime < intval($jieqiConfigs['article']['minsearchtime'])) $this->printfail(sprintf($jieqiLang['article']['search_time_limit'], $jieqiConfigs['article']['minsearchtime']));
		
			$_SESSION['jieqiArticlesearchTime']=JIEQI_NOW_TIME;
			$jieqi_visit_time['jieqiArticlesearchTime']=JIEQI_NOW_TIME;
			setcookie("jieqiVisitTime",jieqi_sarytostr($jieqi_visit_time),JIEQI_NOW_TIME+3600, '/', JIEQI_COOKIE_DOMAIN, 0);
		}
		
		$params['searchkey']=htmlspecialchars(str_replace('&', ' ', $params['searchkey']));
		$searchstring=$params['searchkey'].'&&'.$params['searchtype'];
		$hashid=md5($searchstring);
		
		//ҳ��
		if (empty($params['page']) || !is_numeric($params['page'])) {
			$params['page']=1;
		}
		
		// �������������
		$articlestr = '';
		if (!$params['sort']){
			$params['sort'] = 'lastupdate';
			//$params['sort'] = 'size';
			//$params['sort'] = 'visit';
		}
		//�����������
		/*include_once($jieqiModules['article']['path'].'/class/searchcache.php');
		$searchcache_handler =& JieqiSearchcacheHandler::getInstance('JieqiSearchcacheHandler');
		$criteria=new CriteriaCompo(new Criteria('hashid', $hashid, '='));
		$criteria->setLimit(1);
		$criteria->setStart(0);
		$searchcache_handler->queryObjects($criteria);
		$searchcache=$searchcache_handler->getObject();*/
		
		$this->db->init('searchcache', 'cacheid', 'article');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('hashid', $hashid, '='));
		$this->db->criteria->setLimit(1);
		$this->db->criteria->setStart(0);
		$this->db->queryObjects ();
		$searchcache = $this->db->getObject();
		$usecache=false; //�Ƿ�ʹ��cache
		
		//����������
		if(is_object($searchcache)){
			if($searchcache->getVar('results', 'n')==1) $cachetime=86400;
			else $cachetime=7200;
			if(JIEQI_NOW_TIME - $searchcache->getVar('searchtime') < $cachetime) {
				$usecache=true;
			}
		}

		//����������
		$this->db->init('article','articleid','article');
		//include_once($jieqiModules['article']['path'].'/class/article.php');
        //$article_handler =& JieqiArticleHandler::getInstance('JieqiArticleHandler');

		//ҳ��С
		$jieqiConfigs['article']['pagenum'] = !empty($jieqiConfigs['article']['topcachenum']) ? $jieqiConfigs['article']['topcachenum'] : 10;
		if($usecache){//ʹ�û���
		
			$allresults=$searchcache->getVar('results', 'n');
			$aids=$searchcache->getVar('aids', 'n');
			//print_r($aids);exit;
			if(empty($aids)) $aids=0;
			elseif($allresults==1) $aids=intval($aids);
			else $aids=trim($aids);
			
			if($allresults > $jieqiConfigs['article']['pagenum']){
				$aidary=explode(',', $aids);
				$search_resultnum=count($aidary);
				$maxpage=ceil($search_resultnum / $jieqiConfigs['article']['pagenum']);
				if($params['page'] > $maxpage) $params['page']=$maxpage;
				$startid=($params['page']-1) * $jieqiConfigs['article']['pagenum'];
				$aids='';
				$i=$startid;
				$j=0;
				while($i<$search_resultnum && $j<$jieqiConfigs['article']['pagenum']){
					if(!empty($aids)) $aids.=',';
					$aids.=intval($aidary[$i]);
					$i++;
					$j++;
				}
				$rescount=$j;
			}else{
				$startid=0;
				$params['page']=1;
				$rescount=$allresults;
			}
		   
			//$sql="SELECT * FROM ".jieqi_dbprefix('article_article')." WHERE articleid IN (".jieqi_dbslashes($aids).") ORDER BY lastupdate DESC LIMIT 0, ".$jieqiConfigs['article']['pagenum'];
			//$res=$article_handler->execute($sql);
			unset($this->db->criteria);
			$this->db->setCriteria();
		   if ($params['sort']=='visit'){
		    	$articlestr = 'a.';
		    	$params['sort'] = 's.visit';
		    	$this->db->criteria->setTables($this->dbprefix('article_article')." AS a LEFT JOIN ".$this->dbprefix('article_statamout')." AS s ON a.articleid=s.articleid");
		    }
			$this->db->criteria->add(new Criteria($articlestr.'articleid', '('.jieqi_dbslashes($aids).')', 'IN'));
			$this->db->criteria->add(new Criteria($articlestr.'firstflag',13,'<>'));
			$this->db->criteria->setFields($articlestr."*");
			$this->db->criteria->setSort($params['sort']);
	        $this->db->criteria->setOrder('DESC');
			$this->db->criteria->setLimit($jieqiConfigs['article']['maxsearchres']);
	        $this->db->criteria->setStart(0);
			$res= $this->db->queryObjects();
			$truecount=$this->db->getRowsNum($res);
			//print_r($aids);exit;
			if($truecount != $rescount) $usecache=false;	
	   }elseif(!$usecache){
			//��ʹ�û���
			//$this->db->setCriteria();
			$this->db->init('article','articleid','article');
			$this->db->setCriteria();
			if ($params['sort']=='visit'){
				$articlestr = 'a.';
				$params['sort'] = 's.visit';
				$this->db->criteria->setTables($this->dbprefix('article_article')." AS a LEFT JOIN ".$this->dbprefix('article_statamout')." AS s ON a.articleid=s.articleid");
			}
			$this->db->criteria->add(new Criteria($articlestr.'display', '0', '='));
			$this->db->criteria->add(new Criteria($articlestr.'size','0','>'));

			if(!empty($params['searchkey'])){
				$this->db->criteria->add(new Criteria($articlestr.'articlename', '%'.$params['searchkey'].'%', 'LIKE'));
				$this->db->criteria->add(new Criteria($articlestr.'author', '%'.$params['searchkey'].'%', 'LIKE'),'or');
	         }
            $this->db->criteria->add(new Criteria($articlestr.'firstflag',13,'<>'));
			$this->db->criteria->add(new Criteria($articlestr.'display', '0', '='));
	        $this->db->criteria->add(new Criteria($articlestr.'size','0','>'));
	        $this->db->criteria->setFields($articlestr."*");
			$this->db->criteria->setSort($params['sort']);
	        $this->db->criteria->setOrder('DESC');
			
			$jieqiConfigs['article']['maxsearchres']=intval($jieqiConfigs['article']['maxsearchres']);
			if(empty($jieqiConfigs['article']['maxsearchres'])) $jieqiConfigs['article']['maxsearchres']=200;
			$this->db->criteria->setLimit($jieqiConfigs['article']['maxsearchres']);
	        $this->db->criteria->setStart(0);
		
			$res= $this->db->queryObjects();
	        $allresults=$this->db->getRowsNum($res);
			if($allresults <= $jieqiConfigs['article']['pagenum']) {
				$rescount=$allresults;
			}else {
				$rescount=$jieqiConfigs['article']['pagenum'];
			}
			$params['page']=1;
	   }
	
	   if($rescount == 1 && $params['page']==1){
		//ֻ��һ���������ֱ��ָ��������Ϣҳ��
		$article=$this->db->getObject();
		if(!is_object($article)) $this->printfail($jieqiLang['article']['no_search_result']);
		$this->db->init('searchcache', 'cacheid', 'article');
		if(!$usecache){
			$aids=$article->getVar('articleid');
			$cleancache=false;
			if(is_object($searchcache)){
				//��ǰ�л��棬����
				$searchcache->setVar('searchtime', JIEQI_NOW_TIME);
				$searchcache->setVar('results', $allresults);
				$searchcache->setVar('aids', $aids);
				$searchcache->setVar('searchtype', intval($searchcache->getVar('searchtype'))+1);
				
				if(date('s',  JIEQI_NOW_TIME) == '00') {
					$cleancache=true;
				}
				$this->db->edit($searchcache->getVar('cacheid', 'n'),$searchcache);
			}else{
				//��ǰû���棬����
				//$searchcache = $searchcache_handler->create();
				$searchcache['searchtime']= JIEQI_NOW_TIME;
				$searchcache['hashid']=$hashid;
				$searchcache['keywords']= $params['searchkey'];
				$searchcache['searchtype'] =  1;
				$searchcache['results'] = $allresults;
				$searchcache['aids']= $aids;
				$this->db->add($searchcache);
			}
			
			//������ڻ���
			if($cleancache){
			    $this->db->setCriteria(new Criteria('searchtime', JIEQI_NOW_TIME - $cachetime, '<'));
				//$criteria=new CriteriaCompo(new Criteria('searchtime', JIEQI_NOW_TIME - $cachetime, '<'));
				$this->db->delete($this->db->criteria);
			}
		}
		//�ͷ���Դ
		//jieqi_freeresource();
		return array(
		'articlerows'=> $rescount,
		'aid'=>$article->getVar('articleid'));
	}else{
		//include_once(JIEQI_ROOT_PATH.'/header.php');
		//header($this->getUrl());
		//������ش�����
		$artileLib = $this->load('article','article');
		$articlerows=array();
		$k=0;
		$aids='';
		while($v = $this->db->getObject()){
			if(!$usecache){
				if(!empty($aids)) $aids.=',';
				$aids.=$v->getVar('articleid');
			}
			$articlerows[$k] = $artileLib->article_vars($v);
			$k++;
			if($k >= $jieqiConfigs['article']['pagenum']) break;
		}
	
		//����ʣ��Ľ�������ڻ���
		if(!$usecache){
			while($v = $this->db->getObject()){
				if(!empty($aids)) $aids.=',';
				$aids.=$v->getVar('articleid');
			}
			//include_once($jieqiModules['article']['path'].'/class/searchcache.php');
		    //$searchcache_handler =&JieqiSearchcacheHandler::getInstance('JieqiSearchcacheHandler');
			
			$this->db->init('searchcache', 'cacheid', 'article');
			if(is_object($searchcache)){
				//��ǰ�л��棬����
				$searchcache->setVar('searchtime', JIEQI_NOW_TIME);
				$searchcache->setVar('results', $allresults);
				$searchcache->setVar('aids', $aids);
				$searchcache->setVar('searchtype', intval($searchcache->getVar('searchtype'))+1);
				$this->db->edit($searchcache->getVar('cacheid', 'n'),$searchcache);
			}else{
				//��ǰû���棬����
				//$searchcache = $searchcache_handler->create();
				$searchcache = array();
				$searchcache['searchtime']=JIEQI_NOW_TIME;
				$searchcache['hashid']=$hashid;
				$searchcache['keywords']=$params['searchkey'];
				$searchcache['results']=$allresults;
				$searchcache['aids']=$aids;
				$searchcache['searchtype']=1;
				$this->db->add($searchcache);
			}
		}else{
		
			if(is_object($searchcache)){
				//��ǰ�л��棬����
				$searchcache->setVar('searchtime', JIEQI_NOW_TIME);
				//$searchcache->setVar('results', $allresults);
				//$searchcache->setVar('aids', $aids);
				$searchcache->setVar('searchtype', intval($searchcache->getVar('searchtype'))+1);
				$this->db->init('searchcache', 'cacheid', 'article');
				$this->db->edit($searchcache->getVar('cacheid', 'n'),$searchcache);
			}	  
		}
	}
	
	//include_once(JIEQI_ROOT_PATH.'/lib/html/page.php');
	//$jumppage = new JieqiPage($allresults,$jieqiConfigs['article']['pagenum'],$params['page']);
	//$custompage = "";
	$jumppage = new GlobalPage(JIEQI_PAGE_TAG,$allresults,$jieqiConfigs['article']['pagenum'],$params['page']);
    $jumppage->setlink();
    //$jumppage->whole_bar();
	
     $url = parse_url($this->geturl('article','search','evalpage=0','SYS=searchkey='.urlencode(iconv('gbk','utf-8',$params['searchkey'])).'&page='.$params['page']));
     $wapurl = parse_url($this->geturl('article','search','SYS=searchkey='.urlencode(iconv('gbk','utf-8',$params['searchkey'])).'&page='.$params['page']));
     $maxpage = $allresults == 0 ? 0 : ceil($allresults / $rescount);
	 return array('articlerows'=>$articlerows,
	 'searchkey'=> $params['searchkey'],
	 'page'=> $params['page'],
	 'sort'=> $params['sort'],		
	 'rescount'=>$rescount,
	 'allresults'=>$allresults,
	 'maxpage'=>$maxpage,
	 'pathurl'=>$wapurl['path'],
	 'url_jumppage'=>$jumppage->getPage($url['path'])
	 );
 }}
?>