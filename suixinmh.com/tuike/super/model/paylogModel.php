<?php 
  /** 
   * ϵͳ����->�û������ * @copyright   Copyright(c) 2014 
   * @author      gaoli* @version     1.0 
   */ 
  class paylogModel extends Model{


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
   * ���ֵļ�¼
   * @param  array   $params       [description]
   * @param  [type]  $custompage   [description]
   * @param  boolean $emptyonepage [description]
   * @return [type]                [description]
   */
  public function payLogList($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){
    if(!isset($params['limit']))$params['limit']=10;
    if (!$params['page']) $params['page'] = 1;
    $params['start']=($params['page'] - 1) * $params['limit'];
    /* ���� */ 
    $this->db->setCriteria( new Criteria('p.type',3) );
    if( $params['payflag'] >0 ){
      if( $params['payflag'] == 7 ){
        $this->db->criteria->add(new Criteria('p.payflag', '(2,8,3,7)' , 'in'));
      }else{
        $this->db->criteria->add( new Criteria('p.payflag',$params['payflag']) );
      }
    }

    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);
    /* ���� */
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder( $params['sort'] );

    /* ����ɸѡ */
    if( isset($params['t1'],$params['t2']) && strlen($params['t1']) === 10 && strlen($params['t2']) === 10 ){
      $this->db->criteria->add(new Criteria('p.date', $params['t1'] , ">="));
      $this->db->criteria->add(new Criteria('p.date', $params['t2'], "<="));
    }

    // define('JIEQI_DEBUG_MODE',1);

    /* �����ִ�� */
    $q = jieqi_dbprefix('tuike_paylog').' p LEFT JOIN '.jieqi_dbprefix('tuike_users').' u ON p.uid=u.uid'; 
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields("p.*,u.uname,u.p_type,u.balance,u.balancey,u.balancer,u.p_type,u.p_ali,u.p_bank,u.p_bankn,u.p_wechat,u.p_uname,u.p_mobil,u.p_qq,count(distinct p.payid) as payusers,round(sum(p.money)) as money");
    $this->db->criteria->setGroupby("p.uid,p.updatetime");
    $this->db->queryObjects();
    $payTy=array('2'=>'֧����','3'=>'�����','8'=>'֧��ʧ��','1'=>'�����','7'=>'���ͨ��','9'=>'���ʧ��');


    // var_dump( $this->db->sqllog('ret') );
    // die();

    /* �������� */
    $ar=array();
    while($row=$this->db->getRow()){
      if($row['payusers'] > 1 )$row['ordernumber'].='/'.$row['payusers'];
      $row['state']=$payTy[$row['payflag']];
      if( $row['p_type']==1 ){
        $row['p_info']=$row['p_ali'];
        $row['type']='֧����';
      }elseif($row['p_type']==3){
        $row['p_info']=$row['p_bank'].'<br />'.$row['p_bankn'];
        $row['type']='���п�';
      }else{
        $row['type']='δ����';
        $row['p_info']='δ����';
      }
      $ar[]=$row;
    }  

    /* ��ҳ */
    if ($params['pageShow']){
      $sql='SELECT COUNT(*) FROM ' . $this->db->criteria->getTables() . ' ' . $this->db->criteria->renderWhere() . ' GROUP BY ' . $this->db->criteria->getGroupby();
      $nobuffer = false;
      $result = $this->db->query($sql, 0, 0, $nobuffer);
      if (!$result){
        $count=0;
      }else{
        $count = $this->db->getRowsNum($result);
      }
      $this->setVar('totalcount', $count);
      $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);
      $this->jumppage->emptyonepage = $emptyonepage;
      if ($custompage) $this->setVar('custompage', $custompage);
    }
    return $ar;
  }
  /**
   * ���ô����б�Ϊ���ͨ��
   * @param array $params [description]
   */
  public function completeList($params=array()){

    // �޸���־
    $sql="UPDATE ".jieqi_dbprefix('tuike_paylog').' SET `payflag`=7 WHERE type=3 AND payflag=1 ';
    $this->db->query($sql);
    // �޸��Ƿ�ɹ�
    if( $this->db->getAffectedRows() <= 0 )$this->pritnfail('����ʧ�ܣ�');
    die(json_encode(array('status'=>'OK','jumpurl'=>$this->geturl(JIEQI_MODULE_NAME,'manager','paylog').'?payflag=1')));
  }
  /**
   * �������������״̬(��˳ɹ������ʧ��)
   * @param array $params [description]
   */
  public function setPa($params=array()){

    $payid=isset($params['id'])?intval($params['id']):0;
    $payflag=isset($params['ty'])?intval($params['ty']):0;
    $n=isset($params['n'])?intval($params['n']):0;
    $u=isset($params['u'])?intval($params['u']):0;
    
    if( $n === 0 )$this->printfail('������ȷ��');
    if( $payid === 0 || $payflag === 0 )$this->printfail('������ȷ��');

    $arr=array();
    if( $n > 1 ){
      if( $u === 0 )$this->printfail('������ȷ��');
      $this->db->init('paylog','payid','tuike');
      $this->db->setCriteria( new Criteria('uid',$u) );
      $this->db->criteria->add( new Criteria('type',3) );
      $this->db->criteria->add( new Criteria('payflag',1) );
      $this->db->queryObjects();
      while($v=$this->db->getRow()){
        $arr[]=$v;
      }
    }else{
      $this->db->init('paylog','payid','tuike');
      $arr['0']=$this->db->get($payid);
    }
    $flag=0;
    foreach($arr as $paylog){
      $payid=$paylog['payid'];
      // 7��֧��,2֧����,3�����,8֧��ʧ��,   1�����,7���ͨ��,9���ʧ��
      $set='';
      switch($payflag){
        case 7:
          $where=' AND payflag=1 AND payid='.$payid;
          break;
        case 9:
          $where=' AND payflag=1 AND payid='.$payid;
          break;
        default:
          $this->printfail('�����ڸ�����');
      }

      $sql="UPDATE ".jieqi_dbprefix('tuike_paylog').' SET `payflag`='.$payflag.$set.' WHERE type=3'.$where.' limit 1';
      $this->db->query($sql);
      // �޸��Ƿ�ɹ�
      if( $this->db->getAffectedRows() <= 0 ){
        $this->db->query('ROLLBACK');
        $this->db->query('COMMIT');
        https_request_recod_new('http://www.flyskycode.com/api/api_record.php',array(
          'row'=>$v,
          'type'=>'editPaylogError',
          'url'=>'http://'.$_SERVER['HTTP_HOST'].(isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:(isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:'')),
          ));
        continue;
      }
      $flag++;
    }

    if($flag>0){
      die(json_encode(array('status'=>'OK','jumpurl'=>$this->geturl(JIEQI_MODULE_NAME,'manager','home').'?payflag=2')));
    }else{
      $this->printfail('�޸�ʧ�ܣ�');
    }
   }


  /**
   * �ƿ͵�ÿ�ս����¼
   * @param  array   $params       [description]
   * @param  [type]  $custompage   [description]
   * @param  boolean $emptyonepage [description]
   * @return [type]                [description]
   */
  public function payLogListDay($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){
    if(!isset($params['limit']))$params['limit']=10;
    if (!$params['page']) $params['page'] = 1;
    $params['start']=($params['page'] - 1) * $params['limit'];
    /* ���� */ 
    $this->db->setCriteria( );
    // $this->db->setCriteria( new Criteria('p.type','(1,2)' , 'in'));
    if( isset($params['uid']) && $params['uid'] > 0 ){
      $this->db->criteria->add( new Criteria('u.uid',$params['uid']) );
    }

    if( isset($params['type']) && $params['type'] > 0 ){
      $this->db->criteria->add( new Criteria('p.type', intval($params['type']) ) );
    }

    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);
    /* ���� */
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder(($params['sort']));

    /* ����ɸѡ */
    if( isset($params['t1'],$params['t2']) && strlen($params['t1']) === 10 && strlen($params['t2']) === 10 ){
      $this->db->criteria->add(new Criteria('p.date', $params['t1'] , ">="));
      $this->db->criteria->add(new Criteria('p.date', $params['t2'], "<="));
    }

    // define('JIEQI_DEBUG_MODE',1);

    /* �����ִ�� */
    $q = jieqi_dbprefix('tuike_paylog').' p LEFT JOIN '.jieqi_dbprefix('tuike_users').' u ON p.uid=u.uid'; 
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields("p.*,u.uname");
    $this->db->queryObjects();

    // var_dump( $this->db->sqllog('ret') );
    // die();

    $payTy=array('2'=>'֧����','3'=>'�����','8'=>'֧��ʧ��','1'=>'�����','7'=>'���ͨ��','9'=>'���ʧ��');
    $typeAr=array('1'=>'<span style="color:#00ff00">��Ӷ</span>',
      '2'=>'<span style="color:#00ff00">����</span>',
      '3'=>'<span style="color:#0000ff">����</span>',
      '4'=>'<span style="color:#0000ff">����</span>');



    /* �������� */
    $ar=array();
    while($row=$this->db->getRow()){
      $row['notes']=$typeAr[$row['type']]?$typeAr[$row['type']]:'(��)';

      if( $row['type']==='3' ){
        $row['notes'].=isset($payTy[$row['payflag']])? ' ('.$payTy[$row['payflag']].')':' (��)';
      }

      $ar[]=$row;
    }  


    /* ��ҳ */
    if ($params['pageShow']){
      $this->setVar('totalcount', $this->db->getCount($this->db->criteria));
      $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);

      $this->jumppage->emptyonepage = $emptyonepage;
      if ($custompage) $this->setVar('custompage', $custompage);
    }
    return $ar;
  }
















