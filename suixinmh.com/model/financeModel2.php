<?php 
/**
 * �û�����->�����¼
 * @author chengyuan  2014-5-6
 *
 */
class financeModel extends Model{
	/**
	 * ��ȡ��ǰ��¼�û��ĳ�ֵ��¼
	 */
	public function rechargeLog($param){
		if(empty($param['flag'])){
			$param['flag'] = 'all';
		}
		$this->addConfig('pay','paytype');
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		$data = array();
		$auth = $this->getAuth();
		$this->db->init('paylog','payid','pay');
		$this->db->setCriteria(new Criteria('buyid', $auth['uid']));
		if($param['flag'] == 'success'){
			$this->db->criteria->add(new Criteria('payflag', 1));
		}
		if($param['start']){
			$this->db->criteria->add(new Criteria('buytime',$param['start'],'>='));
		}
		if($param['end']){
			$this->db->criteria->add(new Criteria('buytime',$param['end'],'<'));
		}
		$this->db->criteria->setSort('payid');
		$this->db->criteria->setOrder('DESC');
		$data['nowmsgnum'] = $this->db->getCount();
		$data['totalegold'] = $this->db->getSum('egold');
		$data ['paylog'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG);
		foreach($data['paylog'] as $k=>$v){
			$v['money'] = sprintf('%0.2f',$v['money']/100);
			$data['paylog'][$k] = $v;
		}
		// ����ҳ����ת
		$data ['url_jumppage'] = $this->db->getPage($this->getUrl('system','userhub','evalpage=0','SYS=method=czView&flag='.$param['flag']));
		$data['flag'] = $param['flag'];
		$data['maxmsgnum'] = $jieqiConfigs['system']['messagepnum'];
		//֧�����ͣ������ļ�
		$data['paytype'] = $this->getConfig('pay','paytype');
		return $data;
	}
	/**
	 * ���Ѽ�¼���麣��ʹ�ü�¼
	 * @param unknown $param
	 */
	public function pay($param){
		$auth = $this->getAuth();
		$this->db->init('sale','saleid','article');
		$this->db->setCriteria(new Criteria('accountid', $auth['uid']));
// 		$this->db->criteria->add ( new Criteria ( 'mid', '(\'sale\',\'reward\')', 'IN' ));
// 		$this->db->criteria->add ( new Criteria ( 'mid', 'reward', '=' ), 'OR' );

		
// 		$this->db->criteria->setTables(jieqi_dbprefix('article_statlog').' c LEFT JOIN '.jieqi_dbprefix('article_article').' a ON c.articleid=a.articleid');
// 		$this->db->criteria->setFields('c.*,a.lastchapterid,a.lastchapter');
		
		
		
		//$p='[prepage]<a rel="nofollow" href="\'{$prepage}\'" >��һҳ</a>[/prepage][pages][pnum]6[/pnum][pnumchar] <em class="b">{$page}</em>[/pnumchar][pnumurl]<A href="\'{$pnumurl}\'" >{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]<a href="\'{$nextpage}\'" >��һҳ</a>[/nextpage]';
// 		$p='[prepage]<a rel="nofollow" href="{$prepage}" >��һҳ</a>[/prepage][pages][pnum]6[/pnum][pnumchar] <em class="b">{$page}</em>[/pnumchar][pnumurl]<A href="{$pnumurl}" >{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]<a href="{$nextpage}">��һҳ</a>[/nextpage]';
		
		
		
		$this->db->criteria->setSort('saleid');
		$this->db->criteria->setOrder('DESC');
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
// 		$jieqiConfigs['system']['messagepnum'] = 1;
		$data['xfnum1'] = $this->db->getCount();
		$data['page1'] = $param['page'];
		$data ['maxpage1'] = ceil($data['xfnum1']/$jieqiConfigs['system']['messagepnum']);
		$data ['pay'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG);
		// ����ҳ����ת
		$data ['url_jumppage'] = $this->db->getPage($this->getUrl('system','userhub','evalpage=0','SYS=method=xfView'));
		$articleLib = $this->load('article','article');
		foreach($data ['pay'] as $k=>$v){
			$data ['pay'][$k] = $articleLib->article_vars($v);
		}
		return $data;
	}
	/*
	 * ��ѯ�����ѽ����������ڴ�����
	 */
	function xiaofei(){
		$auth = $this->getAuth();
		$this->db->init('sale','saleid','article');
		$this->db->setCriteria(new Criteria('accountid', $auth['uid']));
		$data['xfnum'] = $this->db->getCount();
		$data['xfegold'] = $this->db->getSum('saleprice');
		return $data;
	}
}
?>