<?php
/*
    *���²ɼ���
	[Cms News] (C) 2009-2012 Cms Inc.
	$Id: collect.class.php 12398 2010-08-02 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

class Collect extends GlobalData{

	/**
	 * ���캯��
	 * 
	 * @param      void       
	 * @access     private
	 * @return     void
	 */
	function Collect($collect = array()){
         if(!$collect){
			 $this->GlobalData('collect', 'collectid','listorder');
		 }else {
		     $this->data = $collect;
		 }
	}

	/**
	 * ���һ�������Ƿ����
	 * 
	 * @access     public
	 * @return     bool
	 */
	function checkdata($collectid, $isreture = false){
	    //�ж������Ƿ����
	    $cachefile = _ROOT_.'/configs/'.$this->module."/data_collect_{$collectid}_field.php";
		if(!is_file($cachefile)) {
		    if(!$this->cacheOne($collectid)){
			    if(!$isreture)  jieqi_printfail(lang_replace('data_not_exists'));
				return false;
			}
		}
	}
	
	/**
	 * ��ȡһ����ǩ
	 * 
	 * @access     public
	 * @return     array
	 */
	function get($collectid, $isreture = false){
	    global $_SGLOBAL,$collectSetting,$collectTask;//�����ظ�����;
	    $cachefile = _ROOT_.'/configs/'.$this->module."/data_collect_{$collectid}_field.php";
		if(!is_file($cachefile)) {
		    if(!$this->cacheOne($collectid)){
			    if(!$isreture)  jieqi_printfail(lang_replace('data_not_exists'));
				return false;
			}
		}
		include_once($cachefile);
		$data = $_SGLOBAL['collect_'.$collectid.'_field'][$collectid];
		if($data['setting'] && !$collectSetting[$collectid]){
			eval('$collectSetting['.$collectid.'] = '.$data['setting'].';');
			$data['setting'] = $collectSetting[$collectid];
		}else{
		    $data['setting'] = $collectSetting[$collectid];
		}
		if($data['task'] && !$collectTask[$collectid]){
			eval('$collectTask['.$collectid.'] = '.$data['task'].';');
			$data['task'] = $collectTask[$collectid];
		}else{
		    $data['task'] = $collectTask[$collectid];
		}
		return $data;
	}

	/**
	 * ��ȡһ����ǩ
	 * 
	 * @access     public
	 * @return     array
	 */
	function getOne($collectid, $isreture = false){
	    //�ж���Ŀ�Ƿ����
	    global $collectSetting,$collectTask;//�����ظ�����
		
		//�����ݿ��ȡ
		$where = " where collectid = ".$collectid;
		$data = selectsql('select * from '.jieqi_dbprefix("{$this->table}")." {$where}");
		if(!$data){
			if(!$isreture) jieqi_printfail(lang_replace('data_not_exists'));
			else return false;
		}
		$data = $data[0];
		if($data['setting'] && !$collectSetting[$collectid]){
			eval('$collectSetting['.$collectid.'] = '.$data['setting'].';');
			$data['setting'] = $collectSetting[$collectid];
		}else{
		    $data['setting'] = $collectSetting[$collectid];
		}
		if($data['task'] && !$collectTask[$collectid]){
			eval('$collectTask['.$collectid.'] = '.$data['task'].';');
			$data['task'] = $collectTask[$collectid];
		}else{
		    $data['task'] = $collectTask[$collectid];
		}
        //������Ŀ����
		return $data;
	}	
		
	/**
	 * ɾ��һ������
	 * 
	 * @access     public
	 * @return     bool
	 */
	function delete($collectid, $cache = true){
	    //�ж�ģ���Ƿ����
		$this->checkdata($collectid);
		if(deletesql($this->table, array("{$this->idfield}"=>"{$collectid}"))){
		    jieqi_delfile(_ROOT_.'/configs/'.$this->module."/data_collect_{$collectid}_field.php");
		    $this->cache();
			return true;
		}else{
		    return false;
		}
	}
	
	 	
	/**
	 * ��������
	 * 
	 * @access     public
	 * @return     bool
	 */	
	function order($order){
	      if(!is_array($order)) return false;
		  foreach($order as $id=>$value){
		      $value = intval($value);
			  updatetable($this->table, array('listorder'=>$value), "{$this->idfield}={$id}");
		  }
		  $this->cache();//���»���
		  return true;
	}
	
	/**
	 * �б�һ������
	 * 
	 * @access     public
	 * @return     empty
	 */
	 function cacheOne($collectid){
	     if($data  = selectsql('select * from '.jieqi_dbprefix($this->table)." WHERE collectid={$collectid}")){
		     $file = _ROOT_.'/configs/'.$this->module."/data_collect_{$collectid}_field.php";
			 cache_write("collect_{$collectid}_field", "_SGLOBAL['collect_{$collectid}_field']", $data, $this->idfield, $file);
			 return true;
		 }else return false;
	 }
	 	
	/**
	 * �Ƽ��б���»���
	 * 
	 * @access     public
	 * @return     empty
	 */
	function cache(){
		global $_SGLOBAL;
		$table = str_replace($this->tablepre, '', $this->table);
		$_SGLOBAL[$table] = array();
		//�����ݿ��ȡ
		if($this->order) $where = " order by ".$this->order." ASC";
		$data = selectsql('select collectid,modelid,sitename,siteurl,description,inputtime,updatetime,disabled,listorder from '.jieqi_dbprefix("{$this->table}")." {$where}");
		cache_write($table, "_SGLOBAL['".$table."']", $data, $this->idfield, $this->cachefile);
		include($this->cachefile);
	}
}

