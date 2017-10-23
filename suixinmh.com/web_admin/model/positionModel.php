<?php
/**
 * ��̨ϵͳ����->ģ���ǩ������ * @copyright   Copyright(c) 2014
 * @author      huliming* @version     1.0
 */
class positionModel extends Model{

	//�б�
	public function main($params = array()){
	    //��ʼ����ǩ����
		$position = $this->load('position', 'system');
		$_PAGE['ltag'] = '{?';
		$_PAGE['rtag'] = '?}';
		//$this->db->init( 'position', 'posid', 'system' );
		//$position->Database();
		$position->setCriteria();
		$position->criteria->add(new Criteria('siteid', JIEQI_SITE_ID));
		// ��ʼ����ѯ����
		$s_name = isset($params['search_name']) ? htmlspecialchars(trim($params['search_name'])) : '';
		$s_type = isset($params['search_ptype']) ? intval($params['search_ptype']) : 0;
		$s_id = isset($params['search_id']) ? intval($params['search_id']) : 0;
		if (''!==$s_name) 
			$position->criteria->add(new Criteria('name', '%'.$s_name.'%', 'LIKE'));
		if (0!==$s_type) 
			$position->criteria->add(new Criteria('ptypeid', $s_type, '='));
        if (0!==$s_id)
            $position->criteria->add(new Criteria('posid', $s_id, '='));
		$position->criteria->setSort('listorder');
		$position->criteria->setOrder('ASC');
		$_PAGE['rows'] = $position->lists(30, $params['page']);
		$_PAGE['url_jumppage'] = $position->getPage();
		return array('_PAGE'=>$_PAGE);
	}
	//ɾ��
	public function del($params = array()){
	    $_OBJ['position'] = $this->load('position', 'system');
		if($_OBJ['position']->delete($params['posid'])) jieqi_jumppage($this->getAdminurl('position'));
		else jieqi_printfail();
	}
	//����
	public function order($params = array()){
	    $_OBJ['position'] = $this->load('position', 'system');
		if($this->submitcheck()){
			 if($_OBJ['position']->order($_OBJ['position']->order, $params['order'])){
			     //$_OBJ['position']->cache();//���»���
			     jieqi_jumppage($this->getAdminurl('position'));
			 }else jieqi_printfail();
		}
	}
	//���
	public function add($params = array()){
		//include_once(JIEQI_ROOT_PATH.'/class/blocks.php');
		//$blocks_handler =& JieqiBlocksHandler::getInstance('JieqiBlocksHandler');
		$this->db->init( 'blocks', 'bid', 'system' );
		$_OBJ['position'] = $this->load('position', 'system');
		//�ύ����
		if($this->submitcheck()){
		//print_r($params);exit;
			 //������Զ������飬�����ȴ���
			 /*if($_REQUEST['setting']['custom']){

				 if($block=$blocks_handler->get($_REQUEST['setting']['bid'])){
					 //�Զ�������
					 if($block->getVar('canedit')==1){
						 $block->setVar('content', $_REQUEST['setting']['content']);
					 }
				 }
				 if($blocks_handler->insert($block)){
				   $blocks_handler->saveContent($block->getVar('bid'), $block->getVar('modname'), JIEQI_CONTENT_HTML, $_REQUEST['setting']['content']);
				 }
				 $_REQUEST['setting']['content'] = '';
			 }*/
			 $data = $params['info'];
			 $data['setting'] = ($this->arrayeval($_REQUEST['setting']));
			 $data['ptypeid'] = intval($params['ptypeid']);
			 //addslashes_array
			 //��������
			 if($params['posid']){
				 $statu = $_OBJ['position']->edit($params['posid'],$data); //�޸�
				 $posid = $params['posid'];
			 }else{
				 $data['siteid'] = JIEQI_SITE_ID;
				 $statu = $_OBJ['position']->add($data);//����
				 $posid = $statu;
			 }
			 //��Ϣ
			 if($statu){
				//$_OBJ['position']->cacheOne($posid);
				jieqi_jumppage($this->getAdminurl('position'));
			 } else jieqi_printfail();
		}

		////////////////////////////�����//////////////////////////////
		//����޸�״̬
		if($params['posid']){
			 //��ȡ�޸���Ŀ����
			 $_SGLOBAL['position'] = $_OBJ['position']->get($params['posid']);
			 //print_r($_SGLOBAL['position']);exit;
		}else{//���״̬
			$_SGLOBAL['position']['type'] = $params['type'];
			if($_SGLOBAL['position']['type']!=2) $_SGLOBAL['position']['setting']['bid'] = $params['bid'];
		}
		if($params['step']){
			//������ݱ�
			//ȡ������
			$this->db->setCriteria(new Criteria('custom',0,'='));
			$this->db->criteria->setSort('weight');
			$this->db->criteria->setOrder('ASC');
			$this->db->queryObjects($criteria);
			$blockary = array();
			while($v = $this->db->getObject()){
				$blockary[$k]['bid']=$v->getVar('bid');
				$blockary[$k]['blockname']=$v->getVar('blockname');
				$blockary[$k]['modname']=$v->getVar('modname', 'n');
				//$blockary[$k]['side']=$blocks_handler->getSide($v->getVar('side', 'n'));
				$blockary[$k]['weight']=$v->getVar('weight');
				//$blockary[$k]['weight']=$v->getVar('weight');
				//$blockary[$k]['template']=$blocks_handler->getPublish($v->getVar('template', 'n'));
				$k++;
			}
			$_PAGE['block'] = $blockary;
		}
			if($_SGLOBAL['position']['type']==1){//��ѯ����
			     $this->db->setCriteria(new Criteria('bid', $_SGLOBAL['position']['setting']['bid']));
				 if(($block = $this->db->get($this->db->criteria))){//echo $_SGLOBAL['position']['setting']['bid'];
					 //$_SGLOBAL['position']['setting'] = array();
					 foreach($block->vars as $k=>$v){
						 if(in_array($k,array('template', 'vars')) && $params['posid']) continue;
						 $_SGLOBAL['position']['setting'][$k] = $block->getVar($k,'n');
					 }
					 //$_SGLOBAL['position']['setting']['filename'] = $block->getVar('filename','n');
					 //$_SGLOBAL['position']['setting']['description'] = $block->getVar('description','n');
					 $_SGLOBAL['position']['setting']['module'] = $block->getVar('modname','n');
				 }
			}

		//����Ĭ������Ȩֵ
		$_SGLOBAL['position']['listorder'] = $_SGLOBAL['position']['listorder'] ?$_SGLOBAL['position']['listorder'] :'0';
		//����Ĭ��ģ��
		if(!$_SGLOBAL['position']['setting']['template']){
			switch($_SGLOBAL['position']['type']){
				case '2':
					 $_SGLOBAL['position']['setting']['template'] = 'block_content.html';
				break;
			}
		}
		return array('_PAGE'=>$_PAGE,'_SGLOBAL'=>$_SGLOBAL);
	}
}
?>