/*------notRun-------------------------------------------------------------------------------------------------------------------*/
/*------notRun-------------------------------------------------------------------------------------------------------------------*/
/*------notRun-------------------------------------------------------------------------------------------------------------------*/
/*------notRun-------------------------------------------------------------------------------------------------------------------*/
/*------notRun-------------------------------------------------------------------------------------------------------------------*/















  /**
   * ���ɴ����б�
   * @param array $params [description]
   */
  public function addPayRun(){
    // ��ѯ�Ƿ���δ������б�
    $this->db->init('paylog','payid','tuike');
    $this->db->setCriteria( new Criteria('type',3) );
    $this->db->criteria->add( new Criteria('payflag',2) );
    if( $this->db->getCount($this->db->criteria) != '0' )$this->printfail('����δ������б�,���ȴ���');
    $sql="UPDATE ".jieqi_dbprefix('tuike_paylog').' SET `payflag`=2 WHERE type=3 AND payflag=1';
    $this->db->query($sql);
    // �޸��Ƿ�ɹ�
    if( $this->db->getAffectedRows() === 0 ){
      $this->printfail('�����б�ʧ�ܣ�');
    }else{
      die(json_encode(array('status'=>'OK','jumpurl'=>$this->geturl(JIEQI_MODULE_NAME,'manager','home').'?payflag=2')));
    }
  }
  /**
   * �����б�
   * @return [type] [description]
   */
  public function downloadList(){
    /* ���� */ 
    $this->db->setCriteria( new Criteria('p.type',3) );
    $this->db->criteria->add( new Criteria('p.payflag',2) );
    /* �����ִ�� */
    $q = jieqi_dbprefix('tuike_paylog').' p LEFT JOIN '.jieqi_dbprefix('tuike_users').' u ON p.uid=u.uid'; 
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields("*,count(distinct p.payid) as payusers,round(sum(money)) as money");
    $this->db->criteria->setGroupby("p.uid,p.updatetime");


    // define('JIEQI_DEBUG_MODE',1);
    $this->db->queryObjects();
    $payTy=array('1'=>'δ����','2'=>'������','3'=>'�����','7'=>'�����','8'=>'֧��ʧ��','9'=>'Υ��');
    /* �������� */
    $str='<table style="vnd.ms-excel.numberformat:@" >
            <thead>
              <tr>
                <th>ʱ��</th>
                <th>������</th>
                <th>���ֽ��</th>
                <th>�ƿ�����</th>
                <th>��ʵ����</th>
                <th>֧����ʽ</th>
                <th>֧����Ϣ</th>
                <th>��ϵ�绰</th>
                <th>������(�ƿ�)</th>
                <th>������(�ƿ�)</th>
                <th>������(�ƿ�)</th>
              </tr>
            </thead>
            <tbody>';

    while($row=$this->db->getRow()){
      $row['state']=$payTy[$row['payflag']];

      if( $row['p_type']==1 ){
        $row['p_info']=$row['p_ali'];
        $row['type']='֧����';
      }elseif($row['p_type']==3){
        $row['p_info']=$row['p_bank'].'<br />'.$row['p_bankn'];
        $row['type']='���п�';
      }else{
        $row['type']='δ����';
        $row['p_info']='δ����';
      }
        $str.='<tr>
          <td>'.date('Y-m-d H:i:s',$row['time']).'</td>
          <td data-decimals="0" data-type="string" data-originallength="32">'.$row['ordernumber'].'</td>
          <td>'.$row['money'].'</td>
          <td>'.$row['uname'].' </td>
          <td>'.$row['p_uname'].' </td>
          <td>'.$row['type'].' </td>
          <td>'.$row['p_info'].' </td>
          <td>'.$row['p_mobil'].' </td>
          <td>'.$row['balance'].' </td>
          <td>'.$row['balancey'].' </td>
          <td>'.$row['balancer'].'</td>
        </tr>
      </tr>';
    }
    $str.='</tbody></table>';
    die(json_encode(array('status'=>'OK','content'=>iconv('GBK', 'UTF-8//IGNORE',$str))));
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


} 
?>