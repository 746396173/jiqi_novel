<?php
/**
 * ��������Ԥ��
 * @author zhangxue
 *
 */
class previewModel extends Model{
	/**
	 * Ĭ�Ϻ���,��ҳ�����ǣ�page���ɼ������Զ�����ҳ����ֻ��Ҫͨ������page���㵱ǰҳ�����ݡ�
	 * @param unknown $params
	 * 2014-6-16 ����2:46:13
	 */
	public function main($params = array()){
		//$params['page'],$params['begin_time'],$params['end_time'],$params['page']
		$data = array();
		$channel = $this->getChannel();
		$data['channel'] = $channel;
		if(isset($params['pushflag']) && intval($params['pushflag']) === 0){
			$ids = $this->getArticleList($channel['channelid'],0);
		}else{
			$ids = $this->getArticleList($channel['channelid']);
		}
		$articleids  = array_keys($ids);//���͵�����ID
		//���ids������ȫ����Ϣ
		//jieqi_pooling_article
		$this->db->init('article', 'paid', 'pooling');
		$this->db->setCriteria();
		if(count($articleids)>0){
			//ָ������
			$this->db->criteria->setTables(jieqi_dbprefix('pooling_article')."  AS pa  LEFT JOIN ".jieqi_dbprefix('article_article')." AS aa ON pa.articleid=aa.articleid LEFT JOIN ".jieqi_dbprefix('article_statamout').' as ast  ON aa.articleid=ast.articleid');
			$this->db->criteria->setFields('ast.visit,pa.*,aa.articleid,aa.articlename as articlename_old ,aa.articletype,aa.author,aa.sortid,aa.imgflag,aa.keywords,aa.postdate,aa.lastupdate,aa.lastchapterid,aa.lastchapter,aa.chapters,aa.size,aa.fullflag');
			$this->db->criteria->add(new Criteria('pa.channelid', $channel['channelid'],'='));//����
			$this->db->criteria->add(new Criteria('pa.pushflag', 1,'='));//��ץȡ״̬
			$this->db->criteria->add(new Criteria('pa.articleid', '('.implode(',',$articleids).')','in'));
		}else{
			//ȫ������
			$this->db->criteria->add(new Criteria('aa.display', 0));
			$this->db->criteria->setTables(jieqi_dbprefix('article_article')." AS aa LEFT JOIN ".jieqi_dbprefix('article_statamout').' as ast  ON aa.articleid=ast.articleid');
			$this->db->criteria->setFields('ast.visit,aa.articleid,aa.articlename,aa.intro,aa.articletype,aa.author,aa.sortid,aa.imgflag,aa.keywords,aa.postdate,aa.lastupdate,aa.lastchapterid,aa.lastchapter,aa.chapters,aa.size,aa.fullflag');
		}
		$params['begin_time'] = $params['begin_time'] ? $params['begin_time'] : $params['timestamp'];
		//ָ�����µ�ʱ������
		if($params['begin_time']){
			if(strlen($params['begin_time'])==10){
				$params['begin_time'] = $params['begin_time'].'00';
			}
			$this->db->criteria->add(new Criteria('aa.lastupdate',strtotime($params['begin_time']),'>='));
		}
		if($params['end_time']){
			if(strlen($params['end_time'])==10){
				$params['end_time'] = $params['end_time'].'00';
			}
			$this->db->criteria->add(new Criteria('aa.lastupdate',strtotime($params['end_time']),'<='));
		}

		if($params['data']=='new'){
			$starttime = strtotime(date("Y-m-d",strtotime("-1 day")));
			$this->db->criteria->add(new Criteria('aa.lastupdate', $starttime,'>='));
	    }

		$this->db->criteria->add(new Criteria('aa.size', 0,'>'));
		$this->db->criteria->setSort('aa.lastupdate');
// 		$this->db->criteria->setSort('aa.articletype');
		$this->db->criteria->setOrder('DESC');
		$pagesize = $channel['setting']['getdata']['pagesize'] ? $channel['setting']['getdata']['pagesize'] : 500;
		$data['pagesize'] = $pagesize;
		$data['rows'] = $this->db->lists($pagesize, $params['page'],JIEQI_PAGE_TAG);
// 		echo $this->db->returnsql($this->db->criteria);
// 		exit;
		
		$articleLib =  $this->load('article','article');
		foreach($data['rows'] as $k=>$v){
			$intro = $v['intro'];
            $lastchapterid = $v['lastchapterid'];
			//article_vars�ж�intro������html��ǩ��ת�봦�����ﲻ��Ҫת��
			$data ['rows'][$k] = $articleLib->article_vars($v);
			$data['rows'][$k]['intro'] = $intro;
            $data['rows'][$k]['lastchapterid'] = $lastchapterid;
			if($data ['rows'][$k]['articletype'] > 0){
				//�����ϳ��򣬿�v������1
				$data ['rows'][$k]['articletype'] = 1;
			}
			if(!$data ['rows'][$k]['visit']){
				$data ['rows'][$k]['visit'] = 0;
			}
		}
		$data['totalcount'] = $this->db->getVar('totalcount');
		$data['totalpage'] = $this->db->jumppage->getVar('totalpage');
		//xml��ʽ����Ҫ
		$data['url_jumppage'] = $this->db->getPage ($this->getUrl('pooling','home','evalpage=0','SYS=method=main'));
		$data['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
		$data['cover_dir'] =  JIEQI_URL."/api/api_image";
		$data['begin_time'] =  $params['begin_time'];
		
// 		print_r($data['rows']);
// 		exit;
		return $data;
	}
	
	/**
	 * c_2345���⴦��,ģ�壺c_2345.html
	 * @param unknown $params
	 * @return multitype:multitype: unknown number �����������
	 * 2014-6-23 ����3:40:10
	 */
	public function c_2345($params = array()){
		if(!$params['aid']) $params['aid'] = $params['book_id'];
		if(!$params['cid']) $params['cid'] = $params['chapter_id'];
// 		$isvip = false;
// 		if(substr($params['cid'],0,1)==1) $isvip = false;
// 		else $isvip = true;
// 		$params['cid'] = substr($params['cid'],1);
		//���ָ��limit��������limit����ȥcid�����ĵ������½�
		//���δָ������ֻȡcid��һ��
		$params['limit']=intval($params['limit']);
		if(!$params['limit']) $params['limit']=1;
		$c_limit = 0;
		$start = false;
		$articleLib =  $this->load('article','article');
		//ȡ����
		$articleLib->instantPackage($params['aid']);
		$data = array();
		$channel = $this->getChannel();
		$data['channel'] = $channel;
		$data['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
		$this->db->init ('chapter','chapterid','article' );
		$this->db->setCriteria ( new Criteria ( 'articleid', $params['aid']));
		//��������������Ϣ��Ӳ�ѯ��������ȡȫ���½�2|��ȡȫ������½�1
// 		if($isvip){
// 			$this->db->criteria->add(new Criteria('isvip', 0,'>'));//�Ƿ��������vip
// 		}
		$this->db->criteria->add(new Criteria('display',2,'<'));//���ͨ����
		$this->db->criteria->add(new Criteria('chaptertype',0,'='));
		$this->db->criteria->setSort('chapterorder');
		$this->db->criteria->setOrder('ASC');
		$this->db->queryObjects();
		$data['chapters']  = array();;
		$k=0;
		while($v = $this->db->getObject()){
			if($params['cid'] && $params['cid'] != $v->getVar('chapterid') && !$start){
				continue;
			}else{
				$start = true;
				$c_limit++;//
				if($c_limit>$params['limit']) break;
				$data['chapters'][$k] = array(
						'chapterid'=>$v->getVar('chapterid'),
						'size'=>$v->getVar('size','n'),
						'content'=>@$articleLib->getContent($v->getVar('chapterid')),
						'isvip'=>$v->getVar('isvip','n')
				);
				$k++;
			}
		}
		$data['articleid'] = $params['aid'];
		return $data;
	}
	/**
	 * ��ȡ�����б�
	 *
	 * 2014-6-23 ����11:34:43
	 */
	public function sort(){
		$articleLib =  $this->load('article','article');
		$data = $articleLib->getSources();
		$data['channel'] = $this->getChannel();
		return $data;
	}
	/**
	 * �½�����
	 * @param unknown $params
	 * @return unknown
	 * 2014-6-18 ����4:57:45
	 */
	public function chapter($params = array()){
		$articleLib =  $this->load('article','article');
		$data = array();
		$channel = $this->getChannel();
		$data['channel'] = $channel;
		$ids = $this->getArticleList($channel['channelid']);//�������º����ݳ�����ID��Ӧ����
		$articleids  = array_keys($ids);//���͵�����ID
		if(count($articleids)>0) {
			if(!in_array($params['aid'],$articleids)) exit('3');
			$this->db->init('article', 'paid', 'pooling');
			$data['article'] = $this->db->get ($ids[$params['aid']]);
		}else{
			$this->db->init('article', 'articleid', 'article');
			$data['article'] = $this->db->get($params['aid']);
		}
		//�麣|���ݳ�
		if(isset($channel['setting']['getdata']['chaptersource']) && $channel['setting']['getdata']['chaptersource']){
			//ͨ��chapterid��ѯ
// 			$this->db->init('chapter', 'pcid', 'pooling');
// 			$data['chapter'] = $this->db->get ($params['cid']);
			$chapters = $this->db->selectsql ( 'select * from ' . jieqi_dbprefix ( "pooling_chapter" ) . " where channelid=" . $channel['channelid'] . " and articleid=" . $params['aid']. " and chapterid=" . $params['cid'] );
			$ct = count($chapters);
			if(is_array($chapters) && $ct == 1){
				$data['chapter'] = $chapters[0];
			}else{
				exit('chapter is error');
			}
		}else{
			$this->db->init('chapter', 'chapterid', 'article');
			$data['chapter'] = $this->db->get ($params['cid']);
			//ȡ����
			$articleLib->instantPackage($params['aid']);
			$tmpvar=@$articleLib->getContent($params['cid']);
			//print_r($tmpvar);
			$data['chapter']['content'] = $tmpvar;
			//ģ���ڻ��ж�vip�½�
			$data['url_vip'] = $this->geturl('article', 'reader', 'aid='.$params['aid'],'cid='.$params['cid']);
		}
		return $data;
	}
	/**
	 * ��������
	 * @param unknown $params
	 * @return Ambigous <number, unknown, multitype:unknown NULL ����������� >
	 * 2014-6-23 ����10:48:09
	 */
	function info($params = array()){
		$articleLib =  $this->load('article','article');
		$data = array();
		$channel = $this->getChannel();
		$data['channel'] = $channel;
		$data['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
		//������Ϣ������ȡ
		if(!$channel['setting']['getdata']['nosetchapters'])exit;
		$ids = $this->getArticleList($channel['channelid']);//���ݳ���ID
		$articleids  = array_keys($ids);
		$this->db->init('article', 'articleid', 'article');
		$this->db->setCriteria();
		//���ϲ�ѯ+jieqi_article_stat(weekvisit,monthvisit,allvisit)
		if(count($articleids)>0) {
			//��ȡ�����²����������ݳ���
			if(!in_array($params['aid'],$articleids)){
				exit('3');//�������ݳ�û�д�����
			}else{
				//���ݳ��ڵ�����
				$this->db->criteria->setTables(jieqi_dbprefix('pooling_article')."  AS pa  LEFT JOIN ".jieqi_dbprefix('article_article')." AS aa ON pa.articleid=aa.articleid LEFT JOIN ".jieqi_dbprefix('article_stat').' as ast  ON aa.articleid=ast.articleid');
				$this->db->criteria->setFields('ast.total as allvisit,ast.month as monthvisit,ast.week as weekvisit,ast.day as dayvisit,pa.*,aa.articleid,aa.articlename as articlename_old,aa.chapters,aa.articletype,aa.author,aa.sortid,aa.imgflag,aa.keywords,aa.postdate,aa.lastupdate,aa.lastchapterid,aa.size,aa.fullflag');
				$this->db->criteria->add(new Criteria('pa.channelid', $channel['channelid'],'='));//����
				$this->db->criteria->add(new Criteria('pa.pushflag', 1,'='));//��ץȡ״̬
			}
		}else{
			//���������ݳ���û�����£����ȡԴ����
			$this->db->criteria->setTables(jieqi_dbprefix('article_article')." AS aa LEFT JOIN ".jieqi_dbprefix('article_stat').' as ast  ON aa.articleid=ast.articleid');
			$this->db->criteria->setFields('ast.total as allvisit,ast.month as monthvisit,ast.week as weekvisit,ast.day as dayvisit,aa.articlename,aa.articleid,aa.chapters,aa.intro,aa.articletype,aa.author,aa.sortid,aa.imgflag,aa.keywords,aa.postdate,aa.lastupdate,aa.lastchapterid,aa.size,aa.fullflag');
		}
		$this->db->criteria->add(new Criteria('ast.mid','visit','='));
		$this->db->criteria->add(new Criteria('aa.articleid', $params['aid'],'='));
		//$this->db->criteria->add(new Criteria('aa.display', 0));
		$this->db->criteria->add(new Criteria('aa.size', 0,'>'));
		//��ѯ
		$this->db->queryObjects();
		$aobj=$this->db->getObject();

		//article_vars�ж�intro������html��ǩ��ת�봦�����ﲻ��Ҫת��
		if(is_object($aobj)){
			$intro = $aobj->getVar('intro', 'n');
			if($channel['url'] == '360.com'){
				$sort = $aobj->getVar('sort', 'n');
			}
			$data['article'] = $articleLib->article_vars($aobj);
			$data['article']['intro'] = $intro;
			if($sort){
				$data['article']['sort'] = $sort;
			}
			if($data['article']['articletype'] > 0){
				//�����ϳ��򣬿�v������1
				$data['article']['articletype'] = 1;
			}
			if(!$data['article']['weekvisit']){
				$data['article']['weekvisit'] = 0;
			}
			if(!$data['article']['monthvisit']){
				$data['article']['monthvisit'] = 0;
			}
			if(!$data['article']['allvisit']){
				$data['article']['allvisit'] = 0;
			}
			//image|limage|simage
			if($data['article']['image']){//�����
				$data['article']['url_image_l'] = JIEQI_URL."/api/api_image".$data['article']['image'];
			}
			if($data['article']['limage']){//С����
				$data['article']['url_image'] = JIEQI_URL."/api/api_image".$data['article']['limage'];
			}
		}else{
			exit('null');
		}
		return $data;
	}
	/**
	 * �½ڸ�������ͨ��chapterId�����ж�
	 * @param unknown $params
	 * @return unknown
	 * 2014-6-23 ����4:57:19
	 */
	public function cquire($params = array()){
		$params['aid'] = $params['aid'] ? $params['aid'] : $params['bookId'];
		$data = $this->chapters($params);
		$data['updatenum'] = 0;
		$start = false;
		if($params['chapterId']){
			foreach($data['chapters'] as $k=>$v){
				if($start) $data['updatenum']=$data['updatenum']+1;
				if($params['chapterId']==$v['chapterid']) $start = true;
			}
		}else $data['updatenum']=count($data['chapters']);
		$data['aid'] = $params['aid'];
		return $data;
	}
	/**
	 * �������µ��½�Ŀ¼,�½�Ŀ¼ֱ����ȡԴ���µ������½�Ŀ¼���������������ò�����Ϊ����ȡȫ���½ڣ���ȡȫ������½ڣ�����ȡ�½�
	 * @param unknown $params
	 * 2014-6-17 ����5:21:43
	 */
	public function chapters($params = array()){
		$articleLib =  $this->load('article','article');
		$data = array();
		$channel = $this->getChannel();
		$data['channel'] = $channel;
		// 		$data['cover_dir'] =  JIEQI_URL."/api/api_image";
		$data['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
		//����ȡ�½�
		if(!$channel['setting']['getdata']['nosetchapters'])exit;
		$ids = $this->getArticleList($channel['channelid']);//������ID
		$articleids  = array_keys($ids);
		if(count($articleids)>0) {
			//��ȡ�����²����������ݳ���
			if(!in_array($params['aid'],$articleids)) exit('3');
		}
		$this->db->init ( 'article', 'articleid', 'article' );
		$article = $this->db->get ($params['aid'] );
		if(!$article) exit('4');
		$data ['article'] = $articleLib->article_vars($article);
		//jieqi_article_stat ���԰�
		$this->db->init ( 'stat', 'statid', 'article' );
		$this->db->setCriteria ( new Criteria ( 'articleid', $params['aid']));
		$this->db->criteria->add(new Criteria('mid','visit','='));
		$this->db->queryObjects();
		$statamout=$this->db->getObject();
		if(is_object($statamout)){
			$data ['article']['allvisit'] = $statamout->getVar('total');
			$data ['article']['monthvisit'] = $statamout->getVar('month');
			$data ['article']['weekvisit'] = $statamout->getVar('week');
			$data ['article']['dayvisit'] = $statamout->getVar('day');
		}else{
			$data ['article']['allvisit'] = $data ['article']['monthvisit'] = $data ['article']['weekvisit'] = $data ['article']['dayvisit'] = 0;
		}
		
		$articletype=intval($data ['article']['articletype']);
		if(($articletype & 2)>0) $data['article']['articletype'] = 1;
		
		if(isset($channel['setting']['getdata']['chaptersource']) && $channel['setting']['getdata']['chaptersource']){
			//���ݳ��½�����
			$this->db->init ('chapter','pcid','pooling' );
			$this->db->setCriteria ();
			$this->db->criteria->setFields('chaptertype,chapterid,chaptername,chapterorder,size,adddate,isvip,adddate');
			$this->db->criteria->add(new Criteria('paid',$ids[$params['aid']]));
			$this->db->criteria->add(new Criteria('channelid',$channel['channelid']));
			$this->db->criteria->add(new Criteria ( 'articleid', $params['aid']));
			if($params['read_chapter']){
				//ֻ��ȡ�½�
				$this->db->criteria->add(new Criteria('chaptertype', 0));
			}
			$this->db->criteria->setSort('chapterorder');
			$this->db->criteria->setOrder('ASC');
			$this->db->queryObjects();
			$data['chapters']  = array();;
			$k=0;
			while($v = $this->db->getObject()){
				$data['chapters'][$k] = array(
						'chaptertype'=>$v->getVar('chaptertype', 'n'),
						'chaptertype_tag'=>$v->getVar('chaptertype', 'n')==0?'�½�':'��',
// 						'chapterid'=>$v->getVar('pcid'),//���ݳ��½�ID
						'chapterid'=>$v->getVar('chapterid'),//�麣վ�½�Id
						'chapterorder'=>$v->getVar('chapterorder'),
						'chaptername'=>str_replace(array('&nbsp;','<br />','&amp;nbsp;'),array(' ','',' '),$v->getVar('chaptername','n')),
						'size'=>$v->getVar('size','n'),
						'saleprice'=>$v->getVar('saleprice','n'),//���ݳ�û�д�����
						'lastupdate'=>$v->getVar('adddate','n'),
						'url'=>'http://'.$_SERVER['HTTP_HOST'].'/?ac=chapter&aid='.$params['aid'].'&cid='.$v->getVar('chapterid'),
						'isvip'=>$v->getVar('isvip','n'),
						'vchapterid'=>$v->getVar('vchapterid','n'),
						'postdate'=>$v->getVar('adddate','n')
				);
				$k++;
			}
		}else{
			//�麣վ�½�����
			$this->db->init ('chapter','chapterid','article' );
			$this->db->setCriteria ( new Criteria ( 'articleid', $params['aid']));
			//��������������Ϣ��Ӳ�ѯ��������ȡȫ���½�2|��ȡȫ������½�1
			//if($channel['setting']['getdata']['nosetchapters'] == 1){
				//$this->db->criteria->add(new Criteria('isvip', 0,'='));//���
			//}
			$this->db->criteria->add(new Criteria('display', 2,'<'));//���ͨ����
			if($params['read_chapter']){
				//ֻ��ȡ�½�
				$this->db->criteria->add(new Criteria('chaptertype', 0));
			}
			$this->db->criteria->setSort('chapterorder');
			$this->db->criteria->setOrder('ASC');
			$this->db->queryObjects();
			$data['chapters']  = array();;
			$k=0;
			while($v = $this->db->getObject()){
			    if($channel['setting']['getdata']['nosetchapters'] == 1){
				     if($v->getVar('isvip','n')) break;
				}
				$data['chapters'][$k] = array(
						'chaptertype'=>$v->getVar('chaptertype', 'n'),
						'chaptertype_tag'=>$v->getVar('chaptertype', 'n')==0?'�½�':'��',
						'chapterid'=>$v->getVar('chapterid'),
						'chapterorder'=>$v->getVar('chapterorder'),
						'chaptername'=>str_replace(array('&nbsp;','<br />','&amp;nbsp;'),array(' ','',' '),$v->getVar('chaptername','n')),
						'size'=>$v->getVar('size','n'),
						'saleprice'=>$v->getVar('saleprice','n'),
						'lastupdate'=>$v->getVar('lastupdate','n'),
						'url'=>'http://'.$_SERVER['HTTP_HOST'].'/?ac=chapter&aid='.$params['aid'].'&cid='.$v->getVar('chapterid'),
						'isvip'=>$v->getVar('isvip','n'),
						'vchapterid'=>$v->getVar('vchapterid','n'),
						'postdate'=>$v->getVar('postdate','n')
				);
				$k++;
			}
		}
		// 		$data['chapters'] = $chapters;
		//���ݳ��������� ������ Դ��������
		//articlename,intro,image,limage,simage
		$this->db->init('article', 'paid', 'pooling');
		$particle = $this->db->get ($ids[$params['aid']]);
		if($particle['articlename']){
			$data['article']['articlename'] = trim( $particle['articlename']);
		}
		if($particle['intro']){
			$data['article']['intro'] = trim($particle['intro']);
		}
		if($particle['image']){
			//$data['article']['url_image_l'] = JIEQI_URL."/api/api_image".$particle['image'];
		}
		return $data;
	}
	/**
	 *
	 * ��ȡ��Ч������ ��������
	 * 2014-6-16 ����1:49:42
	 */
	private function getChannelURL(){
	//print_r($_SERVER['HTTP_HOST']);
		$params = explode('.',$_SERVER['HTTP_HOST']);
		if(!$params[0] || !$params[1]){
			$this->printfail(LANG_ERROR_PARAMETER);
		}else {
			return  $params[0].'.'.$params[1];
		}
	}
	/**
	 * ��ѯ�����µ����ݳ������б�ÿ�����������ݳ�������Ψһ�ģ����ݴ����Է��ص����ݸ�ʽΪ��key:articleid value:paid�Է������ͨ��articleid��ȡ���ݳ����¡�
	 * @param unknown $channelid	����Id
	 * @param unknown $pushflag		״̬��0��� 1����
	 * @return multitype:array(articleid(��������id)=>paid(���ݳ�����id))
	 * 2014-6-16 ����3:57:28
	 */
	function getArticleList($channelid,$pushflag=1) {
		$this->db->init('article', 'paid', 'pooling');
		$this->db->setCriteria(new Criteria('channelid', $channelid));
		$this->db->criteria->add(new Criteria('pushflag', $pushflag));
		$this->db->criteria->setSort('lastdate');
		$this->db->criteria->setOrder('DESC');
		$this->db->queryObjects();
		$ids = array();
		while($v = $this->db->getObject()){
			$ids[$v->getVar('articleid','n')] = $v->getVar('paid','n');
		}
		return $ids;
	}
	/**
	 * ��ȡ������Ϣ
	 * @return �����������
	 * 2014-6-16 ����2:55:00
	 */
	function getChannel(){
		$url =$this->getChannelURL();
		if(!$url) exit('0');
		$ch = $this->load('channel', 'pooling');//�����Զ��建����
		$ch->setCriteria(new Criteria('url', $url));
		$ch->queryObjects();
		$channel = $ch->getObject();
		if (is_object ( $channel )) {
			//��֤data��ip��open
			eval('$setting = '.$channel->getVar('setting','n').';');//�ַ���ת����
			//�ж�IP
			$ip = $this->getIp();
			if(isset($setting['getdata']) && preg_match('/('.$setting['getdata']['ip'].')/is', $ip) && $channel->getVar('statu','n')){
				$channel->setVar('setting',$setting);
				//����ת����
				foreach($channel->getVars() as $k=>$v){
					$ret[$k] = $channel->getVar($k,'n');
				}
				return $ret;
			}
		}
		exit('channel is null');
	}

/**
	 * ��ʾ�ϰ�������Ķ�ͼƬ
	 * @param unknown $aid
	 * @param unknown $cid
	 * @param unknown $sign
	 * 2014-8-25 ����10:55:20
	 */
	public function getOldVipContent($aid,$cid,$sign,$type){

		//cidƥ��vchapterid���ҵ�����cid����ѯ����
		if($type != 'newchapter'){
			$this->db->init ( 'chapter', 'chapterid', 'article' );
			$this->db->setCriteria ( new Criteria ( 'vchapterid', $cid) );
			if($this->db->getCount($this->db->criteria)){
				$this->db->queryObjects();
				$object=$this->db->getObject();
				//object-array
				$cid = $object->getVar ( 'chapterid' );
			}else{
				exit();
			}
		}
		$articleLib = $this->load ( 'article', 'article' );
		$articleLib->instantPackage ( $aid );
		$content = @$articleLib->getContent ( $cid );
		
		define ( 'JIEQI_NOCONVERT_CHAR', '1' );
		@ini_set ( 'memory_limit', '64M' ); // ��������ʹ�õ��ڴ�
		
		// 		jieqi_getconfigs ( JIEQI_MODULE_NAME, 'configs' );
		// 		$jieqiConfigs ['obook'] ['obkpictxt'] = '20000'; // һ��ͼƬ��ʾ�����ֽ�
		// 		$jieqiConfigs ['obook'] ['obkpictxt'] = intval ( $jieqiConfigs ['obook'] ['obkpictxt'] );
		
		
		include_once (JIEQI_ROOT_PATH . '/include/changecode.php');
		include_once (JIEQI_ROOT_PATH . '/lib/text/textfunction.php');
		include_once (JIEQI_ROOT_PATH . '/lib/image/imagetext.php');
		$outstr = preg_replace ( array (
				'/[\t]+/'
		), '', $content);
		// 		if ($_REQUEST ['pic'] > 0) {
		// 			$_REQUEST ['pic'] = intval ( $_REQUEST ['pic'] );
		// 			$outstr = jieqi_substr ( $outstr, ($_REQUEST ['pic'] - 1) * $jieqiConfigs ['obook'] ['obkpictxt'], $jieqiConfigs ['obook'] ['obkpictxt'], '' );
		// 		}
		// 		if (! empty ( $jieqiConfigs ['obook'] ['obookreadhead'] ))
			// 			$outstr = $jieqiConfigs ['obook'] ['obookreadhead'] . "\r\n" . $outstr;
			// 		if (! empty ( $jieqiConfigs ['obook'] ['obookreadfoot'] ))
				// 			$outstr .= "\r\n" . $jieqiConfigs ['obook'] ['obookreadfoot'];
		$outstr = jieqi_limitwidth ( $outstr, 80 );
		
		
		
		
		
		// ����ˮӡ
		$tmp = '<{$userid}>';
		$watertext = str_replace ( array (
				'<{$userid}>',
				'<{$username}>',
				'<{$date}>',
				'<{$time}>'
		), array (
				$_SESSION ['jieqiUserId'],
				$_SESSION ['jieqiUserName'],
				date ( JIEQI_DATE_FORMAT, JIEQI_NOW_TIME ),
				date ( JIEQI_TIME_FORMAT, JIEQI_NOW_TIME )
		), $tmp );
		if (strlen ( $watertext ) < 10)
			$watertext = sprintf ( '%10s', $watertext );
		
		$charsetary = array (
				'gb2312' => 'gb',
				'gbk' => 'gb',
				'gb' => 'gb',
				'big5' => 'big5',
				'utf-8' => 'utf8',
				'utf8' => 'utf8'
		);
		$fontcharset = JIEQI_SYSTEM_CHARSET;
		// ���׿ո�����
		if (JIEQI_SYSTEM_CHARSET == 'gb2312' || JIEQI_SYSTEM_CHARSET == 'gbk')
			$outstr = str_replace ( '    ', chr ( 161 ) . chr ( 161 ) . chr ( 161 ) . chr ( 161 ), $outstr );
		elseif (JIEQI_SYSTEM_CHARSET == 'big5')
		$outstr = str_replace ( '    ', chr ( 161 ) . chr ( 64 ) . chr ( 161 ) . chr ( 64 ), $outstr );
		if (JIEQI_SYSTEM_CHARSET != JIEQI_CHAR_SET) {
			if ((JIEQI_SYSTEM_CHARSET == 'gb2312' || JIEQI_SYSTEM_CHARSET == 'gbk') && JIEQI_CHAR_SET == 'big5') {
				if (! empty ( $jieqiConfigs ['obook'] ['obkcharconvert'] )) {
					$outstr = jieqi_gb2big5 ( $outstr );
					$watertext = jieqi_gb2big5 ( $watertext );
					$fontcharset = JIEQI_CHAR_SET;
				}
			} elseif (JIEQI_SYSTEM_CHARSET == 'big5' && (JIEQI_CHAR_SET == 'gb2312' || JIEQI_CHAR_SET == 'gbk')) {
				if (! empty ( $jieqiConfigs ['obook'] ['obkcharconvert'] )) {
					$outstr = jieqi_big52gb ( $outstr );
					$watertext = jieqi_big52gb ( $watertext );
					$fontcharset = JIEQI_CHAR_SET;
				}
			}
		}
		$changefun = '';
		if (isset ( $charsetary [$fontcharset] ))
			$changefun = 'jieqi_' . $charsetary [$fontcharset] . '2utf8';
		if (function_exists ( $changefun )) {
			$outstr = call_user_func ( $changefun, $outstr );
			$watertext = call_user_func ( $changefun, $watertext );
		}
		$img = new ImageText ();
		$img->set ( 'text', $outstr );
		$img->set ( 'startx', 20 );
		$img->set ( 'starty', 50 );
		$img->set ( 'fontsize', 15 );
		$img->set ( 'fontfile', JIEQI_ROOT_PATH.'/wqy-microhei.ttc');
		$img->set ( 'angle', 0);
		$img->set ( 'imagecolor', '#CCDAED' );
		$img->set ( 'textcolor', '#000000' );
		$img->set ( 'shadowcolor','#000000');
		$img->set ( 'shadowdeep', 0);
		$img->set ( 'imagetype', 'jpg');
		// if(isset($jieqiConfigs['obook']['obkwatertext'])) $img->set('watertplace', intval($jieqiConfigs['obook']['obkwatertext']));
		// else $img->set('watertplace', 2); //Ĭ��ƽ̣�Ϊ�˼�����ǰ���?
		// $img->set('watertext', $watertext);
		$img->set ( 'watercolor', '#ff6600' );
		$img->set ( 'watersize',16);
		$img->set ( 'waterangle', 45 );
		$img->set ( 'waterpct', 30 );
		// 		$jieqiConfigs ['obook'] ['jpegquality'] = intval ( $jieqiConfigs ['obook'] ['jpegquality'] );
		// 		if ($jieqiConfigs ['obook'] ['jpegquality'] >= 0 && $jieqiConfigs ['obook'] ['jpegquality'] <= 100)
		$img->set ( 'jpegquality', 90 );
		// ͼƬˮӡ
		// 		$jieqiConfigs ['obook'] ['obookwater'] = intval ( $jieqiConfigs ['obook'] ['obookwater'] );
		// 		if ($jieqiConfigs ['obook'] ['obookwater'] > 0)
			// 			$img->set ( 'wateriplace', $jieqiConfigs ['obook'] ['obookwater'] );
			// 		$jieqiConfigs ['obook'] ['obookwtrans'] = intval ( $jieqiConfigs ['obook'] ['obookwtrans'] );
			// 		if ($jieqiConfigs ['obook'] ['obookwtrans'] >= 1 && $jieqiConfigs ['obook'] ['obookwtrans'] <= 100)
		$img->set ( 'wateritrans', 30 );
		
			// 		if (! empty ( $jieqiConfigs ['obook'] ['obookwimage'] ) && is_file ( $jieqiModules ['obook'] ['path'] . '/images/' . $jieqiConfigs ['obook'] ['obookwimage'] ))
		
		global $jieqiModules;
		$img->set ( 'waterimage', $jieqiModules ['system'] ['path'] . '/images/qqonline.gif');
		$img->display ();
	}





/*------------------------------- ����Ϊ����ͬ��  ---------------------------------------------*/
	
	
	function handleStatamout(){
		$this->db->init('statamout','statamoutid','article');
		//����jieqi_article_statamout���ظ�����
		//ȡ�����е��ظ�articleid
		//ѭ��������ѯ���ظ���¼�ϲ�Ϊһ�����ݣ�Ȼ��ɾ��һ��
		$setarticle = $this->db->selectsql ('SELECT articleid, COUNT( * ) AS count FROM jieqi_article_statamout GROUP BY articleid HAVING count >1');
		$i = 0;
		foreach ($setarticle as $k=>$v){
			$stat = $this->db->selectsql ('SELECT * FROM jieqi_article_statamout where articleid = '.$v['articleid']);
			if(count($stat) == 2){
				$i++;
				//�ϲ�����
				$stat[0]['visit'] = $stat[0]['visit']+$stat[1]['visit'];
				$stat[0]['vote'] = $stat[0]['vote']+$stat[1]['vote'];
				$stat[0]['goodnum'] = $stat[0]['goodnum']+$stat[1]['goodnum'];
				$stat[0]['vipvote'] = $stat[0]['vipvote']+$stat[1]['vipvote'];
				$stat[0]['sale'] = $stat[0]['sale']+$stat[1]['sale'];
				$this->db->edit($stat[0]['statamoutid'], $stat[0]);
				$this->db->delete ( $stat[1]['statamoutid'] );
				echo $i.'��articleid='.$v['articleid'].'...ok<br>';
			}else{
				echo 'is not 2';
			}
		}
		echo '...end';
	}
	
	/**
	 * ͬ�� ��ȡ�����͵����� �� poolingģ��
	 *
	 * 2014-6-25 ����10:21:42
	 */
	function sync(){
		$map = $this->sync_outapi();
		$this->sync_outarticle($map);
		$map1 = $this->sync_apisite();
		$this->sync_apiarticle($map1);
		exit;
	}
	function sync_article_api($params){
		if(!$params['type']){
			exit('typ is null');
		}
		if(!$params['cid']){
			exit('channelid is null');
		}
		$this->db->init('api', 'id', 'article');
		$this->db->setCriteria();
		$this->db->criteria->setSort('id');
		$this->db->criteria->add ( new Criteria ( 'type', $params['type'] ) );
		$this->db->queryObjects();
		//����ԭʼ����
		$data = array();
		while($v = $this->db->getObject()){
			$row = array();
			foreach($v->getVars() as $k=>$v){
				$row[$k] = 	$v['value'];
			}
			$data[] = $row;
		}
		$type = array(
				1=>'souhu',
				2=>'panda',
				3=>'zhangyue',
				4=>'sq',
				5=>'baidu',
				6=>'baiyue',
				7=>'g3',
				8=>'ifeng',
				9=>'mobile',
				10=>0,
				11=>'mi',
				12=>'sina',
				13=>'tian',
				14=>'kj',
				15=>0,
				16=>'azrd',
				17=>'hawei',
				18=>'mpu'
		);
		$i = 0;
		foreach($data as $k=>$v){
			$i++;
			$this->db->init ( 'article', 'articleid', 'article' );
			$ae = $this->db->get ( $data[$k]['articleid']);
			if(!$ae){
				echo '��Ч��articleid��'.$data[$k]['articleid'];
				continue;
			}

			//��ȡָ������������
			$article = array();
			$article['channelid'] = $params['cid'];//����IDʹ����ID
			if($params['type'] == 9){
				//�ƶ�
				$article['articlename'] = $data[$k]['articlename'];
				$article['apiId'] = $data[$k]['apiname'];//�ƶ��˵�ID
			}elseif ($params['type'] == 7){//3gԭʼ����
				$article['articlename'] = $ae['articlename'];
			}else{
				$article['articlename'] = $data[$k]['apiname'] ? $data[$k]['apiname'] : $data[$k]['articlename'];
			}
			$article['articleid'] = $data[$k]['articleid'];
			$article['pushflag'] = 1;
			$article['adddate'] = $data[$k]['uploadtime'];
			$article['intro'] = $ae['intro'];
			//jieqi_article_channel
			$this->db->init('article', 'paid', 'pooling');
			//�����µ��鲻�ظ����
			$this->db->setCriteria ( new Criteria ( 'channelid', $params['cid'] ) );
			$this->db->criteria->add ( new Criteria ( 'articleid', $article['articleid'] ) );
			$this->db->criteria->setLimit ( 1 );
			$this->db->queryObjects ();
			$tmpa = $this->db->getObject ();
			if (is_object ( $tmpa )) {
				echo $i.':�ظ������£�'.$data[$k]['articlename'].'<br/>';
				continue;
			}
			$attachid = $this->db->add ($article);
			if($attachid){
				echo $i.':ͬ����ɣ�'.$article['articlename'].'<br/>';
			}else{
				echo $i.':ͬ��ʧ�ܣ�'.$article['articlename'].'<br/>';
			}
		}
	}
	//jieqi_manage_apiarticle
	private function sync_apiarticle($map){
		echo '<br>------------------��ʼͬ��jieqi_manage_apiarticle-------------------';
		$this->db->init('apiarticle', 'id', 'manage');
		$this->db->setCriteria();
		$this->db->criteria->setSort('id');
		$this->db->queryObjects();
		//����ԭʼ����
		$data = array();
		while($v = $this->db->getObject()){
			$row = array();
			foreach($v->getVars() as $k=>$v){
				$row[$k] = 	$v['value'];
			}
			$data[] = $row;
		}
		$this->db->init('article', 'paid', 'pooling');
		foreach($data as $k=>$v){
			$article = array();
			if(!empty($map) && !empty($map[$data[$k]['sid']])){
				$article['channelid'] = $map[$data[$k]['sid']];//����IDʹ����ID
			}else {
				echo 'error';
				exit;
			}
			$article['articlename'] = $data[$k]['articlename'];
			$article['articleid'] = $data[$k]['articleid'];
// 			$article['lastvolumeid'] = $data[$k]['lastvolumeid'];
// 			$article['lastvolume'] = $data[$k]['lastvolume'];
// 			$article['lastchapterid'] = $data[$k]['lastchapterid'];
// 			$article['lastchapter'] = $data[$k]['lastchapter'];
// 			$article['outchapters'] = $data[$k]['outchapters'];
			$article['fullflag'] = $data[$k]['fullflag'];
			$article['pushflag'] = $data[$k]['statu'];
			$article['lastdate'] = $data[$k]['lastupdate'];
			$article['adddate'] = $data[$k]['postdate'];
			$article['image'] = $data[$k]['image'];
			$article['limage'] = $data[$k]['image'];
			$article['simage'] = $data[$k]['simage'];
			$article['intro'] = $data[$k]['intro'];
			$attachid = $this->db->add ($article);
			if($attachid){
				echo '<br>ͬ����ɣ�'.$article['articlename'];
			}else{
				echo '<br>ͬ��ʧ�ܣ�'.$article['articlename'];
			}
		}
		echo '<br>------------------jieqi_manage_apiarticle�������-------------------';
	}
	//jieqi_manage_apisite
	private function sync_apisite(){
		echo '<br>------------------��ʼͬ��jieqi_manage_apisite-------------------';
		$this->db->init('apisite', 'sid', 'manage');
		$this->db->setCriteria();
		$this->db->criteria->setSort('sid');
		$this->db->queryObjects();
		//����ԭʼ����
		$data = array();
		while($v = $this->db->getObject()){
			$row = array();
			foreach($v->getVars() as $k=>$v){
				$row[$k] = 	$v['value'];
			}
			$data[] = $row;
		}
		//jieqi_pooling_channel
		$this->db->init('channel', 'channelid', 'pooling');
		$map = array();
		foreach($data as $k=>$v){
			$channel = array();
			// 			$channel['channelid'] = $data[$k]['sid'];
			$channel['channelname'] = $data[$k]['sitename'];
			$channel['type'] = 1;//0����1��ȡ
			$channel['url'] = $data[$k]['siteurl'];
			$channel['setting'] = $data[$k]['setting'];
			$channel['statu'] = $data[$k]['statu'];
			$channel['listorder'] = $data[$k]['listorder'];
			$channel['editdate'] = $data[$k]['editdate'];
			$channel['postdate'] = $data[$k]['postdate'];
			//description ʹ�� setting�еı�ע
			eval('$setting = '.$channel['setting'].';');//�ַ���ת����
			if($setting['beizhu']){
				$channel['description'] = $setting['beizhu'];
			}
			$attachid = $this->db->add ($channel);
			if($attachid){
				$map[$data[$k]['sid']] = $attachid;
				echo '<br>ͬ����ɣ�'.$channel['channelname'].'��ԭid='.$data[$k]['sid'].'��id='.$attachid;
			}else{
				echo '<br>ͬ��ʧ�ܣ�'.$channel['channelname'];
			}
		}
		echo '<br>------------------jieqi_manage_apisite�������-------------------';
		return $map;
	}
	//jieqi_manage_outarticle
	private function sync_outarticle($map){
		echo '<br>----------------��ʼͬ��jieqi_manage_outarticle------------------------';
		$this->db->init('outarticle ', 'id', 'manage');
		$this->db->setCriteria();
		$this->db->criteria->setSort('id');
		$this->db->queryObjects();
		//����ԭʼ����
		$data = array();
		while($v = $this->db->getObject()){
			$row = array();
			foreach($v->getVars() as $k=>$v){
				$row[$k] = 	$v['value'];
			}
			$data[] = $row;
		}

		foreach($data as $k=>$v){
			$article = array();
			if(!empty($map) && !empty($map[$data[$k]['sid']])){
				$article['channelid'] = $map[$data[$k]['sid']];//����IDʹ����ID
			}else {
				echo 'error';
				exit;
			}
			$article['articlename'] = $data[$k]['articlename'];
			$article['articleid'] = $data[$k]['articleid'];
			$article['lastvolumeid'] = $data[$k]['lastvolumeid'];
			$article['lastvolume'] = $data[$k]['lastvolume'];
			//lastchapteridʹ���µ�ID
			if($data[$k]['lastchapter'] && $data[$k]['lastchapterid']){
				if(is_numeric($data[$k]['lastchapterid'])){
					$this->db->init('chapter', 'chapterid', 'article');
					$chapter = $this->db->get($data[$k]['lastchapterid']);
				}elseif(strtolower(substr($data[$k]['lastchapterid'],0,1)) == 'v'){
					$cid = substr($data[$k]['lastchapterid'],1);
// 					$this->db->init('ochapter ', 'ochapterid', 'obook');
// 					$ochapter = $this->db->get($cid);
// 					if($ochapter){
						//����Ӧ�����articleid��vchapterid��ѯ�µ�chapter
						//���ݲ�����ʱ���articleid��chaptername����chapter��ochapterͬ������Ҫ������
						$chapters = $this->db->selectsql ( 'select * from ' . jieqi_dbprefix ( "article_chapter" ) . " where vchapterid=" .$cid. " and articleid=" . $article ['articleid'] );
						if(count($chapters) == 1){
							$chapter = $chapters[0];
						}else {
							echo 'û���ҵ�'.$article['articlename'].'�����µ��½ڣ�'.$cid;
// 							$chapters = $this->db->selectsql ( 'select * from ' . jieqi_dbprefix ( "article_chapter" ) . " where chaptername='" . trim($ochapter['chaptername'],'��') . "' and articleid=" . $article ['articleid']);
// 							if(count($chapters) == 1){
// 								$chapter = $chapters[0];
// 							}else{
// 								echo $data[$k]['id'].'chapter error'.'select * from ' . jieqi_dbprefix ( "article_chapter" ) . " where chaptername='" . $ochapter['chaptername'] . "' and articleid=" . $article ['articleid'];
// 							}
						}
// 					}else{
// 						echo 'ochapter del';
// 					}
				}
				if(!empty($chapter) && $chapter['articleid'] == $article['articleid']){
					$article['lastchapterid'] = $chapter['chapterid'];
					$article['lastchapter'] = $chapter['chaptername'];
				}
			}else{
				$article['lastchapterid'] = 0;
				$article['lastchapter'] = '';
			}
			$article['outchapters'] = $data[$k]['outchapters'];
			$article['fullflag'] = $data[$k]['fullflag'];
			$article['pushflag'] = $data[$k]['statu'];
			$article['lastdate'] = $data[$k]['lastupdate'];
			$article['adddate'] = $data[$k]['postdate'];
			$article['image'] = $data[$k]['image'];
// 			$article['limage'] = $data[$k]['image'];
// 			$article['simage'] = $data[$k]['simage'];
			$article['intro'] = $data[$k]['intro'];
			//jieqi_article_channel
			$this->db->init('article', 'paid', 'pooling');
			$attachid = $this->db->add ($article);
			if($attachid){
				echo '<br>ͬ����ɣ�'.$article['articlename'];
			}else{
				echo '<br>ͬ��ʧ�ܣ�'.$article['articlename'];
			}
		}
		echo '<br>----------------jieqi_manage_outarticle�������------------------------';
		//���ݳ�����
	}
	//jieqi_manage_outapi
	private function sync_outapi(){
		echo '<br>---------------��ʼͬ��jieqi_manage_outapi����---------------------';
		$this->db->init('outapi', 'sid', 'manage');
		$this->db->setCriteria();
		$this->db->criteria->setSort('sid');
		$this->db->queryObjects();
		//����ԭʼ����
		$data = array();
		while($v = $this->db->getObject()){
			$row = array();
			foreach($v->getVars() as $k=>$v){
				$row[$k] = 	$v['value'];
			}
			$data[] = $row;
		}
		//jieqi_pooling_channel
		$this->db->init('channel', 'channelid', 'pooling');
		$map = array();
		foreach($data as $k=>$v){
			$channel = array();
// 			$channel['channelid'] = $data[$k]['sid'];
			$channel['channelname'] = $data[$k]['sitename'];
			$channel['type'] = 0;//0����1��ȡ
			$channel['url'] = $data[$k]['siteurl'];
			$channel['setting'] = $data[$k]['setting'];
			$channel['statu'] = $data[$k]['statu'];
			$channel['listorder'] = $data[$k]['listorder'];
			$channel['editdate'] = $data[$k]['editdate'];
			$channel['postdate'] = $data[$k]['postdate'];
			//description ʹ�� setting�еı�ע
			eval('$setting = '.$channel['setting'].';');//�ַ���ת����
			if($setting['beizhu']){
				$channel['description'] = $setting['beizhu'];
			}
			$attachid = $this->db->add ($channel);
			if($attachid){
				$map[$data[$k]['sid']] = $attachid;
				echo '<br>ͬ����ɣ�'.$channel['channelname'].'��ԭid='.$data[$k]['sid'].'��id='.$attachid;
			}else{
				echo '<br>ͬ��ʧ�ܣ�'.$channel['channelname'];
			}
		}
		echo '<br>---------------jieqi_manage_outapi�������---------------';
		return $map;
	}
	/**
	 * ����isvip=1 saleprice=0���½�
	 *
	 * 2014-7-16 ����11:14:45
	 */
	public function handleChapter(){
		$articleLib =  $this->load('article','article');
		//��ѯ���� isvip=1 size>0 saleprice=0 chaptertype=0���½�
		$this->db->init('chapter', 'chapterid', 'article');
		$this->db->setCriteria ( new Criteria ( 'isvip', 1 ) );
		$this->db->criteria->add ( new Criteria ( 'size', 0 ,'>') );
		$this->db->criteria->add ( new Criteria ( 'saleprice', 0) );
		$this->db->criteria->add ( new Criteria ( 'chaptertype', 0 ) );
		$this->db->queryObjects ();
		$i = 0;
		$articleLib->jieqiConfigs ['article'] ['wordsperegold'] = ceil ( $articleLib->jieqiConfigs ['article'] ['wordsperegold'] ) * 2; // 2������
		while($chapter = $this->db->getObject()){
			$i++;
			$saleprice = 0;
			$size = $chapter->getVar('size');
			if ($articleLib->jieqiConfigs ['article'] ['priceround'] == 1) {
				$saleprice = floor ( $size / $articleLib->jieqiConfigs ['article'] ['wordsperegold'] ); // �������룬ȡ����
			} elseif ($this->jieqiConfigs ['article'] ['priceround'] == 2) {
				$saleprice = ceil ( $size / $articleLib->jieqiConfigs ['article'] ['wordsperegold'] ); // �������룬ȡ����
			} else {
				$saleprice = round ( $size / $articleLib->jieqiConfigs ['article'] ['wordsperegold'] ); // ��������
			}
			if(!$saleprice) $saleprice = 1;
			$this->db->edit($chapter->getVar('chapterid'),array('saleprice'=>$saleprice));
			echo $i.'��'.'size��'.$size.'��saleprice��'.$saleprice.'<br/>';
		}
		echo '....end';
	}
}
?>
