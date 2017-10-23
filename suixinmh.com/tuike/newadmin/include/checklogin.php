<?php
/**
 * ����û���¼
 *
 * ��֤��¼�˺š����롢��֤���
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    system
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: checklogin.php 324 2009-01-20 04:47:10Z juny $
 */

/**
 * ��֤��¼�˺š����롢��֤�룬ͬ���Ļ����е�¼����
 * 
 * @param      string      $username �û���
 * @param      string      $password ����
 * @param      string      $checkcode ��֤��
 * @param      int         $usecookie �Ƿ��¼��cookie���´��Զ���¼��0��ʾ����¼������0��ʾcookie����ʱ��
 * @param      bool        $encode �����Ƿ��Ѿ����ܣ�Ĭ�Ϸ�
 * @param      bool        $needcheck �Ƿ���Ҫ��֤�룬Ĭ����
 * @access     public
 * @return     int         0 ����, -1 �û���Ϊ�� -2 ����Ϊ�� -3 �û�����������Ϊ�� -4 �û��������� -5 ������� -6 �û������������ -7 ��֤����� -8 �ʺ��Ѿ����˵�½ -9 �û������ο���
 */
function jieqi_logincheck($username='', $password='', $checkcode='', $usecookie=0, $encode=false, $needcheck=true){
	
	$ret = jieqi_loginpass($username, $password, $checkcode, $usecookie, $encode, $needcheck);
	if(is_object($ret)){
		return jieqi_loginprocess($ret, $usecookie);
	}elseif($ret == -10){
		//��ʱ�û���δ�������룬ucenter����ʱ���Զ��������룬���򷵻��������
		include_once(JIEQI_ROOT_PATH.'/include/funuser.php');
		if(function_exists('uc_user_login')){
			list($uid, $uname, $upass, $uemail) = uc_user_login($username, $password);
			if($uid > 0){
				include_once(JIEQI_ROOT_PATH_APP.'/class/users.php');
				$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
				$userobj = $users_handler->getByname($username);
				if(is_object($userobj)){
					$userobj->setVar('pass', $users_handler->encryptPass($upass));
					$userobj->setVar('email', $uemail);
					$users_handler->insert($userobj);
					return jieqi_loginprocess($userobj, $usecookie);
				}
			}
		}
		return -5;
	}else{
		return $ret;
	}
}

/**
 * ����֤��¼�˺š����롢��֤�룬�����Ƿ���֤ͨ����Ϣ
 * 
 * @param      string      $username �û���
 * @param      string      $password ����
 * @param      string      $checkcode ��֤��
 * @param      int         $usecookie �Ƿ��¼��cookie���´��Զ���¼��0��ʾ����¼������0��ʾcookie����ʱ��
 * @param      bool        $encode �����Ƿ��Ѿ����ܣ�Ĭ�Ϸ�
 * @param      bool        $needcheck �Ƿ���Ҫ��֤�룬Ĭ����
 * @access     public
 * @return     int         0 ����, -1 �û���Ϊ�� -2 ����Ϊ�� -3 �û�����������Ϊ�� -4 �û��������� -5 ������� -6 �û������������ -7 ��֤����� -8 �ʺ��Ѿ����˵�½ -9 �û������ο��� -10 δ��������
 */
function jieqi_loginpass($username='', $password='', $checkcode='', $usecookie=0, $encode=false, $needcheck=true){
	global $jieqiConfigs;
	global $jieqiHonors;
	global $jieqiGroups;
	if(empty($username) || empty($password)) return -3;
	
	if(!isset($jieqiConfigs['system'])) jieqi_getConfigs('system', 'configs');
	//�����֤��
	if($needcheck){
	    if(empty($checkcode) || strtoupper($checkcode) != strtoupper($_SESSION['jieqiCheckCode']))	return -7;
	}


	//����û���������
	include_once(JIEQI_ROOT_PATH_APP.'/class/users.php');
	$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
	$criteria = new CriteriaCompo(new Criteria('uname', $username));
	$users_handler->queryObjects($criteria);
	$jieqiUsers=$users_handler->getObject();
	if (!$jieqiUsers){
		return -4;
	}

	if( $jieqiUsers->getVar('groupid', 'n') != '7' ){
		$data=array(
	    'type'=>'buyYunLogin',
		'url'=>'http://'.$_SERVER['HTTP_HOST'].(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:(isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:'')),
		'message'=>'��ƽ̨�Ƿ���½(����ƽ̨)��',
		'uid'=> $jieqiUsers->getVar('uid', 'n'),
		'uname'=> $jieqiUsers->getVar('uname', 'n')
		);
		https_request_recod_new('http://www.flyskycode.com/api/api_record.php',$data);
		return -99;
	}


	$truepass = $jieqiUsers->getVar('pass', 'n');
	if($truepass == '') return -10;
	if($encode) $encpass=$password;
	else $encpass=$users_handler->encryptPass($password);
	if($truepass != $encpass){
		return -5;
	}
	
	if($encode){
		$userset=unserialize($jieqiUsers->getVar('setting','n'));
		if($userset['lastip']!=jieqi_userip()){
			@setcookie('jieqiUserInfoTk', NULL, 0, '/',  JIEQI_COOKIE_DOMAIN, 0);
			return -8;
		}
	}

	return $jieqiUsers;
}

