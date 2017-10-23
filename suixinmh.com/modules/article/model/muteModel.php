<?php 
/**
 * ����ҵ��ģ��
 * @author chengyuan 2015-5-18 ����2:41:57
 */

class muteModel extends Model{

	public $mute_day = array(1,3,7,15,30,0);

	/**
	 * ��ǰ��¼�û��Ķ���aid�鼮����ȫվ���Ľ���״̬
	 * <p>
	 * �ж϶���aid�����Ľ���״̬��ȫվ����
	 * <p>
	 * Ϊ��½��δ����
	 * @author chengyuan 2015-5-22 ����9:59:30
	 * @param unknown $aid	��ţ��ɿ�
	 * @return Ambigous <1�����ԣ�, 0��δ���ԣ�, number>|number
	 */
	public function getAuthMuteState($aid){
		$auth = $this->getAuth();
		if($auth['uid']){//��¼
			return $this->userState($auth['uid'],$aid);
		}else{
			return 0;
		}
	}
	/**
	 * �û�����-�����б�
	 * @author chengyuan 2015-5-21 ����4:30:07
	 * @param unknown $params
	 * @return unknown
	 */
	public function mute_view($params){
		$articleLib =  $this->load('article','article');
		$auth = $this->getAuth();
		//��Ʒ��Ϣ
		$data['articles'] = $articleLib->articleByAuthorid($auth['uid']);
		//������Ϣ-Ĭ�ϵ�һ����
		if(is_array($data['articles']) && count($data['articles']) > 0){
			if($params['articleid']){
				$data['article'] = $articleLib->isExists($params['articleid']);
			}else{
				$data['article'] = $data['articles'][0];
			}
			//$data['article']ָ���鼮�Ľ����б�
			$this->db->init ( 'mute', 'muteid', 'article' );
			$this->db->setCriteria();
			$this->db->criteria->setTables("jieqi_article_mute as am inner join jieqi_article_reviews as ar on am.topicid = ar.topicid");
			$this->db->criteria->setFields("am.*,ar.title");
			$this->db->criteria->add(new Criteria('am.articleid',$data['article']['articleid']));
			$this->db->criteria->add(new Criteria('am.state',0));
			$this->addConfig('article','configs');
			$jieqiConfigs['article'] = $this->getConfig('article','configs');
			$data['muterows'] = $this->db->lists($jieqiConfigs['article']['newreviewnum'],$params['page'],JIEQI_PAGE_TAG);
			$data['url_jumppage']=$this->db->getPage();
		}
		return $data;
	}
	/**
	 * �����֧�ֵ���������
	 * @author chengyuan 2015-5-21 ����2:43:47
	 * @param unknown $muteid id����id����
	 */
	public function unmute($muteid){
		if(!is_array($muteid)){
			$muteid = array($muteid);
		}
		if(count($muteid) > 0){
			$auth = $this->getAuth();
			$this->db->updatetable ( 'article_mute', array (
					'state' => 1,
					'unmuteuserid'=>$auth['uid'],
					'unmuteusername'=>$auth['username']
			), 'muteid IN ' . '('.implode(',',$muteid).')');
		}
		$this->jumppage('', LANG_DO_SUCCESS,LANG_DO_SUCCESS);
	}
	/**
	 * ��������-���Լ�¼
	 * @author cheangyuan 2015-5-21 ����4:30:43
	 * @param unknown $params
	 * @return unknown
	 */
	public function mute_list($params){
		//$data['article']ָ���鼮�Ľ����б�
		$this->db->init ( 'mute', 'muteid', 'article' );
		$this->db->setCriteria();
		$this->db->criteria->setTables("jieqi_article_mute as am inner join jieqi_article_reviews as ar on am.topicid = ar.topicid");
		$this->db->criteria->setFields("am.*,ar.title");
// 		$this->db->criteria->add(new Criteria('am.articleid',$data['article']['articleid']));
		$this->db->criteria->add(new Criteria('am.state',0));
		$this->addConfig('article','configs');
		$jieqiConfigs['article'] = $this->getConfig('article','configs');
		$data['muterows'] = $this->db->lists($jieqiConfigs['article']['newreviewnum'],$params['page']);
		$data['url_jumppage']=$this->db->getPage();
		return $data;
	}
	/**
	 * ָ�����û���aid�鼮����ȫվ���Ƿ񱻽���
	 * <p>
	 * 1:���з����ʱ���Ѿ�����
	 * 2:����и��Ľ���״̬Ϊ1
	 * 3:�ڻ�ȡָ���û����Ƿ񱻽��ԣ�������ȫվ��
	 * @author chengyuan 2015-5-19 ����1:22:59
	 * @param unknown $uid	�û�id
	 * @param unknown $aid	�鼮id��Ϊ�����ж��Ƿ�ȫվ����
	 * @return 1�����ԣ�|0��δ���ԣ�
	 */
	public function userState($uid,$aid){
		if(!$uid){
			$this->printfail(LANG_NEED_LOGIN);
		}
//		$muteCache = $this->load('mute', 'article');
//		//���ڸ���
//		$muteCache->setCriteria(new Criteria('state',0));
//		$muteCache->criteria->add(new Criteria('day',0,"!="));
//		$muteCache->criteria->add(new Criteria('enddate',time(),"<"));
//		if($muteCache->getCount($muteCache->criteria)){
//			//�н��Ե��ڵģ��Զ����
//			$muteCache->updatefields("jieqi_article_mute",array("state"=>1,"unmuteuserid"=>0,"unmuteusername"=>""),$muteCache->criteria);
//		}
//		//�û�����״̬
//		$muteCache->setCriteria(new Criteria('state',0));//������
//		$muteCache->criteria->add(new Criteria('userid',$uid));
//		if(isset($aid) && aid){
//			$muteCache->criteria->add(new Criteria('articleid','','in (0,'.$aid.')'));//����
//		}else{
//			$muteCache->criteria->add(new Criteria('articleid',0));//ȫվ
//		}
//
//		$result = $muteCache->getCount($muteCache->criteria)?1:0;
//		return $result;

		return 0;
	}
	/**
	 * �û�-�鼮��һ��һ���Ե�ҵ������
	 * @author chengyuan 2015-5-18 ����2:46:42
	 * @param unknown $user		�����Ե��û���Ϣ
	 * @param unknown $article	������������Ϣ
	 * @param unknown $topicid	Υ�������ID
	 * @param unknown $area		���䣬����0��ȫվ1
	 * @param number $day		����ʱ��
	 */
	public function mute($user=array(),$article=array(),$topicid,$area=0,$day){
		$day = intval($day);
		if(!$user['userid'] || !$user['username']){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		if(!$article['articleid'] || !$article['articlename']){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		if(!$topicid){//��ʹͬʱ���۱�ɾ���ˣ�������һ������������
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		//Ĭ��intval($day)0�����ý���
		if (!in_array($day,$this->mute_day, TRUE)){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		$mute = array();
		$mute['state']=0;//0��ʼ���ԣ�1���
		$mute['userid']=$user['userid'];
		$mute['username']=$user['username'];
		$mute['topicid']=$topicid;
		if($area){//ȫվ
			$mute['articleid']=0;
			$mute['articlename']="";
		}else{//����
			$mute['articleid']=$article['articleid'];
			$mute['articlename']=$article['articlename'];
		}
		$auth = $this->getAuth();
		$mute['activeuserid']=$auth['uid'];
		$mute['activeusername']=$auth['username'];
		$mute['unmuteuserid']=0;
		$mute['unmuteusername']="";
		$mute['startdate']=time();
		if($day == 0){
			$mute['enddate']=0;//���ý���
		}else{
			$mute['enddate']=strtotime("+$day days");;
		}
		$mute['day']=$day;
		$muteCache = $this->load('mute', 'article');
		if(!$muteCache->add($mute)){
			$this->printfail(LANG_DO_FAILURE);//Ψһ�������Ѿ�����
		}else{
			//����վ����֪ͨ�û�
			$this->expressNotice($user,$article['articlename'],$day,$mute['enddate']);
		}
	}

	private function expressNotice($user,$articlename,$day,$enddate){
		//����վ����֪ͨ�û�
		if($enddate == 0){
			$content = "���ڡ�{$articlename}�������������ý��ԣ���ʱ�����ڸ����������������ۣ�";
		}else{
			$content = "���ڡ�{$articlename}��������������{$day}�죬���ʱ��".date("Y-m-d H:i:s", $enddate)."�������ڼ䣬��ʱ�����ڸ����������������ۣ�";
		}
		$messageService = $this->model('message','system');
		$messageService->auditApproval($user['userid'],$user['username'],'���ѱ�����',$content);
	}
}
?>