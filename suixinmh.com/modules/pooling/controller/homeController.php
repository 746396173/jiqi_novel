<?php
/**
 * �������͵�����Ԥ��
 * @author chengyuan  2014-6-11
 *
 */
header ( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" );
class homeController extends Controller {
		public $theme_dir = false;//���ģ��
		public $template_name = 'index';
		public $caching = false;
// 		public function __construct() {
//               parent::__construct();
// 			  $this->checkpower('manageallarticle');//Ȩ����֤
// 			  //����������Ȩ��
// 			  $this->checkpower('setwriter');
//         }
		/**
		 * Ĭ�����,ͨ��ac�����ж��߼�ҵ��
		 * @param unknown $params
		 */
		public $msg = array('0'=>'�ɹ�','-1'=>'��֤ʧ��','-2'=>'��������','-3'=>'���ݳؿ�','-4'=>'�Ѿ�ɾ��');
		public function booklist($params = array()){
		    $this->main($params);
		}
		public function bookinfo($params = array()){
		    $params['ac'] = 'info';
		    $this->main($params);
		}
		public function chapterlist($params = array()){
		    $params['ac'] = 'chapters';
		    $this->main($params);
		}
		public function chapter($params = array()){
		    $params['ac'] = 'chapter';
		    $this->main($params);
		}
		public function getcontents($params = array()){
		    $params['ac'] = 'chapter';
		    $this->main($params);
		}
        public function main($params = array()) {
        	$dataObj = $this->model('preview');
        	$ac = $params['ac'];
			$aid = $params['aid'] ? $params['aid'] : ($params['bookid'] ? $params['bookid'] : $params['bookId']);
			$cid = $params['cid'] ? $params['cid'] : $params['chapterid'];
			$params['aid'] = $aid ? $aid : $params['bid'];
			$params['cid'] = $cid;
        	if($ac == 'content'){//֧��aid>bookid|cid>chapterid
				//chapters_91_com ȡ����
				//1���2�շ�
// 				if(substr($cid,0,1)==1 || substr($cid,0,1)==2){
// 					$params['aid'] = $aid;
// 					$params['cid'] = substr($cid,1);
// 					$data = $dataObj->chapter($params);//�������ݰ��������£�����
// 					$this->setTemplate($data,'chapter');
// 				}else $this->printfail(LANG_ERROR_PARAMETER);
				$data = $dataObj->chapter($params);//�������ݰ��������£�����
				$this->setTemplate($data,'chapter');
        	}elseif ($ac == 'chapters' || $ac == 'chapterlist'){ 
        		$params['aid'] = $params['aid'] ? $params['aid'] : $params['bid'];
        		$data = $dataObj->chapters($params);//�������ݰ������Ƽ����£�����
        		$this->setTemplate($data,'chapters');
        	}elseif($ac == 'chapters_2345'){
        		$params['read_chapter'] = 1;//ֻ��ȡ�½�
        		$data = $dataObj->chapters($params);
        		$this->setTemplate($data,'chapters');
        	}elseif ($ac == 'cquire'){
        		$data = $dataObj->cquire($params);
        		$this->setTemplate($data,$ac);
        	}elseif($ac == 'chapter' || $ac == 'vipchapter' || $ac == 'chapterContent' ){
        		$params['aid'] = $params['aid'] ? $params['aid'] : $params['bid'];
        		$data = $dataObj->chapter($params);//�������ݰ������Ƽ����£��½����ݣ�����
        		$this->setTemplate($data,'chapter');
        	}elseif ($ac == 'info' || $ac == 'bookinfo' || $ac == 'book'){
        		$params['aid'] = $params['aid'] ? $params['aid'] : $params['bid'];
        		$params['aid'] = $params['aid'] ? $params['aid'] : $params['bookid'];
        		$data = $dataObj->info($params);//�������ݰ�����������Ϣ������
        		$this->setTemplate($data,$ac);
        	}elseif ($ac == 'sort'){
        		$data = $dataObj->sort();//�������ݰ�����������Ϣ������
        		$this->setTemplate($data,'sort');
        	}elseif ($ac == 'c_2345'){
        		$data = $dataObj->c_2345($params);
        		$this->setTemplate($data,'c_2345');
        	}elseif($ac == 'black'){//����鼮�б�
        		$params['pushflag']=0;
        		$data = $dataObj->main($params);//�������ݰ������Ƽ����£�����
        		$this->setTemplate($data,'black');
        	}else{
        		//Ĭ��,�����б�
        		$data = $dataObj->main($params);//�������ݰ������Ƽ����£�����
        		$this->setTemplate($data,$type = $ac ? $ac : 'index');
        	}
        }

		private function displayjosn($row,$type,$code){

			$datarr['code'] = $code;
			$datarr['msg'] = $this->msg[$code];
			$arr  = array();
			if ($type=='index'){
				foreach($row['rows'] as $k => $v){
					$arr[$k] = $v['articleid'];
				}
				$datarr['body'] = $arr ;
			}else if ($type=='info'){
				$arr['bookid']  = $row['article']['articleid'];
				$arr['book_name'] =  $row['article']['articlename'] ;
				$arr['author'] =  $row['article']['author'];
				$arr['description'] = $row['article']['intro'];
				$arr['complete_status'] = $row['article']['fullflag']>0?2:1;
				$arr['parent_category_name'] =  '';
				$arr['category_name'] =  $row['article']['shortcaption'];
				$arr['keywords'] =  $row['article']['keywords'];
				$arr['img'] =  $row['article']['url_image_l'];
				$arr['isvip'] =  $row['article']['articletype']>0?2:0;
				$arr['price'] =  3;
				$arr['down_count'] =  0;
				$arr['hits_count'] = $row['article']['allvisit'];
				$datarr['body'] = $arr ;
			}else if ($type=='chapters'){
				$arr['book_id'] = $row['article']['articleid'];
				foreach($row['chapters'] as $k=>$v){
				    $chapterinfo = array();
					if (!$v['chaptertype']){
						$chapterinfo['chapter_id'] = $v['chapterid'];
						$chapterinfo['chapter_name'] = $v['chaptername'];
						$chapterinfo['isvip'] = $v['isvip'];
						$chapterinfo['update_time'] = $v['lastupdate'];
						$arr['chapter_list'][] = $chapterinfo;
					}
				}

				$datarr['body'] = $arr ;
			}else if ($type=='chapter'){
                if (!$row['chapter']['chaptertype']){
					$arr['bookid']  = $row['chapter']['articleid'];
					$arr['chapter_id'] =  $row['chapter']['chapterid'] ;
					$arr['chapter_content'] =  $row['chapter']['content'];
					$arr['chapter_size'] = $row['chapter']['size'];
					$datarr['body'] = $arr ;
				}
			}
			exit(str_replace("\\/", "/",$this->json_encode($datarr)));
		}
		/**
		 * �ϰ汾�Ļ�ȡvipͼƬ���ݵ�
		 * @param unknown $params
		 * 2014-8-25 ����10:44:00
		 */
		public function oldVipContent($params = array()){
			//aid,cid,sign
			if(!$params['id'] || !$params['cid'] || !$params['sign']){
				$this->printfail(LANG_ERROR_PARAMETER);
			}
			$dataObj = $this->model('preview');
			$sign2 = md5('MtQwU3yxZZAbz%cet!@Vsj'.'|'.$params['id'].'|'.$params['cid']);
			if($sign2!=$params['sign']) exit('sign error');
			$dataObj->getOldVipContent($params['id'],$params['cid'],$params['sign'],$params['type']);
		}

		/**
		 * Ŀ¼
		 * @param unknown $params
		 * 2014-6-17 ����3:17:53
		 */
       /* public function chapters($params = array()){
        	$dataObj = $this->model('preview');
        	$data = $dataObj->chapters($params);//�������ݰ������Ƽ����£�����
        	$this->setTemplate($data,'chapters');
        }*/
        /**
         * �½�����
         * @param unknown $params
         * 2014-6-18 ����4:51:07
         */
      /*  public function chapter($params = array()){
        	$dataObj = $this->model('preview');
        	$data = $dataObj->chapter($params);//�������ݰ������Ƽ����£��½����ݣ�����
        	$this->setTemplate($data,'chapter');
        }*/
        /**
         * ����������������Ϣ�����ö�Ӧģ�壺xml|html
         * @param unknown $data	���ص�ģ������ݰ������������������Ϣ
         * @param string $type	Ĭ��index|chapters|chapter|info|sort|c
         * 2014-6-17 ����5:01:55
         */
        private function setTemplate($data,$type='index'){
        	$setting = $data['channel']['setting'];
				if($setting['getdata']['dataformat'] == 'xml'){
					$tt = str_replace('.','_',$data['channel']['url']);
					//
// 	        		$tt = str_replace('.','_','baidu.com'); //pass
					//$tt = str_replace('.','_','163.com22');//pass
	//         		$tt = str_replace('.','_','360.com');//pass
	//         		$tt = str_replace('.','_','2345');//���⴦��������
					//$tt = str_replace('.','_','3320.net');//pass
					//$tt = str_replace('.','_','abada.cn');//pass
	//         		$tt = str_replace('.','_','ifeng.com');//pass
	//         		$tt = str_replace('.','_','wjsw.com');//pass
					//$tt = str_replace('.','_','zhangyue.com');//pass
					//$tt = str_replace('.','_','ifeng.com');//pass
					//�Ƿ�ʹ��Ĭ��ģ��
					if(file_exists(Application::$_HLM_VIEW_PATH."/xml/{$type}_{$tt}.html")){
						$this->template_name = "xml/{$type}_{$tt}";//ָ��ģ��
					}else{
						$this->template_name = "xml/{$type}";//xml��ʽ���������б�Ĭ��ģ��
					}
					header('Content-Type:text/xml;');
					$this->display($data);
				}elseif ($setting['getdata']['dataformat'] == 'html'){
					$this->template_name = "html/{$type}";//html��ʽ���������б�ģ�壨ֻ��һ��ģ�壩
					header('Content-Type:text/html;');
					$this->display($data);
				}elseif($setting['getdata']['dataformat'] == 'json'){
					if(!$data['channel']['url']){
						$this->printfail('channel is null');
					}
					$className = str_replace(".com","",$data['channel']['url']);
					$displayJsonImpl = $this->load('displayjson'.$className,'pooling');
					$resutl = array();
					if($type == 'index'){
						$resutl = $displayJsonImpl->articlePage($data);
					}elseif ($type == 'page'|| $type == 'booklist'){
						$resutl = $displayJsonImpl->articleList($data);
					}elseif ($type == 'info' || $type == 'book'){
						$resutl = $displayJsonImpl->articleInfo($data);
					}elseif ($type == 'chapters'  || $type == 'chapterlist'){
						$resutl = $displayJsonImpl->chapterList($data);
					}elseif ($type == 'chapter'){
						$resutl = $displayJsonImpl->chapterContent($data['chapter']);
					}else{
						$this->printfail(LANG_ERROR_PARAMETER);
					}
					if(!empty($resutl)){
						exit(str_replace("\\/", "/",$this->json_encode($resutl)));
					}else{
						$this->printfail(LANG_ERROR_PARAMETER);
					}
				}else{
					$this->printfail(LANG_ERROR_PARAMETER);
				}
        }
		/**
		 * ͬ���������ݳغ�api����
		 *
		 * 2014-6-24 ����10:35:22
		 */
        public function sync(){
        	$dataObj = $this->model('preview');
        	$data = $dataObj->sync();
			exit;
        }
        public function sync_api($params = array()){
        	$dataObj = $this->model('preview');
        	$data = $dataObj->sync_article_api($params);
        	exit;
        }
        public function handleChapter($params = array()){
        	$dataObj = $this->model('preview');
        	$data = $dataObj->handleChapter();
        	exit;
        }
        public function handleStatamout($params = array()){
        	$dataObj = $this->model('preview');
        	$dataObj->handleStatamout();
        	exit;
        }
}

?>