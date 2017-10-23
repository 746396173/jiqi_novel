<?php
/**
 * articleģ��base������
 * @copyright   Copyright(c) 2014
 * @author      chengyuan *
 * @version     1.0
 */
class chief_controller extends Controller {
	//Ĭ��ģ��
	public $caching = false;
	/**
	 * article�����������yһ̎���ꑺ��_����ȵę�����C
	 * <table border=1 >
	 * <tr><td rowspan=2>����</td><td rowspan=2>˵��</td><td colspan=2>Ȩ�����</td></tr>
	 * <tr><td>��½</td><td>�������</td></tr>
	 * <tr><td>appwV</td><td>����������ͼ</td><td>��</td><td>X</td></tr>
	 * <tr><td>appw</td><td>���������ύ</td><td>��</td><td>X</td></tr>
	 * <tr><td>synchronousMakePack</td><td>��������opf�Ⱦ�̬�ļ�</td><td>X</td><td>X</td></tr>
	 * <tr><td>regularAudits</td><td>��ʱ���</td><td>X</td><td>X</td></tr>
	 * <tr><td>bcView</td><td>�����ͼ</td><td>��</td><td>X</td></tr>
	 * <tr><td>bcBatch</td><td>��ܲ���</td><td>��</td><td>X</td></tr>
	 * <tr><td>Others</td><td>��������</td><td>��</td><td>��</td></tr>
	 * </table>
	 */
	public function __construct() {
	    header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		parent::__construct ();
		//����½
		if($this->getRequest('method') != 'synchronousMakePack' && $this->getRequest('method') != 'regularAudits'){
			$this->checklogin();
		}
		//������¹���Ȩ�ޣ�ֱ����ʾ
		$this->addConfig('article','power');
		//�������߲�����authorpanelȨ���ж�
		if($this->getRequest('method') != 'appwV' &&  $this->getRequest('method') != 'bcView' &&  $this->getRequest('method') != 'bcBatch' &&  $this->getRequest('method') != 'appw' && $this->getRequest('method') != 'synchronousMakePack' && $this->getRequest('method') != 'regularAudits'){
			if(!$this->checkpower ($this->getConfig('article','power','authorpanel'), $this->getUsersStatus (), $this->getUsersGroup (), true )){
			     header('location:'.$this->geturl('article','article','SYS=method=appwV'));
			}
		}
		$iswriter = $this->checkpower ($this->getConfig('article','power','newarticle'), $this->getUsersStatus (), $this->getUsersGroup (), true);
		$delown = $this->checkpower ($this->getConfig('article','power','delmyarticle'), $this->getUsersStatus (), $this->getUsersGroup (), true);
		$delall = $this->checkpower ($this->getConfig('article','power','delallarticle'), $this->getUsersStatus (), $this->getUsersGroup (), true);
		$mangall=$this->checkpower($this->getConfig('article','power','manageallarticle'), $this->getUsersStatus (), $this->getUsersGroup (), true);
// 		if($iswriter){
// 			//������û�д�������
// 			$article =  $this->model('article','article');
// 			$this->assign('hasCreate', $article->createArticle());
// 		}
		$this->assign('iswriter',$iswriter);
		$this->assign('delown',$delown);
		$this->assign('delall',$delall);
		$this->assign('mangall',$mangall);
	}
}
?>