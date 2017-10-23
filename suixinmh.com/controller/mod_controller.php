<?php
/**
 * base������
 * @copyright   Copyright(c) 2014
 * @author      chengyuan *
 * @version     1.0
 */
class chief_controller extends Controller {
	//Ĭ��ģ��
	public $template_name = 'main';
	public $caching = false;
	/**
	 * article�����������yһ̎���ꑺ��_����ȵę�����C
	 */
	public function __construct() {
	    header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		parent::__construct ();
		if(!in_array($this->getRequest('method'), array('userinfo','popuser','usermember','uservip','zuozhe','logout'))){
			//print_r($this->getRequest('method'));exit;
			//����½
			$this->checklogin();
		}
		//��鷢�������Ȩ��
		$this->addConfig('article','power');
		$iswriter = $this->checkpower ($this->getConfig('article','power','newarticle'), $this->getUsersStatus (), $this->getUsersGroup (), true);
		if($iswriter){
			//������û�д�������
			$article =  $this->model('article','article');
			$this->assign('hasCreate', $article->createArticle());
		}
		$this->assign('iswriter',$iswriter);
	}
}
?>