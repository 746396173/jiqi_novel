<?php
/**
 * article������ *
 * @copyright   Copyright(c) 2014
 * @author      chengyuan
 * @version     1.0
 */
 header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
 class articleController extends chief_controller {

//      public $template_name = 'index';
        public $caching = false;
		public $theme_dir = false;
		//public $cacheid = 'fff';
		//public $cachetime=5;

		/**
		 * �����ͼ
		 */
		public function bcView($param){
			$dataObj = $this->model('article','article');
			$data = $dataObj->bcList($param);//print_r($data);
			// ��ȡ�Ķ���¼
			$ucookie = $this->rCookie();
			if (''!=$ucookie) {
				$data['read_count'] = count($ucookie);
			} else {
				$data['read_count'] = 0;
			}
			$data['read_history'] = $ucookie;
//			$this->dump($data);
			$this->display($data);
		}
		/**
		 * ����Ƴ�һ����
		 * @param  $param
		 */
// 		public function bcRem($param){
// 			$dataObj = $this->model('article');
// 			$dataObj->bcDel($param);
// 		}
		/**
		 * �����������
		 */
		public function bcBatch($param){
			$dataObj = $this->model('article','article');
//			$this->dump($param);
			$dataObj->bcHandle($param);
		}
}

//testController �̳����ǵĺ��Ŀ���������ʵ���Ժ��ÿ���������ж�Ҫ�̳еģ���������ͨ����������� http://localhost/myapp/index.php?controller=test ,������������� test �ַ�����

?>