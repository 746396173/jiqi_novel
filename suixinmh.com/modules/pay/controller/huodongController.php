<?php 
/** 
 * ��ֵ���Ŀ����� * @copyright   Copyright(c) 2014 
 * @author      zhangxue* @version     1.0 
 */ 
class huodongController extends pay_controller { 

		//�麣��
        public function main($params = array()) {
			$this->theme_dir = false;
//		    global $jieqiPayset;
//	        jieqi_getconfigs('pay', 'alipay', 'jieqiPayset');
			//�ύ����
		    if($this->submitcheck()){
			    if($this->checklogin(true)){
					$dataObj = $this->model('huodong');
					$dataObj->main($params);
				}else{
					$this->printfail('���ȵ�¼��');
				}
			}
			$this->display($jieqiPayset['alipay'],'shcard');
        } 
} 
?>