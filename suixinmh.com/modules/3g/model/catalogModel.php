<?php
/**
 * Ŀ¼ҵ��ģ��
 * @author chengyuan  2014-8-6
 *
 */
class catalogModel extends Model {
	/**
	 * ��ȡĿ¼�б�
	 * @param unknown $articleid
	 * @param string $obj
	 * 2014-8-6 ����3:26:28
	 */
	public function catalogList($articleid,$order,$page) {
		$package = $this->load ( 'articleWap', '3g' );
		$data = $package->article_vars($v);//article���ֶεĸ�ʽ��
		if (!$package->loadOPF ( $articleid )) {
			$this->addLang ( 'article', 'article' );
			$jieqiLang ['article'] = $this->getLang ( 'article' ); // �������԰����ø�ֵ
			$this->printfail ( $jieqiLang ['article'] ['article_not_exists'] );
		}
		$data = $package->getCatalog ($order,$page);
		return $data;
// 		return $package->showIndex ( $obj );
	}
	
	/**
	 * ����ҳʹ�õ�Ŀ¼�б�
	 */
	public function getLists($articleid, $pageCounts = 20, $order = 'asc') {
		$package = $this->load ( 'articleWap', '3g' );
		$data = $package->article_vars($v);//article���ֶεĸ�ʽ��
		if (!$package->loadOPF ( $articleid )) {
			$this->addLang ( 'article', 'article' );
			$jieqiLang ['article'] = $this->getLang ( 'article' ); // �������԰����ø�ֵ
			$this->printfail ( $jieqiLang ['article'] ['article_not_exists'] );
		}
		$data = $package->getCatalog ($order, 1, $pageCounts);
		return $data;
	}
}

?>