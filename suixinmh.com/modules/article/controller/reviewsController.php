<?php 
/**
 * ����������
 * @author chengyuan 2015-6-11 ����9:10:15
 */ 
class reviewsController extends Controller
 { 
	public $caching = false;
	//��ѯ����ʾ����
	public function main($params = array())
	{
		header('Content-Type:text/html;charset=gbk');//��������ˢ��ʱ��������
		$modelObj = $this->model('reviews');
		$data = $modelObj->main($params);
	 	$this->display($data); 
	}
	
	//�������ۣ����⣩ID ��ѯ����
	public function showReplies($params = array())
	{	
		$this->template_name = 'reviewshow';
		$modelObj = $this->model('reviews');
		$data = $modelObj->showReplies($params);
		
	 	$this->display($data);
	}
	
	public function addReplies($params = array())
	{	
		
		if($this->submitcheck()){
			$modelObj = $this->model('reviews');
			$modelObj->addReplies($params);
		}
	}
	
	//�༭����
	public function editReply($params=array())
	{
		$this->template_name = 'reviewedit';
		$modelObj = $this->model('reviews');
		$data = $modelObj->editReply($params);
		$this->display($data);
	}
	//�������ӻظ�
	public function manageReplies ($params=array())
	{
		if($this->submitcheck()){
			$params['dosubmit'] = true;
		}else{
			$params['dosubmit'] = false;
		}
		$modelObj = $this->model('reviews');
		$modelObj->manageReplies($params);
		
		//��ѯ��ת��
		$this->showReplies($params);
	}
	
	//��������
	public function add($params = array())
	{ 	
			$modelObj = $this->model('reviews');
			$modelObj->add($params);
	}
	
	//��������
	public function manageReview($params = array())
	{
		if(isset($params['action']) && !empty($params['rid']))
		{
			$modelObj = $this->model('reviews');
			$modelObj->manageReview($params); 
		}else{
			$this->printfail(LANG_ERROR_PARAMETER);
		}
	}
	public function dianzan($params = array())
	{
		$modelObj = $this->model('reviews');
		$modelObj->manageReplies($params);
	}
	/**
	 * �������
	 * @author chengyuan 2015-6-8 ����1:49:50
	 * @param unknown $params
	 */
	public function asyncApplyModerator($params = array()){
		$modelObj = $this->model('reviews');
		$modelObj->applyModerator($params['aid']);
	}
 }
?>