class CollectPage extends JieqiObject{
    
	var $collect = array();   //��ַ�ɼ�����
	var $urlpram = array();   //�����URL����
	var $task = array();      //�ɼ�����
	var $index = '';         //�ɼ���������
	var $source;              //Զ��ҳ������
	/**
	 * ���캯��
	 * 
	 * @param      taskcollect   
	 * @param      filedcollect     
	 * @access     private
	 * @return     void
	 */
	function CollectPage($collect, $index=''){
        global $_SGLOBAL;
		include_once(_ROOT_.'/lib/text/textfunction.php');
		include_once($_SGLOBAL['news']['path'].'/include/collectfunction.php');
		$this->collect = $collect;
		//�������
		$colary=array(
					'repeat'=>$collect['setting']['senior']['threadrequest'],
					'referer'=>$collect['setting']['senior']['referer'],
					'wget'=>$collect['setting']['senior']['wget'], 
					'proxy_host'=>$collect['setting']['senior']['proxy_host'], 
					'proxy_port'=>$collect['setting']['senior']['proxy_port'], 
					'proxy_user'=>$collect['setting']['senior']['proxy_user'], 
					'proxy_pass'=>$collect['setting']['senior']['proxy_pass']
				);
		if(!empty($collect['setting']['senior']['pagecharset'])) $colary['charset']=$collect['setting']['senior']['pagecharset'];
		$this->urlpram = $colary;
		$this->index = $index;
		$this->setTask($index);
		if($index=='') $this->fields = $this->collect['setting']['fields'];
		else{
			if($this->task['fields']) $this->fields = $this->task['fields'];
			else $this->fields = $this->collect['setting']['fields'];
		}		
	}
	
	/**
	 * ��ȡURL����
	 * 
	 * @param      url   
	 * @access     public
	 * @return     str
	 */
	 function getSource($url, $isreturn = false){
	     if(!$url) return false;
		 $this->source = jieqi_urlcontents($url,$this->urlpram);
		 if(empty($this->source)){
		    if($isreturn) return false;
			else jieqi_printfail(lang_replace('collect_url_failure',array($url,$url)));
		 }
		 return $this->source;
	 }
	 
	/**
	 * ���ɼ�����ת���ɿ�ִ�е�����
	 * 
	 * @param      str   
	 * @access     public
	 * @return     str
	 */
	 function collectstoe($str){
	     if(!$str) return false;
		 return jieqi_collectstoe(jieqi_collectptos($str));
	 }
	 
	/**
	 * ƥ��һ�����
	 * 
	 * @param      str   
	 * @access     public
	 * @return     array
	 */
	 function cmatchone($pregstr, $source){
	     return jieqi_cmatchone($pregstr, $source);
	 }
	 
	/**
	 * ƥ�������
	 * 
	 * @param      str   
	 * @access     public
	 * @return     array
	 */
	 function cmatchall($pregstr, $source){
	     return jieqi_cmatchall($pregstr, $source);
	 }
	 
	/**
	 * ��������
	 * 
	 * @param      string   
	 * @access     public
	 * @return     string
	 */
	 function filtercontent($content, $filter){
	     if(!$filter) return $content;
		 $filterary=explode("\n", $filter);
		 $repfrom = $repto = array();   //��Ų���/�滻���������
		 foreach($filterary as $filterstr){
		     $filterstr=trim($filterstr);
			 if(!empty($filterstr)){
			     $filters = explode('|', $filterstr);
			     if(preg_match('/^\/[^\/\\\\]*(?:\\\\.[^\/\\\\]*)*\/[imsu]*$/is', $filters[0])) $repfrom[]=$filters[0];
				 else $repfrom[] = '/'.jieqi_pregconvert($filters[0]).'/is';
				 $repto[] = str_replace("\r\n","\n",str_replace("\s"," ",$filters[1]));
			 }
		 }
		 if(count($repfrom) > 0) $content = preg_replace($repfrom, $repto, $content);
		 return $content;
	 }
	  
