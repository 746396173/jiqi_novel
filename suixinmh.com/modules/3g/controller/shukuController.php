<?php
/**
 * ��������
 * @author chengyuan  2014-7-18
 *
 */

class shukuController extends chief_controller {

	//	public $theme_dir = false;
	public $caching = true;
	public function main($params = array()) {
		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		$this->setCacheid(md5(serialize($params)));
		if(!$this->is_cached()){
			$params['siteid'] = isset($params['siteid']) ? $params['siteid'] : 0;
			// ����ÿҳ��ʾ��������
			$params['listnum'] = 10;
			$dataObj = $this -> model('shuku', 'article');
			$data = $dataObj -> query($params);
			// ������ʾ����
			$filterModel = $this->model('filter3g', '3g');
			$data['operate'] = $filterModel->getOperate();
		}
		$this -> display($data);
	}

}
?>