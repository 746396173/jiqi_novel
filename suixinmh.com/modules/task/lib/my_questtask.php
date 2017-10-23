<?php
include_once ($GLOBALS['jieqiModules']['task']['path'] . '/class/TaskBase.php');

/**
 * �ͻ��˵�½ģ�飺�̳���TaskBase������
 * @author zhangxue
 * @version 0.1
 */
 class MyQuesttask extends TaskBase {
 	
	// ʵ�ֵ�ǰ�Զ�����Ĺ�������
	protected $_rules = array(
		// keyΪ�����Ӧ�����ƣ�valueΪĬ��ֵ
//		'field'	=> array(
//			'isvip' => 'VIP�ȼ�',
//			'score' => '�ƺŵȼ�'
//		)
	);
	
	// ʵ�ֵ�ǰ�Զ�����Ľ�����������
	protected $_rewards = array(
	);
	
	/**
	 * ������ɱ��
	 */
	protected function finishGroup($params) {
		return 'finished';
	}
 	
	/**
	 * ���ӽ���
	 * $params tid
	 */
 	protected function addReward($params) {
 		$uid = $params['uid'];
 		$this->db->init('users', 'uid', 'system');
		$this->db->setCriteria(new Criteria('uid', $uid));
		$res_uadd = $this->db->lists();
		// ѭ�����齱������
		$user_adds = array();
		$user_adds['egold'] = $res_uadd[0]['egold'] + 200;
		$this->db->edit($uid, $user_adds);
 	}
	
	/**
	 * �����ɹ���վ����
	 * $params tid
	 */
 	protected function addRewardAfter($params) {
		$users_handler = $this->getUserObject();
		$jieqiUsers = $users_handler->get($params['uid']);//print_r($jieqiUsers);exit;
		$uid = $jieqiUsers->getVar('uid');
		$uname = $jieqiUsers->getVar('uname', 'n');
			
		$this->db->init('message','messageid','system');
		$newMessage = array();
		$newMessage['siteid']= JIEQI_SITE_ID;
		$newMessage['postdate']= JIEQI_NOW_TIME;
		$newMessage['fromid']= 6;
		$newMessage['fromname']= 'ϵͳ����Ա';
		$newMessage['toid']= $uid;
		$newMessage['toname']= $uname;
		$newMessage['title']= '��¼�麣�ֻ��ͻ�������';
		$newMessage['content']= '�麣ӭ���������죬�ֻ��ͻ��������������ڻ�ڼ��¼�麣�ֻ��ͻ��ˣ�����200�麣�ң���ע����ա�';
		$newMessage['messagetype']= 0;
		$newMessage['isread']= 0;
		$newMessage['fromdel']= 0;
		$newMessage['todel']= 0;
		$newMessage['enablebbcode']= 1;
		$newMessage['enablehtml']= 0;
		$newMessage['enablesmilies']= 1;
		$newMessage['attachsig']=0;
		$newMessage['attachment']= 0;
		$this->db->add($newMessage);	
 	}
	
	/**
	 * ʵ�ַ������û��Ƿ���������
	 */
	protected function haveAchevable($uid, $tid) {
		return false;
	}
	
	/**
	 * �ж��Ƿ�����ɣ��ж��Ƿ������
	 */
	protected function haveFinished($uid, $tid) {
		$this->db->init('complete', 'tcid', 'task');
		$this->db->setCriteria(new Criteria('userid', $uid));
		$this->db->criteria->add(new Criteria('taskid', $tid));
		$this->db->criteria->add(new Criteria('createtime', $this->getTime(), '>='));
		$finish = $this->db->lists();//print_r($finish);
		if (!empty($finish)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * ���html��ʽ�Ĺ���(��д����)
	 */
	public function getRuleHtml() {
		$htmls = '';
//		$htmls .= '<tr class="sign_option"><th class="td_title">������֤��</th>';
//		$htmls .= '<td class="td_contents">sale+reward</td>';
//		$htmls .= '<td class="td_span"><span>*�����������û���</span></td></tr>';
		return $htmls;	
	}
	
	/**
	 * ���html��ʽ�Ľ���(��д����)
	 */
	public function getRewardsHtml($params) {
		$htmls = '';
//		$htmls .= '<tr class="sign_option"><th class="td_title">��������</th><td class="td_contents">';
//		$htmls .= '<input class="text" type="text" name="rewards[percentage]" value="'.$params['percentage'].'" />';
//		$htmls .= '</td><td class="td_span"><span>*��������ʾ</span></td></tr>';
		foreach ($params as $key => $val) {
			$htmls .= '<tr class="sign_option"><th class="td_title">������</th><td class="td_contents"><select name="rewards['.$key.'][reward]">';
			foreach ($this->_rewards as $k => $v) {
				if ($val['reward'] == $v['reward']) {
					$htmls .= '<option value="'.$v['reward'].'" selected="selected" >'.$v['name'].'</option>';
				} else {
					$htmls .= '<option value="'.$v['reward'].'">'.$v['name'].'</option>';
				}
			}
			$htmls .= '</select>&nbsp;&nbsp;<input class="text" type="text" name="rewards['.$key.'][percentage]" placeholder="���磺5000" value="'.$params[$key]['percentage'].'" />';
			$htmls .= '</td><td class="td_span"><span>*��д������ʽ</span></td></tr>';
		}
		return $htmls;
	}
	
	/**
	 * ���html��ʽ�Ľ���(��д����)
	 */
	public function setRewardsHtml() {
		$htmls = '';
		$htmls .= '<tr class="sign_option"><th class="td_title">������</th><td class="td_contents"><select name="rewards[0][reward]">';
		foreach ($this->_rewards as $k => $v) {
			$htmls .= '<option value="'.$v['reward'].'">'.$v['name'].'</option>';
		}
		$htmls .= '</select>&nbsp;&nbsp;<input class="text" type="text" name="rewards[0][percentage]" value="'.$this->_rewards[0]['percentage'].'" />';
		$htmls .= '</td><td class="td_span"><span>*��д������ʽ</span></td></tr>';
		return $htmls;
	}
	
	/**
	 * ���html��ʽ�Ĺ���(��д����)
	 */
	public function setRuleHtml() {
//		$this->addConfig('system', 'groups');
//		$groups = $this->getConfig('system', 'groups');
		$htmls = '';
//		$htmls .= '<tr class="sign_option"><td class="td_title">������֤��</td><td class="td_contents"><select name="rule[groupid]">';
//		foreach ($groups as $k => $v) {
//			$htmls .= '<option value="'.$k.'">'.$v.'</option>';
//		}
//		$htmls .= '</select></td><td class="td_span"><span>*�����������û���</span></td></tr>';
		return $htmls;
	}
	/*
	 * ��ɼ�¼�ı�ע�ֶ�
	 * $params tid
	 */
	protected function recordsGroup($params){
		$this->getReward($params);//��ȡ��������
		$msg = '����������齱�������'.$this->_params['value'];
		if($this->_params['type']=='esilver'){
			$msg .= '��ȯ��';
		}else{
			$msg .= '�麣�ҡ�';
		}
		return $msg;
	}
	/*
	 * ��ȡ��ϸ������Ϣ�����ڱ�ע
	 */
	private function getReward($params){
		$items = array(
				array('prob' => 700,'msg'=>'���Ƚ�', 'type'=>'esilver', 'value'=>50, 'data'=>'6'),
				array('prob' => 850,'msg'=>'��Ƚ�', 'type'=>'esilver', 'value'=>200, 'data'=>'5'),
				array('prob' => 909,'msg'=>'�ĵȽ�', 'type'=>'esilver', 'value'=>500, 'data'=>'4'),
				array('prob' => 989,'msg'=>'���Ƚ�', 'type'=>'egold', 'value'=>88, 'data'=>'3'),
				array('prob' => 999,'msg'=>'���Ƚ�', 'type'=>'egold', 'value'=>188, 'data'=>'2'),
				array('prob' => 1000,'msg'=>'һ�Ƚ�', 'type'=>'egold', 'value'=>588, 'data'=>'1')
		);
		$index = $this->getItems($items);
		$this->_params = $items[$index];//echo $value['msg'];
//		return $value;
	}
	private function getItems($items){
		mt_srand((double)microtime()*1000000);
		$randval = mt_rand(1,1000);
		foreach($items as $k => $v){
			$prob = $v['prob'];
			if($randval<=$prob){
				return $k;
			}
		}
	}
	function judge($params = array()){
		if(JIEQI_NOW_TIME<1423929600){
			$this->printfail('�δ��ʼ�����������ʱ�䣡');
		}elseif(JIEQI_NOW_TIME>=1425571200){
			$this->printfail('��ѽ������´���ץ��Ŷ��');
		}else{
			$auth = $this->getAuth();
			$this->db->init('task', 'taskid', 'task');
			$this->db->setCriteria(new Criteria('type', 'quest'));
			$task = $this->db->get($this->db->criteria);
			$tid = $task->getVar('taskid');
			
			if($this->haveFinished($auth['uid'], $tid)){
				$this->printfail('�����Ѿ�������ˣ�����������');
			}else{
				$thisAddTask = array(
					'userid' 		=> $auth['uid'],
					'taskid'			=> $tid,
					'finish'			=> $this->finishGroup($params),
					'createtime'		=> JIEQI_NOW_TIME,
					'records'		=> $this->recordsGroup($params)
				);
				$this->db->init('complete', 'tcid', 'task');
				$this->db->add($thisAddTask);
				
				$value = $this->_params;//echo $value['msg'];
				$users_handler =  $this->getUserObject();
				if($value['type']=='egold'){
					$ret = $users_handler->income($auth['uid'],$value['value']);
//					$type = '�麣��';
				}else{
					$ret = $users_handler->income($auth['uid'],$value['value'],1);
//					$type = '��ȯ';
				}
				$this->msgbox("", $value['data']);
	//			exit( json_encode(array('status'=>true,'msg'=>$value['data'])));
	//			if($ret){
	//				$this->db->init('message','messageid','system');
	//				$newMessage = array();
	//				$newMessage['siteid']= JIEQI_SITE_ID;
	//				$newMessage['postdate']= JIEQI_NOW_TIME;
	//				$newMessage['fromid']= 6;
	//				$newMessage['fromname']= 'ϵͳ����Ա';
	//				$newMessage['toid']= $auth['uid'];
	//				$newMessage['toname']= $auth['username'];
	//				$newMessage['title']= '��¼�麣�ֻ��ͻ�������';
	//				$newMessage['content']= '�麣ӭ���������죬�ֻ��ͻ���������������'.date('Y��m��d��',JIEQI_NOW_TIME).'�������齱������'.$value['msg'].'������'.$value['value'].$type.'����ע����ա�';
	//				$newMessage['messagetype']= 0;
	//				$newMessage['isread']= 0;
	//				$newMessage['fromdel']= 0;
	//				$newMessage['todel']= 0;
	//				$newMessage['enablebbcode']= 1;
	//				$newMessage['enablehtml']= 0;
	//				$newMessage['enablesmilies']= 1;
	//				$newMessage['attachsig']=0;
	//				$newMessage['attachment']= 0;
	//				$this->db->add($newMessage);	
	//			}
			}
		}

	}
}
?>
 
 
 
 
 
 
 
 
 