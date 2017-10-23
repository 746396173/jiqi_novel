<?php
/**
 * 3gģ��base������
 * @author chengyuan  2014-8-6
 *
 */
class chief_controller extends Controller {
	/**
	 * Ĭ��ģ��
	 * @var unknown
	 */
//	public $template_name = 'index';
	public $caching = false;

	public function __construct() {
	    global $jieqiModules;
		parent::__construct ();
		$this->assign('SITE_WAP_URL',$jieqiModules['3g']['url']);//3g 
		$this->assign('SITE_3GWAP_URL',$jieqiModules['3gwap']['url']);//������qq��½ʹ��
		//$this->assign('APP_DOWNLOAD_URL','http://appdata.shuhai.com/shuhai_server/servlet/DownloadServlet?apptype=1&appbookid=0');
		//�ж���Դ��ַ
		if(!defined('JIEQI_NEED_SOURCE')) define('JIEQI_NEED_SOURCE',true);
		if(defined('JIEQI_NEED_SOURCE') && $_SESSION['SOURCE_SITE']=='' && $_REQUEST['qd']){
			$refer = $_REQUEST['qd'].'_'.$_REQUEST['aid'];
			if($refer){
				setcookie('SOURCE_SITE',$refer,time()+3600*72,'/');
				$_SESSION['SOURCE_SITE'] = $refer;
			}
		}
	}
	
	/**
	 * д���Ķ���¼
	 */
	public function wCookie($readInfo, $isUser = false) {
		if ($isUser) {
			$user = $this->getAuth();
			$uid = !isset($user['uid']) ? 0 : $user['uid'];
		} else {
			$uid = '';
		}
		if (empty($_COOKIE['shuhai_history_'.$uid])) {
			// ��ʼ��cookie
			$cookiestr[] = $readInfo;
			setCookie('shuhai_history_'.$uid, json_encode($cookiestr), time()+2592000, '/');
		} else {
			// �ж��Ƿ����cookie
			$this_cookie = json_decode($_COOKIE['shuhai_history_'.$uid], true);
			$have_add = true;
			$diff_sum = 0;
			foreach ($this_cookie as $k=>$v) {
				if ($readInfo['aid']==$v['aid'] && $readInfo['cid']==$v['cid']) {
					// ��ͬ���Ķ���¼����¼
					$have_add = false;
				} elseif ($readInfo['aid']==$v['aid'] && $readInfo['cid']!=$v['cid']) {
					// �Ķ��½ڲ�ͬ������Ķ���¼
					unset($this_cookie[$k]);
					$this_cookie[$k] = $readInfo;
				} else {
					// ��ȫ��ͬ������Ķ���¼
					$diff_sum++;
				}
			}
			// ������κ�һ����ͬ��¼�򲻸���
			if ($have_add) {
				// �����ǰ�Ķ��½��������Ķ���¼����ͬ��������Ķ���¼
				if (count($this_cookie)==$diff_sum) {
					// ��ʾ��໺��6���Ķ���¼
					if (count($this_cookie)>6) unset($this_cookie[0]);
					$this_cookie[] = $readInfo;
				}
				setCookie('shuhai_history_'.$uid, '', 0, '/');
				setCookie('shuhai_history_'.$uid, json_encode($this_cookie), time()+2592000, '/');
			}
		}
		return true;
	}
	
	/**
	 * ����Ķ���¼
	 */
	public function rCookie($isUser = false) {
		$reData = array();
		if ($isUse) {
			$user = $this->getAuth();
			$uid = !isset($user['uid']) ? 0 : $user['uid'];
		} else {
			$uid = '';
		}
		if (empty($_COOKIE['shuhai_history_'.$uid])) {
			$reData = '';
		} else {
			$temp = json_decode($_COOKIE['shuhai_history_'.$uid], true);
			$temp = array_reverse($temp);
			foreach ($temp as $k=>$v) {
				$reData[$k]['aid'] = $v['aid'];
				$reData[$k]['cid'] = $v['cid'];
				$reData[$k]['aname'] = urldecode($v['aname']);
				$reData[$k]['autname'] = urldecode($v['autname']);
				$reData[$k]['asort'] = urldecode($v['asort']);
				$reData[$k]['cname'] = urldecode($v['cname']);
			}
		}
		return $reData;
	}
}
?>