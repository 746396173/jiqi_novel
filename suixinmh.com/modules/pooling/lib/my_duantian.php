<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/icollect.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/baseCollect.php');
// include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * ����ɼ��ӿ�ʵ����
 * @author chengyuan  2014-8-21
 *
 */
class Myduantian extends baseCollect implements iCollect {
	/**
	 * �����б�URL
	 * @var unknown
	 */
	const BOOKLIST = 'spdat.duantian.com/shuhai/getspbookids/';
	
	
	/**
	 * ��ȡ�����ɼ��������б�֧��aidsɸѡ
	 * @param unknown $cid
	 * @param unknown $page ��ʱ��֧��ҳ��
	 * @param unknown $aids ���������
	 * 2014-8-19 ����1:52:02
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
		$rdata = $this->parseXmlToArray(Myduantian::BOOKLIST);
		$row = array();
		//һ������item=array���Ƕ�������itme=array('key'=>array())
		$items =$rdata['document']['items']['item'];
		if(!array_key_exists(0,$items)){
			//һ���������⴦��
			$temp = $items;
			$items = array($temp);
		}
		foreach ( $items as $item ){
			//ɸѡ��ָ������������ͬ
			$article = $this->simplePackingArticle($item,$channel);
			$row[$article['articleid']] = $article;
		}
		$data['rows'] = $row;
		$data['channel'] = $channel;
		return $data;
	
	}
	
	public function simplePackingArticle($item,$channel){
		return $this->packingArticle($item, $channel,false);
	}
	/* (non-PHPdoc)
	 * @see iCollect::articleList()
	*/
	public function articleList($cid, $page, $aids = array()) {
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
		$rdata = $this->parseXmlToArray(Myduantian::BOOKLIST);
		$row = array();
		//һ������item=array���Ƕ�������itme=array('key'=>array())
		$items =$rdata['document']['items']['item'];
		if(!array_key_exists(0,$items)){
			//һ���������⴦��
			$temp = $items;
			$items = array($temp);
		}
		foreach ( $items as $item ){
			//ɸѡ��ָ������������ͬ
			if(!empty($aids) && !in_array($item['bookid']['value'],$aids)){
				continue;
			}
			$article = $this->packingArticle($item,$channel);
			$row[$article['articleid']] = $article;
			if(!empty($aids) && count($row) == count($aids)){
				break;
			}
		}
		$data['rows'] = $row;
		$data['channel'] = $channel;
		return $data;
	}

// 	public function getSortMapping(){
// 		return array(
// 				'��ʷ'=>'��ʷ',
// 				'����'=>'����',
// 				'���'=>'����',
// 				'����'=>'����',
// 				'����'=>'����',
// 				'����'=>'����',
// 				'����'=>'����',
// 				'У԰'=>'����',
// 				'����'=>'����',
// 				'�ƻ�'=>'�ƻ�',
// 				'����'=>'����',
// 				'����'=>'����',
// 				'�ֲ�'=>'�ֲ�',
// 				'ͬ��'=>'ͬ��',
// 				'��ƪ'=>'΢С',
// 				'ʫ��'=>'�ŵ�',
// 				'����'=>'����'
// 		);
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

}
?>