<?php 
/** 
 * �Ҳ�sysinfo * @copyright   Copyright(c) 2015 
 * @author      zhangxue* @version     1.0 
 */ 
class homeController extends Admin_controller {
		/**
		 * ����������ʾ�б���������
		 */
        public function main($params = array()) {
			 $dataObj = $this->model('home');
			 $data = $dataObj->main($params);
             $this->display($data);
        } 
		public function total($params = array()){
			 $dataObj = $this->model('home');
			 $data = $dataObj->total($params);
             $this->display($data);
		}
		
		/**
		 * �첽���༭
		 * ���أ��ɹ�/ʧ�� ���
		 */
		public function asynEdit($params = array()) {
			$dataObj = $this->model('home');
			$params['action'] = 'confirm';
			$dataObj->main($params);
		}
		
		/**
		 * �첽��ɾ��
		 * ���أ��ɹ�/ʧ�� ���
		 */
		public function asynDel($params = array()) {
			$dataObj = $this->model('home');
			$params['action'] = 'del';
			$dataObj->main($params);
		}
} 

?>