<?php
/**
 * ���������̨�����������
 * @auther by: liuxiangbin
 * @createtime : 2014-12-12
 */
class bookpackagemanageController extends Admin_controller {
    public $template_name = 'bookpackagemanage';
    
    public function __construct() {
        parent::__construct();
//        echo 'start';die;
        $this->checkpower('manageallarticle');
    }
    
    /**
     * �����������ҳ�����
     * @param type $params
     */
    public function main($params = array()) {
//        $this->dump($_REQUEST['method']);
        // ��ҳ�������õ�ǰҳ��
//        $params['thismethod'] = 'main';
//        $this->dump($params, 0);
        $data = array();
        $bpinfoModel = $this->model('bookpackage', 'article');
        $data = $bpinfoModel->getBookpackageList($params, true);
        // ���Ƶ���б�
        $package = $this->load('article', 'article');
        $tempData = $package->getSources();
        $data['channel'] = $tempData['channel'];
        $this->display($data);
    }
    
    /**
     * ���������Ŀ�����
     * @param type $params
     */
    public function add_bp($params = array()) {
        $data = array();
        // ���Ƶ���б�
        $package = $this->load('article', 'article');
        $tempData = $package->getSources();
        $data['channel'] = $tempData['channel'];
        $sortModel = $this->model('bookpackagesort', 'article');
        $data['bpsort'] = $sortModel->get_bosort($params);
        $this->display($data, 'addbookpackage');
    }
    
    /**
     * ���������Ŀ�����
     * @param type $params
     */
    public function add_newbp($params = array()) {
        $data = array();
        $bpinfoModel = $this->model('bookpackage', 'article');
        if ($bpinfoModel->add_new_bp($params)) {
            $this->jumppage($this->getAdminurl().'&method=main', LANG_DO_SUCCESS, '�����ӳɹ�:)');
        } else {
            $this->jumppage($this->getAdminurl().'&method=add_bp', LANG_DO_FAILURE, '������ʧ��:(');
        }
    }
    
    /**
     * �༭���������
     * @param type $params
     */
    public function edit_bp($params = array()) {
//        $this->dump($params);
        $data = array();
        $bpinfoModel = $this->model('bookpackage', 'article');
        $temp = $bpinfoModel->getBookpackageInfo($params, true);
        $data['bpinfo'] = $temp[0];
        // ���Ƶ���б�
        $package = $this->load('article', 'article');
        $tempData = $package->getSources();
        $data['channel'] = $tempData['channel'];
        $sortModel = $this->model('bookpackagesort', 'article');
        $data['bpsort'] = $sortModel->get_bosort($params);
//        $this->dump($temp);
        $this->display($data, 'editbookpackage');
    }
    
    /**
     * ����������ݵ��м������
     * @param type $parasm
     */
    public function edit_bpinfo($params = array()) {
        $data = array();
        $bpinfoModel = $this->model('bookpackage', 'article');
        if ($bpinfoModel->update_one_bp($params)) {
            $this->jumppage($this->getAdminurl().'&method=main', LANG_DO_SUCCESS, '������³ɹ�:)');
        } else {
            $this->jumppage($this->getAdminurl().'&method=edit_bp&id='.$params['id'], LANG_DO_FAILURE, '�������ʧ��:(');
        }
    }
    
    /**
     * �첽��ʽ����һ��������鼮��ϸ
     * @param type $params
     */
    public function show_on_bp($params) {
        $data = array();
        $bpinfoModel = $this->model('bookpackage', 'article');
        $result = $bpinfoModel->get_one_bpinfo($params);
        if (!$result) {
            $data['status'] = '400';
        } else {
            $data['status'] = '200';
            $data['list'] = $result;
        }
        echo $this->json_encode($data);
        die;
    }
    
    /**
     * �첽��ʽɾ��һ�����
     * @param type $params
     */
    public function del_on_bp($params) {
        $data = array();
        $bpinfoModel = $this->model('bookpackage', 'article');
        $result = $bpinfoModel->del_bpinfo($params);
        echo $this->json_encode($result);
        die;
    }
    
    /**
     * �첽��ѯ����鼮�б�
     * @param type $params
     */
    public function search_book_id($params = array()) {
        $data = array();
        $bpinfoModel = $this->model('bookpackage', 'article');
        $result = $bpinfoModel->get_book_ids($params);
//        $this->msgbox('', $result);
    }
    
    /**
     * �ж��鼮�Ƿ�������
     * @param type $params
     * @return type
     */
    public function check_exist_book($params = array()) {
        $bpinfoModel = $this->model('bookpackage', 'article');
        $result = $bpinfoModel->_check_book_exist($params['bookid']);
        echo $this->json_encode($result);
        die;
    }
    
    /**
     * �����������ͳ��ҳ�����
     * @param type $params
     */
    public function bpsalecount($params = array()) {
        $data = array();
        $bpsaleModel = $this->model('bookpackagesale', 'article');
        $data = $bpsaleModel->getAllBp($params);
        $this->display($data, 'bookpackagecount');
    }
    
    /**
     * �첽��������¼�е�����ķ���
     * @param type $params
     */
    public function search_click($params = array()) {
        $data = array();
        $bpsaleModel = $this->model('bookpackagesale', 'article');
        $data = $bpsaleModel->get_one_clicks($params);
        if ($data) {
            jieqi_msgbox('', $data);
        } else {
            jieqi_printfail();
        }
    }
    
    /**
     * �Ķ�������Ŀ��Ʒ���
     * @param type $params
     */
    public function bpclick($params = array()) {
        $data = array();
        $bpsaleModel = $this->model('bookpackagesale', 'article');
        $data = $bpsaleModel->get_all_click($params);
        $this->display($data, 'bookpackageclick');
    }
}
