<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/iDisplayJson.php');
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/class/base.php');
// include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * �ѹ������� �����ӿ�
 * <p>
 * �ӿ����ݲ��ܷ���null����ʹû�����ݣ�ҲҪ����ת����json��ʽ���磺{"body":[]}
 * <p>
 * ���������json��ʽ
 * @author chengyuan
 *
 */
class MyDisplayJsonSogou extends base implements iDisplayJson {
	public $msg = array('0'=>'�ɹ�','-1'=>'��֤ʧ��','-2'=>'��������');
	/* (non-PHPdoc)
	 * @see iDisplayJson::articlePage()
	 */
	public function articlePage($date) {
		// TODO Auto-generated method stub
		//���·�ҳ�ӿڣ�����Ҫʵ��
		exit();
	}

	/* (non-PHPdoc)
	 * @see iDisplayJson::articleList()
	 */
	public function articleList($date) {
		// TODO Auto-generated method stub
		$resutl = array("code"=>0,'msg'=>$this->msg['0'],'body'=>array());
		foreach($date['rows'] as $k => $v){
			$resutl['body'][$k] = $v['articleid'];
		}
		return $resutl;
	}

	/* (non-PHPdoc)
	 * @see iDisplayJson::articleInfo()
	 */
	public function articleInfo($date) {
		$resutl = array("code"=>0,'msg'=>$this->msg['0'],'body'=>array());
		// TODO Auto-generated method stub
		$arr['bookid']  = $date['article']['articleid'];
		$arr['book_name'] =  $date['article']['articlename'] ;
		$arr['author'] =  $date['article']['author'];
		$arr['description'] = $date['article']['intro'];
		$arr['complete_status'] = $date['article']['fullflag']>0?2:1;
		$arr['parent_category_name'] =  '';
		$arr['category_name'] =  $date['article']['shortcaption'];
		$arr['keywords'] =  $date['article']['keywords'];
		$arr['img'] =  $date['article']['url_image_l'];
		$arr['isvip'] =  $date['article']['articletype']>0?2:0;
		$arr['price'] =  3;
		$arr['down_count'] =  0;
		$arr['hits_count'] = $date['article']['allvisit'];
		$resutl['body'] = $arr ;
		return $resutl;
	}
	/* (non-PHPdoc)
	 * @see iDisplayJson::chapterList()
	*/
	public function chapterList($date){
		$resutl = array("code"=>0,'msg'=>$this->msg['0'],'body'=>array());
		$resutl['body'] ['book_id'] = $date ['article'] ['articleid'];
		$resutl['body'] ['chapter_list'] = array();
		foreach ( $date ['chapters'] as $k => $v ) {
			$chapterinfo = array ();
			if (! $v ['chaptertype']) {
				$chapterinfo['chapter_id'] = $v ['chapterid'];
				$chapterinfo['chapter_name'] = $v ['chaptername'];
				$chapterinfo['isvip'] = $v ['isvip'];
				$chapterinfo['update_time'] = $v ['lastupdate'];
				$resutl['body'] ['chapter_list'] [] = $chapterinfo;
			}
		}
		return $resutl;
	}
	/* (non-PHPdoc)
	 * @see iDisplayJson::chapterContent()
	 */
	public function chapterContent($chapter) {
		// TODO Auto-generated method stub
		$resutl = array("code"=>0,'msg'=>$this->msg['0'],'body'=>array());
		if (! $chapter ['chaptertype']) {
			$resutl ['body'] ['bookid'] = $chapter['articleid'];
			$resutl ['body'] ['chapter_id'] = $chapter['chapterid'];
			$resutl ['body'] ['chapter_content'] = $chapter['content'];
			$resutl ['body'] ['chapter_size'] = bcdiv($chapter['size'],2);
		}
		return $resutl;
	}
}
?>