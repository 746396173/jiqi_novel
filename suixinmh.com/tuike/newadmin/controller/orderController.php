<?php
  /**
   * �¼��ƿ���ϸ
   * @author chengyuan  2014-8-6
   *
   */
  header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
  class orderController extends Tuike_controller {
    public $theme_dir = false;
    public function __construct() { 
      parent::__construct();
      $this->assign('nav',3);
    } 
    /**
     * �����б�
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function main($params = array()) {
      if($_SESSION['newWeiboUse']===1){
        if($this->submitcheck()){
          $this->model('qdlist_wb')->qdAdd($params);
        }
        $dataObj=$this->model('order_wb');
        $data['qdList']=$dataObj->orderList($params);
        $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manqd','evalpage=0'));
        $this->display($data,'order_list_wb');


      }else{
        if($this->submitcheck()){
          $this->model('qdlist')->qdAdd($params);
        }
        $dataObj=$this->model('order');
        $data['qdList']=$dataObj->orderList($params);
        $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manqd','evalpage=0'));
        $this->display($data,'order_list');
      }
    }
    /**
     * ��Ӷ���
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function addOrder($params = array()) {
      if($this->submitcheck()){
        $this->model('order')->addOrder($params);
      }
      $data=array();
      // $data=array('ordersn'=>$this->model('order')->createOrdersn());
      $this->display($data,'order_addorder');
    }
    /**
     * �޸Ķ���
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function editOrder($params=array()){
      $params['oid']=isset($params['oid'])?intval($params['oid']):0;
      if( $params['oid']===0 )$this->printfail('�����ڸö�����');
      if($this->submitcheck()){
        $this->model('order')->editOrder($params);
      }
      $data=array('info'=>$this->model('order')->getOrder($params));
      $this->display($data,'order_editorder');
    }

    /**
     * ɾ���ն���
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function delorder($params=array()){
      $params['oid']=isset($params['oid'])?intval($params['oid']):0;
      if( $params['oid']===0 )$this->printfail('�����ڸö�����');
      if($this->submitcheck()){
        $this->model('order')->delorder($params);
      }
      $this->printfail('��Ϣ����ȷ��');
    }

    /**
     * ɾ������
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function deleteQd($params=array()){
      if($_SESSION['newWeiboUse']===1){
        $params['qid']=isset($params['qid'])?intval($params['qid']):0;
        if( $params['qid']===0 )$this->printfail('�����ڸö�����');
        $this->model('qdlist_wb')->deleteQd($params);

      }else{
        $params['qid']=isset($params['qid'])?intval($params['qid']):0;
        if( $params['qid']===0 )$this->printfail('�����ڸö�����');
        $this->model('qdlist')->deleteQd($params);

      }
    }

    /**
     * ������ֵ��ϸ
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function qdpaylist($params = array()) {
      if( !isset($params['qdId']) || $params['qdId'] <=0 )ecs_header('Location: '.$this->geturl(JIEQI_MODULE_NAME, 'manqd'));
      $dataObj=$this->model('pay');
      $data['payList']=$dataObj->getPayList($params); 
      $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manqd','evalpage=0','SYS=method=qdpaylist'));
      // $data['qdId']=$params['qdId'];
      $this->display($data,'manqd_qdpaylist');
    }







/*------newRun---------------------------------------------------------------------------------------------------------------------------*/

































}

?>