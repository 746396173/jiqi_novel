<?php 
/**
 * �½ڿ�����
 * @author chengyuan  2014-4-4
 *
 */
class chapterController extends chief_controller { 

//         public $template_name = 'index'; 
// 		public $caching = false;
		//public $theme_dir = false;
		//public $cacheid = 'fff';
		//public $cachetime=5;
		   
/*        public function __construct() { 
              parent::__construct(); 
        } */
		
		/**
		 * �½ھ����
		 */
		public function cmView($param){
			$dataObj = $this->model('chapter','article');
			$data = $dataObj->volumeManage($param);
			$this->display($data,'chaptermanage');
		}
		/**
		 * �����¾�
		 */
		public function saveVolume($param){
			if($this->submitcheck()){
				//�����֤��
				if(empty($param['checkcode']) || $param['checkcode'] != $_SESSION['jieqiCheckCode']){
					$this->addLang('system', 'users');
					$jieqiLang['system'] = $this->getLang('system');
					$this->printfail($jieqiLang['system']['error_checkcode']);
				}
				$dataObj = $this->model('volume');
				$dataObj->saveVolume($param['aid'],$param['previous_volume'],$param['chaptername'],$param['manual'],$param['postdate']);
			}
		}
		/**
		 * �ڶ������ϴ�������ͼ
		 */
		public function step2View($param){
			$dataObj = $this->model('chapter','article');
			$data = $dataObj->set2View($param);
			$this->display($data,'newchapter_step');
		}
		/**
		 * �ڶ����������ϴ�����
		 */
		public function step2($param){
			if($this->submitcheck()){
				$dataObj = $this->model('chapter','article');
				$newChapter = $dataObj->saveChapter($param);
				//�ض����������ͼ
				$this->jumppage ($this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid='.$param['aid']), LANG_DO_SUCCESS,LANG_DO_SUCCESS);
			}
		}
		/**
		 * ���������½���ͼ
		 */
		public function newChapterView($param){
			$chapterObj = $this->model('chapter','article');
			$data = $chapterObj->addChapterView($param);
			$data['ip'] = $this->getIp();
			$this->display($data,'newchapter');
		}
		/**
		 * �����½�
		 */
		public function newChapter($param=array()){
			if($this->submitcheck()){
				$dataObj = $this->model('chapter');
				$newChapter = $dataObj->saveChapter($param);
				if(!empty($newChapter) && in_array($newChapter['display'],array('0','1','2','9'))){
					$this->addLang('article','article');
					$txt =  $this->getLang('article','chapter_display_'.$newChapter['display']);
					$this->jumppage($this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid='.$param['aid']), LANG_DO_SUCCESS,LANG_DO_SUCCESS.'<br>'.$txt);
				}else{
					$this->printfail();
				}
			}
			
		}
		/**
		 * ��������
		 */
		public function batchHandle($param=array()){
			if($this->submitcheck()){
				$dataObj = $this->model('chapter');
				$aid = $param['aid'];
				$chapterids = $param['checkid'];
				if($param['op'] == 1){
					//������ʾ
					$dataObj->hideChapter($aid,$chapterids,0);
				}else if($param['op'] == 2){
					//��������
					$dataObj->hideChapter($aid,$chapterids,1);
				}else if($param['op'] == 3){
					//����ɾ��
					$dataObj->batchDelChapter($aid,$chapterids);
				}
				else if($param['op'] == 4){
					//����ɾ��
					$dataObj->vipChapter($aid,$chapterids,1);
				}
				else if($param['op'] == 5){
					//����ɾ��
					$dataObj->vipChapter($aid,$chapterids,0);
				}
				$this->jumppage ($this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid='.$param['aid']), LANG_DO_SUCCESS,LANG_DO_SUCCESS);
			}
		}
		/**
		 * �½�����
		 */
		public function sortChapter($param=array()){
			$dataObj = $this->model('chapter');
			$data = $dataObj->chapterSort($param);
		}
		/**
		 * �½ڡ����޸���ͼ
		 */
		public function editChapterView($param=array()){
			$dataObj = $this->model('chapter');
			$data = $dataObj->editChapterView($param);
			if($data['chapter']['chaptertype'] == 0){
				$this->display($data,'editchapter');//�½�
			}elseif($data['chapter']['chaptertype'] == 1){
				$this->display($data,'editvolume');//��
			}else{
				$this->jumppage ($this->geturl ( 'article', 'chapter', 'SYS=method=cmView&aid='.$param['aid']), LANG_DO_SUCCESS,LANG_UNKNOWN);
			}
			
		}
		/**
		 * �޸��½�
		 */
		public function editChapter($param){
			if($this->submitcheck()){
				$dataObj = $this->model('chapter');
				$data = $dataObj->editChapter($param);
			}
		}
		/**
		 * �޸ľ�
		 */
		public function editVolume($param){
			if($this->submitcheck()){
				$dataObj = $this->model('volume','article');
				$volume = array();
				$volume['chapterid'] = $param['cid'];
				$volume['articleid'] = $param['aid'];
				$volume['chaptername'] = trim($param['chaptername']);
				$volume['manual'] = trim($param['manual']);
				$volume['postdate'] = trim($param['postdate']);
				$data = $dataObj->editVolume($volume);
			}
				
		}
		//�����½�
		public function hideChapter(){
			$dataObj = $this->model('chapter');
			$dataObj->hideChapter();
		}
		/**
		 * ɾ�������½�
		 * @param unknown $param
		 */
		public function delChapter($param=array()){
			$dataObj = $this->model('chapter');
			$dataObj->delChapter($param);
		}
		/**
		 * ����½�����
		 * @param unknown $params
		 */
		public function checkChapter($params = array()){
			 $dataObj = $this->model('chapter');
			 $dataObj->checkChapter($params);
		}
		
		/**
		 * ajax ����½�������Ч��
		 * @author chengyuan 2015-5-6 ����10:40:58
		 * @param unknown $param
		 */
		public function checkChapterName($param){
			$chapterModel = $this->model ( 'chapter');
			//ajaxֻ֧��utf-8
			$chapterModel->checkChapterName($param['aid'],$param['cid'],iconv('utf-8',JIEQI_DB_CHARSET,$param['chaptername']));
		}
} 

//testController �̳����ǵĺ��Ŀ���������ʵ���Ժ��ÿ���������ж�Ҫ�̳еģ���������ͨ����������� http://localhost/myapp/index.php?controller=test ,������������� test �ַ�����

?>