<?php 
/** 
 * �û�����ģ�� * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */ 
class userinfoModel extends Model{
	
	/**
	 * �û���Ϣ
	 * @return multitype:string NULL number unknown Ambigous <string, mixed>
	 */
	function main($params = array()){
		global $jieqiPower, $jieqiLang, $jieqiConfigs, $jieqiModules, $jieqiRight,$jieqiHonors;
		$this->addConfig('system','vipgrade');
		$jieqiVipgrade = $this->getconfig('system', 'vipgrade');
		header('Content-Type:text/html;charset=gbk');
		$users_handler = $this->getUserObject();
		if (!$jieqiUsers = $users_handler->get($params['uid'])){
			$this->printfail(LANG_NO_USER);
		};
		if ($jieqiUsers->getVar('lastlogin')==$jieqiUsers->getVar('regdate')){
			header('location:/');exit;$this->printfail(LANG_NO_USER);
		};
		if(in_array($jieqiUsers->getVar('groupid'),array(6,7))){
		     if(!preg_match('/zuozhe/',JIEQI_CURRENT_URL)){
                              Header("HTTP/1.1 301 MovedPermanently");
			      header('location:'.str_replace('user','zuozhe',JIEQI_CURRENT_URL));
 			 }
		}
		jieqi_getconfigs('system', 'honors');
		$data = array();
		$data['uid'] = $jieqiUsers->getVar('uid');
		$data['uname'] = $jieqiUsers->getVar('uname');
		$data['name'] = $jieqiUsers->getVar('name');
		$data['group'] = $jieqiUsers->getGroup();
		$data['sex'] = $jieqiUsers->getSex();
		$data['email'] = $jieqiUsers->getVar('email');
		$data['qq'] = $jieqiUsers->getVar('qq');
		$data['icq'] = $jieqiUsers->getVar('icq');
		$data['msn'] = $jieqiUsers->getVar('msn');
		$data['url'] = $jieqiUsers->getVar('url');
		$data['regdate'] = date(JIEQI_DATE_FORMAT, $jieqiUsers->getVar('regdate'));
		$data['experience'] = $jieqiUsers->getVar('experience');
		$data['score'] = $jieqiUsers->getVar('score');
		$data['monthscore'] = $jieqiUsers->getVar('monthscore');
		$data['weekscore'] = $jieqiUsers->getVar('weekscore');
		$data['dayscore'] = $jieqiUsers->getVar('dayscore');
		$data['credit'] = $jieqiUsers->getVar('credit');
		$data['isvip'] = $jieqiUsers->getVar('isvip');
		$data['vipgradeid'] = jieqi_gethonorid($data['isvip'], $jieqiVipgrade);
		$data['vipphoto'] = $jieqiVipgrade[$data['vipgradeid']]['photo'];
		$data['vipgrade'] = $jieqiVipgrade[$data['vipgradeid']]['caption'];
		$data['honorid'] = jieqi_gethonorid($data['score'], $jieqiHonors);
		$data['honorphoto'] = $jieqiHonors[$data['honorid']]['photo'];
		$data['viptype'] = $jieqiUsers->getViptype();
		$data['egoldname'] = JIEQI_EGOLD_NAME;
		$honorid=jieqi_gethonorid($jieqiUsers->getVar('score'), $jieqiHonors);
		$data['honor'] = $jieqiHonors[$honorid]['name'][intval($jieqiUsers->getVar('workid','n'))];
		
		$egold=$jieqiUsers->getVar('egold');
		$esilver=$jieqiUsers->getVar('esilver');
		$emoney=$egold+$esilver;
		$data['egold'] = $egold;
		$data['esilver'] = $esilver;
		$data['emoney'] = $emoney;
		
		$data['sign'] = $jieqiUsers->getVar('sign');
		$data['intro'] = $jieqiUsers->getVar('intro');
		$data['lastlogin'] = $jieqiUsers->getVar('lastlogin')?date(JIEQI_DATE_FORMAT, $jieqiUsers->getVar('lastlogin')):date(JIEQI_DATE_FORMAT, $jieqiUsers->getVar('regdate'));
		//ͷ��
		$avatar=$jieqiUsers->getVar('avatar');
		$data['avatar'] = $avatar;
		
		$this->db->init('bookcase','caseid','article');
		$this->db->setCriteria();
		$this->db->criteria->setTables($this->dbprefix('article_bookcase')." AS b RIGHT JOIN ".$this->dbprefix('article_article')." AS a ON b.articleid=a.articleid ");
		$this->db->criteria->add(new Criteria('b.userid',$params['uid'], '='));
		$this->db->criteria->add(new Criteria('a.display',0));
		$data['goodnum'] = $this->db->getCount();	//�ղ�
		
		$this->db->init('statlog','statlogid','article');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('uid',$params['uid'], '='));
		$this->db->criteria->add(new Criteria('mid','vote', '='));
		$this->db->criteria->add ( new Criteria ( 'a.display', 0));
		$this->db->criteria->setTables($this->dbprefix('article_statlog')." AS s RIGHT JOIN ".$this->dbprefix('article_article')." AS a ON s.articleid=a.articleid ");
		$this->db->criteria->setFields('a.*');
		$this->db->criteria->setGroupby('a.articleid');
		$this->db->criteria->setLimit(7);
		$this->db->criteria->setSort('statlogid');
		$this->db->criteria->setOrder('DESC');
		
