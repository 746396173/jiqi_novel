<?php 
/**
 * ������article�µ�һ������ģ��
 * @author liuxiangbin 
 * @create 2015-03-30 15:24:15
 */
class reviews3gModel extends Model{

	//��ѯ����
	public function main($params, $pageNum = 20)
	{
		$this->addConfig('article','configs');
		$jieqiConfigs['article'] = $this->getConfig('article','configs');
		$this->addConfig('article', 'power');
		$jieqiPower['article'] = $this->getConfig('article','power');
		$canedit = $this->checkpower($jieqiPower['article']['manageallreview'], $this->getUsersStatus(), $this->getUsersGroup(), true );
		$reviewnewLib = $this->load ( 'reviews', 'article');
		$params['limit'] = $pageNum;
		$params['ispage'] = false;
		$temp = $reviewnewLib->queryReviews($params);
		// ����ͷ����ص�avatar����
		$data = array();
		$userModel = $this->db->init('users', 'uid', 'system');
		foreach ($temp['reviewrows'] as $k=>$v) {
			// �������ò���
			$data[$k]['rid'] = $v['topicid'];
			$data[$k]['posttext'] = $v['posttext'];$data[$k]['isvip'] = $v['isvip'];
			$data[$k]['poster'] = $v['poster'];
			$data[$k]['posttime'] = $v['posttime'];
			$data[$k]['posterid'] = $v['posterid'];
            $data[$k]['replies'] = $v['replies'];
			// ����ͷ����ز���
			$userModel->setCriteria();
			$userModel->criteria->add(new Criteria('uid', $v['posterid'], '='));
			$userModel->criteria->setFields('avatar');
			$res = $userModel->lists();
			$data[$k]['avatar'] = $res[0]['avatar'];
		}
		return $data;
	}

	/**
	 * ����ͷ�����
	 */
	public function addFace($params, $twoArr = true) {
		$data = array();
		$userModel = $this->db->init('users', 'uid', 'system');
		if ($twoArr) {
			foreach ($params as $k=>$v) {
				// �������ò���
				foreach ($v as $key=>$val) {
					$data[$k][$key] = $val;
				}
				// ����ͷ����ز���
				$userModel->setCriteria();
				$userModel->criteria->add(new Criteria('uid', $v['posterid'], '='));
				$userModel->criteria->setFields('avatar');
				$res = $userModel->lists();
				$data[$k]['avatar'] = $res[0]['avatar'];
			}
		} else {
			$data = $params;
			$userModel->setCriteria();
			$userModel->criteria->add(new Criteria('uid', $params['posterid'], '='));
			$userModel->criteria->setFields('avatar');
			$res = $userModel->lists();
			$data['avatar'] = $res[0]['avatar'];
		}
		return $data;
	}
	/**
	 * �������ۼ��ظ�ҳ����ѯ����
	 */
	public function reviewbyid($params){
		$review = array();
		$this->db->init ( 'replies', 'postid', 'article' );
		$this->db->setCriteria(new Criteria('r.topicid', $params['rid']));
		$this->db->criteria->add(new Criteria('istopic', 1));
		$sqlStr = $this->dbprefix('article_replies')." AS r INNER JOIN ".$this->dbprefix('article_reviews')." AS ar ON r.topicid = ar.topicid LEFT JOIN ".$this->dbprefix('system_users')." AS u ON r.posterid = u.uid";
		$this->db->criteria->setTables($sqlStr);
		$this->db->criteria->setFields("r.*,ar.*,u.avatar");
		$this->db->queryObjects();
		while($v = $this->db->getObject()){//print_r($v);
			$review['poster']=$v->getVar('poster');
			$review['posterid']=$v->getVar('posterid');
			$review['title']=$v->getVar('title');
			$review['posttime']=$v->getVar('posttime');
			$review['posttext']=$v->getVar('posttext');
			$review['articleid']=$v->getVar('ownerid');
			$review['avatar']=$v->getVar('avatar');
		}
		return $review;
	}
}