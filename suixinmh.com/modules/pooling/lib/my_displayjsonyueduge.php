<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iDisplayJson.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/base.php');
// include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * ����api�ӿ�
 * <p>
 * ���ⲻ��Ҫ�ṩarticlePage��ҳ�ӿڡ�
 * @author chengyuan	2015-7-28
 *
 */
class MyDisplayJsonYueduge extends base implements iDisplayJson {
	/* (non-PHPdoc)
	 * @see iDisplayJson::articlePage()
	 */
	public function articlePage($date) {
		// TODO Auto-generated method stub
		if($date['totalpage']){
			for ($i = 1; $i <= $date['totalpage']; $i++) {
				$resutl['page_list'][] = "http://{$date['HTTP_HOST']}?ac=page&page={$i}";
			}
		}
		return $resutl;
	}

	/* (non-PHPdoc)
	 * @see iDisplayJson::articleList()
	 */
	public function articleList($date) {
		// TODO Auto-generated method stub
		foreach ($date['rows'] as $key => $row) {
			$resutl[] = array('id'=>$row['articleid'],'name'=>$row['articlename']);
		}
		return $resutl;
	}

	/* (non-PHPdoc)
	 * @see iDisplayJson::articleInfo()
	 */
	public function articleInfo($date) {
		// TODO Auto-generated method stub
		$result = array(
				"id"=>$date['article']['articleid'],
				"keywords"=>$date['article']['keywords'],
				"author"=>$date['article']['author'],
				"name"=>$date['article']['articlename'],
				"cover"=>$date['article']['url_image_l'],
				"category"=>$this->getSortIdBySHSortId($date['article']['sortid']),
				"brief"=>$date['article']['intro'],
				"complete_status"=>$date['article']['fullflag']?'Y':'N'
		);
		return $result;
	}
	//˽�з�����ӳ������ϵ
	private function getSortIdBySHSortId($sortid){
		$sortArr = array(
				1=>'����',
				2=>'����',
				3=>'����',
				4=>'��Խ',
				5=>'����',
				6=>'����',
				7=>'��Խ',
				8=>'��ʷ',
				9=>'����',
				10=>'����',
				11=>'ͬ��',
				101=>'����',
				102=>'����',
				103=>'����',
				104=>'����',
				105=>'��Խ',
				106=>'�ഺ',
				107=>'����',
				108=>'�ܲ�'
		);
		return key_exists($sortid, $sortArr)?$sortArr[$sortid]:'����';
	}
	/* (non-PHPdoc)
	 * @see iDisplayJson::chapterList()
	*/
	public function chapterList($date){
		// TODO Auto-generated method stub
		foreach ($date['chapters'] as $key => $chapter) {
			$result[] = array(
					'id'=>$chapter['chapterid'],
					'name'=>$chapter['chaptername'],
					'is_free'=>$chapter['isvip']?'0':'1',
					'creat_time'=>$chapter['postdate']
			);
		}
		return $result;
	}
	/* (non-PHPdoc)
	 * @see iDisplayJson::chapterContent()
	 */
	public function chapterContent($chapter) {
		// TODO Auto-generated method stub
		$result = array(
				'bookid'=>$chapter['articleid'],
				'bookname'=>$chapter['articlename'],
				'id'=>$chapter['chapterid'],
				'title'=>$chapter['chaptername'],
				'content'=>htmlspecialchars_array($chapter['content']?$chapter['content']:""),
				'is_free'=>$chapter['isvip']?'0':'1',
				'creat_time'=>$chapter['postdate'],
				'update_time'=>$chapter['updatedate']?$chapter['updatedate']:$chapter['postdate'],
				'size'=>bcdiv($chapter['size'],2)
		);
		return $result;
	}
}
?>