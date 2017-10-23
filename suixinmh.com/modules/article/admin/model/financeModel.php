<?php
/**
 * ������Ϣҵ��ģ��
 * @author chengyuan
 *
 */
class financeModel extends Model{
	/**
	 * uersext�м�¼���߲�����Ϣ
	 * @param unknown $params
	 * @return multitype:Ambigous <number, unknown>
	 */
	public function main($params){
		$data = array();
		$this->db->init('usersextapply','ueaid','system');
		$this->db->setCriteria();
		if(isset($params['flag'])){
			//0���� 1ͨ�� 2�ܾ�
			$this->db->criteria->add(new Criteria('state',$params['flag']));
		}
		$this->db->criteria->setSort('applydate');
		$this->db->criteria->setOrder('DESC');
		$data['rows'] = $this->db->lists (30, $params['page']);
		$data ['url_jumppage'] = $this->db->getPage ();
		$data['flag']=isset($params['flag'])?$params['flag']:'';
		//�������Ȩ��
		$this->addConfig('article','power');
		$data['authfinance']=$this->checkpower($this->getConfig('article','power','authfinance'), $this->getUsersStatus (), $this->getUsersGroup (), true);
		return $data;
	}
	/**
	 * ��ȡָ���û��Ĳ�����Ϣ
	 * @param unknown $copyrightid
	 */
	public function getFinance($ueid){
		if($ueid){
			$this->db->init('usersext','ueid','system');
			$this->db->setCriteria(new Criteria('uid',$ueid));
			$this->db->queryObjects();
			$userext=$this->db->getObject();
			if(is_object($userext)){
				//����ת����
				foreach($userext->getVars() as $k=>$v){
					$finance[$k] = $userext->getVar($k,'n');
				}
				$this->msgbox('',$finance);
			}else{
				$this->printfail('���û�δ�Ǽǲ�����Ϣ');
			}
		}else{
			$this->printfail(LANG_ERROR_PARAMETER);
		}
	}
	/**
	 * ������߲�����Ϣ�޸�����
	 * @param unknown $ueaid �����¼id
	 * @param unknown $state ״̬��1ͨ����2�ܾ�
	 */
	public function audit($ueaid,$state){
		//�������Ȩ��
		$this->addConfig('article','power');
		if($this->checkpower($this->getConfig('article','power','authfinance'), $this->getUsersStatus (), $this->getUsersGroup (), true)){
			if($state == 1 || $state == 2){
				$this->db->init('usersextapply','ueaid','system');
				if($apply = $this->db->get($ueaid)){
					$auth = $this->getAuth();
					$apply['auditdate']=JIEQI_NOW_TIME;
					$apply['audituid']=$auth['uid'];
					$apply['audituname']=$auth['username'];
					$apply['state']=$state;
					if($this->db->edit($ueaid,$apply)){
						//����������߷�վ���ţ�֪ͨ��˽��
						if($state==1){
							$result = '���ͨ��';
							// 						$content = '���ͨ��,���Ĳ�����Ϣ�޸�������'.date('Y-m-d H:i',JIEQI_NOW_TIME).'���ͨ��������12Сʱ֮���޸Ĳ�����Ϣ������12Сʱ����Ҫ�������롣';
							$content = '���ͨ��,���Ĳ�����Ϣ�޸�������'.date('Y-m-d H:i',JIEQI_NOW_TIME).'���ͨ�����뾡���޸Ĳ�����Ϣ�Ա�֤����������';
						}else{
							$result = '��˾ܾ�';
							$content = '���ʧ�ܣ��ܾ��޸�';
						}
						$messageModel = $this->model('message','system');
						$messageModel->auditApproval($apply['applyuid'],$apply['applyuname'],'������Ϣ�޸�������',$content);
						$this->jumppage('','',$result.'���ѷ���վ����֪ͨ�����ˡ�');
					}else{
						$this->printfail(LANG_DO_FAILURE);
					}
				}else{
					$this->printfail(LANG_ERROR_PARAMETER);
				}
			}else{
				$this->printfail(LANG_ERROR_PARAMETER);
			}
		}else{
			$this->printfail(LANG_NO_PERMISSION);
		}
	}
}
?>