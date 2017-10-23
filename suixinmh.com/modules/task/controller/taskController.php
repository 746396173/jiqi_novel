<?php
/**
 * ����ϵͳ���������û��������ģ��
 * @author by: liuxiangbin
 * @createtime : 2015-01-13
 */
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
class taskController extends Controller {
	public $template_name = 'task';
	public $caching = false;
	
	/**
	 * ������
	 */
	public function main($params = array()) {
		$this->checklogin();
		$params['methodName'] = 'main';
		$taskModel = $this->model('usertask', 'task');
		$data = $taskModel->getUserList($params);
		$this->display($data);
	}
	
	/**
	 * �û���������б�
	 */
	public function userfinished($params = array()) {
		$this->checklogin();
		$params['methodName'] = 'userfinished';
		$taskModel = $this->model('usertask', 'task');
		$data = $taskModel->getUsreFinished($params);
		$this->display($data, 'userfinished');
	}
	
	/**
	 * ��������첽��ʽ����
	 */
	public function taskComplete($params) {
		$taskModel = $this->model('usertask', 'task');
		$taskModel->setComplete($params);
	}
	
	/**
	 * �������齱�������ȡ�ñ����5����
	 */
	public function getQuestion($params = array()){
	    	$dataObj = $this->model('questionbank','task');
	    	$dataObj->getRadomQuestion($params['aid']);
	}
	/**
	 * 
	 */
	public function luckydraw($params = array()){
	    	$dataObj = $this->model('specials','task');
	    	$dataObj->getLuckydraw($params);
	}
}
	