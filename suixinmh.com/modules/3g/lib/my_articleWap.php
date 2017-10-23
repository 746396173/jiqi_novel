<?php
include_once ($GLOBALS['jieqiModules']['article']['path'] . '/lib/my_article.php');
/**
 * wapģ��article�Զ�����̳���articleģ���article��,������������wapģ��ĺ���
 * @author chengyuan  2014-8-7
 *
 */
class MyArticleWap extends MyArticle {
	/**
	 * ����Ŀ¼��Ϣ��ȷ���Ѿ�����loadOPF ( $articleid )����������OPF�ĵ�
	 * @return Ambigous <multitype:, string>
	 * 2014-8-7 ����11:10:20
	 */
	function getCatalog($order,$page,$pagenum = 23){
		$data = array();
		$data['article'] = $this->formatOPF();
//		$pagenum = 23;

		$totalpage = @ceil($data['article']['chapters']/$pagenum);
		if($totalpage <= 1) $totalpage=1;

		
		$order = strtolower($order);
		if(!$order || !in_array($order, array('asc','desc'))){
			$order = 'asc';//Ĭ������
		}
		if(!$page || !is_numeric($page) || $page < 1 || $page > $totalpage){
			$page = 1;//Ĭ�ϵ�һҳ
		}
		//֧�� ���� ��ҳ ��ת
		 global $jieqiConfigs,$jieqiLang;
		 if(!isset($jieqiConfigs)){
			 $this->addConfig('article','configs');
			 $jieqiConfigs['article'] = $this->getConfig('article','configs');
		 }
		 if(!isset($jieqiLang)){
			 $this->addLang('article','article');
			 $jieqiLang['article'] = $this->getLang('article');//�������԰����ø�ֵ
		 }
// 		 if(isset($jieqiConfigs['article']['indexcols']) && $jieqiConfigs['article']['indexcols']>0) $cols=intval($jieqiConfigs['article']['indexcols']);
// 		 else $cols=4;
		 $cols=1;
		 $indexrows=array();
		 $i=0;
		 $idx=0;
		 $this->preid=0; //ǰһ��
		 $this->nextid=0; //��һ��
		 $preview_page='';
		 $next_page='';
		 $lastvolume='';
		 $lastchapter='';
		 $lastchapterid = $start = $isvip = $lastvolumeorder = 0;
		if($order == 'desc'){
			krsort($this->chapters);
		}
		//���㵱ǰҳ�ĵ�һ�����ݵ�����
		$newChapters = array_slice($this->chapters,($page-1)*$pagenum,$pagenum,true);
		foreach($newChapters as $k => $chapter){//�����½ڿ�ʼ
		  if(!$chapter['display']){
				$start++;
				//�־�
				if($chapter['content-type']=='volume' && $start>=1){
						if($i>0) $idx++;
						$i=0;
						$indexrows[$idx]['ctype']='volume';
						$indexrows[$idx]['vurl']='';
						$indexrows[$idx]['vname']=@jieqi_htmlstr($chapter['id']);
						$indexrows[$idx]['vid']=$this->getCid($chapter['href']);
						$indexrows[$idx]['intro'] = @jieqi_htmlstr($chapter['intro']);
						$lastvolume=$chapter['id'];
						$lastvolumeorder = $idx;
						$idx++;
				}else{//�½�
// 						if($start==1){
// 							//Ĭ�Ͼ�-����
// 							 $i=0;
// 							 $indexrows[$idx]['ctype']='volume';
// 							 $indexrows[$idx]['vurl']='';
// 							 $indexrows[$idx]['vname']='����';
// 							 $indexrows[$idx]['vid']=0;
// 							 $indexrows[$idx]['intro'] = '';
// 							 $lastvolume = $lastvolumeorder = 0;
// 							 $idx++;
// 						}
// 						$k=$k+1;
// 						if($k < $this->nowid) $this->preid=$k;
// 						elseif($k > $this->nowid && $this->nextid==0) $this->nextid=$k;
						$tmpvar=$this->getCid($chapter['href']);
						$i++;
						$indexrows[$idx]['ctype']='chapter';
						$indexrows[$idx]['cname']=jieqi_htmlstr(trim(preg_replace("/\s+/",'  ',$chapter['id'])));
						$indexrows[$idx]['cid']=$tmpvar;
// 						if($chapter['isvip'] && !$isvip){
// 							$isvip = 1;
// 							$indexrows[$lastvolumeorder]['isvip'] = 1;
// 						}
						$indexrows[$idx]['isvip']=$chapter['isvip'];

						if(true){
							$indexrows[$idx]['time'] = $chapter['postdate'];
							$indexrows[$idx]['lastupdate'] = $chapter['lastupdate'];
							$indexrows[$idx]['size'] = $chapter['size'];
							$indexrows[$idx]['size_c'] = ceil($indexrows[$idx]['size']/2);
						}

						$lastchapter=$chapter['id'];
						$lastchapterid=$tmpvar;
						$indexrows[$idx]['curl']=basename($this->geturl('article', 'reader', 'aid='.$this->id,'cid='.$tmpvar));
						if(empty($next_page)) $next_page=$tmpvar;
						$preview_page=$tmpvar;
// 						if($i==$cols){
							$idx++;
// 							$i=0;
// 						}

				  }
			}
		}//�����½ڽ���
//		$pagetag = '[prepage]<a href="{$prepage}" target="_self">��ҳ</a>[/prepage][pages][pnum]4[/pnum][pnumchar]<em class="on">{$page}</em>[/pnumchar][pnumurl]<A href="{$pnumurl}" target="_self">{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]...<a href="{$nextpage}" target="_self">��ҳ</a>[/nextpage]��<em class="on">{$page}</em>/<em class="px3">{$totalpage}</em>ҳ';
		$jumppage = new GlobalPage(JIEQI_PAGE_TAG,$data['article']['chapters'],$pagenum, $page);
// 		$jumppage->emptyonepage = false;
// 		$totalpage = $jumppage->getVar('totalpage');
		
		$data['url_jumppage'] = $jumppage->getPage($this->geturl(JIEQI_MODULE_NAME,'catalog','evalpage=0','SYS=aid='.$this->id.($order=='desc' ? '&order='.$order : '')));
//		print_r($data);die;
		$data['article']['preview_page'] = basename($this->geturl(JIEQI_MODULE_NAME, 'reader', 'aid='.$this->id,'cid='.$preview_page));
		$data['article']['next_page'] = basename($this->geturl(JIEQI_MODULE_NAME, 'reader', 'aid='.$this->id,'cid='.$next_page));
		$data['indexrows'] = $indexrows;
		$data['order'] = $order;
		return $data;
	}
	/**
	 * �����½�����
	 * @param unknown $cid
	 * @return Ambigous <boolean, number>|boolean
	 * 2014-8-12 ����9:51:53
	 */
	function reader($cid){
		define(RETURN_READER_DATA, true);//makeHtml���ر�ʶ
		$i=0;//echo $cid;
		$num=count($this->chapters);
		while($i<$num){
			$tmpvar=$this->getCid($this->chapters[$i]['href']);
			if($tmpvar==$cid){
				return $this->makeHtml($i+1, false, true, null);
			}
			$i++;
		}
		return false;
	}
}
?>