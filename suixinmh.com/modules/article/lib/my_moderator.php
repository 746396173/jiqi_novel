<?php
/**
 * 
 * ������������ҵ����
 * @copyright Copyright(c) 2014
 * @author chengyuan
 * @version 1.0
 */
class MyModerator extends Model {
	/**
	 * ָ���û��Ƿ��ǰ���
	 * @author chengyuan 2015-6-10 ����10:38:07
	 * @param unknown $aid
	 * @param unknown $uid
	 * @return boolean
	 */
	public function isModerator($aid,$uid){
		$this->db->init('moderator', 'mid', 'article' );
		$this->db->setCriteria(new Criteria('articleid',$aid));
		$this->db->criteria->add(new Criteria('uid',$uid));
		$this->db->criteria->add(new Criteria('state',0));
		return $this->db->getCount($this->db->criteria) ? true : false;
	}
	
	/**
	 * �Ƴ�����
	 * @author chengyuan 2015-6-9 ����5:24:42
	 * @param unknown $mid
	 */
	public function removeModerator($mid){
		$this->db->init('moderator', 'mid', 'article');
		return $this->db->delete($mid);
	}
	/**
	 * ����Ϊ����ҵ������
	 * <p>
	 * �����������Ƿ��ǰ���
	 * <p>
	 * ����auditdate,state=0
	 * @author chengyuan 2015-6-9 ����3:37:14
	 * @param unknown $mid
	 */
	public function setModerator($aid,$mid){
		if($mid){
			$moderatorInfo = $this->moderatorInfo($aid);
			if(count($moderatorInfo) == 2){
				$this->printfail('ÿ�����޶�2��������');
			}else{
				$this->db->init('moderator', 'mid', 'article' );
				$apply = $this->db->get($mid);
				if($apply){
					if($apply['uid'] == $moderatorInfo['uid']){
						$this->printfail('��ǰ�������Ѿ��ǰ�����');
					}else{
						return $this->db->edit($mid,array("auditdate"=>JIEQI_NOW_TIME,"state"=>0));
					}
				}
			}
		}
		return false;
	}
	/**
	 * ����ɾ��������ID����
	 * @author chengyuan 2015-6-9 ����3:08:09
	 * @param unknown $idsArray
	 * @return boolean
	 */
	public function delByIds($idsArray){
		if(!is_array($idsArray)){
			$idsArray = array($idsArray);
		}
		if(count($idsArray) > 0){
			$this->db->init('moderator', 'mid', 'article' );
			$this->db->setCriteria(new Criteria('mid', '('.implode(',',$idsArray).')', 'IN'));
			return $this->db->delete($this->db->criteria);
		}
		return true;
	}
	/**
	 * ��ȡ�鼮�İ�����Ϣ
	 * @author chengyuan 2015-6-9 ����9:31:00
	 * @param unknown $aid
	 * @return moderatorInfoArr
	 */
	public function moderatorInfo($aid){
		$this->db->init('moderator', 'mid', 'article' );
		$this->db->setCriteria(new Criteria('articleid',$aid));
		$this->db->criteria->add(new Criteria('state',0));
		$moderatorInfoArr = $this->db->lists(2);
		return $moderatorInfoArr;
	}
	public function applyModeratorInfo($aid,$page=0){
		$this->db->init('moderator', 'mid', 'article' );
		$this->db->setCriteria(new Criteria('articleid',$aid));
		$this->db->criteria->add(new Criteria('state',1));
		$data = array();
		$data['applyModerators'] = $this->db->lists(10,$page,JIEQI_PAGE_TAG);
		$data['url_jumppage']=$this->db->getPage();
		return $data;
	}
	/**
	 * ���������ҵ������
	 * <p>
	 * �������������麣���е��鼮��permission=4��
	 * @author chengyuan 2015-6-8 ����2:13:15
	 * @param unknown $aid
	 */
	public function applyModerator($aid){
		$auth = $this->getAuth();
		if($auth['uid']>0){
			$articleLib = $this->load ( 'article','article' );
			$article = $articleLib->isExists($aid);
			if($article['permission'] == 4){
				$moderatorInfoArr = $this->moderatorInfo($aid);
				//��������2��
				if(count($moderatorInfoArr) < 2){
					if(count($moderatorInfoArr) == 1 && $moderatorInfoArr[0]['uid'] == $auth['uid']){
						$this->msgbox('','��ǰ�������Ѿ��ǰ�����');//��ǰ��¼�û��Ƿ��Ѿ������˰���
					}else{
						//����֮��ֻ������һ�ΰ���
						$this->db->init('moderator', 'mid', 'article' );
						$this->db->setCriteria(new Criteria('articleid',$article['articleid']));
						$this->db->criteria->add(new Criteria('uid',$auth['uid']));
						$this->db->criteria->add(new Criteria('applydate',strtotime("-3 days"),'>='));//�����ڵ������¼
						$this->db->criteria->add(new Criteria('state',1));
						if($this->db->getCount($this->db->criteria)){
							$this->msgbox('','ÿ3��ֻ������һ�ΰ�����');
						}else{
							//�޸�applydate
							$applydateCriteria = $this->db->criteria->criteriaElements[2];
							$applydateCriteria->operator='<';
							$result = false;
							if($this->db->getCount($this->db->criteria)){
								//������ǰ�������¼�������޸�ʱ��
								$this->db->queryObjects($this->db->criteria);
								$applyInfo = $this->db->getObject();
								$result = $this->db->edit($applyInfo->getVar('mid'),array("applydate"=>JIEQI_NOW_TIME));
							}else{
								$moderator = array();
								$moderator['articleid'] = $article['articleid'];
								$moderator['uid'] = $auth['uid'];
								$moderator['uname'] = $auth['username'];
								$moderator['applydate'] = JIEQI_NOW_TIME;
								$moderator['auditdate'] = 0;
								$moderator['state'] = 1;
								$result = $this->db->add($moderator);
							}
							if($result){
								$this->msgbox('','�Ѿ�֪ͨ���ߣ���˽�����ᷢ�͵���������վ�ڶ�Ϣ�С�');
							}else{
								$this->printfail(LANG_DO_FAILURE);
							}
						}
					}
				}else{
					$this->msgbox('','ÿ�����޶�2��������');
				}
			}else{
				$this->msgbox('','���������������麣�����鼮��');
			}
		}else{
			$this->printfail('',LANG_NEED_LOGIN);
		}
	}
}
?>