<?php 
  /** 
   * ϵͳ����->�û������ * @copyright   Copyright(c) 2014 
   * @author      gaoli* @version     1.0 
   */ 
  class usersModel extends Model{
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
   * �˳���½
   * @return [type] [description]
   */
  public function logout(){
    $_REQUEST = $this->getRequest();
    
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
    if (!empty($_COOKIE['jieqiUserInfoTk'])){
      setcookie('jieqiUserInfoTk', '', 0, '/', JIEQI_COOKIE_DOMAIN, 0);
    }
    if (!empty($_COOKIE[session_name()])){
      setcookie(session_name(), '', 0, '/', JIEQI_COOKIE_DOMAIN, 0);
    }
    setcookie($_SESSION['jieqiUserId'],JIEQI_NOW_TIME,JIEQI_NOW_TIME+99999999,'/',JIEQI_COOKIE_DOMAIN,0);
    $_SESSION = array();
    @session_destroy();
    
    if(empty($_REQUEST['jumpurl']))$this->geturl(JIEQI_MODULE_NAME, 'login');
    ecs_header('location:'.$_REQUEST['jumpurl']);
  } 

  /**
   * ��Ա�Ļ�����Ϣ
   * @return [type] [description]
   */
  public function userBase($params){
    // ��ȡ���ճ�ֵ
    $t1 = strtotime(date("Y-m-d"));
    $this->db->setCriteria(new Criteria('rettime', $t1 , ">="));
    $this->db->criteria->add(new Criteria('p.payflag', 1)); 
    $this->db->criteria->add(new Criteria('q.uid', $_SESSION['jieqiUserId']));  
    $q = jieqi_dbprefix('system_qdlist').' q LEFT JOIN '.jieqi_dbprefix('pay_paylog').' p ON p.source=q.qd';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('round(sum(p.money)/100) as smoney');
    $this->db->queryObjects();
    $result = $this->db->getRow();
    $data['dayCz'] = $result['smoney']?$result['smoney']:0;

    // ��ȡ���³�ֵ
    $t1=strtotime( date('Y-m-01').' 00:00:00' ); 
    $this->db->setCriteria(new Criteria('rettime', $t1 , ">="));
    $this->db->criteria->add(new Criteria('p.payflag', 1)); 
    $this->db->criteria->add(new Criteria('q.uid', $_SESSION['jieqiUserId']));  
    $q = jieqi_dbprefix('system_qdlist').' q LEFT JOIN '.jieqi_dbprefix('pay_paylog').' p ON p.source=q.qd';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('round(sum(p.money)/100) as smoney');
    $this->db->queryObjects();
    $result = $this->db->getRow();
    $data['MonthCz'] = $result['smoney']?$result['smoney']:0;

    // ��ȡ�ۼƳ�ֵ
    $this->db->setCriteria(new Criteria('q.uid', $_SESSION['jieqiUserId']));
    $this->db->criteria->add(new Criteria('p.payflag', 1)); 
    $q = jieqi_dbprefix('system_qdlist').' q LEFT JOIN '.jieqi_dbprefix('pay_paylog').' p ON p.source=q.qd';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('round(sum(p.money)/100) as smoney');
    $this->db->queryObjects($this->db->criteria);
    $result = $this->db->getRow();
    $data['allCz']=$result['smoney']?$result['smoney']:0;
  
  return $data;
  } 

  /**
   * ��ȡ��ֵ��¼
   * @param  [type]  $uid    [description]
   * @param  integer $qd     [description]
   * @param  array   $params [description]
   * @return [type]          [description]
   */
  public function getPayList($uid=0,$qdUid=0,$params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){

    $uid=$uid===0?$_SESSION['jieqiUserId']:$uid;
    if(!isset($params['limit']))$params['limit']=10;
    if (!$params['page']) $params['page'] = 1;
    $params['start']=($params['page'] - 1) * $params['limit'];


    // ����id
    if( $params['qdId']>0 ){
      $this->db->init('qdlist','id','system');
      $qdAr=$this->db->get($params['qdId']);
      if( !$qdAr ){
      jump_fail('�����Ų���ȷ��',geturl(JIEQI_MODULE_NAME,'qdlist'));
      }
    }


    /* ���� */ 
    $this->db->setCriteria();
    $this->db->criteria->add(new Criteria('p.payflag', 1));


    if( isset($params['t1'],$params['t2']) ){
      $this->db->criteria->add(new Criteria('p.rettime', $params['t1'] , ">="));
      $this->db->criteria->add(new Criteria('p.rettime', $params['t2'] , "<"));
    }

    // $t1=strtotime( date('Y-m-01').' 00:00:00' ); 
    // $this->db->add(new Criteria('rettime', $t1 , ">="));
    $this->db->criteria->add(new Criteria('q.uid', $uid));
    if( isset($params['qd']) && $params['qd'] !== ''){
      $this->db->criteria->add(new Criteria('p.source', $params['qd']));
    }
    // ��Աid
    if( $params['qdUid']>0 ){
      $this->db->criteria->add(new Criteria('p.buyid', $params['qdUid']));
    }

    // ������
    if( isset($qdAr) ){
      $this->db->criteria->add(new Criteria('p.source', $qdAr['qd']));
    }

    // ����
    if(isset($params['keyword']) && strlen($params['keyword']) > 0){
      $this->db->criteria->add(new Criteria('p.buyname', trim($params['keyword']))); 
    }


    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);

    /* ���� */
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder(($params['sort']===1?'asc':'desc'));

    $q = jieqi_dbprefix('pay_paylog').' p LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON p.source=q.qd';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('p.*');
    $this->db->queryObjects();
    $ar=array();
    while($row=$this->db->getRow()){
      $row['money']=$row['money']/100;
      $ar[]=$row;
    }

    if ($params['pageShow']) {
      $this->setVar('totalcount', $this->db->getCount($this->criteria));
      $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);
      $this->jumppage->emptyonepage = $emptyonepage;
      if ($custompage) $this->setVar('custompage', $custompage);
    }

    return $ar;
  }

  /**
   * �û��Ļ�����Ϣ
   * @return [type] [description]
   */
  function getUser(){
    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('uid', $_SESSION['jieqiUserId']));
    $this->db->queryObjects();
    return $this->db->getRow();
  }



  /**
   * �༭�û��Ļ�����Ϣ
   * @return [type] [description]
   */
  function payreceive($params = array()){

    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('uid', $_SESSION['jieqiUserId']));
    $this->db->queryObjects();
    $user=$this->db->getRow();

    $data=array();
    if(isset($params['paychannel'])){
      // $p_type=array('alipay'=>1,'wehcat'=>2,'bank'=>3);
      $p_type=array('alipay'=>1,'bank'=>3);
      if( !isset($p_type[$params['paychannel']]) )$this->printfail('�����ڸ��տʽ��');
      if( $user['p_type'] !=0 )$this->printfail('�����޸��տʽ');

      if( empty($params['pay_account']) || 
        empty($params['pay_realname']) 
        ) $this->printfail('�������տ���Ϣ��');
      $data['p_wechat']=$params['pay_weixin'];
      $data['p_type']=$p_type[$params['paychannel']];
      switch($data['p_type']){
        case 1:
          $data['p_ali']=$params['pay_account'];
          break;
        case 2:
          $data['p_wechat']=$params['pay_account'];
          break;
        case 3:
          if( empty($params['pay_bankh']) )$this->printfail('�����뿪��֧�У�');
          $data['p_bank']=$params['pay_account'];
          $data['p_bankn']=$params['pay_bankh'];
          break;
      }
      $data['p_uname']=$params['pay_realname'];
    }else{
      if( $user['p_type'] !=2 )$data['p_wechat']=$params['pay_weixin'];
    }

    // if( empty($params['pay_phone']) ) $this->printfail('�������տ���Ϣ��');
    // $data['p_mobil']=$params['pay_phone'];
    $data['p_qq']=$params['pay_qq'];
    $this->db->edit($_SESSION['jieqiUserId'],$data);

    if( $this->db->getAffectedRows() === 0 ) $this->printfail('�޸�ʧ�ܣ�');
    $this->msgwin('.');
  }



  /**
   * ���ֺ�ÿ�յĽ����¼�������ƹ㣩
   * @param  array   $params       [description]
   * @param  [type]  $custompage   [description]
   * @param  boolean $emptyonepage [description]
   * @return [type]                [description]
   */
  public function payoutList($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){

    if(!isset($params['limit']))$params['limit']=10;
    if (!$params['page']) $params['page'] = 1;
    $params['start']=($params['page'] - 1) * $params['limit'];
    
    /* ���� */ 
    $this->db->setCriteria( new Criteria('uid',$_SESSION['jieqiUserId']) );

    $params['orderS']='payid';
    $params['sort']=0;

    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);
    /* ���� */
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder(($params['sort']===1?'asc':'desc'));
    /* �����ִ�� */
    $q = jieqi_dbprefix('tuike_paylog'); 
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields("*");
    $this->db->queryObjects();

    /* �������� */
    $ar=array();
    while($row=$this->db->getRow()){
      $ar[]=$row;
    }

    /* ��ҳ */
    if ($params['pageShow']) {
      $this->setVar('totalcount', $this->db->getCount($this->criteria));
      $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);
      $this->jumppage->emptyonepage = $emptyonepage;
      if ($custompage) $this->setVar('custompage', $custompage);
    }

    return $ar;
  }

  /**
   * ���ֽ�������
   * @param  [type] $payId [description]
   * @return [type]        [description]
   */
  function getPaylog($payId){
    $this->db->init('paylog','payid','tuike');
    $this->db->setCriteria(new Criteria('payid',$payId));
    $this->db->queryObjects();
    $paylog=$this->db->getRow();
    if(!$paylog)$this->printfail('��ѯ���������ݣ�');

    if( $paylog['type'] != 3 ){
      //�ý�����ܽ��

      $paylog['t1']=strtotime($paylog['date']);
      $paylog['t2']=strtotime($paylog['date'].' 23:59:59');

      // /* ���� */ 
      // $this->db->setCriteria( new Criteria('p.payflag', 1) );
      // $this->db->criteria->add(new Criteria('q.uid', $_SESSION['jieqiUserId']));
      // $this->db->criteria->add(new Criteria('p.rettime', $paylog['t1'] , ">="));
      // $this->db->criteria->add(new Criteria('p.rettime', $paylog['t2'] , "<"));
      // /* ��ȡ���� */
      // $this->db->criteria->setLimit(1);
      // $q = jieqi_dbprefix('pay_paylog').' p LEFT JOIN '. jieqi_dbprefix('system_qdlist').' q ON p.source=q.qd';
      // $this->db->criteria->setTables($q);
      // $this->db->criteria->setFields("count(distinct p.buyid) as payusers,round(sum(p.money)/100) as qdpay");
      // $this->db->criteria->setGroupby("q.uid");
      // $this->db->queryObjects();
      // $row=$this->db->getRow();
      // if( $row ){
      //   $paylog['payusers']=$row['payusers'];
      //   $paylog['allPay']=$row['qdpay'];
      // }else{
      //   $paylog['payusers']=0;
      //   $paylog['qdpay']=0;
      // }
    }
    return $paylog;
  }

  /**
   * ��������
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  function payoutRun($params=array()){

    $money=isset($params['money'])?intval($params['money']):0;
    if( $money < MINIMUM_MONEY )$this->printfail('���ֽ��Ҫ���ڻ����'.MINIMUM_MONEY);
    if( $_SESSION['jieqiUserBalance'] < $money  )$this->printfail('����('.$_SESSION['jieqiUserBalance'].')!');
    $user=$this->getUser();
    if( !$user )$this->printfail('��ȡ��Ϣʧ�ܣ�');

    if( $user['balance'] < $money  )$this->printfail('����('.$_SESSION['jieqiUserBalance'].')!');

    $user= $this->getUser();
    if(!$user)$this->printfial('��ȡ��Ϣʧ�ܣ�');
    if( $user['p_type'] == 0 )$this->printfail('�������տ���Ϣ��');

    $data=array(
      'uid'=>$_SESSION['jieqiUserId'],
      'type'=>3,
      'time'=>$_SERVER['REQUEST_TIME'],
      'date'=>date('Y-m-d',JIEQI_NOW_TIME),
      'info'=>'����',
      'money'=>$money,
      'ordernumber'=>date('YmdHis',JIEQI_NOW_TIME).substr(microtime(),2,1),
      'payflag'=>1
    );

    $this->db->init('paylog','payid','tuike');
    $payid=$this->db->add($data);
    if( !$payid )$this->printfail('��ȡ��Ϣʧ�ܣ�');

    $this->db->init('users','uid','tuike');
    $this->db->edit($_SESSION['jieqiUserId'],array('balance'=>$user['balance']-$money,'balancer'=>$user['balancer']+$money));

    if( $this->db->getAffectedRows() === 0 ){
      $this->db->init('paylog','payid','tuike');
      $this->db->delete($payid);
      $this->printfail('��ȡ��Ϣʧ�ܣ�');
    }else{
      $_SESSION['jieqiUserBalance']-=$money;
      $_SESSION['jieqiUserBalancer']+=$money;
      $this->msgwin(' ');
    }
  }


  /**
   * �����¼��Ĺ���ֵ��¼
   * @param  array   $params       [description]
   * @param  [type]  $custompage   [description]
   * @param  boolean $emptyonepage [description]
   * @return [type]                [description]
   */
  public function getPayListTk($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){

    if(!isset($params['limit']))$params['limit']=10;
    if (!$params['page']) $params['page'] = 1;
    $params['start']=($params['page'] - 1) * $params['limit'];

    /* ���� */ 
    $this->db->setCriteria( new Criteria('p.payflag', 1) );
    $this->db->criteria->add(new Criteria('p.rettime', $params['t1'] , ">="));
    $this->db->criteria->add(new Criteria('p.rettime', $params['t2'] , "<"));
    $this->db->criteria->add(new Criteria('u.tkuid', $_SESSION['jieqiUserId']));

    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);

    /* ���� */
    $params['orderS']='p.payid';
    $params['sort']='0';
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder(($params['sort']===1?'asc':'desc'));

    $q = jieqi_dbprefix('tuike_users').' u LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON u.uid=q.uid LEFT JOIN '.jieqi_dbprefix('pay_paylog').' p ON p.source=q.qd';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('p.*');

    $this->db->queryObjects();
    $ar=array();
    while($row=$this->db->getRow()){
      $row['money']=$row['money']/100;
      $ar[]=$row;
    }

    if ($params['pageShow']) {
      $this->setVar('totalcount', $this->db->getCount($this->criteria));
      $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);
      $this->jumppage->emptyonepage = $emptyonepage;
      if ($custompage) $this->setVar('custompage', $custompage);
    }

    return $ar;
  }

    /**
     * �ƿ͵�һ�ܼ�¼ rand()
     * @return [type] [description]
     */
    function getWeekPay(){
      $data=array();
      $tmpA=array(
        '0'=>date('Y-m-d',strtotime(' -1 day',JIEQI_NOW_TIME)),
        '1'=>date('Y-m-d',strtotime(' -2 day',JIEQI_NOW_TIME)),
        '2'=>date('Y-m-d',strtotime(' -3 day',JIEQI_NOW_TIME)),
        '3'=>date('Y-m-d',strtotime(' -4 day',JIEQI_NOW_TIME)),
        '4'=>date('Y-m-d',strtotime(' -5 day',JIEQI_NOW_TIME)),
        '5'=>date('Y-m-d',strtotime(' -6 day',JIEQI_NOW_TIME)),
        '6'=>date('Y-m-d',strtotime(' -7 day',JIEQI_NOW_TIME)),
        );
      $t1=strtotime($tmpA['6']);
      $t2=strtotime($tmpA['0'].' 23:59:59');
      foreach($tmpA as $v){
        $data[$v]=array('payusers'=>0,'qdpay'=>0,'dateS'=>$v);
      }

      /* ���� */ 
      $this->db->setCriteria( new Criteria('p.payflag', 1) );
      $this->db->criteria->add(new Criteria('p.rettime', $t1 , ">="));
      $this->db->criteria->add(new Criteria('p.rettime', $t2 , "<"));
      $this->db->criteria->add(new Criteria('q.uid', $_SESSION['jieqiUserId']));

      /* ���� */
      $this->db->criteria->setSort('p.rettime');
      $this->db->criteria->setOrder('desc');
      $q = jieqi_dbprefix('pay_paylog').' p LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON q.qd=p.source ';
      $this->db->criteria->setTables($q);
      $this->db->criteria->setFields('FROM_UNIXTIME(rettime,"%Y-%m-%d") dateS,count(distinct p.buyid) as payusers,round(sum(p.money)/100) as qdpay');
      $this->db->criteria->setGroupby("dateS");

      $this->db->queryObjects();
      $ar=array();
      while($row=$this->db->getRow()){
        if( isset($data[$row['dateS']]) )$data[$row['dateS']]=$row;
      }

      $tmpA=array();
      foreach($data as $v){
        $tmpA[]=$v;
      }
      return $tmpA;
    }





} 
?>