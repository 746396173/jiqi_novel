<?php 
/** 
 * ϵͳ����->�û���־ * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class userlogController extends Admin_controller {
		public $template_name = 'userlog';
		//public $theme_dir = false;
		public function __construct() { 
              parent::__construct();
			  //�û���־ Ȩ��
			  $this->checkpower('adminuserlog');
        }
		
        public function main($params = array()) {
			 $dataObj = $this->model('userlog');
			 $dataModel = $dataObj->main($params);
			 $data = array(
				 'logrows'=>$dataModel['logrows'],
				 'url_jumppage'=>$dataModel['url_jumppage'],
			 );
             $this->display($data);
        } 
} 

?>