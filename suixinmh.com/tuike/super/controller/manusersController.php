<?php
  /**
   * �¼��ƿ���ϸ
   * @author chengyuan  2014-8-6
   *
   */
  header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
  class manusersController extends Tuike_controller {
    public $theme_dir = false;
    public function __construct() { 
    parent::__construct();
    $this->assign('nav',4);
  } 

  
  /**
   * ���о����б�
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  public function main($params = array()) {

    $dataObj=$this->model('manusers');
    $data['ktList']=$dataObj->maUserPay($params);
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manusers','evalpage=0'));
    $this->display($data,'manusers_list');
  }
  /**
   * ��Ӿ���
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  function manadd($params=array()){
    $data=array();
    if($this->submitcheck()){
      $dataObj=$this->model('manusers');
      $dataObj->manadd($params);
    }
    $this->display($data,'manusers_manadd');
  }
  /**
   * �鿴����
   * @return [type] [description]
   */
  public function tkuinfo($params = array()){ 
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if($params['uid'] === 0)$this->printfail('�����ڸ��ƿͣ�');


    if($this->submitcheck()){
      $dataObj=$this->model('manusers')->manEdit($params);
    }else{
      $data['info']=$this->model('manuser')->tkInfo($params);
      $setting=unserialize($data['info']['setting']);
      if($setting){
        $data['info']['co_name']=$setting['name'];
        $data['info']['co_qq']=$setting['qq'];
        $data['info']['co_phone']=$setting['phone'];
        $data['info']['co_img']=$setting['img'];
      }else{
        $data['info']['co_name']='';
        $data['info']['co_qq']='';
        $data['info']['co_phone']='';
        $data['info']['co_img']='';
      }
    }


    $this->display($data,'manusers_tkuinfo');
 }

  /**
   * �ϴ���ά��
   * @return [type] [description]
   */
  public function uploadImg($params=array()){
    if (empty($_FILES['__avatar1']['name']))die(json_encode(array('success'=>false,'sourceUrl'=>'','msg'=>'ͼƬ������')));
    if($_FILES['__avatar1']['error'] > 0)die(json_encode(array('success'=>false,'sourceUrl'=>'','msg'=>'����')));
    $this->model('manusers')->uploadImg($params);
  }






















  /**
   *  �ƿ͵���������
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  public function qdlist($params = array()) {
    $orderAr=array(
      'id'=>'id',
      'name'=>'name',
      'fee'=>'fee',
      'pdate'=>'pdate'
      );
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if($params['uid'] === 0)$this->printfail('�����ڸ��ƿͣ�');
    $params['order']=isset($params['order']) && $orderAr[$params['order']]?$params['order']:'id';
    $params['orderS']=$orderAr[$params['order']];
    $params['sort']=isset($params['sort']) && $params['sort']==1?1:0;
    $SYS='SYS=method=qdlist&sort='.$params['sort'];
    $SYS.='&order='.$params['order'].'&uid='.$params['uid'];
    $dataObj=$this->model('qdlist');
    $params['limit']=10;
    $params['pageShow']=true;
    $data['qdList']=$dataObj->qdlist($params);
    $data['order']=$params['order'];
    $data['sort']=$params['sort'];
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0',$SYS));
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
    $params['limit']=10;
    $params['pageShow']=true;
    $params['orderS']='p.rettime';
    $data['payList']= $dataObj->getPayList($params);      
    $SYS='SYS=method=paylist';
    $SYS.='&uid='.$params['uid'];
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0',$SYS));
    $data['tuiInfo']=$this->model('manuser')->qdinfo($params);
    $this->display($data,'manuser_paylist');
  }
  /**
   * ĳ���ƿ������������ĳ�ֵ��¼
   * @return [type] [description]
   */
  public function tkulist($params = array()){ 
     $orderAr=array(
      'id'=>'u.uid',
      'name'=>'u.name',
      'reg_time'=>'u.reg_time',
      );
    $params['uid']=isset($params['uid'])?intval($params['uid']):0;
    if($params['uid'] === 0)$this->printfail('�����ڸ��ƿͣ�');
    $params['order']=isset($params['order']) && $orderAr[$params['order']]?$params['order']:'id';
    $params['orderS']=$orderAr[$params['order']];
    $params['sort']=isset($params['sort']) && $params['sort']==1?1:0;
    $SYS='SYS=sort='.$params['sort'];
    $SYS.='&order='.$params['order'].'&uid='.$params['uid'];
    $dataObj=$this->model('manuser');
    $params['limit']=10;
    $params['pageShow']=true;
    $data['ktList']=$dataObj->maUserTkPay($params);
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manuser','evalpage=0',$SYS));
    $data['order']=$params['order'];
    $data['sort']=$params['sort'];
    $data['tuiInfo']=$dataObj->qdinfo($params);
    $this->display($data,'manuser_utklist');
 }



}

?>