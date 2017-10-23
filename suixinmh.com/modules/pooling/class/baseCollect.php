<?php
/**
 * �ɼ�ʵ�ֽӿڵĸ��࣬�ṩĬ�ϵĽӿ�ʵ�ַ�����������Ҫʵ��iCollect�ӿ�
 * @author chengyuan  2014-8-21
 *
 */
include_once ($GLOBALS['jieqiModules']['pooling']['path'] . '/class/base.php');
abstract class  baseCollect extends base{

	function __construct() {
		$this->initDB();
	}
	/**
	 * ƥ�䱾�ط���ID��Ĭ�Ϸ��ط��ࣺ1
	 * @param unknown $sort		��������
	 * @return unknown|number
	 * 2014-8-21 ����3:38:10
	 */
	public  function getLocalSortId($sort,$channel){
		if(is_string($sort)){
			if(is_array($channel['setting']['getdata']['category']) && array_key_exists($sort, $channel['setting']['getdata']['category'])){
				return $channel['setting']['getdata']['category'][$sort];//��Ӧ��վ��sortid
			}
// 			$sortArr =  $this->getSortMapping();//����ʵ�ֵĽӿڷ���
// 			$locaSort = $sortArr[$sort];
// 			$this->addConfig('article','sort');
// 			$sortArr = $this->getConfig('article','sort');
// 			foreach ( $sortArr as $k => $v ) {
// 				if($v['shortcaption'] == $locaSort){
// 					return $k;
// 				}
// 			}
		}
		return 1;
	}
	/**
	 * ����xmlΪarray
	 * @param unknown $url
	 * 2014-8-21 ����3:51:25
	 */
	public  function parseXmlToArray($url){
		$XML = $this->load('getxml','system');
		$rdata = $XML->getData($url);
		return $rdata;
	}
	/**
	 * Ĭ�Ϸ�װ�½ڣ���װ�ĸ�ʽ��ο�my_article��saveChatper����
	 * @param unknown $item
	 * @param unknown $channel
	 * @return multitype:NULL number string
	 * 2014-8-22 ����10:23:04
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

	
	
	/**
	 * ���ݳ�pooling_article���Ƿ����
	 * <p>
	 * ������ڣ��򷵻�pooling_article��article_article���ϲ�ѯ����������
	 * @param unknown $apiId		�����������
	 * @param unknown $channel		����ID
	 * @return multitype:unknown	ӳ���ϵ����
	 */
	public function isExists($apiId,$channelid){
		$poolArticle = array();
		//�Ƿ��Ѿ���⣬����id+bookid Ψһ����
		$this->db->init('article','paid','pooling');
		$this->db->setCriteria(new Criteria('channelid', $channelid));
		$this->db->criteria->add(new Criteria('apiId', $apiId));
		$this->db->criteria->setTables(jieqi_dbprefix('pooling_article').' pa INNER JOIN '.jieqi_dbprefix('article_article').' aa ON pa.articleid=aa.articleid');
		$this->db->criteria->setFields('pa.paid,pa.lastvolumeid,pa.lastvolume,pa.lastchapterid,pa.lastchapter,pa.outchapters,aa.articleid, aa.articlename,aa.lastupdate,aa.sortid,aa.articletype');
		$count = $this->db->getCount($this->db->criteria);
		if($count == 0){
		}elseif ($count == 1){
			$this->db->queryObjects();
			$object=$this->db->getObject();
			//object-array
			foreach($object->getVars() as $k=>$v){
				$poolArticle[$k] = $v['value'];
			}
		}else{
			$this->out_msg_err('�������ݲ�Ψһ');
			exit;
		}
		return $poolArticle;
	}
	
	
	public function getSiteIdBySortId($sortid){
		$articleLib = $this->load('article','article');
		$soruce = $articleLib->getSources();
		foreach($soruce['channel'] as $k=>$v){
			if(intval($v['minsortid']) <= $sortid && $sortid <= intval($v['maxsortid'])){
				return $k;
			}
		}
		//Ĭ�ϣ�0
		return 0;
	}
	/**
	 * icollect�ӿڵ�Ĭ��ʵ�֣�������Ը��������д
	 * @param unknown $item
	 * @param unknown $channel
	 * @return Ambigous <multitype:NULL string number Ambigous <NULL, string, number> Ambigous <unknown, number, unknown> , unknown>
	 * 2014-8-22 ����11:34:21
	 */
	public function packingArticle($item,$channel,$loadLocalArticle=true){
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
		$article['sortid'] = $this->getLocalSortId($item['category']['value'],$channel);//���¼���ͱ�վ�Ķ�Ӧ��ϵ
		$article['siteid'] = $this->getSiteIdBySortId($article['sortid']);//ͨ��sortid����siteid
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
}
?>