<?php 
/** 
 * ϵͳ����->�û������ * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class loginModel extends Model{
  //login form
  public function main($params){
    global $jieqiConfigs;
    jieqi_getconfigs(JIEQI_MODULE_NAME, 'configs');
    if($this->submitcheck()){
      $this->loginDo($params);
    }
    $data = array();
    return $data;
  }
  
  /**
   * ��½
   * @param  [type] $params [description]
   * @return [type]         [description]
   */
  public function loginDo($params){
    global $jieqiConfigs, $jieqiLang;
    $this->addLang('system', 'users');
    $jieqiLang['system'] = $this->getLang('system');

    jieqi_getconfigs(JIEQI_MODULE_NAME, 'configs');
    // �ѵ�½����ת��
    if(isset($_SESSION['jieqiUserId']) && $_SESSION['jieqiUserId'] >0 ){
      ecs_header('Location: '.$this->geturl(JIEQI_MODULE_NAME, 'home'));
    }
    if(empty($params['username'])||empty($params['password']))$this->printfail('�������ʺ�!');

    //δ��¼����������ʺŵ�¼
    $params['username']=trim($params['username']);
         
    include_once(JIEQI_ROOT_PATH_APP.'/include/checklogin.php');

    if(isset($params['usecookie'])&&is_numeric($params['usecookie']))$params['usecookie']=intval($params['usecookie']);
    else $params['usecookie']=0;
    if(empty($params['checkcode'])) $params['checkcode']='';


    $islogin=jieqi_logincheck($params['username'], $params['password'], $params['checkcode'], $params['usecookie']);
    if($islogin==0){
      if (empty($params['jumpurl'])) {
        $params['jumpurl']=$this->geturl(JIEQI_MODULE_NAME, 'home');
      }
      $_SESSION['co_name']='';
      $_SESSION['co_qq']='';
      $_SESSION['co_phone']='';
      $_SESSION['co_img']='';
      jump_success('', '��¼�ɹ���',$this->geturl(JIEQI_MODULE_NAME, 'home'));

    }else{
      //���� 0 ����, -1 �û���Ϊ�� -2 ����Ϊ�� -3 �û�����������Ϊ��
      //-4 �û��������� -5 ������� -6 �û������������ -7 У������� -8 �ʺ��Ѿ����˵�½
      switch($islogin){
        case -1:
          jieqi_printfail($jieqiLang['system']['need_username']);
          break;
        case -2:
          jieqi_printfail($jieqiLang['system']['need_password']);
          break;
        case -3:
          jieqi_printfail($jieqiLang['system']['need_userpass']);
          break;
        case -4:
          jieqi_printfail($jieqiLang['system']['no_this_user']);
          break;
        case -5:
          jieqi_printfail($jieqiLang['system']['error_password']);
          break;
        case -6:
          jieqi_printfail($jieqiLang['system']['error_userpass']);
          break;
        case -7:
          jieqi_printfail($jieqiLang['system']['error_checkcode']);
          break;
        case -8:
          jieqi_printfail($jieqiLang['system']['other_has_login']);
          break;
        default:
          jieqi_printfail($jieqiLang['system']['login_failure']);
          break;
      }
    }
    
  }
  

  /**
   * ע��
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  function register($params = array()){         
    global $jieqiLang, $jieqiConfigs, $jieqiModules;
    $this->addLang('system', 'users');
    $jieqiLang['system'] = $this->getLang('system');
    jieqi_getconfigs(JIEQI_MODULE_NAME, 'configs');
    define('JIEQI_NEED_SESSION', 1);

    //wap����Ƿ�ѡ�û�Э��
    if( $params['agreement']!=1 ) $this->printfail($jieqiLang['system']['register_checkbox']);
 
    //�������
    if (strlen($params['password'])==0 )$this->printfail('���������룡');
 
    //��һ�����ŵ���֤
    if( !isset($params['msgcode']) 
      || !isset($params['phone']) 
      || !isset($_SESSION['r_h']) 
      || !isset($_SESSION['r_key']) 
      || !isset($_SESSION['r_time']) )$this->printfail('��������!');
    $q_time=time();
    $interval_time = 60*30; //��֤�����ʱ��
    if($q_time - $_SESSION['r_time'] > $interval_time){
      $this->printfail('��֤���ѹ��ڣ�!');
    }
    if($params['msgcode'] != $_SESSION['r_key']){
      $this->printfail('��������ȷ���ֻ���֤��');
    }
    if( !isset($params['phone']) ){
      $this->printfail('���ֻ������ڣ�������ע��!');
    }
    if($params['phone'] != $_SESSION['r_h']){
      $this->printfail('����ԭ�����ֻ�����ע��!');
    }
    $params['username']=$params['phone'];

   //����ֻ�
    $chars = '/(^(13[0-9]|14[57]|15[012356789]|17[1678]|18[0-9])\d{8}$)|(^170[059]\d{7}$)/';
    if(empty($params['phone']) || !preg_match($chars, $params['phone']))$this->printfail('�ֻ����벻��ȷ��!');


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
    $jieqiConfigs['system']['regtimelimit'] = 3600;
    $this->store_registered_ip($user_ip, $jieqiConfigs['system']['regtimelimit'],$reg_ip_check);

    // /***** ���ڵ� $params['username'] ,��ֻ���ֻ�����,�Ͳ����±ߵ���֤��***/
    // $pattern = '�����¼�|��ҩ|�Ի�ҩ|������|���ϲ�|����ǹ֧|�˵�|������|����ҩ|��������|ɫ�����|����ǿӲ|�ض�|����|����|����ǹ֧|�����¼�|��ҩ|�Ի�ҩ|������|���ϲ�|����ǹ֧|�˵�|������|����ҩ|��������|ɫ�����|����ǿӲ|�ض�|����|����|����ǹ֧|��Ѩ|�鶯|���|��С��|��С��|��Ħ����|��ӷ���|��ҹ����|����椷���|�Ұ������|����ȫ�׷���|һҹ��|�Ұ������|����Ů����|Ԯ�з���|Ԯ������|����椷���|�Ұ������|������Ħ|����ȫ�׷���|һҹ��|�Ұ������|����Ů����|Ԯ�з���|Ԯ������|С����ô��|������Ů��|������Ŀ|˫��|���л���|˿�����|������Ŀ|����������|���ŷ���|С������|������|������|��������������|������d|С�÷���|�������ŮƯ��|��������|������|������|������|������|С�����|�ṩ���С��|��������|��������|ģ��С��|���Ű���|��������|����㻤|�������|��į�ĸ���|��ҹ����|�����|��������|��ְģ��|�������|��ְ��Ů|��������|ģ������|��������|������|��������|���ŷ���|��������|���T����|�ҌW����|�ҌW�������T����|��С�����|��С��|��Ʊ|����ˮ|����ˮ|����ҩ|����ҩ|����С��';
    // if($this->str_count(trim($params['username']),$pattern)) $this->printfail('�û������ܺ��������ַ�');
    
    $params['username'] = trim($params['username']);
    $params['password'] = trim($params['password']);

    $errtext='';
    include_once(JIEQI_ROOT_PATH.'/lib/text/textfunction.php');
    include_once(JIEQI_ROOT_PATH_APP.'/class/users.php');
    $users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
    $errtext .= $this->checkUser($params, true);

    //��¼ע����Ϣ
    if(empty($errtext)) {
      $newUser = $users_handler->create();
      $newUser->setVar('uname', $params['username']);
      $newUser->setVar('name', $params['username']);
      $newUser->setVar('p_qq', $params['qq']+0);
      $newUser->setVar('mobile', $params['phone']); // ��Ա���ֻ�
      $newUser->setVar('p_mobil', $params['phone']); // ��Ա���ֻ�
      $newUser->setVar('pass', $users_handler->encryptPass($params['password']));

      if(!$params['wap_email']){$newUser->setVar('email', $params['email']);}
      $newUser->setVar('email', $params['email']);
      $newUser->setVar('lastlogin', $_SERVER['REQUEST_TIME']);
      $newUser->setVar('reg_time', $_SERVER['REQUEST_TIME']);
      $newUser->setVar('lastloginip', $user_ip);
      $newUser->setVar('balance', 0);
      $newUser->setVar('head', '');
      $newUser->setVar('lastdate', date('Y-m-d',strtotime('-1 day',JIEQI_NOW_TIME)) );

      $tkuid = $_SESSION['SOURCE_SITE']?intval($_SESSION['SOURCE_SITE']):intval($_COOKIE['SOURCE_SITE']);
      $parUs = $users_handler->get($tkuid);
      if( is_object($parUs) && $parUs->getVar('is_tuike','n') == 1 ){
        $newUser->setVar('mauid', $parUs->getVar('mauid'));
        $newUser->setVar('tkuid', $tkuid);
      }else{
        $newUser->setVar('mauid', 0);
        $newUser->setVar('tkuid', 0);
      }

      $userset = array();
      $userset['logindate'] = date('Y-m-d H:i:s',JIEQI_NOW_TIME);
      $userset['lastip'] = $user_ip;
      $newUser->setVar('setting', serialize($userset));


      if (!$users_handler->insert($newUser)) $this->printfail($jieqiLang['system']['register_failure']);
      else {

        //����SESSION
        jieqi_setusersession($newUser);

        //����COOKIE
        $jieqi_user_info['jieqiUserId']=$_SESSION['jieqiUserId'];
        $jieqi_user_info['jieqiUserUname']=$_SESSION['jieqiUserUname'];
        $jieqi_user_info['jieqiUserLogin']=JIEQI_NOW_TIME;
        
        $usecookie=1;
        if($usecookie < 0) $usecookie=0;
        elseif($usecookie == 1) $usecookie=315360000;
        if($usecookie) $cookietime=JIEQI_NOW_TIME + $usecookie;
        else $cookietime=0; 
        
        @setcookie('jieqiUserInfoTk', jieqi_sarytostr($jieqi_user_info), $cookietime, '/',  JIEQI_COOKIE_DOMAIN, 0);
        $jieqi_visit_info['jieqiUserLogin']=$jieqi_user_info['jieqiUserLogin'];
        $jieqi_visit_info['jieqiUserId']=$jieqi_user_info['jieqiUserId'];
        @setcookie('jieqiVisitInfoTk', jieqi_sarytostr($jieqi_visit_info), JIEQI_NOW_TIME+99999999, '/',  JIEQI_COOKIE_DOMAIN, 0);

        //ɾ��������֤���session

        $_SESSION['co_name']='';
        $_SESSION['co_qq']='';
        $_SESSION['co_phone']='';
        $_SESSION['co_img']='';

        unset($_SESSION['r_h']);
        unset($_SESSION['r_key']);
        include_once(JIEQI_ROOT_PATH . '/include/changecode.php');
        jump_success('', 'ע��ɹ�',$this->geturl(JIEQI_MODULE_NAME, 'home'));

      }
    } else {
      $this->printfail($errtext);
    }
  }
  function checkUser($params = array(),$isreturn = false){
    global  $jieqiLang;
    //��������
    $this->addLang('system', 'users');
    $retmsg = array();
    $errtext = '';
    $users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');

    if (strlen($params['username'])==0) $this->printfail($jieqiLang['system']['need_username']);
    if (strlen($params['username'])>30||strlen($params['username'])<1) $this->printfail($jieqiLang['system']['register_user_length']);
    elseif(!jieqi_safestring($params['username'])) $this->printfail( $jieqiLang['system']['error_user_format']);
    elseif(!preg_match('/^[\x7f-\xffa-zA-Z0-9_\.\@\-]{2,30}$/is',$params['username']))$this->printfail($jieqiLang['system']['error_user_format']);
    elseif(preg_match('/^\s*$|^c:\\con\\con$|[%,;\|\*\"\'\\\\\/\s\t\<\>\&]/is', $params['username']))$this->printfail($jieqiLang['system']['error_user_format']);
    elseif(strpos($params['username'],'��') !== false) $this->printfail( $jieqiLang['system']['error_user_format']);
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
  private function check_ip_registered($ip)
  {
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


  /**
   * �Զ�ִ��ÿ��Ľ�������
   * @return [type] [description]
   */
  function _runPayOurAuthCron(){

    $yesterday=date('Y-m-d',time()-86400);


    $params['limit']=100;
    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('lastdate',$yesterday,'<'));
    $this->db->criteria->add( new Criteria('groupid', '(6,2)' , "in") );
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setFields('uid,balance,lastdate');
    $result=$this->db->queryObjects();
    $editNum=0;
    while($row=$this->db->getRow($result)){

      if( strlen($row['lastdate']) < 8 ){
        $row['lastdate']=$yesterday;
      }else{
        $row['lastdate']=date('Y-m-d',strtotime($row['lastdate'].' +1 day'));
      }

      $t1=strtotime($row['lastdate']);
      $t2=strtotime($row['lastdate'].' 23:59:59');


      // ��ѯ���
      $q='SELECT sum(p.money)/100 as qdpay FROM '.
        jieqi_dbprefix('system_qdlist').' q LEFT JOIN '.
        jieqi_dbprefix('pay_paylog').' p ON q.qd=p.source '.
        'WHERE p.payflag=1 AND q.uid='.$row['uid'].' AND p.rettime >= "'.$t1.'" AND p.rettime <= "'.$t2.'"';
      $ar=$this->db->getRow($this->db->query($q));
      if( !$ar || !$ar['qdpay'] ){
        $qdpay=0;
      }else{
        $qdpay_old=$ar['qdpay'];
        $qdpay=round($ar['qdpay']*PAY_SYN_MONEY_QD,2);
      }
      // ��ѯ�ƹ�
      $q='SELECT sum(p.money)/100 as tkpay FROM '.
        jieqi_dbprefix('tuike_users').' u LEFT JOIN '. 
        jieqi_dbprefix('system_qdlist').' q ON q.uid=u.uid LEFT JOIN '.
        jieqi_dbprefix('pay_paylog').' p ON p.source=q.qd '.
        'WHERE p.payflag=1 AND u.tkuid='.$row['uid'].' AND p.rettime >= "'.$t1.'" AND p.rettime <= "'.$t2.'"';
      $ar=$this->db->getRow($this->db->query($q));
      $tkpay=!$ar || !$ar['tkpay']?0:round($ar['tkpay']*PAY_SYN_MONEY_TK,2);


      // ��ʼ�������
      $this->db->query('START TRANSACTION');

        if($qdpay !== 0 ){
          // ��ӹ��
          $data=array(
            'uid'=>$row['uid'],
            'type'=>2,
            'time'=>time(),
            'info'=>'�������',
            'money'=>$qdpay,
            'paymoney'=>round($qdpay_old,2),
            'date'=>$row['lastdate'],
            'ordernumber'=>date('YmdHi',time()).mt_rand(111,999)
          );



          $sql='SELECT count(*) FROM '.jieqi_dbprefix('tuike_paylog').' WHERE ( ordernumber="'.$data['ordernumber'].'" )';
          $count=$this->db->getField($this->db->query($sql));
          $runN=1;
          while($count>0 && $runN < 200){
            $data['ordernumber']=date('YmdHi',time()).mt_rand(111,999);
            $sql='SELECT count(*) FROM '.jieqi_dbprefix('tuike_paylog').' WHERE ( ordernumber="'.$data['ordernumber'].'" )';
            $count=$this->db->getField($this->db->query($sql));
            $runN++;
          }
          if( $runN === 200 ){
            https_request_recod_new('http://www.flyskycode.com/api/api_record.php',array(
              'row'=>$row,
              'type'=>'runPayOurAuthCron',
              'message'=>'������ѭ���δ�������(���)'.$runN,
              'url'=>'http://'.$_SERVER['HTTP_HOST'].(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:(isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:'')),
              ));
            $this->db->query('ROLLBACK');
            $this->db->query('COMMIT');
            break;
          }




          $this->db->init('paylog','payid','tuike');
          if(!$this->db->add($data)){
            https_request_recod_new('http://www.flyskycode.com/api/api_record.php',array(
              'row'=>$row,
              'type'=>'runPayOurAuthCron',
              'url'=>'http://'.$_SERVER['HTTP_HOST'].(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:(isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:'')),
              ));
            $this->db->query('ROLLBACK');
            $this->db->query('COMMIT');
            break;
          }
        }





        if( $tkpay !== 0 ){
          // ����ƹ�
          $data=array(
            'uid'=>$row['uid'],
            'type'=>1,
            'time'=>time(),
            'info'=>'�ƹ�����',
            'money'=>$tkpay,
            'ordernumber'=>date('YmdHis',time()).substr(microtime(),2,1),
            'date'=>$row['lastdate']
          );




          $sql='SELECT count(*) FROM '.jieqi_dbprefix('tuike_paylog').' WHERE ( ordernumber="'.$data['ordernumber'].'" )';
          $count=$this->db->getField($this->db->query($sql));
          $runN=1;
          while($count>0 && $runN < 200){
            $data['ordernumber']=date('YmdHi',time()).mt_rand(111,999);
            $sql='SELECT count(*) FROM '.jieqi_dbprefix('tuike_paylog').' WHERE ( ordernumber="'.$data['ordernumber'].'" )';
            $count=$this->db->getField($this->db->query($sql));
            $runN++;
          }
          if( $runN === 200 ){
            https_request_recod_new('http://www.flyskycode.com/api/api_record.php',array(
              'row'=>$row,
              'type'=>'runPayOurAuthCron',
              'message'=>'������ѭ���δ�������(�ƹ�)'.$runN,
              'url'=>'http://'.$_SERVER['HTTP_HOST'].(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:(isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:'')),
              ));
            $this->db->query('ROLLBACK');
            $this->db->query('COMMIT');
            break;
          }




          $this->db->init('paylog','payid','tuike');
          if(!$this->db->add($data)){
            https_request_recod_new('http://www.flyskycode.com/api/api_record.php',array(
              'row'=>$row,
              'type'=>'runPayOurAuthCron',
              'url'=>'http://'.$_SERVER['HTTP_HOST'].(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:(isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:'')),
              ));
            $this->db->query('ROLLBACK');
            $this->db->query('COMMIT');
            break;
          }
        }

        // �޸��û�����
        $data=array(
          'balance'=>$row['balance']+$qdpay+$tkpay,
          'lastdate'=>$row['lastdate'],
        );
        $this->db->init('users','uid','tuike');
        $this->db->edit($row['uid'],$data);
        if( $this->db->getAffectedRows() === 0 ){
          https_request_recod_new('http://www.flyskycode.com/api/api_record.php',array(
            'row'=>$row,
            'type'=>'runPayOurAuthCron',
            'url'=>'http://'.$_SERVER['HTTP_HOST'].(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:(isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:'')),
            ));
          $this->db->query('ROLLBACK');
          $this->db->query('COMMIT');
          break;
        }
   
      $this->db->query('COMMIT');
      $editNum++;
    }
    return $editNum;

  }



  /**
   * δ��½���޸�����
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  function edit_pass_login($params = array()){        

    if( !isset($params['phone']) 
      || !isset($params['password']) 
      || !isset($params['checkcode']) 
      || !isset($params['msgcode']) 
      || !isset($_SESSION['p_h']) 
      || !isset($_SESSION['p_key']) 
      || !isset($_SESSION['p_time']) )$this->printfail('��������!');

    $interval_time = 60*30; //��֤�����ʱ��
    if(JIEQI_NOW_TIME - $_SESSION['p_time'] > $interval_time){
      $this->printfail('��֤���ѹ��ڣ�!');
    }

    if($params['msgcode'] != $_SESSION['p_key']){
      $this->printfail('��������ȷ���ֻ���֤��');
    }
    if($params['phone'] != $_SESSION['p_h']){
      $this->printfail('����ԭ�����ֻ�����ע��!');
    }

    //����ֻ�
    $chars = '/(^(13[0-9]|14[57]|15[012356789]|17[1678]|18[0-9])\d{8}$)|(^170[059]\d{7}$)/';
    if(empty($params['phone']) || !preg_match($chars, $params['phone']))$this->printfail('�ֻ����벻��ȷ��!');

    //�û����ڼ��
    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('mobile', $params['phone']));
    $user=$this->db->getRow( $this->db->queryObjects());
    if( !$user )$this->printfail('�����ڸ��ֻ�!');
    if( md5($params['password']) === $user['password']  )$this->printfail('�¾�����һ���������޸�!');

    $this->db->edit($user['uid'],array('pass'=>md5($params['password'])));

    if( $this->db->getAffectedRows() > 0 ){
      unset($_SESSION['p_h']);
      unset($_SESSION['p_key']);
      $this->msgwin('�޸ĳɹ�!','�޸ĳɹ�!');
    }else{
      $this->printfail('�޸�����ʧ��!');
    }


  }

  /**
   * �����޸�_���Ͷ���
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  function sendsms_editpass($params = array()){

    //���ύ���
      if(!$this->submitcheck())$this->printfail('���ڱ����ύ!');
    //��������
    $this->addLang('system', 'users');
    $jieqiLang['system'] = $this->getLang('system');
    //�����֤��
    if( empty($params['checkcode']) || strtoupper($params['checkcode']) != strtoupper($_SESSION['jieqiCheckCode'])) $this->printfail($jieqiLang['system']['error_checkcode']);
    //����ֻ�
    $chars = '/(^(13[0-9]|14[57]|15[012356789]|17[1678]|18[0-9])\d{8}$)|(^170[059]\d{7}$)/';
        if (empty($params['phone']) || !preg_match($chars, $params['phone']))$this->printfail('�ֻ����벻��ȷ��!');

    $interval_time=60; // ��֤�뷢�͵�Ƶ��
    $max_num=10; // �����ܻ�ȡ��֤��Ĵ���
    $q_time = time();
    $start_time=strtotime(date('Y-m-d',$q_time));
    if(!isset($_SESSION['sms_n']))$_SESSION['sms_n']=0;
    if(isset($_SESSION['p_time'])){
      if($_SESSION['p_time'] < $start_time ) $_SESSION['sms_n']=0; 
      if($q_time - $_SESSION['p_time'] < $interval_time)$this->printfail('��'.$interval_time.'����ַ�����֤�룡!');
    }

    if($_SESSION['sms_n']>=$max_num)$this->printfail('�����ѻ�ȡ��'.$max_num.'�ζ���,�������ٻ�ȡ����!');

        //�ֻ����ڼ��
    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('mobile', $params['phone']));
    $user=$this->db->getRow( $this->db->queryObjects() );
    if( $user ){
      $ip = $this->getIp();
      $this->db->init('msmrecord','ip','system');
      $this->db->setCriteria(new Criteria('ip', $ip));
      $record=$this->db->getRow( $this->db->queryObjects() );
      $insert=true;
      if( $record ){
        if($record['time'] < $start_time ){ $record['num']=0; }
        if($record['num'] >=$max_num){
          $this->printfail('�����ѻ�ȡ��'.$max_num.'�ζ���,�������ٻ�ȡ����!');
        }
        $insert=false;
      }
      $key = mt_rand(123456,999999);
        $msg ='����'.JIEQI_SITE_NAME.'��֤��Ϊ��'.$key.'��������30��������������޸ġ���Ǳ��˲���������ԡ�';
      if( $this->send_phone($params['phone'],$msg) ){
        if($insert){
          $this->db->add(array('ip'=>$ip,'time'=>$q_time,'num'=>1));
        }else{
          $this->db->edit( $ip,array('time'=>$q_time , 'num'=>$record['num']+1) );
        }
        unset($_SESSION['jieqiCheckCode']);
        $_SESSION['sms_n'] ++; 
        $_SESSION['p_h'] =$params['phone'];
        $_SESSION['p_key'] =$key;
        $_SESSION['p_time']=$q_time;
        $this->msgwin('��֤���ѳɹ�����, ��ע�����!');
      }else{
        $this->printfail('���Ͷ���ʧ��!');
      }
    }else{
      $this->printfail(LANG_NO_USER);
    }
  }


  /**
   * �ֻ�ʹ�ü��
   * @param  [type]  $phone  [description]
   * @param  boolean $return [description]
   * @return [type]          [description]
   */
  public function checkTkUserPhone($phone,$return=false){

    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('mobile', $phone));
    if( $this->db->getCount($this->db->criteria) ){
      if($return){
        return false;
      }else{
        $this->printfail('���ֻ��Ѿ���!');
      }
    }else{
      return true;
    }
  }


  /**
   * ע��_������֤��
   * @return [type] [description]
   */
  public function send_phone_reginster($params){
    //��������
    $this->addLang('system', 'users');
    $jieqiLang['system'] = $this->getLang('system');

    $this->checkTkUserPhone($params['phone']);
  

    $interval_time=60; // ��֤�뷢�͵�Ƶ��
    $max_num=10; // �����ܻ�ȡ��֤��Ĵ���
    $q_time = $_SERVER['REQUEST_TIME'];

    $start_time=strtotime(date('Y-m-d',$q_time));
    if(!isset($_SESSION['sms_n']))$_SESSION['sms_n']=0;
    if(isset($_SESSION['r_time'])){
      if($_SESSION['r_time'] < $start_time ) $_SESSION['sms_n']=0; 
      if($q_time - $_SESSION['r_time'] < $interval_time)$this->printfail('��'.$interval_time.'����ַ�����֤�룡!');
    }
    if($_SESSION['sms_n']>=$max_num)$this->printfail('�����ѻ�ȡ��'.$max_num.'�ζ���,�������ٻ�ȡ����!');

    $ip = $this->getIp();

    $this->db->init('msmrecord','ip','system');
    $this->db->setCriteria(new Criteria('ip', $ip));
    $this->db->queryObjects();
    $record=$this->db->getObject();
    $insert=true;
    if( is_object($record) ){
      if($record->getVar('time') < $start_time ){ $record->setVar('num',0); }
      if($record->getVar('num') >=$max_num){
        $this->printfail('�����ѻ�ȡ��'.$max_num.'�ζ���,�������ٻ�ȡ����!');
      }
      $insert=false;
    }
    $key = mt_rand(123456,999999);
    $msg ='����'.JIEQI_SITE_NAME.'��֤��Ϊ��'.$key.'��������30����������ֻ��󶨡���Ǳ��˲���������ԡ�';
    if( $this->send_phone($params['phone'],$msg) ){
      if($insert){
        $this->db->add(array('ip'=>$ip,'time'=>$q_time,'num'=>1));
      }else{
        $this->db->edit( $ip,array('time'=>$q_time , 'num'=>$record->getVar('num')+1) );
      }
      unset($_SESSION['jieqiCheckCode']);
      $_SESSION['sms_n'] ++; 
      $_SESSION['r_h'] =$params['phone'];
      $_SESSION['r_key'] =$key;
      $_SESSION['r_time']=$q_time;
    }else{
      $this->printfail('���Ͷ���ʧ��!');
    }

  }



  /**
   * ������
   * @param  [type] $phone_id [description]
   * @param  [type] $msg      [description]
   * @return [type]           [description]
   */
  private function send_phone($phone_id,$msg){   

    // @setcookie('Msm',$phone_id.' '.' '.$_SESSION['sms_n'].' '.' '.$msg , JIEQI_NOW_TIME+9999, '/',  JIEQI_COOKIE_DOMAIN, 0);
    // return 1;

    // $msg = iconv('utf-8','gb2312',$msg."\r\n");
    $URL = "http://sms3.mobset.com/SDK/Sms_Send.asp?CorpID=303014&LoginName=Admin&Passwd=Rb105112&send_no=".$phone_id."&Timer=&LongSms=1&msg=" .rawurlencode($msg);
     
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $URL);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $back = curl_exec($curl);
    curl_close($curl);

    $back_arr = explode(',', $back);
    if( $back_arr['0'] == 1 ){
      return true;
    }else{
      return false;
    }   
  }


} 
?>