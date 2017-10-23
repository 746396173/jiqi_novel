<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/icollect.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/baseCollect.php');
// include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * ԭ�����ɼ��ӿ�ʵ����
 * @author chengyuan  2014-8-21
 *
 */
class MyYcsd extends baseCollect implements iCollect {
	/**
	 *	��ȡ�ɼ������б�Url
	 * @return string
	 * 2014-9-16 ����1:58:58
	 */
	protected  function getBookListUrl(){
		return 'api.ycsd.cn/interface/shuhai/booklist/0';
	}
	/**
	 * ��ȡ�ɼ�������ϢUrl
	 * @return string
	 * 2014-9-16 ����1:58:58
	 */
	protected  function getBookInfoUrl($bookId){
		return 'api.ycsd.cn/interface/shuhai/book/'.$bookId;
	}
	
	public function collectList($cid,$page){
		$data = array();
		if(!$cid){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		$this->db->init( 'channel', 'channelid', 'pooling' );
		$channelLib = $this->load('channel', 'pooling');//����channel�Զ�����
		if(!$channel = $channelLib->get($cid,true)) $this->printfail(LANG_ERROR_PARAMETER);
		$rdata = $this->parseXmlToArray($this->getBookListUrl());
		$row = array();
		//һ������item=array���Ƕ�������itme=array('key'=>array())
		$items =$rdata['books']['book'];
		if(!array_key_exists(0,$items)){
			//һ���������⴦��
			$temp = $items;
			$items = array($temp);
		}
		foreach ( $items as $item ){
			$article = $this->simplePackingArticle($item,$channel);
			$row[$article['articleid']] = $article;
		}
		$data['rows'] = $row;
		$data['channel'] = $channel;
		return $data;
	}
	public function simplePackingArticle($item,$channel){
		$article = array();
		$article['articleid'] = $item['id']['value'];
		$article['articlename'] = trim($item['booktitle']['value']);
		$article['lastupdate'] = $item['updatetime']['value'];
		return $article;
	}
	/**
	 * ��ȡ�����ɼ��������б�����ͨ��aidsָ���������¡�
	 * @param unknown $cid
	 * @param unknown $page ��ʱ��֧��ҳ��
	 * @param unknown $aids ָ�����������array(123,345,678);
	 * 2014-8-19 ����1:52:02
	 */
	public function articleList($cid,$page,$aids=array()){
		$data = array();
		if(!$cid){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		$this->db->init( 'channel', 'channelid', 'pooling' );
		$channelLib = $this->load('channel', 'pooling');//����channel�Զ�����
		if(!$channel = $channelLib->get($cid,true)) $this->printfail(LANG_ERROR_PARAMETER);
		$rdata = $this->parseXmlToArray($this->getBookListUrl());
		$row = array();
		//һ������item=array���Ƕ�������itme=array('key'=>array())
		$items =$rdata['books']['book'];
		if(!array_key_exists(0,$items)){
			//һ���������⴦��
			$temp = $items;
			$items = array($temp);
		}
		if(is_array($aids) && !empty($aids)){
			$ct = count($aids);
			$t = 0;
			foreach ( $items as $item ){
				if(in_array($item['id']['value'], $aids)){
					$t++;
					//��ȡ�鼮��Ϣ
					$data = $this->parseXmlToArray($this->getBookInfoUrl($item['id']['value']));
					$bookinfo = $data['book'];
					$bookinfo['updatetime'] = array('value'=>$item['updatetime']['value']);
					$article = $this->packingArticle($bookinfo,$channel);
					$row[$article['articleid']] = $article;
					if($t == $ct){
						break;
					}
				}
			}
		}else{
			foreach ( $items as $item ){
				//��ȡ�鼮��Ϣ
				$data = $this->parseXmlToArray($this->getBookInfoUrl($item['id']['value']));
				$bookinfo = $data['book'];
				$bookinfo['updatetime'] = array('value'=>$item['updatetime']['value']);
				$article = $this->packingArticle($bookinfo,$channel);
				$row[$article['articleid']] = $article;
			}
		}
		$data['rows'] = $row;
		$data['channel'] = $channel;
		return $data;
	}
	/**
	 * ʵ�ֽӿڣ���д���෽��
	 * @param unknown $item
	 * @param unknown $channel
	 * @return Ambigous <multitype:NULL string number Ambigous <NULL, string, number> , unknown>
	 * 2014-8-22 ����11:36:58
	 */
	public function packingArticle($item,$channel,$loadLocalArticle = true){
		$article = array();
		$article['articleid'] = $item['id']['value'];
		$article['articlename'] = trim($item['title']['value']);
		$article['intro'] = $item['summary']['value'];
		$article['author'] = $item['author']['value'];
		$article['sort'] = $item['category']['value'];
		//ת����ʱ���ᣬͳһ��ʽ
		$article['lastupdate'] = $item['updatetime']['value'];
// 		if(strchr($article['lastupdate'], '/') && $article['lastupdate']){
// 			$article['lastupdate'] = strtotime($article['lastupdate']);
// 		}
		$article['postdate'] = $article['lastupdate'];
// 		if(strchr($article['postdate'], '/') && $article['postdate']){
// 			$article['postdate'] = strtotime($article['postdate']);
// 		}
		$article['isvip'] = $item['isVip']['value'];
		$article['fullflag'] = $item['isFull']['value'];
		$article['size'] = $item['size']['value'];
		$article['articlelpic'] = $item['cover']['value'];
		$article['articlespic'] = $item['cover']['value'];
		$article['chaptersurl'] = $item['url']['value'];

		$article['keywords'] = $item['tag']['value'];
		$article['agent'] = '';
		$article['authorid'] = 0;
		$article['permission'] = 1;//��Ȩ��Ʒ
		$article['firstflag'] = $channel['setting']['getdata']['firstflag'];
		$article['sortid'] = $this->getLocalSortId($item['sort']['value'],$channel);//���¼���ͱ�վ�Ķ�Ӧ��ϵ
		$article['siteid'] = $this->getSiteIdBySortId($article['sortid']);
		$article['notice'] = $item['role']['value'];
		$article['articletype'] = $article['isvip'];//1=>vip
		$article['display'] = 1;//��Ҫ���
		//�Ƿ��Ѿ���⣬����+�׷�״̬ Ψһ����
		if($loadLocalArticle){
			$article['new'] = 1;
			$mateArticle = $this->isExists($article['articleid'],$channel['channelid']);
			if(!empty($mateArticle)){
				$article['new'] = 0;
				$article['mappingArticle'] = $mateArticle;
			}
		}
		return $article;
	}
	/**
	 * ԭ���������ϵ
	 * @see iCollect::getSortMapping()
	 */
// 	public function getSortMapping(){
// 		//todo ��ȫ�����Ӧ��ϵ
// 		return array(
// 				'��������'=>'����',
// 				'��ѪУ԰'=>'����',
// 				'��������'=>'����',
// 				'������ʷ'=>'��ʷ',
// 				'ְ������'=>'����',
// 				'��Ϸ����'=>'����',
// 				'������'=>'�ֲ�'
// 			);
// 	}
	/* (non-PHPdoc)
	 * @see iCollect::getArticleUrl()
	*/
	public function parseChapters($url,$lastchapterid=0) {
		$rdata = $this->parseXmlToArray($url);
		$items =$rdata['chapters']['chapter'];
		if(!array_key_exists(0,$items)){
			$temp = $items;
			$items = array($temp);
		}
		if(is_numeric($lastchapterid) && $lastchapterid > 0){
			//����λ
			for ($i = count($items)-1; $i >= 0; $i--) {
				if($lastchapterid == $items[$i]['id']['value']){
					return array_slice($items,$i);
				}
			}
			// 			foreach ($items as $key => $value) {
			// 				if($lastchapterid == $value['cid']['value']){
			// 					return array_slice($items,$key+1);
			// 				}
			// 			}
			return array();
		}
		return $items;
	}

	/**
	 * ��д��װ�½ڣ���װ�ĸ�ʽ��ο�my_article��saveChatper����
	 * @param unknown $item
	 * @return multitype:NULL number string
	 * 2014-8-22 ����4:46:13
	 */
	public function packingChapter($item){
		$chapter = array();
		$chapter['cid'] = $item['id']['value'];
		$chapter['chaptername'] = $item['title']['value'];
		$chapter['typeset'] = 1;//�Զ��Ű�
		$chapter['chaptertype'] = $item['isVol']['value'];
		// 		$chapter['fullflag'] = $item['']['value'];
		$chapter['manual'] = '';
		$chapter['volumeid'] = '';
		$chapter['isvip'] = $item['isVip']['value'];
		$chapter['postdate'] = $item['updatetime']['value']?$item['updatetime']['value']:JIEQI_NOW_TIME;
// 		if(strchr($chapter['postdate'], '-')){
// 			$chapter['postdate'] = strtotime($chapter['postdate']);
// 		}
		$chapter['saleprice'] = $item['saleprice']['value'];
		$chapter['chaptercontent'] = '';
		if($item['url']['value']){
			$rdata = $this->parseXmlToArray($item['url']['value']);
			$chapter['chaptercontent'] = $rdata['content']['value'];
		}
		return $chapter;
	}
}
?>