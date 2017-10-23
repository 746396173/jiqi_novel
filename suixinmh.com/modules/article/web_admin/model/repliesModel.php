<?php 
/** 
 * С˵����->�������� * @copyright   Copyright(c) 2014 
 * @author      liujilei* @version     1.0 
 */ 

class repliesModel extends Model{

	public function main($params = array()){
		global $jieqiModules;
		//�������ò���
		$this->addConfig('system','configs');
		$this->addConfig('article','configs');
		$this->addConfig('article', 'power');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		$jieqiConfigs['article'] = $this->getConfig('article','configs');
		//Ȩ�޼��
		$jieqiPower['article'] = $this->getConfig('article','power');
		$canedit = $this->checkpower($jieqiPower['article']['manageallreview'], $this->getUsersStatus(), $this->getUsersGroup(), true );

		//���ع�����
		$data['ismaster'] = $canedit ? 1:0;
        if(!$params['page']) $params['page'] = 1;
		$this->db->init ( 'replies', 'postid', 'article' );
		$this->db->setCriteria();	
		$sqlStr = $this->dbprefix('article_replies')." AS r LEFT JOIN ".$this->dbprefix('article_reviews')." AS ar ON  r.topicid = ar.topicid"." LEFT JOIN ".$this->dbprefix('article_article')." AS a ON  r.ownerid = a.articleid";
		$this->db->criteria->setTables($sqlStr);
		$this->db->criteria->add(new Criteria('r.istopic',0, '='));
		$this->db->criteria->setFields("r.*,a.articlename,a.articleid,ar.title,ar.istop,ar.isgood");
        $this->db->criteria->setSort('r.postid');
		$this->db->criteria->setOrder('DESC');
	    if(!empty($params['keyword'])){
			if($params['keytype']==1) $this->db->criteria->add(new Criteria('a.articlename', '%'.$params['keyword'].'%', 'like'));
			else $this->db->criteria->add(new Criteria('r.poster', $params['keyword'], '='));
		 } 
		$data = $this->db->lists ( $jieqiConfigs ['article'] ['toppagenum'], $params['page'] );
		return array(
		'replyrows'=>$data,
		'url_jumppage'=>$this->db->getPage(),
		'article_dynamic_url'=>empty($jieqiConfigs['article']['dynamicurl']) ? $jieqiModules['article']['url'] : $jieqiConfigs['article']['dynamicurl']
		);
	}
	
	//����ID��ɾ�������۵Ļظ�����������Ӧ�Ļ���
	public function delReply($params = array())
	{
	    $this->addConfig('article','configs');
		$this->addConfig('article', 'power');
		$jieqiPower['power'] = $this->getConfig('article','power');
		$jieqiConfigs['article'] = $this->getConfig('article','configs');
		//$canedit = $this->checkpower($jieqiPower['power']['newreview'], $this->getUsersStatus(), $this->getUsersGroup(), true );
		//������������
		if(!empty($jieqiConfigs['article']['scorereply'])){
			$users_handler = $this->getUserObject();
			$users_handler->changeScore(intval($params['pid']), $jieqiConfigs['article']['scorereply'], false);
		
		}
		//ɾ������
		$this->db->init('replies ', 'postid', 'article');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('postid', $params['pid'], '='));
		$this->db->delete($this->db->criteria);
		return $this->main($params);
	}
	
	//����ID ɾ�����ۣ���ɾ�������۵Ļظ�����������Ӧ�Ļ���
	public function batchDel($params = array())
	{
	    $this->addConfig('article','configs');
		$jieqiConfigs['article'] = $this->getConfig('article','configs');
		$this->db->init('replies','postid','article');
		$arr = $params['checkid'];
		$ids = $this->arrayToStr($arr);
		$this->db->setCriteria(new Criteria('postid','('.$ids.')', 'in'));
		$this->db->delete($this->db->criteria);
		
		//ȡ������
		$users_handler = $this->getUserObject();
		foreach($arr as $k=>$v){
			if(!empty($jieqiConfigs['article']['scorereply'])){
				$users_handler->changeScore(intval($v), $jieqiConfigs['article']['scorereply'], false);
			}
		}

		return $this->main($params);
	}
}
?>