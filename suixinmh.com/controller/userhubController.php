<?php
/**
 * �û����Ŀ��������������û����ã�����Ϣ�����������й��ܡ�
 * <br>�̳�chief���������������������½��֤��Ĭ��ģ�壨main����
 * @author chengyuan  2014-4-21
 *
 */
class userhubController extends chief_controller {

	/**
	 * �û���Ϣ
	 */
	public function userinfo($params = array()) {
		$this->theme_dir = false;
		header('Content-Type:text/html;charset=gbk');
		if($params['flag']!=''){
			$dataObj = $this->model('article','article');
			if($params['flag']=='article'){
				$data = $dataObj->userList($params);
				$this->display($data,'user_article');
			}elseif($params['flag']=='bookcase'){
				$data = $dataObj->userbook($params);
				$this->display($data,'user_book');
			}elseif($params['flag']=='review'){
				$reviewsLib = $this->load ( 'reviews', 'article' );
				$data = $reviewsLib->queryReviews(array('uid'=>$params['uid'],'page'=>$params['page'],'ispage'=>1));
				$this->display($data,'user_review');
			}
		}else{
			$dataObj = $this->model('userinfo');
			$data = $dataObj->main($params);
			$this->display($data,'userinfo');
		}
	}
	public function zuozhe($params = array()) {
	    $this->userinfo($params);
	}
	/**
	 * �޸��û���Ϣ
	 * @param unknown $param
	 */
	public function useredit($param){
		if($this->submitcheck()){
			$dataObj = $this->model('useredit');
			$data = $dataObj->useredit($param);
			$this->display($data, 'useredit');
		}

	}
	/**
	 * ��Ϣ�޸���ͼ
	 */
	public function usereditView($param){
		$dataObj = $this->model('useredit');
		$data = $dataObj->usereditView($param);
		$this->display($data,'userupdate');
	}
	/**
	 * �鿴������Ϣ
	 */
	public function userview($param){
		$dataObj = $this->model('useredit');
		$data = $dataObj->usereditView($param);//print_r($data);
		$this->display($data,'userview');
	}
	/**
	 * ajax����ͷ��ʹ��flase������ϴ���ͷ���Ϊ4�֣�ԭͼ|162*162|48*48|20*20
	 * @param unknown $param
	 */
	public function saveAvatar($param){
		$dataObj = $this->model('setavatar');
		$data = $dataObj->saveAvatar($param);
		echo $this->json_encode($data);
	}
	/**
	 * upload avatar view
	 */
	public function avatarView(){
		$dataObj = $this->model('setavatar');
		$data = $dataObj->setavatarView();
		$this->display($data,'setavatar');
	}
	/**
	 * update avatar view
	 */
	public function upaView(){
		$dataObj = $this->model('setavatar');
		$data = $dataObj->setavatarView();
		$this->display($data,'setavatar');
	}

	/**
	 * ��������
	 * @param unknown $param
	 */
	public function updatePwd($param){
		if($this->submitcheck()){
			$dataObj = $this->model('passedit');
			$dataObj->passedit($param);
		}
	}

	/**
	 * �����޸���ͼ
	 * @param unknown $param
	 */
	public function pwdview($param){
		$dataObj = $this->model('passedit');
		$data = $dataObj->passeditView($param);
		$this->display($data,'passedit');
	}
	/**
	 * �˳���¼
	 */
	public function logout(){//print_r('ddd');exit;
		$dataObj = $this->model('logout');
		$dataObj->logout();
	}
	/**
	 * ɾ����Ϣ���ռ���|�����䣩
	 * @param unknown $param
	 */
	public function delMsg($param){
		$dataObj = $this->model('message','system');
//		echo 'aaa';
//		exit;
		$dataObj->main($param);
	}
	/**
	 * �ռ���
	 */
	public function inbox($param){
		$dataObj = $this->model('message','system');
		$data = $dataObj->inbox($param);
		$this->display($data, 'inbox');
	}

