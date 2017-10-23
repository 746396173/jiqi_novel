<?php
/**
 * �����б�ģ��
 * @author zhangxue
 *
 */
class shukuModel extends Model{
	/**
	 * ��ѯ������Ĭ��ֵ0�����ʾ����Ӵ˲�ѯ������
	 * @var unknown
	 */
	public $default_v = 0;
	/**
	 * װ�ز�ѯ����,ͳһ���ݸ�ʽ,֧�����ֲ�ѯ�����ֱ��ǣ����࣬���������ȣ���ʽ��״̬
	 * @param unknown $data
	 */
	private function container(&$data){
		$size = array(
				$this->default_v=>array('text'=>'ȫ��'),
				1=>array('text'=>'30������'),
				2=>array('text'=>'30��-50��'),
				3=>array('text'=>'50��-100��'),
				4=>array('text'=>'100��-200��'),
				5=>array('text'=>'200������'),
		);
		$operate = array(
				$this->default_v=>array('text'=>'Ĭ��'),
				1=>array('text'=>'������'),
				2=>array('text'=>'�ܵ��'),
				3=>array('text'=>'�µ��'),
				4=>array('text'=>'�ܵ��'),
				5=>array('text'=>'���ղ�'),
				6=>array('text'=>'���ղ�'),
				7=>array('text'=>'���ղ�'),
				8=>array('text'=>'������')
		);
		$free = array(
				$this->default_v=>array('text'=>'����'),
				1=>array('text'=>'ֻ�����'),
				2=>array('text'=>'ֻ��VIP')
		);
		$articleLib = $this->load('article','article');//�������´�����
		$sdata = $articleLib->getSources();
		array_unshift($sdata['fullflag']['items'],'ȫ��');//0ȫ�� 1������ 2�����
		//������װfullflag��ʽ
		foreach($sdata['fullflag']['items'] as $k=>$item){
			$data['fullflag'][$k] = array('text'=>$item);
		}
// 		array_unshift($sdata['sortrows'],array('shortcaption'=>'ȫ��'));//0ȫ�� 1������ 2�����
// 		$sdata['sortrows'] = array(0=>array('shortcaption'=>'ȫ��'))+$sdata['sortrows'];
		$sdata['sortrows'] = array(0=>array('shortcaption'=>'ȫ��','caption'=>'ȫ��'))+$sdata['sortrows'];
		$data['sort'] = $sdata['sortrows'];
		$data['channel'] = $sdata['channel']; 
		$data['size'] =$size;
		$data['operate'] =$operate;
		$data['free'] =$free;
		
		//ŮƵ��ӱ�ǩ��ѯ����
		if(JIEQI_MODULE_NAME == 'mm'){
			$tagObj = $this->model('tag','article');
			$data['tag'] = array(0=>array('id'=>'0','name'=>'ȫ��'))+$tagObj->getTagByModule();
		}
	}
	/**
	 * ��֤��ѯ��������Ч��
	 * @param unknown $params	���ô���
	 * 2014-7-18 ����9:47:56
	 */
	private function validate(&$params = array()){
		$default_v = 0;
		$query_data = array();
		$this->container($query_data);//װ�غϷ��Ĳ�ѯ����

		if(!array_key_exists($params['sort'],$query_data['sort'])){
			$params['sort'] = $default_v;
		}
		if(JIEQI_MODULE_NAME == 'mm' && !array_key_exists($params['tag'],$query_data['tag'])){
			$params['tag'] = $default_v;
		}
		if(!array_key_exists($params['size'],$query_data['size'])){
			$params['size'] = $default_v;
		}
		if(!array_key_exists($params['fullflag'],$query_data['fullflag'])){
			$params['fullflag'] = $default_v;
		}
		if(!array_key_exists($params['operate'],$query_data['operate'])){
			$params['operate'] = $default_v;
		}
		if(!array_key_exists($params['free'],$query_data['free'])){
			$params['free'] = $default_v;
		}
		if(!$params['listnum'] || ($params['listnum'] != 40 && $params['listnum'] != 50)){
			if (JIEQI_MODULE_NAME == 'wap' || JIEQI_MODULE_NAME == '3gwap' || JIEQI_MODULE_NAME == '3g'){
				$params['listnum'] = 15;
			} else {
				$params['listnum'] = 50;
			}
		}
		if(!$params['page'] || $params['page'] < 1) $params['page'] = 1;
		//on_list on_img
		if(!$params['topview'])$params['topview'] = 'on_list';
		return $query_data;
	}

