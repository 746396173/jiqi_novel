<?php
include_once ($GLOBALS['jieqiModules']['task']['path'] . '/class/TaskBase.php');

/**
 * �������ѷ���ģ�飺�̳���TaskBase������
 * @author liuxiangbin
 * @version 0.1
 */
 class MyConsumetask extends TaskBase {
 	
	// ʵ�ֵ�ǰ�Զ�����Ĺ�������
	protected $_rules = array(
		// keyΪ�����Ӧ�����ƣ�valueΪĬ��ֵ
//		'groupid'			=> '0'
	);
	
	// ʵ�ֵ�ǰ�Զ�����Ľ�����������
	protected $_rewards = array(
		// ��ʽ�����Զ��壬ֻҪ�Լ��ܿ���
//		'percentage'	=> 0.05
		array('reward'=>'egold', 'name'=>'�麣��', 'percentage'=>0.05),
		array('reward'=>'esilver', 'name'=>'��ȯ', 'percentage'=>0.1)
	);
	
	/**
	 * ������ɱ��
	 */
	protected function finishGroup($params) {
		return date("Ym", JIEQI_NOW_TIME);
	}
 	
	/**
	 * ���ӽ���
	 */
 	protected function addReward($params) {//print_r($params);
   		$uid = $this->_userCheck();
   		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', $params['tid']));
		$this->db->criteria->setFields('rewards');
		$tmp = $this->db->lists();
		$thisRewards = json_decode($tmp[0]['rewards'], true);//print_r($thisRewards);//exit;
		$this->_params['type'] = $thisRewards[0]['reward'];
		$consumeegold = $this->haveAchevable($uid, $params['tid']);
		$this->_params['consumeegold'] = $consumeegold;
		$addesilver = round($consumeegold*$thisRewards[0]['percentage'],2);
		$this->_params['addesilver'] = $addesilver;
		
 		$this->db->init('users', 'uid', 'system');
		$this->db->setCriteria(new Criteria('uid', $uid, '='));
		$res_uadd = $this->db->lists();
		// ѭ�����齱������
		$user_adds = array();
//		foreach ($thisRewards as $k => $v) {
			$user_adds[$this->_params['type']] = $res_uadd[0][$this->_params['type']] + $addesilver;
//		}
		$this->db->edit($uid, $user_adds);
 	}
	
	/**
	 * �����ɹ���վ����
	 */
 	protected function addRewardAfter($params) {//$this->dump($params);
		$this->addLang('task','msg');
		$this->jieqiLang['task'] =  $this->getLang('task'); 
		$auth = $this->getAuth();	
		if($this->_params['type']=='esilver'){
			$type = '��ȯ';
		}else{
			$type = '�麣��';
		}
			
		$this->db->init('message','messageid','system');
		$newMessage = array();
		$newMessage['siteid']= JIEQI_SITE_ID;
		$newMessage['postdate']= JIEQI_NOW_TIME;
		$newMessage['fromid']= 6;
		$newMessage['fromname']= 'ϵͳ����Ա';
		$newMessage['toid']= $auth['uid'];
		$newMessage['toname']= $auth['useruname'];
		$newMessage['title']= $this->jieqiLang['task']['premonth_xf_title'];
		$newMessage['content']= sprintf($this->jieqiLang['task']['premonth_xf_text'],$this->_params['consumeegold'],$this->_params['addesilver']);
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
	 * ʵ�ַ������û��Ƿ��������񣬼������Ƿ񶩹��½ڻ����
	 */
	protected function haveAchevable($uid, $tid) {
//		$this->db->init('task', 'taskid', 'task');
//		$this->db->setCriteria(new Criteria('taskid', $tid));
//		$this->db->criteria->setFields('rule');
//		$tmpRule = $this->db->lists();
//		$rules = json_decode($tmpRule[0]['rule'], true);
		
		$monthstart=$this->getTime('month');
		$premonth = $this->getTime('premonth');
		
		$saleegold = $rewardegold = 0;
		
		//��ѯ��ǰ�û������ܽ��
		$this->db->init( 'sale', 'saleid', 'article' );
		$this->db->setCriteria(new Criteria('accountid', $uid));
		$this->db->criteria->add(new Criteria( 'buytime', $premonth, '>=' ));
		$this->db->criteria->add(new Criteria( 'buytime', $monthstart, '<' ));
		$this->db->criteria->add(new Criteria( 'pricetype', 0 ));//����������ȯ����
		$saleegold = $this->db->getSum('saleprice');
		
		//��ѯ��ǰ�û������ܽ��
		$this->db->init( 'statlog', 'statlogid', 'article' );
		$this->db->setCriteria(new Criteria('uid', $uid));
		$this->db->criteria->add(new Criteria( 'mid', 'reward'));				
		$this->db->criteria->add(new Criteria( 'addtime', $premonth, '>=' ));
		$this->db->criteria->add(new Criteria( 'addtime', $monthstart, '<' ));
		$this->db->criteria->setFields("uid,username,sum(stat) as sum");
		$rewardegold = $this->db->getSum('stat');
		
		$totalegold = bcadd($saleegold, $rewardegold, 2);
		if($totalegold>0) return $totalegold;
		else return false;
	}
	
	/**
	 * �ж��Ƿ�����ɣ������ɼ�¼�Ĵ���ʱ�䣬�жϱ����Ƿ�������������ѷ���
	 */
	protected function haveFinished($uid, $tid) {
		$monthstart=$this->getTime('month');//echo $monthstart.' ';
		//���³�
		$nextmonth = explode('-',date('Y-m-d',strtotime("+1 month")));
		$nextmonthstart = mktime(0,0,0,(int)$nextmonth[1],1,(int)$nextmonth[0]);

		$thismonth = date('Ym', JIEQI_NOW_TIME);
		
		$this->db->init('complete', 'tcid', 'task');
		$this->db->setCriteria(new Criteria('userid', $uid));
		$this->db->criteria->add(new Criteria('taskid', $tid));
//		$this->db->criteria->add(new Criteria('finish', '%'.$thismonth.'%', 'LIKE'));
		
		$this->db->criteria->add(new Criteria('createtime', $monthstart, '>='));
		$this->db->criteria->add(new Criteria('createtime', $nextmonthstart, '<'));//�����м�¼��������ȡ�������ѷ���
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
//		$htmls = '';
//		$htmls .= '<tr class="sign_option"><td class="td_title">������֤��</td><td class="td_contents"><select name="rule[groupid]">';
//		foreach ($groups as $k => $v) {
//			$htmls .= '<option value="'.$k.'">'.$v.'</option>';
//		}
//		$htmls .= '</select></td><td class="td_span"><span>*�����������û���</span></td></tr>';
//		return $htmls;
	}
	/*
	 * ��ɼ�¼�ı�ע�ֶ�
	 */
	protected function recordsGroup($params){
		$this->getReward($params);
		if($this->_params['type']=='esilver') $type = '��ȯ';
		else $type = '�麣��';
		$msg = date('Y��m��',$this->getTime('premonth')).'�ۼ�����'.$this->_params['consumeegold'].'�麣�ң�����'.$this->_params['addesilver'].$type.'��';
		return $msg;
	}
	/*
	 * ��ȡ��ϸ������Ϣ�����ڱ�ע
	 */
	private function getReward($params){
 		$uid = $this->_userCheck();
 		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('taskid', $params['tid']));
		$this->db->criteria->setFields('rewards');
		$tmp = $this->db->lists();
		$thisRewards = json_decode($tmp[0]['rewards'], true);//print_r($thisRewards);//exit;
		$this->_params['type'] = $thisRewards[0]['reward'];
		$consumeegold = $this->haveAchevable($uid, $params['tid']);//echo $params['tid'];exit;
		$this->_params['consumeegold'] = $consumeegold;
		$addesilver = round($consumeegold*$thisRewards[0]['percentage'],2);
		$this->_params['addesilver'] = $addesilver;
	}
}
?>
 
 
 
 
 
 
 
 
 