	/**
	 * ������
	 */
	public function outbox($param){
		$dataObj = $this->model('message','system');
		$data = $dataObj->outbox($param);
		$this->display($data, 'outbox');
	}
	/**
	 * �ݸ���
	 * @param unknown $param
	 */
	public function draft($param){
		$dataObj = $this->model('message','system');
		$data = $dataObj->draft($param);
		$this->display($data, 'draft');
	}
	/**
	 * ��Ϣ��ϸ
	 */
	public function messagedetail($param){
		$dataObj = $this->model('message');
		$data = $dataObj->messagedetail($param);
		$this->display($data, 'messagedetail');
	}

	/**
	 * д��Ϣ
	 */
	public function newmessage($param){
		$dataObj = $this->model('message');
		$param['receiver'] = urldecode($param['receiver']);
		$data = $dataObj->newmessage($param);
		$this->display($data, 'newmessage');
	}
	/**
	 * д������Ա
	 * @param unknown $param
	 */
	public function toSysView($param){
		$dataObj = $this->model('message');
		$data = $dataObj->newmessage($param);
		$data['tosys'] = 1;
		$this->display($data, 'newmessage');
	}
	/**
	 * ������Ϣ
	 * @param unknown $param
	 */
	public function sendMsg($param){
		if($this->submitcheck()){
			$dataObj = $this->model('message');
			$data = $dataObj->sendMsg($param);
			//$this->display($data, 'newmessage');
		}
	}
	//������
	/**
	 * �����б���ͼ
	 */
	public function friend($param){
		$this->display('','myfriends');
	}

	public function getfriend($params){
		$dataObj = $this->model('myfriends');
		$data = $dataObj->main($params);
		$this->display($data,'wholeatten');
	}

	public function searchF($params){
		$params['smid'] = iconv("utf-8","gb2312",urldecode($params['smid']));
		$dataObj = $this->model('myfriends');
		$data = $dataObj->searchF($params);
		$data['seach'] = 'add';
		$data['smid'] = $params['smid'];
		$this->display($data,'wholeatten');
	}

	public function addAttention($param){
		$dataObj = $this->model('myfriends');
		$data = $dataObj->addAttention($param);
		$this->display($data,'wholeatten');
	}


	public function delAtten($param){
		$dataObj = $this->model('myfriends');
		$data = $dataObj->delAtten($param);
//		$this->display($data,'wholeatten');
	}

	/**
	 * ���ѿռ���ͼ
	 */
	public function friendSpace($param){
		$dataObj = $this->model('myfriends');
		$data = $dataObj->friendSpace($param['uid']);
		//���ѿռ�ģ��
		$this->display($data,'empty');
	}
	/**
	 * �ҵķ��������
	 */
	public function comment($param){
		$reviewsLib = $this->load ( 'reviews', 'article' );
		$auth = $this->getAuth();
		$url = $this->getUrl('article','userhub','SYS=method=comment');
		$data = $reviewsLib->queryReviews(array('uid'=>$auth['uid'],'page'=>$param['page'],'ispage'=>1,'url'=>$url));
		$this->display($data,'comment');
	}
	/**
	 * �ظ�������
	 */
	public function hotcomment($param){
		$reviewsLib = $this->load ( 'reviews', 'article' );
		$auth = $this->getAuth();
// 		$data = $reviewsLib->queryReviews(array('uid'=>$auth['uid'],'ispage'=>1,'limit'=>4,'display'=>'isgood'));
		$param['uid'] = $auth['uid'];
		$data = $reviewsLib->showRepliesByUid($param);
		$this->display($data,'commentreplies');
	}
	/**
	 * �û�������ҳ
	 */
	public function main($param){
		$this->addConfig('article', 'sort');
		$data['sort'] = $this->getConfig('article','sort');
		$auth = $this->getAuth();
		$userinfoModel = $this->model('userinfo');
		$data['issign'] = $userinfoModel->isSign();
		//print_r($data['issign']);
		$this->display(array('uid'=>$auth['uid'],'sort'=>$data['sort'],'issign'=>$data['issign']),'user_index');
	}
	/**
	 * ǩ������
	 */
	public function signin($param){
		$dataObj = $this->model('userinfo');
		$dataObj->signin($param);
	}
	/**
	 * ǩ����ͼ
	 */
	public function showSignView($param){
		$dataObj = $this->model('userinfo');
		$data = $dataObj->showSignView($param);
		print_r(json_encode($data));
	}
	/**
	 * ��˽����
	 */
	public function ysView($param){
		$data = array();
		$this->display($data,'yinsi');
	}

