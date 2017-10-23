<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/lib/my_displayjsonbaiducloud.php');
// include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
/**
 * �����ٶ��������ӿڣ��̳аٶ������ݽӿڣ�ͨ���鼮�ӿ��ṩ�麣վ��URL
 * <p>
 * ��д�˸���articleInfo($date)�鼮������Ϣ�ӿڷ������½ڵ�ַchapter_url��ת���麣վ
 * <p>
 * ���������json��ʽ��
 * @author chengyuan  2014-7-3
 *
 */
class MyDisplayJsonBaiducloudflow extends MyDisplayJsonBaiducloud{

	/* (non-PHPdoc)
	 * @see iDisplayJson::articleInfo()
	 */
	public function articleInfo($date) {
		
		
// 		echo $this->getUrl('3gwap','reader','SYS=aid=123&cid=456').'?free=1';
		// TODO Auto-generated method stub
		$item = $date['article']['channel'].'_*_';
		if($date['article']['keywords']){
			foreach (explode(" ", $date['article']['keywords']) as $key => $value) {
				$tag .= ','.$item.$value;
			}
		}else{
			$tag = $item.'*';
		}
		$result = array(
				"book_id"=>$date['article']['articleid'],
				"book_name"=>$date['article']['articlename'],
				"author"=>$date['article']['author'],
				"channel"=>$date['article']['channel'],
				"category"=>$date['article']['channel'].'_'.$date['article']['shortcaption'].'_*',
				"tag"=>$tag,
				"book_status"=>$date['article']['fullflag']?'���':'����',
				"description"=>$date['article']['intro'],
				"log"=>$date['article']['url_image_l'],
				"first_published"=>$date['article']['firstflag']==0?1:0,//1-�ڱ�վ�׷���0-���ڱ�վ�׷�
				"origin_provider"=>JIEQI_URL,
				"price_status"=>$date['article']['articletype'],//0 ��ѣ�1 �շ�
				"price_pattern"=>0,// 0 ���£�1 ����
				"price"=>0,
				"chapter_price"=>0,
				"chapter_number"=>$date['article']['chapters'],
				"save_content"=>1
		);
		foreach ($date['chapters'] as $key => $chapter) {
			$result['group'][] = array(
					'chapter_index'=>$chapter['chapterorder'],
					'chapter_title'=>$chapter['chaptername'],
					'chapter_url'=>$this->getUrl('3gwap','reader',"SYS=aid={$date['article']['articleid']}&cid={$chapter['chapterid']}&method=freereader"),
					'price_status'=>$chapter['isvip'],
					'price'=>bcdiv($chapter['saleprice'],100,2),
					'public_time'=>$chapter['lastupdate'],
			);
		}
		return $result;
	}

	
}
?>