<?php 
/**
 * qq����ģ��
 * @author ������  2014-6-12
 *
 */
 class sinaloginModel extends Model{
   
	private $access_token = NULL;
	private $connectLib = NULL;
	private $openid ;
	
	public function main($params)
	{//print_r($params);exit;
		//��½�������ͻ���
		$connectLib = $this->load( 'sina', 'system', 'connect');
		$connectLib->loginClient($params['callback'],$params['appid'],'',$params['clienturl']);
	}
	
	//��½�ɹ����صĵ�ַ
	function login($params){
	    global $jieqiModules;
		$params['jumpurl'] = $_SESSION['jumpurl'];
		//exit(22);
		if($params['error_code'] && $params['error_code']==21330){
			if ($params['jumpurl']){
				echo "<script>parent.adtest('".$params['jumpurl']."');</script>";exit;
			}else{
				echo "<script>parent.loadheader();parent.layer.closeAll();</script>";exit;//parent.layer.close(parent.layer.getFrameIndex(window.name));
			}
		}

	   //print_r($params);exit;
	    $connectLib = $this->load( 'sina', 'system', 'connect');
		$access_token = $connectLib->access_token( $params['callback'],$params['appid'], $params['appkey'],$params['code'],$params["clienturl"],'POST');
		//$connectLib = $this->load( 'connsina', false );
		//$access_token = $connectLib->getTokenFromJSSDK();
//		print_r($access_token);exit;
		//�ж��Ƿ��Ѿ����˺ŷ���ֱ�ӵ�½
		$users_handler =  $this->getUserObject();//��ѯ�û��Ƿ����
		//$jieqiUsers = $users_handler->get($params['uid']);
//		$this->db->init('sina', 'connectid', 'system');
		$_openid = $access_token['uid']?$access_token['uid']:$_SESSION['openid_sina']['openid'];
		if(!$_openid){
		    //header('location:'.$jieqiModules[JIEQI_MODULE_NAME]['url'].'/qqlogin/?jumpurl='.$params['jumpurl']);
			$this->jumppage($jieqiModules[JIEQI_MODULE_NAME]['url'].'/sinalogin/?jumpurl='.$params['jumpurl'], LANG_DO_SUCCESS,'��ȡ�˺���Ϣʧ�ܡ�ϵͳ���Զ����ԡ�<br /> ���� <a href="'.$params['jumpurl'].'">������ﷵ����һҳ</a><br />');
			exit;
		}
		unset($_SESSION['jumpurl']);
		$this->db->init('connect', 'connectid', 'system');
		$this->db->setCriteria(new Criteria('openid',$access_token['uid']));//$access_token['uid']
		$this->db->queryObjects($this->db->criteria);
		$contObj = $this->db->getObject();
		if (is_object($contObj)) {
			include_once(JIEQI_ROOT_PATH.'/include/checklogin.php');
			
			$jieqiUsers = $users_handler->get($contObj->getVar('uid','n'));
			//print_r($jieqiUsers->getVar('pass', 'n'
			$islogin = jieqi_loginprocess($jieqiUsers, 100000000);
			if($islogin==0){
				if($contObj->getVar('bindtime')+90*86400<=time()){
					$contObj->setVar('bindtime',time());
					$this->db->edit($contObj->getVar('connectid','n'),$contObj);
				}
				
				//include_once(JIEQI_ROOT_PATH.'/include/funuser.php');
				//if(strpos($params['jumpurl'],'controller=sinalogin')>0 || strpos($params['jumpurl'],'controller=qqlogin')>0) $params['jumpurl'] = JIEQI_LOCAL_URL.'/';
				//print_r( $params['jumpurl']);exit;
				/*if ($params['jumpurl']=='11'){
				     //include_once(JIEQI_ROOT_PATH.'/include/funuser.php');
					//jieqi_logindo( $params['jumpurl'],true);
					//header('location:'.JIEQI_LOCAL_URL);
					echo "<script>parent.location.href=".JIEQI_LOCAL_URL." parent.layer.close(parent.layer.getFrameIndex(window.name));</script>";exit;
				}else{
					echo "<script>parent.loadheader();parent.layer.close(parent.layer.getFrameIndex(window.name));</script>";exit;
				}*/
				//print_r($_SESSION);exit;
				
				//print_r(SITE_WAP_URL);exit;
				if (!in_array(JIEQI_MODULE_NAME, array("3gwap","3g","wap"))){
					if ($params['jumpurl']){
						echo "<script>parent.adtest('".$params['jumpurl']."');</script>";exit;
					}else{
						echo "<script>parent.loadheader();parent.layer.closeAll();</script>";exit;//parent.layer.close(parent.layer.getFrameIndex(window.name));
					}
				}else{
					
					include_once(JIEQI_ROOT_PATH.'/include/funuser.php');
					if (!$params['jumpurl']){
						$params['jumpurl'] = $jieqiModules[JIEQI_MODULE_NAME]['url'].'/';	
					}
					//print_r($params['jumpurl']);
					header('location:'.$params['jumpurl']);exit;//jieqi_logindo($params['jumpurl'],true);
				}
				
				//$params['jumpurl'] = JIEQI_LOCAL_URL.'/';
				//jieqi_logindo($params['jumpurl'],true);
			}else{
				//���� 0 ����, -1 �û���Ϊ�� -2 ����Ϊ�� -3 �û�����������Ϊ�� 
				//-4 �û��������� -5 ������� -6 �û������������ -7 У������� -8 �ʺ��Ѿ����˵�½
				switch($islogin){
					case -1:
					$this->printfail($jieqiLang['system']['need_username']);
					break;
					case -2:
					$this->printfail($jieqiLang['system']['need_password']);
					break;
					case -3:
					$this->printfail($jieqiLang['system']['need_userpass']);
					break;
					case -4:
					$this->printfail($jieqiLang['system']['no_this_user']);
					break;
					case -5:
					$this->printfail($jieqiLang['system']['error_password']);
					break;
					case -6:
					$this->printfail($jieqiLang['system']['error_userpass']);
					break;
					case -7:
					$this->printfail($jieqiLang['system']['error_checkcode']);
					break;
					case -8:
					$this->printfail($jieqiLang['system']['other_has_login']);
					break;
					case -9:
					$this->printfail($jieqiLang['system']['user_has_denied']);
					break;
					default:
					$this->printfail($jieqiLang['system']['login_failure']);
					break;
				}
			}
//			include_once(JIEQI_ROOT_PATH.'/include/checklogin.php');
//			$jieqiUsers = $users_handler->get($contObj->getVar('uid','n'));
//			jieqi_loginprocess($jieqiUsers, 1);
//			if($contObj->getVar('bindtime')+90*86400<=time()){
//				$contObj->setVar('bindtime',time());
//				$this->db->edit($contObj->getVar('connectid','n'),$contObj);
//			}
//			
//			//ת��
//			$data['jumpurl'] = $_SESSION['jumpurl'] ? $_SESSION['jumpurl'] : JIEQI_LOCAL_URL;
//			include_once(JIEQI_ROOT_PATH.'/include/funuser.php');
//			jieqi_logindo($data['jumpurl'],true);
		}else{
			//��ȡ�û���������
			if (!isset($_SESSION['openid_sina']))
			{
				//��ȡ΢���û���������
				$params['openid'] = $access_token['uid'];
				$params['access_token'] = $access_token['access_token'];
				$arr = $this->get_user_info($params);
				
				$data['gender'] = iconv('utf-8','gb2312',$arr["gender"]);
				$data['nickname'] = iconv('utf-8','gb2312',$arr["screen_name"]);
				$data['username'] = $data["nickname"];
				$data['figureurl_2'] = $arr["profile_image_url"];
				if($data['gender']=='m') $data['sex'] = 1;
				if($data['gender']=='f') $data['sex'] = 2;
				else $data['sex'] = 0;
				
				//�������� 
				/*$data['sex'] = 1;
				$data['nickname'] = 'admin';
				$data['profile_image'] = 'http://tp1.sinaimg.cn/1404376560/180/0/1';
				*/
				/*if(!$users_handler->getByname($data['nickname'], 3)){
					//define('autoregister',true);
					$data['name'] = $data['nickname'];
				}*/
				$data['url_login'] = $jieqiModules[JIEQI_MODULE_NAME]['url'].'/sinalogin/bindlogin';
				$_params = array(
					'openid'=>$params['openid'],
					'username'=>$data['nickname'],
					'accesstoken' => $params['access_token'],
					'type'=>'sina'
				);
				$data['url_register'] = $jieqiModules[JIEQI_MODULE_NAME]['url'].'/sinalogin/register';//?'.http_build_query($_params);
				$data['type'] = $params['type'];
				$data['openid'] = $access_token['uid'];
				$data['access_token'] = $data['accesstoken'] = $access_token['access_token'];
				$data['jumpurl'] = $params['jumpurl'];
				$_SESSION['openid_sina'] = $data;
				//print_r($data);
			}else{
				$data = $_SESSION['openid_sina'];
			}
			if($data['username']) $this->register($data);
			return $data;
		}	
	}
	
	//�������˺Ų���½
	function bindlogin($params)
	{
		$connectLib = $this->load( 'sina', 'system', 'connect');
		$connectLib->userlogin($params);
	}
	
	//ע��󶨲���½
	function register ($params)
	{
		$connectLib = $this->load( 'sina', 'system', 'connect');
		$connectLib->userregister($params);
	}
	
	function get_user_info($params)
	{ 	//print_r($params);exit;
	  //$connectLib = $this->load( 'connsina', false );
	  $_params=array(
		       'uid'=>$params['openid'],
		       'source' =>$params['appid'],
			   'access_token'=>$params['access_token']
			);
			//print_r($_params);exit;
	   //$info = $connectLib->show_user_by_id( $_params);

		$connectLib = $this->load( 'sina', 'system', 'connect');
		$url='https://api.weibo.com/2/users/show.json';
		$info = $connectLib->api($url, $_params);

		//$get_user_info = "https://api.weibo.com/2/users/show.json?"."access_token=".$params['access_token']."&uid=".$params['openid']."&source=".$params['appid'];
		//$info = file_get_contents($get_user_info);
		//$arr = json_decode($info, true);
		//print_r($info);exit;
		return $info;
	}
	
 }
 
?>