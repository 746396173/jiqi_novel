<?php
/**
 * ������������
 * @author zhangxue  2014-9-24
 *
 */
class sortmanageController extends Admin_controller {

		public function __construct(){
			parent::__construct();
			$this->checkpower('managesort');//Ȩ����֤
		}
		
		//����ͼ
		public function main($params = array()){
			$dataObj = $this->model('sortmanage');
			$data = $dataObj->main($params);
			$this->display($data);
		}
		//���ӷ���
		public function addsort($params = array()){
			$dataObj = $this->model('sortmanage');
			$dataObj->addsort($params);
		}
		//�޸ķ�����ͼ
		public function editsortview($params = array()){
			$dataObj = $this->model('sortmanage');
			$data = $dataObj->editsortview($params);//print_r($data);
			$this->display($data,'editsort');
		}
		//�޸ķ���
		public function editsort($params = array()){
			$dataObj = $this->model('sortmanage');
			$dataObj->editsort($params);
		}
		//ɾ������
		public function delsort($params = array()){
			$dataObj = $this->model('sortmanage');
			$dataObj->delsort($params);
		}
}
?>