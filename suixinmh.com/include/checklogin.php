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
				include_once(JIEQI_ROOT_PATH.'/class/users.php');
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
	if(!empty($jieqiConfigs['system']['checkcodelogin']) && $needcheck){
	    if(empty($checkcode) || $checkcode != $_SESSION['jieqiCheckCode'])	return -7;
	}
	//����û���������
	include_once(JIEQI_ROOT_PATH.'/class/users.php');
	$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
	$criteria = new CriteriaCompo(new Criteria('uname', $username));
	$users_handler->queryObjects($criteria);
	$jieqiUsers=$users_handler->getObject();
	if (!$jieqiUsers){
		return -4;
	}
	$truepass = $jieqiUsers->getVar('pass', 'n');
	if($truepass == '') return -10;
	if($encode) $encpass=$password;
	else $encpass=$users_handler->encryptPass($password);
	if($truepass != $encpass){
		return -5;
	}
	
	if($jieqiUsers->getVar('groupid', 'n') == JIEQI_GROUP_GUEST){
		return -9;
	}
	if($encode){
		$userset=unserialize($jieqiUsers->getVar('setting','n'));
		if($userset['lastip']!=jieqi_userip()){
			@setcookie('jieqiUserInfo', NULL, 0, '/',  JIEQI_COOKIE_DOMAIN, 0);
			return -8;
		}
	}
    //echo "uid=".$username.",ip=".jieqi_userip()."<br>";
    $time=time();
    $ip=jieqi_userip();
    mysql_query("insert into ".jieqi_dbprefix("login_log")." (username,ip,logtime) values('".addslashes($username)."','$ip','$time')");
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
	include_once(JIEQI_ROOT_PATH.'/class/users.php');
	$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
	//���������û���
	include_once(JIEQI_ROOT_PATH.'/class/online.php');
	$online_handler =& JieqiOnlineHandler::getInstance('JieqiOnlineHandler');
	$criteria = new CriteriaCompo(new Criteria('uid', $jieqiUsers->getVar('uid', 'n')));
	$criteria->setSort('updatetime');
	$criteria->setOrder('DESC');
	$online_handler->queryObjects($criteria);
	$online=$online_handler->getObject();
	
	//��cookie��Ϣ
	$jieqi_user_info=array();
	if(!empty($_COOKIE['jieqiUserInfo'])) $jieqi_user_info=jieqi_strtosary($_COOKIE['jieqiUserInfo']);
	else $jieqi_user_info=array();
	$jieqi_visit_info=array();
	if(!empty($_COOKIE['jieqiVisitInfo'])) $jieqi_visit_info=jieqi_strtosary($_COOKIE['jieqiVisitInfo']);
	else $jieqi_visit_info=array();
	
	
	if(is_object($online)){
		$ip=jieqi_userip();
		if (JIEQI_SESSION_EXPRIE > 0) $exprie_time=JIEQI_SESSION_EXPRIE;
		else $exprie_time=@ini_get('session.gc_maxlifetime');
		if(empty($exprie_time)) $exprie_time=1800;
		if(defined('JIEQI_DENY_RELOGIN') && JIEQI_DENY_RELOGIN==1 && JIEQI_NOW_TIME - $online->getVar('updatetime') < $exprie_time && $online->getVar('ip', 'n') != $ip && $jieqi_visit_info['jieqiUserId'] != $jieqiUsers->getVar('uid')){
			return -8;
		}
		$tmpvar = strlen($jieqiUsers->getVar('name', 'q')) > 0 ? $jieqiUsers->getVar('name', 'q') : $jieqiUsers->getVar('uname', 'q');
		
		$sql="UPDATE ".jieqi_dbprefix('system_online')." SET uid=".$jieqiUsers->getVar('uid', 'q').", sid='".jieqi_dbslashes(session_id())."', uname='".$jieqiUsers->getVar('uname', 'q')."', name='".$tmpvar."', pass='".$jieqiUsers->getVar('pass', 'q')."',email='".$jieqiUsers->getVar('email', 'q')."', groupid=".$jieqiUsers->getVar('groupid', 'q').", updatetime=".JIEQI_NOW_TIME.", ip='".jieqi_dbslashes($ip)."' WHERE uid=".$jieqiUsers->getVar('uid', 'q')." OR sid='".jieqi_dbslashes(session_id())."'";
		$online_handler->db->query($sql);
	}else {
		include_once(JIEQI_ROOT_PATH.'/include/visitorinfo.php');
        $online = $online_handler->create();
        $online->setVar('uid', $jieqiUsers->getVar('uid', 'n'));
        $online->setVar('siteid', JIEQI_SITE_ID);
        $online->setVar('sid', session_id());
		$online->setVar('uname', $jieqiUsers->getVar('uname', 'n'));
		$tmpvar = strlen($jieqiUsers->getVar('name', 'n')) > 0 ? $jieqiUsers->getVar('name', 'n') : $jieqiUsers->getVar('uname', 'n');
		$online->setVar('name', $tmpvar);
		$online->setVar('pass', $jieqiUsers->getVar('pass', 'n'));
		$online->setVar('email', $jieqiUsers->getVar('email', 'n'));
		$online->setVar('groupid', $jieqiUsers->getVar('groupid', 'n'));
		$tmpvar=JIEQI_NOW_TIME;
		$online->setVar('logintime', $tmpvar);	
		$online->setVar('updatetime', $tmpvar);	
		$online->setVar('operate', '');	
		$tmpvar=VisitorInfo::getIp();
		$online->setVar('ip', $tmpvar);	
		$online->setVar('browser', VisitorInfo::getBrowser());	
		$online->setVar('os', VisitorInfo::getOS());
		$location=VisitorInfo::getIpLocation($tmpvar);
		if(JIEQI_SYSTEM_CHARSET == 'big5'){
			include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
			$location=jieqi_gb2big5($location);
		}
		$online->setVar('location', $location);
		$online->setVar('state', '0');
		$online->setVar('flag', '0');	
		$online_handler->insert($online);
	}
	//ɾ�����ڵ������û�
	unset($criteria);
	$criteria = new CriteriaCompo(new Criteria('updatetime', JIEQI_NOW_TIME-$jieqiConfigs['system']['onlinetime'], '<'));
	$online_handler->delete($criteria);
	 
	//����û��ϴε��˳�ʱ��
	if (!empty($_COOKIE[$jieqiUsers->getVar('uid')])){
		$preLoginOutTime = $_COOKIE[$_SESSION['jieqiUserId']];
	}else{
	    if (!empty($jieqi_user_info['jieqiUserLogin'])) {
		$preLoginOutTime = JIEQI_NOW_TIME - $jieqi_user_info['jieqiUserLogin'] < 1800 ? JIEQI_NOW_TIME - $jieqi_user_info['jieqiUserLogin']:JIEQI_NOW_TIME - 1800;
		}else{
			$preLoginOutTime = JIEQI_NOW_TIME - 1800;
		}
	}
	$queryHandler = JieqiQueryHandler::getInstance('JieqiQueryHandler');
	//��鶯̬��֪ͨ��
	/*$criteria=new CriteriaCompo(new Criteria('s.uid',$jieqiUsers->getVar('uid'), '='));
	$criteria->setTables(jieqi_dbprefix('article_statlog')." AS s LEFT JOIN ".jieqi_dbprefix('article_article')." AS a ON s.articleid=a.articleid ");
	$criteria->add(new Criteria('a.authorid',$jieqiUsers->getVar('uid'), '='),'or');
	$criteria->add(new Criteria('s.addtime', intval($preLoginOutTime),'>='));
	$criteria->setFields('s.*,a.articlename,a.authorid');
	$newtongzhi = $queryHandler->getCount($criteria);
	unset($criteria);*/
	
	//����˿
	/*$criteria=new CriteriaCompo(new Criteria('myid', $jieqiUsers->getVar('uid'),'='));
	$criteria->add(new Criteria('adddate', intval($preLoginOutTime),'>='));
    $criteria->setTables(jieqi_dbprefix('system_friends'));
	$newfriend = $queryHandler->getCount($criteria);
	unset($criteria);*/
