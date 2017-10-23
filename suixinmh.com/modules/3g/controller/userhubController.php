<?php
/**
 * �û����Ŀ�����
 * @author chengyuan  2015-3-31
 *
 */
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
class userhubController extends chief_controller {
	public $theme_dir = false;
	public $caching = false;
	/**
	 * �û���Ϣ
	 */
	public function userinfo($params = array()){
		$this->display();
	}

	/**
	 * ��������
	 * @param unknown $param
	 */
	public function updatePwd($param){
		if($this->submitcheck()){
			$dataObj = $this->model('passedit','system');
			$dataObj->passedit($param,'userinfo');
		}
	}
	/**
	 * �˳���¼
	 */
	public function logout(){
		$dataObj = $this->model('logout','system');
		$dataObj->logout();
	}
	/**
	 * �ռ���
	 */
	public function inbox($param){
		$dataObj = $this->model('message','system');
		$data = $dataObj->inbox($param);
		$this->display($data);
	}
	/**
	 * �ҵķ��������
	 */
	public function comment($param){
		$reviewsLib = $this->load ( 'reviews', 'article' );
		$auth = $this->getAuth();
		$url = $this->getUrl('article','userhub','SYS=method=comment');
		$data = $reviewsLib->queryReviews(array('uid'=>$auth['uid'],'page'=>$param['page'],'ispage'=>1,'url'=>$url));
		$data['limit'] = 10;
		$data['pageurl'] = $this->getUrl('3gwap','userhub','SYS=method=comment&page=1');//print_r($data);
		if (empty($param['ajax_request'])){
			$this->display($data);
		}else{
			$this->display($data,'commentAjax');
		}
		
	}
	/**
	 * �û�������ҳ
	 */
	public function main($param){
        //ˢ���û���Ϣ
		$users_handler =  $this->getUserObject();
		$auth = $this->getAuth();
		if($auth['uid']){//更新用户SESSIO，防止出现充值到账未显示的情�?
			if($users = $users_handler->get($auth['uid'])){
				$users->saveToSession();
			}
		}
		$this->display();
	}
	/**
	 * ��������-��ֵ
	 */
/*	public function cwView($param){
		$data = array();
		$this->display($data,'caiwuhub');
	}*/
	/**
	 * ��ֵ��¼
	 */
	public function czView($param){//print_r($param);
		$dataObj = $this->model('finance','system');
		$data = $dataObj->rechargeLog($param);
		$this->display($data,'userhub_czView');
	}
	/**
	 * ���Ѽ�¼
	 */
	public function xfView($param){
		$dataObj = $this->model('finance','system');
		$data = $dataObj->pay($param);
		$dat = $dataObj->xiaofei();
		$data['xfegold'] = $dat['xfegold'];
		$data['xfnum'] = $dat['xfnum'];
		$this->display($data);
	}

	public function usermember($params = array()){
		$this->display();
	}

	public function uservip($param){
		$this->display();
	}
}
?>