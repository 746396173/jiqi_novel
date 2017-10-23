<?php 
/** 
 * article������ * 
 * @copyright   Copyright(c) 2014 
 * @author      chengyuan 
 * @version     1.0 
 */ 
class articleController extends chief_controller { 
		/**
		 * ����������ͼ
		 */
		public function appwV($param){
			$this->display($data,'applywriter');
		}
		/**
		 * ��������
		 * @param unknown $param
		 */
		public function appw($param){
			if($this->submitcheck()){
				$dataObj = $this->model('article');
				$dataObj->applyWriter($param);
			}
			//$this->display($data,'applywriter');
		}
		/**
		 * ��һ��������������ͼ
		 */
		public function step1View($param){
			header('Content-Type:text/html;charset=gbk');
			$dataObj = $this->model('article','article');
			$data = $dataObj->newArticleView();
			$this->display($data,'newarticle'); 
		}
		
		/**
		 * ��һ������������
		 */
        public function step1($param) { 
        	//��֤���ĺϷ���
        	if($this->submitcheck()){
        		$dataObj = $this->model('article','article');
				$dataObj->newArticle($param);
        	}
        } 
        /**
         * �������������ͼ
         */
        public function step3View($param){
        	$dataObj = $this->model('article','article');
        	$data = $dataObj->step3($param);
        	$this->display($data,'step3');
        }
		/**
		 * �ҵ���Ʒ��
		 */
		public function masterPage($param) { 
			$dataObj = $this->model('article','article');
			$data = $dataObj->myArticleList($param);
			$this->display($data,'masterpage');
		}
		/**
		 * ��Ʒ��Ϣ������ͼ
		 */
		public function editArticleView($param){
			$dataObj = $this->model('article','article');
			$data = $dataObj->editArticleView($param);
			$this->display($data,'articleedit');
		}
		/**
		 * ���±༭
		 */
		public function editArticle($param){
			if($this->submitcheck()){
				$dataObj = $this->model('article');
				$dataObj->editArticle($param);
			}
		}
		/**
		 * ������£�ɾ�������½�
		 */
		public function articleClean($param){
			$dataObj = $this->model('article');
			$dataObj->articleClean($param['aid'], $param['jumpurl'] );
		}
		/**
		 * ɾ��һƪ����
		 */
		public function articleDelete($param){
			$dataObj = $this->model('article');
			$dataObj->articleDelete($param['aid']);
		}
		/**
		 * �������ɾ�̬�ļ�
		 */
		public function repack($param){
			if($this->submitcheck()){
				$dataObj = $this->model('article');
				$dataObj->repack($param['aid'],$param['packflag']);
			}
		}
		/**
		 * �����ͼ
		 */
		public function bcView($param){
			$dataObj = $this->model('article');
			$data = $dataObj->bcList($param);
			$this->display($data,'bookcase');
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
			$dataObj = $this->model('article');
			$dataObj->bcHandle($param);
		}
		/**
		 * ������µ���Ʒ
		 * @param unknown $param
		 */
		public function sevenday($param){
			$this->display($data,'bookcase');
		}
		//���¹���
		public function articleManage() { 
			$dataObj = $this->model('article');
			$data = $dataObj->articleManage($this->getRequest('aid'));
			$this->display($data,'articlemanage');
		}
		
		//������Ϣչʾ
		public function articleInfo(){
		$dataObj = $this->model('article');
		//$dataObj->getArticleInfo($this->getRequest('id'));
		$this->display($data,'articlemanage');
		
		}
		//��¼�� С�����
//		public function miniList($param){
//			$dataObj = $this->model('article');
//			$data = $dataObj->miniList($param);
//			print_r($data);
//			$this->display($data,'miniList');
//		}
/*		//������Ϣ ��Ʒ�б�
		public function userlist($param){
			$this->theme_dir = false;
			header('Content-Type:text/html;charset=gbk');
			$dataObj = $this->model('article');
			$data = $dataObj->userList($param);
//			print_r($data);
			$this->display($data,'userList');
		}
		//������Ϣ �ղ��б�
		public function userbook($param){
		$data=array();
			$this->theme_dir = false;
			header('Content-Type:text/html;charset=gbk');
			$dataObj = $this->model('article');
			$data = $dataObj->userbook($param);
//			print_r($data);
			$this->display($data,'user_book');
		}
		//������Ϣ �����б�
		public function userreview($param){
		$data=array();
		$this->theme_dir = false;
		header('Content-Type:text/html;charset=gbk');
		$reviewsLib = $this->load ( 'reviews', 'article' );
//		$auth = $this->getAuth();
		$data = $reviewsLib->queryReviews(array('uid'=>$param['uid'],'page'=>$param['page'],'ispage'=>1));
//		print_r($data);
			$this->display($data,'user_review');
		}*/
		/**
		 * ͳ�Ƶ����
		 * @param unknown $param
		 */
		public function statisticsVisit($param){
			$dataObj = $this->model('article');
			$dataObj->statisticsVisit($param['aid']);
			return;
		}
		
