<?php
/*
    *ͨ�����´�����
	[Cms News] (C) 2010-2012 Cms Inc.
	$Id: content.class.php 12398 2010-06-03 15:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

class Content extends View{
    var $tablepre = 'news_';
	var $table = 'content';  //��������
	var $idfield = 'contentid';//�������ֶ�
	var $table_count; //���ͳ�Ʊ���/������
	var $table_digg; //DIGG����/������
	var $table_digglog; //DIGG��־����/������
	var $table_mood; //MOOD����/������
	var $datadir;
	var $handler;
	var $criteria;
	var $jumppage;
	/**
	 * ���캯��
	 * 
	 * @param      void       
	 * @access     private
	 * @return     void
	 */
	function Content(){
		 $this->table = $this->tablepre.$this->table;
		 $this->table_count = $this->tablepre.'content_count';
		 $this->table_digg = $this->tablepre.'digg';
		 $this->table_digglog = $this->tablepre.'digg_log';
		 $this->table_mood = $this->tablepre.'mood_data';
		 $this->datadir = CACHE_PATH."/modules/"._MODULE_.'/info/';
	}
	
	/**
	 * ��ʼ����ѯ����
	 * 
	 * @access     public
	 * @return     empty
	 */	
	function setHandler($tag = ''){
	    global $_SGLOBAL;
		if(!$tag){
			include_once($_SGLOBAL['news']['path'].'/class/content.php');
			if(!is_object($this->handler)) $this->handler =& JieqiContentHandler::getInstance('JieqiContentHandler');
		}else{
			//�������ݿ�
			dbconnect();
			if(!is_object($this->handler)) $this->handler =& JieqiQueryHandler::getInstance('JieqiQueryHandler');
		}
		if(!is_object($this->criteria)) $this->criteria=new CriteriaCompo();
	}
	
	/**
	 * ��ȡһ������ʵ��
	 * 
	 * @access     public
	 * @return     empty
	 */	
	function get($contentid, $readall = true)
	{
	    global $_SGLOBAL,$_OBJ;
	    if(!$contentid) return true;
		if($readall) $cachefile = $this->getCacheFile($contentid);
		if(1 && is_file($cachefile) && $readall && filesize($cachefile)>0 && _NOW_ - filemtime($cachefile) < CACHE_LIFETIME){
		    include_once($cachefile);
			$ret = $_SGLOBAL["{$contentid}"][$contentid];
		} else {
			$this->setHandler();
			$content=$this->handler->get($contentid);
			if(!$content) return true;
			$ret = $this->get_news_vars($content);
			//��ȡ����
			if($readall){
				if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
				$table = $_SGLOBAL['model'][$ret['modelid']]['tablename'];
				if(!$table) jieqi_printfail(LANG_ERROR_PARAMETER);
				$table = $this->tablepre.'c_'.$table;
				$sql = 'select * from '.jieqi_dbprefix("{$table}")." where {$this->idfield} = {$contentid}";
				if($c = selectsql($sql)) $ret = array_merge($ret, $c[0]);
			}
			if(1 && $readall){//USE_CACHE
				$data[] = $ret;
				cache_write("{$contentid}", "_SGLOBAL['{$contentid}']", $data, 'contentid', $cachefile);
			}
		}
		return $ret;
	}

	/**
	 * ��������ʵ�����󣬷����ʺ�ģ�帳ֵ��������Ϣ����
	 * 
	 * @param      object      $news ����ʵ��
	 * @access     public
	 * @return     array
	 */
	function get_news_vars($news, $output = false){
		global $_SGLOBAL,$_OBJ;
		if(!is_object($_SGLOBAL['category'])) $_OBJ['category'] = new Category();
		if(!is_object($_SGLOBAL['model'])) $_OBJ['model'] =new Model();
		//����content�࣬�����жϵ�ǰ�����Ƿ����ɾ�̬
		//if(!is_object($this)) $this = new Content();
		$i = 0;
		$ret = array();
		foreach($news->vars as $k=>$v){
			if($i && array_key_exists($k, $ret)) continue;
			$ret[$k]=$news->getVar($k,'n');
			$i++;
		}
		if($output && $ret['thumb'] && substr(strtolower($ret['thumb']),0,7)!='http://'){
			$attachurl = $_OBJ['category']->getAttachurl($ret['catid']);
			$ret['thumb'] = $attachurl.$ret['thumb'];
		}
		if($this->isHtml($ret)) $ret['ishtml'] = true;
		else  $ret['ishtml'] = false;
		$ret['alltitle'] = $this->setStyle($ret['title'], $ret['style'], $ret['thumb']);
		$ret['catname'] = $_SGLOBAL['category'][$ret['catid']]['catname'];
		$ret['modelid'] = $_SGLOBAL['category'][$ret['catid']]['modelid'];
		$ret['modelname'] = $_SGLOBAL['model'][$_SGLOBAL['category'][$ret['catid']]['modelid']]['name'];
		$ret['url_articleinfo'] = $this->getUrl($ret, 1);//jieqi_geturl('news', 'show', $ret, 1);
		$ret['url_catelist'] = $_OBJ['category']->getUrl($ret['catid']);
		return $ret;
	}

    //���α���
	function setStyle($str, $style, $thumb = ''){
		if(!$style && !$thumb) return $str;
		$str = $style ?"<span class=\"{$style}\">{$str}</span>" :$str;
		return "$str".($thumb ?' <font color="red">ͼ</font>' :'');
	}
	
	/**
	 * ��ȡ�����ļ�·��
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getCacheFile($id){
	     $dir = $this->datadir;
		 if(!is_dir($dir)) if(!jieqi_createdir($dir, 0777, true)) return false;
		 if($this->module) $dir = $dir."{$this->module}/";
		 if(!is_dir($dir)) if(!jieqi_createdir($dir, 0777, true)) return false;
		 return $dir.$id.'.php';
	 }
	 
	/**
	 * ���һ������
	 * 
	 * @access     public
	 * @return     empty
	 */
	 function delCache($id){
	     $cachefile = $this->getCacheFile($id);
		 if(is_file($cachefile)) @unlink($cachefile);
	 }
	 	 	
	/**
	 * ���һ�������Ƿ����
	 * 
	 * @access     public
	 * @return     empty
	 */	
	 function checkTitle($title, $param = array(), $level = 0){
	      global $_SGLOBAL,$_SCONFIG;
		  $where = '';
		  $level = $level ? $level : $_SCONFIG['samearticlename'];
		  switch($level){
		      case 1:
			      if($param['modelid']){
					  if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
					  $catids = $_OBJ['model']->getMCatids($param['modelid']);
					  if($catids){
					      $where = '`catid` in ('.implode(',', $catids).') AND ';
					  }
				  }
			  break;
		  }
		  $title = shtmlspecialchars($title);
	      $info = selectsql("SELECT * FROM `".jieqi_dbprefix($this->table)."` WHERE $where `title`='$title'");
		  if($info[0]['contentid']) return TRUE;
		  else return FALSE;
	 }
	 
	/**
	 * �������ֶ�������������Ƿ����
	 * 
	 * @access     public
	 * @return     empty
	 */	
	 function checkFields($data,$table = '', $param = array(), $level = 0){
	      global $_SGLOBAL,$_SCONFIG;
		  if(!is_array($data)) return FALSE;
		  $where = '';
		  $level = $level ? $level : $_SCONFIG['samearticlename'];
		  switch($level){
		      case 1:
			      if($param['modelid']){
					  if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
					  $catids = $_OBJ['model']->getMCatids($param['modelid']);
					  if($catids){
					      $where = '`catid` in ('.implode(',', $catids).') AND ';
					  }
				  }
			  break;
		  }
		  $sql = $comma = $co = '';
		  foreach ($data as $key => $value) {
			  $sql .= $comma.'`'.$key.'`';
			  $sql .= '=\''.shtmlspecialchars($value).'\'';
			  $comma = ' AND ';
		  }
		  if($table) $co = " as a left join `".jieqi_dbprefix($table)."` as b on a.contentid=b.contentid ";
	      $info = selectsql("SELECT * FROM `".jieqi_dbprefix($this->table)."` {$co} WHERE {$where} {$sql}");
		  if($info[0]['contentid']) return count($info);
		  else return FALSE;
	 }
	 	 
	/**
	 * ��ȡһ����Ŀ���ļ���
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getUrlrule($data, $page = 1, $evalpage = true){
	     global $_SGLOBAL,$_OBJ;
		 if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		 $cate=$_OBJ['category']->get($data['catid']);
		 if($cate['type']>0) return false;//����ҳ//����
		 if(!$data['contentid'] || !is_array($data)) return false;//���ݲ�����
		 extract($data);//
		 $isrule = false;//��ַ�Ƿ���Ҫ����
		 
	     if($prefix){//�����ļ���
			 $urlrule = $prefix;//!substr_count($prefix,'.') ? $prefix.'.html' : $prefix;//Ĭ��
			 $isrule = true;
		 }else{
			 $urlrule = 'show-{$contentid}-{$page}';//Ĭ��
			 if($cate['setting']['show_urlrule']){
				 $urlrule = $cate['setting']['show_urlrule'];
			 }else{
				 if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
				 if($_SGLOBAL['model'][$cate['modelid']]['show_urlrule']){
					 $urlrule = $_SGLOBAL['model'][$cate['modelid']]['show_urlrule'];
				 }
			 }
			 if($evalpage){
			     if($page<2) $urlrule_tmp = $urlrule;
				 if(!substr_count($urlrule, '/')){
					 if($page<2) $urlrule = $contentid;//Ĭ��
					 else $isrule = true;
				 }else{
					 if($page<2) $urlrule = substr($urlrule, 0, strrpos($urlrule, '/')+1).'index';
					 $isrule = true;
				 }
				 if($page<2 && substr_count($urlrule_tmp,'.')>0){
				     $urlrule = $urlrule.'.'.fileext($urlrule_tmp);
				 }
			 }else{
			     $page = '<{$page}>';
				 $isrule = true;
			 }
		 }
		 if($isrule) eval('$urlrule = "'.saddslashes($urlrule).'";');
		 $urlrule = !substr_count($urlrule,'.') ? $urlrule.'.html' : $urlrule;
		 return $urlrule;
	 }
	 
	/**
	 * ��ȡһ�������Ƿ������ļ�
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function isHtml($data){
	     global $_SGLOBAL,$_OBJ;
		 if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		 $cate=$_OBJ['category']->get($data['catid']);
		 if($cate['type']>0 || $data['url']) return false;//����ҳ//����||ת������
		 $ishtml = false;//Ĭ��
		 //������ڲ���Ŀ
		 if($cate['setting']['show_ishtml']>=0 && isset($cate['setting']['show_ishtml'])){
			 $ishtml = $cate['setting']['show_ishtml'];
		 }else{
			 if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
			 if($_SGLOBAL['model'][$cate['modelid']]['disabled']) return false;
			 $ishtml = $_SGLOBAL['model'][$cate['modelid']]['show_ishtml'];
		 }
		 if($ishtml<2) return false;
		 return $ishtml;
	 }
	 
	/**
	 * ��ȡһ��������ʾ��ʽ
	 * 
	 * @access     public
	 * @return     int
	 */	
	 function showType($data){
	     global $_SGLOBAL,$_OBJ;
		 if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		 $cate=$_OBJ['category']->get($data['catid']);
		 $tyle = 0;//Ĭ��
		 //������ڲ���Ŀ
		 if($cate['setting']['show_ishtml']>=0 && isset($cate['setting']['show_ishtml'])){
			 $tyle = $cate['setting']['show_ishtml'];
		 }else{
			 if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
			 if($_SGLOBAL['model'][$cate['modelid']]['disabled']) return false;
			 $tyle = $_SGLOBAL['model'][$cate['modelid']]['show_ishtml'];
		 }
		 return $tyle;
	 }	 
	 
	/**
	 * ��ȡһ�����µĴ��Ŀ¼
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function getDir($data){
	     global $_OBJ;
		 if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		 //if($data['catid']!=96){
		 $dir = str_replace(_ROOT_.'/', '', $_OBJ['category']->getDir($data['catid']));
		 $dirs = explode('/', $dir);
		 return _ROOT_.'/'.$dirs[0].'/';
		 //} else return $_OBJ['category']->getDir($data['catid']);
	 }
	 
	/**
	 * ��ȡһ�����µ�URL
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getUrl($data, $page = 1, $evalpage = true){
	     return jieqi_geturl('news', 'show', $data, $page, $evalpage);
	 }
	 	 	
	/**
	 * ����һ������
	 * 
	 * @access     public
	 * @return     int
	 */
	function add($tdata, $cdata){
	    global $_SGLOBAL,$_OBJ;
		if(!is_array($tdata) || !is_array($cdata) || !$tdata['catid']) return false;
		if($conentid = inserttable($this->table, $tdata, true)){
		
		   if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();

		   if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();

		   $table = $_SGLOBAL['model'][$_SGLOBAL['category'][$tdata['catid']]['modelid']]['tablename'];
		   $cdata['contentid'] = $conentid;
		   inserttable("{$this->tablepre}c_{$table}", $cdata);
		   //��Ŀ����ͳ��
		   updatetable('news_category', array('items'=>'++'),"catid={$tdata['catid']}");
		   //ģ������ͳ��
		   //updatetable('news_category', array('items'=>'++'),"catid={$tdata['catid']}");
		   //�ж��Ƿ������Ŀ����
		   $cache = false;
		   if(defined('UPDATE_CATEGORY_CACHE')){
		       if(UPDATE_CATEGORY_CACHE) $cache = true;
		   }else $cache = $_SGLOBAL['model'][$_SGLOBAL['category'][$tdata['catid']]['modelid']]['isrelated'];
		   if($cache) $_OBJ['category']->cache();
		   
		   return $conentid;
		}else{
		   return false;
		}
	}	
	
	/**
	 * �༭һ������
	 * 
	 * @access     public
	 * @return     int
	 */
	function edit($tdata, $cdata = array()){
	    global $_SGLOBAL, $_OBJ, $_PAGE;
		if(!is_array($tdata) || !$tdata['catid'] || !$tdata['contentid']) return false;
		$conentid = $tdata['contentid'];
		unset($tdata['contentid']);
		unset($cdata['contentid']);
		if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		$cate = $_OBJ['category']->get($tdata['catid']);
		//����ı�����Ŀ
		if($_PAGE['_GET']['catid'] && $_PAGE['_GET']['catid']!=$tdata['catid']){
		    $oldcate = $_OBJ['category']->get($_PAGE['_GET']['catid']);
		    //$oldmodel = $_SGLOBAL['category'][$_PAGE['_GET']['catid']]['modelid'];
			//$newmodel = $cate['modelid'];
			if(!$oldcate['modelid'] || !$cate['modelid']) jieqi_printfail(lang_replace('model_not_exists'));
			if($oldcate['modelid']!=$cate['modelid']) return false;
			updatetable('news_category', array('items'=>'--'),"catid={$_PAGE['_GET']['catid']}");
			updatetable('news_category', array('items'=>'++'),"catid={$tdata['catid']}");
			$_OBJ['category']->cache();
		}
		if(updatetable($this->table, $tdata, "{$this->idfield}={$conentid}")){
		    $model = $_OBJ['model']->get($cate['modelid'], true);
		    $table = $model['tablename'];
		    if($cdata) updatetable("{$this->tablepre}c_{$table}", $cdata, "{$this->idfield}={$conentid}");
			$this->delCache($conentid);
			return true;
		}else{
		    return false;
		}
	}
	
	/**
	 * ɾ��һ������
	 * 
	 * @access     public
	 * @return     bool
	 */
	function delete($data){
	    global $_SCONFIG, $_SGLOBAL, $_OBJ;
	    $conentid = $data['contentid'];
		if(deletesql($this->table, array("{$this->idfield}"=>"{$conentid}"))){
		    if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		    if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
			$cate = $_OBJ['category']->get($data['catid']);
		    $table = $_SGLOBAL['model'][$cate['modelid']]['tablename'];
		    deletesql("{$this->tablepre}c_{$table}", "{$this->idfield}={$conentid}");
			//ɾ�������������
			deletesql('news_comment', "{$this->idfield}={$conentid}");
			//ɾ�����ͳ��
			deletesql($this->table_count, "{$this->idfield}={$conentid}");
			//ɾ��DIGG����
			deletesql($this->table_digg, "{$this->idfield}={$conentid}");
			deletesql($this->table_digglog, "{$this->idfield}={$conentid}");
			//ɾ������
			deletesql($this->table_mood, "{$this->idfield}={$conentid}");
			//�޸���Ŀͳ��
			updatetable('news_category', array('items'=>'--'),"catid={$data['catid']}");
			$_OBJ['category']->cache();
			$this->delCache($conentid);
			//if($this->isHtml($data)) jieqi_delfile($this->getDir($data).$this->getUrlrule($data, 1).$_SCONFIG['htmlfile']);
			return true;
		}else{
		    return false;
		}
	}
	
	/**
	 * ���ӵ��
	 * 
	 * @access     public
	 * @return     array
	 */
	function hits($contentid, $num = 1, $data = array())
	{
	    global $_SGLOBAL;
		$contentid = intval($contentid);
		$sql = 'select * from '.jieqi_dbprefix($this->table_count)." WHERE `contentid`=$contentid";
		
		if($r = selectsql($sql)){ //����������Լ�
		    if(!$data){
				$data = $r[0];
				$data['hits'] = $data['hits'] + $num;
				$data['hits_day'] = (date('Ymd', $data['hits_time']) == date('Ymd', $_SGLOBAL['timestamp'])) ? ($data['hits_day'] + $num) : $num;
				$data['hits_week'] = (date('YW', $data['hits_time']) == date('YW', $_SGLOBAL['timestamp'])) ? ($data['hits_week'] + $num) : $num;
				$data['hits_month'] = (date('Ym', $data['hits_time']) == date('Ym', $_SGLOBAL['timestamp'])) ? ($data['hits_month'] + $num) : $num;
				$data['hits_time'] = $_SGLOBAL['timestamp'];
			}else{
			    $data['comments'] = $r[0]['comments']+$data['comments'];
				$data['comments_checked'] = $r[0]['comments_checked']+$data['comments_checked'];
			}
			if(!updatetable($this->table_count, $data,"contentid={$contentid}")) return false;
		}else{
		    if(!$data){
				$data['comments'] = $data['comments_checked'] = 0;
			}
		    $data['hits'] = $data['hits_day'] = $data['hits_week'] = $data['hits_month'] = $num;
			$data['contentid'] = $contentid;
			$data['hits_time'] = $_SGLOBAL['timestamp'];
			
		    if(!inserttable($this->table_count, $data)) return false;
		}
		return $data;
	}
	
	/**
	 * ��ȡһ��DIGG����
	 * 
	 * @access     public
	 * @return     array
	 */
	 function getDigg($contentid){
	     $contentid = intval($contentid);
		 $sql = 'select * from '.jieqi_dbprefix($this->table_digg)." WHERE `contentid`=$contentid";
		 if($r = selectsql($sql)) return $r[0];
		 else return false;
	 }
	 
	/**
	 * ����digg
	 * 
	 * @access     public
	 * @return     array
	 */
	 function digg($contentid, $flag = 1){ //$flag Ϊ1��ʾ֧��
	     global $_SGLOBAL, $_SN;
		 $contentid = intval($contentid);
		 $flag = $flag == 1 ? 1 : 0;
		 $where = $_SGLOBAL['supe_uid'] ? "`userid`={$_SGLOBAL['supe_uid']} AND `contentid`=$contentid" : "`ip`='".jieqi_userip()."' AND `contentid`=$contentid";
		 $sql = "SELECT count(*) as num FROM `".jieqi_dbprefix($this->table_digglog)."` WHERE $where";
		 if($ret = selectsql($sql)){
		    if($ret[0]['num']>0) return false;//����Ѿ�ͶƱ�򷵻�
		 }
		 
		 if($r = $this->getDigg($contentid)){ //����������Լ�
		     $data = $r;
			 if($flag){
			     $data['supports'] = $data['supports'] + 1;
				 $data['supports_day'] = (date('Ymd', $data['updatetime']) == date('Ymd', $_SGLOBAL['timestamp'])) ? ($data['supports_day'] + 1) : 1;
				 $data['supports_week'] = (date('YW', $data['updatetime']) == date('YW', $_SGLOBAL['timestamp'])) ? ($data['supports_week'] + 1) : 1;
				 $data['supports_month'] = (date('Ym', $data['updatetime']) == date('Ym', $_SGLOBAL['timestamp'])) ? ($data['supports_month'] + 1) : 1;
				 $data['updatetime'] = $_SGLOBAL['timestamp'];
			 }else{
			     $data['againsts'] = $data['againsts'] + 1;
				 $data['againsts_day'] = (date('Ymd', $data['updatetime']) == date('Ymd', $_SGLOBAL['timestamp'])) ? ($data['againsts_day'] + 1) : 1;
				 $data['againsts_week'] = (date('YW', $data['updatetime']) == date('YW', $_SGLOBAL['timestamp'])) ? ($data['againsts_week'] + 1) : 1;
				 $data['againsts_month'] = (date('Ym', $data['updatetime']) == date('Ym', $_SGLOBAL['timestamp'])) ? ($data['againsts_month'] + 1) : 1;
				 $data['updatetime'] = $_SGLOBAL['timestamp'];
			 }
			 if(!updatetable($this->table_digg, $data,"contentid={$contentid}")) return false;
		 }else{
		     if($flag){
			     $data = array('contentid'=>$contentid,'supports'=>1,'supports_day'=>1,'supports_week'=>1,'supports_month'=>1,'againsts'=>0,'againsts_day'=>0,'againsts_week'=>0,'againsts_month'=>0,'updatetime'=>$_SGLOBAL['timestamp']);
			 }else{
			     $data = array('contentid'=>$contentid,'againsts'=>1,'againsts_day'=>1,'againsts_week'=>1,'againsts_month'=>1,'supports'=>0,'supports_day'=>0,'supports_week'=>0,'supports_month'=>0,'updatetime'=>$_SGLOBAL['timestamp']);
			 }
			 if(!inserttable($this->table_digg, $data)) return false;
		 }
		 $log = array('contentid'=>$contentid, 'flag'=>$flag, 'userid'=>$_SGLOBAL['supe_uid'], 'username'=>$_SN[$_SGLOBAL['supe_uid']], 'ip'=>jieqi_userip(), 'time'=>$_SGLOBAL['timestamp']);
		 inserttable($this->table_digglog, $log);
		 return array_merge($data, $log);
	 }

	
	/**
	 * ��ȡһ��mood����
	 * 
	 * @access     public
	 * @return     array
	 */
	 function getMood($moodid, $contentid){
	     $moodid = intval($moodid);
	     $contentid = intval($contentid);
		 $sql = 'select * from '.jieqi_dbprefix($this->table_mood)." WHERE `moodid`=$moodid AND `contentid`=$contentid";
		 if($r = selectsql($sql)) return $r[0];
		 else return false;
	 }
	 
	/**
	 * ����mood
	 * 
	 * @access     public
	 * @return     array
	 */
	 function mood($moodid, $contentid, $vote_id){ 
	     global $_SGLOBAL;
		 
		 //�������ò���/�ж������Ƿ����
		 $mood = new GlobalData('mood', 'moodid');
		 if(!($fields = $mood->get($moodid))) return false;
		 //������Χ
		 if($vote_id<1 || $vote_id>$fields['number']) return false;
		 
		 $field = 'n'.$vote_id;
	 	 if($r = $this->getMood($moodid, $contentid)){ //����������Լ�
		     $data = $r;
			  $data[$field] = $data[$field] + 1;
			  $data['total'] = $data['total'] + 1;
			  $data['updatetime'] = $_SGLOBAL['timestamp'];
			  //����ƽ����
			  if($fields['isavg']){
			      $data['scores'] = $data['scores'] + $vote_id;
				  $data['avg'] = number_format($data['scores']/$data['total'],1);//sprintf("%.1f",$data['scores']/$data['total']);
			  }
			  if(!updatetable($this->table_mood, $data," `moodid`=$moodid AND contentid={$contentid}")) return false;
		 }else{
		      $data['moodid'] = $moodid;
			  $data['contentid'] = $contentid;
		      $data[$field] = 1;
			  $data['total'] = 1;
			  //����ƽ����
			  if($fields['isavg']){
			      $data['scores'] = $vote_id;
				  $data['avg'] = number_format($data['scores'],1);//sprintf("%.1f",$data['scores']);
			  }
			  $data['updatetime'] = $_SGLOBAL['timestamp'];
			  if(!inserttable($this->table_mood, $data)) return false;
		 }
		 return $data;
	 }
	/**
	 * ��ѯ��¼�б�
	 * 
	 * @access     public
	 * @return     array
	 */
	 function lists($pagenum = 0, $page = 0, $custompage = '', $emptyonepage = false){
	    global $_SCONFIG;
		if($pagenum){
			$this->criteria->setLimit($pagenum);
			if(!$page) $page=1;
			$this->criteria->setStart(($page-1) * $pagenum);
		}
		$this->handler->queryObjects($this->criteria);
		$rows = array();
		$k=0;
		while($v = $this->handler->getObject()){
			$rows[$k] = $this->get_news_vars($v, true);
			$k++;
		}
		if($page){
			 $this->setVar('totalcount', $this->handler->getCount($this->criteria));
			 if(!$custompage){
				 //����ҳ����ת
				 include_once(_ROOT_.'/lib/html/page.php');
				 $this->jumppage = new JieqiPage($this->getVar('totalcount'),$pagenum,$page);
			 }else{
			     $this->jumppage = new GlobalPage($custompage,$this->getVar('totalcount'),$pagenum,$page);
				 $this->jumppage->emptyonepage = $emptyonepage;
				 if($custompage) $this->setVar('custompage', $custompage);
			 }
		}else{
			 $this->setVar('totalcount', count($rows));
		}
		return $rows;
	 }
    
	function getData($param, $reterror = false, $emptyonepage = false){
	    global $_SGLOBAL, $_SCONFIG, $_OBJ, $_PAGE;
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
		if($param['tag']){
			$param['tag'] = urldecode($param['tag']);
			$keywords = explode(' ',$param['tag']);
		}
		if($param['catid']){
		    $param['catids'] = explode('|',$param['catid']);
			if(!($_SGLOBAL['cate'] = $cate = $_OBJ['category']->get($param['catids'][0], true))){
			    if(!$reterror) jieqi_printfail(lang_replace('category_not_exists'));
				else return false;
			}
			//$param['catids'] = array($param['catid']);
			$param['mid'] = $_SGLOBAL['cate']['modelid'];
		}else{
			if($param['mid']){
				$param['model'] = $_OBJ['model']->get($param['mid']);
				$param['m'] = $_PAGE['model']['tablename'];
			}elseif($param['m']){
				foreach($_OBJ['model']->data as $v){
					if(array_search($param['m'],$v)){
					   $param['mid'] = $v['modelid'];
					   break;
					}
				}
				if(!$param['mid']){
				    if(!$reterror) jieqi_printfail(LANG_ERROR_PARAMETER);
					else return false;
				}
			}
			foreach($_SGLOBAL['category'] as $k=>$v){
				if($v['modelid']==$param['mid'] && $_OBJ['category']->islist($v['catid'])) $param['catids'][] = $v['catid'];
			}
			$cate = $_OBJ['category']->get($param['catids'][0], true);
		}
		
		//�����ѯ��
		$tables = array();
		if($_SCONFIG['showarticlelists'] & 1 && $param['catids']) $tables[$this->tablepre.'c_'.$_SGLOBAL['model'][$cate['modelid']]['tablename']] = '*';  //���¸��ӱ����
		if($_SCONFIG['showarticlelists'] & 2) $tables[$this->table_count] = 'hits,hits_day,hits_week,hits_month,hits_time,comments,comments_checked'; //����ͳ�Ʊ����
		if($_SCONFIG['showarticlelists'] & 4) $tables[$this->table_digg] = 'supports,againsts,supports_day,againsts_day,supports_week,againsts_week,supports_month,againsts_month';
		$tag = $tables ? 'tables' : NULL;
		$tabletag = ($tag ?'news_content.' :'');
		unset($this->handler);
		unset($this->criteria);
		$this->setHandler($tag);
		if(!$param['order']){
		   $order = "{$tabletag}inputtime";
		   $param['order'] = 'inputtime';
		}else $order = $param['order'];
					
		if($tables){
			$tablestr = $fields = '';
			foreach($tables as $table=>$field){
				$tablestr.= " LEFT JOIN ".jieqi_dbprefix($table)." AS {$table} ON {$tabletag}contentid={$table}.contentid ";
				$fields.= ",{$table}.{$field}";
			}
			$this->criteria->setFields("{$tabletag}*{$fields}");
			$this->criteria->setTables(jieqi_dbprefix('news_content')." AS news_content {$tablestr}");
		}
		
		if($param['catids']){
			if(count($param['catids'])>1){
				$catids = implode(',',$param['catids']);
				$this->criteria->add(new Criteria('catid', "($catids)", 'in'));
			}elseif(count($param['catids'])==1){
				if($_SGLOBAL['cate']['child']){
					$catids = $_SGLOBAL['cate']['arrchildid'];
					$this->criteria->add(new Criteria('catid', "($catids)", 'in'));
				} else $this->criteria->add(new Criteria('catid', $param['catids'][0]));
			}
		}
		
		if($keywords){
			if(count($keywords)>1){
				foreach($keywords as $k=>$v){
					$left = !$k ? '(' : '';
					$this->criteria->add(new Criteria($left.'keywords', '%'.$v.'%', 'like'), 'AND');
				}
			}elseif(count($keywords)==1){
				$this->criteria->add(new Criteria('keywords', '%'.$keywords[0].'%', 'like'));
			}
		}
		if($param['title']) $this->criteria->add(new Criteria('title', '%'.$param['title'].'%', 'like'), $keywords ? 'OR' :'AND');
		$this->criteria->add(new Criteria('status', 99), count($keywords)>1 ? ') AND' : 'AND');
		$this->criteria->setSort($order);
		$this->criteria->setOrder('DESC');
		$pagesize = $param['pagesize'] ? $param['pagesize'] : ($_SCONFIG['pagenum'] ?$_SCONFIG['pagenum'] :30);
		$_PAGE['articlerows'] = $this->lists($pagesize, $param['page'], $param['pagestr'], $emptyonepage);
		return $_PAGE;
	}
	
	/**
	 * ��ȡ��ҳ����
	 * 
	 * @access     public
	 * @return     string|array
	 */
	function getContent($contentid, $page = 1){
	    global $_SGLOBAL, $_SCONFIG, $_PAGE, $_OBJ;
		//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		//��ȡ����
		if(!is_array($_PAGE['data'] = $this->get($contentid))) return false;
		//��ȡ��Ŀ����
		$_SGLOBAL['cate'] = $_OBJ['category']->get($_PAGE['data']['catid']);
		//���ر�������
		include_once($_SGLOBAL['news']['path'].'/include/fields/formelements.class.php');
		//���ر����ݶ�����
		$elements = new FormElements($_SGLOBAL['cate']['modelid'], $_PAGE['data']['catid']);
		if(!$_PAGE['data'] = $elements->show($_PAGE['data'])) return false;
		$_PAGE['data']['___content'] = $elements->getVar('___content');
		$_PAGE['data']['__content'] = $_PAGE['data']['___content']['content'][$page-1];
		return $_PAGE['data'];
	} 
	
	/**
	 * �����ҳ����
	 * 
	 * @access     public
	 * @return     string|array
	 */
	function fetch($contentid, $page = 1, $createhtml = false){
		global $_SGLOBAL, $_SCONFIG, $_SN, $_TPL, $jieqiTset, $jieqiTpl, $_PAGE, $_OBJ;
		//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		//����ģ��
		if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
		//���ر�������
		///include_once($_SGLOBAL['news']['path'].'/include/fields/formelements.class.php');
		//��ȡ����
		///if(!is_array($_PAGE['data'] = $this->get($contentid))) return false;
		if(!is_array($_PAGE['data'] = $this->getContent($contentid,$page ))) return false;
		//��ȡ��Ŀ����
		///$_SGLOBAL['cate'] = $_OBJ['category']->get($_PAGE['data']['catid']);
		
		//���ر����ݶ�����
		///$elements = new FormElements($_SGLOBAL['cate']['modelid'], $_PAGE['data']['catid']);
		///if(!$_PAGE['data'] = $elements->show($_PAGE['data'])) return false;
		
		///$_PAGE['data']['___content'] = $elements->getVar('___content');
		$_PAGE['pagetatol'] = count($_PAGE['data']['___content']['content']);
		if($page>$_PAGE['pagetatol']) return false; //��ǰҳ�������ҳ��
		
		//��������ɾ�̬
		if($createhtml){
			$ret = array();
			foreach($_PAGE['data']['___content']['content'] as $page=>$value){
				$page++;//ҳ���1��ʼ
				$_PAGE['data']['__content'] = $value;
				
				if($_PAGE['pagetatol']>1){
					$jumppage = new GlobalPage($_SCONFIG['articlepages'],$_PAGE['pagetatol'],1,$page);
					$linkurl = '';
					if(!$this->showType($_PAGE['data']['catid'])){
						$linkurl = $this->getUrl($_PAGE['data'], 1, false);
						$urlrule = $this->getUrlrule($_PAGE['data'], 1, false);
						if(!substr_count($urlrule, '/')){
							$jumppage->emptyonepage = $contentid.'.'.fileext($linkurl);
						}else $jumppage->emptyonepage = '';
					}
					$_PAGE['url_jumppage'] = $jumppage->getPage($linkurl);
				}
				template($_PAGE['data']['_showtemplate']);
				$jieqiTpl->assign('jieqi_contents', $jieqiTpl->fetch($jieqiTset['jieqi_contents_template']));
				if(!is_file($jieqiTset['jieqi_page_template']) && strpos($jieqiTset['jieqi_page_template'], '/') == 0) $jieqiTset['jieqi_page_template']=_ROOT_.$jieqiTset['jieqi_page_template'];
				$ret[$page] = $jieqiTpl->fetch($jieqiTset['jieqi_page_template']);
				unset($jieqiTset['jieqi_contents_template']);
				unset($jumppage);
				unset($_PAGE['url_jumppage']);
			}
		}else{
			$ret = '';
			$_PAGE['data']['__content'] = $_PAGE['data']['___content']['content'][$page-1];
			
			if($_PAGE['pagetatol']>1){
				$jumppage = new GlobalPage($_SCONFIG['articlepages'],$_PAGE['pagetatol'],1,$page);
				$linkurl = '';
				if($this->showType($_PAGE['data'])){
					$linkurl = $this->getUrl($_PAGE['data'], 1, false);
					$urlrule = $this->getUrlrule($_PAGE['data'], 1, false);
					if(!substr_count($urlrule, '/')){
						$jumppage->emptyonepage = $contentid.'.'.fileext($linkurl);
					}else $jumppage->emptyonepage = '';
				}
				$_PAGE['url_jumppage'] = $jumppage->getPage($linkurl);
			}
			$_PAGE['ac'] = 'show';
			template($_PAGE['data']['_showtemplate']);global $jieqiTset;
			$jieqiTpl->assign('jieqi_contents', $jieqiTpl->fetch($jieqiTset['jieqi_contents_template']));
			if(!is_file($jieqiTset['jieqi_page_template']) && strpos($jieqiTset['jieqi_page_template'], '/') == 0) $jieqiTset['jieqi_page_template']=_ROOT_.$jieqiTset['jieqi_page_template'];
			$ret = $jieqiTpl->fetch($jieqiTset['jieqi_page_template']);
		}
		jieqi_freeresource();
		return $ret;
	}
	
	/**
	 * ��ȡ��ҳ
	 * 
	 * @access     public
	 * @return     string
	 */
/*	 function getPage($setlink = ''){
		 if($setlink) $this->jumppage->setlink($setlink, false, true);
		 return $this->jumppage->whole_bar();
	 }*/
}
?>