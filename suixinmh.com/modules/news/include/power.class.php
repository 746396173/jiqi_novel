<?php
/*
    *ͨ��Ȩ�޴�����
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: power.class.php 12398 2010-05-6 09:55:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

class Power extends JieqiObject{
	//�������б���
	var $vars = array();
	var $power = array(); //���ص�Ȩ�޽������
	
	function Power($key = '', $value = '', $isreturn=true){
	    if($key){
		    $this->addPower($key, $value);
			$this->checkPower($key, $isreturn);
		}
	}
	
	/**
	 * ���һ��Ȩ��
	 * 
	 * @param      string     $key Ȩ�ޱ�ʶ
	 * @access     public
	 * @return     bool
	 */
    function checkPower($key, $isreturn = true, $isadmin = false){
	     global $_SGLOBAL, $jieqiUsersStatus, $jieqiUsersGroup;
		 $this->power[$key] = 0;
		 $groups = array();
		 $isadmin = false;
		 if(JIEQI_GROUP_ADMIN!=$jieqiUsersStatus){
			 $powers = $this->getPower($key, 'a');
			 if(!isset($powers['groups'])) $groups['groups'] = $powers;
			 else $groups = $powers;
			 unset($powers);
		 }
		 if((defined('IN_ADMIN') && IN_ADMIN) || $isadmin) $isadmin = true;
		 $this->power[$key] = jieqi_checkpower($groups, $jieqiUsersStatus, $jieqiUsersGroup, $isreturn, $isadmin);
		 return $this->power[$key];
	}
	
	/**
	 * �������Ȩ��
	 * 
	 * @param      array      $array ����Ȩ������
	 * @access     public
	 * @return     array
	 */
	function checkPowers($array = array()){
	     if($array){
			 foreach($array as $k=>$v){
				 $this->addPower($k, $v, 'a');
				 $this->checkPower($k, true);
			 }
		 }
		 return $this->power;
	}
	
	/**
	 * ���һ��Ȩ������
	 * 
	 * @param      string     $key Ȩ�ޱ�ʶ
	 * @param      mixed      $value  Ȩ��ֵ
	 * @param      array      $format ��ʽ��Ȩ��ֵ[a=array,s=string]
	 * @param      string     $split  ��ʽ��Ȩ��ֵ�ָ���
	 * @access     public
	 * @return     void
	 */
	function addPower($key, $value, $format = 'a', $split = ','){
	     if(isset($key)){
		     switch (strtolower($format)) {
			      case 's':
				       if(is_array($value)) $value = implode($split, $value);
				  default:
				       if(!is_array($value)) $value = explode($split, $value);
				       
			 }
		 }
	     $this->setVar($key, $value);
	}
	
	/**
	 * ȡ��һ��Ȩ��
	 * 
	 * @param      string     $key Ȩ�ޱ�ʶ
	 * @param      array      $format ��ʽ��Ȩ��ֵ[a=array,s=string]
	 * @access     public
	 * @return     bool
	 */
	function getPower($key, $format = 'a', $split = ','){
		if (isset($this->vars[$key])) {
			if($format){
				switch (strtolower($format)) {
					case 's':
						if(!is_array($this->vars[$key])) return $this->vars[$key];
						else return implode($split, $this->vars[$key]);
					default:
						if(is_array($this->vars[$key])) return $this->vars[$key];
						else return explode($split, $this->vars[$key]);
				}
			}else return $this->vars[$key];
		}else{
			return false;
		}
	}	

	/**
	 * ȡ������Ȩ���б�
	 * 
	 * @param      void
	 * @access     public
	 * @return     array
	 */
	function getVars(){
		return $this->vars;
	}
		
	/**
	 * ȡ��Ȩ�ޱ�ʶ
	 * 
	 * @param      string     $key Ȩ�ޱ�ʶ
	 * @access     public
	 * @return     void
	 */	
	function clearPower($key = ''){
		if(!$key) $this->vars=array();
		else $this->vars[$key]=array();
	}
}
?>