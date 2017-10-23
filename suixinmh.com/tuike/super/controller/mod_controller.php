<?php
/** 
 * ��̨������Ŀ����� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); 
class Tuike_controller extends Controller{
  public $theme_dir = 'main';
  public $caching = false;
  
  public function __construct() { 
    global $cache_redis;
    include_once(JIEQI_ROOT_PATH."/include/total_service_funcs.php");
    redis_conn();
    parent::__construct();
    

    //�ж��ƿ͵��ϼ�
    if(!defined('JIEQI_NEED_SOURCE')) define('JIEQI_NEED_SOURCE',true);
    if(defined('JIEQI_NEED_SOURCE') && $_SESSION['SOURCE_SITE']=='' && $_REQUEST['tku']){
      setcookie('SOURCE_SITE',$_REQUEST['tku'],time()+3600*360,'/');
      $_SESSION['SOURCE_SITE'] = $_REQUEST['tku'];
    }

    $this->assign(array(
      'youyuebook_url' => YOUYUEBOOK_URL,
      'youyuebook_url_m' => YOUYUEBOOK_URL_M,
      'jieqi_site_name' => JIEQI_SITE_NAME,
      'nav' => 1,
     ));

    if(application::$DU_CONTROLLER != 'login' && application::$DU_METHOD != '_runPayOurAuthCron'){
      $this->checkLogin(false);
    }

//     if(isset($_GET['qq'])){

//       if( $cache_redis->isExists('dsfdsf_name_tmp_ar_se') ){
//         $arr_name=unserialize( $cache_redis->get('dsfdsf_name_tmp_ar_se') );
//       }else{
//         $arr_name=array();
//       }


//       array_push($arr_name,'fgref43f44');

//   if( count($arr_name) > 3000 )array_shift($arr_name);
// var_dump( $arr_name );
// die();



//     }





    $comm=$this->model('manuser')->common();
    $this->assign('comm',$comm);

  } 

  /**
   * ����½
   * @param  boolean $return [description]
   * @return [type]          [description]
   */
  public function checkLogin($return=false){


    if(isset($_SESSION['jieqiUserId']) && $_SESSION['jieqiUserId'] >0 ){
      if($return)return true;
      
    }else{
      if($return)return false;
      ecs_header('Location: '.$this->geturl(JIEQI_MODULE_NAME, 'login'));
    }
  }



  //��̨Ȩ�޼��
  public function checkpower($pname, $isreturn=false){

    //include_once('model/powerModel.php'); 
    if($pname=='admin'){
      if(!$this->checkisadmin()){
        if(!$isreturn) jieqi_printfail(LANG_NEED_ADMIN);
        else return false;
      }else return true;
    }else{
      $powerObj = $this->model();
      $mod = $this->getRequest('mod') && $pname != 'adminpanel' ? $this->getRequest('mod'):'system';
      return parent::checkpower($powerObj->getDbPower($mod,$pname), $this->getUsersStatus(), $this->getUsersGroup(), $isreturn, true);
    }
  }

}
?>