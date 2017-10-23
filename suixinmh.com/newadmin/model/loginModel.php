<?php 
/** 
 * ϵͳ����->�û������ * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class loginModel extends Model{
	//login form
	public function main(){
		global $jieqiConfigs;
		jieqi_getconfigs(JIEQI_MODULE_NAME, 'configs');
		$data = array();
		$_REQUEST = $this->getRequest();
		$self_fname = $_SERVER['PHP_SELF'] ? basename($_SERVER['PHP_SELF']) : basename($_SERVER['SCRIPT_NAME']);
		if (!empty($_REQUEST['jumpurl'])) {
			$data['url_login'] = $this->getAdminurl('login','method=login&do=submit&jumpurl='.urlencode($_REQUEST['jumpurl']));
		}else{
			$data['url_login'] = $this->getAdminurl('login','method=login&do=submit');
		}
		if(empty($_SESSION['jieqiUserId'])){
			$data['jieqi_userid'] = 0;
			$data['jieqi_username'] = '';
		}else{
			
			$data['jieqi_userid'] = $_SESSION['jieqiUserId'];
			$data['jieqi_username'] = jieqi_htmlstr($_SESSION['jieqiUserUname']);
		}
		 
		if(!empty($jieqiConfigs['system']['checkcodelogin'])) $data['show_checkcode'] = 1;
		else $data['show_checkcode'] = 0;
		
		if(empty($jieqiConfigs['system']['usegd'])){
			$data['usegd'] = 0;
		}else{
			$data['usegd'] = 1;
		}
		$data['url_checkcode'] = JIEQI_USER_URL.'/checkcode.php';
		//$jieqiTpl->assign('url_checkcode', JIEQI_USER_URL.'/checkcode.php');
		//$jieqiTpl->setCaching(0);
		//$jieqiTset['jieqi_contents_template'] = JIEQI_ROOT_PATH.'/templates/admin/login.html';
		return $data;
	}
	
	
	
	//login
    public function login(){
        include_once(JIEQI_ROOT_PATH."/include/funsystem.php");
        global $jieqiConfigs, $jieqiLang;
        jieqi_getconfigs(JIEQI_MODULE_NAME, 'configs');
        jieqi_loadlang('users', JIEQI_MODULE_NAME);
        $_REQUEST = $this->getRequest();
        if(!empty($_REQUEST['username']) && !empty($_REQUEST['password'])){
            //δ��¼����������ʺŵ�¼
            //$_REQUEST['username']=strtolower(trim($_REQUEST['username']));
            $_REQUEST['username']=trim($_REQUEST['username']);
            include_once(JIEQI_ROOT_PATH.'/include/checklogin.php');
            if(isset($_REQUEST['usecookie']) && is_numeric($_REQUEST['usecookie'])) $_REQUEST['usecookie']=intval($_REQUEST['usecookie']);
            else $_REQUEST['usecookie']=0;
            if(empty($_REQUEST['checkcode'])) $_REQUEST['checkcode']='';
            $islogin=jieqi_logincheck($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['checkcode'], $_REQUEST['usecookie']);
            echo "islogin=$islogin";
            if($islogin==0){
                if (empty($_REQUEST['jumpurl'])) {
                    $_REQUEST['jumpurl']='/';
                }
                header("location:".$_REQUEST['jumpurl']);
                exit();
            }else{
                //���� 0 ����, -1 �û���Ϊ�� -2 ����Ϊ�� -3 �û�����������Ϊ��
                //-4 �û��������� -5 ������� -6 �û������������ -7 У������� -8 �ʺ��Ѿ����˵�½
                switch($islogin){
                    case -1:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['need_username']));
                        break;
                    case -2:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['need_password']));
                        break;
                    case -3:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['need_userpass']));
                        break;
                    case -4:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['no_this_user']));
                        break;
                    case -5:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['error_password']));
                        break;
                    case -6:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['error_userpass']));
                        break;
                    case -7:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['error_checkcode']));
                        break;
                    case -8:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['other_has_login']));
                        break;
                    default:
                        fail(iconv("GBK","UTF-8",$jieqiLang['system']['login_failure']));
                        break;
                }
            }
        }
    }

    public function logout(){
        global $jieqiConfigs, $jieqiLang, $jieqi_image_type;
        $_REQUEST = $this->getRequest();
        define('JIEQI_ADMIN_LOGIN', 1);
        $this->addLang('system', 'users');
        include_once(JIEQI_ROOT_PATH.'/include/dologout.php');
        jieqi_dologout();
        header('location:/');
    }
	
} 
?>