		$this->db->queryObjects($this->db->criteria);
		$package = $this->load('article','article');//�������´�����
		$k=0;
		while($v = $this->db->getObject()){
		  $data['articlerows'][$k] = $package->article_vars($v);
		  $k++;
		}
		unset($this->db->criteria);
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('uid',$params['uid'], '='));
		$this->db->criteria->add(new Criteria('mid','vote', '='));
		$this->db->criteria->setFields('sum(stat) as sum');
		$this->db->queryObjects();
		$v = $this->db->getObject();
		$data['votenum'] = $v->getVar('sum')?$v->getVar('sum'):0;	//�Ƽ�Ʊ
		unset($this->db->criteria);
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('uid',$params['uid'], '='));
		$this->db->criteria->add(new Criteria('mid','reward', '='));
		$data['rewardnum'] = $this->db->getCount();	//����
		unset($this->db->criteria);
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('uid',$params['uid'], '='));
		$this->db->criteria->add(new Criteria('mid','vipvote', '='));
		$this->db->criteria->setFields('sum(stat) as sum');
		$this->db->queryObjects();
		$v = $this->db->getObject();
		$data['vipnum'] = $v->getVar('sum')?$v->getVar('sum'):0;	//��Ʊ
		
		$this->db->init('article','articleid','article');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('authorid',$params['uid'], '='));
		$this->db->criteria->add(new Criteria('display',0));
		$data['worknum'] = $this->db->getCount();	//��Ʒ
		
		 $jieqiConfigs['article']['pagenum'] = 4;
		 $this->db->criteria->setSort('lastupdate');	//������ʱ������
		 $this->db->criteria->setOrder('DESC');
		 if (empty($params['page']))
		 {
		 	$params['page'] = 1;
		 }
		 $p='[prepage]<a rel="nofollow" href="javascript:;" onclick="return showProducts(this,\'{$prepage}\',1)" id="'.$params['page'].'">��һҳ</a>[/prepage][pages][pnum]6[/pnum][pnumchar] <em class="b">{$page}</em>[/pnumchar]
