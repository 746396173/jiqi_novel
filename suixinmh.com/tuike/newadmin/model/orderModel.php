<?php 
/** 
 * �¼��ƿ���ϸģ��
 * @author      gaoli* @version     1.0 
 */ 
class orderModel extends Model{
  //login form
  public function main($params){
    
    $data = array();
    return $data;
  }
  /**
   * �ƿ��ܵĳ�ֵ��¼
   * @param  array   $params       [description]
   * @param  [type]  $custompage   [description]
   * @param  boolean $emptyonepage [description]
   * @return [type]                [description]
   */
  public function orderList($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){
    global $feeTypeAr;
    $params['page']=isset($params['page'])?intval($params['page']):1;
    $params['start']=($params['page'] - 1) * $params['limit'];
    /* ���� */ 
    $this->db->setCriteria(new Criteria('o.uid',$_SESSION['jieqiUserId']));
    // ����
    if(isset($params['keyword']) && strlen($params['keyword']) > 0){
      $this->db->criteria->add(new Criteria('company', trim($params['keyword']))); 
    }
    if(isset($params['oid']) && $params['oid'] > 0){
      $this->db->criteria->add(new Criteria('o.id', intval($params['oid']))); 
    }
    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);
    /* ���� */
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder($params['sort']);
    $q = jieqi_dbprefix('tuike_orderqd').' o '.
      ' LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON q.orderqdid=o.id '.
      ' LEFT JOIN '.jieqi_dbprefix('pay_paylog').' p ON p.source=q.qd AND payflag="1"';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields("o.*,sum(round(p.money/100,2)) payAll");
    $this->db->criteria->setGroupby('o.id');
    $result=$this->db->queryObjects();

    $ar=array();
    while($row=$this->db->getRow($result)){
      $sql='SELECT count(*) FROM '.jieqi_dbprefix('system_qdlist').' WHERE ( orderqdid="'.$row['id'].'" )';
      $row['count']=$this->db->getField($this->db->query($sql));
      $row['payAll']=$row['payAll']?$row['payAll']:0;
      $row['feeType']=isset($feeTypeAr[$row['feetype']])?$feeTypeAr[$row['feetype']]:'������';
      $ar[]=$row;
    }

