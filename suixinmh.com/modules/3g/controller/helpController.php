<?php
/*����������*/ 
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate'); 
class helpController extends chief_controller {
	public $theme_dir = false;
	public function main(){
		// ��ʼ������
		$helpno = isset($_GET['helpno']) ? intval($_GET['helpno']) : 1000;
		$data['helpno'] = $helpno;
		$this->display($data);
	}
} 
?>