		/**
		 * ��������opf��txtfull��umd��txtfull��jar���ļ��������ڽ�ͬ������ת��Ϊ�첽����
		 * @param unknown $param
		 */
		public function synchronousMakePack($param){
			$articleObj = $this->model ( 'article');
			$articleObj->synchronousMakePack($param);
		}
		/**
		 * ajax ��֤agent��Ч��
		 * @param unknown $param
		 */
		public function checkAuthor($param){
			$articleObj = $this->model ( 'article');
			//ajaxֻ֧��utf-8
			$articleObj->checkAuthor(iconv('utf-8',JIEQI_DB_CHARSET,$param['author']));
		}
		/**
		 * ajax ��֤agent��Ч��
		 * @param unknown $param
		 */
		public function checkAgent($param){
			$articleObj = $this->model ( 'article');
			//ajaxֻ֧��utf-8
			$articleObj->checkAgent(iconv('utf-8',JIEQI_DB_CHARSET,$param['agent']));
		}
		/**
		 * ajax ��֤�����Ч��
		 * @param unknown $param
		 */
		public function checkIntro($param){
			$articleObj = $this->model ( 'article');
			//ajaxֻ֧��utf-8
			$articleObj->checkIntro(iconv('utf-8',JIEQI_DB_CHARSET,$param['intro']));
		}
		/**
		 * ajax ��֤������Ч�ԣ����Թ��˵�aid���µ�����
		 * @param unknown $param
		 */
		public function checkArticlename($param){
			$articleObj = $this->model ( 'article');
			//ajaxֻ֧��utf-8
			$articleObj->checkArticlename($param['aid'],iconv('utf-8',JIEQI_DB_CHARSET,$param['articlename']));
		}
		

		/**
		 * �����޸Ĳ�����Ϣ
		 * @param unknown $params
		 */
		public function addEditApply($params){
			$dataObj = $this->model('income');
			$dataObj->addEditApply($params['ueid']);
		}
		/**
		 * ������Ϣ
		 * @param unknown $params
		 */
		public function finance($params){
			header('Content-Type:text/html;charset=gbk');
			$dataObj = $this->model('income');
			$data = $dataObj->finance();
			$this->display($data,'finance');
		}
		/**
		 * �������߲�����Ϣ
		 * @param unknown $params
		 */
		public function addFinance($params){
			if($this->submitcheck()){
				$dataObj = $this->model('income');
				$dataObj->addFinance($params);
			}
		}
		/**
		 * �޸����߲�����Ϣ
		 * @param unknown $params
		 */
		public function editFinance($params){
			if($this->submitcheck()){
				$dataObj = $this->model('income');
				$dataObj->editFinance($params);
			}
		}
		
		
		//�����±�
		public function income($params){
			$dataObj = $this->model('income');
			$data = $dataObj->income($params);
			$this->display($data,'income');
		}
		//��������
		public function rewards($params){
			$dataObj = $this->model('income');
			$data = $dataObj->rewards($params);
			$this->display($data,'rewards');
		}
		//������ϸ
		public function exceptional($params){
			$dataObj = $this->model('income');
			$data = $dataObj->exceptional($params);
			$this->display($data,'exceptional');
		}
		
		//��ѯ����
		public function params($param){
			$dataObj = $this->model('income');
			$data = $dataObj->queryex($params);
			$this->display($data,'channelincome');
		}
		//��������
		public function channelIncome($params){
			$dataObj = $this->model('income');
			$data = $dataObj->channelIncome($params);
			$this->display($data,'channelincome');
		}
		
		public function incomedetail($params){
			$dataObj = $this->model('income');
			$data = $dataObj->incomedetail($params);
			$this->display($data,'incomedetail');
		}
		public function getincome($params){
			$dataObj = $this->model('income');
			$data = $dataObj->incomedetail($params);
			$this->display($data,'getincome');
		}
		/**
		 * ��ʱ��ˣ�����ʱ���½ں;���Ҫ��֤key
		 * <br>md5(JIEQI_DB_USER.JIEQI_DB_PASS.JIEQI_DB_NAME.JIEQI_SITE_KEY)
		 * @param unknown $param
		 * 2014-7-4 ����7:13:45
		 */
		public function regularAudits($param){
			$dataObj = $this->model('article');
			$dataObj->regularAudits($param);
		}
		
} 

//testController �̳����ǵĺ��Ŀ���������ʵ���Ժ��ÿ���������ж�Ҫ�̳еģ���������ͨ����������� http://localhost/myapp/index.php?controller=test ,������������� test �ַ�����

?>