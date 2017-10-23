<?php
/**
 * articleģ��
 * @author chengyuan  2014-4-4
 *
 */
class articleModel extends Model {
	/**
	 * ��ǰ��¼������û�д�������
	 */
	function createArticle(){
		$bool = 0;
		$auth = $this->getAuth();
		$articleLib =  $this->load('article','article');
		$data =  $articleLib->articleByAuthorid($auth['uid']);
		if(!empty($data)){
			$bool = 1;
		}
		return $bool;
	}

	/**
	 * ����������ͼ��Դ
	 * @param unknown $param
	 * @return multitype:NULL
	 */
	function step3($param){
		if(!empty($param['aid']) && !empty($param['cid'])){
			$data = array();
			$articleLib =  $this->load('article',false);
			$article = $articleLib->isExists($param['aid']);
			$data['article'] = $articleLib->article_vars($article);
			$this->db->init ( 'chapter', 'chapterid', 'article' );
			$chapter = $this->db->get($param['cid']);
			$data['firstchaptername'] = $chapter['chaptername'];
			$data['firstchaptersize'] = jieqi_strlen ( $chapter['chaptername'] );
			return $data;
		}else{
			$this->printfail(LANG_DO_FAILURE);
		}
	}
	/**
	 * ����Ϊ����
	 * @param unknown $param
	 */
	function applyWriter($param){
		//��Ʒ��������
		$url = $this->geturl ( 'article', 'article', 'SYS=method=masterPage&display=author' );
		$articleLib = $this->load ( 'article', 'article' );
		if($this->checkpower($articleLib->jieqiPower['article']['newarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true)) {
			$this->printfail(sprintf($articleLib->jieqiLang['article']['has_been_writer'],$url,$url));
		}
		$applyText = trim($param['simpletext']);
		if(empty($applyText) || strlen($applyText) == 0){
			$this->printfail($articleLib->jieqiLang['article']['need_simple_chapter']);
		}
		$bool = $articleLib->saveSimpleChapter($applyText);
		if($bool){
			$this->jumppage($url, LANG_DO_SUCCESS, sprintf($articleLib->jieqiLang['article']['apply_writer_success'],$articleLib->jieqiConfigs['article']['writergroup']));
		}
	}
	/**
	 * ɾ��һƪ����
	 *
	 * @param $aid ����id
	 */
	function articleDelete($aid) {
		$articleLib = $this->load ( 'article', 'article' );
		$article = $articleLib->isExists ( $aid );
		// ���Ȩ��
		$articleLib->canedit($article);
		$articleLib->delPower($aid);
		$articleLib->articleDelete ( $article, true );
		$this->jumppage ( $this->geturl ( 'article', 'article', 'SYS=method=masterPage' ), LANG_DO_SUCCESS, sprintf($articleLib->jieqiLang['article']['article_delete_success'],$article['articlename']));
	}
	/**
	 * ������£���ɾ�������ڵ������½�
	 *
	 * @param
	 *        	$aid
	 */
	function articleClean($aid, $jumpurl = '') {
		$articleLib = $this->load ( 'article','article' );
		$article = $articleLib->isExists ( $aid );
		// ���Ȩ��
		$articleLib->canedit($article);
		$articleLib->delPower($aid);
		$articleLib->articleClean ( $article, false );
		$jumpurl = $jumpurl ? $jumpurl : $this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid=' . $aid );
		$this->jumppage ( $jumpurl, LANG_DO_SUCCESS, sprintf($articleLib->jieqiLang['article']['article_clean_success'],$article['articlename']));
	}
	/**
	 * ������ڵ���Դ
	 * @return $data
	 */
	function newArticleView() {
		// �����Զ����� ������������
		$articleLib = $this->load ( 'article', 'article' );
		// ��������Դ�����磺��𣬷���
		$data = $articleLib->getSources();
		//�޸�Ȩ�޵ļ���  manageallarticle > articlemodify
		$data['manageallarticle'] = 0;
		if($this->checkpower ( $articleLib->jieqiPower ['article'] ['manageallarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true )){
			$data['manageallarticle'] = 1;//��߼����Ȩ��
		}
		//ת����Ʒ��Ȩ��
		$data ['allowtrans'] = 0;
		if ($this->checkpower ($articleLib->jieqiPower ['article'] ['transarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true )){
			$data ['allowtrans'] = 1;
		}
		//���������費��Ҫ���
		$data ['display'] = 0;
		if ($this->checkpower ($articleLib->jieqiPower ['article'] ['needcheck'], $this->getUsersStatus (), $this->getUsersGroup (), true )) {
			$data ['display'] = 1;//����Ҫ���
		}
		unset($data['channel']['400']);//���ε�wap����
		//unset($data['channel']['100']);//���ε�mm����
		
		//��ǩ
		//Ĭ���ǵ�ǰ������ģ��ı�ǩ
		$tagMod = $this->model('tag','article');
		$tags = $tagMod->getAllSiteTag();
		$data['tags'] = $tags;
		return $data;
	}
	/**
	 * ���»�����Ϣ�޸���ͼ
	 * @param unknown $param
	 */
	function editArticleView($param){
		$aid = $param['aid'];
		$articleLib = $this->load ( 'article', 'article' );
		$article = $articleLib->isExists($aid);
		$articleLib->canedit($article);//��û���޸�Ȩ�� manageallarticle > authorid|posterid|agentid��û��Ȩ��ֱ����ʾ
		$data = array();
		$auth = $this->getAuth();
		$data = $articleLib->getSources ();
		$data['articles'] = $articleLib->articleByAuthorid($auth['uid']);
		$articleLib->handleManageallarticle($data['articles'],$article);
		foreach ( $data['articles'] as $k => $v ) {
			if(is_array($v) && $v['articleid'] == $aid){
				$data['article'] = $v;
				break;
			}
		}
		//�Ƿ���Ȩ������
		if($data['article']['authorid']>0) $data['article']['authorflag'] = 1;
		else $data['article']['authorflag'] = 0;
		//�޸�Ȩ�޵ļ���  manageallarticle > articlemodify
		$data['manageallarticle'] = 0;
		if($this->checkpower ( $articleLib->jieqiPower ['article'] ['manageallarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true )){
			$data['manageallarticle'] = 1;//��߼����Ȩ��
		}
		$data['transarticle'] = 0;
		if($this->checkpower ( $articleLib->jieqiPower ['article'] ['transarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true )){
			$data['transarticle'] = 1;//��߼����Ȩ��
		}
		unset($data['channel']['400']);//���ε�wap����
		//unset($data['channel']['100']);//���ε�mm����
		
		//��ǩ
		$tagMod = $this->model('tag','article');
		$tags = $tagMod->getAllSiteTag();
		$data['tags'] = $tags;
		return $data;
	}
	/**
	 * �޸����»�����Ϣ
	 * @param unknown $param
	 */
	function editArticle($param) {
	    $data = $param;
		$data ['articleid'] = trim ( $param ['aid'] );
		$data ['articlelpic'] = $_FILES ['articlelpic'];
		$data ['articlespic'] = $_FILES ['articlespic'];
		$data ['tag'] = implode(",",$param ['tag'] );
		//��֤����
		$errtext =  $this->checkArticlename($data ['articleid'], $data ['articlename'],true);
		if(empty($errtext)){
			$errtext =  $this->checkIntro($data ['intro'],true);
		}
		if(empty($errtext)){
			$errtext =  $this->checkCover($data ['articlelpic']);
		}
		if(empty($errtext)){
			$errtext =  $this->checkCover($data ['articlespic']);
		}
		if(!empty($errtext)){
			$this->printfail($errtext);
		}else{
			$articleLib = $this->load ( 'article', 'article' );
			$articleLib->updateArticle ( $data );
			header('Location: '.$this->geturl ( 'article', 'article', 'SYS=method=editArticleView&aid='.$data ['articleid']));
		}
	}
	/**
	 * �������飬���� �û����Ȩ�� �ض���
	 * <br>��Ҫ���->�ڶ������ϴ�����
	 * <br>�����->�½ڹ���
	 */
	function newArticle($param) {
		//�����֤��
		if(empty($param['checkcode']) || strtolower($param['checkcode']) != $_SESSION['jieqiCheckCode']){
			$this->addLang('system', 'users');
			$jieqiLang['system'] = $this->getLang('system');
			$this->printfail($jieqiLang['system']['error_checkcode']);
		}
		$data ['articlename'] = trim ( $param ['articlename'] );
		$data ['author'] = trim ( $param ['author'] );
		$data ['agent'] = trim ( $param ['agent'] );
		$data ['keywords'] = trim ( $param ['keywords'] );
		$data ['tag'] = implode(",",$param ['tag'] );
		$data ['intro'] = trim ( $param ['intro'] );
		$data ['notice'] = trim ( $param ['notice'] );
		$data ['permission'] = trim ( $param ['permission'] );
		$data ['siteid'] = trim ( $param ['siteid'] );
		$data ['sortid'] = trim ( $param ['sortid'] );
		$data ['firstflag'] = 0;
		$data ['authorflag'] = trim ( $param ['authorflag'] );
/*		if(!empty($param ['firstflag'])){
			$data ['firstflag'] = trim ( $param ['firstflag'] );
		}*/
		$data ['articlelpic'] = $_FILES ['articlelpic'];
		$data ['articlespic'] = $_FILES ['articlespic'];
		//��֤����
		$errtext =  $this->checkArticlename('', $data ['articlename'],true);
		if(empty($errtext)){
			$errtext =  $this->checkIntro($data ['intro'],true);
		}
		if(empty($errtext)){
			$errtext =  $this->checkCover($data ['articlelpic']);
		}
		if(empty($errtext)){
			$errtext =  $this->checkCover($data ['articlespic']);
		}
		if(!empty($errtext)){
			$this->printfail($errtext);
		}else{
		    $articleLib = $this->load ( 'article', 'article' );
			$users_handler = $this->getUserObject();
			/*$data ['agent'] = '';
			$data ['agentid'] = 0;
			if (! empty ( $param ['agent'] )){
				if ($agentobj = $users_handler->getByname ( $param ['agent'], 3 )) {
					$data ['agentid'] = $agentobj->getVar ( 'uid' );
					$data ['agent'] = $agentobj->getVar ( 'uname', 'n' );
				}
			}*/
			$auth = $this->getAuth();
			if ($this->checkpower ( $articleLib->jieqiPower ['article'] ['transarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true )) {
				//����ת�ص����
				if (empty ( $data ['author'] ) || ($data ['author'] == $auth ['username'])) {
					$data ['authorid'] = $auth ['uid'];
					$data ['author'] = $auth ['username'];
				} else {
					// ת����Ʒ
					//$data ['author'] = $data ['author'];
					if ($data['authorflag']) {
						$authorobj = $users_handler->getByname ( $data ['author'], 3 );
						if (is_object ( $authorobj )) $newArticle ['authorid'] = $authorobj->getVar ( 'uid' );
						else $data ['authorid'] = 0;
					} else {
						$data ['authorid'] = 0;
					}
				}
				//$data ['permission'] = $data ['permission'];
				if($data ['permission']>= 4) $data ['signdate'] = JIEQI_NOW_TIME;
				//$data ['firstflag'] = $data ['firstflag'] ? $data ['firstflag'] : 0;
				if(!empty($param ['firstflag'])){
					$data ['firstflag'] = trim ( $param ['firstflag'] );
				}
			} else {
				$data ['authorid'] = $auth ['uid'] ;
				$data ['author'] = $auth ['username'];
			}

			$newArticle = $articleLib->newArticle($data);
			if($newArticle ['display'] == 1){
				header('Location: '.$this->geturl ( 'article', 'chapter', 'SYS=method=step2View&aid=' .$newArticle['articleid']));
			}else{
				header('Location: '.$this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid=' . $newArticle['articleid']));
			}
		}
	}
	/**
	 * �ҵ������б�,���ϲ�ѯjieqi_article_statamout����ղأ�������Ƽ�
	 * @param unknown $param
	 * @return multitype:NULL
	 */
	function myArticleList($param){
		$data = array ();
		$auth = $this->getAuth();
		$articleLib = $this->load ( 'article', 'article' );
		$this->db->init ( 'article', 'articleid', 'article' );
		$this->db->setCriteria ();
		$this->db->criteria->add ( new Criteria ( 'authorid', $auth ['uid'], '=' ), 'OR' );
		$this->db->criteria->setTables(jieqi_dbprefix('article_statamout').' s right JOIN '.jieqi_dbprefix('article_article').' a ON s.articleid=a.articleid');
		$this->db->criteria->setFields('a.*, s.goodnum, s.visit, s.vote');
		$this->db->criteria->setSort ( 'postdate' );
		$this->db->criteria->setOrder ( 'desc' );
		$data ['articlerows'] = $this->db->lists ( $articleLib->jieqiConfigs ['article'] ['pagenum'], $param['page'], JIEQI_PAGE_TAG);
		foreach($data ['articlerows'] as $k=>$v){
			$data ['articlerows'][$k] = $articleLib->article_vars($v);
			//����п���û������
			if(!isset($data ['articlerows'][$k]['goodnum'])){
				$data ['articlerows'][$k]['goodnum'] = 0;
			}
			if(!isset($data ['articlerows'][$k]['visit'])){
				$data ['articlerows'][$k]['visit'] = 0;
			}
			if(!isset($data ['articlerows'][$k]['vote'])){
				$data ['articlerows'][$k]['vote'] = 0;
			}
		}
		// ����ҳ����ת
		$data ['url_jumppage'] = $this->db->getPage ($this->getUrl('article','article','evalpage=0','SYS=method=masterPage'));
		return $data;
	}
	/**
	 * �������ɾ�̬�ļ�
	 */
	function repack($aid,$packflag){
		$this->addLang('article','article');
		$articleLib = $this->load ( 'article', false );
		$articleLib->repack($aid,$packflag);
		jieqi_jumppage ( $this->geturl ( 'article', 'article', 'SYS=method=articleManage&aid=' . $aid ), LANG_DO_SUCCESS, $this->getLang('article','article_repack_success'));
	}
	/**
	 * �����Ϣ�б�
	 */
	function bcList($param){
		//header('Content-Type:text/html;charset=gbk');
		$articleLib = $this->load ( 'article', 'article' );

		//Ĭ�ϵ�һҳ
		if(!isset($param['page']) || empty($param['page'])){
			$param['page'] = 1;
		}
		//0 Ĭ�������
		$data = $articleLib->getBcList($param['page']);
		return $data;
	}

	/**
	 * ɾ������ڵ���,�ѷ���
	 * @param unknown $param
	 */
	function bcDel($param){
		$caseid = $param['caseid'];
		$classid = $param['classid'];
		$articleLib = $this->load ( 'article', false );
		$articleLib->baBatchDel($caseid);
		//�ض�����ǩ��ͼ
		$this->jumppage ($this->geturl ( 'article', 'article', 'SYS=method=bcView&classid=' . $classid), LANG_DO_SUCCESS,LANG_DO_SUCCESS);
	}
	/**
	 * �������ɾ������
	 * @param unknown $param
	 */
	function bcHandle($param){
		$articleLib = $this->load ( 'article', 'article' );
		$checkids=$this->arrayToStr($param['checkid']);
		$auth = $this->getAuth();
		$this->db->init('bookcase','caseid','article');
		$this->db->setCriteria(new Criteria('userid', $auth['uid']));
		$this->db->criteria->add(new Criteria('caseid', '('.$checkids.')', 'IN'));
		$this->db->criteria->setFields('articleid');
		$this->db->queryObjects();
		$articleids = array();
		while($v = $this->db->getObject()){
			$articleids[] = intval($v->getVar('articleid'));
		}
		$this->db->init('statlog','statlogid','article');
		$this->db->setCriteria(new Criteria('uid', $auth['uid']));
		$this->db->criteria->add(new Criteria('mid', 'goodnum'));
		$this->db->criteria->add(new Criteria('articleid', '('.implode(',',$articleids).')','IN'));
		$this->db->delete( $this->db->criteria );
		$articleLib->baBatchDel($checkids);
		$this->jumppage ($this->geturl ( JIEQI_MODULE_NAME, 'article', 'SYS=method=bcView'), LANG_DO_SUCCESS,LANG_DO_SUCCESS);
	}
	/**
	 * ��ȡ����������Ϣ
	 *
	 * @param С˵ID $id
	 * @return multitype:NULL string unknown number Ambigous <multitype:, string>
	 */
	function getArticleInfo($id) {

		// �����Զ����� ������������
		$articleLib = $this->load ( 'article', false );
		// ��ȡ�����б�key:sort��������Ȩkey:����Ȩ����key:���׷�״̬key:
		$data = $articleLib->getSources ();
		$this->db->init ( 'article', 'articleid', 'article' );
		$article = $this->db->get ( $id );
	}


	/**
	 * ��ȡ�����б�key:sort��������Ȩkey:����Ȩ����key:���׷�״̬key:
	 *
	 * @return multitype:$data
	 */
	public function getSources() {
		$articleLib = $this->load ( 'article', 'article' );
		$data =  $articleLib->getSources();
		return $data;
	}
	//��¼�� С�����
	//������Ϣ ��Ʒ�б�
	public function userList($params){
		 $jieqiConfigs['article']['pagenum'] = 4;
		 $this->db->init('article','articleid','article');
		 $this->db->setCriteria();
		 $this->db->criteria->add(new Criteria('authorid',$params['uid']));
		$this->db->criteria->add ( new Criteria ( 'display', 0));
		 $this->db->criteria->setSort('lastupdate');	//������ʱ������
		 $this->db->criteria->setOrder('DESC');
		 if (empty($params['page']))
		 {
		 	$params['page'] = 1;
		 }
		 $p='[prepage]<a rel="nofollow" href="javascript:;" onclick="return showProducts(this,\'{$prepage}\',1)" id="'.$params['page'].'">��һҳ</a>[/prepage][pages][pnum]6[/pnum][pnumchar] <em class="b">{$page}</em>[/pnumchar]
[pnumurl]<A href="javascript:;" onclick="return showProducts(this,\'{$pnumurl}\',1)" id="'.$params['page'].'">{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]<a href="javascript:;" onclick="return showProducts(this,\'{$nextpage}\',1)" id="'.$params['page'].'">��һҳ</a>[/nextpage]';
		$data = $this->db->lists($jieqiConfigs['article']['pagenum'], $params['page'],$p);


		 $package = $this->load('article','article');//�������´�����

		 $k=0;
		 foreach($data as $k=>$v)
		 {
		 	$data[$k] = $package->article_vars($v);
			  $k++;
		 }

		 $pageurl = $this->db->getPage($this->getUrl('article','article','method=userlist','evalpage=0','SYS=uid='.$params['uid']));
		 return array(
			 'articlerows'=>$data,
			 'url_jumppage'=>$pageurl
		 );
	}
	//������Ϣ �ղ��б�
	public function userbook($params){
		$jieqiConfigs['article']['pagenum'] = 10;
		$this->db->init('bookcase ','caseid','article');
		$this->db->setCriteria(new Criteria('userid', $params['uid']));
		$this->db->criteria->add ( new Criteria ( 'display', 0));
		$data['nowbookcase'] = $this->db->getCount();
		$this->db->criteria->setTables(jieqi_dbprefix('article_bookcase').' c RIGHT JOIN '.jieqi_dbprefix('article_article').' a ON c.articleid=a.articleid');
		$this->db->criteria->setFields('c.*, a.articleid, a.lastupdate, a.articlename, a.authorid, a.author, a.sortid, a.lastchapterid, a.lastchapter, a.fullflag');
		$this->db->criteria->setSort('a.lastupdate');
		$this->db->criteria->setOrder('DESC');
		 if (empty($params['page']))
		 {
		 	$params['page'] = 1;
		 }
		 $p='[prepage]<a rel="nofollow" href="javascript:;" onclick="return showProducts(this,\'{$prepage}\',1)" id="'.$params['page'].'">��һҳ</a>[/prepage][pages][pnum]6[/pnum][pnumchar] <em class="b">{$page}</em>[/pnumchar]
[pnumurl]<A href="javascript:;" onclick="return showProducts(this,\'{$pnumurl}\',1)" id="'.$params['page'].'">{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]<a href="javascript:;" onclick="return showProducts(this,\'{$nextpage}\',1)" id="'.$params['page'].'">��һҳ</a>[/nextpage]';
		$data = $this->db->lists($jieqiConfigs['article']['pagenum'], $params['page'],$p);

		$package = $this->load('article','article');//�������´�����
		$k=0;
		 foreach($data as $k=>$v)
		 {
		 	$data[$k] = $package->article_vars($v);
			  $k++;
		 }

		 $pageurl = $this->db->getPage($this->getUrl('article','article','method=userbook','evalpage=0','SYS=uid='.$params['uid']));
		 return array(
			 'articlerows'=>$data,
			 'url_jumppage'=>$pageurl
		 );
	}
	/**
	 * ͳ�Ƶ����
	 * @param unknown $aid
	 */
	public function statisticsVisit($aid){
		if(isset($aid) && !empty($aid) && is_numeric($aid)){
			$articleLib = $this->load ( 'article', 'article' );
			$article = $articleLib->isExists($aid);
			$articleLib->statisticsVisit($article);
		}

	}
	/**
	 * �첽�������¶�Ӧ�ľ�̬�ļ�
	 */
	public function synchronousMakePack($param){
		$articleLib = $this->load ( 'article', 'article' );
		//��������ת�����Ѿ�Ϊ�첽��ת��url�ĺϷ�����֤ͨ��������˵����url�Ѿ�Ϊ�첽������
		//�����Կ
		if(empty($param['key'])) exit('no key');
		elseif($param['key'] != md5(JIEQI_DB_USER.JIEQI_DB_PASS.JIEQI_DB_NAME.JIEQI_SITE_KEY)) exit();

		//���������
		if(!is_numeric($param['aid'])) exit;
		$aid = intval($param['aid']);
		//��������Ĳ���Ϊ��1
		$articleLib->article_repack($aid,$param,1);
	}
	/**
	 * ��֤�ϴ��ķ����ļ���������֤��������ؿ�����֤ͨ��
	 * @param unknown $cfile
	 */
	function checkCover($cfile){
		$errtext = "";
		if (!empty($cfile) && is_array($cfile)){
			$articleLib = $this->load ( 'article', 'article' );
			// ������
			$typeary = explode ( ' ', trim ( $articleLib->jieqiConfigs ['article'] ['imagetype'] ) );
			foreach ( $typeary as $k => $v ) {
				if (substr ( $v, 0, 1 ) != '.')
					$typeary [$k] = '.' . $typeary [$k];
			}
			if (! empty ( $cfile['name'] )) {
				$simage_postfix = strrchr ( trim ( strtolower ( $cfile['name'] ) ), "." );
				if (eregi ( "\.(gif|jpg|jpeg|png|bmp)$", $cfile['name'] )) {
					if (! in_array ( $simage_postfix, $typeary ))
						$errtext .= sprintf ( $articleLib->jieqiLang ['article'] ['simage_type_error'], $articleLib->jieqiConfigs ['article'] ['imagetype'] ) . '<br />';
				} else {
					$errtext .= sprintf ( $articleLib->jieqiLang ['article'] ['simage_not_image'], $cfile['name'] ) . '<br />';
				}
				if (! empty ( $errtext ))
					jieqi_delfile ( $cfile['tmp_name'] );
			}
		}
		return $errtext;
	}
	/**
	 * ajax ��֤���� ���� �Ƿ���Ч
	 * @param unknown $intro
	 */
	function checkAuthor($author){
		$articleLib = $this->load ( 'article', 'article' );
		$author = trim($author);
		$retmsg = array();
		if(!empty($author)){
			if ($this->checkpower ( $articleLib->jieqiPower ['article'] ['transarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true )) {
				$auth = $this->getAuth();
				//����ת�ص����
				if ($author == $auth ['username']) {
					$retmsg['ok'] = $articleLib->jieqiLang ['article'] ['author_myself'] ;
				} else {
					// ת����Ʒ
					$users_handler = $this->getUserObject();
					$authorobj = $users_handler->getByname ( $author, 3 );
					if (is_object ( $authorobj ))
						$retmsg['ok'] = '';
					else
						$retmsg['error'] = $articleLib->jieqiLang ['article'] ['author_not_exists'] ;
				}
			} else {
				$retmsg['error'] = $articleLib->jieqiLang ['article'] ['author_not_trans'] ;
			}
			exit($this->json_encode($retmsg));
		}
	}

	/**
	 * ajax ��֤������/����Ա ���� �Ƿ���Ч
	 * @param unknown $intro
	 */
	function checkAgent($agent){
		$articleLib = $this->load ( 'article', 'article' );
		$agent = trim($agent);
		$retmsg = array();

		$users_handler = $this->getUserObject();
		if (! empty ($agent))
			$agentobj = $users_handler->getByname ($agent, 3 );
		if (is_object ( $agentobj )) {
			$retmsg['ok'] = '';
		}else{
			$retmsg['error'] = $articleLib->jieqiLang ['article'] ['agent_not_exists'] ;
		}
		exit($this->json_encode($retmsg));
	}
	/**
	 * ��֤intro�Ƿ���Υ������
	 * @param unknown $intro
	 * @param string $isreturn
	 */
	function checkIntro($intro,$isreturn = false){
		include_once (JIEQI_ROOT_PATH . '/lib/text/textfunction.php');
		$articleLib = $this->load ( 'article', 'article' );
		$intro = trim($intro);
		$retmsg = array();
		$errtext = '';
		// ������ͼ����û��Υ������
		if (!empty( $articleLib->jieqiConfigs ['system'] ['postdenywords'] )) {
			include_once (JIEQI_ROOT_PATH . '/include/checker.php');
			$checker = new JieqiChecker ();
			$matchwords1 = $checker->deny_words ($intro, $articleLib->jieqiConfigs ['system'] ['postdenywords'], true );
			if (is_array ( $matchwords1 )) {
				if (! isset ( $articleLib->jieqiLang ['system'] ['post'] )){
					$this->addLang('system','post');
					$articleLib->jieqiLang['system'] =  $this->getLang('system');
				}
				$errtext .= sprintf ( $articleLib->jieqiLang ['system'] ['post_words_deny'], implode ( ' ', jieqi_funtoarray ( 'htmlspecialchars', $matchwords1 ) ) );
			}
		}

		if($errtext){
			$retmsg['error'] = $errtext;
		}else  $retmsg['ok'] = '';
		if(!$isreturn) exit($this->json_encode($retmsg));
		else return $errtext;
	}
	/**
	 * ��֤articlename�ĺϷ��ԣ���֤�ĸ���Ŀ���ǿգ�Ӱ����ҳ���ַ���Υ�����ʣ������Ƿ��Ѿ�ռ�á�
	 * @param unknown $aid		�ɿ�,aid��֤��ͬ����ʱ�����Թ��˵�aid
	 * @param unknown $string   ��Ҫ��֤���ַ���
	 * @param string $isreturn  �Ƿ񷵻���֤��Ϣ��Ĭ��false?�json�����֤�����true������֤���
	 * @return string  ���ݸ�ʽ��array('error'=>'info')|array('ok'=>'info');
	 */
	function checkArticlename($aid,$string,$isreturn = false){
		include_once (JIEQI_ROOT_PATH . '/lib/text/textfunction.php');
		$articleLib = $this->load ( 'article', 'article' );
		$string = trim($string);
		$retmsg = array();
		$errtext = '';
		// ������
		if (strlen ($string) == 0)
			$errtext .= $articleLib->jieqiLang ['article'] ['need_article_title'] . '<br />';
		elseif (!jieqi_safestring ($string))
			$errtext .= $articleLib->jieqiLang ['article'] ['limit_article_title'] . '<br />';
		if(!empty( $articleLib->jieqiConfigs ['system'] ['postdenywords'] )){// ������ͼ����û��Υ������
			include_once (JIEQI_ROOT_PATH . '/include/checker.php');
			$checker = new JieqiChecker ();
			$matchwords1 = $checker->deny_words ($string, $articleLib->jieqiConfigs ['system'] ['postdenywords'], true );
			if (is_array($matchwords1 )) {
				if (! isset ( $articleLib->jieqiLang ['system'] ['post'] )){
					$this->addLang('system','post');
					$articleLib->jieqiLang['system'] =  $this->getLang('system');
				}
				$errtext .= sprintf ( $articleLib->jieqiLang ['system'] ['post_words_deny'], implode ( ' ', jieqi_funtoarray ( 'htmlspecialchars', $matchwords1 ) ) );
			}
		}
		if($articleLib->jieqiConfigs ['article'] ['samearticlename'] != 1) {
			$this->db->init ( 'article', 'articleid', 'article' );
			$this->db->setCriteria ( new Criteria ( 'articlename', $string) );
			if(!empty($aid) && $aid>0){
				$this->db->criteria->add ( new Criteria ( 'articleid', $aid, '!=' ));
			}
			if ($this->db->getCount () > 0) {
				$errtext .= sprintf ( $articleLib->jieqiLang ['article'] ['articletitle_has_exists'], jieqi_htmlstr ($string) ) ;
			}
		}
		if($errtext){
			$retmsg['error'] = $errtext;
		}else  $retmsg['ok'] = '';
		if(!$isreturn) exit($this->json_encode($retmsg));
		else return $errtext;
	}

	/**
	 * ��ʱ����½ڡ������
	 * @param unknown $param
	 * 2014-7-4 ����7:15:22
	 */
	function regularAudits($param){
		if(empty($param['key'])) exit('no key');
		elseif($param['key'] != md5(JIEQI_DB_USER.JIEQI_DB_PASS.JIEQI_DB_NAME.JIEQI_SITE_KEY)) exit();
		$this->db->init ( 'chapter', 'chapterid', 'article' );
		$this->db->setCriteria ( new Criteria ( 'display', 2) );
		$this->db->criteria->add ( new Criteria ( 'postdate', JIEQI_NOW_TIME, '<=' ));
		$this->db->criteria->setGroupby ('articleid');
		$this->db->queryObjects ();
		$aids = array();
		while($v = $this->db->getObject()){
			$aids[] = $v->getVar ( 'articleid', 'n' );
		}
		if(!empty($aids)){
			//�������״̬2-0
			$this->db->updatetable ( 'article_chapter', array (
					'display' => '0'
			), 'display = 2 and postdate <= ' . JIEQI_NOW_TIME );
			$articleLib = $this->load ( 'article', 'article' );
			foreach ( $aids as $k => $v ) {
				$articleLib->article_repack($v, array('makeopf'=>1), 1);
			}
		}
	}

	/**
	 * ��Ϧ����
	 * @param unknown $param
	 * 2014-7-30 ����5:12:15
	 */
	function qixi($param){
		$fid = $param['fid'];
		$sid = $param['sid'];
		$auth = $this->getAuth();
		$sql = 'SELECT a.articleid,a.articlename,SUM(c.saleprice) AS totalprice FROM '.jieqi_dbprefix("article_article").' a right join '.jieqi_dbprefix("article_chapter").' c on a.articleid = c.articleid where a.articleid in ('.$fid.','.$sid.')  group by articleid';
		$setarticle = $this->db->selectsql ($sql);
		$retmsg = array();
		$retmsg['uid'] = $auth['uid'];
		$retmsg['uname'] = $auth['useruname'];
		$retmsg['egold'] = $auth['egolds'];

		$retmsg['fid'] = $setarticle[0]['articleid'];
		$retmsg['fname'] = $setarticle[0]['articlename'];
		$retmsg['ftotalprice'] = $setarticle[0]['totalprice'];

		$retmsg['sid'] = $setarticle[1]['articleid'];
		$retmsg['sname'] = $setarticle[1]['articlename'];
		$retmsg['stotalprice'] = $setarticle[1]['totalprice'];

		$retmsg['totalprice'] = $setarticle[0]['totalprice']+$setarticle[1]['totalprice'];
		$retmsg['saletotalprice'] = floor(($setarticle[0]['totalprice']+$setarticle[1]['totalprice'])*0.77);

		exit($this->json_encode($retmsg));
	}
	function qixireg($param){
		//ͳ��2014-8-1 00:00:00-2014-8-10 23:59:59ע����û�
		//ÿ���û�����77�麣�ң�����վ����֪ͨ
		$sql = 'SELECT *FROM '.jieqi_dbprefix("system_users").' WHERE regdate between 1406822400 and 1407686399 ORDER BY regdate';
		$users = $this->db->selectsql ($sql);
		echo '<table border=1>';
		echo '<tr><th colspan=7>ͳ��2014-8-1 00:00:00-2014-8-10 23:59:59ע����û�������'.count($users).'</th></tr>';
		echo '<tr><th>��</th><th>ID</th><th>�û�����</th><th>ע��ʱ��</th><th>�麣��</th><th>���º���麣��</th><th>վ����֪ͨ</th></tr>';
		$i = 0;
		$users_handler =  $this->getUserObject();//��ѯ�û��Ƿ����
		$this->db->init('message','messageid','system');
		foreach ( $users as $k => $v ) {
			$i++;
			$temp = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
			$users_handler->income($v['uid'],77);//�����麣��
			$user = $users_handler->get($v['uid']);//���º���û���Ϣ
			//����վ����
			$newMessage = array();
			$newMessage['siteid']= JIEQI_SITE_ID;
			$newMessage['postdate']= JIEQI_NOW_TIME;
			$newMessage['fromid']= 6;
			$newMessage['fromname']= 'ϵͳ����Ա';
			$newMessage['toid']= $v['uid'];
			$newMessage['toname']= $v['uname'];
			$newMessage['title']= '��Ϧ�-ע���û�';
			$newMessage['content']= '������Ϧ���麣����������ڻ�ڼ��� ע�� �麣���˻����Ա��л������77���麣�ң�����ա�';
			$newMessage['messagetype']= 0;
			$newMessage['isread']= 0;
			$newMessage['fromdel']= 0;
			$newMessage['todel']= 0;
			$newMessage['enablebbcode']= 1;
			$newMessage['enablehtml']= 0;
			$newMessage['enablesmilies']= 1;
			$newMessage['attachsig']=0;
			$newMessage['attachment']= 0;
			if($this->db->add($newMessage))$msg ='���ͳɹ�';
			else $msg = '����ʧ��';
			echo sprintf($temp,$i,$v['uid'],$v['uname'],date('Y-m-d H:i:s',$v['regdate']),$v['egold'],$user->getVar('egold', 'n'),$msg);
		}
		echo '</table>';
	}
	/**
	 * ��Ϧ��½
	 * @param unknown $param
	 * 2014-8-13 ����2:45:47
	 */
	function qixilogin($param){
		//2014-8-1 00:00:00��ǰע����û���2014-8-1 00:00:00-���ڵ�½�����û��������麣��
		//ÿ���û�����77�麣�ң�����վ����֪ͨ
		$sql = 'SELECT * FROM '.jieqi_dbprefix("system_users").' WHERE regdate < 1406822400 and lastlogin >= 1406822400 order by lastlogin';
		$users = $this->db->selectsql ($sql);
		echo '<table border=1>';
		echo '<tr><th colspan=8>ͳ��2014-8-1 00:00:00��ǰע����û�����2014-8-1 00:00:00-'.date('Y-m-d H:i:s',JIEQI_NOW_TIME).'��½���û�,������'.count($users).'</th></tr>';
		echo '<tr><th>��</th><th>ID</th><th>�û�����</th><th>ע��ʱ��</th><th>�ϴε�¼ʱ��</th><th>�麣��</th><th>���º���麣��</th><th>վ����֪ͨ</th></tr>';
		$i = 0;
		$users_handler =  $this->getUserObject();//��ѯ�û��Ƿ����
		$this->db->init('message','messageid','system');
		foreach ( $users as $k => $v ) {
			$i++;
			$temp = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
			$users_handler->income($v['uid'],77);//�����麣��
			$user = $users_handler->get($v['uid']);//���º���û���Ϣ
			//����վ����
			$newMessage = array();
			$newMessage['siteid']= JIEQI_SITE_ID;
			$newMessage['postdate']= JIEQI_NOW_TIME;
			$newMessage['fromid']= 6;
			$newMessage['fromname']= 'ϵͳ����Ա';
			$newMessage['toid']= $v['uid'];
			$newMessage['toname']= $v['uname'];
			$newMessage['title']= '��Ϧ�-��¼�û�';
			$newMessage['content']= '������Ϧ���麣����������ڻ�ڼ��� ��¼ �麣���˻����Ա��л������77���麣�ң�����ա�';
			$newMessage['messagetype']= 0;
			$newMessage['isread']= 0;
			$newMessage['fromdel']= 0;
			$newMessage['todel']= 0;
			$newMessage['enablebbcode']= 1;
			$newMessage['enablehtml']= 0;
			$newMessage['enablesmilies']= 1;
			$newMessage['attachsig']=0;
			$newMessage['attachment']= 0;
			if($this->db->add($newMessage))$msg ='���ͳɹ�';
			else $msg = '����ʧ��';
			echo sprintf($temp,$i,$v['uid'],$v['uname'],date('Y-m-d H:i:s',$v['regdate']),date('Y-m-d H:i:s',$v['lastlogin']),$v['egold'],$user->getVar('egold', 'n'),$msg);
		}
		echo '</table>';
	}

	function qixisale($param){
		$sql = 'SELECT *,(select aa.articlename from jieqi_article_article aa where aa.articleid=s.articleid) as articlename FROM '.jieqi_dbprefix("article_statlog").' s WHERE addtime between 1406822400 and 1407686399 and articleid in (1162,1999,15991,2122,1935,13689,12622,8690,24655,4033,15985,9815,4143,1944,4010,1361,8822,14478,24669,24671) and mid="sale" and chaptername like "%���½�" ORDER BY addtime';
		$stat = $this->db->selectsql ($sql);
		echo '<table border=1>';
		echo '<tr><th colspan=8>ͳ��2014-8-1 00:00:00-2014-8-10 23:59:59��Ϧר�����ۼ�¼</th></tr>';
		echo '<tr><th>��</th><th>ID</th><th>�û�����</th><th>����ʱ��</th><th>���</th><th>����</th></tr>';
		$i = 0;
// 		$users_handler =  $this->getUserObject();//��ѯ�û��Ƿ����
		foreach ( $stat as $k => $v ) {
			$temp = strval($v['stat']);
			if(strchr($temp,'.') === false){
				$i++;
				$temp = "<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>";
				// 			$users_handler->income($v['uid'],77);//�����麣��
				// 			$user = $users_handler->get($v['uid']);//���º���û���Ϣ
				echo sprintf($temp,$i,$v['uid'],$v['username'],date('Y-m-d H:i:s',$v['addtime']),$v['articleid'],$v['articlename']);
			}

		}
		echo '</table>';
	}
	private function out($msg){
		$sapi = php_sapi_name();
		if($sapi == 'cgi-fcgi'){
			echo str_pad($msg,1024*64);
		}else{
			if($this->first_out){
				echo str_repeat(' ',4096);
				$this->first_out = false;
			}
			echo $msg;
		}
		ob_flush();
		flush();
	}
	/**
	 * ����jieqi_article_stat���е��ظ�����
	 */
	function handleStatTable(){
		$this->db->init('stat','statid','article');
		$sql = "SELECT articleid, mid FROM jieqi_article_stat GROUP BY articleid, mid HAVING count( * ) >1";
		$repeatRows = $this->db->selectsql ($sql);//�����ظ��ļ�¼
		if(!$repeatRows)exit('û��������Ҫ����');
		$this->out("�ܹ�".count($repeatRows)."�������ظ���¼��Ҫ����<br>");
		$q=0;
		foreach ( $repeatRows as $k => $repeatRow ) {
			
			$articleid = $repeatRow['articleid'];
			$mid = $repeatRow['mid'];
			
			
			$sql1 = "SELECT * FROM jieqi_article_stat WHERE articleid={$articleid} and mid = '{$mid}'";//ÿ�����ظ���¼
			//�ۼӣ�����һ����ɾ��������
			$articleRows = $this->db->selectsql ($sql1);
			if(!$articleRows)exit('û���ظ���¼��Ҫ����');
			
			$this->out(++$q.',��ʼ������ţ�'.$articleid.',���ͣ�'.$mid.',��'.count($articleRows).'���ظ���¼<br>');
			
			$newStat = $articleRows[0];
			unset($articleRows[0]);
			foreach ( $articleRows as $key => $stat ) {
				$newStat['total'] += $stat['total'];
				$newStat['month'] += $stat['month'];
				$newStat['week'] += $stat['week'];
				$newStat['day'] += $stat['day'];
				$newStat['totalnum'] += $stat['totalnum'];
				$newStat['monthnum'] += $stat['monthnum'];
				$newStat['weeknum'] += $stat['weeknum'];
				$newStat['daynum'] += $stat['daynum'];
				if($stat['lasttime'] > $newStat['lasttime']){
					$newStat['lasttime'] = $stat['lasttime'];
				}
				//ɾ��$stat
				if($this->db->delete ( $stat['statid'] )){
					$this->out('ɾ���ɹ���statid='.$stat['statid'].'<br>');
				}else{
					$this->out('ɾ��ʧ�ܣ�statid='.$stat['statid'].'<br>');
				}
			}
			//����$newStat
			if($this->db->edit ( $newStat['statid'], $newStat )){
				$this->out('���³ɹ���statid='.$newStat['statid'].'<br>');
			}else{
				$this->out('����ʧ�ܣ�statid='.$newStat['statid'].'<br>');
			}
		}
		$this->out('����...');
	}
}

?>