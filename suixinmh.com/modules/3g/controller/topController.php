<?php 
/** 
 * ���а������ * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class topController extends chief_controller
 { 
	public $caching = true;
	
	/**
	 * ���а񵼺�ҳ
	 */
	public function main($params = array())
	{
		$this->display(); 
	}
	
	/**
	 * ���а�ҳ��
	 */
	public function toplist($params = array())
	{
		$params['listnum'] = 15;
		$this->setCacheid(md5(serialize($params)));
		if(!$this->is_cached()){
			$dataObj = $this->model('top','article');
			// ����ÿҳ��ʾ��������
			$data = $dataObj->toplist($params);//print_r($data);
			$data['midname'] = $data['midname'].'��';
		}
		$this->display($data);
	}
 }
?>