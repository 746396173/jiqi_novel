<?php 
/** 
 * �¼��ƿ���ϸģ��
 * @author      gaoli* @version     1.0 
 */ 
class manusersModel extends Model{
  //login form
  public function main($params){
    
    $data = array();
    return $data;
  }
  /**
   * ���������ƿ�
   * @param  array   $params       [description]
   * @param  [type]  $custompage   [description]
   * @param  boolean $emptyonepage [description]
   * @return [type]                [description]
   */
  public function maUserPay($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){
    if (!$params['page']) $params['page'] = 1;
    $params['start']=($params['page'] - 1) * $params['limit'];
  
    /* ���� */ 
    $this->db->setCriteria(new Criteria('u.groupid',2));
   
    // ����
    if(isset($params['keyword']) && strlen($params['keyword']) > 0){
      $this->db->criteria->add(new Criteria('u.uname', trim($params['keyword']))); 
    }
    
    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);
    /* ���� */
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder( $params['sort'] );
   
    $q = jieqi_dbprefix('tuike_users').' u ';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('u.uid,u.uname,u.reg_time ');
    $sqlres=$this->db->queryObjects();
    $ar=array();

         
    while($row=$this->db->getRow($sqlres)){
      if( !$row['money'] )$row['money']=0;
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
   * ��Ӿ���
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  function manadd($params=array()){

    $data=array();
    $data['uname']=$params['uname'];
    $data['name']=$data['uname'];
    $data['mobile']=$params['mobile'];
    $data['p_mobil']= $data['mobile'];
    $data['pass']=md5($params['password']);
    $data['groupid']=2;
    $data['is_tuike']=1;

    $userset = array();
    $userset['logindate'] = date('Y-m-d H:i:s',JIEQI_NOW_TIME);
    $userset['lastip'] = $this->getIp();
    $userset['name'] = $params['name'];
    $userset['qq'] = $params['qq'];
    $userset['phone'] = $params['phone'];

    $image_postfix='';
    if (empty($_FILES['upfile']['name']))$this->printfail('ѡ��ͼƬ��');
    if($_FILES['upfile']['error'] > 0)$this->printfail('ѡ��ͼƬ��');
    $tmpfile = '/images/user/w'.date('YmdHis',$_SERVER['REQUEST_TIME']).substr(microtime(),2,1).'.jpg';


    if(!move_uploaded_file($_FILES['upfile']['tmp_name'], JIEQI_ROOT_PATH_APP.$tmpfile))$this->printfail('ѡ��ͼƬ��');

    $userset['img'] = $tmpfile;
    $data['setting']=serialize($userset);

    $this->db->init('users','uid','tuike');
    $res = $this->db->add($data);
   
    if ($res){
      $this->msgwin('��ӳɹ���');
    }else{
      $this->printfail("���ʧ��");
    }

  }

  /**
   * �༭������ϸ
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  function manEdit($params=array()){
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if( $params['uid'] === 0 )$this->printfail('�����ڸ��ƿͣ�');

    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new criteria('uid',$params['uid']));
    $this->db->criteria->setFields('uid,setting');
    $user=$this->db->getRow($this->db->queryObjects());
    $userset = unserialize($user['setting']);

    $data=array();
    $data['uname']=$params['uname'];
    $userset['name'] = $params['co_name'];
    $userset['qq'] = $params['co_qq'];
    $userset['phone'] = $params['co_phone'];
    $data['setting']=serialize($userset);

    $this->db->edit($params['uid'],$data);
    if( $this->db->getAffectedRows() > 0 ){
      $this->msgwin('�޸ĳɹ���');
    }else{
      $this->printfail("�޸�ʧ�ܣ�");
    }
  }



  /**
   * �ϴ���ά��
   * @return [type] [description]
   */
  function uploadImg($params=array()){

    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if( $params['uid'] === 0 )die(json_encode(array('success'=>false,'sourceUrl'=>'','msg'=>iconv('GBK','UTF-8//IGNORE','�����ڸ��ƿͣ�'))));

    $this->db->init('users','uid','tuike');
    $this->db->setCriteria( new Criteria('uid',$params['uid']) );
    $this->db->criteria->setFields('uid,setting');
    $user=$this->db->getRow($this->db->queryObjects());
    if( !$user )die(json_encode(array('success'=>false,'sourceUrl'=>'','msg'=>iconv('GBK','UTF-8//IGNORE','�����ڸ��ƿͣ�'))));
    $setting=unserialize($user['setting']);
    $tmpfileOld=$setting['img'];

    $tmpfile = '/images/user/w'.date('YmdHis',$_SERVER['REQUEST_TIME']).substr(microtime(),2,1).'.jpg';
    if(!move_uploaded_file($_FILES['__avatar1']['tmp_name'], JIEQI_ROOT_PATH_APP.$tmpfile))$this->printfail('ѡ��ͼƬ��');
    
    $setting['img']=$tmpfile; 
    $data['setting']=serialize($setting);
    $this->db->init('users','uid','tuike');
    $this->db->edit($params['uid'],$data);

    // �޸��Ƿ�ɹ�
    if( $this->db->getAffectedRows() > 0 ){
      if(strlen($tmpfileOld)>5)@unlink(JIEQI_ROOT_PATH_APP.$tmpfileOld);
      die(json_encode(array('success'=>true,'sourceUrl'=>JIEQI_URL.$tmpfile,'msg'=>'')));
    }else{
      @unlink(JIEQI_ROOT_PATH_APP.$tmpfile);
      die(json_encode(array('success'=>false,'sourceUrl'=>'','msg'=>iconv('GBK','UTF-8//IGNORE','�޸�ʧ�ܣ�'))));
    }
  }



  /**
   * ���еľ���
   * @return [type] [description]
   */
  function getManList(){
    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('groupid',2));
    $this->db->criteria->setFields('uid,uname');
    $sqlres=$this->db->queryObjects();
    $ar=array();
    while($row=$this->db->getRow($sqlres)){
      $ar[]=$row;
    }
    return $ar;
  }





















































