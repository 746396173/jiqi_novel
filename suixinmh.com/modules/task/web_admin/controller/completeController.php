<?php
/**
 * ������ɲ�ѯ�б�
 * @author liuxiangbin  2015-02-02
 *
 */
class completeController extends Admin_controller {
	public $template_name = 'complete_list';
	
	/**
	 * ���б�
	 */
	public function main($params = array()) {
		// ʵ��ģ��
		$completeModel = $this->model('complete');
		$taskModel = $this->model('task');
		// ��ȡ���������б�
		$data = $completeModel->getAllData($params);
		$data['types'] = $taskModel->getTypesLists();
//		$this->dump($data);
		$this->display($data);
	}
	
}
