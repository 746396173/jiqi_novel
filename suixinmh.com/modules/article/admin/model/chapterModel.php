<?php
/**
 * С˵����->�½ڸ��¼�¼ * @copyright   Copyright(c) 2014
 * @author      zhangxue* @version     1.0
 */

class chapterModel extends Model{
	
	
	/**
	 * �¸���ͳ��
	 * @param unknown $aid
	 * @param unknown $year
	 * @param unknown $month
	 */
	public function getMonthChapters($aid,$year,$month){
		if(!$aid || !$year || !$month){
			$this->printfail(LANG_ERROR_PARAMETER);
		}
		$day_num = cal_days_in_month (CAL_GREGORIAN,$month, $year);
		$month_begin_time = strtotime($year.'-'.$month.'-01 00:00:00');
		$month_end_time = strtotime($year.'-'.$month.'-'.$day_num.' 23:59:59');
		//������������½�
		$sql = "select t0.chapterid,t0.chaptername,t0.postdate,t1.comment from ".jieqi_dbprefix ( "article_chapter" )." t0 LEFT JOIN ".jieqi_dbprefix ( "article_comment" )." t1 on t0.chapterid=t1.chapterid where articleid = {$aid} and postdate BETWEEN {$month_begin_time} AND {$month_end_time} order by postdate asc";
		$chapters = $this->db->selectsql ($sql);
		
		if(is_array($chapters)){
			foreach($chapters as $key=>&$chapter){
				// 			$chapter['content'] = @$articleLib->getContent($chapter['chapterid']);
				//���û����ע��¼��commentid �� comment ��ֵ�� null
				if($chapter['comment']){
					$commentArr = unserialize($chapter['comment']);
					if(is_array($commentArr)){
						$chapter['comment'] = $commentArr;
					}else{
						$chapter['comment'] = "";
					}
				}else{
					$chapter['comment'] = "";
				}
			}
		}
		return array(
				'year'=>$year,
				'month'=>$month,
				'chapters'=>$chapters
		);
	}
	/**
	 * �½ڸ�����ͳ��
	 * @param unknown $params
	 * @return multitype:NULL unknown
	 */
	public function chapterStatistics($params = array()){
		$data = array();
		//�����·�
		if($params['ym'] && $params['ym'] != date("Y").'-'.date("m")){
			$ym = explode('-',$params['ym']);
			$year = $ym[0];
			$month = $ym[1];
			$day_num = cal_days_in_month (CAL_GREGORIAN,$month, $year);
		}else{
			//ȱʡ������
			$year = date("Y");
			$month = date("m");
			$day_num = date("d");
		}
		$auth = $this->getAuth();
		$articleLib = $this->load('article','article');//�������´�����
		$source = $articleLib->getSources();
		$start_time = strtotime($year.'-'.$month.'-01 00:00:00');
		$end_time = strtotime($year.'-'.$month.'-'.$day_num.' 23:59:59');
// 		$sql = "SELECT count( articleid ) AS t_num, sum( size ) AS t_size, 
// 				GROUP_CONCAT( conv( oct( chapterid ) , 8, 10 ) SEPARATOR ',' ) AS chapterids,
// 				GROUP_CONCAT( conv( oct( commentdate ) , 8, 10 ) SEPARATOR ',' ) AS commentdates,
// 		 		FROM_UNIXTIME( postdate, '%s' ) as pdate FROM ".jieqi_dbprefix ( "article_chapter" )." WHERE articleid =%u
// 				AND postdate BETWEEN {$start_time} AND {$end_time}
// 				GROUP BY pdate
// 				order by postdate asc";
		$this->db->init('article','articleid','article');
		$this->db->setCriteria();
		if(is_numeric($params['firstflag'])){
			$this->db->criteria->add(new Criteria('firstflag', $params['firstflag']));
		}
		if(!empty($params['keyword'])){
			$params['keyword'] = urldecode($params['keyword']);
			if($params['keytype']==1) $field = 'author';
			else $field = 'articlename';
			$this->db->criteria->add(new Criteria($field, '%'.$params['keyword'].'%', 'LIKE'));
		}
		if($this->checkpower($articleLib->jieqiPower['article']['manageallarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true)){
			//�༭��ɸѡ
			if($params["nowagent"]){
				$this->db->criteria->add(new Criteria('agentid',$params["nowagent"]));
			}else{
				$params["nowagent"] = 0;//ȱʡ
			}
		}else{
			//��ǰ�༭��
			$this->db->criteria->add(new Criteria('agentid',$auth['uid']));
		}
		$this->db->criteria->setSort('lastupdate');
		$this->db->criteria->setOrder('DESC');
		$data ['rows'] = $this->db->lists (30, $params['page']);
		$data ['url_jumppage'] = $this->db->getPage ();
// 		$this->db->query("SET @@global.group_concat_max_len=102400;");
// 		SELECT @@global.group_concat_max_len;

		
// 		$resutl = $this->db->selectsql ('SELECT @@global.group_concat_max_len');
		
// 		$query = $this->db->query(sprintf($sql,'%Y-%m-%d',9815));
// 		while($v = $this->db->fetchArray($query)){
// // 			if($v['pdate']='2013-12-09'){
// // 				print_r($v);
// // 			}
// 			$rows[] = $v;
// 		}
// 		print_r($rows[5]);
// 		exit;
		
		
// 		$sql = "SELECT count( articleid ) AS t_num, sum( size ) AS t_size,
// 				GROUP_CONCAT( conv( oct( t0.chapterid ) , 8, 10 ) ORDER BY t0.chapterid SEPARATOR ',' ) AS chapterids,
// 				GROUP_CONCAT( t1.comment SEPARATOR ',' ) AS comment,
// 				FROM_UNIXTIME( postdate, '%s' ) as pdate
// 				FROM ".jieqi_dbprefix ( "article_chapter" )." t0 LEFT JOIN ".jieqi_dbprefix ( "article_comment" )." t1 ON t0.chapterid = t1.chapterid WHERE  articleid =%u
// 						AND postdate BETWEEN {$start_time} AND {$end_time}
// 						GROUP BY pdate
// 						order by postdate asc";
		$sql = "SELECT count( t0.articleid ) AS t_num, sum( t0.size ) AS t_size,
				GROUP_CONCAT( t1.comment SEPARATOR ',' ) AS comment,
				FROM_UNIXTIME( t0.postdate, '%s' ) as pdate
				FROM ".jieqi_dbprefix ( "article_chapter" )." t0 LEFT JOIN ".jieqi_dbprefix ( "article_comment" )." t1 ON t0.chapterid = t1.chapterid WHERE  t0.articleid =%u
						AND t0.postdate BETWEEN {$start_time} AND {$end_time}
						GROUP BY pdate
						order by t0.postdate asc";
		
		foreach($data['rows'] as $tmp=>&$row){
			
// 			unset($this->db);
// 			$this->db = Application::$_lib ['database'];
// 			$this->db->init('chapter','chapterid','article');
			$resutl = $this->db->selectsql (sprintf($sql,'%Y-%m-%d',$row['articleid']));
// 			if($row['articleid'] == 9815){
// 				echo sprintf($sql,'%Y-%m-%d',$row['articleid']).'<br>';
// // // 							$resutl = $this->db->selectsql (sprintf($sql,'%Y-%m-%d',$row['articleid']));
// // 				$query = $this->db->query(sprintf($sql,'%Y-%m-%d',$row['articleid']));
// // 				while($v = $this->db->fetchArray($query)){
// // 					if($v['pdate']='2013-12-09'){
// // 						print_r($v);
// // 					}
// // 					$rows[] = $v;
// // 				}
// // 				exit;
// // // 				return $rows;
				
// // // 				print_r($this->db->query(sprintf($sql,'%Y-%m-%d',$row['articleid'])));
// // // 				exit;
// // // 				echo sprintf($sql,'%Y-%m-%d',$row['articleid']).'<br>';
// // 				print_r($resutl[5]);
// // // 				exit;
// 			}
			//����result��pdate��Ψһ������Ϊkey
			if($resutl){
				foreach($resutl as $key=>$value){
					$k = $value['pdate'].'';
					unset($value['pdate']);
					unset($resutl[$key]);
					$resutl[$k] = $value;
				}
			}
			for ($i=1;$i<=$day_num;$i++){
				//��ȫ����01,02,03,04,05,06,07,08,09
				if($i<10){
					$date = $year.'-'.$month.'-0'.$i;
				}else{
					$date = $year.'-'.$month.'-'.$i;
				}
				$t_num = $t_size =  0 ;
// 				$cids = '';
				if($resutl && key_exists($date, $resutl)){
					$t_num = $resutl[$date]['t_num'];
					$t_size = $resutl[$date]['t_size'];
// 					$cids = $resutl[$date]['chapterids'];
// 					$has_comment = $this->checkCommentDate($resutl[$date]['commentdates']);

					$has_comment = $resutl [$date] ['comment']?1:0;
					
// 					if($row['articleid'] == 9815 && $i == 9){
// 						echo $resutl [$date] ['comment'];
// // 						$this->maxCommentCountTheSameDay($resutl [$date] ['comment']);
// // 						echo sprintf($sql,'%Y-%m-%d',$row['articleid']);
// 					}
					
// 					$has_comment = 0;
// 					if($resutl [$date] ['comment']){
// 						$commentArr = unserialize($resutl [$date] ['comment']);
// 						if(is_array($commentArr)){
// 							$has_comment = count($commentArr);
// 						}
// 					}
					
				}
				$row['items'][] = array('t_num'=>$t_num,'t_size'=>ceil($t_size/2),'has_comment'=>$has_comment);
			}
		}
		// ����ҳ����ת
		//�ͷ���db���ڻ�ȡ��ѯ��
		if($this->checkpower($articleLib->jieqiPower['article']['manageallarticle'], $this->getUsersStatus (), $this->getUsersGroup (), true)){
			//�й����������µ�Ȩ��
			$data['agents'] = $articleLib->getAgents();
			$data['nowagent'] = $params["nowagent"];
		}
		$data['firstflag'] = $params ['firstflag'];
		$data['year'] = $year;
		$data['month'] = $month;
		$data['day_num'] = $day_num;
		$data['state'] = $source['fullflag']['items'] ;
		$data['soruce'] = $source ['firstflag']['items'];
		$data['keytype'] = $params['keytype'];
		$data['keyword'] = $params['keyword'];
		return $data;
	}
	/**
	 * ͬһ��������������ε���ע����
	 * @param unknown $serializeStr ��,�ָ�����л��ַ���
	 */
	private function maxCommentCountTheSameDay($serializeStr){
		$num = 0;
		if($serializeStr && is_array(explode(',', $serializeStr))){
			print_r(explode(',', $serializeStr));
			foreach(explode(',', $serializeStr) as $key=>$serializeComment){
				$commentArr = unserialize($serializeComment);
				if(is_array($commentArr)){
					echo count($commentArr);
					if(count($commentArr) > $num){
						$num = count($commentArr);
					}
				}else{
					//ʧ��ԭ���п����ֶι���GROUP_CONCAT�����г������ƣ�Ĭ�ϣ�1024
				}
			}
		}
		return $num;
	}
	/**
	 * �����עʱ�䣬0��Ч��ʱ�����Ч
	 * @param unknown $commentdates ��,�ָ��ʱ��� 0,1414463169,1414463169,0
	 * @return 0����Ч��עʱ�䣬1������Ч����עʱ��
	 */
	private function checkCommentDate($commentdates){
		if($commentdates){
			$dateArr = explode(',',$commentdates);
			if(is_array($dateArr) && count($dateArr) >= 1){
				rsort($dateArr);//����
				if(is_numeric($dateArr[0]) && $dateArr[0] > 0) {
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		return 0;
		
	}
	/**
	 * msgbox���Զ��ж��ύ����ajax������json��ʽ
	 * @param unknown $cids
	 */
	public function getChapters($aid,$year,$month,$day){
		if($aid && $year && $month && $day){
			$start_time = strtotime($year.'-'.$month.'-'.$day .' 00:00:00');
			$end_time = strtotime($year.'-'.$month.'-'.$day.' 23:59:59');			
			$articleLib = $this->load('article','article');
			$articleLib->instantPackage($aid);
			$chapters = $this->db->selectsql ("select t0.chapterid,t0.chaptername,t0.chaptertype,t1.commentid,t1.comment from ".jieqi_dbprefix ( "article_chapter" )." t0 left join ".jieqi_dbprefix ( "article_comment" )." t1 on t0.chapterid = t1.chapterid where t0.articleid = {$aid} AND t0.postdate BETWEEN {$start_time} AND {$end_time} order by t0.postdate");
			//������ע
			foreach($chapters as $key=>&$chapter){
				$chapter['content'] = @$articleLib->getContent($chapter['chapterid']);
				//���û����ע��¼��commentid �� comment ��ֵ�� null
				if($chapter['comment']){
					$commentArr = unserialize($chapter['comment']);
					if(is_array($commentArr)){
						$chapter['comment'] = $commentArr;
					}else{
						$chapter['comment'] = "";
					}
				}else{
					$chapter['comment'] = "";
				}
			}
			$this->msgbox('',$chapters);
		}else{
			$this->printfail(LANG_ERROR_PARAMETER);
		}
	}
	/**
	 * ����½���ע
	 * @param unknown $cid
	 * @param unknown $comment
	 */
	public function addComment($cid,$comment){
		include_once(JIEQI_ROOT_PATH.'/include/changecode.php');
		$comment = jieqi_utf82gb(urldecode($comment));
		if($cid && $comment){
			$this->db->init('chapter','chapterid','article');
			$chapter = $this->db->get ( $cid );
			if($chapter){
				$this->db->init('comment','commentid','article');
				$this->db->setCriteria(new Criteria('chapterid', $cid));
				$this->db->queryObjects();
				$commentObj = $this->db->getObject();
// 				$commentdate = date('Y-m-d H:i:s',JIEQI_NOW_TIME);
				$auth = $this->getAuth();
				$result = false;
				$ct = array("comment"=>$comment,"date"=>date('Y-m-d H:i:s',JIEQI_NOW_TIME),'uid'=>$auth['uid'],'username'=>$auth['username']);
				if (is_object ($commentObj)) {//�м�¼
					$commentId = $commentObj->getVar ( 'commentid', 'n' );
					$commentOld = $commentObj->getVar ( 'comment', 'n' );
					$commentArr = unserialize($commentOld);
					if(is_array($commentArr)){
						//�ѵ�����
						array_unshift($commentArr,$ct);
						$result = $this->db->edit($commentId,array('comment'=>serialize($commentArr)));
					}else{
						$this->printfail(LANG_ERROR_PARAMETER);
					}
				} else {//�޼�¼
					$commentArr[] = $ct;
					$result = $this->db->add ( array('chapterid'=>$cid,'comment'=>serialize($commentArr)));
				}
				if($result){
					$ct['msg'] = LANG_DO_SUCCESS;
					$ct['postdateday'] = date('j',$chapter['postdate']);
					$this->msgbox('',$ct);
				}else{
					$this->printfail(LANG_DO_FAILURE);
				}
			}else{
				$this->printfail('�½��Ѿ�ɾ��');
			}
		}else{
			$this->printfail(LANG_ERROR_PARAMETER);
		}
	}
	
	public function getChapter($param = array()){
		//�����Զ�����
		$articleLib =  $this->load('article','article');
		$data = $articleLib->getSources ();
		$data['article'] = $articleLib->isExists($param['aid']);
		$articleLib->canedit($data['article']);//�˴���֤Ȩ��
		$this->db->init('chapter','chapterid','article');
		if(!$data['chapter'] = $this->getFormat($this->db->get($param['cid']),'e')){
			if($param['chaptertype']==1) $typename=$articleLib->jieqiLang['article']['volume_name'];
			else $typename=$articleLib->jieqiLang['article']['chapter_name'];
			$this->printfail(sprintf($articleLib->jieqiLang['article']['chapter_volume_notexists'], $typename));
		}
		//�ύ����
		if($this->submitcheck()){
		    if(!in_array($data['chapter']['display'],array(1,9))) $this->printfail('���½�������ˣ�');
			if($data['chapter']['comment']) $this->printfail('�벻Ҫ�ظ�����½ڣ�');
			if($param['type']){//���ͨ��
			    $display = 0;
				if($data['chapter']['display']==9) $display = 2;
			    $statu = $this->db->edit($param['cid'], array('display'=>$display, 'comment'=>'', 'commentdate'=>time()));
				if($statu) $articleLib->article_repack($param['aid'], array('makeopf'=>1), 1);
			}else{
			    $statu = $this->db->edit($param['cid'], array('comment'=>$param['comment'], 'commentdate'=>time()));
			}
			if($statu) jieqi_jumppage();
			else jieqi_printfail();
		}
		if($data['chapter']['chaptertype'] == 0){
			$data['wordsperegold'] = $articleLib->jieqiConfigs['article']['wordsperegold'];
			//�½�
			$data['authtypeset'] = $articleLib->jieqiConfigs['article']['authtypeset'];
			$articleLib->instantPackage ( $param['aid'] );
			$data['chapter']['context']= $articleLib->getContent ( $param['cid'], ENT_QUOTES );
			//�Զ���۸��Ȩ��
			if($this->checkpower($articleLib->jieqiPower['article']['customprice'], $this->getUsersStatus (), $this->getUsersGroup (), true)){
				$data['article']['customprice'] = 1;
			}
			//��������
			$data['maxfilenum'] = 0;
			$canupload = $this->checkpower($articleLib->jieqiPower['article']['articleupattach'], $this->getUsersStatus(), $this->getUsersGroup(), true);
			if($canupload && is_numeric($articleLib->jieqiConfigs['article']['maxattachnum']) && $articleLib->jieqiConfigs['article']['maxattachnum']>0){
				$data['maxfilenum'] = $articleLib->jieqiConfigs['article']['maxattachnum'];
			}
			//���ϴ��ĸ���
			$tmpvar = $data['chapter']['attachment'];
			$attachnum = 0;
			if (! empty ( $tmpvar )) {
				$attachary = unserialize ( htmlspecialchars_decode($tmpvar) );//print_r($attachary);
				if (! is_array ( $attachary ))
					$attachary = array ();
				$attachnum = count ( $attachary );
				if ($attachnum > 0) {
					$data['chapter']['attachary'] = $attachary;
				}
			}
			//����½����ƺ�ǰ׺
			/*if($data['article']['postdate'] >= $this->auto_chatper_prefix_timestamp){
				if(mb_strpos($data['chapter']['chaptername'], ' ')){
					$space_index = strpos($data['chapter']['chaptername'], ' ');
					$data['chapter']['chaptername_prefix']=array(substr($data['chapter']['chaptername'],0,$space_index));
					$data['chapter']['chaptername']=substr($data['chapter']['chaptername'],$space_index+1);
				}else{
					$data['chapter']['chaptername_prefix'] = "";
				}
			}*/
		}
		return $data;
	}
		
	public function main($params = array()){
		global $jieqiModules;
		$this->addConfig('article','configs');
		$jieqiConfigs['article'] = $this->getConfig('article','configs');
		$this->addLang('article','list');
		$jieqiLang['article'] = $this->getLang('article');//�������԰����ø�ֵ
		$this->db->init('chapter','chapterid','article');
		$this->db->setCriteria();
		if(!empty($params['chaptertype'])){
			if($params['chaptertype']=='volume'){
				$this->db->criteria->add(new Criteria('c.chaptertype',1, '='));
			}else{
				$this->db->criteria->add(new Criteria('c.chaptertype',0, '='));
			}
		}
		if(!empty($params['display'])){
			$this->db->criteria->add(new Criteria('c.display',1, '='));
			$this->db->criteria->add(new Criteria('c.display',9, '='),'or');
		}
		if(!$params['nowagent']){
			 //�ύ����
			 if($this->submitcheck()){
				 if(!empty($params['keyword'])){
					$params['keyword'] = urldecode($params['keyword']);
					if($params['keytype']==1) $this->db->criteria->add(new Criteria('c.poster', $params['keyword'], '='));
					elseif($params['keytype']==2) $this->db->criteria->add(new Criteria('c.articleid', $params['keyword'], '='));
					else $this->db->criteria->add(new Criteria('c.articlename', '%'.urldecode($params['keyword']).'%', 'LIKE'));
				 }
				 if($params['start']){
					$params['start'] = urldecode($params['start']);
					$start = strtotime($params['start']);
					$this->db->criteria->add(new Criteria('c.postdate', $start,'>='));
				 }
				 if($params['end']){
					$params['end'] = urldecode($params['end']);
					$end = strtotime($params['end']);
					$this->db->criteria->add(new Criteria('c.postdate', $end,'<='));
				 }
			 }
			 $tablSql = $this->dbprefix('article_chapter')." AS c";
			 $this->db->criteria->setTables($tablSql);
			//render sql,�Ӳ�ѯ-���ϲ�ѯ������������
//			$sizeSql = "select sum(c.size) from $tablSql ".$this->db->criteria->renderWhere();
//			$this->db->criteria->setFields("($sizeSql) as totalsize, c.*");
//			$this->db->criteria->setFields("c.*,sum(c.size) as totalSize");
			$this->db->criteria->setFields("sum(c.size) as totalSize");
			$res = $this->db->lists();
//			echo $res[0]['totalSize'];die;
			$this->db->criteria->setFields("c.*");
//			$totalsize = $this->db->getSum('size');
			
		}else{

			 //�ύ����
			 if($this->submitcheck()){
				 if(!empty($params['keyword'])){
					$params['keyword'] = urldecode($params['keyword']);
					if($params['keytype']==1) $this->db->criteria->add(new Criteria('c.poster', $params['keyword'], '='));
					elseif($params['keytype']==2) $this->db->criteria->add(new Criteria('c.articleid', $params['keyword'], '='));
					else $this->db->criteria->add(new Criteria('c.articlename', '%'.urldecode($params['keyword']).'%', 'LIKE'));
				 }
				 if($params['nowagent']){
					$this->db->criteria->add(new Criteria('a.agentid', $params['nowagent']));
				 }
				 if($params['start']){
					$params['start'] = urldecode($params['start']);
					$start = strtotime($params['start']);
					$this->db->criteria->add(new Criteria('c.postdate', $start,'>='));
				 }
				 if($params['end']){
					$params['end'] = urldecode($params['end']);
					$end = strtotime($params['end']);
					$this->db->criteria->add(new Criteria('c.postdate', $end,'<='));
				 }
			 }
			 $tablSql = $this->dbprefix('article_article')." AS a RIGHT JOIN ".$this->dbprefix('article_chapter')." AS c ON a.articleid=c.articleid";
			 $this->db->criteria->setTables($tablSql);
			//render sql,�Ӳ�ѯ-���ϲ�ѯ������������
//			$sizeSql = "select sum(c.size) from $tablSql ".$this->db->criteria->renderWhere();
//			$this->db->criteria->setFields("($sizeSql) as totalsize, c.*,a.agent,a.agentid");
			$this->db->criteria->setFields("sum(c.size) as totalSize");
			$res = $this->db->lists();
			$this->db->criteria->setFields("c.*,a.agent,a.agentid");
//			$totalsize = $this->db->getSum('size');
		}
//		$totalSize = $this->db->returnSql($this->db->criteria);
//		echo $this->db->getSum('size');die;
		$this->db->criteria->setSort('c.postdate');
		$this->db->criteria->setOrder('DESC');
		if(!$params['page']) $params['page'] = 1;
		$this->db->criteria->setLimit($jieqiConfigs['article']['pagenum']);
		$this->db->criteria->setStart(($params['page']-1) * $jieqiConfigs['article']['pagenum']);
		$this->db->queryObjects();
//		echo 111;die;
//		$totalsize = $this->db->getSum('size');//echo $totalsize;
		
//		echo $this->db->returnSql($this->db->criteria);die;
//		echo $totalsize;die;
//		$totalsize_k = ceil($totalsize/1024);//echo $totalsize_k.' ';
//		$totalsize_c = ceil($totalsize/2);//echo $totalsize_c.' ';
//		$totalsize_w = number_format($totalsize_c / 10000,1);//echo $totalsize_w;//����
		$k=0;
// 		$sumsize = 0;
		$package = $this->load('article','article');//�������´�����
		while($v = $this->db->getObject()){
			$articlerows[$k] = $package->article_vars($v);
//			$articlerows[$k]['totalSize'] = $v->getVar('totalSize', 'n');
// 			$sumsize += $v->getVar('size','n');
			$articlerows[$k]['chaptername'] = $v->getVar('chaptername','n');
			$articlerows[$k]['postdate']=date(JIEQI_DATE_FORMAT.' '.JIEQI_TIME_FORMAT,$v->getVar('postdate'));  //����ʱ��
			$articlerows[$k]['lastupdate']=date(JIEQI_DATE_FORMAT.' '.JIEQI_TIME_FORMAT,$v->getVar('lastupdate'));  //����ʱ��
			$articlerows[$k]['chaptertype']=$v->getVar('chaptertype');  //�½�����
			if($articlerows[$k]['chaptertype']==0){
				 $articlerows[$k]['url_lastchapter']=$this->geturl('article', 'reader', 'aid='.$v->getVar('articleid'),'cid='.$v->getVar('chapterid'));
				$articlerows[$k]['typename']=$jieqiLang['article']['chapter_name'];
			}else{
				$articlerows[$k]['url_lastchapter']='#';
				$articlerows[$k]['typename']=$jieqiLang['article']['volume_name'];
			}
			$articlerows[$k]['checkbox']='<input type="checkbox" id="checkid[]" name="checkid[]" value="'.$v->getVar('chapterid').'">';  //ѡ���
			$k++;
		 }
		 include_once(HLM_ROOT_PATH.'/lib/html/page.php');
		 $jumppage = new JieqiPage($this->db->getCount($this->db->criteria),$jieqiConfigs['article']['pagenum'],$params['page']);
		 $jumppage->setlink('', true, true);//print_r($articlerows);
		 //��ȡ�༭��
		 $agents = array();
		 if($jieqiConfigs['article']['agentgroup']){
			 global $jieqiGroups;
			 $group_array = explode('|',$jieqiConfigs['article']['agentgroup']);
			 $groups = array();
			 foreach($group_array as $key=>$group){
				  $groups[] = array_search($group, $jieqiGroups);
			 }
			 if(is_array($groups)){
			      $this->db->init('users','uid','system');
				  $this->db->setCriteria();
				  $this->db->criteria->setFields("uid,uname,name,groupid");
				  foreach($groups as $k=>$groupid){
				      $this->db->criteria->add(new Criteria('groupid', $groupid), 'OR');
				  }
				  $this->db->criteria->setSort('uid');
				  $this->db->criteria->setOrder('ASC');
				  $agents = $this->db->lists();
			 }
		 }
		 $source = $package->getSources();
//		 $totalsize = 0;
//		 if(current($articlerows)){
//		 	$totalsize = ceil($articlerows[0]['totalsize']/2);
//		 }
		 return array(
		 	  'totalsize'=>ceil($res[0]['totalSize']/2),
		 	  'agents'=>$agents,
			  'channel'=>$source['channel'],
			  'groups'=>$jieqiGroups,
			  'nowagent'=>$params['nowagent'],
		      'articletitle'=>$jieqiLang['article']['chapter_update_list'],
			  'articlerows'=>$articlerows,
			  'article_static_url'=>(empty($jieqiConfigs['article']['staticurl'])) ? $jieqiModules['article']['url'] : $jieqiConfigs['article']['staticurl'],
			  'article_dynamic_url'=>(empty($jieqiConfigs['article']['dynamicurl'])) ? $jieqiModules['article']['url'] : $jieqiConfigs['article']['dynamicurl'],
			  'url_jumppage'=>$jumppage->whole_bar(),
			  'start'=>$params['start'],
			  'end'=>$params['end'],
// 			  'totalsize'=>$totalsize,
// 			  'totalsize_c'=>$totalsize_c,
// 			  'totalsize_w'=>$totalsize_w,
			  'keytype'=>$params['keytype'],
			  'keyword'=>$params['keyword']
		 );
	}

}
?>