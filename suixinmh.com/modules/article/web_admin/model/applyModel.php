<?php 
/**
 * ���������¼
 * @author chengyuan  2014-4-24
 *
 */
class applyModel extends Model{
	/**
	 * �����б�
	 * @param unknown $params
	 */
	public function applyList($params = array()){
		global $jieqiModules;
		$this->addConfig('article','configs');
		$data = array();
		$this->db->init('applywriter', 'applyid', 'article' );
		$this->action($params);
		//��ʾ�б�
		$this->db->setCriteria();
		$this->db->criteria->setSort('applyid');
		switch ($params['display']){
			case 'ready':
				$this->db->criteria->add(new Criteria('applyflag', 0));
				break;
			case 'success':
				$this->db->criteria->add(new Criteria('applyflag', 1));
				$this->db->criteria->setSort('authtime');
				break;
			case 'failure':
				$this->db->criteria->add(new Criteria('applyflag', 2));
				$this->db->criteria->setSort('authtime');
				break;
		}
		$this->db->criteria->setOrder('DESC');
		$data ['rows'] = $this->db->lists ($this->getConfig('article','configs','pagenum'), $params ['page'] );
		foreach($data['rows'] as $k=>$v){
			$v['applytext'] = $this->getFormat($v['applytext'],'s');
			$data['rows'][$k] = $v;
		}
		$data ['url_jumppage'] = $this->db->getPage ();
		$data ['display'] = $params ['display'];
		$data ['article_dynamic_url'] = (empty($jieqiConfigs['article']['dynamicurl'])) ? $jieqiModules['article']['url'] : $jieqiConfigs['article']['dynamicurl'];
		return $data;
	}
	
	
	private function action($params){
		$auth = $this->getAuth();
		if(isset($params['action']) && !empty($params['aid'])){
			//$this->db->init('article','articleid','article');
			switch($params['action']){
				case 'del'://ɾ��
					$this->db->delete($params['aid']);
					break;
				case 'refusal'://�ܾ�
					$this->db->edit($params['aid'],array('applyflag'=>2,'authtime'=>JIEQI_NOW_TIME,'authuid'=>$auth['uid'],'authname'=>$auth['useruname']));
					break;
				case 'audit'://ͨ��
					$articleLib = $this->load ( 'article', 'article' );
					$this->db->edit($params['aid'],array('applyflag'=>1,'authtime'=>JIEQI_NOW_TIME,'authuid'=>$auth['uid'],'authname'=>$auth['useruname']));
					$applyUser = $articleLib->updateGroup( $params['applyuid'],$articleLib->jieqiConfigs['article']['writergroup'],false);
					//���Ͷ���
					$apply = $this->model('message','system');
					$apply->auditApproval($params['applyuid'], $applyUser->getVar('uname', 'n'), $articleLib->jieqiLang['article']['apply_confirm_title'],$articleLib->jieqiLang['article']['apply_confirm_text']);
					//������Ϣ�����˲�������������applywriter��
					$this->db->init('applywriter', 'applyid', 'article');
					break;
			}
	
		}
	}
} 
?>