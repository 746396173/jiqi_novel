<?php 
/** 
 * ϵͳ����->�û�����->���� * @copyright   Copyright(c) 2014 
 * @author      gaoli* @version     1.0 
 */ 
class usermanageController extends Admin_controller {
		public $template_name = 'main';
		public $theme_dir = false;
		
		public function __construct() { 
              parent::__construct();
			  //�����û� Ȩ��
			  $this->checkpower('adminuser');
        }
        public function main() {
			 if($this->checkpower('deluser',true)) $adminlevel=4;
			 elseif($this->checkpower('adminvip',true)) $adminlevel=3;
			 elseif($this->checkpower('changegroup',true)) $adminlevel=2;
			 else $adminlevel=1;
			 //echo $adminlevel;
			 $dataObj = $this->model('usermanage');
			 $data = $dataObj->main($adminlevel);
             $this->display($data);
        }
		
		
		public function update() {
			 if($this->checkpower('deluser',true)) $adminlevel=4;
			 elseif($this->checkpower('adminvip',true)) $adminlevel=3;
			 elseif($this->checkpower('changegroup',true)) $adminlevel=2;
			 else $adminlevel=1;
			 //echo $adminlevel;
			 //exit;
			 $dataObj = $this->model('usermanage');
			 $data = $dataObj->update($adminlevel);
             //$this->display($data);
        }
} 

?>