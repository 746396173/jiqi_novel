<?php
/*
    *��Ƶ�����ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_video.class.php 12398 2010-06-21 09:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_images.class.php');

class Form_video extends Form_images
{
	
	//��ȡ���ύ����
	function getAdd($value){
	    global $_OBJ,$_SCONFIG,$_SGLOBAL,$_PAGE;
	    $this->setSetting();
		if(is_array($value)){//�ɼ��������
			$URL = gethost();
			$param = "module={$this->formobj->model['tablename']}&catid={$this->formobj->category['catid']}&uploadtext={$this->field}";
			$currentarr = $array = array();
			//������վ�ļ�
			foreach($value as $k=>$fileurl){
			    //�޲�Զ���ļ�����������ת����µ�BUG
				$order = substr_count(strtolower($fileurl), 'http://');
				if($order>1) $fileurl = substr($fileurl, strripos($fileurl, 'http://'));
				$URL = gethost();
				//������վ�ļ�
				if(substr($fileurl,0,7)=='http://' && !ereg("\.$URL|http://$URL/i",$fileurl) && $this->setting['enablesaveimage']){
					 $remotearr[$k] = $fileurl;
				}else{
				     $currentarr[$k] = basename($fileurl).'|'.$fileurl;
				}
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
				}
				ksort($array);
				$array = implode("[page]\n",$array);
			}
		}
		if(!$this->setting['enablehtml'] && $array) $array = shtmlspecialchars($array);
		$this->setValue($array);
	    return $this->getValue();
	}
}
?>