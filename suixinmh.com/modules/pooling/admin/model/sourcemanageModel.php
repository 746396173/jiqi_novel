<?php
/**
 * ��ֵ�ֳ���������
 * @author chengyuan  2014-6-12
 *
 */
class sourcemanageModel extends Model{
		
	/**
	 * ���һ����¼
	 */
	public function setData($params, $setType = 'add'){
		// ���Ϊ�޸Ĳ������sid���г�ʼ��
		if ($setType == 'edit') {
			if (!isset($params['sid']) || intval($params['sid'])==0) {
				$this->printfail('ȱ�ٲ���');
			} else {
				$this_sid = intval($params['sid']);
			}
		}
		$setData = array();
		// ����֤
		if (trim($params['sname'])=='' || mb_strlen($params['sname'], 'GBK')>25) 
			$this->printfail('�ύ��Ϣ����1');
		if (trim($params['markname'])=='' || mb_strlen($params['markname'], 'GBK')>25) 
			$this->printfail('�ύ��Ϣ����2');
		if (trim($params['name'])=='' || mb_strlen($params['name'], 'GBK')>25) 
			$this->printfail('�ύ��Ϣ����3');
		if (intval($params['compos'])<0 || intval($params['compos'])>99) 
			$this->printfail('�ύ��Ϣ����4');
		$setData = array(
			'sname'				=> trim($params['sname']),
			'markname'			=> trim($params['markname']),
			'name'				=> trim($params['name']),
			'compositor'			=> intval($params['compos']),
			'locked'				=> intval($params['locked'])
		);
		// �������ݿ�(��Ҫ�������)
		$cacheLib = $this->load('cachetable', 'system');
		$cacheLib->init('sources', 'sid', 'pooling', 'compositor');
		if ($setType == 'add') {
			$setData['password'] = $this->createCode();
			$setData['createtime'] = JIEQI_NOW_TIME;
			// ���û���
			$cacheLib->add($setData);
			$this->msgbox('');
			die;
		} elseif ($setType == 'edit') {
			$cacheLib->edit($this_sid, $setData);
			$this->msgbox('');
			die;
		} else {
			$this->printfail('ģ�Ͳ�������');
		}
	}
	
	/**
	 * ���һ����¼
	 */
	public function getOneData($params){
		// ������֤
		if (!isset($params['sid']) || intval($params['sid'])==0) {
			$this->printfail('ȱ�ٲ���');
		} else {
			$this_sid = intval($params['sid']);
		}
		$this->db->init('sources', 'sid', 'pooling');
		$this->db->setCriteria();
		$this->db->criteria->add(new Criteria('sid', $this_sid, '='));
		$res = $this->db->lists();
		if (empty($res))
			$this->printfail('��������');
		return $res[0];
	}
	
	/**
	 * ɾ��һ����¼
	 * @param			: Boo	Ĭ�ϼ�-locked���ã���-ɾ������
	 */
	public function delData($params, $true_del = false){
		// ������֤
		if (!isset($params['sid']) || intval($params['sid'])==0) {
			$this->printfail('ȱ�ٲ���');
		} else {
			$this_sid = intval($params['sid']);
		}
		$cacheLib = $this->load('cachetable', 'system');
		$cacheLib->init('sources', 'sid', 'pooling', 'compositor');
		// �ж��Ƿ�Ϊɾ�����ݿ����ݣ�����ʹ�ñ��ɾ����
		if ($true_del) {
			$cacheLib->delete($this_sid);
			$this->msgbox('');
			die;
		} else {
			$setData['locked'] = 99;
			$cacheLib->edit($this_sid, $setData);
			$this->msgbox('');
			die;
		}
		// ���û���κβ�������ʾʧ��
		$this->printfail('���д���');
	}
	
	/**
	 * ��������б�
	 */
	public function getDataList($params){
		// �����ҳ����
		$this->addConfig('article','configs');
    		$jieqiConfigs['article'] = $this->getConfig('article', 'configs');
		$pagenum = $jieqiConfigs['article']['pagenum'];
		$thisPage = intval($params['page'])<=0 ? 1 : $params['page'];
		$this->db->init('sources', 'sid', 'pooling');
		$this->db->setCriteria();
		// ���α��ɾ��������
		$this->db->criteria->add(new Criteria('locked', 99, '<>'));
		// ��������
		if (isset($params['keyword']) && trim($params['keyword'])!='') {
			$this->db->criteria->add(new Criteria($params['searchkey'], '%'.$params['keyword'].'%', 'LIKE'));
		}
		$this->db->criteria->setSort('compositor');
//		$this->db->criteria->setOrder('ASC');
//		$this->db->criteria->setFields('sid,sname,markname,name,password,compositor,createtime');
		$thisController = ($_REQUEST['controller']) ? $_REQUEST['controller'] : 'sources';
		$data['lists'] = $this->db->lists($pagenum, $thisPage, JIEQI_PAGE_TAG);
		$data['url_jumppage'] = $this->db->getPage($this->getUrl(JIEQI_MODULE_NAME, $thisController,'evalpage=0','SYS=method='.$methodName));
		return $data;
	}
	
	/**
	 * ��������
	 */
	public function setOrder($params) {
		// ���û���
		$cacheLib = $this->load('cachetable', 'system');
		$cacheLib->init('sources', 'sid', 'pooling', 'compositor');
		foreach ($params as $k => $v) {
			if (preg_match('/^sid_/', $k)) {
				$this_key = array_pop(array_filter(explode('_', $k)));
				$this_val = (intval($v)>=0||intval($v)<=99) ? intval($v) : 0;
				$cacheLib->edit($this_key, array('compositor'=>$this_val));
			}
		}
		$this->msgbox('');
	}
	
	/**
	 * ���������
	 * @param			: String ��ü�λ�ĵ�½��
	 */
	protected function createCode($codeNumber = 8) {
		$chars = array(
            'Q', '@', '8', 'y', '%', '^', '5', 'Z', '(', 'G', '_', 'O', '`',
            'S', '-', 'N', '<', 'D', '{', '}', '[', ']', 'h', ';', 'W', '.',
            '/', '|', ':', '1', 'E', 'L', '4', '&', '6', '7', '#', '9', 'a',
            'A', 'b', 'B', '~', 'C', 'd', '>', 'e', '2', 'f', 'P', 'g', ')',
            '?', 'H', 'i', 'X', 'U', 'J', 'k', 'r', 'l', '3', 't', 'M', 'n',
            '=', 'o', '+', 'p', 'F', 'q', '!', 'K', 'R', 's', 'c', 'm', 'T',
            'v', 'j', 'u', 'V', 'w', ',', 'x', 'I', '$', 'Y', 'z', '*'
        );
        $strlen = count($chars) - 1;
        $tmpstr = '';
        for ($i = 0; $i < 32; $i++) {
            $tmpstr .= $chars[mt_rand(0, $strlen)];
            $tmpstr .= $tokenstr;
        }
        $tmpstr .= sha1(microtime());
        $tmpstr = md5($tmpstr . time());
        $strnumber = strlen($tmpstr);
        $randnum = mt_rand(0, $strnumber-$codeNumber);
        $code = substr($tmpstr, $randnum, $codeNumber);
        return $code;
	}
}
?>
	