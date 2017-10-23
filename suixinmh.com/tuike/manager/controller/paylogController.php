<?php 
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
class paylogController extends Tuike_controller { 
  public $caching = false;
  public $theme_dir = false;
  public function __construct() { 
    parent::__construct();
    $this->assign('nav',4);
  }
  public function main($params = array()){

    $dataObj=$this->model('paylog');
    $data['payList']=$dataObj->payLogList($params);

    if( !isset($params['t1'],$params['t2']) || strlen($params['t1']) !== 10 || strlen($params['t2']) !== 10 ){
      $params['t1']=$params['t2']=date('Y-m-d',JIEQI_NOW_TIME);
    }
    $data['t1']=$params['t1'];
    $data['t2']=$params['t2'];
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'home','evalpage=0'));
    
    // 7��֧��,2֧����,3�����,8֧��ʧ��,   1�����,7���ͨ��,9���ʧ��
    switch($params['payflag']){
      case 1:
        $this->display($data,'paylog_payListWai');
        break;
      case 7:
        $this->display($data,'paylog_payListFin');
        break;
      case 9:
        $this->display($data,'paylog_payListFail');
        break;
      default:
        $this->display($data,'paylog_payListAl');
    }
  }
 


  /**
   * ajax �첽
   * @param  [type] $params [description]
   * @return [type]         [description]
   */
  public function ajax_action($params=array()){
    switch($params['ac']){
      case 'setPa':
        $this->model('paylog')->setPa($params); // ��������״̬
        break;
      default:
        $this->printfail('�����ڸ�����');
    }
  }

  /**
   * �˳���¼
   * @return [type] [description]
   */
  public function logout(){ 
    $dataObj = $this->model('paylog');
    $dataObj->logout();
  }

}
?>