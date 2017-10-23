<?php 
/**
 * ��ܱ����ģ��
 * @author chengyuan 2015-6-2 ����2:46:49
 */
class bookcaseModel extends Model{
	/**
	 * ����½���ǩ
	 * <p>
	 * ����鼮�Ѿ�������ܣ��������ǩ�½���Ϣ
	 * <p>
	 * ����鼮û�з�����ܣ���ֱ������½���ǩ��Ϣ����������goodnum+1
	 * @author chengyuan 2015-6-3 ����9:33:02
	 * @param unknown $uid
	 * @param unknown $username
	 * @param unknown $aid
	 * @param unknown $cid
	 * @return boolean 1ʧ�ܣ�2�����ɹ���3���³ɹ�
	 */
	public function addBookmark($uid,$username,$aid,$cid){
		$this->addLang('article', 'article');
		$jieqiLang['article'] = $this->getLang('article'); //�������԰����ø�ֵ
		//������ǩ
		$this->db->init('chapter','chapterid','article');
		$this->db->setCriteria(new Criteria('c.chapterid', $cid));
		$this->db->criteria->setTables(jieqi_dbprefix('article_chapter').' c LEFT JOIN '.jieqi_dbprefix('article_article').' a ON c.articleid=a.articleid');
		$this->db->queryObjects($this->db->criteria);
		$chapter=$this->db->getObject();
		unset($this->db->criteria);
		if(!$chapter) $this->printfail($jieqiLang['article']['chapter_not_exists']);
		$this->db->init('bookcase','caseid','article');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('userid',$uid,'='));
		$this->db->criteria->add(new Criteria('articleid', $aid));
		$this->db->queryObjects();
		$bookcase=$this->db->getObject();
		unset($this->db->criteria);
		if (!$bookcase){
			//������־
			$package = $this->load('article', 'article');
			$article = $package->isExists($aid);
			if($package->addArticleStat($article['articleid'],$article['authorid'], 'goodnum')){
				$this->db->init('bookcase','caseid','article');
				$data = array();
				$data['joindate'] = JIEQI_NOW_TIME;
				$data['lastvisit'] = JIEQI_NOW_TIME;
				$data['flag'] = 0;
				$data['articleid'] = $chapter->getVar('articleid', 'n');
				$data['articlename'] = $chapter->getVar('articlename', 'n');
				$data['userid']= $uid;
				$data['username']= $username;
				$data['chapterid'] = $chapter->getVar('chapterid', 'n');
				$data['chaptername'] = $chapter->getVar('chaptername', 'n');
				$data['chapterorder'] =  $chapter->getVar('chapterorder', 'n');
				if(!$this->db->add($data)) {
					return 1;
				}else{
					return 2;
				}
			}
		}else{
			$bookcase->setVar('chapterid', $chapter->getVar('chapterid', 'n'));
			$bookcase->setVar('chaptername', $chapter->getVar('chaptername', 'n'));
			$bookcase->setVar('chapterorder', $chapter->getVar('chapterorder', 'n'));
			$bookcase->setVar('joindate', JIEQI_NOW_TIME);
			$bookcase->setVar('lastvisit',JIEQI_NOW_TIME);
			$bookcase->setVar('flag',0);//0�ֶ���ӣ�1�Զ����
			if(!$this->db->edit($bookcase->getVar('caseid', 'n') ,$bookcase)) {
				return 1;
			}else{
				return 3;
			}
		}
	}
}
?>