    if ($params['pageShow']){
      $this->setVar('totalcount', $this->db->getCount($this->db->criteria));
      $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);
      $this->jumppage->emptyonepage = $emptyonepage;
      if ($custompage) $this->setVar('custompage', $custompage);
    }
    return $ar;
  }
  /**
   * ��Ӷ���
   * @param array $params [description]
   */
  function addOrder($params=array()){

    $params['pay_way']=isset($params['pay_way'])?trim($params['pay_way']):0;
    $params['pay_weixin']=isset($params['pay_weixin'])?intval($params['pay_weixin']):0;
    $cid=intval($params['chapterid']);
    $fee=intval($params['fee']);

    $data['company']=isset($params['conmpay'])?trim($params['conmpay']):'';
    $data['fans']=isset($params['fanshnum'])?trim($params['fanshnum']):'';
    $data['p_accounts']=isset($params['receivenum'])?trim($params['receivenum']):'';
    $data['p_name']=isset($params['receiveperson'])?trim($params['receiveperson']):'';
    $data['fee']=isset($params['moneycost'])?trim($params['moneycost']):'';
    $data['notes']=isset($params['introduct'])?trim($params['introduct']):'';

    if(
      empty($data['company'])||
      // empty($data['fans'])||
      // $data['fee'] === 0 ||
      empty($data['p_accounts'])||
      empty($data['p_name'])
      )$this->printfail('��Ϣ����ȷ��');

    // pack  fansh  perpri      
    // '0�����,1��ۼ�,2����'
    $platAr=array('pack'=>0, 'fansh'=>1, 'perpri'=>2);
    if(!isset($platAr[$params['pay_way']]))$this->printfail("�����ڸüƷѷ�ʽ!");

    $data['feetype']=$platAr[$params['pay_way']];
    if( $data['feetype'] === 1 ){
      $data['feelence']=$params['pay_weixin'];
      if( $params['pay_weixin'] === 0 )$this->printfail('�����뵥�ۣ�');
    }

    $data['addtime']=JIEQI_NOW_TIME;
    $data['uid']=$_SESSION['jieqiUserId'];
    $data['ordersn']=$this->createOrdersn();
    if( $data['ordersn']=== '' )$this->printfail('��Ϣ����ȷ��');

    $this->db->init('orderqd','id','tuike');
    $res = $this->db->add($data);
    if ($res){
      $this->msgwin('��ӳɹ���');
    }else{
      $this->printfail("�������ʧ��");
    }
  }


  /**
   * ��Ӷ���
   * @param array $params [description]
   */
  function editOrder($params=array()){

    $params['pay_way']=isset($params['pay_way'])?trim($params['pay_way']):0;
    $params['pay_weixin']=isset($params['pay_weixin'])?intval($params['pay_weixin']):0;
    $cid=intval($params['chapterid']);
    $fee=intval($params['fee']);

    $data['company']=isset($params['conmpay'])?trim($params['conmpay']):'';
    $data['fans']=isset($params['fanshnum'])?trim($params['fanshnum']):'';
    $data['p_accounts']=isset($params['receivenum'])?trim($params['receivenum']):'';
    $data['p_name']=isset($params['receiveperson'])?trim($params['receiveperson']):'';
    $data['fee']=isset($params['moneycost'])?trim($params['moneycost']):'';
    $data['notes']=isset($params['introduct'])?trim($params['introduct']):'';

    if(
      empty($data['company'])||
      empty($data['fans'])||
      empty($data['p_accounts'])||
      empty($data['p_name'])||
      $data['money'] === 0
      )$this->printfail('��Ϣ����ȷ��');

    // pack  fansh  perpri      
    // '0�����,1��ۼ�,2����'
    $platAr=array('pack'=>0, 'fansh'=>1, 'perpri'=>2);
    if(!isset($platAr[$params['pay_way']]))$this->printfail("�����ڸüƷѷ�ʽ!");

    $data['feetype']=$platAr[$params['pay_way']];
    if( $data['feetype'] === 1 ){
      $data['feelence']=$params['pay_weixin'];
      if( $params['pay_weixin'] === 0 )$this->printfail('�����뵥�ۣ�');
    }

    $data['addtime']=JIEQI_NOW_TIME;
    $data['uid']=$_SESSION['jieqiUserId'];

    $this->db->init('orderqd','id','tuike');
    $this->db->edit($params['oid'],$data);


    // �޸��Ƿ�ɹ�
    if( $this->db->getAffectedRows() > 0 ){

      $orderqdid=$params['oid'];
      $error='';
      // '0�����,1��ۼ�,2����',
      if( $data['feetype'] === 1 ){ // 1��ۼ�

        /* �޸Ķ�����ÿ�������ĳɱ� */
        $sql="UPDATE ".jieqi_dbprefix('system_qdlist').' SET `fee`=round(`fans`*'.$data['feelence'].',2) WHERE ( orderqdid="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'")';
        $this->db->query($sql);
        if( $this->db->getAffectedRows() <= 0 ){$error.='�����ĳɱ�û�б仯'."<br />"; }


        /* �޸Ķ����ķ�˿�ĳɱ� */
        $selectSonP='(SELECT sum(fee) FROM '.jieqi_dbprefix('system_qdlist').
            ' WHERE ( orderqdid="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'" ) )';
        $selectSonF='(SELECT sum(fans) FROM '.jieqi_dbprefix('system_qdlist').
            ' WHERE ( orderqdid="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'" ) )';
        $sql="UPDATE ".jieqi_dbprefix('tuike_orderqd').' SET `fee`='.$selectSonP.',`fans`='.$selectSonF.
          ' WHERE ( id="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'")';
        $this->db->query($sql);
        if( $this->db->getAffectedRows() <= 0 ){$error.='�������ܼۺͷ�˿û�б仯'."<br />"; }
   
      }elseif( $data['feetype'] === 2  ){ // 2����

        /* �޸Ķ����ķ�˿�ĳɱ� */
        $selectSonP='(SELECT sum(fee) FROM '.jieqi_dbprefix('system_qdlist').
            ' WHERE ( orderqdid="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'" ) )';
        $selectSonF='(SELECT sum(fans) FROM '.jieqi_dbprefix('system_qdlist').
            ' WHERE ( orderqdid="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'" ) )';
        $sql="UPDATE ".jieqi_dbprefix('tuike_orderqd').' SET `fee`='.$selectSonP.',`fans`='.$selectSonF.
          ' WHERE ( id="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'")';
        $this->db->query($sql);
        if( $this->db->getAffectedRows() <= 0 ){$error.='�������ܼۺͷ�˿û�б仯'."<br />"; }

      }elseif( $data['feetype'] === 0 ){ // '0�����

        /* �޸Ķ�����ÿ�������ĳɱ� */
        $sql='SELECT sum(fans) fans FROM '.jieqi_dbprefix('system_qdlist').' WHERE ( orderqdid="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'" )';
        $fansAll=$this->db->getField($this->db->query($sql));
        $uprice=$fansAll == 0?0:round($data['fee']/$fansAll,4);

        $sql="UPDATE ".jieqi_dbprefix('system_qdlist').' SET `fee`=round(`fans`*'.$uprice.',2) WHERE ( orderqdid="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'")';

        $this->db->query($sql);
        if( $this->db->getAffectedRows() <= 0 ){$error.='�����ĳɱ�û�б仯'."<br />"; }

        /* �޸ķ�˿�� */
        $selectSonF='(SELECT sum(fans) FROM '.jieqi_dbprefix('system_qdlist').
            ' WHERE ( orderqdid="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'" ) )';
        $sql="UPDATE ".jieqi_dbprefix('tuike_orderqd').' SET `fans`='.$selectSonF.
          ' WHERE ( id="'.$orderqdid.'" AND uid="'.$_SESSION['jieqiUserId'].'")';
        $this->db->query($sql);
        if( $this->db->getAffectedRows() <= 0 ){$error.='�����ķ�˿û�б仯'."<br />"; }

      }

      $this->msgwin($error===''?'�޸ĳɹ���':$error);
    }else{
      $this->printfail('�޸�ʧ�ܣ�');
    }

  }

  /**
   * ���ɶ�����
   * @return [type] [description]
   */
  function createOrdersn(){

    $ordernumber=date('YmdHi',time()).mt_rand(111,999);
    $sql='SELECT count(*) FROM '.jieqi_dbprefix('tuike_paylog').'WHERE ( ordernumber="'.$ordernumber.'" )';
    $count=$this->db->getField($this->db->query($sql));
    $runN=1;
    while($count>0 && $runN < 200){
      $ordernumber=date('YmdHi',time()).mt_rand(111,999);
      $sql='SELECT count(*) FROM '.jieqi_dbprefix('tuike_paylog').'WHERE ( ordernumber="'.$ordernumber.'" )';
      $count=$this->db->getField($this->db->query($sql));
      $runN++;
    }
    if( $runN === 200 ){return ''; }
    return  $ordernumber;

  } 

  /**
   * ������Ϣ
   * @return [type] [description]
   */
  function getOrder($params=array()){
    $this->db->init("orderqd", "id", "tuike");
    $this->db->setCriteria(new Criteria('uid',$_SESSION['jieqiUserId']));
    $this->db->criteria->add(new Criteria('id',$params['oid']));
    $ar=$this->db->getRow($this->db->queryObjects());
    if( $ar )return $ar;
    return false;
  } 

  /**
   * ɾ���ն���
   * @return [type] [description]
   */
  function delorder($params=array()){
    /* �Ƿ�Ϊ�ն��� */
    $sql='SELECT count(*) FROM '.jieqi_dbprefix('system_qdlist').' WHERE ( orderqdid="'.$params['oid'].'" )';
    $count=$this->db->getField($this->db->query($sql));
    if( $count > 0 )$this->printfail('ֻ��ɾ���ն�����');

    $this->db->init("orderqd", "id", "tuike");
    $this->db->setCriteria(new Criteria('uid',$_SESSION['jieqiUserId']));
    $this->db->criteria->add(new Criteria('id',$params['oid']));
    $this->db->delete($this->db->criteria);
         
    // �޸��Ƿ�ɹ�
    if( $this->db->getAffectedRows() > 0 ){
      $this->msgwin('ɾ���ɹ���');
    }else{
      $this->printfail('ɾ��ʧ�ܣ�');
    }
  } 







/*----newRun-------------------------------------------------------------------------------------------------------------------------------*/











} 
?>