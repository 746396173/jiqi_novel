<?php 
/** 
 * ���Կ����� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class testController extends Controller { 
		public $template_name = 'test'; 
		public $caching = true;
		public $theme_dir = false;
		public $cachetime=5;
        public function main() { //print_r(Application::$_config);
		    //header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
			echo getenv("HTTP_CLIENT_IP").'='.time();
		   	/*$booktxt = JIEQI_ROOT_PATH.'/booktxt.txt';
		    if($ip_arrays = @file($booktxt)){
			    $ip_arrays = array_unique($ip_arrays);
			    $a_tmp = array();
			    foreach($ip_arrays as $v){
				    echo "update jieqi_article_article set display=1 where articlename='".trim($v)."';<br>";
				}
			}*/
			exit;
			/*if(isset($_REQUEST['page'])) $page = $_REQUEST['page'];
		        else $page= 1;
				$this->addConfig('system', 'configs');
				$this->addConfig('system', 'blocks');
				$this->setCacheid($page);
				$M = $this->model('test');
//				print_r($M->testDatabases());
				$C = $this->load('test',false);
				if(!$this->is_cached()){
					echo ' ִ���˻����е����ݲ�ѯ����';
					//print_r($this->getConfig('system', 'blocks','2'));
					//echo "test"; exit;
					//$data['text'] = "����������ggggggggggggggg"; 
					$data = array(
						'title'=>'�����ҵĵ�'.$page.'����ҳ',
						'list'=>array(
							1=>'��1������_'.$page,
							2=>'��2������_'.$page,
							3=>'��3������_'.$page,
							4=>'��4������_'.$page,
							5=>'��5������_'.$page,
							6=>'��6������_'.$page,
							7=>'��7������_'.$page,
							8=>'��8������_'.$page
						),
					);
				}
                $this->display($data); */
        } 

} 
?>