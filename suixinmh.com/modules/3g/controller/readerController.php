<?php
/**
 * �Ķ�������
 * @author chengyuan  2014-8-8
 *
 */
class readerController extends chief_controller {

//	public $template_name = 'read';
// 	public $caching = false;
	public $theme_dir = false;
	//public $cacheid = 'fff';
	//public $cachetime=5;
	/**
	 * ȱʡ���Ķ��½�
	 * @param unknown $params
	 * 2014-8-8 ����3:16:23
	 */

	public function main($params = array()) {
        define('CHAPTER_READER_CACHE_TIMEOUT',3600);
		define("PLATFORM",'mobile');

		$dataObj = $this->model('readerr', '3g');
		$data = $dataObj->reader($params['aid'], $params['cid'], -11, $params['page']);

		$cookiestr = array(
			'aid'			=> $data['article']['articleid'],
			'cid'			=> $data['chapter']['chapterid'],
			'aname'			=> urlencode($data['article']['articlename']),
			'autname'		=> urlencode($data['article']['author']),
			'asort'			=> urlencode($data['article']['sort']),
			'cname'			=> urlencode($data['chapter']['title']),
			'siteid'		=> $data['article']['siteid'],
			'sortid'		=> $data['article']['sortid']
		);
		if($data['chapter']['isvip']){//print_r($data);
		    header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
			//vip template
			//û���½����ݣ�����Ҫ���ģ��
			$this->theme_dir = false;
			$this->template_name = 'readvip';
		}
		// ���������Ƿ�ΪVIP�ж��Ƿ�д��
		$user = $this->getAuth();
		if (!$data['chapter']['isvip'] || isset($user['uid'])&&(''!=$data['chapter']['content'])) {
			$this->wCookie($cookiestr);
		}
		//�����
		$dataObj = $this->model('article','article');
		$dataObj->statisticsVisit($params['aid']);
        $url = $this->geturl('3g', 'reader', 'aid='.$params['aid'],'cid='.$params['cid']);
        $_SESSION['jieqi_readurl'] = $url;
		return $this->display($data);
	}
	/**
	 * ��ƪ����vip�½�
	 * @param unknown $params
	 * 2014-8-12 ����4:40:56
	 */
	public function buychapter($params = array()){
	    header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
		$dataObj = $this->model('readerr','3g');
		//����ɹ��Ļص�URL
		$url = $this->geturl('3g', 'reader', 'aid='.$params['aid'],'cid='.$params['cid']);
		$_SESSION['jieqi_readurl'] = $url;
		$dataObj->buychapter($params['aid'],$params['cid'],$url);
	}
	public function xbuychapter($params = array()){
		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		$dataObj = $this->model('readerr','3g');
		//����ɹ��Ļص�URL
		$url = $this->geturl('3g', 'reader', 'aid='.$params['aid'],'cid='.$params['cid']);
		$_SESSION['jieqi_readurl'] = $url;
		$dataObj->xbuychapter($params['aid'],$params['cid'],$url);
	}

	public function readnext($params = array()) {
		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		$dataObj = $this->model('readerr','3g');
        $dataObj->readnext($params);
	}
}
?>