	/**
	 * ��ֵ��¼
	 */
	public function czView($param){
		$dataObj = $this->model('finance');
		$data = $dataObj->rechargeLog($param);
		$this->display($data,'caiwu');
	}
	/**
	 * ���Ѽ�¼
	 */
	public function xfView($param){
		$dataObj = $this->model('finance');
		$data = $dataObj->pay($param);
		$this->display($data,'xiaofei');
	}

	/**
	 * �Զ�����
	 */
	public function dyView($params){
		$dataObj = $this->model( 'home');
		$auth = $this->getAuth();
		$params['uid'] = $auth['uid'];
		$data = $dataObj->getDingyue($params);
		$this->display($data,'dingyue');
	}

	public function canseDingyue($params){
		    $this->addLang( 'article', 'article');
			$jieqiLang ['article'] = $this->getLang ( 'article' ); // �������԰����ø�ֵ
			$dataObj = $this->model('reader','article');
			if (!$dataObj->closebuy($params)){
				$this->printfail();
			}else{
				$readurl = $this->geturl('system', 'userhub','method=dyView');
			    $this->jumppage($readurl, LANG_DO_SUCCESS, $jieqiLang['article']['batch_close_buy_success']);
			}
	}


	/**
	 * �ҵĶ�̬����
	 */
	public function myDynamic($params = array()){
		$dataObj = $this->model( 'home');
		$auth = $this->getAuth();
		$params['uid'] = $auth['uid'];
		//$data = $dataObj->getDynamic($params);
		$data=array();
		$this->display($data,'dynamic');
	}
	/**
	 * ������Ϣ ������
	 */
	public function popuser($params = array()){
		header('Content-Type:text/html;charset=gbk');//����ˢ��ʱ��������
		$dataObj = $this->model('userinfo');
		$data = $dataObj->popuser($params);
		$this->display($data,'pop_user');
	}
	//����ͷ��
	public function handleAvatar(){
		global $jieqiConfigs, $jieqiLang, $jieqi_image_type;
		jieqi_getconfigs('system', 'configs');
		$this->addLang('system', 'users');
		$auth = $this->getAuth ();
		$users_handler = $this->getUserObject ();
		$jieqiUsers = $users_handler->get ( $auth ['uid'] );
		$subdir = $auth ['uid'];
		$dir=jieqi_uploadpath($jieqiConfigs['system']['avatardir'], 'system');
		/***********************
		�ڶ���ʵ�ְ취����readdir()����
		************************/
			if(is_dir($dir))
		   	{
		     	if ($dh = opendir($dir))
				{
		        	while (($file = readdir($dh)) !== false)
					{
		     			if((is_dir($dir."/".$file))    && $file!="." && $file!="..")
						{
		     				//echo "<b><font color='red'>�ļ�����</font></b>",$file,"<br><hr>";
		     				//listDir($dir."/".$file."/");
		     			}
						else
						{
		         			if($file!="." && $file!=".." && $file != 'Thumbs.db')
							{
								echo '��ʼ�����ļ���'.$dir."/".$file.'<br>';
								if('i.jpg' == strrchr ( trim ( strtolower ($file) ), "i" )){
									echo 'ɾ��'.'<br>';
									jieqi_delfile($dir."/".$file);
								}elseif ('s.jpg' == strrchr ( trim ( strtolower ($file) ), "s" )){
									$basedir = $dir.jieqi_getsubdir(substr($file,0,strpos($file,'s')));
									jieqi_checkdir($basedir,true);
									$basedir .= '/'.$file;
									jieqi_copyfile($dir."/".$file,$basedir,0777,true);
									echo '�ƶ�����'.$basedir.'<br>';
								}elseif(is_numeric(basename($file, '.jpg'))){
									$basedir = $dir.jieqi_getsubdir(basename($file, '.jpg'));
									jieqi_checkdir($basedir,true);
									$o = $basedir.'/'.$file;
									$l = $basedir.'/'.basename($file, '.jpg').'l.jpg';
									$m = $basedir.'/'.basename($file, '.jpg').'m.jpg';;
									jieqi_copyfile($dir."/".$file,$o,0777,false);//ԭͼ
									echo '��������'.$o.'<br>';
									jieqi_copyfile($dir."/".$file,$l,0777,false);//l
									echo '��������'.$l.'<br>';
									jieqi_copyfile($dir."/".$file,$m,0777,true);//m
									echo '�ƶ�����'.$m.'<br>';
								}else{
									$basedir = $dir.jieqi_getsubdir(basename($file, '.png'));
									jieqi_checkdir($basedir,true);
									$o = $basedir.'/'.basename($file, '.png').'.jpg';
									$l = $basedir.'/'.basename($file, '.png').'l.jpg';
									$m = $basedir.'/'.basename($file, '.png').'m.jpg';
									$s = $basedir.'/'.basename($file, '.png').'s.jpg';
									jieqi_copyfile($dir."/".$file,$o,0777,false);//ԭͼ
									echo '��������'.$o.'<br>';
									jieqi_copyfile($dir."/".$file,$l,0777,false);//l
									echo '��������'.$l.'<br>';
									jieqi_copyfile($dir."/".$file,$m,0777,false);//m
									echo '��������'.$m.'<br>';

									//СͼĬ��ʹ�ô�ͼ����С��,��С�ٷ�֮50
									 include_once(JIEQI_ROOT_PATH.'/lib/image/imageresize.php');
									$imgresize = new ImageResize();
									$imgresize->loadImg($dir."/".$file);
									$imgresize->resize(null,null,0.5);
									$imgresize->save($s,true);

// 									jieqi_copyfile($dir."/".$file,$s,0777,true);//s
									echo '�ƶ�����'.$s.'��С50%<br>';
								}
								echo '<br>';
								//$basedir = $dir.jieqi_getsubdir($uid);
								//����ͼƬ
// 								if(jieqi_checkdir($basedir,true)){

// 								}
// 		         				echo $file."<br>";
		      				}
		     			}
		        	}
		        	closedir($dh);
		     	}
		   	}
		//��ʼ����
		echo '�������';
		exit;
	}

