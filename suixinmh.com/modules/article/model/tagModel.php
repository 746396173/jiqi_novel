<?php 
/**
 * ��ǩҵ��ģ��
 * @author chengyuan  2014-4-24
 *
 */
class tagModel extends Model{
	/**
	 * ��ȡ$moduleָ��վ�ı�ǩ
	 * <p>
	 * ���$moduleΪ����ȡ�������ģ��
	 * @param unknown $siteid
	 * @return key:tagid value:array(tag)
	 */
	public function getTagByModule($module=null){
		$tag = array();
		global $jieqiModules;
		if($module == null){
			$module = JIEQI_MODULE_NAME; 
		}
		if($jieqiModules[$module]){
			$siteid = $jieqiModules[$module]['siteid'];
		}
// 		$this->db->init('tag','tagid','article');
		$tagCache = $this->load('tag', 'article');
		$tagCache->setCriteria(new Criteria('FIND_IN_SET('.$siteid, '',',siteid)'));
		$tagCache->criteria->setSort('tagid');
		$tagCache->queryObjects();
		$k = 0;
		while($v = $tagCache->getObject()){
			$tag[$v->getVar ( 'tagid', 'n' )]=array("id"=>$v->getVar ( 'tagid', 'n' ),'name'=>$v->getVar ( 'name', 'n' ));
			$k++;
		}
		return $tag;
	}
	
	/**
	 * ��ȡ����վ��ı�ǩ����
	 */
	public function getAllSiteTag(){
		$allTag = array();
// 		$this->db->init('tag','tagid','article');
		$tagCache = $this->load('tag', 'article');
		$tagCache->setCriteria();
		$tagCache->criteria->setSort('tagid');
		$tagCache->queryObjects();
		while($v = $tagCache->getObject()){
			$tag = array("id"=>$v->getVar ( 'tagid', 'n' ),'name'=>$v->getVar ( 'name', 'n' ));
			$siteid = $v->getVar ( 'siteid', 'n' );
			$siteid_array = explode(",",$siteid);
			foreach($siteid_array as $k=>$v){
				
				$allTag[$v][]=$tag;
				
// 				if(array_key_exists($v,$allTag)){
// 					$allTag[$v][]=$tag;
// 				}else{
					
// 				}
			}
		}
		return $allTag;
	}
} 
?>