<?php
/*
    *�Ƽ�λ/TAG������
	[Cms News] (C) 2009-2012 Cms Inc.
	$Id: position.class.php 12398 2010-07-07 18:36:38Z huliming $
*/
if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

class Position extends GlobalData{

	/**
	 * ���캯��
	 * 
	 * @param      void       
	 * @access     private
	 * @return     void
	 */
	function Position($position = array()){
         if(!$position){
			 $this->GlobalData('position', 'posid','listorder');
		 }else {
		     $this->data = $position;
		 }
	}

	/**
	 * ���һ�������Ƿ����
	 * 
	 * @access     public
	 * @return     bool
	 */
	function checkdata($posid, $isreture = false){
	    //�ж������Ƿ����
	    $cachefile = _ROOT_.'/configs/'.$this->module."/data_position_{$posid}_field.php";
		if(!is_file($cachefile)) {
		    if(!$this->cacheOne($posid)){
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
	function get($posid, $isreture = false){
	    global $_SGLOBAL,$positionSetting;
	    $cachefile = _ROOT_.'/configs/'.$this->module."/data_position_{$posid}_field.php";
		if(!is_file($cachefile)) {
		    if(!$this->cacheOne($posid)){
			    if(!$isreture)  jieqi_printfail(lang_replace('data_not_exists'));
				return false;
			}
		}
		include_once($cachefile);
		$data = $_SGLOBAL['position_'.$posid.'_field'][$posid];
		if($data['setting'] && !$positionSetting[$posid]){
			eval('$positionSetting['.$posid.'] = '.$data['setting'].';');
			$data['setting'] = $positionSetting[$posid];
		}else{
		    $data['setting'] = $positionSetting[$posid];
		}
		return $data;
	}
			
	/**
	 * ��ȡһ����ǩ
	 * 
	 * @access     public
	 * @return     array
	 */
	function getOne($posid, $isreture = false){
	    //�ж���Ŀ�Ƿ����
	    global $positionSetting;//�����ظ�����
		
		//�����ݿ��ȡ
		$where = " where posid = ".$posid;
		$sql = 'select * from '.jieqi_dbprefix("{$this->table}")." {$where}";
		$data = selectsql($sql);
		if(!$data){
			if(!$isreture) jieqi_printfail(lang_replace('data_not_exists'));
			else return false;
		}
		$data = $data[0];
		if($data['setting'] && !$positionSetting[$posid]){
			eval('$positionSetting['.$posid.'] = '.$data['setting'].';');
			$data['setting'] = $positionSetting[$posid];
		}else{
		    $data['setting'] = $positionSetting[$posid];
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
	function delete($posid, $cache = true){
	    //�ж�ģ���Ƿ����
		$this->checkdata($posid);
		if(deletesql($this->table, array("{$this->idfield}"=>"{$posid}"))){
		    jieqi_delfile(_ROOT_.'/configs/'.$this->module."/data_position_{$posid}_field.php");
		    $this->cache();
			return true;
		}else{
		    return false;
		}
	}
	
	/**
	 * ��ɾ���Ƽ�λ
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function updatePosid($contentid, $value, $ac = 'add'){
		if(!is_array($value) || $ac == 'delete'){//ɾ���Ƽ�λ
		    if($ac == 'add') return true;
		    $temparr = array();
			$ids = array();
			foreach($this->data as $k=>$v){
			    if($v['data']){
					$temparr = explode(',', $v['data']);
					if(in_array($contentid, $temparr)){
						foreach($temparr as $t=>$tv){
							if($contentid == $tv){
							   unset($temparr[$t]);
							}
						}
						$this->edit($k, array('data' => implode(',', $temparr)) );
						$ids[] = $k;
					}
				}
			}
		}elseif($ac == 'add'){//���
			foreach($value as $k=>$v){
			    $pos = $this->get($v);
				if($pos['data']){
					if( !in_array($contentid, explode(',', $pos['data'])) ){
						$this->edit($v, array('data' => $contentid.','.$pos['data']) );
						$ids[] = $v;
					}
				}else{
					$this->edit($v, array('data' => $contentid) );
					$ids[] = $v;
				}
			}
		}else{//�޸�
		    $temparr = array();
			$oldarr = array();
			foreach($this->data as $k=>$v){
			    //if(!$v['data']) continue;
			    $temparr = explode(',', $v['data']);
				if(in_array($contentid, $temparr)){//˳������޸�ǰ���ڵ��Ƽ�λ
				   $oldarr[$k] = $temparr;
				}else{//���
				    if(in_array($k, $value)){
						if($v['data']){
							if( !in_array($contentid, explode(',', $v['data'])) ){
								$this->edit($k, array('data' => $contentid.','.$v['data']) );
								$ids[] = $k;
							}
						}else{
							$this->edit($k, array('data' => $contentid) );
							$ids[] = $k;
						}
					}
				}
			}
			if($oldarr){//�޸�ǰ���ڵ��Ƽ�λ
			    foreach($oldarr as $j=>$jv){
				   if(!in_array($j, $value)){//ɾ��δѡ��
					   foreach($jv as $t=>$tv){
						  if($contentid == $tv){
							 unset($jv[$t]);
						  }
					   }
					   $this->edit($j, array('data' => implode(',', $jv)) );
					   $ids[] = $j;
				   }
				}
			}
		}
		if($ids){
		    $ids = array_values(array_unique($ids));
			foreach($ids as $k=>$id){
			    $this->cacheOne($id);
			}
			//���»���
			$this->cache();
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
			  $this->cacheOne($id);//���µ�������
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
	 function cacheOne($posid){
	     if($data  = selectsql('select * from '.jieqi_dbprefix($this->table)." WHERE posid={$posid}")){
		     $file = _ROOT_.'/configs/'.$this->module."/data_position_{$posid}_field.php";
			 cache_write("position_{$posid}_field", "_SGLOBAL['position_{$posid}_field']", $data, $this->idfield, $file);
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
		if($this->order) $where = " where type=0 order by ".$this->order." ASC";
		else $where = ' where type=0';
		$data = selectsql('select posid,name,data,type,listorder from '.jieqi_dbprefix("{$this->table}")." {$where}");
		cache_write($table, "_SGLOBAL['".$table."']", $data, $this->idfield, $this->cachefile);
		include($this->cachefile);
	}
}
?>