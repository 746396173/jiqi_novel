<?php 
  /** 
   * ϵͳ����->�û������ * @copyright   Copyright(c) 2014 
   * @author      gaoli* @version     1.0 
   */ 
  class homeModel extends Model{
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
   * ����Ļ�����Ϣ
   * @return [type] [description]
   */
  public function userBase($params){
    global $cache_redis;
    if( $cache_redis->isExists(JIEQI_REDIS_FIX.'userbase'.$_SESSION['jieqiUserId']) ){
      $data=unserialize( $cache_redis->get(JIEQI_REDIS_FIX.'userbase'.$_SESSION['jieqiUserId']) );
      if( isset($data['dayCzOrderFee']) )return $data;
    }

    $data['dayCzN'] = 0;
    $data['dayCz'] = 0;
    $data['MonthCzN'] = 0;
    $data['MonthCz'] = 0;
    $data['WeekCzN'] = 0;
    $data['WeekCz'] = 0;
    $data['allCzN'] = 0;
    $data['allCz'] = 0;
    $data['preMonthCzN'] = 0;
    $data['preMonthCz'] = 0;

    // ��ȡ���ճ�ֵ
    $t1 = $dayStar= strtotime(date("Y-m-d"));
    $this->db->setCriteria(new Criteria('rettime', $t1 , ">="));
    $this->db->criteria->add(new Criteria('p.payflag', 1)); 
    $this->db->criteria->add(new Criteria('q.uid', $_SESSION['jieqiUserId'])); 
    $q = jieqi_dbprefix('pay_paylog').' p LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON p.source=q.qd ';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('count(distinct p.buyid) as payusers,p.buyid,round(sum(p.money)/100,2) as smoney');  
    $result = $this->db->getRow($this->db->queryObjects());

         
    if($result['payusers']){
      $data['dayCzN'] = $result['payusers'];
      $data['dayCz'] = $result['smoney'];
    }
    // ������Ϣ
    $sql='SELECT count(*) count,sum(fee) fees FROM '.jieqi_dbprefix('tuike_orderqd').
      ' WHERE ( uid="'.$_SESSION['jieqiUserId'].'" AND addtime>="'.$t1.'" ) LIMIT 1';
    $ar=$this->db->getROW($this->db->query($sql));
    $data['dayCzOrder']=$ar['count'];
    $data['dayCzOrderFee']=$ar['fees']?$ar['fees']:0;

    // ����
    $week = date('w');
    $week=$week==='0'?7:$week;
    $t1=strtotime( (1-$week).' days' ,$dayStar);
    $this->db->setCriteria(new Criteria('rettime', $t1 , ">="));
    $this->db->criteria->add(new Criteria('p.payflag', 1)); 
    $this->db->criteria->add(new Criteria('q.uid', $_SESSION['jieqiUserId'])); 
    $q = jieqi_dbprefix('pay_paylog').' p LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON p.source=q.qd';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('count(distinct p.buyid) as payusers,p.buyid,round(sum(p.money)/100,2) as smoney');
    $result = $this->db->getRow($this->db->queryObjects());
    if($result['payusers']){
      $data['WeekCzN'] = $result['payusers'];
      $data['WeekCz'] = $result['smoney'];
    }
    // ������Ϣ
    $sql='SELECT count(*) count,sum(fee) fees FROM '.jieqi_dbprefix('tuike_orderqd').
      ' WHERE ( uid="'.$_SESSION['jieqiUserId'].'" AND addtime>="'.$t1.'" ) LIMIT 1';
    $ar=$this->db->getROW($this->db->query($sql));
    $data['WeekCzOrder']=$ar['count'];
    $data['WeekCzOrderFee']=$ar['fees']?$ar['fees']:0;


    // ��ȡ���³�ֵ
    $t1=strtotime( date('Y-m-01').' 00:00:00' ); 
    $this->db->setCriteria(new Criteria('rettime', $t1 , ">="));
    $this->db->criteria->add(new Criteria('p.payflag', 1)); 
    $this->db->criteria->add(new Criteria('q.uid', $_SESSION['jieqiUserId'])); 
    $q = jieqi_dbprefix('pay_paylog').' p LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON p.source=q.qd';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('count(distinct p.buyid) as payusers,round(sum(p.money)/100,2) as smoney');
    $result = $this->db->getRow($this->db->queryObjects());
    $data['MonthCz'] = $result['smoney']?$result['smoney']:0;
    if($result['payusers']){
      $data['MonthCzN'] = $result['payusers'];
      $data['MonthCz'] = $result['smoney'];
    }
    // ������Ϣ
    $sql='SELECT count(*) count,sum(fee) fees FROM '.jieqi_dbprefix('tuike_orderqd').
      ' WHERE ( uid="'.$_SESSION['jieqiUserId'].'" AND addtime>="'.$t1.'" ) LIMIT 1';
    $ar=$this->db->getROW($this->db->query($sql));
    $data['MonthCzOrder']=$ar['count'];
    $data['MonthCzOrderFee']=$ar['fees']?$ar['fees']:0;


    // ����
    $today = getdate();
    $t1 =mktime(0, 0 , 0,$today['mon']-1,1,$today['year']);//��ȡ����ͷʱ��
    $t2 =mktime(23,59,59,$today['mon'] ,0,$today['year']); //��ȡ����βʱ��
    $this->db->setCriteria(new Criteria('p.rettime', $t1 , ">="));
    $this->db->criteria->add(new Criteria('p.rettime', $t2 , "<="));
    $this->db->criteria->add(new Criteria('p.payflag', 1)); 
    $this->db->criteria->add(new Criteria('q.uid', $_SESSION['jieqiUserId'])); 
    $q = jieqi_dbprefix('pay_paylog').' p LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON p.source=q.qd LEFT JOIN '.
      jieqi_dbprefix('tuike_users').' u ON u.uid=q.uid ';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('count(distinct p.buyid) as payusers,p.buyid,round(sum(p.money)/100) as smoney');
    $this->db->queryObjects();
         
    $result = $this->db->getRow();
    if($result['payusers']){
      $data['preMonthCzN'] = $result['payusers'];
      $data['preMonthCz'] = $result['smoney'];
    }
    // ������Ϣ
    $sql='SELECT count(*) count,sum(fee) fees FROM '.jieqi_dbprefix('tuike_orderqd').
      ' WHERE ( uid="'.$_SESSION['jieqiUserId'].'" AND addtime>="'.$t1.'" AND addtime<="'.$t2.'" ) LIMIT 1';
    $ar=$this->db->getROW($this->db->query($sql));
    $data['preMonthCzOrder']=$ar['count'];
    $data['preMonthCzOrderFee']=$ar['fees']?$ar['fees']:0;


    $time=180;
    $cache_redis->set(JIEQI_REDIS_FIX.'userbase'.$_SESSION['jieqiUserId'],serialize($data),$time);
    return $data;
  } 


  /**
   * �༭�ƿ���Ϣ
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  function editPass($params=array()){
    $params['oldpass']=isset($params['oldpass'])?trim($params['oldpass']):'';
    $params['oldpass1']=isset($params['oldpass1'])?trim($params['oldpass1']):'';
    $params['oldpass2']=isset($params['oldpass2'])?trim($params['oldpass2']):'';
    if( $params['oldpass'] === '' ||
        $params['oldpass1'] === '' ||
        $params['oldpass2'] === '' 
     )$this->printfail('��Ϣ����ȷ��');
    if( $params['oldpass1'] !== $params['oldpass2'] )$this->printfail('�ٸ������벻һ����');
    $this->db->init('users','uid','tuike');
    $users=$this->db->get($_SESSION['jieqiUserId']);
    if( md5($params['oldpass']) !== $users['pass'] )$this->printfail('�������������ϵ���Ŀͻ�����');
    if( md5($params['oldpass1']) === $users['pass'] )$this->printfail('������;�������ͬ�������޸ģ�');
    $data=array('pass'=>md5($params['oldpass2']));
    $this->db->edit($_SESSION['jieqiUserId'],$data);
    if( $this->db->getAffectedRows() > 0 ){
      $this->msgwin('�޸ĳɹ���');
      die(json_encode(array('status'=>'OK','jumpurl'=>$this->geturl(JIEQI_MODULE_NAME,'server','home').'?payflag=2')));
    }else{
      $this->printfail('�޸�ʧ�ܣ�');
    }
  }
  /**
   * �˳���½
   * @return [type] [description]
   */
  public function logout(){
    $_REQUEST = $this->getRequest();
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
    if (!empty($_COOKIE['jieqiUserInfoTk'])){
      @setcookie('jieqiUserInfoTk', '', 0, '/', JIEQI_COOKIE_DOMAIN, 0);
    }
    if (!empty($_COOKIE[session_name()])){
      @setcookie(session_name(), '', 0, '/', JIEQI_COOKIE_DOMAIN, 0);
    }
    setcookie($_SESSION['jieqiUserId'],JIEQI_NOW_TIME,JIEQI_NOW_TIME+99999999,'/',JIEQI_COOKIE_DOMAIN,0);
    $_SESSION = array();
    @session_destroy();
    if(empty($_REQUEST['jumpurl']))$this->geturl(JIEQI_MODULE_NAME, 'login');
    ecs_header('location:'.$_REQUEST['jumpurl']);
  } 



/*------newRun--------------------------------------------------------------------------------------------------------------------------*/




































} 
?>