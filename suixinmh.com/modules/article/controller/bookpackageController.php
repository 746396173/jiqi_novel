<?php
/**
 * �������������������б�
 * @author by: liuxiangbin
 * @createtime : 2014-12-10
 */
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
class bookpackageController extends Controller {
    
    public $template_name = 'bookpackagelist';
    // �����������
    public $caching = false;
//  public $theme_dir = false;
//  public $cacheid = 'snow_bookpackage';
//    public $cachetime = 5;
    
    /**
     * ��������б�Ĭ�Ϸ�����
     * @param type $params
     */
    public function main($params = array()) {
        $data = array();
        $page = $this->getRequest('page');
        if (!$page)
            $page = 1;
        $this->setCacheid($page);
        if (!$this->is_cached()) {
            $bpinfoModel = $this->model('bookpackage');
            $bpsaleModel = $this->model('bookpackagesale');
            $data = $bpinfoModel->getBookpackageList($params, false);
            $data['commends'] = $bpinfoModel->commendsBookpackageList($params, true);
            $data['rankbp'] = $bpsaleModel->getRankBp();
            // ��Ƶ����
            $temp = $bpinfoModel->siteBookpackageList($params, 0);
            $data['bpmalelist'] = $temp['lists'];
            $data['male_jumppage'] = $temp['url_jumppage'];
            // ŮƵ����
            $temp = $bpinfoModel->siteBookpackageList($params, 100);
            $data['bpfemalelist'] = $temp['lists'];
            $data['female_jumppage'] = $temp['url_jumppage'];
        }
        $this->display($data);
    }
    
    /**
     * �����������չʾҳ
     * @param type $params
     */
    public function showbookpackage($params = array()) {
        if (!isset($params['bpid'])) {
            jieqi_printfail('�Բ��𣬸���������ڣ�', $this->geturl('article', 'bookpackage', 'SYS=method=main'));
        }
        $bpinfoModel = $this->model('bookpackage');
        $bpsaleModel = $this->model('bookpackagesale');
        $temp = $bpinfoModel->getBookpackageInfo($params);
        $data['bpinfo'] = $temp[0];
        $data['commends'] = $bpinfoModel->commendsBookpackageList();
        $data['rankbp'] = $bpsaleModel->getRankBp();
        // �����鼮����
        $this->addConfig('article', 'sort');
        $data['sortname'] = $this->getConfig('article', 'sort');
//		$this->dump($data);
        $this->display($data, 'bookpackageinfo');
    }
    
    /**
     * ������¹����¼���ҵ������
     * @param type $params
     */
    public function mybookpackage($params = array()) {
        $bpsaleModel = $this->model('bookpackagesale');
        $data['records'] = $bpsaleModel->getMyBookpackage($params);
        $this->display($data, 'bookpackagebuy');
    }
    
    /**
     * ����һ�����
     * @param type $params
     */
    public function buybookpackage($params = array()) {
//        $this->checklogin();
        $bpsaleModel = $this->model('bookpackagesale');
        $bpsaleModel->buy_one_bp($params);
    }
    
    /**
     * ��ȡ�û��˻���Ϣ
     * @param type $params
     */
    public function get_user_info($params = array()) {
        $this->checklogin();
        $bpsaleModel = $this->model('bookpackagesale');
        // �첽��������
        $bpsaleModel->get_user_money($params);
    }
}