	/**
	 * ���òɼ�����
	 * 
	 * @param      int   
	 * @access     public
	 * @return     array
	 */
	 function setTask($index){
	     if(!isset($index)) return false;
		 if(!array_key_exists($index, $this->collect['task'])) jieqi_printfail(LANG_ERROR_PARAMETER); 
		 $this->task = $this->collect['task'][$index];
	 }
	 
	/**
	 * ��ȡ����ɼ����µ�URL�б�
	 * 
	 * @param      int   
	 * @access     public
	 * @return     array
	 */
	 function getArticleUrls($urls = '', $isreturn = true){
	     //if(!isset($index) || !$urls) return false;
		 if(!$urls) return false;
		 //$this->setTask($index);
		 //if(strpos($startpageid, 'http://')) $this->task['urlpage'] = $startpageid;
		 //else $this->task['urlpage'] = str_replace('<{pageid}>', $startpageid, $this->task['urlpage']);
		 $this->task['urlpage'] = $urls;
		 if(!($source = $this->getSource($this->task['urlpage'], $isreturn))) return false;
		 //�ж������±�Ż�������URL
		 $urls = array();
		 if(strpos($this->task['urlarticle'], '<{articleid}>')){
		     $pregstr = $this->collectstoe($this->task['articleid']);
			 $matchvar = $this->cmatchall($pregstr, $source);
			 if(empty($matchvar)) return false;
			 foreach($matchvar as $k=>$key){
			     if($key=='') continue;
			     $urls[$key] = str_replace('<{articleid}>', $key, $this->task['urlarticle']);
			 }
		 }elseif(strpos($this->task['urlarticle'], '<{articleurl}>')){
		     $pregstr = $this->collectstoe($this->task['articleurl']);
			 $matchvar = $this->cmatchall($pregstr, $source);
			 if(empty($matchvar)) return false;
			 foreach($matchvar as $k=>$key){
			     if($key=='') continue;
			     $urls[$key] = str_replace('<{articleurl}>', $key, $this->task['urlarticle']);
			 }
		 }else return false;
		 return $urls;
	 }
	 
	/**
	 * ��ȡ�ֶ��б�
	 * 
	 * @param      str   
	 * @access     public
	 * @return     array
	 */
	 function getFields($url, $fields = ''){
	      if(!$fields){
/*			  if($index=='') $fields = $this->collect['setting']['fields'];
			  else{
				  $this->setTask($index);
				  if($this->task['fields']) $fields = $this->task['fields'];
				  else $fields = $this->collect['setting']['fields'];
			  }*/
			  $fields = $this->fields;
			  if(!$fields) return false;
		  }
		  if(!($source = $this->getSource($url, true))) return false;
		  $temp = array();
		  foreach($fields as $field => $v){
		      if(!$v['adopt']) continue;
			  $pregstr = $this->collectstoe($v['adopt']);
			  $matchvar = $this->cmatchone($pregstr, $source);
			  if(empty($matchvar)) continue;
			  if($v['filter']){ //����������滻����
			      //$filterstr = $this->collectstoe($v['filter']);
				  $matchvar = $this->filtercontent($matchvar, $v['filter']);
			  }
			  //�����е�ͼƬ���·���ĳɾ���·��
			  $temp[$field] = relative_to_absolute($matchvar, $url);
			  if($v['nextpage']){//����趨����һҳ�ɼ�
			      $nfields[$field] = $fields[$field];
			      //$nfields[$field]['filter'] = $v['nextpage'];
				  $nextpage = relative_to_absolute($this->cmatchone($this->collectstoe($v['nextpage']), $source), $url, true);
				  if($nextpage && $nextpage!=$url){
				      $t = $this->getFields($nextpage, $index, $nfields);
					  if($t[$field]){
						  $temp[$field] = $temp[$field]."[page]\n".$t[$field];
					  }
				  }
			  }
			  //�����ͼƬ��ͼ
/*			  if($field=='pictureurls'){
				  preg_match_all("/((https?|ftp|http):\/\/)([^\s\r\n\t\f<>]+(\.gif|\.jpg|\.jpeg|\.png|\.bmp))/i", $temp[$field], $matches);
				  $temp[$field] = $matches[0];
				  //print_r($matches[0]);exit;
			  }*/
			  
		  }
		  return $temp;
	 }
}
?>