	public function usermember($param){
		$dataObj = $this->model('usermember');
		$data = $dataObj->usermember($param);
		$this->display($data,'usermember');
	}

	public function uservip($param){
		$dataObj = $this->model('usermember');
		$data = $dataObj->uservip($param);
		$this->display($data,'viparea');
	}
	//�ͻ��� �һ�����
	public function getpass($params = array()){
		$dataObj = $this->model('getpass');
		$data = $dataObj->getpass($params);
		//$this->display($data,'usermember');
	}
	//�ͻ��� �޸�����
	public function setpass($params = array()){
		$dataObj = $this->model('setpass');
		$data = $dataObj->setpass($params);
		//$this->display($data,'usermember');
	}
	//�˻���Ϣ
	/* public function shuquan($params = array()){
		$dataObj = $this->model('finance');
		$this->display($data,'shuquan');
	} */
	
	/*
	 * �������ģ���ȡ��ȯ�б���ͼ
	 */
	public function getShuquanView($params = array()){
		$dataObj = $this->model('finance');
		$data = $dataObj->getShuquanView($params);
		$this->display($data,'getShuquan');
	}
	/*
	 * ��ȡ��ȯ����
	 */
	public function getShuquan($params = array()){
		$dataObj = $this->model('finance');
		$data = $dataObj->getShuquan($params);
		$this->display($data,'receiveBookC');
	}
        
        /**
         * �ҵ��������
         * @param type $params
         */
        public function mybplist($params = array()) {
        $data = array();
        $bpsaleModel = $this->model('bookpackagesale', 'article');
        $data = $bpsaleModel->getMyBookpackage($params);
        // �����鼮����
        $this->addConfig('article', 'sort');
        $data['sortname'] = $this->getConfig('article', 'sort');
        $this->display($data, 'userbookpackage');
    }
}
?>