<?php 
/**
 * �ɼ����ÿ�����
 * @author zhanngxue  2014-9-12
 *
 */
class collectsetController extends Admin_controller {
		//public $template_name = 'applylist';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallarticle');//Ȩ����֤
        } 
		//�ɼ���������ͼ
        public function main($params = array()) {
			$dataObj = $this->model('collectset');
			$data = $dataObj->main($params);
            $this->display($data,'collectset');
        }
		//��ƪ�ɼ����� �༭
		public function collectedit($params = array()){
			$dataObj = $this->model('collectset');
			$dataObj->collectedit($params);
		}
		//��ƪ�ɼ����� �༭��ͼ
		public function collecteditview($params = array()){
			$dataObj = $this->model('collectset');
			$data = $dataObj->collecteditview($params);
            $this->display($data,'empty');
		}
		//�����ɼ����� ��ͼ
		public function collectpage($params = array()){
			$dataObj = $this->model('collectset');
			$data = $dataObj->collectpage($params);
            $this->display($data,'collectpage');
		}
		//�����ɼ����� �༭
		public function collectpedit($params = array()){
			$dataObj = $this->model('collectset');
			$dataObj->collectpedit($params);
		}
		//�����ɼ����� �༭��ͼ
		public function collectpeditview($params = array()){
			$dataObj = $this->model('collectset');
			$data = $dataObj->collectpeditview($params);
            $this->display($data,'empty');
		}
		//�½�����
		public function collectnew($params = array()){
			$dataObj = $this->model('collectset');
			$dataObj->collectnew($params);
		}
		//�½�������ͼ
		public function collectnewview($params = array()){
			$dataObj = $this->model('collectset');
			$data = $dataObj->collectnewview($params);
            $this->display($data,'empty');
		}
}

?>