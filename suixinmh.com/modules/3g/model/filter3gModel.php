<?php
/**
 * ҵ���߼�ģ�ͣ�����Ӧ�κ����ݿ�
 * @author liuxiangbin
 * @create 2015-04-02 14:19:06
 */
class filter3gModel extends Model {
	
	// Ĭ��ѡ������
//	protected $default_v = 0;
	
	private $size = array(
					0=>array('text'=>'ȫ��'),
					1=>array('text'=>'30������'),
					2=>array('text'=>'30��-50��'),
					3=>array('text'=>'50��-100��'),
					4=>array('text'=>'100��-200��'),
					5=>array('text'=>'200������'),
			);
	private $operate = array(
					0=>array('text'=>'Ĭ��'),
					1=>array('text'=>'����'),
//					2=>array('text'=>'�ܵ��'),
//					3=>array('text'=>'�µ��'),
					4=>array('text'=>'���'),
//					5=>array('text'=>'���ղ�'),
//					6=>array('text'=>'���ղ�'),
					7=>array('text'=>'�ղ�'),
					8=>array('text'=>'����')
			);
	private $free = array(
					0=>array('text'=>'����'),
					1=>array('text'=>'ֻ�����'),
					2=>array('text'=>'ֻ��VIP')
			);

	/**
	 * ����3g���е�����ʽ
	 */
	public function getOperate() {
		return $this->operate;
	}
}
