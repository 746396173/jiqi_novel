<?php
/*
    *��̬������
	[Cms News] (C) 2009-2010 Cms Inc.
	$Id: html.class.php 12398 2010-06-13 09:55:38Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

class Html extends JieqiObject{
	
	function Html(){
	    global $jieqiTpl;
		include_once(_ROOT_.'/header.php');
		$jieqiTpl->assign(array('jieqi_themeurl' => JIEQI_URL.'/themes/'.JIEQI_THEME_NAME.'/'));
	}
	
	//������ĿHTML
	function category($catid, $page = 1){
	    global $_SGLOBAL,$_SCONFIG,$_OBJ,$_PAGE;
		//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		if($_OBJ['category']->islist($catid)){
			//��ȡ���������б�
			$content = & new Content();
			$content->setHandler();
			$content->criteria->add(new Criteria('catid', $catid));
			$content->criteria->add(new Criteria('status', 99));
			$content->criteria->setSort('contentid');
			$content->criteria->setOrder('DESC');
			$pagesize = $_OBJ['category']->getPagenum($catid);;
			$_PAGE['articlerows'] = $content->lists($pagesize, $page);
			$totalcount = $content->getVar('totalcount');
			$totalpage = ceil($totalcount/$pagesize);
			$_SCONFIG['maxpage'] = $_SCONFIG['maxpage'] ?$_SCONFIG['maxpage'] :100;
			if($_OBJ['category']->isHtml($catid) && $totalpage>$_SCONFIG['maxpage']) $totalpage = $_SCONFIG['maxpage'];
			if($totalpage>1){
			    $n = 0;//λ�ñ�ʶ
				for($i=$page; $i<=$totalpage; $i++){
				    $n++;
				    $this->createCate($catid, $i);
					if($i==$totalpage){
					    $jumpurl = "?ac=create&op=category&pagesize={$_PAGE['pagesize']}&n=".($_PAGE['_GET']['n']+1)."&catids=".urlencode($_PAGE['_GET']['catids']);
						$temparr = array($_SGLOBAL['category'][$catid]['catname'], $totalpage);
					    jieqi_jumppage($jumpurl."&n=".($_PAGE['_GET']['n']+1), lang_replace('message_notice'), lang_replace('category_page_upload_success',$temparr));
					}elseif($n>=$_PAGE['pagesize']){
					    $next = $i+1;
					    $jumpurl = "?ac=create&op=category&pagesize={$_PAGE['pagesize']}&n={$_PAGE['_GET']['n']}&page={$next}&catids=".urlencode($_PAGE['_GET']['catids']);
						$step = '1 - '.$i;
						$temparr = array($_SGLOBAL['category'][$catid]['catname'], $step);
					    jieqi_jumppage($jumpurl, lang_replace('message_notice'), lang_replace('category_page_upload_success', $temparr));
					}
				}
				return true;
			}
		}
		return $this->createCate($catid, $page);
	}
	
	//����һ����Ŀ
	function createCate($catid, $page = 1){
	    global $_SGLOBAL,$_SCONFIG,$_OBJ;
		//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
		if(!is_object($_OBJ['category'])) $_OBJ['category'] = new Category();
		//�ж��Ƿ���Ҫ�����ļ�
		if(!$catid || ($showtyle = $_OBJ['category']->showType($catid))<2) return false;
		$htmldir = $_OBJ['category']->getDir($catid);
		//if(!is_dir($htmldir)){
		   //if(!jieqi_createdir($htmldir, 0777, true)) return false;
		//}
		$filename = $htmldir.$_OBJ['category']->getUrlrule($catid, $page);
		$dir = dirname($filename).'/';
		if(!is_dir($dir)) if(!jieqi_createdir($dir, 0777, true)) return false;
		if($showtyle>2){
		    if(!($pagestr = $_OBJ['category']->fetch($catid,$page))) return false;
			return swritefile($filename,$pagestr);//���ɾ�̬
		}else return $this->createFake($catid, $page, $filename, 'list');
	}
	 
	//������������HTML
	function content($id){
	    global $_SGLOBAL,$_SCONFIG,$_OBJ,$_PAGE;
		//��ʼ����Ŀ��������ͼ�����Ŀ�����б�
		if(!is_object($_OBJ['content'])) $_OBJ['content'] = new Content();		
		if(!$id || !($pagearr = $_OBJ['content']->fetch($id,1,true))) return false;
		//�ж��Ƿ���Ҫ���ɾ�̬
		if(($showtyle = $_OBJ['content']->showType($_PAGE['data']))<2) return false;
		
		$htmldir = $_OBJ['content']->getDir($_PAGE['data']);
		$statu = false;
		$filename = '';
		foreach($pagearr as $k=>$v){
		    $filename = $htmldir.$_OBJ['content']->getUrlrule($_PAGE['data'], $k);
		    $dir = dirname($filename).'/';
			if(!is_dir($dir)) if(!jieqi_createdir($dir, 0777, true)) return false;
			if($showtyle>2) $statu = swritefile($filename,$pagearr[$k]);//���ɾ�̬
			else $statu = $this->createFake($id, $k, $filename, 'show');
		}
		return $statu;
	}
	
	//������ҳ��HTML
	function index($url){
	    global $_SGLOBAL, $_SCONFIG, $_SN, $_TPL, $jieqiTset, $jieqiTpl, $_PAGE, $_OBJ;
		$htmldir = $_SGLOBAL['rootpath']."/{$url}";
		if(!is_dir($htmldir)) if(!jieqi_createdir(dirname($htmldir), 0777, true)) return false;
		template('index');
		$jieqiTpl->assign('jieqi_contents', $jieqiTpl->fetch($jieqiTset['jieqi_contents_template']));
		$pagearr = $jieqiTpl->fetch($jieqiTset['jieqi_page_template']);
		jieqi_freeresource();
		if(swritefile($htmldir, $pagearr)) return filesize($htmldir);
		else return false;
	}
	
	//������α��̬
	function createFake($id, $page, $filename, $type){
	    global $_SGLOBAL;
	    if(!$id || !$filename) return false;
		$filename = str_replace('//', '/', $filename);
		$tmpcot = str_repeat('../', substr_count(str_replace($_SGLOBAL['rootpath'],'',$filename), '/')-1);
		$content='<?php
//����ҳ��Ԥ�����ļ�
include_once(\''.$tmpcot.'global.php\');
include_once(\''.$tmpcot.'modules/news/common.php\');
include_once(\''.$tmpcot.'modules/news/include/loadclass.php\');
$_PAGE[\'_GET\'][\'id\'] = '.$id.';
$_PAGE[\'_GET\'][\'page\'] = '.$page.';
//����ģ��
include_once($_SGLOBAL[\'news\'][\'path\'].\'/source/'.$type.'.inc.php\');
include_once($_SGLOBAL[\'rootpath\'].\'/footer.php\');
?>';
		return swritefile($filename, $content);
	}
}
?>