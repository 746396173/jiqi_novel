<?php
class userhuodongModel extends Model {
	public function sliver($params = array()) {
		$hid=1;
		$addsliver = 100;
        $auth = $this->getAuth();
        $uid = $auth['uid'];

        $this->db->init('huodong', 'id', 'system');
        $this->db->setCriteria(new Criteria('uid', $uid, '='));
        $this->db->criteria->add(new Criteria('hid', $hid, '='));
        $huodong = $this->db->get($this->db->criteria);
        //print_r($huodong);
        if ($huodong) {
            $this->printfail("�ܱ�Ǹ�����Ѿ���ȡ���ˣ������ظ���ȡŶ");
        }
        else {
            include_once(JIEQI_ROOT_PATH . '/class/users.php');
            $users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
            $users_handler->income($uid, $addsliver, 1, 0, 0);
            $time=time();
            $sql="insert into jieqi_system_huodong (hid,uid,hdate,source) values('$hid','$uid',$time,'0')";
            $this->db->query($sql, 0, 0, true);
            return array(
                'title'=>1,
                'readurl'=>'/user/userinfo',
                'msg'=>'���ѳɹ���ȡ'.$addsliver.'��ȯ��<br>�����������Ĳ鿴��ȯ���'
            );
        }
	}

    public function guoqing($params = array()) {
        $hid=3;
        $addsliver = rand(200,500);
        $auth = $this->getAuth();
        $uid = $auth['uid'];


        //print_r($huodong);
        $date=date("Y-m-d");
        if ($date < '2016-10-01' || $date>'2016-10-07') {
            $this->printfail("�ܱ�Ǹ�����ֻ�ڹ����1-7���ڼ俪��");
            return false;
        }

        $this->db->init('huodong', 'id', 'system');
        $this->db->setCriteria(new Criteria('uid', $uid, '='));
        $this->db->criteria->add(new Criteria('hid', $hid, '='));


        $huodong = $this->db->get($this->db->criteria);
        if ($huodong) {
            $this->printfail("�ܱ�Ǹ�����Ѿ���ȡ���ˣ������ظ���ȡŶ");
            return false;
        }
        else {
            include_once(JIEQI_ROOT_PATH . '/class/users.php');
            $users_handler =& JieqiUsersHandler::getInstance('JieqiUsersHandler');
            $users_handler->income($uid, $addsliver, 1, 0, 0);
            $time=time();
            $sql="insert into jieqi_system_huodong (hid,uid,hdate,source) values('$hid','$uid',$time,'0')";
            $this->db->query($sql, 0, 0, true);
            return array(
                'title'=>1,
                'readurl'=>'/user/userinfo',
                'msg'=>'���ѳɹ���ȡ'.$addsliver.'��ȯ��<br>�����������Ĳ鿴��ȯ���'
            );
        }
    }
}






?>