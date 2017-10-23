<?php
include_once ($GLOBALS ['jieqiModules'] ['pooling'] ['path'] . '/lib/my_ycsd.php');
/**
 * �������ɼ��࣬�̳���ԭ����һ��api�ṩ�̵�����������xml��ģ���ʽ��ͬ��
 * @author chengyuan  2014-8-21
 *
 */
class MyYqsd extends MyYcsd{
	/**
	 * override
	 * @return string
	 * 2014-9-16 ����1:58:01
	 */
	protected function getBookListUrl(){
		return 'api.yqsd.cn/interface/shuhai/booklist/0';
	}
	/**
	 * override
	 * @return string
	 * 2014-9-16 ����1:58:01
	 */
	protected function getBookInfoUrl($bookId){
		return 'api.yqsd.cn/interface/shuhai/book/'.$bookId;
	}
	
	/**
	 * override
	 * @see MyCollectYcsd::getSortMapping()
	 */
// 	public function getSortMapping(){
// 		//todo ��ȫ�����Ӧ��ϵ
// 		return array(
// 				'�����ܲ�'=>'����',
// 				'�ഺУ԰'=>'����',
// 				'��Խ�ܿ�'=>'����',
// 				'��������'=>'����',
// 				'�������'=>'����',
// 				'��������'=>'����',
// 				'���и߸�'=>'����',
// 				'�ۺ�����'=>'����',
// 				'��������'=>'����',
// 				'��ʷ����'=>'��ʷ',
// 				'��������'=>'�ֲ�',
// 				'����ͬ��'=>'ͬ��'
// 		);
// 	}
}
?>