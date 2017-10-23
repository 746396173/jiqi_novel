<?php
/*
    *��ͼƬ�ϴ������ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_images.class.php 12398 2010-06-21 09:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_textarea.class.php');

class Form_images extends Form_textarea
{
	//���ñ�����
	function setForm(){
	    global $_SCONFIG;
		$this->fieldinfo['formattribute'] .=' style="display:none"';
		$this->element->setExtra($this->fieldinfo['formattribute']);
		$fieldtext = $this->element->render();
		return $fieldtext.$this->setFormHtml();

	}
	
	//��ȡ���ύ����
	function getAdd($value){
	    global $_OBJ,$_SCONFIG,$_SGLOBAL,$_PAGE;
	    $this->setSetting();
		if(is_array($value)){//�ɼ��������
		    $firstimg = '';
			$URL = gethost();
			$param = "module={$this->formobj->model['tablename']}&catid={$this->formobj->category['catid']}&uploadtext={$this->field}";
			$currentarr = $array = array();
			//������վͼƬ|flash|�ļ�
			foreach($value as $k=>$fileurl){
			    //�޲�Զ��ͼƬ����������ת����µ�BUG
				$order = substr_count(strtolower($fileurl), 'http://');
				if($order>1) $fileurl = substr($fileurl, strripos($fileurl, 'http://'));
				
				$URL = gethost();
				//������վͼƬ
				if(substr($fileurl,0,7)=='http://' && !ereg("\.$URL|http://$URL/i",$fileurl) && $this->setting['enablesaveimage']){
				     //if($fileurl=down_remotefile($fileurl,$param)){
					     //$array[$k] = basename($fileurl).'|'.$fileurl;
					 //}
					 $remotearr[$k] = $fileurl;
				}else{
				     $currentarr[$k] = basename($fileurl).'|'.$fileurl;
				}
				if(!$firstimg) $firstimg=$fileurl;
			}
			if($remotearr){
				$retstr = down_remotefile(implode("[page]\n",$remotearr),$param);
				$data = explode("[page]\n", str_replace("\r\n","\n",$retstr));
			    foreach($data as $fileurl){
				    $array[] = basename($fileurl).'|'.$fileurl;
				}
			}
			if($currentarr) $array = array_merge($currentarr, $array);
			$array = implode("[page]\n",$array);
		}else{
			$tempfileurls = getparameter($this->field.'_fileurl');
			if(count($tempfileurls)>0){
				$tempdescriptions = getparameter($this->field.'_description');
				$templistorders = getparameter($this->field.'_listorder');
				$tempdels = getparameter($this->field.'_delete');
				foreach($tempfileurls as $k=>$fileurl){
					if(count($tempdels)>0){//�����ѡ��ɾ��ͼƬ
					   if(in_array($k,$tempdels)){
						   @unlink(_ROOT_.$fileurl);
						   continue;//���ɾ��
					   }
					}
					$array[$templistorders[$k]]=$tempdescriptions[$k].'|'.$fileurl;
					if(!$firstimg) $firstimg=$fileurl;
				}
				ksort($array);
				$array = implode("[page]\n",$array);
			}
		}
		if($firstimg){
		    //�Ƿ��ȡ����ͼƬ��Ϊ����ͼƬ
			$auto_thumb_no = $_PAGE['_POST']['auto_thumb_no'];
			$auto_thumb_no = $auto_thumb_no < 1 ? 1 : $auto_thumb_no;
			if($_PAGE['_POST']['auto_thumb'] && $auto_thumb_no || is_array($value)){
				 //�������ģ�Ͷ���������ͼ�ֶβ���ֵΪ��
				if(isset($this->formobj->fields['thumb']) && $this->formobj->vars['__issystem']['thumb']==''){
				     if(strpos($firstimg, '://') === false){
					     if(!is_object($_OBJ['category'])) $_OBJ['category'] = &new Category();
						 $attachurl = $_OBJ['category']->getAttachurl($this->formobj->category['catid']);
					     $firstimg = $attachurl.$firstimg;
					 }
					 $param = "module={$this->formobj->model['tablename']}&catid={$this->formobj->category['catid']}&uploadtext=thumb";
					 $filepath = down_remotefile($firstimg,$param);
					 if(strpos($filepath, '/'.$_SCONFIG['attachdir']) == 0){
					     $this->formobj->vars['__issystem']['thumb'] = $filepath;
					 }
				}
			}
		}
		if(!$this->setting['enablehtml'] && $array) $array = shtmlspecialchars($array);
		$this->setValue($array);
		//echo($this->getValue());exit;
	    return $this->getValue();
	}
		
	//���ñ����
	function setFormHtml(){
	    global $_OBJ,$_SCONFIG,$_SGLOBAL;
		$catid = $this->formobj->category['catid'];
		$modelid = $this->formobj->category['modelid'];
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = &new Category();
		$attachurl = $_OBJ['category']->getAttachurl($catid);
		$rows = array();
		if($this->getValue()){
		    $data = explode("[page]\n", str_replace("\r\n","\n",$this->getValue()));
			foreach($data as $k=>$v){
			    if(!$v) continue;
			    if(strpos($v, '|')!==false){
				    //$temp = explode("|", $v);
					$fileurl = substr($v, strrpos($v,"|")+1);
					$description = str_replace('|'.$fileurl, '', $v);
					$rows[] = array('fileurl'=>$fileurl, 'description'=>$description);
				}else $rows[] = array('fileurl'=>$v, 'description'=>'');
			}
			$rows = shtmlspecialchars($rows);
		}
		ob_start();
		include($_SGLOBAL['news']['path'].'/include/fields/'.$this->fieldinfo['formtype'].'.inc.php');
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}
	
	//��ȡ���ݣ�ǰ̨��ʾ
	function getShow($data = array()){
	    global $_OBJ;
	    //return shtmlspecialchars($this->getValue());
		if($this->value){
		    $CONTENT_POS = strpos($this->getValue(), '[page]');
			if($CONTENT_POS !== false) $split = "[page]\n";
			else $split = "\n";
		    $tempdata = explode($split, str_replace("\r\n","\n",$this->getValue()));
			$ret = array();
			if(!is_object($_OBJ['category'])) $_OBJ['category'] = &new Category();
			if(!is_object($_OBJ['content'])) $_OBJ['content'] = &new Content();
			$attachurl = $_OBJ['category']->getAttachurl($this->formobj->category['catid']);
			foreach($tempdata as $k=>$v){
			    if(strpos($v, '|')!==false){
				    $fileurl = substr($v, strrpos($v,"|"));
					$description = str_replace($fileurl, '', $v);
					$fileurl = str_replace('|', '', $fileurl);
					if(strpos($fileurl, '://') === false){
					    $ret[] = array('description'=>$description,'url'=>$attachurl.$fileurl,'pageurl'=>$_OBJ['content']->getUrl($data, $k+1));
					}else{
					    $ret[] = array('description'=>$description,'url'=>$fileurl,'pageurl'=>$_OBJ['content']->getUrl($data, $k+1));
					}
				}
			}
		}
		if($this->pagefield) $this->formobj->setVar('___content', array("content"=>$ret));
		return $ret;
	}
	
	//ɾ������ʱ����
	function getDelete(){
	    if($this->value){
			$CONTENT_POS = strpos($this->getValue(), '[page]');
			if($CONTENT_POS !== false) $split = "[page]\n";
			else $split = "\n";
		    $tempdata = explode($split, str_replace("\r\n","\n",$this->getValue()));
			foreach($tempdata as $v){
			    if(strpos($v, '|')!==false){
				    $fileurl = substr($v, strrpos($v,"|")+1);
					if(strpos($fileurl, '/') == 0){
						$this->formobj->vars['_delimgs'][] = $fileurl;
						$fileurl = substr($v, strrpos($v,"|")+1);
						$fdir = dirname(_ROOT_.$fileurl).'/'.str_replace( '.', '_*_*.', basename($fileurl) );
						$farr = glob($fdir) ;
						if($farr){
							$this->formobj->vars['_delimgs'] = array_merge($this->formobj->vars['_delimgs'],$farr);
							$isreplace = true;
						}
					}
				}
			}
			if($isreplace) $this->formobj->vars['_delimgs'] = str_replace(_ROOT_,'',$this->formobj->vars['_delimgs']);
			$this->formobj->addListenter('delimgs', $this->formobj->vars['_delimgs']);
		}
	}
	
/*    //����ɼ�����
	function formatCollect($collectObj){
	    if(!$this->value) return '';
		preg_match_all("/((https?|ftp|http):\/\/)([^\s\r\n\t\f<>]+(\.gif|\.jpg|\.jpeg|\.png|\.bmp))/i", $this->value, $matches);
	    return $matches[0];
	}*/
	
    //����ɼ�����
	function formatCollect($collectObj){
	    $this->setSetting();//echo $this->value;
	    if(!$this->value) return '';
		//$pregstr = $collectObj->collectstoe($collectObj->fields[$this->field]['resultadopt']);
		//$matchvar = $collectObj->cmatchone($pregstr, $collectObj->getSource($this->value));
		$ret = array();
		if($collectObj->fields[$this->field]['resultadopt']){//�ɼ�����ӹ�
		    $pregstr = $collectObj->collectstoe($collectObj->fields[$this->field]['resultadopt']);
		    if(strpos($this->value, '[page]\n') !== false){
				$resultarr = explode("[page]\n", str_replace("\r\n","\n",$this->value));
				foreach($resultarr as $k=>$url){
				    $ret[] = $collectObj->cmatchone($pregstr, $collectObj->getSource($url));
				}
			}else{
			    $ret[] = $collectObj->cmatchone($pregstr, $collectObj->getSource($this->value));
			}
		}else{
		    preg_match_all("/((https?|ftp|http):\/\/)([^\s\r\n\t\f<>]+(".str_replace(',','|',$this->setting['fileextname'])."))/i", $this->value, $matches);
			$ret = $matches[0];
		}
	    return $ret;
	}	
	
}
?>