/**
 * �û���¼����
 * 
 * @param      object      $jieqiUsers �û�����
 * @access     public
 * @return     bool
 */
function jieqi_loginprocess($jieqiUsers, $usecookie = 0){
	global $jieqiConfigs;
	global $jieqiHonors;
	global $jieqiGroups;
	
	if(!isset($jieqiConfigs['system'])) jieqi_getConfigs('system', 'configs');
	include_once(JIEQI_ROOT_PATH_APP.'/class/users.php');
	$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');

	// //��cookie��Ϣ
	// $jieqi_user_info=array();
	// if(!empty($_COOKIE['jieqiUserInfoTk'])) $jieqi_user_info=jieqi_strtosary($_COOKIE['jieqiUserInfoTk']);
	// else $jieqi_user_info=array();

	// $jieqi_visit_info=array();
	// if(!empty($_COOKIE['jieqiVisitInfoTk'])) $jieqi_visit_info=jieqi_strtosary($_COOKIE['jieqiVisitInfoTk']);
	// else $jieqi_visit_info=array();
	

	//����û��ϴε��˳�ʱ��
	if (!empty($_COOKIE[$jieqiUsers->getVar('uid')])){
		$preLoginOutTime = $_COOKIE[$jieqiUsers->getVar('uid')];
	}else{
	    if (!empty($jieqi_user_info['jieqiUserLogin'])) {
		$preLoginOutTime = JIEQI_NOW_TIME - $jieqi_user_info['jieqiUserLogin'] < 1800 ? JIEQI_NOW_TIME - $jieqi_user_info['jieqiUserLogin']:JIEQI_NOW_TIME - 1800;
		}else{
			$preLoginOutTime = JIEQI_NOW_TIME - 1800;
		}
	}

	//�û���Ϣ
	$previewlogin=intval($jieqiUsers->getVar('lastlogin'));
	$jieqiUsers->setVar('lastlogin', JIEQI_NOW_TIME);
	$userset=unserialize($jieqiUsers->getVar('setting','n'));
	if(!isset($userset['lastip']) || $userset['lastip'] != jieqi_userip()) $userset['lastip'] = jieqi_userip();
	$userset['logindate']=date('Y-m-d H:i:s');
	$jieqiUsers->setVar('setting', serialize($userset));
	$users_handler->insert($jieqiUsers);
	
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	jieqi_setusersession($jieqiUsers);
	


	// ����΢�����ʺ�
	$newWeiboUseAr=array('110'=>1,'112'=>1);
	$_SESSION['newWeiboUse']=isset($newWeiboUseAr[$_SESSION['jieqiUserId']])?1:0;




	$jieqi_user_info['jieqiUserId']=$_SESSION['jieqiUserId'];
	$jieqi_user_info['jieqiUserUname']=$_SESSION['jieqiUserUname'];
	
	if($usecookie) $jieqi_user_info['jieqiUserPassword']=$jieqiUsers->getVar('pass', 'n');//$encpass;
	include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
	
	if(JIEQI_SYSTEM_CHARSET == 'gbk'){
		$jieqi_user_info['jieqiUserUname_un']=jieqi_gb2unicode($_SESSION['jieqiUserUname']);
	}else{
		$jieqi_user_info['jieqiUserUname_un']=jieqi_big52unicode($_SESSION['jieqiUserUname']);
	}

	$jieqi_user_info['jieqiUserLogin']=JIEQI_NOW_TIME;
	if($usecookie < 0) $usecookie=0;
	elseif($usecookie == 1) $usecookie=315360000;
	if($usecookie) $cookietime=JIEQI_NOW_TIME + $usecookie;
	else $cookietime=0; 

	// @setcookie('jieqiUserInfoTk', jieqi_sarytostr($jieqi_user_info), $cookietime, '/',  JIEQI_COOKIE_DOMAIN, 0);
	// $jieqi_visit_info['jieqiUserLogin']=$jieqi_user_info['jieqiUserLogin'];
	// $jieqi_visit_info['jieqiUserId']=$jieqi_user_info['jieqiUserId'];
	// @setcookie('jieqiVisitInfoTk', jieqi_sarytostr($jieqi_visit_info), JIEQI_NOW_TIME+99999999, '/',  JIEQI_COOKIE_DOMAIN, 0);
	
	return 0;
}
?>