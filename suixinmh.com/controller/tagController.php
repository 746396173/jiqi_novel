<?php 
/** 
 * ���Կ����� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class tagController extends Controller { 

        public $template_name = 'tag'; 
		public $caching = false;
		public $theme_dir = false;

        public function main($params = array()) { //print_r(Application::$_config);
			$id = intval($params['id']);
			if($id) echo('document.write("'.addslashes_array(str_replace(array("\r","\n"),'',jieqi_geturl('system', 'tags', $id))).'");');
			exit;
        } 
} 

//testController �̳����ǵĺ��Ŀ���������ʵ���Ժ��ÿ���������ж�Ҫ�̳еģ���������ͨ����������� http://localhost/myapp/index.php?controller=test ,������������� test �ַ�����

?>