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
		if($param['flag'] == 'shuquan'){
			$this->db->init('shuquan','sid','system');
			$this->db->setCriteria(new Criteria('uid', $auth['uid']));
			$data['rows'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG);
			foreach($data['rows'] as $k=>$v){
				$data['rows'][$k] = $v;
			}
		}else{
			$this->db->init('paylog','payid','pay');
			$this->db->setCriteria(new Criteria('buyid', $auth['uid']));
			if($param['flag'] == 'success'){
				$this->db->criteria->add(new Criteria('payflag', 1));
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
		}
		// ����ҳ����ת
		$data ['url_jumppage'] = $this->db->getPage($this->getUrl(JIEQI_MODULE_NAME,'userhub','evalpage=0','SYS=method=czView&flag='.$param['flag']));
		$data['flag'] = $param['flag'];
		$data['source'] = array(0 => 'VIP��������',1=> '����ǩ������',2 => '�������ѷ���',3=> '�μ�ָ���',4 => '����ǩԼ����');
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
        $sale_table=sprintf("sale_%02d",$auth['uid']%100);
        $this->db->init($sale_table,'saleid','article');
        $this->db->setCriteria(new Criteria('accountid', $auth['uid']));
// 		$this->db->criteria->add ( new Criteria ( 'mid', '(\'sale\',\'reward\')', 'IN' ));
// 		$this->db->criteria->add ( new Criteria ( 'mid', 'reward', '=' ), 'OR' );

        $q = jieqi_dbprefix('article_'.$sale_table).' c LEFT JOIN '.jieqi_dbprefix('article_chapter').' a ON c.chapterid=a.chapterid';
        $this->db->criteria->setTables($q);
		$this->db->criteria->setFields('c.*,a.articlename,a.chaptername');



        //$p='[prepage]<a rel="nofollow" href="\'{$prepage}\'" >��һҳ</a>[/prepage][pages][pnum]6[/pnum][pnumchar] <em class="b">{$page}</em>[/pnumchar][pnumurl]<A href="\'{$pnumurl}\'" >{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]<a href="\'{$nextpage}\'" >��һҳ</a>[/nextpage]';
// 		$p='[prepage]<a rel="nofollow" href="{$prepage}" >��һҳ</a>[/prepage][pages][pnum]6[/pnum][pnumchar] <em class="b">{$page}</em>[/pnumchar][pnumurl]<A href="{$pnumurl}" >{$pagenum}</A>[/pnumurl]{$pages}[/pages][nextpage]<a href="{$nextpage}">��һҳ</a>[/nextpage]';



        $this->db->criteria->setSort('saleid');
        $this->db->criteria->setOrder('DESC');
        $this->addConfig('system','configs');
        $jieqiConfigs['system'] = $this->getConfig('system','configs');
// 		$jieqiConfigs['system']['messagepnum'] = 1;
        $data ['pay'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG);
        // ����ҳ����ת
        $data ['url_jumppage'] = $this->db->getPage($this->getUrl(JIEQI_MODULE_NAME,'userhub','evalpage=0','SYS=method=xfView'));
        $articleLib = $this->load('article','article');
        foreach($data ['pay'] as $k=>$v){
            $data ['pay'][$k] = $articleLib->article_vars($v);
        }
        return $data;
    }
	/*
	 * �������ģ���ȡ��ȯ�б���ͼ
	 */
	public function getShuquanView($param){
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		$auth = $this->getAuth();
		$this->db->init('shuquan','sid','system');
		$this->db->setCriteria(new Criteria('uid', $auth['uid']));
		$data['rownum'] = $this->db->getCount($this->db->criteria); //��ѯ��ȯ����
		$data['rows'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG); //�б�
		$data ['url_jumppage'] = $this->db->getPage($this->getUrl('system','userhub','evalpage=0','SYS=method=receiveBookC')); //��ҳ����
		$data['source'] = array(0 => 'VIP��������',1=> '����ǩ������',2 => '�������ѷ���',3=> '�μ�ָ���',4 => '����ǩԼ����'); //��ȯ��Դ�������б���ʾ
		
		//��ѯ����ȡ��ȯ
		unset($this->db->criteria);
		$this->db->setCriteria(new Criteria('uid', $auth['uid']));
		$this->db->criteria->add(new Criteria ( 'getflag', 0));
		$data['flagcount'] = $this->db->getCount($this->db->criteria);
		//print_r($data);
		return $data;
	}
	/*
	 * ��ȡ��ȯ����
	 */
	public function getShuquan($param){
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		$this->addLang('pay', 'pay');
		$jieqiLang['pay'] = $this->getLang('pay'); //�������԰����ø�ֵ
		$auth = $this->getAuth();
		$this->db->init('shuquan','sid','system');
		$this->db->setCriteria(new Criteria('sid', $param['sid']));
		$shuquan=$this->db->get($this->db->criteria);
		if(is_object($shuquan)){//��ѯ��һ������
			$stat=$shuquan->getVar('stat');
			$flag=$shuquan->getVar('getflag');
			if($flag == 0){//δ��ȡ
				if(!$this->db->edit($param['sid'], array('getflag'=>1))){//����flag���ɹ�
					$this->printfail('��ȡʧ��');
				}else{//����flag�ɹ�
					$this->db->init('users','uid','system');
					$this->db->setCriteria(new Criteria('uid', $auth['uid']));
					$user=$this->db->get($this->db->criteria);
					$esilver = $user->getVar('esilver') + $stat;
					if(!$this->db->edit($auth['uid'], array('esilver'=>$esilver))){//������ȯ���ɹ�
						$this->printfail('����ʧ��');
					}else{//������ȯ�ɹ�
						$this->msgwin(LANG_DO_SUCCESS,'��ȡ�ɹ�');
					}
				}
			}else{//����ȡ
				$this->printfail('����ȡ');
			}
		}else{//û������
			$this->printfail('��������');
		}
	}
	//������
/* 	public function shujuan($param){
		$this->addConfig('system','configs');
		$jieqiConfigs['system'] = $this->getConfig('system','configs');
		$auth = $this->getAuth();
		$this->db->init('users','uid','system');
		$this->db->setCriteria(new Criteria('uid', $auth['uid']));
		$data['rows'] = $this->db->lists ($jieqiConfigs['system']['messagepnum'], $param['page'],JIEQI_PAGE_TAG);
		$data['esilver'] = $data['rows'][0]['esilver'];
		return $data;
	} */
	
	/*
	 * ��ѯ�����ѽ����������ڴ�����
	 */
    function xiaofei(){
        $auth = $this->getAuth();
        $sale_table=sprintf("sale_%02d",$auth['uid']%100);
        $this->db->init($sale_table,'saleid','article');
        $this->db->setCriteria(new Criteria('accountid', $auth['uid']));
        $data['xfnum'] = $this->db->getCount();
        $data['xfegold'] = $this->db->getSum('saleprice');
        $data['xfegold'] = sprintf("%1\$.2f",$data['xfegold']);
        return $data;
    }
}
?>