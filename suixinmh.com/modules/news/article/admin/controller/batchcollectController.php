<?php 
/**
 * �����ɼ�
 * @author huliming  2014-9-12
 *
 */
class batchcollectController extends Admin_controller {
    public $theme_dir = false;
	public $template_name = '/templates/admin/main';
	public function __construct() { 
		  parent::__construct();
		  $this->checkpower('manageallarticle');//Ȩ����֤
	} 
	
	//��ƪ�ɼ�����ͼ
	public function main($params = array()) {
		$dataObj = $this->model('batchcollect');
		$this->display($dataObj->main($params));
	}
	
}

?>