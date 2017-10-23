<?php
/**
 * �������������
 * @author chengyuan  2014-6-11
 *
 */
class channelController extends Admin_controller {
		public $template_name = 'channel';
		public $caching = false;
// 		public function __construct() {
//               parent::__construct();
// 			  $this->checkpower('manageallarticle');//Ȩ����֤
// 			  //����������Ȩ��
// 			  $this->checkpower('setwriter');
//         }
		/**
		 * Ĭ�����
		 * @param unknown $params
		 */
        public function main($params = array()) {
        	$data = array();
        	$dataObj = $this->model('channel');
        	$this->display($dataObj->main($params));
        }
        /**
         * �����������
         * @param unknown $params
         */
        public function schedule($params = array()){
        	$dataObj = $this->model('channel');
        	$dataObj->schedule($params['channelid'],$params['uids']);
        }
        /**
         * �������޸�
         * @param unknown $params
         */
        public function add($params = array()){
        	$dataObj = $this->model('channel');
        	$this->display($dataObj->add($params), $this->template_name.'_add'.$params['step']);
        }
        /**
         * idɾ������
         * @param unknown $params
         */
        public function del($params = array()){
        	$dataObj = $this->model('channel');
        	$dataObj->del($params);
        }
        /**
         * ����
         * @param unknown $params
         */
        public function order($params = array()){
        	$dataObj = $this->model('channel');
        	$dataObj->order($params);
        }
        /**
         * ������������
         * @param unknown $params
         * 2014-6-12 ����3:00:34
         */
        public function pushArticles($params = array()){
        	if($this->submitcheck()){
        		$dataObj = $this->model('channel');
        		$data = $dataObj->pushArticles($params['cid'],$params['articleids'],$params['statu']);
        	}
        }
		/**
		 * ����������ͼ
		 * @param unknown $params
		 * 2014-6-12 ����2:17:40
		 */
        public function pushView($params = array()){
        	$dataObj = $this->model('channel');
        	$data = $dataObj->pushView($params);
        	$this->template_name = 'article_list';
        	$this->display($data);
        }
        /**
         * �����ɼ���ͼ
         * @param unknown $params
         * 2014-8-19 ����1:46:01
         */
        public function collectView($params = array()){
        	$dataObj = $this->model('channel');
        	$data = $dataObj->collectList($params['cid'],$params['page']);
        	$this->template_name = 'article_collect_list';
        	$this->display($data);
        }
        /**
         * �����ɼ���⣬����|����
         * @param unknown $params
         * 2014-8-19 ����4:35:07
         */
        public function newArticle($params = array()){
        	$dataObj = $this->model('channel');
        	$id = $params['aid'] ? array($params['aid']) : $params['aids'];
        	$data = $dataObj->newArticle($params['cid'],$id,$page);
        }
        /**
         * ɾ�����͵�����
         * @param unknown $params
         * 2014-6-13 ����1:35:42
         */
        public function delArticle($params = array()){
        	$dataObj = $this->model('channel');
        	$id = $params['paid'] ? $params['paid'] : $params['paids'];
        	$data = $dataObj->delArticle($params['cid'],$id);
        }
        /**
         * ����������߷��
         * @param unknown $params
         * 2014-6-13 ����2:25:48
         */
        public function editStatu($params = array()){
        	$dataObj = $this->model('channel');
        	$id = $params['paid'] ? $params['paid'] : $params['paids'];
        	$data = $dataObj->editStatu($params['cid'],$id,$params['value']);
        }

        public function  editArticle($params = array()){
        	$dataObj = $this->model('channel');
        	$data = $dataObj->editArticle($params);
        	$this->display($data,'article_edit');
        }
		/**
		 * ����
		 * @param unknown $params
		 * 2014-6-27 ����2:12:34
		 */
        public function push($params = array()){
        	$dataObj = $this->model('channel');
        	$data = $dataObj->push($params);
        }
        /**
         * ��ƪͬ��/����ͬ���麣�½�
         * <p>
         * ���麣��վ�������½ڸ���һ�ݵ�api�����ݳ��У��Թ�api�Ķ��α༭��
         * @param unknown $params
         * 2014-8-27 ����2:42:14
         */
        public function synchronization($params = array()){
        	$dataObj = $this->model('chapter');
        	$id = $params['paid'] ? array($params['paid']) : $params['paids'];
        	$dataObj->synchronization($params['cid'],$id);
        }
        /**
         * ���ݳ��½��б�ͬ����
         * @param unknown $params
         * 2014-8-28 ����3:28:41
         */
        public function chapterList($params = array()){
        	$dataObj = $this->model('chapter');
        	$data =  $dataObj->chapterList($params['cid'],$params['paid']);
        	$this->display($data,'chapter_list');
        }
        /**
         * ajax��ȡ���ݳ��½���Ϣ������json��ʽ
         * @param unknown $params
         * 2014-9-1 ����1:41:33
         */
        public function getChapter($params = array()){
        	$dataObj = $this->model('chapter');
        	$dataObj->getChapter($params['cid']);
        }
        /**
         * �޸��½�
         * @param unknown $params
         * 2014-9-2 ����9:09:17
         */
        public function editChapter($params = array()){
        	$dataObj = $this->model('chapter');
        	$dataObj->editChapter($params['pcid'],$params['chaptername'],$params['content'],true);
        }
        /**
         * ����/�����½�
         * @param unknown $params
         * 2014-9-12 ����2:28:05
         */
        public function insertChapter($params = array()){
        	$dataObj = $this->model('chapter');
        	$dataObj->insertChapter($params['pcid'],$params['chaptername'],$params['content'],$params['insertChapterName'],$params['insertContent']);
        }
        /**
         * ɾ��һ���½�
         * @param unknown $params
         * 2014-9-12 ����2:32:46
         */
        public function delete($params = array()){
        	$dataObj = $this->model('chapter');
        	$dataObj->delete($params['pcid']);
        }
}

?>