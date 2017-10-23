<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/icollect.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/baseCollect.php');
// include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * api�ɼ�Ĭ�ϵ��Զ�����
 * @author chengyuan
 *
 */
class MyCollectDefault extends baseCollect implements iCollect {
	
	/*
	 * �ɼ��б��������µĻ�����Ϣ����š�����
	 */
	public function collectList($cid,$page){
		$data = array();
		if(!$cid){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		$this->db->init( 'channel', 'channelid', 'pooling' );
		$channelLib = $this->load('channel', 'pooling');//����channel�Զ�����
		if(!$channel = $channelLib->get($cid,true)) $this->printfail(LANG_ERROR_PARAMETER);
		if(!$channel['url']){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		$rdata = $this->parseXmlToArray($channel['url']);
		$row = array();
		//һ������item=array���Ƕ�������itme=array('key'=>array())
		$items =$rdata['document']['items']['item'];
		if(!array_key_exists(0,$items)){
			//һ���������⴦��
			$temp = $items;
			$items = array($temp);
		}
		foreach ( $items as $item ){
			$article = $this->simplePackingArticle($item, $channel);
			$row[$article['articleid']] = $article;
		}
		$data['rows'] = $row;
		$data['channel'] = $channel;
		return $data;
	}
	public function simplePackingArticle($item,$channel){
		return $this->packingArticle($item, $channel,false);
	}
	
	/**
	 * ��ȡ�����ɼ��������б�֧��aidsɸѡ
	 * @param unknown $cid
	 * @param unknown $page ��ʱ��֧��ҳ��
	 * @param unknown $aids ���������
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
		if(!$channel['url']){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		$row = array();
		$rdata = $this->parseXmlToArray($channel['url']);
		//һ������item=array���Ƕ�������itme=array('key'=>array())
		$items =$rdata['document']['items']['item'];
		if(!array_key_exists(0,$items)){
			//һ���������⴦��
			$temp = $items;
			$items = array($temp);
		}
		foreach ( $items as $item ){
			//ɸѡ
			if(!empty($aids) && !in_array($item['bookid']['value'],$aids)){
				continue;
			}
			$data = $this->parseXmlToArray($item['url']['value']);
			$article = $this->packingArticle($data['document']['info'],$channel);
			$row[$article['articleid']] = $article;
			if(!empty($aids) && count($row) == count($aids)){
				break;
			}
		}
		$data['rows'] = $row;
		$data['channel'] = $channel;
		return $data;
	}
	/**
	 * ��װ���¶���
	 * @param unknown $item
	 * @param unknown $channel
	 * @return Ambigous <multitype:NULL string number Ambigous <NULL, string, number> Ambigous <unknown, number, unknown> , unknown>
	 * 2014-8-22 ����11:34:21
	 */
	public function packingArticle($item,$channel,$loadLocalArticle = true){
		$article = array();
		$article['articleid'] = $item['bookid']['value'];//�����������
		$article['articlename'] = trim($item['title']['value']);
		$article['intro'] = $item['comment']['value'];
		$article['author'] = $item['author']['value'];
		$article['sort'] = $item['category']['value'];
		//Ĭ��ʱ����
		//ת����ʱ���ᣬͳһ��ʽ
		$article['lastupdate'] = $item['lastupdate']['value'];
		// 		if(strchr($article['lastupdate'], '-')){
		// 			$article['lastupdate'] = strtotime($article['lastupdate']);
		// 		}
		$article['postdate'] = $item['postdate']['value'];
		// 		if(strchr($article['postdate'], '-')){
		// 			$article['postdate'] = strtotime($article['postdate']);
		// 		}
		// 		$article['lastupdate'] = strtotime($item['lastupdate']['value']);
		// 		$article['postdate'] = strtotime($item['postdate']['value']);
		$article['isvip'] = $item['isvip']['value'];
		$article['fullflag'] = $item['fullflag']['value'];
		$article['size'] = $item['size']['value'];
		$article['articlelpic'] = $item['image_big']['value'];
		$article['articlespic'] = $item['image_small']['value'];
		$article['chaptersurl'] = $item['chaptersurl']['value'];
	
		$article['keywords'] = '';
		$article['agent'] = '';
		$article['authorid'] = 0;
		$article['permission'] = 1;//��Ȩ��Ʒ
		$article['firstflag'] = $channel['setting']['getdata']['firstflag'];
// 		$article['sortid'] = 1;//ȱʡ
		$article['sortid'] = $this->getLocalSortId($item['category']['value'],$channel);
// 		if(is_array($channel['setting']['getdata']['category']) && array_key_exists($item['category']['value'], $channel['setting']['getdata']['category'])){
// 			$article['sortid'] = $channel['setting']['getdata']['category'][$item['category']['value']];//��Ӧ��վ��sortid
// 		}
		$this->addConfig('article','sort');
		$sort = $this->getConfig('article','sort');
		$article['siteid'] = $sort[$article['sortid']]['siteid'];//������������
		$article['notice'] = '';
		$article['articletype'] = $article['isvip'];//1=>vip
		$article['display'] = 1;//��Ҫ���
		if($loadLocalArticle){
			$article['new'] = 1;
			$mappingArticle = $this->isExists($article['articleid'],$channel['channelid']);
			if(!empty($mappingArticle)){
				$article['new'] = 0;
				$article['mappingArticle'] = $mappingArticle;
			}
		}
		return $article;
	}
	//ͨ��ǰ̨�����û�ȡƥ���ϵ
	//'��������'=>'�麣����'
// 	public function getSortMapping(){
// // 		return $this->setting['getdata']['category'];
// 	}
	/* (non-PHPdoc)
	 * @see iCollect::getArticleUrl()
	*/
	public function parseChapters($url,$lastchapterid=0) {
		$rdata = $this->parseXmlToArray($url);
		$items =$rdata['document']['items']['item'];
		if(!array_key_exists(0,$items)){
			$temp = $items;
			$items = array($temp);
		}
		if(is_numeric($lastchapterid) && $lastchapterid > 0){
			//����λ
			for ($i = count($items)-1; $i >= 0; $i--) {
				if($lastchapterid == $items[$i]['cid']['value']){
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
		// TODO Auto-generated method stub
	}
	/**
	 * ��װ�½�
	 * @param unknown $item
	 * @return multitype:NULL number string
	 */
	public function packingChapter($item){
		$chapter = array();
		$chapter['cid'] = $item['cid']['value'];
		$chapter['chaptername'] = $item['chaptername']['value'];
		$chapter['typeset'] = 1;//�Զ��Ű�
		$chapter['chaptertype'] = $item['chaptertype']['value'];
		// 		$chapter['fullflag'] = $item['']['value'];
		$chapter['manual'] = '';
		$chapter['volumeid'] = '';
		$chapter['isvip'] = $item['isvip']['value'];
		//Ĭ�ϵ�ǰʱ��
		$chapter['postdate'] = $item['postdate']['value']?$item['postdate']['value']:JIEQI_NOW_TIME;
		// 		if(strchr($chapter['postdate'], '-')){
		// 			$chapter['postdate'] = strtotime($chapter['postdate']);
		// 		}
		// 		$chapter['saleprice'] = $item['saleprice']['value'];
		$chapter['chaptercontent'] = '';
		if($item['chapterurl']['value']){
			$rdata = $this->parseXmlToArray($item['chapterurl']['value']);
			$chapter['chaptercontent'] = $rdata['document']['chaptercontent']['value'];
		}
		return $chapter;
	}
}
?>