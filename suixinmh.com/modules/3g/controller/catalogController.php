<?php
/**
 * Ŀ¼������
 * @author chengyuan  2014-8-6
 *
 */
class catalogController extends chief_controller {

// 	public $caching = false;
	public $theme_dir = false;
	//public $cacheid = 'fff';
	//public $cachetime=5;
	/**
	 * ȱʡ����Ŀ¼�б�
	 * @param unknown $params
	 * 2014-8-6 ����2:01:04
	 */
	public function main($params = array()) {
	    header('Cache-Control:max-age='.JIEQI_CACHE_LIFETIME);
		$dataObj = $this->model('catalog','3g');
		$data = $dataObj->catalogList($params['aid'],$params['order'],$params['page']);
		//�����
		$dataObj = $this->model('article','article');
		$dataObj->statisticsVisit($params['aid']);
		return $this->display($data);
	}
	
}
?>