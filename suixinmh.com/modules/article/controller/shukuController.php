<?php
/**
 * ��������
 * @author huliming  2014-6-10
 *
 */
class shukuController extends Controller
{
	public $caching = false;
	/**
	 * ����ѯ��Ĭ�����
	 * @param unknown $params
	 */
	public function main($params = array()){
	    //header('Cache-Control:max-age='.JIEQI_CACHE_LIFETIME);
		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		//��֤������Ч��
		$dataObj = $this->model('shuku');
		$data = $dataObj->query($params);//print_r($data);
		$this->display($data);
	}
}
?>