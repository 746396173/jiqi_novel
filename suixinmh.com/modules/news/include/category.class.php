<?php
/*
    *Ŀ¼������[Ŀ¼����ɾ��ת��]
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: category.class.php 12398 2010-05-20 18:36:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

class Category extends GlobalData{

	/**
	 * ���캯��
	 * 
	 * @param      void       
	 * @access     private
	 * @return     void
	 */
	function Category($category = array()){
         if(!$category){
			 $this->GlobalData('category', 'catid','listorder');
		 }else {
		     $this->data = $category;
		 }
	}

	/**
	 * ���һ����Ŀ�Ƿ����
	 * 
	 * @access     public
	 * @return     bool
	 */
	function checkdata($id, $isreture = false){
	    //�ж������Ƿ����
	    if(!array_key_exists($id, $this->data)){
			if(!$isreture) jieqi_printfail(lang_replace('category_not_exists'));
			else return false;
		}else{
			return true;
		}
	}
	
	/**
	 * ��ȡһ����Ŀ
	 * 
	 * @access     public
	 * @return     array
	 */
	function get($catid, $isreture = true){
	    //�ж���Ŀ�Ƿ����
		if(!$this->checkdata($catid, $isreture)) return false;
	    global $categorySetting;//�����ظ�����
		if($this->data[$catid]['setting'] && !$categorySetting[$catid]){
			eval('$categorySetting['.$catid.'] = '.$this->data[$catid]['setting'].';');
			$this->data[$catid]['setting'] = $categorySetting[$catid];
		}else{
		    $this->data[$catid]['setting'] = $categorySetting[$catid];
		}
        //������Ŀ����
		//return shtmlspecialchars($this->data[$catid]);
		return ($this->data[$catid]);
	}
	
	/**
	 * ���һ����Ŀ�Ƿ����б�ҳ
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function islist($catid){
		 $cate=$this->get($catid);
		 if($cate['type']>0) return false; //�����뵥��ҳ��û���б�
		 if($cate['child']) return false;
		 else return true;
	 }
	/**
	 * ��ȡһ����Ŀ������/����URL
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getCateurl($catid = 0){
	     global $_SCONFIG;
		 return $_SCONFIG['cateurl'] ?$_SCONFIG['cateurl'] :JIEQI_URL;
	 }
	 
	/**
	 * ��ȡһ����Ŀ�б�ҳÿҳ��Ϣ����
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getPagenum($catid = 0){
	     global $_SCONFIG;
		 $retval = '';
		 if($catid){
			 $cate=$this->get($catid);
			 $retval = $cate['setting']['pagenum'];
		 }
		 if(!$retval) $retval = $_SCONFIG['pagenum'] ?$_SCONFIG['pagenum'] :30;
		 return $retval;
	 }
	 	 	 	
	/**
	 * ��ȡһ����Ŀ���µķ���URL
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getPosturl($catid = 0){
	     global $_SCONFIG;
		 return $_SCONFIG['staticurl'] ?$_SCONFIG['staticurl'] :JIEQI_URL;
	 }
	 	
	/**
	 * ��ȡһ����Ŀ�ĸ���URL������
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getAttachurl($catid = 0){
	     global $_SCONFIG,$_SGLOBAL,$_OBJ,$_PAGE;
		 $attachurl = $_SCONFIG['attachurl'] ?$_SCONFIG['attachurl'] :JIEQI_URL;
		 $cate=$this->get($catid);
		 if($cate['type']==0 && $cate['setting']['attachurl']){//������ڲ���Ŀ
		      $attachurl = $cate['setting']['attachurl'];
		 }
		 return $attachurl;
	 }	 
	/**
	 * ��ȡһ����Ŀ��ģ��
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getTemplate($catid){
	     global $_SGLOBAL,$_OBJ,$_PAGE;
	     $cate=$this->get($catid);
		 if($cate['type']>1) return false;
		 if($cate['type']==0){//������ڲ���Ŀ
		     if($cate['child']){//�������Ŀ¼��ʹ��Ƶ��ģ��
			     if($cate['setting']['template_category']){
				     return $cate['setting']['template_category'];
				 }else{
				     if(!is_object($_OBJ['model'])) new Model();
				     if($_SGLOBAL['model'][$cate['modelid']]['template_category']){
					     return $_SGLOBAL['model'][$cate['modelid']]['template_category'];
					 }else return 'category';
			     }
			 }else{
			     $template = $cate['setting']['template_list'];
			     if(!$template){
				     if(!is_object($_OBJ['model'])) new Model();
					 $template = $_SGLOBAL['model'][$cate['modelid']]['template_list'];
				     if(!$template) $template = 'list';
				 }
				 if(substr_count($template,'|')){
					 $templates = explode('|',$template);
					 if(getparameter('page')>1) return $templates[1];
					 else return $templates[0];
				 }
				 return $template;
			 }
		 }else{//����ҳ
		     	 if($cate['setting']['template_category']){
				     return $cate['setting']['template_category'];
				 }else return 'page';
		 }
	 }
	
	/**
	 * ��ȡһ����Ŀ���ļ���
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getUrlrule($catid, $page = 1, $evalpage = true){
	     global $_SGLOBAL,$_OBJ;
		 $cate=$this->get($catid);
		 if($cate['type']>1) return false;//����
		 if(!$evalpage) $page = '<{$page}>';
		 $isrule = false;//��ַ�Ƿ���Ҫ����
		 $urlrule = 'index';//Ĭ��
		 //$urlrule = "list-{$catid}";//Ĭ��
		 if($cate['type']<1){
			 if(!is_object($_OBJ['model'])) new Model();
			 if($cate['setting']['ishtml']>=0 && isset($cate['setting']['ishtml'])){
				 $ishtml = $cate['setting']['ishtml'];
			 }else{
				 $ishtml = $_SGLOBAL['model'][$cate['modelid']]['ishtml'];
			 }
		 }
		 if($cate['type']>0){//����ҳ
			 if($cate['setting']['category_urlrule']){
			    $urlrule = $cate['setting']['category_urlrule'];
				$isrule = true;
			 }
		 }elseif($cate['child']){//������Ŀ
			 if($cate['setting']['category_urlrule']){
				 $urlrule_tmp = $cate['setting']['category_urlrule'];
			 }else{
				 if($_SGLOBAL['model'][$cate['modelid']]['category_urlrule']){
					 $urlrule_tmp = $_SGLOBAL['model'][$cate['modelid']]['category_urlrule'];
				 }
			 }
			 if($ishtml!=1){
			     if($urlrule_tmp && substr_count($urlrule_tmp,'.')>0) $urlrule = $urlrule.'.'.fileext($urlrule_tmp);
			 }else{
			     $urlrule = $urlrule_tmp;
				 if($evalpage) $isrule = true;
				 else{
					 $page = '<{$page}>';
					 $isrule = true;
				 }
			 }
		 }else{//������ڲ���Ŀ
		     //if($page>1 || !$evalpage){//ҳ�����1��ʱ���ļ���Ϊindex.html
				 $urlrule = 'list-{$catid}-{$page}';//Ĭ��
				 if($cate['setting']['category_urlrule']){
					 $urlrule = $cate['setting']['category_urlrule'];
				 }else{
					 //if(!is_object($_OBJ['model'])) new Model();
					 if($_SGLOBAL['model'][$cate['modelid']]['category_urlrule']){
						  $urlrule = $_SGLOBAL['model'][$cate['modelid']]['category_urlrule'];
					 }
				 }
				 $isrule = true;
			 //}
			 
			 if($evalpage){
			     if($page<2) $urlrule_tmp = $urlrule;
				 if(!substr_count($urlrule, '/')){
					 if($page<2 && $ishtml!=1) $urlrule = 'index';//Ĭ��
					 else $isrule = true;
				 }else{
					 if($page<2 && $ishtml!=1) $urlrule = substr($urlrule, 0, strrpos($urlrule, '/')+1).'index';
					 $isrule = true;
				 }
				 if($page<2 && substr_count($urlrule_tmp,'.')>0 && $ishtml!=1){
				     $urlrule = $urlrule.'.'.fileext($urlrule_tmp);
				 }
			 }else{
			     $page = '<{$page}>';
				 $isrule = true;
			 }
		 }
		 if($isrule) eval('$urlrule = "'.saddslashes($urlrule).'";');
		 $urlrule = substr_count($urlrule,'.')<1 ? $urlrule.'.html' : $urlrule;
		 return $urlrule;
	 }
	 
	/**
	 * ��ȡһ����Ŀ�Ƿ����ɾ�̬
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function isHtml($catid){
	     global $_SGLOBAL,$_OBJ;
		 $cate=$this->get($catid);
		 if($cate['type']>1) return false;//����
		 $ishtml = false;//Ĭ��
		 if($cate['setting']['ishtml']>=0 && isset($cate['setting']['ishtml'])){
			 $ishtml = $cate['setting']['ishtml'];
		 }else{
		     if($cate['type']==0){//������ڲ���Ŀ
				 if(!is_object($_OBJ['model'])) new Model();
				 if($_SGLOBAL['model'][$cate['modelid']]['disabled']) return false;
				 $ishtml = $_SGLOBAL['model'][$cate['modelid']]['ishtml'];
			 }
		 }
		 if($ishtml<2) return false;
		 return $ishtml;
	 }
	 
	/**
	 * �Ƿ�����ȫ������
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function isSearch($catid){
	     global $_SGLOBAL,$_OBJ;
		 $cate=$this->get($catid);
		 if($cate['type']>1) return false;//����
		 if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
		 if(!($model = $_OBJ['model']->get($cate['modelid'], true))) return false;
		 return $model['enablesearch'];
	 }
	 
	/**
	 * ��ȡһ����Ŀ��ʾ��ʽ
	 * 
	 * @access     public
	 * @return     int
	 */	
	 function showType($catid){
	     global $_SGLOBAL,$_OBJ;
		 //if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		 $cate=$this->get($catid);
		 $tyle = 0;//Ĭ��
		 //������ڲ���Ŀ
		 if($cate['setting']['ishtml']>=0 && isset($cate['setting']['ishtml'])){
			 $tyle = $cate['setting']['ishtml'];
		 }else{
			 if(!is_object($_OBJ['model'])) new Model();
			 if($_SGLOBAL['model'][$cate['modelid']]['disabled']) return false;
			 $tyle = $_SGLOBAL['model'][$cate['modelid']]['ishtml'];
		 }
		 return $tyle;
	 }	
	 
	/**
	 * ��ȡһ����Ŀ�ĸ�������
	 * 
	 * @access     public
	 * @return     array
	 */
	 function getCateSet($catid){
	      global $_SGLOBAL,$_SCONFIG;
		  if(!($cate=$this->get($catid))) return false;
		  $ret = array();
		  //�����ϴ�����������
		  $ret['attachmime'] = $cate['setting']['attachmime'] ?$cate['setting']['attachmime'] :$_SCONFIG['attachmime'];
		  //����ͼ
		  $ret['thumb_enable'] = $cate['setting']['thumb_enable']>=0 ?$cate['setting']['thumb_enable'] :$_SCONFIG['thumb_enable'];
		  //����ͼ��С
		  if($cate['setting']['thumb_width'] && $cate['setting']['thumb_height']){
		      $ret['thumb_width'] = $cate['setting']['thumb_width'];
			  $ret['thumb_height'] = $cate['setting']['thumb_height'];
		  }else{
			  $thumb_size = $_SCONFIG['thumb_size'];
			  $thumb_size = @explode('*', $thumb_size );
			  $ret['thumb_width'] = $thumb_size[0];
			  $ret['thumb_height'] = $thumb_size[1];
		  }
		  //ˮӡ
		  $ret['attachwater'] = $cate['setting']['attachwater']>=0 ?$cate['setting']['attachwater'] :$_SCONFIG['attachwater'];
		  //ˮӡͼƬ�ļ�
		  $ret['attachwimage'] = $cate['setting']['attachwimage'] ?$cate['setting']['attachwimage'] :$_SCONFIG['attachwimage'];
		  return $ret;
	 }
	 
	/**
	 * ��ȡһ����Ŀ��Ŀ¼
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function getDir($catid){
	     global $_SGLOBAL,$_OBJ;
		 $cate=$this->get($catid);
		 if($cate['type']>1) return false;//����
		 //$dirs = explode('/', $cate['parentdir'].$cate['catdir']);
		 //$dir = $dirs[0];
		 //return JIEQI_ROOT_PATH.'/'.$dir.'/';
		 return JIEQI_ROOT_PATH.'/'.$cate['parentdir'].$cate['catdir'].'/';
	 }
	 
	/**
	 * ��ȡһ����Ŀ��URL
	 * 
	 * @access     public
	 * @return     string
	 */
	 function getUrl($catid, $page = 1, $evalpage = true){
	     return jieqi_geturl('news', 'lists', $catid, $page, $evalpage);
	 }
	 
	/**
	 * ���һ����Ŀ
	 * 
	 * @access     public
	 * @return     int
	 */
	 function recycle($catid, $cache = true, $deleleall = false){
	     global $_SGLOBAL, $_OBJ;
	     if(!$catid || !$this->checkdata($catid, false)) return false;
		 if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
		 $tname = jieqi_dbprefix('news_content');
		 $cname = jieqi_dbprefix('news_c_'.$_SGLOBAL['model'][$this->data[$catid]['modelid']]['tablename']);
		 dbconnect();
		 $_SGLOBAL['db']->db->query("DELETE `".$tname."`,`".$cname."` FROM `".$tname."`,`".$cname."` WHERE `".$tname."`.contentid=`".$cname."`.contentid AND `".$tname."`.catid='$catid'");
		 if(!$deleleall) updatetable('news_category', array('items'=>0),"catid={$catid}");
		 if($cache) $this->cache();//���»���
		 return true;
	 }
	 	 
	/**
	 * ����һ����Ŀ
	 * 
	 * @access     public
	 * @return     int
	 */
	function add($data){
	    if(!is_array($data)) return false;
		$catid = inserttable($this->table, $data, true);
		if(!$catid) jieqi_printfail(LANG_DO_FAILURE);
		if($data['parentid']){
		    $data['arrparentid'] = $this->data[$data['parentid']]['arrparentid'].','.$data['parentid'];
			$tdir = $this->data[$data['parentid']]['parentdir'].$this->data[$data['parentid']]['catdir'];
			$data['parentdir'] = $tdir ? $tdir.'/' : '';
			$data['parenturl'] = $this->data[$data['parentid']]['url'];
			$parentids = explode(',', $data['arrparentid']);
			foreach($parentids as $parentid){
			    if($parentid){
				    $arrchildid = $this->data[$parentid]['arrchildid'].','.$catid;
					updatetable($this->table, array('child'=>1, 'arrchildid'=>"{$arrchildid}"), "catid={$parentid}");
				}
			}
		}else{
			$data['arrparentid'] = '0';
			$data['parentdir'] = '';
			$data['parenturl'] = '';
		}
		$arrparentid = $data['arrparentid'];
		$parentdir = $data['parentdir'];
		//����������URL
		$url = "{$data['parenturl']}{$data['catdir']}";
		if(empty($data['url'])) $url = $url ? $url."/" :'';
		else $url = $data['url'];
		updatetable($this->table, array('arrchildid'=>"$catid", 'listorder'=>$catid, 'arrparentid'=>"$arrparentid", 'parentdir'=>"$parentdir", 'url'=>"$url"), "catid=$catid");
		$this->cache();//���»���
		return $catid;
	}
	
	/**
	 * ɾ��һ����Ŀ
	 * 
	 * @access     public
	 * @return     bool
	 */
	 function delete($catid, $cache =true, $deleleall = false){
	     global $_SGLOBAL, $_OBJ;
	     if(!$catid || !$this->checkdata($catid, true)) return false;
		 //���������Ŀ¼����ִֹͣ��
		 $cate=$this->get($catid, false);
		 if(!$deleleall && ($cate['child'] || substr_count($cate['arrchildid'], ','))) jieqi_printfail(lang_replace('category_exists_arrchild'));
		 //���¹�����Ŀ¼������о�Ŀ¼��arrchildid����
		 if($cate['arrparentid']){
			 $oldparentids = explode(',', $cate['arrparentid']);//�����ϼ�Ŀ¼����
			 $arrchildids = explode(',', $cate['arrchildid']);//ȡ�ø�Ŀ¼������Ŀ¼����
			 foreach($oldparentids as $oid){
			     if(!$oid || !$this->checkdata($oid, true)) continue;
				 $oldarrchildid = implode(',', array_diff(explode(',', $this->data[$oid]['arrchildid']), $arrchildids));
				 if(!substr_count($oldarrchildid, ',')) $child = 0;
				 else  $child = 1;
				 updatetable($this->table, array('arrchildid'=>"{$this->get_asort($oldarrchildid)}", 'child'=>$child), "catid={$oid}");
			 }
		 }
		 if(deletesql($this->table, array('catid'=>$catid))){
		     $this->recycle($catid, $cache, true);
			 return true;
		 }else{
		     return false;
		 }
	 }
	 	
	/**
	 * �޸�һ����Ŀ
	 * 
	 * @access     public
	 * @return     bool
	 */
	function edit($catid, $data){
	    if(!is_array($data)) return false;
		//$cate=$this->get($catid);
		$this->checkdata($catid, false);
		$isupdatecate = false;
		if($data['catdir'] != $this->data[$catid]['catdir']){
		    $isupdatecate = true;
			$this->data[$catid]['catdir'] = $data['catdir'];
		}
		if($data['parentid'] != $this->data[$catid]['parentid']){
		    $this->move($catid, $data['parentid'], $this->data[$catid]['parentid']);
		}elseif($isupdatecate && $this->data[$catid]['child']){//����޸�����ĿĿ¼����û���޸��ϼ�Ŀ¼������Ŀ¼
		    //�޸ĸ�Ŀ¼��URL���Է����¼�Ŀ¼����
			$turl = $this->data[$this->data[$catid]['parentid']]['url'].$this->data[$catid]['catdir'];
			$this->data[$catid]['url'] = $turl ? $turl.'/' : '';
		    $arrchildids = explode(',', $this->data[$catid]['arrchildid']);
			foreach($arrchildids as $cid){
			  if($cid==$catid || !$this->checkdata($cid, true)) continue;
			  $tdir = $this->data[$this->data[$cid]['parentid']]['parentdir'].$this->data[$this->data[$cid]['parentid']]['catdir'];
			  $this->data[$cid]['parentdir']= $tdir ? $tdir.'/' : '';
			  $turl = $this->data[$this->data[$cid]['parentid']]['url'].$this->data[$cid]['catdir'];
			  $this->data[$cid]['url'] = $turl ? $turl.'/' : '';
			  updatetable($this->table, array('parentdir'=>"{$this->data[$cid]['parentdir']}",'url'=>"{$this->data[$cid]['url']}"), "catid={$cid}");
			}//echo '����޸�����ĿĿ¼����û���޸��ϼ�Ŀ¼������Ŀ¼';
		}
		if(empty($data['url'])){
		   $url = "{$this->data[$catid]['parentdir']}{$data['catdir']}";
		   $data['url'] = $url ? $url."/" :'';
		}
		if(updatetable($this->table, $data,"catid={$catid}")){
		    $this->cache();//���»���
		    return true;
		}else {
		    return false;
		}
		
	}
	
	/**
	 * �ƶ�һ����Ŀ����һ����Ŀ��
	 * 
	 * @access     public
	 * @return     bool
	 */
	function move($catid, $parentid, $oldparentid){
	    //��鲢��ȡĿ����Ŀ����
		$cate = $this->get($catid, false);
		$parentcate = $parentid ?$this->data[$parentid] :array();
		$oldparentcate = $oldparentid ?$this->data[$oldparentid] :array();
		//�޸ĸ�Ŀ¼��URL���Է����¼�Ŀ¼����
		if(!substr_count($this->data[$catid]['url'], 'http://')) $this->data[$catid]['url'] = ($parentid ?$parentcate['url'] :'').$this->data[$catid]['catdir'].'/';
		$this->data[$catid]['parentdir'] = $parentid ?$parentcate['parentdir']."{$parentcate['catdir']}/" :'';
		//���¹�����Ŀ¼����Ŀ¼������и�Ŀ¼����
		$arrchildids = explode(',', $cate['arrchildid']);//print_r($arrchildids);
		if(in_array($parentid, $arrchildids)) jieqi_printfail(lang_replace('category_not_do'));
		if($cate['child']){
			foreach($arrchildids as $cid){
			  if($cid==$catid || !$this->checkdata($cid, true)) continue;
			  $this->data[$cid]['arrparentid'] = ($parentid ?$parentcate['arrparentid'].',' :'')."$parentid,".$this->get_arrparentid($cid,$catid);
			  //ȥ����Ŀ¼
			  if($oldparentid){
			     $this->data[$cid]['arrparentid'] = str_replace(",{$oldparentid}", '', $this->data[$cid]['arrparentid']);
			  }
			  //exit($this->data[$cid]['arrparentid'].'hh'.$oldparentid);
			  ///$this->data[$cid]['parentdir'] = $this->data[$catid]['parentdir'].$this->get_parentdir($cid,$this->data[$catid]['catdir']);
			  $this->data[$cid]['parentdir']=$this->data[$this->data[$cid]['parentid']]['parentdir'].$this->data[$this->data[$cid]['parentid']]['catdir'].'/';
			  if(!substr_count($this->data[$cid]['url'], 'http://')) $this->data[$cid]['url'] = $this->data[$this->data[$cid]['parentid']]['url'].$this->data[$cid]['catdir'].'/';
			  updatetable($this->table, array('arrparentid'=>"{$this->get_asort($this->data[$cid]['arrparentid'])}",'parentdir'=>"{$this->data[$cid]['parentdir']}",'url'=>"{$this->data[$cid]['url']}"), "catid={$cid}");
			}
		}//echo '���¹�����Ŀ¼����Ŀ¼������и�Ŀ¼����<br><br>';
		//���¹�����Ŀ¼������о�Ŀ¼��arrchildid����
		if($oldparentid){
			$oldparentids = explode(',', $cate['arrparentid']);
			//$arrchildids = explode(',', $cate['arrchildid']);
			$arrparentids = explode(',', $parentcate['arrparentid'].",$parentid");//����Ŀ���ϼ�Ŀ¼
			foreach($oldparentids as $oid){
			    if(!$oid || !$this->checkdata($oid, true)) continue;
				//���Ҫת�Ƶ�Ŀ¼�����ʹ���������Ŀ���ϼ�Ŀ¼�У��򲻱�ȥ��
				if(in_array($oid,$arrparentids)){ //$oldarrchildid = implode(',', explode(',', $this->data[$oid]['arrchildid']));
				}else{ $oldarrchildid = implode(',', array_diff(explode(',', $this->data[$oid]['arrchildid']), $arrchildids));
				
				if(!substr_count($oldarrchildid, ',')) $child = 0;
				else  $child = 1;

				updatetable($this->table, array('arrchildid'=>"{$this->get_asort($oldarrchildid)}", 'child'=>$child), "catid={$oid}");}
			}
		}//echo '���¹�����Ŀ¼������о�Ŀ¼��arrchildid����<br><br>';
		//���¹�����Ŀ¼���������Ŀ¼��arrchildid����
		if($parentid){
		    $this->data[$catid]['arrparentid'] = $parentcate['arrparentid'].",$parentid";
		    $parentids = explode(',', $this->data[$catid]['arrparentid']);
			$arrparentids = explode(',', $cate['arrparentid']);//����Ŀ���ϼ�Ŀ¼
			foreach($parentids as $pid){
			    if(!$pid || !$this->checkdata($pid, true)) continue;
				//���Ҫת�Ƶ�Ŀ¼�����ʹ����ھ���Ŀ���ϼ�Ŀ¼�У��򲻱�����
				if(in_array($pid,$arrparentids)){ //$newarrchildid = $this->data[$pid]['arrchildid'];
				}else{ $newarrchildid = $this->data[$pid]['arrchildid'].','.$cate['arrchildid'];
				updatetable($this->table, array('arrchildid'=>"{$this->get_asort($newarrchildid)}", 'child'=>1), "catid={$pid}");}
			}
		}else{
				$this->data[$catid]['parentdir'] = '';
				$this->data[$catid]['arrparentid'] = 0;
		}
		updatetable($this->table, array('arrparentid'=>"{$this->data[$catid]['arrparentid']}", 'parentdir'=>"{$this->data[$catid]['parentdir']}", 'url'=>"{$this->data[$catid]['url']}"), "catid={$catid}");
		//echo '���¹�����Ŀ¼���������Ŀ¼��arrchildid����<br><br>';
	}
	
	/**
	 * ��Ŀ��������
	 * 
	 * @access     public
	 * @return     bool
	 */	
	function order($order){
	      if(!is_array($order)) return false;
		  foreach($order as $catid=>$value){
		      $value = intval($value);
			  updatetable($this->table, array('listorder'=>$value), "catid={$catid}");
		  }
		  $this->cache();//���»���
		  return true;
	}
	
	/**
	 * ��ʽ����Ŀ����
	 * 
	 * @access     public
	 * @return     array
	 */	
	 function get_format($catid = 0){
			global $_SGLOBAL;
			include_once($GLOBALS['jieqiModules']['news']['path'].'/include/tree.class.php');
			if($this->data){
				$Tree = new Tree(NULL);
				foreach($this->data as $k=>$value){
					$Tree->setNode($value['catid'], $value['parentid'], $value['catname']);
				}
				$category = $Tree->getChilds($catid);
				array_splice($category,0,1);
				foreach ($category as $key=>$id){
					$_SGLOBAL['catelist'][$id] = $this->get($id);
					$_SGLOBAL['catelist'][$id]['layer'] = $Tree->getLayer($id, array('','��','��','��','��','��','��','��','��','��','��'));
					$_SGLOBAL['catelist'][$id]['url_catelist'] = $this->getUrl($_SGLOBAL['catelist'][$id]['catid']);
				}
			}else $_SGLOBAL['catelist'] = array();
			return $_SGLOBAL['catelist'];
	 }
	
	/**
	 * ��ʽ����Ŀ����
	 * 
	 * @access     public
	 * @return     array
	 */	
	 function getParentCat($parentid = 0){
	     if($this->data){
		     $ret = array();
		     foreach($this->data as $k=>$value){
			     if($value['parentid']==$parentid){
				     $ret[$k] = $value;
					 if($value['child']){
					    $ret[$k]['currentlist'] = $this->getParentCat($value['catid']);
					 }
				 }
			 }
			 return $ret;
		 }else return array();
	 }
	 	 	
	/**
	 * �ַ�������
	 * 
	 * @access     public
	 * @return     string
	 */	
	 function get_asort($string){
			$strarray = explode(',', $string);
			asort($strarray);
			return implode(',', $strarray);
	 }
	 
	/**
	 * ��ĳ����Ŀ�ϼ��ڵ��л�ȡĳһ���ڵ��µ������ϼ��ڵ�
	 * 
	 * @access     public
	 * @return     string
	 */
	function get_arrparentid($cid, $splitcatid = '')
	{
		return strchr($this->data[$cid]['arrparentid'],$splitcatid);
	}
	
	/**
	 * ��ĳ����Ŀ�ϼ��ڵ��л�ȡĳһ��Ŀ¼�µ������ϼ�Ŀ¼
	 * 
	 * @access     public
	 * @return     string
	 */
	function get_parentdir($cid, $splitcatdir = '')
	{
		return strchr($this->data[$cid]['parentdir'],$splitcatdir);
	}
	
	/**
	 * �����Ŀ����
	 * 
	 * @access     public
	 * @return     string
	 */
	function fetch($catid, $page = 1){
		global $_SGLOBAL, $_SCONFIG, $_SN, $_TPL, $jieqiTset, $jieqiTpl, $_PAGE, $_OBJ;
		//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
		//if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		//��ȡ��Ŀ����
		if(!($_SGLOBAL['cate'] = $this->get($catid, true))) return false;
		//����ģ��
		if(!is_object($_OBJ['model'])) $_OBJ['model'] = new Model();
		if($_SGLOBAL['model'][$_SGLOBAL['cate']['modelid']]['disabled']) return false;
		
		if($this->islist($catid)){
			//��ȡ���������б�
			$content = & new Content();
			
			//�����ѯ��
			$tables = array();
			//if($_SCONFIG['showarticlelists'] & 1) $tables[$content->tablepre.'c_'.$_SGLOBAL['model'][$_SGLOBAL['cate']['modelid']]['tablename']] = '*';  //���¸��ӱ����
			if($_SCONFIG['showarticlelists'] & 2) $tables[$content->table_count] = 'hits,hits_day,hits_week,hits_month,hits_time,comments,comments_checked'; //����ͳ�Ʊ����
			if($_SCONFIG['showarticlelists'] & 4) $tables[$content->table_digg] = 'supports,againsts,supports_day,againsts_day,supports_week,againsts_week,supports_month,againsts_month'; //����DIGG�����
			
			$tag = $tables ? 'tables' : NULL;
			$tabletag = ($tag ?'news_content.' :'');
			$content->setHandler($tag);
			
			if($tables){
				$tablestr = $fields = '';
				foreach($tables as $table=>$field){
					$tablestr.= " LEFT JOIN ".jieqi_dbprefix($table)." AS {$table} ON {$tabletag}contentid={$table}.contentid ";
					$fields.= ",{$table}.{$field}";
				}
				$content->criteria->setFields("{$tabletag}*{$fields}");
				$content->criteria->setTables(jieqi_dbprefix('news_content')." AS news_content {$tablestr}");
			}
			
			$content->criteria->add(new Criteria('catid', $catid));
			$content->criteria->add(new Criteria('status', 99));
			$content->criteria->setSort("{$tabletag}contentid");
			$content->criteria->setOrder('DESC');
			$pagesize = $this->getPagenum($catid);
			$page = $page<1 ? 1 : $page;
			
			$emptyonepage = true;
			$showtype = $this->showType($catid);
			if(!$showtype){
			    $link = '';
			    $emptyonepage = false;
			}else{
			    if($showtype==1) $emptyonepage = false;
			    $link = $this->getUrl($catid, 1, false);
			}
			$_PAGE['articlerows'] = $content->lists($pagesize, $page, $_SCONFIG['categorypages'], $emptyonepage);//print_r($_PAGE['articlerows']);
			//�����ɾ�̬��ʱ�����������������ҳ��
			$totalcount = $content->getVar('totalcount');
			$totalpage = ceil($totalcount/$pagesize);
			if($this->isHtml($catid) && $_SCONFIG['maxpage'] && $totalpage>=$_SCONFIG['maxpage']){
			   $content->jumppage->setVar('totalpage', $_SCONFIG['maxpage']);
			}
			$_PAGE['url_jumppage'] = $content->getPage($link);
		} else $_SGLOBAL['subcate'] = $this->get_format($catid);//����Ŀ
		$_PAGE['ac'] = 'list';
		template($this->getTemplate($catid));
		$jieqiTpl->assign('jieqi_contents', $jieqiTpl->fetch($jieqiTset['jieqi_contents_template']));
		if(!is_file($jieqiTset['jieqi_page_template']) && strpos($jieqiTset['jieqi_page_template'], '/') == 0) $jieqiTset['jieqi_page_template']=_ROOT_.$jieqiTset['jieqi_page_template'];
		$str = $jieqiTpl->fetch($jieqiTset['jieqi_page_template']);
		unset($jieqiTset['jieqi_contents_template']);
		jieqi_freeresource();
		return $str;
	}
}
?>