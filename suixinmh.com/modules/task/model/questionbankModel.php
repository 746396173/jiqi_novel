<?php
/**
 * �������ģ�ͣ�ǰ̨�û�����ģ��
 * @auther by: liuxiangbin
 * @createtime : 2015-02-04
 */

class questionbankModel extends Model {
	
	protected $_params = array();
		
	/**
	 * ��̨ģ�ͣ���������������
	 */
	public function getAllData($params) {
		$reData = array();
		$this->db->init('quests', 'qid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->setTables(jieqi_dbprefix('task_quests').' tq LEFT JOIN '.jieqi_dbprefix('article_article').' aa ON tq.aid=aa.articleid');
		$this->db->criteria->setFields('tq.*,aa.articlename');
		$this->db->criteria->add(new Criteria('qflag', 99, '<>'));
		// ��������
		if (isset($params['keyword']) && trim($params['keyword']) != '') {
			$this_field = trim($params['searchkey']);
			if (in_array($this_field, array('question','aid'))) {
				$this->db->criteria->add(new Criteria('tq.'.$this_field, '%'.trim($params['keyword']).'%', 'LIKE'));
			} else if ($this_field == 'articlename') {
				$this->db->criteria->add(new Criteria('aa.'.$this_field, '%'.trim($params['keyword']).'%', 'LIKE'));
			} else {
				$this->printfail('�Ƿ�����');
			}
		}
		// ����
		$this->db->criteria->setSort('tq.createtime');
		$this->db->criteria->setOrder('DESC');
		// �����ҳ����
		$this_count = $this->db->getCount($this->db->criteria);
		$this->addConfig('article','configs');
    		$jieqiConfigs['article'] = $this->getConfig('article', 'configs');
		$pagenum = $jieqiConfigs['article']['pagenum'];
		$thisPage = isset($params['page']) ? intval($params['page']) : 1;
		$reData['lists'] = $this->db->lists($pagenum, $thisPage, JIEQI_PAGE_TAG);
        include_once(HLM_ROOT_PATH.'/lib/html/page.php');
        $jumppage = new JieqiPage($this_count, $pagenum, $thisPage);
        $jumppage->setlink('', true, true);
		$reData['url_jumppage'] = $jumppage->whole_bar();
		$reData['qbcount'] = $this_count;
		return $reData;
	}
	
	/**
	 * ��̨ģ�ͣ�����һ������
	 */
	public function setOneData($params, $this_act = 'add') {
		$this->paramsFilter($params, $this_act);
		$this->db->init('quests', 'qid', 'task');
		$setData = array(
			'aid'				=> $this->_params['aid'],
			'question'			=> $this->_params['question'],
			'options'			=> json_encode($this->_params['options']),
			'rightoption'		=> $this->_params['rightoption'],
			'point'				=> ''
		);
		if ($this_act == 'add') {
			$setData['createtime'] = JIEQI_NOW_TIME;
			$this->db->add($setData);
			$this->msgbox('');
			die;
		} elseif ($this_act == 'edit') {
//			$this->dump($setData);
			$this->db->edit($this->_params['qid'], $setData);
			$this->msgbox('');
			die;
		}
		$this->printfail('����ʧ��');
	}
	
	/**
	 * ��̨ģ�ͣ�ɾ������
	 */
	public function delData($params, $isBatching = false) {
		$this->paramsFilter($params, 'del');
		$data = array();
		$this->db->init('quests', 'qid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('qid', $this->_params['qid'], '='));
		$res = $this->db->lists();
		if (empty($res))
			$this->printfail('��������');
		$data['qflag'] = 99;
		$this->db->edit($this->_params['qid'], $data);
		$this->msgbox('');
		die;
	}
	
	/**
	 * ��̨ģ�ͣ�չʾһ������
	 */
	public function viewOneData($params) {
		$this->paramsFilter($params, 'del');
		$data = array();
		$this->db->init('quests', 'qid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->setTables(jieqi_dbprefix('task_quests').' tq LEFT JOIN '.jieqi_dbprefix('article_article').' aa ON tq.aid=aa.articleid');
		$this->db->criteria->setFields('tq.*,aa.articlename');
		$this->db->criteria->add(new Criteria('tq.qid', $this->_params['qid'], '='));
		$res = $this->db->lists();
		if (empty($res))
			$this->printfail('��������');
		$data['qid'] 			= $res[0]['qid'];
		$data['aid'] 			= $res[0]['aid'];
		$data['question'] 		= $res[0]['question'];
		$data['rightoption'] 	= $res[0]['rightoption'];
		$data['point'] 			= $res[0]['point'];
		$data['createtime'] 		= $res[0]['createtime'];
		$data['qflag'] 			= $res[0]['qflag'];
		$data['articlename'] 	= $res[0]['articlename'];
		$temp = json_decode($res[0]['options'], true);
		foreach ($temp as $k => $v) {
			$data['options'][$k] = iconv('utf-8','gb2312',$v);
		}
		$this->msgbox('', $data);
	}
	
	/**
	 * ��̨ģ�ͣ�����AID������µ�����
	 */
	public function getArticleName($params) {
		if (intval($params['aid'])<=0)
			$this->printfail('��������');
		$this->db->init('article', 'articleid', 'article');
		$this->db->setCriteria(new Criteria('articleid', intval($params['aid']), '='));
		$res = $this->db->lists();
		if (empty($res))
			$this->printfail('û���ҵ��κ��鼮');
		$this->msgbox('', $res[0]['articlename']);
	}
	
	/**
	 * ��̨ģ�ͣ��ڲ����� - �����ݹ���
	 * @param : $this_act - add-���;edit-�༭;del-ɾ��������֤qid��
	 */
	protected function paramsFilter($params, $this_act = 'add') {
//		$this->dump($params);
		if ($this_act != 'del') {
			$this->_params['aid'] = isset($params['aid']) ? intval($params['aid']) : $this->printfail('ȱ�ٲ���');
			$this->_params['question'] = isset($params['question']) ? trim($params['question']) : $this->printfail('ȱ�ٲ���');
			if (!isset($params['options'])) $this->printfail('ȱ�ٲ���');
			$this->_params['rightoption'] = isset($params['rightoption']) ? intval($params['rightoption']) : $this->printfail('ȱ�ٲ���');
			// ��ʾ�����ݲ�����
	//		$this->_params['point'] = isset($params['point']) ? intval($params['point']) : $this->printfail('ȱ�ٲ���');
			// ��֤����
			if ($this->_params['aid'] <= 0)
				$this->pintfail('�鼮ID��������');
			if ($this->_params['question']=='' || mb_strlen($this->_params['question'], 'gbk')>60)
				$this->printfail('���������������0С��60����');
			if ($this->_params['rightoption'] <= 0)
				$this->printfail('��ȷѡ����������');
			$options_sum = 0;
			foreach ($params['options'] as $k =>$v) {
				if (trim($v) != '') {
					$this->_params['options'][$k] = iconv('gb2312','utf-8',$v);
					$options_sum++;
				}
			}
			if ($options_sum < 2)
				$this->printfail('������Ҫ������ѡ��');
		}
		// �༭��ʽ���qid������֤
		if ($this_act == 'edit' || $this_act == 'del') {
			$this->_params['qid'] = isset($params['qid']) ? intval($params['qid']) : $this->printfail('ȱ�ٲ���');
			if ($this->_params['qid'] <= 0)
				$this->printfail('��������');
		}
	}
	
	/**
	 * ǰ̨��������������Ŀ����
	 * @param : $num - ������Ŀ����
	 */
	public function getQuestions($params, $num = 5) {
		$data = array();
		$this->db->init('quests', 'qid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('qid', $this->_params['qid'], '='));
		$res = $this->db->lists();
		if (empty($res))
			$this->printfail('��������');
		$data['qid'] 			= $res[0]['qid'];
		$data['aid'] 			= $res[0]['aid'];
		$data['question'] 		= $res[0]['question'];
		$data['rightoption'] 	= $res[0]['rightoption'];
		$data['point'] 			= $res[0]['point'];
		$data['createtime'] 		= $res[0]['createtime'];
		$data['qflag'] 			= $res[0]['qflag'];
		$data['articlename'] 	= $res[0]['articlename'];
		$temp = json_decode($res[0]['options'], true);
		foreach ($temp as $k => $v) {
			$data['options'][$k] = iconv('utf-8','gb2312',$v);
		}
		return $data;
	}
	
	/**
	 * ��ȡ�����Ŀ
	 * Ĭ��5��
	 * ��Ҫ�����µ�aid�ֶΣ����û����ȫ�����)
	 */
	public function getRadomQuestion($aid, $num = 5) {
		$this->db->init('quests', 'qid', 'task');
		$this->db->setCriteria();
		$this->db->criteria->setTables(jieqi_dbprefix('task_quests').' tq LEFT JOIN '.jieqi_dbprefix('article_article').' aa ON tq.aid=aa.articleid');
		$this->db->criteria->setFields('tq.qid');
		$this->db->criteria->add(new Criteria('tq.aid', intval($aid), '='));
		$this->db->criteria->add(new Criteria('tq.qflag', 99, '<>'));
		$qid_arr = $this->db->lists();
		// ���������Ŀ���������Ŀ��ʹ��������Ŀ����
		$ques_num = count($qid_arr)>=$num ? $num : count($qid_arr);
		$qids = array();
		foreach ($qid_arr as $k => $v) {
			$qids[$k] = $v['qid'];
		}
		// ���������鲢����sql�������
		$this_random = array_rand($qids, $ques_num);
		$where_str = '';
		// �����ȡ1������д���
		if ($ques_num==1) {
			$where_str = $this_random;
		} else {
			foreach ($this_random as $k => $v) {
				$where_str .= $qids[$v] . ',';
			}
			$where_str = rtrim($where_str, ',');
		}
		$this->db->init('quests', 'qid', 'task');
		$res = $this->db->execute('SELECT tq.*,aa.articlename FROM '.jieqi_dbprefix('task_quests').' tq LEFT JOIN '.jieqi_dbprefix('article_article').' aa ON tq.aid=aa.articleid WHERE tq.qid IN('.$where_str.')');
		// ����������һ������
		$data = array();
		$tmp_data = array();
		while ($row = mysql_fetch_array($res)) {
			$tmp_data[] = $row;
		}
		foreach ($tmp_data as $k => $v) {
			$data[$k]['qid'] = $v['qid'];
			$data[$k]['aid'] = $v['aid'];
			$data[$k]['question'] = $v['question'];
			$data[$k]['rightoption'] = $v['rightoption'];
			$data[$k]['options'] = iconv('gb2312', 'utf-8', $v['options']);
		}
//		$this->dump($data);
//		return $data;
		$this->msgbox('', $data);
	}
}















	