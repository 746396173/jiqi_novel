<?php 
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
class newadminController extends Tuike_controller { 
  public $template_name = 'home'; 
  public $caching = false;
  public $theme_dir = false;
  public function __construct() { 
    parent::__construct();
    $this->assign('nav',7);
  }


  /**
   * �����б�
   * @param  array  $params [description]
   * @return [type]         [description]
   */
  public function main($params = array()){
    $dataObj=$this->model('newadmin');
    $data['new_list']=$dataObj->getNewList();
    $data['List']=$dataObj->newadminOrderList($params);
    $data['page']=$dataObj->getPage($this->getUrl(JIEQI_MODULE_NAME,'newadmin','evalpage=0'));
    $data['uid']=isset($params['uid'])?intval($params['uid']):0;
    $this->display($data,'newadmin_payListAl');

  }
 
  /**
   * ajax �첽
   * @param  [type] $params [description]
   * @return [type]         [description]
   */
  public function ajax_action($params=array()){
    switch($params['ac']){
      case 'setPa':
        $this->model('newadmin')->setPa($params); // ��������״̬
        break;
      case 'downxls':
        $this->model('newadmin')->downxls($params); // ��������״̬
        break;
      default:
        $this->printfail('�����ڸ�����');
    }
  }




/*--------not_run------------------------------------------------------------------------------------------------------------------*/
/*--------not_run------------------------------------------------------------------------------------------------------------------*/








}
?>