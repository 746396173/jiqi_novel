<?php
/*
    *�༭�������ֶ�ģ��
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: form_editor.class.php 12398 2010-04-25 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/form_textarea.class.php');

class Form_editor extends Form_textarea
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
	    global $_SGLOBAL,$_SCONFIG,$_PAGE;
		if(!$this->value) return '';
		$this->setSetting();	
		//������չ
		$fileext = '';
		if($this->setting['enablesaveimage']) $fileext = 'gif|jpg|jpeg|bmp|png';
		if($this->setting['enablesaveflash']) $fileext.= '|swf|flv';
		if($this->setting['enablesavefile'])  $fileext.= '|'.$this->setting['savefileext'];
		$fileext = array_filter(explode('|', $fileext));
		$this->value = stripslashes($this->value);
		//���˽���HTML��ǩ
		if($this->setting['forbidwords']) $this->value = checkhtml($this->value, $this->setting['forbidwords']);
		//����Զ���ļ�
		$this->value = $this->saveFile($fileext);
		/*$auto_thumb_no = $_PAGE['_POST']['auto_thumb_no'];
		    if($_PAGE['_POST']['auto_thumb'] && $auto_thumb_no){
		        //�������ģ�Ͷ���������ͼ�ֶβ���ֵΪ��
			    if(isset($this->formobj->vars['__issystem']['thumb']) && $this->formobj->vars['__issystem']['thumb']==''){
				    print_r($matches);exit;
			        if($matches[3][$auto_thumb_no-1]) $firstimg = $matches[3][$auto_thumb_no-1];
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
		    }*/
		//������վͼƬ|flash|�ļ�
		///$param = "module={$this->formobj->model['tablename']}&catid={$this->formobj->category['catid']}&uploadtext={$this->field}";
		///if($fileext){
			///$this->value = save_remotefile($this->value, $fileext, $param);
		///}
		//�Ƿ��ȡ����������ժҪ
		$introcude_length = $_PAGE['_POST']['introcude_length'];
		if($_PAGE['_POST']['add_introduce'] && $introcude_length){
		    //�������ģ�Ͷ���������ժҪ�ֶβ���ֵΪ��
			if(isset($this->formobj->vars['__issystem']['description']) && $this->formobj->vars['__issystem']['description']==''){
			     $introcude_length = $introcude_length>255 ?255 :$introcude_length;//���ƽ�ȡ����
				 $tempstr = preg_replace(array('/\r|\n/'),array(),strip_tags($this->value));
				 $this->formobj->vars['__issystem']['description'] = saddslashes(jieqi_substr($tempstr, 0, $introcude_length));
			}
		}
		//�Ƿ��ȡ����ͼƬ��Ϊ����ͼƬ
