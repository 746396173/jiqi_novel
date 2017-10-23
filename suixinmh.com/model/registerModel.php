<?php 
/** 
 * ����ģ�� * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class registerModel extends Model{

    var $redis = null;
	
	//���û�ע�����
	function main($params = array()){
		//��������
		$this->addLang('system', 'users');
		$this->addConfig('system','configs');
		$jieqiLang['system'] = $this->getLang('system');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		
		if (empty($params['jumpurl'])) {
		   $params['jumpurl'] = empty($_SERVER['HTTP_REFERER'])? JIEQI_LOCAL_URL :$_SERVER['HTTP_REFERER'];
		}
		//�ύ����
		if($this->submitcheck()){
		     $this->register($params);
		}
		$data = array();
		if(!empty($jieqiConfigs['system']['checkcodelogin'])) $data['show_checkcode'] = 1;
		else $data['show_checkcode'] = 0;
		$data['jumpurl'] = $params['jumpurl'];
		$data['url_checkcode'] = JIEQI_USER_URL.'/checkcode.php';
		return $data;
	}
	
	function register($params = array()){
		global $jieqiLang, $jieqiConfigs, $jieqiModules;
		define('JIEQI_NEED_SESSION', 1);
		//�Ƿ�����ע��
		if (!defined("JIEQI_ALLOW_REGISTER") || JIEQI_ALLOW_REGISTER != 1) {
			$this->printfail($jieqiLang['system']['user_stop_register']);
			exit();
		}

 		//wap����Ƿ�ѡ�û�Э��
		if($params['list'] && $params['checkbox'] != 9) $this->printfail($jieqiLang['system']['register_checkbox']);
		//�������
		if (strlen($params['password'])==0 || (strlen($params['repassword'])==0 && !$params['norepsw']))  $this->printfail( $jieqiLang['system']['need_pass_repass']);
		elseif ($params['password'] != $params['repassword'] && $params['repassword']) $this->printfail( $jieqiLang['system']['password_not_equal']);
		
		//�����֤��
		if(!empty($jieqiConfigs['system']['checkcodelogin']) && $params['checkcode'] != $_SESSION['jieqiCheckCode']) $this->printfail( $jieqiLang['system']['error_checkcode']);

		//ͬһ��IP�ظ�ע��ʱ������
        if (!$this->redis) {
            include_once(JIEQI_ROOT_PATH . '/lib/database/redis.php');
            $this->redis = new MyRedis(JIEQI_REDIS_HOST, JIEQI_REDIS_PORT);
        }
        $user_ip = $this->getIp();
        $reg_ip_check = $this->check_ip_registered($user_ip);
        if ($reg_ip_check > 500) { //ÿ��IP����һСʱע�᲻����10���˺�
            $this->printfail(sprintf($jieqiLang['system']['user_register_timelimit']."����IP��".$user_ip, $jieqiConfigs['system']['regtimelimit']));
        }

        //$jieqiConfigs['system']['regtimelimit'] = intval($jieqiConfigs['system']['regtimelimit']);
        $jieqiConfigs['system']['regtimelimit'] = 3600;
        $this->store_registered_ip($user_ip, $jieqiConfigs['system']['regtimelimit'],$reg_ip_check);


//		if($jieqiConfigs['system']['regtimelimit']>0 && $this->getIp()!='10.168.85.67' && $this->getIp()!='113.140.9.50'){
//			$ip=jieqi_userip();
//			$this->db->init('registerip','ip','system');
//			$this->db->setCriteria(new Criteria('ip', jieqi_dbslashes($ip)));
//			$regtime = JIEQI_NOW_TIME - $jieqiConfigs['system']['regtimelimit'] * 3600;
//			$this->db->criteria->add(new Criteria('regtime', $regtime, '>'));
//			if($this->db->getCount($this->db->criteria)){
//				$this->printfail(sprintf($jieqiLang['system']['user_register_timelimit'], $jieqiConfigs['system']['regtimelimit']));
//			}
//		}
		$pattern = '�����¼�|��ҩ|�Ի�ҩ|������|���ϲ�|����ǹ֧|�˵�|������|����ҩ|��������|ɫ�����|����ǿӲ|�ض�|����|����|����ǹ֧|�����¼�|��ҩ|�Ի�ҩ|������|���ϲ�|����ǹ֧|�˵�|������|����ҩ|��������|ɫ�����|����ǿӲ|�ض�|����|����|����ǹ֧|��Ѩ|�鶯|���|��С��|��С��|��Ħ����|��ӷ���|��ҹ����|����椷���|�Ұ������|����ȫ�׷���|һҹ��|�Ұ������|����Ů����|Ԯ�з���|Ԯ������|����椷���|�Ұ������|������Ħ|����ȫ�׷���|һҹ��|�Ұ������|����Ů����|Ԯ�з���|Ԯ������|С����ô��|������Ů��|������Ŀ|˫��|���л���|˿�����|������Ŀ|����������|���ŷ���|С������|������|������|��������������|������d|С�÷���|�������ŮƯ��|��������|������|������|������|������|С�����|�ṩ���С��|��������|��������|ģ��С��|���Ű���|��������|����㻤|�������|��į�ĸ���|��ҹ����|�����|��������|��ְģ��|�������|��ְ��Ů|��������|ģ������|��������|������|��������|���ŷ���|��������|���T����|�ҌW����|�ҌW�������T����|��С�����|��С��|��Ʊ|����ˮ|����ˮ|����ҩ|����ҩ|����С��';
        if($this->str_count(trim($params['username']),$pattern)){
			ob_start();
		    print_r($_REQUEST);
			//'$_SERVER)=��';print_r($_SERVER);
			$c = ob_get_contents();
			ob_end_clean();
			jieqi_writefile(JIEQI_ROOT_PATH.'/a.txt',$c,"a+");
		    $this->jumppage(urldecode($params['jumpurl']),'','ע��ɹ���' );
		}
		
		$params['username'] = trim($params['username']);
		$params['email'] = trim($params['email']);
		$params['password'] = trim($params['password']);
		$params['repassword'] = trim($params['repassword']);
		$params['checkbox'] = trim($params['checkbox']);
		if(empty($params['checkcode'])) $params['checkcode']='';
		else $params['checkcode'] = trim($params['checkcode']);
		
		$errtext='';
		include_once(JIEQI_ROOT_PATH.'/lib/text/textfunction.php');
		include_once(JIEQI_ROOT_PATH.'/class/users.php');
		$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
		$errtext .= $this->checkUser($params, true);
		//$errtext .= $this->checkEmail($params, true);

		//��¼ע����Ϣ
		if(empty($errtext)) {
			$newUser = $users_handler->create();
			$newUser->setVar('siteid', $jieqiModules[JIEQI_MODULE_NAME]['siteid']);
			$newUser->setVar('uname', $params['username']);
			$newUser->setVar('name', $params['username']);
			$newUser->setVar('pass', $users_handler->encryptPass($params['password']));
			$newUser->setVar('groupid', JIEQI_GROUP_USER);
			$newUser->setVar('regdate', JIEQI_NOW_TIME);
			$newUser->setVar('initial', jieqi_getinitial($params['username']));
			$newUser->setVar('sex', $params['sex']);
			if(!$params['wap_email']){$newUser->setVar('email', $params['email']);}
			$newUser->setVar('email', $params['email']);
			$newUser->setVar('url', $params['url']);
			$newUser->setVar('avatar', 0);
			$newUser->setVar('workid', 0);
			$newUser->setVar('qq', $params['qq']);
			$newUser->setVar('icq', '');
			$newUser->setVar('msn', $params['msn']);
			$newUser->setVar('mobile', '');
			$newUser->setVar('sign', '');
			$newUser->setVar('intro', '');
			$userset = array();
			$userset['logindate'] = date('Y-m-d H:i:s',JIEQI_NOW_TIME);
			$userset['lastip'] = $this->getIp();
			$userset['source'] = $_SESSION['SOURCE_SITE'] ? $_SESSION['SOURCE_SITE'] : $_COOKIE['SOURCE_SITE'] ;
			if (strpos($userset['source'],'_')!==false) {
                $source_x=explode('_',$userset['source']);
                $source=$source_x[0];
                $book_id=$source_x[1];
            }
            else {
                $source=$userset['source'];
                $book_id = 0;
            }
			$newUser->setVar('setting', serialize($userset));
			$newUser->setVar('badges', '');
			$newUser->setVar('lastlogin', JIEQI_NOW_TIME);
			$newUser->setVar('showsign', 0);
			$newUser->setVar('viewemail', $params['viewemail']);
			$newUser->setVar('notifymode', 0);
			$newUser->setVar('adminemail', $params['adminemail']);
			$newUser->setVar('monthscore', 0);
			$newUser->setVar('experience', $jieqiConfigs['system']['scoreregister']);
			$newUser->setVar('score', $jieqiConfigs['system']['scoreregister']);
			$newUser->setVar('source', $source);
            $newUser->setVar('book_id', $book_id);
			$newUser->setVar('egold', 0);
			$newUser->setVar('esilver', 0);
			$newUser->setVar('credit', 0);
			$newUser->setVar('goodnum', 0);
			$newUser->setVar('badnum', 0);
			$newUser->setVar('isvip', 0);
			$newUser->setVar('overtime', 0);
			$newUser->setVar('state', 0);
			if (!$users_handler->insert($newUser)) $this->printfail($jieqiLang['system']['register_failure']);
			else {
				//�Զ���¼
				//��¼ע��ʱ��IP
				if($jieqiConfigs['system']['regtimelimit']>0){
//					$sql="DELETE FROM ".$this->dbprefix('system_registerip')." WHERE regtime<".(JIEQI_NOW_TIME - ($jieqiConfigs['system']['regtimelimit'] > 72 ? $jieqiConfigs['system']['regtimelimit'] : 72) * 3600);
//					$this->db->query($sql);
//					$sql="INSERT INTO ".$this->dbprefix('system_registerip')." (ip, regtime, count) VALUES ('".$this->getFormat($ip,'q')."', '".JIEQI_NOW_TIME."', '0')";
//					$this->db->query($sql);
				}

				//���������û���
				include_once(JIEQI_ROOT_PATH.'/include/visitorinfo.php');
				$this->db->init('online','uid','system');
				$online = array();
				$online['uid'] = $newUser->getVar('uid', 'n');
				$online['siteid'] = JIEQI_SITE_ID;
				$online['sid'] = session_id();
				$online['uname'] = $newUser->getVar('uname', 'n');
				$tmpvar = strlen($newUser->getVar('name', 'n')) > 0 ? $newUser->getVar('name', 'n') : $newUser->getVar('uname', 'n');
				$online['name'] = $tmpvar;
				$online['pass'] = $newUser->getVar('pass', 'n');
				$online['email'] = $newUser->getVar('email', 'n');
				$online['groupid'] = $newUser->getVar('groupid', 'n');
				$tmpvar=JIEQI_NOW_TIME;
				$online['logintime'] = $tmpvar;
				$online['updatetime'] = $tmpvar;
				$online['operate'] = '';
				$tmpvar=VisitorInfo::getIp();
				$online['ip'] = $tmpvar;
				$online['browser'] = VisitorInfo::getBrowser();
				$online['os'] = VisitorInfo::getOS();
				$location=VisitorInfo::getIpLocation($tmpvar);
				if(JIEQI_SYSTEM_CHARSET == 'big5'){
					include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
					$location=jieqi_gb2big5($location);
				}
				$online['location'] = $location;
				$online['state'] = '0';
				$online['flag'] = '0';
				$newUserID = $this->db->add($online);

				//����SESSION
				jieqi_setusersession($newUser);

				//����COOKIE
				$jieqi_user_info['jieqiUserId']=$_SESSION['jieqiUserId'];
				$jieqi_user_info['jieqiUserName']=$_SESSION['jieqiUserName'];
				$jieqi_user_info['jieqiUserGroup']=$_SESSION['jieqiUserGroup'];

				include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
				if(JIEQI_SYSTEM_CHARSET == 'gbk') $jieqi_user_info['jieqiUserName_un']=jieqi_gb2unicode($_SESSION['jieqiUserName']);
				else $jieqi_user_info['jieqiUserName_un']=jieqi_big52unicode($_SESSION['jieqiUserName']);
				$jieqi_user_info['jieqiUserLogin']=JIEQI_NOW_TIME;
				
				$usecookie=1;
				
				if($usecookie < 0) $usecookie=0;
				elseif($usecookie == 1) $usecookie=315360000;
				if($usecookie) $cookietime=JIEQI_NOW_TIME + $usecookie;
				else $cookietime=0; 
				
				@setcookie('jieqiUserInfo', jieqi_sarytostr($jieqi_user_info), $cookietime, '/',  JIEQI_COOKIE_DOMAIN, 0);
				$jieqi_visit_info['jieqiUserLogin']=$jieqi_user_info['jieqiUserLogin'];
				$jieqi_visit_info['jieqiUserId']=$jieqi_user_info['jieqiUserId'];
				@setcookie('jieqiVisitInfo', jieqi_sarytostr($jieqi_visit_info), JIEQI_NOW_TIME+99999999, '/',  JIEQI_COOKIE_DOMAIN, 0);

				//�ƹ����
				if(JIEQI_PROMOTION_REGISTER > 0 && !empty($_COOKIE['jieqiPromotion'])){
					$users_handler->changeCredit(intval($_COOKIE['jieqiPromotion']), intval(JIEQI_PROMOTION_REGISTER), true);
					setcookie('jieqiPromotion', '', 0, '/', JIEQI_COOKIE_DOMAIN, 0);
				}
				include_once(JIEQI_ROOT_PATH.'/include/funuser.php');
				jieqi_registerdo(urldecode($params['jumpurl']));
			}
		} else {
			$this->printfail($errtext);
		}
	}
	function str_count($str,$needle,$case=0){
		if(!$str || !$needle) return 0;
		$str = str_replace( array("��","��","."," ","��","��","��"), "", $str ); 
		$str = preg_replace( "@&nbsp;|\r\n|=|��|��|\.| |��|��|��|��|��|��|��|��|��|��|\n|-|<script(.*?)</script>@is", "", $str ); 
		$str = preg_replace( "@<iframe(.*?)</iframe>@is", "", $str ); 
		$str = preg_replace( "@<style(.*?)</style>@is", "", $str ); 
		$str = preg_replace( "@<(.*?)>@is", "", $str ); 
		$pattern = "/[".chr(0xa1)."-".chr(0xff)."]+/";
		preg_match_all($pattern,$str,$matches);
		foreach($matches[0] as $v){
		   $str.=trim(iconv('utf-8','gbk',$v));
		}  
		if($case){
			preg_match_all("/(".$needle.")/is",$str,$matches);
		}else{
			preg_match_all("/(".$needle.")/s",$str,$matches);
		}
		return count($matches[1]);
	}
	function checkUser($params = array(),$isreturn = false){
	    global  $jieqiLang;
		//��������
		$this->addLang('system', 'users');
		$retmsg = array();
		$errtext = '';
	    include_once(JIEQI_ROOT_PATH.'/lib/text/textfunction.php');
		include_once(JIEQI_ROOT_PATH.'/class/users.php');
		$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
		//$_REQUEST['ajax_request'] = 1;
		if (strlen($params['username'])==0) $this->printfail($jieqiLang['system']['need_username']);
		if (strlen($params['username'])>30 || strlen($params['username'])<1) $this->printfail($jieqiLang['system']['register_user_length']);
		elseif (!jieqi_safestring($params['username'])) $this->printfail( $jieqiLang['system']['error_user_format']);
		elseif(!preg_match('/^[\x7f-\xffa-zA-Z0-9_\.\@\-]{2,30}$/is', $params['username'])) $this->printfail( $jieqiLang['system']['error_user_format']);
		elseif(preg_match('/^\s*$|^c:\\con\\con$|[%,;\|\*\"\'\\\\\/\s\t\<\>\&]/is', $params['username'])) $this->printfail( $jieqiLang['system']['error_user_format']);
		elseif (strpos($params['username'], '��') !== false) $this->printfail( $jieqiLang['system']['error_user_format']);
		elseif($jieqiConfigs['system']['usernamelimit']==1 && !preg_match('/^[A-Za-z0-9]+$/',$params['username'])) $this->printfail( $jieqiLang['system']['username_need_engnum']);
		elseif($users_handler->getByname($params['username'], 3)>0){//�Ƿ���ע��
			$errtext = $jieqiLang['system']['user_has_registered'];
		}
		if($errtext){
		     include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
		     $retmsg['error'] = $errtext;
		}else  $retmsg['ok'] = '';
		if(!$isreturn) exit($this->json_encode($retmsg));
		else return $errtext;
	}
	
	function checkEmail($params = array(),$isreturn = false){
		global $jieqiLang;
		$this->addLang('system', 'users');
		$retmsg = array();
		$errtext = '';
	    include_once(JIEQI_ROOT_PATH.'/lib/text/textfunction.php');
		include_once(JIEQI_ROOT_PATH.'/class/users.php');
		$users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
		if (strlen($params['email'])==0) $this->printfail( $jieqiLang['system']['need_email']);
		elseif (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i",$params['email'])) $this->printfail( $jieqiLang['system']['error_email_format']);
		elseif($users_handler->getCount(new Criteria('email', $params['email'], '=')) > 0) $errtext = $jieqiLang['system']['email_has_registered'];
		if($errtext){
		     include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
		     $retmsg['error'] = $errtext;
		}else  $retmsg['ok'] = '';
		if(!$isreturn) exit($this->json_encode($retmsg));
		else return $errtext;
	}

    private function check_ip_registered($ip)
    {
		//return true;
        $white_ip_list=array("10.168.85.67","113.140.9.50");
        if (in_array($ip,$white_ip_list)) {
            return 1;
        }
		$cache_key = "register_{$ip}_".date("YmdH");
        return $this->redis->get($cache_key);
    }

    private function store_registered_ip($ip,$timeout,$num=1) {
        $cache_key = "register_{$ip}_".date("YmdH");
        if ($num>=1) {
            return $this->redis->increment($cache_key);
        }
        else {
            return $this->redis->set($cache_key, 1, $timeout);
        }
    }
} 
?>