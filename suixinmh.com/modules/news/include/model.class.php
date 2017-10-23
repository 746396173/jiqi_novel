<?php
/*
    *ģ�ʹ�����[ģ�͵����ݲ���]
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: category.class.php 12398 2010-05-20 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

class Model extends GlobalData{
	var $table = 'model';
	var $table_field = 'model_field';
	var $redis;
	/**
	 * ���캯��
	 * 
	 * @param      void       
	 * @access     private
	 * @return     void
	 */
    function Model($model = array())
    {
        //global $_SGLOBAL;
        if (!$model) {
            $this->GlobalData('model', 'modelid');
            $this->model_field_cache($this->table_field);
        } else {
            $this->data = $model;
        }
        include_once(JIEQI_ROOT_PATH . '/lib/database/redis.php');
        $this->redis = new MyRedis(JIEQI_REDIS_HOST, JIEQI_REDIS_PORT);
    }
	
	/**
	 * ���һ��ģ���Ƿ����
	 * 
	 * @access     public
	 * @return     bool
	 */
	function checkdata($id, $isreture = false){
	    //�ж������Ƿ����
	    if(!array_key_exists($id, $this->data)){
			if(!$isreture) jieqi_printfail(lang_replace('model_not_exists'));
			else return false;
		}else{
			return true;
		}
	}
	
	/**
	 * ����һ��ģ��
	 * 
	 * @access     public
	 * @return     array
	 */	
	 function addModel($data){
	     if(!is_array($data)) return false;
		 if($modelid = $this->add($data)){//���� 
			 include_once($GLOBALS['jieqiModules']['news']['path']."/include/function_db.php");
			 $search = array('$tablename', '$table_model_field', '$modelid');
			 $replace = array(jieqi_dbprefix('news_c_'.$data['tablename']), jieqi_dbprefix('news_model_field'), $modelid);
			 $sql = file_get_contents($GLOBALS['jieqiModules']['news']['path'].'/include/fields/model.sql');
			 $sql = str_replace($search, $replace, $sql);
			 sql_execute($sql);
			 return $modelid;
		 }else return false;
	 }
	 	
	/**
	 * ɾ��һ��ģ��
	 * 
	 * @access     public
	 * @return     array
	 */	
	 function deleteModel($modelid){
	      global $_SGLOBAL, $_OBJ;

	      if($this->delete($modelid, false)){//ɾ�����ݿ�ģ������
		      $tablename = jieqi_dbprefix($this->tablepre.'c_'.$this->data[$modelid]['tablename']);
			  //�趨������ɾ��ģ���ֶ�
			  $this->table = $this->tablepre.$this->table_field;
			  $this->idfield = 'modelid';
			  $this->delete($modelid, false);
			  if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
			  foreach($_SGLOBAL['category'] as $catid=>$value){
				  if($value['modelid'] != $modelid) continue;
				  $_OBJ['category']->delete($catid, false, true);
			  }
			  $_SGLOBAL['db']->db->query("DROP TABLE IF EXISTS `".$tablename."`");
			  $_OBJ['category']->cache();
			  //�趨����������ģ�ͻ����б��ļ�
			  $this->table = $this->tablepre.'model';
			  $this->idfield = 'modelid';
			  $this->cache();
			  $this->cacheModel($modelid);//ɾ��ģ�ͻ����ļ�
			  return true;
		  }else return false;
	 }
	
	/**
	 * �ֶ���������
	 * 
	 * @access     public
	 * @return     bool
	 */	
	function order($modelid, $order){
	      if(!is_array($order) || !$modelid) return false;
		  foreach($order as $fieldid=>$value){
		      $value = intval($value);
			  updatetable($this->tablepre.$this->table_field, array('listorder'=>$value), " modelid={$modelid} and fieldid={$fieldid}");
		  }
		  $this->cacheModel($modelid);//���»���
		  return true;
	}
		 	
	/**
	 * ����һ���ֶ�
	 * 
	 * @access     public
	 * @return     array
	 */	
	 function addField($modelid, $data){
	     //�ж�ģ���Ƿ����
		 $this->checkdata($modelid);
		 if(!$data) return false;
		 //�趨��
		 $this->table = $this->tablepre.$this->table_field;
		 $this->idfield = 'fieldid';
		 $data['modelid'] = $modelid;
		 if($fieldid = $this->add($data, false)){
			 $data['issystem'] = 0;
			 if($this->activeField($data, 'add')){
				 $this->cacheModel($modelid);
				 return $fieldid;
			 } else {
			     $this->delete($fieldid, false);
				 return false;
			 }
		 } else return false;
	 }
	 	
	/**
	 * ɾ��һ���ֶ�
	 * 
	 * @access     public
	 * @return     array
	 */	
	 function deleteField($modelid, $fieldid){
	     global $_SGLOBAL;
		 //�ֶδ���
		 if($fields = $this->getfieldid($modelid, $fieldid)){
			 if($fields['issystem'] || $fields['iscore']) return false; //ϵͳ|�����ֶβ�����ɾ��
			 //�趨��
			 $this->table = $this->tablepre.$this->table_field;
			 $this->idfield = 'fieldid';
			 if($this->delete($fieldid, false)){
				 if($this->activeField($fields, 'delete')){
					 $this->cacheModel($modelid);
					 return true;
				 } else return false;
			 } else return false;
		 } else return false;
	 }
	 	 	
	/**
	 * �޸�һ���ֶ�
	 * 
	 * @access     public
	 * @return     array
	 */	
	 function editField($modelid, $fieldid, $data){
	     //�ж�ģ���Ƿ����
		 $this->checkdata($modelid);
		 if(!$fieldid || !$data) return false;
		 //�ֶδ���
		 if($fields = $this->getfieldid($modelid, $fieldid)){
		     if($fields['iscore']) jieqi_printfail(lang_replace('scorefield_not_edit')); //�����ֶβ�����ɾ��
			 $data['modelid'] = $modelid;
			 $data['issystem'] = $fields['issystem'];
			 if($this->activeField($data, 'edit')){
				 //�趨��
				 $this->table = $this->tablepre.$this->table_field;
				 $this->idfield = 'fieldid';
				 if($this->edit($fieldid, $data, false)){
					 $this->cacheModel($modelid);
					 return true;
				 } else return false;
			 } else return false;
		 } else return false;
	 }
	
	//�޸��ֶ�ʱ����
	function activeField($data = array(), $active = 'edit'){
	     global $_SGLOBAL;
		 if(!$data) return false;
		 if($data['setting']!='' && $active!='delete'){
			eval('$setting['.$data['field'].'] = '.stripcslashes($data['setting']).';');
			$data['setting'] = $setting[$data['field']];
		 }
	     extract($data);
		 if($issystem) $tablename = jieqi_dbprefix($this->tablepre.'content');
		 else $tablename = jieqi_dbprefix($this->tablepre.'c_'.$this->data[$modelid]['tablename']);
		 dbconnect();
		 $file = $GLOBALS['jieqiModules']['news']['path'].'/include/fields/form/'.$formtype.".{$active}.php";
		 if(is_file($file)) include_once($file);
		 else include_once($GLOBALS['jieqiModules']['news']['path']."/include/fields/form/text.{$active}.php");
		 return true;
	}	
		 	
	/**
	 * ��ȡģ���ֶμ���
	 * 
	 * @access     public
	 * @return     array
	 */	
	function getfields($modelid)
	{
	    global $_SGLOBAL;
		//�ж�ģ���Ƿ����
		$this->checkdata($modelid);
		//����ģ���ֶ��б�
		include_once(_ROOT_."/configs/{$this->module}/data_model_{$modelid}_field.php");
		//get_cache_data("model_".$modelid."_field");
		return $_SGLOBAL['model_'.$modelid.'_field'];
	}
	 	
	/**
	 * �����ֶ�ID��ȡģ���ֶ�
	 * 
	 * @access     public
	 * @return     array
	 */	
	 function getfieldid($modelid, $fieldid){
	     global $_SGLOBAL;
		 if($fieldrows = $this->getfields($modelid)){
		     if($fieldid){
			     foreach($fieldrows as $k=>$v){
					if($v['fieldid']==$fieldid) $field = $fieldrows[$k];
				 }
				 if(is_array($field)) return $field;
				 else return false;
			 }return false;
		 }return false;
		 
	 }
	 	
	/**
	 * ����ֶθ�ʽ
	 * 
	 * @access     public
	 * @return     bool
	 */	
	function check($field)
	{
	    if(!$field) return false;
		return preg_match("/^[a-z][0-9a-z_]*[0-9a-z]?$/i", $field);
	}
	
	/**
	 * ����ֶ��Ƿ����
	 * 
	 * @access     public
	 * @return     bool
	 */	
	function exists($modelid, $field)
	{
	    if(!($fields = $this->getfields($modelid, true))) return true;
		if(!$field || array_key_exists($field, $fields)) return true;
	}

	/**
	 * �Ƿ�����ȫ������
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function isSearch($modelid){
	     if(!is_array($GLOBALS['jieqiModules']['search'])) return false;
		 if(!($model = $this->get($modelid, true))) return false;
		 return $model['enablesearch'];
	 }

	/**
	 * ǰ̨������Ϣ�Ƿ���Ҫ���
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function isCheck($modelid){
		 if(!($model = $this->get($modelid, true))) return false;
		 return $model['ischeck'];
	 }	

	/**
	 * ��ȡĳ��ģ���µ���Ŀ���
	 * 
	 * @access     public
	 * @return     array
	 */ 
	function getMCatids($modelid){
	     global $_OBJ;
		 if(!is_object($_OBJ['category'])) $_OBJ['category'] = &new Category();
		 $catearr = $_OBJ['category']->data;
		 $retarr = array();
		 foreach($catearr as $k=>$v){
		     if($v['modelid'] == $modelid){
			     $retarr[] = $v['catid'];
			 }
		 }
		 return $retarr;
	}
	  	
	/**
	 * ��������ʽ
	 * 
	 * @access     public
	 * @return     bool
	 */	
	function checkTable($tablename)
	{
	    if(!$tablename) return false;
		return preg_match("/^[a-z][0-9a-z]*[0-9a-z]?$/i", $tablename);
	}
	
	/**
	 * �������Ƿ����
	 * 
	 * @access     public
	 * @return     bool
	 */	
	function tableExists($tablename)
	{
	    foreach($this->data as $k=>$v){
		    if($v['tablename']==trim($tablename)) return true;
		}
		return false;
	}
			
	/**
	 * ���»���
	 * 
	 * @access     public
	 * @return     empty
	 */
	function cache(){
		global $_SGLOBAL;
	    parent::cache();//ǿ�Ƹ���ģ�ͻ���
	}

	//����ģ���ֶλ���
	function model_field_cache(){
		global $_SGLOBAL;
		foreach($_SGLOBAL['model'] as $k=>$value){
			if(!is_file(_ROOT_."/configs/{$this->module}/data_model_{$k}_field.php")){
				// �����ݿ��ȡ
				$_SGLOBAL['model_field'] = selectsql('select * from '.jieqi_dbprefix('news_model_field')." WHERE modelid={$k} order by listorder ASC");
				cache_write("model_{$k}_field", "_SGLOBAL['model_{$k}_field']", $_SGLOBAL['model_field'], 'field',_ROOT_."/configs/news/data_model_{$k}_field.php");
			}
		}
	}	
	
	/**
	 * ����һ��ģ�ͻ���
	 * 
	 * @access     public
	 * @return     empty
	 */
	 function cacheModel($modelid){
	     jieqi_delfile(_ROOT_."/configs/{$this->module}/data_model_".$modelid.'_field.php');
	 }
}
?>