/*		$auto_thumb_no = $_PAGE['_POST']['auto_thumb_no'];
		if($_PAGE['_POST']['auto_thumb'] && $auto_thumb_no){
		     //�������ģ�Ͷ���������ͼ�ֶβ���ֵΪ��
			if(isset($this->formobj->vars['__issystem']['thumb']) && $this->formobj->vars['__issystem']['thumb']==''){
			     //$this->value = stripslashes($this->value);
			     preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $this->value, $matches);
				 //$this->value = saddslashes($this->value);
			     if($matches[3][$auto_thumb_no-1]) $this->formobj->vars['__issystem']['thumb'] = $matches[3][$auto_thumb_no-1];
			
			}
		}*/
		//ȥ����վ����
		if($this->setting['enablereplaceurls']){
           $this->value = $this->replaceUrls($this->value);
		}
		
	    return saddslashes($this->value);
	}
	
	//��ȡ���ݣ�ǰ̨��ʾ
	function getShow($data = array()){
	    global $_SCONFIG, $_OBJ;
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = &new Category();
		
		$attachurl = $_OBJ['category']->getAttachurl($this->formobj->category['catid']);
		if($attachurl){//����趨�˸���URL��������������ͼƬ�����·��
		    $this->value = relative_to_absolute($this->value,$attachurl);
		}
		$this->setSetting();
		//���˽���HTML��ǩ
		if($this->setting['forbidwords']) $this->value = checkhtml($this->value, $this->setting['forbidwords']);
		//ȥ����վ����
		if($this->setting['enablereplaceurls']){
           $this->value = $this->replaceUrls($this->value);
		}
		if($this->formobj->model['pagefield']==$this->field){//�Ƿ���Ϊ��ҳ�ֶ�
			$ret = array();
			$CONTENT_POS = strpos($this->value, '[page]');
			if($CONTENT_POS !== false){
				$ret[$this->field] = explode('[page]', $this->value);
				if($CONTENT_POS==0){//�ж�[page]���ֵ�λ���Ƿ��ڵ�һλ
				   unset($ret[$this->field][0]);
				   $ret[$this->field] = array_values($ret[$this->field]);
				}
				$pagenumber = count($ret[$this->field]);
				//$data['catid'] = $this->formobj->category['catid'];
				//$data['contentid'] = $this->formobj->getVar('contentid');
				for($i=1; $i<=$pagenumber; $i++)
				{
					$ret['pageurl'][$i-1] = jieqi_geturl('news', 'show', $data, $i);
				}
	
				if(strpos($this->value, '[/page]') !== false){
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $this->value, $m, PREG_PATTERN_ORDER))
					{
						$j = ($CONTENT_POS==0) ?0 :1;
						foreach($m[1] as $k=>$v)
						{
							$ret['titles'][$j] = strip_tags($v);
							$j++;
						}
					}
					for($i=1; $i<=$pagenumber; $i++){
						if($i>1 || $CONTENT_POS==0){
							list($title, $content) = explode('[/page]', $ret[$this->field][$i-1]);
							$ret[$this->field][$i-1] = $content;
						}else{
							$ret[$this->field][$i-1] = $ret[$this->field][$i-1];
						}
					}				
				}
			}
		}
		if(!$ret){
		    if($this->pagefield) $this->formobj->setVar('___content', array("{$this->field}"=>array($this->value)));
		    return $this->value;
		}else{
			$this->formobj->setVar('___content', $ret);
			return implode('', $ret[$this->field]);
		}
	}
	
	function getValue(){
	    return shtmlspecialchars($this->value);
	}
	
	//���ñ����
	function setFormHtml(){
	    global $_OBJ,$_PAGE,$_SCONFIG;
		$catid = $this->formobj->category['catid'];
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = &new Category();
		$attachurl = $_OBJ['category']->getAttachurl($catid);
		ob_start();
		include_once($GLOBALS['jieqiModules']['news']['path'].'/include/fields/editor.inc.php');
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}
	
	//ɾ������ʱ����
	function getDelete(){
	    if($this->value){
		    $this->setSetting();	
			//������չ
			$fileext = '';
			if($this->setting['enablesaveimage']) $fileext = 'gif|jpg|jpeg|bmp|png';
			if($this->setting['enablesaveflash']) $fileext.= '|swf|flv';
			if($this->setting['enablesavefile'])  $fileext.= '|'.$this->setting['savefileext'];
			$fileext = array_filter(explode('|', $fileext));
			if($fileext){
				preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.(".implode('|', $fileext)."))\\2/i", $this->value, $matches);
				if($matches[3]){
					foreach($matches[3] as $fileurl){
					    if(strpos($fileurl, '/') == 0){
							$this->formobj->vars['_delimgs'][] = $fileurl;
						}
					}
					$this->formobj->addListenter('delimgs', $this->formobj->vars['_delimgs']);
				}
			}
		}
	}
		
    //����Զ���ļ�
	function saveFile($fileext){
	    global $_SCONFIG, $_OBJ, $_PAGE;
		$content = $this->value;
	    if($fileext){
			preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.(".implode('|', $fileext)."))\\2/i", $content, $matches);
			if($matches[3]){
				//�ϴ��ļ�ʱ���ظ�������
				$fileinfo = $_OBJ['category']->getCateSet($this->formobj->category['catid']);
				$_PAGE['setting'] = $this->setting;
				if($_PAGE['setting']['thumb_enable']>=0) $fileinfo['thumb_enable'] = $_PAGE['setting']['thumb_enable'];
				if($_PAGE['setting']['thumb_width']) $fileinfo['thumb_width'] = $_PAGE['setting']['thumb_width'];
				if($_PAGE['setting']['thumb_height']) $fileinfo['thumb_height'] = $_PAGE['setting']['thumb_height'];
				if($_PAGE['setting']['attachwater']>=0) $fileinfo['attachwater'] = $_PAGE['setting']['attachwater'];
				if($_PAGE['setting']['attachwimage']) $fileinfo['attachwimage'] = $_PAGE['setting']['attachwimage'];
				$content = save_remotefile($content, $fileext, 'content', $fileinfo);
			}
			$imgdata = false;
		    /*preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.(".implode('|', $fileext)."))\\2/i", $content, $matches);
			if($matches[3]){
			    $matches[3] = array_values(array_unique($matches[3]));
				$find = array();
				$replace = array();
				$haveimage = false;
				$URL = gethost();
				//�ϴ��ļ�ʱ���ظ�������
				$fileinfo = $_OBJ['category']->getCateSet($this->formobj->category['catid']);
				$_PAGE['setting'] = $this->setting;
				if($_PAGE['setting']['thumb_enable']>=0) $fileinfo['thumb_enable'] = $_PAGE['setting']['thumb_enable'];
				if($_PAGE['setting']['thumb_width']) $fileinfo['thumb_width'] = $_PAGE['setting']['thumb_width'];
				if($_PAGE['setting']['thumb_height']) $fileinfo['thumb_height'] = $_PAGE['setting']['thumb_height'];
				if($_PAGE['setting']['attachwater']>=0) $fileinfo['attachwater'] = $_PAGE['setting']['attachwater'];
				if($_PAGE['setting']['attachwimage']) $fileinfo['attachwimage'] = $_PAGE['setting']['attachwimage'];
				
				foreach($matches[3] as $k=>$path){
				    if(strpos($path, '://') === false) continue;
					if(!ereg("\.$URL|http://$URL/i",$path)){
						//�޲�Զ��ͼƬ����������ת����µ�BUG
						$order = substr_count(strtolower($path), 'http://');
						if(!$order) continue;
						elseif($order<2) $imgfile = $path;
						else $imgfile = substr($path, strripos($path, 'http://'));
						
					    $up = upfile($imgfile, $fileinfo ); //�ϴ��ļ�
						$upfile_file_path = $up[upfile_file_path];
						$fileurl = str_replace(_ROOT_, '', $upfile_file_path);
						unset($up);
						if($fileurl){
							if(strpos($fileurl, '/'.$_SCONFIG['attachdir']) != 0) continue;
							$find[] = $path;
							$replace[] = $fileurl;
							$haveimage = true;
						}
					}
				}
				if($haveimage) $content = str_replace($find, $replace, $content);
			}*/
		}else{
		    preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches);
			$imgdata = true;
		}
		if(!$imgdata) preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches);
		$auto_thumb_no = $_PAGE['_POST']['auto_thumb_no'];
		if($_PAGE['_POST']['auto_thumb'] && $auto_thumb_no){
		        //�������ģ�Ͷ���������ͼ�ֶβ���ֵΪ��
			    if(isset($this->formobj->vars['__issystem']['thumb']) && $this->formobj->vars['__issystem']['thumb']==''){
			        if($matches[3][$auto_thumb_no-1]) $firstimg = $matches[3][$auto_thumb_no-1];
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
		return $content;
	}

    //����ɼ�����
	function formatCollect($collectObj){
	    global $_PAGE;
	    if(!$this->value) return '';
		$tempset = $collectObj->fields[$this->field];
		$_PAGE['_POST']['add_introduce'] = $tempset['add_introduce'];
		$_PAGE['_POST']['introcude_length'] = $tempset['introcude_length'];
		$_PAGE['_POST']['auto_thumb'] = $tempset['auto_thumb'];
		$_PAGE['_POST']['auto_thumb_no'] = $tempset['auto_thumb_no'];
		return $this->value;
	}
	
		
    //������վURL
	function replaceUrls($content){
		//ȥ����վ����
        $urlsarray = match_links($content);
		if(count($urlsarray['link'])>0){
		    $URL = gethost();
		    $find = array();
			$replace = array();
			$haveurl = false;
		    foreach($urlsarray['link'] as $k=>$url){
			    if(strpos($url, '://') === false) continue;
			    if(!ereg("\.$URL|http://$URL/i",$url)){
				   $find[] = $urlsarray['all'][$k];
				   $replace[] = $urlsarray['content'][$k];
				   $haveurl = true;
				}
			}
			if($haveurl) $content = str_replace($find, $replace, $content);
		}
		return $content;
	}
}
?>