  /**
   * �ƿ��ܵĳ�ֵ��¼
   * @param  array   $params       [description]
   * @param  [type]  $custompage   [description]
   * @param  boolean $emptyonepage [description]
   * @return [type]                [description]
   */
  public function ktUserPay($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){
    if(!isset($params['limit']))$params['limit']=10;
    if (!$params['page']) $params['page'] = 1;
    $params['start']=($params['page'] - 1) * $params['limit'];
    /* ���� */ 
    $this->db->setCriteria();
    $this->db->criteria->add(new Criteria('u.tkuid',$params['uid']));
    $this->db->criteria->add(new Criteria('u.uid',$params['uid'],'!='));
    // ����
    if(isset($params['keyword']) && strlen($params['keyword']) > 0){
      $this->db->criteria->add(new Criteria('u.uname', trim($params['keyword']))); 
    }
    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);
    /* ���� */
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder(($params['sort']===1?'asc':'desc'));
    $q = jieqi_dbprefix('tuike_users').' u LEFT JOIN '. jieqi_dbprefix('system_qdlist').' q ON u.uid=q.uid LEFT JOIN '.jieqi_dbprefix('pay_paylog').' p ON q.qd=p.source AND p.payflag=1';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields("u.uid,u.name,u.reg_time,count(distinct p.buyid) as payusers,round(sum(p.money)/100) as qdpay");
    $this->db->criteria->setGroupby("u.uid");
    $this->db->queryObjects();
    $ar=array();
    while($row=$this->db->getRow()){
      $row['qdpay']=isset($row['qdpay'])?$row['qdpay']:0;
      if(strlen($row['head']) < 6 ){
        $row['head']=YOUYUEBOOK_URL.'/images/noavatarl.jpg';
      }elseif(strpos($row['head'],'http://') === false){
        $row['head']=YOUYUEBOOK_URL.'/'.$row['head'];
      }
      $ar[]=$row;
    }  
    if ($params['pageShow']){
      $this->db->setCriteria(new Criteria('u.tkuid',$params['uid']));
      $this->db->criteria->add(new Criteria('u.uid',$params['uid'],'!='));
      // ����
      if(isset($params['keyword']) && strlen($params['keyword']) > 0){
        $this->db->criteria->add(new Criteria('u.name', trim($params['keyword']))); 
      }
      $q = jieqi_dbprefix('tuike_users').' u';
      $this->db->criteria->setTables($q);
      $this->setVar('totalcount', $this->db->getCount($this->db->criteria));
      $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);
      $this->jumppage->emptyonepage = $emptyonepage;
      if ($custompage) $this->setVar('custompage', $custompage);
    }
    return $ar;
  }


  /**
   * �ƿ���ϸ(������Ϣ)
   * @return [type] [description]
   */
  function tkInfo($params=array()){
    // �ƿ�
    $info=$this->qdinfo($params);
    // �ϼ��ƿ�
    $info['tkuidname']='(��)';
    if( $info['tkuid'] >0 ){
      $row=$this->qdinfo(array('uid'=>$info['tkuid']));
      if( $row )$info['tkuidname']=$row['uname'];
    }
    // ���գ���棬�ƹ㣩
    $info['paylogG']='0';
    $info['paylogT']='0';
    $dateS=date('Y-m-d',strtotime(' -1 day',JIEQI_NOW_TIME));
    $this->db->init('paylog','payid','tuike');
    $this->db->setCriteria(new Criteria('uid',$info['uid'] ));
    $this->db->criteria->add(new Criteria('date',$dateS ));
    $this->db->criteria->setFields('type,money');
    $this->db->queryObjects();
    while($row=$this->db->getRow()){
      if($row['type'] === '1')$info['paylogT']=$row['money'];
      if($row['type'] === '2')$info['paylogG']=$row['money'];
    };
    return $info;
  }
  /**
   * �ƿ���ϸ
   * @return [type] [description]
   */
  function qdinfo($params=array()){
    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('uid',$params['uid'] ));
    $this->db->queryObjects();
    return $this->db->getRow();
  }
  /**
   * ���������ƿ�
   * @param  array   $params       [description]
   * @param  [type]  $custompage   [description]
   * @param  boolean $emptyonepage [description]
   * @return [type]                [description]
   */
  public function maUserTkPay($params=array(),$custompage=JIEQI_PAGE_TAG,$emptyonepage = false){
    if(!isset($params['limit']))$params['limit']=10;
    if (!$params['page']) $params['page'] = 1;
    $params['start']=($params['page'] - 1) * $params['limit'];
    /* ���� */ 
    $this->db->setCriteria(new Criteria('u.tkuid',$params['uid']));
    $this->db->criteria->add(new Criteria('u.uid',$params['uid'],'!='));
    // ����
    if(isset($params['keyword']) && strlen($params['keyword']) > 0){
      $this->db->criteria->add(new Criteria('u.uname', trim($params['keyword']))); 
    }
    /* ��ȡ���� */
    $this->db->criteria->setLimit($params['limit']);
    $this->db->criteria->setStart($params['start']);
    /* ���� */
    $this->db->criteria->setSort($params['orderS']);
    $this->db->criteria->setOrder(($params['sort']===1?'asc':'desc'));
    $q = jieqi_dbprefix('tuike_users').' u LEFT JOIN '.jieqi_dbprefix('system_qdlist').' q ON q.uid=u.uid LEFT JOIN '.
      jieqi_dbprefix('pay_paylog').' p ON p.source=q.qd AND p.payflag=1';
    $this->db->criteria->setTables($q);
    $this->db->criteria->setFields('u.uid,u.uname,u.reg_time,round(sum(p.money)/100) as money ');
    $this->db->criteria->setGroupby("u.uid");
    $sqlres=$this->db->queryObjects();
    $ar=array();
    while($row=$this->db->getRow($sqlres)){
      if( !$row['money'] )$row['money']=0;

      //���ֳ�
      $row['payT']=0;
      $row['payG']=0;
      $this->db->init('paylog','payid','tuike');
      $this->db->setCriteria(new Criteria('type',3,'!='));
      $this->db->criteria->add(new Criteria('uid',$row['uid'] ));
      $this->db->criteria->setFields("count(distinct payid) as payusers,round(sum(money)) as money,type");
      $this->db->criteria->setGroupby('type');
      $this->db->queryObjects();
      while( $ro=$this->db->getRow() ){
        if($ro['type'] === '1'){
          $row['payT']=$ro['money'];
        }elseif($ro['type'] === '2'){
          $row['payG']=$ro['money'];
        }
      }

      //�ƹ�ֳ�
      $this->db->init('users','uid','tuike');
      $this->db->setCriteria(new Criteria('tkuid',$row['uid']));
      $this->db->criteria->add(new Criteria('uid',$row['uid'],'!='));
      $row['payTNum']=$this->db->getCount($this->db->criteria);

      //��������
      $this->db->init('qdlist','id','system');
      $this->db->setCriteria(new Criteria('uid',$row['uid']));
      $row['qdNum']=$this->db->getCount($this->db->criteria);
      $ar[]=$row;
    }

    if ($params['pageShow']){
      $this->db->init('users','uid','tuike');
      $this->db->setCriteria(new Criteria('tkuid',$params['uid']));
      $this->db->criteria->add(new Criteria('uid',$params['uid'],'!='));
      $this->setVar('totalcount', $this->db->getCount($this->db->criteria));
      $this->jumppage = new GlobalPage($custompage, $this->getVar('totalcount'), $params['limit'], $params['page']);
      $this->jumppage->emptyonepage = $emptyonepage;
      if ($custompage) $this->setVar('custompage', $custompage);
    }
    return $ar;
  }



  /**
   * ÿ�εĹ�������
   * @return [type] [description]
   */
  function common(){
    $data=array();
    // ��ѯ�ƿ���
    $this->db->init('users','uid','tuike');
    $this->db->setCriteria(new Criteria('mauid',$_SESSION['jieqiUserId'] ));
    $data['tkNu']=$this->db->getCount($this->db->criteria);
    // ��ѯ����˽��
    $data['payusers']=0;
    $data['money']=0;
    $this->db->init('paylog','payid','tuike');
    $this->db->setCriteria(new Criteria('type',3 ));
    $this->db->criteria->add(new Criteria('payflag',1 ));
    $this->db->criteria->setFields("count(distinct payid) as payusers,round(sum(money)) as money");
    $this->db->queryObjects();
    $row=$this->db->getRow();
    if($row && $data['money']){
      $data['payusers']=$row['payusers'];
      $data['money']=$row['money'];
    }
    return $data;
  }


































} 
?>