/*	$this->db->init('friends','friendsid','system');
	$this->db->setCriteria(new Criteria('myid', $jieqiUsers->getVar('uid'),'='));*/
	/*if (!$preLoginTime)
	{
		$this->db->criteria->add(new Criteria('adddate', intval($jieqiUserInfo['jieqiUserLogin'])-3600*24*7,'>='));
	}else{
		$this->db->criteria->add(new Criteria('adddate', intval($preLoginTime),'>='));
	}*/
	/*$res= $this->db->queryObjects();
	$newfriend = $this->db->getRowsNum($res);*/
    //������Ϣ
    include_once(JIEQI_ROOT_PATH.'/class/message.php');
    $message_handler=JieqiMessageHandler::getInstance('JieqiMessageHandler');
    $criteria=new CriteriaCompo(new Criteria('toid', $jieqiUsers->getVar('uid'), '='));
    $criteria->add(new Criteria('isread', 0, '='));
    $criteria->add(new Criteria('todel', 0, '='));
    $newmsgnum=$message_handler->getCount($criteria);
    unset($criteria);
	 //�ж���Ϣ
	 
    //if($jieqiUsers->getVar('uname', 'n')!='phper'){
		//�û���Ϣ
		$previewlogin=intval($jieqiUsers->getVar('lastlogin'));
		$jieqiUsers->setVar('lastlogin', JIEQI_NOW_TIME);
		$userset=unserialize($jieqiUsers->getVar('setting','n'));
		if(!isset($userset['lastip']) || $userset['lastip'] != jieqi_userip()) $userset['lastip'] = jieqi_userip();
		if(!isset($userset['logindate']) || substr($userset['logindate'],0,10) != date('Y-m-d')){
			//���ӵ�½����
			$jieqiUsers->setVar('experience', $jieqiUsers->getVar('experience')+$jieqiConfigs['system']['scorelogin']);
			$jieqiUsers->setVar('score', $jieqiUsers->getVar('score')+$jieqiConfigs['system']['scorelogin']);
		}
		$userset['logindate']=date('Y-m-d H:i:s');
		//��������ˣ�����»���
		//if(date('Y-m', $previewlogin) != date('Y-m', JIEQI_NOW_TIME)) $jieqiUsers->setVar('monthscore', 0);
		$jieqiUsers->setVar('setting', serialize($userset));
	
	//}
	$users_handler->insert($jieqiUsers);
	
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	//����SESSION
	//if($jieqiUsers->getVar('uname', 'n')=='phper') $jieqiUsers->setVar('groupid', 2);
	jieqi_setusersession($jieqiUsers);
	
	if($newmsgnum > 0) $_SESSION['jieqiNewMessage'] = $newmsgnum;
