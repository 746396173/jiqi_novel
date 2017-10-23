<?php 
/** 
 * ���» * @copyright   Copyright(c) 2014 
 * @author      huliming* @version     1.0 
 */
class huodongController extends chief_controller
{

	public $template_name = 'huodong';
	public $caching = false;
	public $theme_dir = false;

	public function __construct()
	{
		parent::__construct();
		//����½
		$this->checklogin(false, false, JIEQI_MODULE_NAME);
	}

	//�Ƽ�
	public function vote($params = array())
	{
		$dataObj = $this->model('huodong', 'article');
		$params['nosubmitcheck'] = true;

        $result = $dataObj->vote($params);
        if ($result['stat']) {
            $result['msg'] = iconv("gbk","utf-8",$result['msg']);
            echo json_encode($result);
        } else {
            $this->display($result);
        }
	}

	//����
	public function reward($params = array())
	{
		$dataObj = $this->model('huodong', 'article');
		$params['nosubmitcheck'] = true;
		$data = $dataObj->reward($params);
		//print_r($data);
		$this->display($data);
	}

	//��Ʊ
	public function vipvote($params = array())
	{
		$dataObj = $this->model('huodong', 'article');
		$params['nosubmitcheck'] = true;
		$result = $dataObj->vipvote($params);
		if ($result['stat']) {
            $result['msg'] = iconv("gbk","utf-8",$result['msg']);
			echo json_encode($result);
		} else {
			$this->display($dataObj->vipvote($params));
		}
	}

	//�������
	function addBookCase($params = array())
	{
		$dataObj = $this->model('huodong', 'article');
		$dataObj->addBookCase($params);
	}

	function lunpan($params) {
        $this->printfail('Ŀǰû�л');
		$dataObj = $this->model('huodong', 'article');
        $this->display($dataObj->lunpan($params),'turntable');

//        if ($params['action']) {
//            echo json_encode(array(
//                "stat" => "succ",
//                "num" => rand(1, 8),
//				"times" => 9,
//                "msg" => iconv("gbk", "utf-8", "��ϲ���н���")
//            ));
//            exit();
//        }
//        else {
//			$params['times'] = 10;
//			$params['list']=array(
//				array('info'=>'��������1888��ȯ'),
//				array('info'=>'��������888��ȯ'),
//				array('info'=>'��������168��ȯ')
//			);
//            $this->display($params,'turntable');
//
//        }
	}

    function newyear($params) {
		$this->printfail('Ŀǰû�л');
        $this->display($params,'active');
    }

    function dati($params) {
        $this->printfail('Ŀǰû�л');
        $dataObj = $this->model('huodong', 'article');
        $this->display($dataObj->dati($params),'dati');
        $this->display(array(),'dati');
    }

//    function paytest($params) {
//        $auth=$this->getAuth();
//        $mod=$this->model('pay');
//        $mod->insert_activity(array(
//            'uid'=>$auth['uid'],
//            'money'=>5000
//        ));
//        echo 'ok';
//    }
} 
?>