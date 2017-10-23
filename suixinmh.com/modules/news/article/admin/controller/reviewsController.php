<?php 
/** 
 * С˵����->�������� * @copyright   Copyright(c) 2014 
 * @author            liujilei* @version     1.0 
 */ 
class reviewsController extends Admin_controller {
		public $template_name = 'reviews';
		
		public function __construct() { 
              parent::__construct();
			  $this->checkpower('manageallreview');//Ȩ����֤
        } 
		
        public function main($params = array()) {
			 $modelObj = $this->model('reviews');
             $this->display($modelObj->main($params));
        } 
		
		//����ID ɾ�����ۣ���ɾ�������۵Ļظ�����������Ӧ�Ļ���
		public function batchDel($params = array()){
			 $modelObj = $this->model('reviews');
             //$modelObj->delReview($params);
			 //$this->main($params);
			  $this->display($modelObj->batchDel($params));
		}
		
		//��������
	    public function manageReview($params = array())
	   {
			$this->addConfig(JIEQI_MODULE_NAME, 'power');
			$jieqiPower['power'] = $this->getConfig(JIEQI_MODULE_NAME,'power');
			$canedit = $this->checkpower($jieqiPower['power']['manageallreview'], $this->getUsersStatus(), $this->getUsersGroup(), true );
			if($canedit && isset($params['action']) && !empty($params['rid']))
			{
				$modelObj = $this->model('reviews');
				$reviewId = $modelObj->manageReview($params);
			}
			$this->main($params);
	   }
	   //��ʾ�������ظ�
	   public function showReplies($params = array()){
			header('Content-Type:text/html;charset=gbk');//��������ˢ��ʱ��������
	   		$dataObj = $this->model('reviews');
			$data = $dataObj->showReplies($params);
			$this->display($data,'showreplies');
	   }
	   //ɾ���ظ�
	   public function delReply($params = array()){//print_r($params);exit();
	   		$dataObj = $this->model('reviews');
			$dataObj->delReply($params);
	   }
}

?>