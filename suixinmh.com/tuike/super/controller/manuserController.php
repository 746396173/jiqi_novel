<?php
  /**
   * �¼��ƿ���ϸ
   * @author chengyuan  2014-8-6
   *
   */
  header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
  class manuserController extends Tuike_controller {
    public $theme_dir = false;
    public function __construct() { 
    parent::__construct();
    $this->assign('nav',2);
  } 
  /**
   * �����ƿ��б�
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  public function main($params = array()) {
    $dataObj=$this->model('manuser');
    $data['ktList']=$dataObj->maUserPay($params);
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0'));
    $data['manList']=$this->model('manusers')->getManList();
    $data['urlTkShare']=str_replace('/manager','',JIEQI_URL).'/login?tku='.$_SESSION['jieqiUserId'];
    $this->display($data,'manuser_list');
  }



  /**
   * �����ƿ͵�ÿ�³�ֵ�б�
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  public function moon($params = array()) {
    $dataObj=$this->model('manuser');
    $params['moon']=isset($params['moon'])?trim($params['moon']):date('Y-m',JIEQI_NOW_TIME);
    // $params['limit']=2;
    $data['ktList']=$dataObj->moon_list($params);
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0'));
    $_REQUEST['moon']=$data['moon']=$params['moon'];

// sleep(4);// ��
    $this->display($data,'manuser_list_moon');
  }



  /**
   * �����ƿ͵�ÿ�³�ֵ�б�����
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  public function moon_download($params = array()) {
    
    $_REQUEST['ajax_request']=1;
    if( !isset($params['moon']) )$this->printfail('�����ڸ�����');
    $dataObj=$this->model('manuser');
    $dataObj->moon_download($params);
  }







  /**
   * ajax �첽
   * @param  [type] $params [description]
   * @return [type]         [description]
   */
  public function ajax($params=array()){
    switch($params['ac']){
      case 'setMan': // ���þ���
        $this->model('manuser')->setMan($params); // ��������״̬
        break;
      case 'setPa':
        $this->model('manuser')->setPa($params); // ��������״̬
        break;
      default:
        $this->printfail('�����ڸ�����');
    }
  }
  /**
   * ĳ���ƿ��µ���ϸ��Ϣ
   * @return [type] [description]
   */
  public function tkuinfo($params = array()){ 
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if($params['uid'] === 0)$this->printfail('�����ڸ��ƿͣ�');

    if($this->submitcheck()){
      $this->model('manuser')->tkInfoEdit($params);
    }
    $data['info']=$this->model('manuser')->tkInfo($params);
    $this->display($data,'manuser_tkuinfo');
 }























  /**
   *  ĳ���ƿ͵���������
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  public function qdlist($params = array()) {
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if($params['uid'] === 0)$this->printfail('�����ڸ��ƿͣ�');
    $dataObj=$this->model('qdlist');
    $data['qdList']=$dataObj->qdlist($params);
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0','SYS=method=qdlist'));
    $data['tuiInfo']=$this->model('manuser')->qdinfo($params);         
    $this->display($data,'manuser_qdlist');
  }
  /**
   * ĳ���ƿ������������ĳ�ֵ��¼
   * @return [type] [description]
   */
  public function paylist($params = array()){ 
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if($params['uid'] === 0)$this->printfail('�����ڸ��ƿͣ�');
    $dataObj = $this->model('pay');
    $data['payList']= $dataObj->getPayList($params);      
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0','SYS=method=paylist'));
    $data['tuiInfo']=$this->model('manuser')->qdinfo($params);
    $this->display($data,'manuser_paylist');
  }
  /**
   * ĳ���ƿ��������¼��ƿ�
   * @return [type] [description]
   */
  public function tkulist($params = array()){ 
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    $params['tkId']=isset($params['tkId'])?intval($params['tkId']):0;
    if($params['uid'] === 0 &&  $params['tkId']===0)$this->printfail('�����ڸ��ƿͣ�');
    $dataObj=$this->model('manuser');
    $data['ktList']=$dataObj->maUserPay($params);
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0'));
    $data['tuiInfo']=$this->model('manuser')->qdinfo(array('uid'=>$params['tkId']));    
    $this->display($data,'manuser_tkulist');
 }
  /**
   * ĳ���ƿ��µ�ÿ�ս���
   * @return [type] [description]
   */
  public function paydaylist($params = array()){ 
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if($params['uid'] === 0)$this->printfail('�����ڸ��ƿͣ�');
    $dataObj = $this->model('paylog');
    $data['paylogList']= $dataObj->payLogListDay($params); 
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0','SYS=method=paydaylist'));
    $data['tuiInfo']=$this->model('manuser')->qdinfo($params);
    $this->display($data,'manuser_paylistday');
  }


  /**
   * �鿴������ϸ���ƹ���ӵģ� sql
   * @return [type] [description] payId
   */
  public function paysettle($params = array()){ 

    if( !isset($params['payId']) || $params['payId'] <=0 )$this->printfail('�����ڸý����¼��');

    $dataObj=$this->model('pay');
    $data['paylog']=$dataObj->getPaylog($params['payId']); ;
    if( !$data['paylog'] || $data['paylog']['type'] == 3 || $data['paylog']['type'] == 4 )$this->printfail('����û����ϸҳ�棡');
    $params['t1']=$data['paylog']['t1'];
    $params['t2']=$data['paylog']['t2'];
    $params['uid']=$data['paylog']['uid'];

    if( $data['paylog']['type'] ==1 ){
      $data['pay_syn_money_old']=PAY_SYN_MONEY_TK;
      $data['payList']=$dataObj->getPayListTk($params);
    }else{
      $data['pay_syn_money_old']=PAY_SYN_MONEY_QD;
      $data['payList']=$dataObj->getPayList($params);
    }
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0','SYS=method=paysettle'));
    $this->display($data,'manuser_paysettle');
  }










}

?>