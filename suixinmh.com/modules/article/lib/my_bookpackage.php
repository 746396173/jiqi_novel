<?php
/**
 * ���ư����������ط���
 * @copyright Copyright(c) 2014
 * @author snowdiva
 * @version 1.0
 */
class Mybookpackage {
    
    public $db;
    
    /**
     * ���캯��ʹ�õ�������db����
     */
    function __construct() {
        if (! is_object ( $this->db )) {
            $this->db = Application::$_lib ['database'];
        }
    }
    
    /**
     * �ж��Ƿ�������Ķ�Ȩ��
     * @param type $articleid   ����id
     */
    public function is_bpuser($articleid, $uid) {
        if (!$articleid || intval($articleid)==0)
            return false;
//        $auth = $this->getAuth();
        $nowTime = time();
        $this->db->init('bookpackagesale', 'id', 'article');
        $this->db->setCriteria();
        $this->db->criteria->setFields('*');
        $this->db->criteria->add(new Criteria('accountid', $uid, '='));
        $this->db->criteria->add(new Criteria('bookid', '%"articleid":"'.$articleid.'",%', 'LIKE'));
        $this->db->criteria->add(new Criteria('endtime', $nowTime, '>='));
        $this->db->criteria->setLimit(1);
        $result = $this->db->lists();
        if (empty($result)) {
            return false;
        } else {
            return $result[0];
        }
    }
    
    /**
     * ����Ķ���¼
     * @param type $saleid      ���������¼id
     * @param type $bpid        ���id
     * @param type $chapterid   �½�id
     * @param type $uid         �û�id
     */
    public function add_bpclick($saleid, $bpid, $articleid, $chapterid, $uid, $uname) {
        $this->db->init('bookpackagestat', 'id', 'article');
        $this->db->setCriteria();
        $this->db->criteria->add(new Criteria('bpid', $bpid, '='));
        $this->db->criteria->add(new Criteria('bpsaleid', $saleid, '='));
        $this->db->criteria->add(new Criteria('articleid', $articleid, '='));
        $this->db->criteria->add(new Criteria('accountid', $uid, '='));
        $this->db->criteria->add(new Criteria('chapterid', $chapterid, '='));
        $res = $this->db->lists();
        if (empty($res)) {
            $addData = array(
                'bpid'                  => $bpid,
                'articleid'             => $articleid,
                'bpsaleid'              => $saleid,
                'accountid'             => $uid,
                'accountname'           => $uname,
                'chapterid'             => $chapterid,
                'clicktime'             => time()
            );
            if ($this->db->add($addData))
                return true;
        }
    }
}