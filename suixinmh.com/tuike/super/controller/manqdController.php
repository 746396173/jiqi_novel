<?php
  /**
   * �¼��ƿ���ϸ
   * @author chengyuan  2014-8-6
   *
   */
  header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
  class manqdController extends Tuike_controller {
    public $theme_dir = false;
    public function __construct() { 
      parent::__construct();
      $this->assign('nav',3);
    } 
    /**
     * ���е�����
     * @param  array  $params [description]
     * @return [type]         [description]
     */
    public function main($params = array()) {
      $dataObj=$this->model('qdlist');
      $data['qdList']=$dataObj->manQdList($params);
      $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'manqd','evalpage=0'));
      if( isset($params['uid']) && $params['uid']>0 ){
        $data['tuiInfo']=$this->model('manuser')->qdinfo($params);
      }else{
        $data['tuiInfo']=array();
      }
      $this->display($data,'manqd_qdlist');
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







































}

?>