/*	if($newtongzhi > 0) $_SESSION['jieqiNewTongZhi'] = $newtongzhi;
	if($newfriend > 0) $_SESSION['jieqiNewFriend'] = $newfriend;*/
	
	//��̨��¼״̬
	$jieqi_online_info = empty($_COOKIE['jieqiOnlineInfo']) ? array() : jieqi_strtosary($_COOKIE['jieqiOnlineInfo']);
	if(isset($jieqi_online_info['jieqiAdminLogin']) && $jieqi_online_info['jieqiAdminLogin'] == 1) $_SESSION['jieqiAdminLogin'] = 1;

	$jieqi_user_info['jieqiUserId']=$_SESSION['jieqiUserId'];
	$jieqi_user_info['jieqiUserUname']=$_SESSION['jieqiUserUname'];
	$jieqi_user_info['jieqiUserName']=$_SESSION['jieqiUserName'];
	$jieqi_user_info['jieqiUserGroup']=$_SESSION['jieqiUserGroup'];
	$jieqi_user_info['jieqiUserGroupName']=$jieqiGroups[$_SESSION['jieqiUserGroup']];
	$jieqi_user_info['jieqiUserVip']=$_SESSION['jieqiUserVip'];
	$jieqi_user_info['jieqiUserHonorId']=$_SESSION['jieqiUserHonorId'];
	$jieqi_user_info['jieqiUserHonor']=$_SESSION['jieqiUserHonor'];
	
	if($newmsgnum > 0) $jieqi_user_info['jieqiNewMessage']=$newmsgnum;
/*	if($newtongzhi > 0) $jieqi_user_info['jieqiNewTongZhi']=$newtongzhi;
	if($newfriend > 0) $jieqi_user_info['jieqiNewFriend'] = $newfriend;*/
	if ($jieqi_messagenum > 0) $_SESSION['jieqi_messagenum'] = $jieqi_messagenum;
	if($usecookie) $jieqi_user_info['jieqiUserPassword']=$jieqiUsers->getVar('pass', 'n');//$encpass;
	include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
	
	if(JIEQI_SYSTEM_CHARSET == 'gbk'){
		$jieqi_user_info['jieqiUserUname_un']=jieqi_gb2unicode($_SESSION['jieqiUserUname']);
		$jieqi_user_info['jieqiUserName_un']=jieqi_gb2unicode($_SESSION['jieqiUserName']);
		$jieqi_user_info['jieqiUserHonor_un']=jieqi_gb2unicode($_SESSION['jieqiUserHonor']);
		$jieqi_user_info['jieqiUserGroupName_un']=jieqi_gb2unicode($jieqiGroups[$_SESSION['jieqiUserGroup']]);
	}else{
		$jieqi_user_info['jieqiUserUname_un']=jieqi_big52unicode($_SESSION['jieqiUserUname']);
		$jieqi_user_info['jieqiUserName_un']=jieqi_big52unicode($_SESSION['jieqiUserName']);
		$jieqi_user_info['jieqiUserHonor_un']=jieqi_big52unicode($_SESSION['jieqiUserHonor']);
		$jieqi_user_info['jieqiUserGroupName_un']=jieqi_gb2unicode($jieqiGroups[$_SESSION['jieqiUserGroup']]);
	}
	//session_start();
	$jieqi_user_info['jieqiUserLogin']=JIEQI_NOW_TIME;
	if($usecookie < 0) $usecookie=0;
	elseif($usecookie == 1) $usecookie=315360000;
	if($usecookie) $cookietime=JIEQI_NOW_TIME + $usecookie;
	else $cookietime=0; 
	//echo $cookietime;
	@setcookie('jieqiUserInfo', jieqi_sarytostr($jieqi_user_info), $cookietime, '/',  JIEQI_COOKIE_DOMAIN, 0);
	$jieqi_visit_info['jieqiUserLogin']=$jieqi_user_info['jieqiUserLogin'];
	$jieqi_visit_info['jieqiUserId']=$jieqi_user_info['jieqiUserId'];
	@setcookie('jieqiVisitInfo', jieqi_sarytostr($jieqi_visit_info), JIEQI_NOW_TIME+99999999, '/',  JIEQI_COOKIE_DOMAIN, 0);
	
	//���������û�
	include_once(JIEQI_ROOT_PATH.'/lib/template/template.php');
    $jieqiTpl =& JieqiTpl::getInstance();
    $jieqiTpl->clear_cache(JIEQI_ROOT_PATH.'/templates/online.html');
    
	return 0;
}
?>