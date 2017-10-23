<?php 
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
define('API_URL',$GLOBALS['jieqiModules'][JIEQI_MODULE_NAME]['url'].'/qqlogin/login/');
class qqloginController extends Controller { 

	public $theme_dir = false;
	public $template_name = 'bindlogin';
	public $appid = '101230128';
	public $appkey = 'bf8b0f7b4e3867b83af63f6174ae0821';
	public $callback = API_URL;
	public $caching = false;
	
	public function main($params = array()){
		$dataObj = $this->model('qqlogin');
		$params['appid'] = $this->appid;
	    $params['appkey'] = $this->appkey;
		$params['jumpurl'] = urldecode($params['jumpurl']);
        $params['callback'] = $this->callback;
		$dataObj->main($params);
	}
	
	//��½�ɹ����صĵ�ַ
	public function login($params = array()){
	   $dataObj = $this->model('qqlogin');
	   $params['type'] = 'qq';
	   $params['appid'] = $this->appid;
	   $params['appkey'] = $this->appkey;
       $params['callback'] = $this->callback ;
	   //�ύ����
	   $data = $dataObj->login($params);
	   //print_r($data);exit; 
	   $this->display($data);
	}

	//�������˺Ų���½
	function bindlogin($params)
	{
		$dataObj = $this->model('sinalogin');
		if($this->submitcheck()) $dataObj->bindlogin($params);
		else $this->printfail();
	}
	
	/**
	 * ע��󶨲���½
	 * <p>
	 * ǰ��Ҫ¼�����û���email��Ϣ�������qq��Ϣ�����û�ע��
	 * @param unknown $params 
	 */
	function registerlogin ($params)
	{
		$dataObj = $this->model('qqlogin');
		if($this->submitcheck()) $dataObj->register($params);
		else $this->printfail();
	}
	
	function jumpurl($params){
	    //print_r("isset:".isset($params['param'])." empty:".empty($params['param']));exit;
		if (!empty($params['param'])){
// 			echo "<script>parent.adtest('".$params['param']."');<\/script>";exit;
			echo "<script>location.href='".$params['param']."';</script>";exit;
		}else{
			echo "<script>parent.loadheader();parent.layer.closeAll();</script>";exit;//parent.layer.close(parent.layer.getFrameIndex(window.name));
		}
			/*echo "<script>parent.loadheader();parent.layer.close(parent.layer.getFrameIndex(window.name));</script>";exit;*/
	}
}
?>