[pnumurl]<A href="javascript:;" onclick="return showProducts(this,\'{$pnumurl}\',1)" id="'.$params['page'].'">{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]<a href="javascript:;" onclick="return showProducts(this,\'{$nextpage}\',1)" id="'.$params['page'].'">��һҳ</a>[/nextpage]';
		$data['writerows'] = $this->db->lists($jieqiConfigs['article']['pagenum'], $params['page'],$p);
		
		 $k=0;
		 foreach($data['writerows'] as $k=>$v)
		 {
		 	$data['writerows'][$k] = $package->article_vars($v);
			  $k++;
		 }
		 
		 $pageurl = $this->db->getPage($this->getUrl('article','article','method=userlist','evalpage=0','SYS=uid='.$params['uid']));

		 while($v = $this->db->getObject()){
		      $data['writerows'][$k] = $package->article_vars($v);
			  $k++;
		 }
		 $data['url_jumppage'] = $pageurl;
		$this->db->init('friends','friendsid','system');
		$this->db->setCriteria(new Criteria('yourid', $params['uid']));
		$data['friendnum'] = $this->db->getCount();	//��˿
		$this->db->init ( 'replies', 'postid', 'article' );
		$this->db->setCriteria();
		$sqlStr = $this->dbprefix('article_replies')." AS r LEFT JOIN ".$this->dbprefix('article_reviews')." AS ar ON  r.topicid = ar.topicid"." LEFT JOIN ".$this->dbprefix('article_article')." AS a ON  r.ownerid = a.articleid";
		$this->db->criteria->setTables($sqlStr);
		$this->db->criteria->add(new Criteria('r.istopic',1, '='));
		$this->db->criteria->add(new Criteria('ar.posterid',$params['uid'],'='));
		$data['reviewnum'] = $this->db->getCount();	//����
		$data['aflag'] = $params['aflag'];
		return $data;
	}
	function popuser($params = array()){
		$data = array();
		$this->addConfig('system','vipgrade');
		$jieqiVipgrade = $this->getconfig('system', 'vipgrade');
		$this->db->init('friends','friendsid','system');
		$this->db->setCriteria(new Criteria('myid', $params['uid']));
		$data['friendnum'] = $this->db->getCount();	//��ע
		
		$this->db->init('article','articleid','article');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('authorid',$params['uid'], '='));
		$this->db->criteria->add(new Criteria('display',0));
		$data['worknum'] = $this->db->getCount();	//��Ʒ
	
		$this->db->init ( 'replies', 'postid', 'article' );
		$this->db->setCriteria();
		$sqlStr = $this->dbprefix('article_replies')." AS r LEFT JOIN ".$this->dbprefix('article_reviews')." AS ar ON  r.topicid = ar.topicid"." LEFT JOIN ".$this->dbprefix('article_article')." AS a ON  r.ownerid = a.articleid";
		$this->db->criteria->setTables($sqlStr);
		$this->db->criteria->add(new Criteria('r.istopic',1, '='));
		$this->db->criteria->add(new Criteria('ar.posterid',$params['uid'],'='));
		$data['reviewnum'] = $this->db->getCount();	//����
	
		$users_handler = $this->getUserObject();
		$jieqiUsers = $users_handler->get($params['uid']);
		$data['uid'] = $jieqiUsers->getVar('uid');
		$data['uname'] = $jieqiUsers->getVar('uname');
		$data['name'] = $jieqiUsers->getVar('name');
		$data['sign'] = $jieqiUsers->getVar('sign');
		$data['intro'] = $jieqiUsers->getVar('intro');
		$data['isvip'] = $jieqiUsers->getVar('isvip');
		$data['vipgradeid'] = jieqi_gethonorid($data['isvip'], $jieqiVipgrade);
		$data['vipphoto'] = $jieqiVipgrade[$data['vipgradeid']]['photo'];
		$data['vipgrade'] = $jieqiVipgrade[$data['vipgradeid']]['caption'];
		$data['avatar'] = $jieqiUsers->getVar('avatar');
		$groupid = $jieqiUsers->getVar('groupid');
		$this->db->init ( 'groups', 'groupid', 'system' );
		$dataDb = $this->db->get($groupid);
		$data['group'] = $dataDb['name'];
		$auth = $this->getAuth();
		if ($auth['uid']){
			$this->db->init('friends','friendsid','system');
			$this->db->setCriteria(new Criteria('yourid', $params['uid'],'='));
			$this->db->criteria->add(new Criteria('myid', $auth['uid'],'='));
			$data['type'] = $this->db->getCount();	//0��1���Ƿ��ѹ�ע
		}else{
			$data['type'] = -2;	//û��½
		}
		if($auth['uid']==$params['uid']) $data['type'] = -1;	//�Ǳ���
		return $data;
	}
	
	//ǩ����ͼ��ǩ������ʾ
	public function showSignView(){
		$auth = $this->getAuth();//print_r($auth);
		$this_month_year = date('Ym', JIEQI_NOW_TIME);
		$this->db->init('signin', 'sid', 'task');
		$this->db->setCriteria(new Criteria('uid', $auth['uid']));
		$this->db->criteria->add(new Criteria('month', $this_month_year, '='));
		if($signinfo = $this->db->get($this->db->criteria)){
			$dates = $signinfo->getVar('days');
			$data['totalsign'] = count(array_filter(explode(',', $dates)));
			$data['dates'] = $dates;	
		}
		return $data;
	}

	//�Ƿ���ǩ�����û�����Ҫ��ʾ
	public function isSign(){
		$auth = $this->getAuth();
		$this_month = date('Ym', time());
		$this_day = date('d', time());
		$this->db->init('signin', 'sid', 'task');
		$this->db->setCriteria(new Criteria('uid', $auth['uid'], '='));
		$this->db->criteria->add(new Criteria('month', $this_month, '='));
		$res = $this->db->lists();
		$user_sign_arr = array_filter(explode(',', $res[0]['days']));
		if (empty($res) || (date('Ymd', JIEQI_NOW_TIME)!=date('Ymd', $res[0]['lasttime']))) {
			return 0;
		} else {
			if (!in_array($this_day, $user_sign_arr)) {
				return 0;
			} else {
				return 1;
			}
		}
	}
	
	/**
	 * ǩ������
	 */
	public function signin() {
		// ��ȡ��ǰ����
		$auth = $this->getAuth();
		$this_month = date('Ym', JIEQI_NOW_TIME);
		$pre_month = date('Ym', $this->getTime('premonth'));
		$this_day = date('d', JIEQI_NOW_TIME);
		// ��ѯ���¼�¼�����û����ֱ�Ӵ����¼�¼��
		$this->db->init('signin', 'sid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('uid', $auth['uid'], '='));
		$this->db->criteria->add(new Criteria('month', $this_month, '='));
		$res = $this->db->lists();
		// 1��д��ǩ����¼
		if (empty($res)) {
			// �ޱ���ǩ����¼��ֱ�Ӳ���һ��ǩ����¼
			$add_data = array(
				'uid'			=> $auth['uid'],
				'lasttime'		=> JIEQI_NOW_TIME,
				'month'			=> $this_month,
				'days'			=> $this_day,
				'totalkeep'		=> 1
			);
			$this->db->add($add_data);
		} else {
			$days_arr = array_filter(explode(',', $res[0]['days']));
			if (!in_array($this_day, $days_arr)) {
				// ����û��ǩ����¼(��������ǩ��ʱ���ʼΪ1)
				$update_data = array('days'=>$res[0]['days'] . ',' . $this_day, 'lasttime'=>JIEQI_NOW_TIME, 'totalkeep'=>1);
				// �������ǩ����¼
				if ($this_day == 1) {
					// ��ѯ���µ�lasttime��¼
					$this->db->init('signin', 'sid', 'task');
					$this->db->setCriteria();
					$this->db->criteria->add(new Criteria('uid', $auth['uid'], '='));
					$this->db->criteria->add(new Criteria('month', $pre_month, '='));
					$pre_res = $this->db->lists();
					// ������ǩ����¼�����ǩ������Ϊ���һ��
					if (!empty($pre_res) && (date('d', $pre_res[0]['lasttime']))==cal_days_in_month(CAL_GREGORIAN, intval(date('m', $pre_res[0]['lasttime'])), intval(date('Y', $pre_res[0]['lasttime']))))
						$update_data['totalkeep'] = $pre_res[0]['totalkeep'] + 1;
				} else {
					$over_time = (JIEQI_NOW_TIME - $res[0]['lasttime'])/(3600*24);
					if ((date('d', JIEQI_NOW_TIME)-date('d', $res[0]['lasttime'])==1) && $over_time<2) 
						$update_data['totalkeep'] = $res[0]['totalkeep'] + 1;
				}
				// ���õ�ǰ���ݿ����ģ��
				$this->db->init('signin', 'sid', 'task');
				$this->db->edit($res[0]['sid'], $update_data);
			} else {
				// ��������Ѿ���ǩ����¼�򷵻���ʾ
				$this->printfail('������ǩ��');
			}
		}
		// 2���ж��Ƿ���������Ŀǰǩ��������������һ����
		$this->db->init('task', 'taskid', 'task');
		$this->db->setCriteria(new Criteria('type', 'signin', '='));
		$this->db->criteria->setLimit(1);
		$result = $this->db->lists();
		if (empty($result)) {
			$this->msgbox('');
			die;
		}
		$this_tid = $result[0]['taskid'];
		$taskLib = $this->load('signintask', 'task');
		$is_ach = $taskLib->isAchevable($this_tid);
		// 3���������ֱ�����ӽ���
		if (!$is_ach) {
			// ������ɷ��ؿ�
			$this->msgbox('');
			die;
		} else {
			// �����������������񲢽���
			$res_finish = $taskLib->setFinish(array('tid'=>$this_tid));
			if ($res_finish['status']=='OK') {
				$this->msgbox('');
				die;
			} else {
				$this->printfail($res_finish['msg']);
			}
		}
	}
}





















