<?php 
/** 
 * ���Կ����� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class ylController extends Controller { 

        public $template_name = 'index'; 
		public $caching = false;
		//public $theme_dir = false;
		//public $cacheid = 'fff';
		//public $cachetime=5;
		   
/*        public function __construct() { 
              parent::__construct(); 
        } */
		
		//���ҹ�����ͼ
		public function myArticleView(){
			 $this->display($data,'myarticle'); 
		}
		
		//������ͼ
		public function newArticleView(){
			$dataObj = $this->model('yl');
			$data = $dataObj->newArticleView();
			
			$this->display($data,'newarticle'); 
		}
		
		//��������
        public function newArticle() { 
			$dataObj = $this->model('yl');
			$dataObj->newArticle();
			//exit;
//		     $data = array();
//			 if(isset($_REQUEST['page'])) $page = $_REQUEST['page'];
//		     else $page= 1;
//			 $this->setCacheid($page);
//             if(!$this->is_cached()){echo ' 123ִ���˻����е����ݲ�ѯ����';
//			     //$data['title'] = '��������ҳ����ҳ';
//				 
//				 $C = $dataObj->getArticles();
//				 $data['articlerows'] = $C['data'];
//				 $data['url_jumppage'] = $C['jumppage'];
//				 //$data['test'] = "��������ҳ!!��".date('Y-m-d H:i:s',time()); 
//				 $this->load('aa','system');
//				 //$this->addConfig('system', 'configs');
//				 //$this->addConfig('system', 'blocks');//print_r($jieqiBlocks);
//				 //print_r($this->getConfig('system'));
//				 //$this->addLang('system', 'users');
//				 //$this->addLang('system', 'cache');
//				 //$this->tpl->setCaching(0);
//				 //$this->tpl->setCacheid('index');
//				 //print_r($this->getLang());
//			 }
//             $this->display($data); 
        } 
		
		//�ҵ������б�
		public function yl() { 
			//�ο�article1/masterpage.php
			$dataObj = $this->model('yl');
			$dataObj->test();
		}
		
		//���¹���
		public function ylarticleManage() { 
			$dataObj = $this->model('yl');
			$data = $dataObj->articleManage($this->getRequest('id'));
			$this->display($data,'articlemanage');
		}
		
		//������Ϣչʾ
		public function articleInfoShow(){
		$dataObj = $this->model('article');
		$dataObj->getArticleInfo($this->getRequest('id'));
		
		}
		
		//������Ϣչʾ
		public function articleInfoEdit(){
		
		}
		
} 

//testController �̳����ǵĺ��Ŀ���������ʵ���Ժ��ÿ���������ж�Ҫ�̳еģ���������ͨ����������� http://localhost/myapp/index.php?controller=test ,������������� test �ַ�����

?>