	public function query($params = array()){
		global $jieqiModules;
		$data = $this->validate($params);
// 		$data = array();
// 		$this->container($data);
		$this->addConfig ( 'article', 'configs' );
		$jieqiConfigs ['article'] = $this->getConfig ( 'article', 'configs' );	//��������

		$package = $this->load('article','article');
		$this->db->init('article','articleid','article');
// 		$this->db->setCriteria(new Criteria ( 'a.siteid',JIEQI_SITE_ID, '=' ));
		$this->db->setCriteria();
		$this->db->criteria->add ( new Criteria ( 'a.display',0 ));
		$this->db->criteria->add ( new Criteria ( 'a.firstflag',13, '<>' ));
		$this->db->criteria->setSort('a.lastupdate');
		if($params['operate'] > 1){
			//���ϲ�ѯ
			$this->db->criteria->setTables($this->dbprefix('article_stat').' s RIGHT JOIN '.$this->dbprefix('article_article').' a ON s.articleid=a.articleid');
			$this->db->criteria->setFields('a.*,s.mid,s.total,s.month,s.week,s.day,s.lasttime');
		}else{
			//�����ѯ
			$this->db->criteria->setTables( $this->dbprefix('article_article').' a ');
			$this->db->criteria->setFields('a.*');
		}
		if($params['sort']){
			//ָ�����࣬��ͬ��Ƶ����ʾ��ǰƵ���ķ���
			$this->db->criteria->add(new Criteria('a.sortid',$params['sort'], '='));
		}
		if(JIEQI_MODULE_NAME == 'mm' && $params['tag']){
			//ŮƵָ����ǩ
			$this->db->criteria->add(new Criteria('FIND_IN_SET('.$params['tag'], '',',tag)'));
		}
		//ͨ��JIEQI_MODULE_NAMEָ��Ƶ�������û����ʹ��main��վƵ��
		//���
		if(array_key_exists(JIEQI_MODULE_NAME,$jieqiModules)){
			if (JIEQI_MODULE_NAME != 'wap' && JIEQI_MODULE_NAME != '3gwap' && JIEQI_MODULE_NAME != '3g' && JIEQI_MODULE_NAME != 'overseas'){
				$siteid = $jieqiModules[JIEQI_MODULE_NAME]['siteid'];
				//$this->db->criteria->add(new Criteria('a.siteid',$jieqiModules[JIEQI_MODULE_NAME]['siteid']));
			} else{
				if (isset($params['siteid'])){
					$siteid = $params['siteid'];
					//$this->db->criteria->add(new Criteria('a.siteid',$params['siteid']));
				}
			}
		}else{
			$siteid = $jieqiModules['system']['siteid'];
			//$this->db->criteria->add(new Criteria('a.siteid',$jieqiModules['system']['siteid']));
		}

		if (isset($siteid)){
			$this->db->criteria->add(new Criteria ( 'siteid',$siteid, '=' ));
		}

// 		if(JIEQI_MODULE_NAME == 'wenxue'){
// 			//��ѧƵ��
// 			$this->db->criteria->add(new Criteria('a.siteid','200'));
// 		}elseif(JIEQI_MODULE_NAME == 'girl'){
// 			//Ů��Ƶ��
// 			$this->db->criteria->add(new Criteria('a.siteid','100'));
// 		}else{
// 			//����Ƶ��-��վ
// 			$this->db->criteria->add(new Criteria('a.siteid',$channels['main']['siteid']));
// 		}
// 		if($params['sort']) $this->db->criteria->add(new Criteria('a.sortid',$params['sort'], '='));
		//����
		if($params['size']){
			if($params['size'] == 1){
				$this->db->criteria->add(new Criteria('a.size',300000*2, '<'));
			}elseif($params['size'] == 2){
				$this->db->criteria->add(new Criteria('a.size',300000*2, '>='));
				$this->db->criteria->add(new Criteria('a.size',500000*2, '<='));
			}elseif($params['size'] == 3){
				$this->db->criteria->add(new Criteria('a.size',500000*2, '>='));
				$this->db->criteria->add(new Criteria('a.size',1000000*2, '<='));
			}elseif($params['size'] == 4){
				$this->db->criteria->add(new Criteria('a.size',1000000*2, '>='));
				$this->db->criteria->add(new Criteria('a.size',2000000*2, '<='));
			}elseif($params['size'] == 5){
				$this->db->criteria->add(new Criteria('a.size',2000000*2, '>'));
			}
		}else{
			$this->db->criteria->add(new Criteria('a.size',0, '>'));
		}
		//����
		if($params['fullflag'] == 1)$this->db->criteria->add(new Criteria('a.fullflag',0, '='));//����
		elseif($params['fullflag'] == 2)$this->db->criteria->add(new Criteria('a.fullflag',1, '='));//�����
		//����ʽ
		if($params['operate'] == 1)$this->db->criteria->setSort('a.size');
		elseif ($params['operate'] == 2 ){
			$this->db->criteria->add(new Criteria('s.mid','visit', '='));
			$this->db->criteria->add ( new Criteria ( 's.lasttime',$this->getTime('week'), '>=' ));
			$this->db->criteria->setSort('s.week');
		}elseif ($params['operate'] == 3 ){
			$this->db->criteria->add(new Criteria('s.mid','visit', '='));
			$this->db->criteria->add ( new Criteria ( 's.lasttime',$this->getTime('month'), '>=' ));
			$this->db->criteria->setSort('s.month');
		}elseif ($params['operate'] == 4 ){
			$this->db->criteria->add(new Criteria('s.mid','visit', '='));
			$this->db->criteria->setSort('s.total');
		}elseif ($params['operate'] == 5 ){
			$this->db->criteria->add(new Criteria('s.mid','goodnum', '='));
			$this->db->criteria->add ( new Criteria ( 's.lasttime',$this->getTime('week'), '>=' ));
			$this->db->criteria->setSort('s.week');
		}elseif ($params['operate'] == 6 ){
			$this->db->criteria->add(new Criteria('s.mid','goodnum', '='));
			$this->db->criteria->add ( new Criteria ( 's.lasttime',$this->getTime('month'), '>=' ));
			$this->db->criteria->setSort('s.month');
		}elseif ($params['operate'] == 7 ){
			$this->db->criteria->add(new Criteria('s.mid','goodnum', '='));
			$this->db->criteria->setSort('s.total');
		}elseif ($params['operate'] == 8 ){
			$this->db->criteria->add(new Criteria('s.mid','sale', '='));
			$this->db->criteria->setSort('s.total');
		}
		//״̬
		if($params['free'] == 1)$this->db->criteria->add(new Criteria('a.articletype',0, '='));
		elseif($params['free'] == 2)$this->db->criteria->add(new Criteria('a.articletype',1, '='));
		$this->db->criteria->setOrder('DESC');


// 		$package = $this->load('article',false);//�������´�����
		$data ['articlerows'] = $this->db->lists ($params['listnum'], $params['page'],JIEQI_PAGE_TAG);
		$data ['maxpage'] = ceil($this->db->getVar('totalcount')/$params['listnum']);
		foreach($data ['articlerows'] as $k=>$v){
			$data ['articlerows'][$k] = $package->article_vars($v);
		}
		$prevpage=$params['page']>1?$params['page']-1:1;
		$nextpage=$params['page']<$data['maxpage']?$params['page']+1:$data['maxpage'];
		//urlʹ�����·��
		if (isset($params['siteid'])){
			$url =  parse_url($this->getUrl(JIEQI_MODULE_NAME,'shuku','evalpage=0','tag='.$params['tag'],'SYS=sort='.$params['sort'].'&size='.$params['size'].'&fullflag='.$params['fullflag'].'&operate='.$params['operate'].'&free='.$params['free'].'&page='.$params['page'].'&siteid='.$siteid));
			$url3gwap = parse_url($this->getUrl('article','shuku','SYS=sort='.$params['sort'].'&size='.$params['size'].'&fullflag='.$params['fullflag'].'&operate='.$params['operate'].'&free='.$params['free'].'&page='.$params['page'].'&siteid='.$siteid));
			$url3gwap_prev = parse_url($this->getUrl('article','shuku','SYS=sort='.$params['sort'].'&size='.$params['size'].'&fullflag='.$params['fullflag'].'&operate='.$params['operate'].'&free='.$params['free'].'&page='.$prevpage.'&siteid='.$siteid));
			$url3gwap_next = parse_url($this->getUrl('article','shuku','SYS=sort='.$params['sort'].'&size='.$params['size'].'&fullflag='.$params['fullflag'].'&operate='.$params['operate'].'&free='.$params['free'].'&page='.$nextpage.'&siteid='.$siteid));
		}else{
			$url =  parse_url($this->getUrl(JIEQI_MODULE_NAME,'shuku','tag='.$params['tag'],'evalpage=0','SYS=sort='.$params['sort'].'&size='.$params['size'].'&fullflag='.$params['fullflag'].'&operate='.$params['operate'].'&free='.$params['free'].'&page='.$params['page']));
			$url3gwap =      parse_url($this->getUrl('article','shuku','SYS=sort='.$params['sort'].'&size='.$params['size'].'&fullflag='.$params['fullflag'].'&operate='.$params['operate'].'&free='.$params['free'].'&page='.$params['page']));
			$url3gwap_prev = parse_url($this->getUrl('article','shuku','SYS=sort='.$params['sort'].'&size='.$params['size'].'&fullflag='.$params['fullflag'].'&operate='.$params['operate'].'&free='.$params['free'].'&page='.$prevpage));
			$url3gwap_next = parse_url($this->getUrl('article','shuku','SYS=sort='.$params['sort'].'&size='.$params['size'].'&fullflag='.$params['fullflag'].'&operate='.$params['operate'].'&free='.$params['free'].'&page='.$nextpage));
		}



// 		$data['chapter']['index_page'] = ($this->geturl('article', 'index', 'aid='.$this->id));//basename
		$data ['url_jumppage'] = $this->db->getPage ($url['path']);
		$data['sel_sort'] = $params['sort'];
		$data['sel_tag'] = $params['tag'];
		$data['sel_size'] = $params['size'];
		$data['sel_fullflag'] = $params['fullflag'];
		$data['sel_operate'] = $params['operate'];
		$data['sel_free'] = $params['free'];
		$data['topview'] = $params['topview'];
		$data['path'] = $url3gwap['path'];
		$data['prevpath'] = $url3gwap_prev['path'];
		$data['nextpath'] = $url3gwap_next['path'];
		$data['siteid'] = $params['siteid'];
		$data['page'] = $params['page'];
		//$isnextpage=$params['page'] - ceil($this->db->getVar('totalcount')/$params['listnum']) < 0? "true":"false";
		//ѡ�е��������,��������ȫ��
		if($data['sel_sort'] != 0){
			$data['sel_sort_name'] =$data['sort'][$data['sel_sort']]['shortcaption'];
			$data['sort_name'] =$data['sort'][$data['sel_sort']]['caption'];
		}
		return $data;
	}
}
?>