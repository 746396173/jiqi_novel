<?php
include_once (JIEQI_ROOT_PATH . '/lib/my_cachetable.php');//�����������ݱ�����
/**
 * jieqi_article_mute������ݿ�����໺����
 * @author chengyuan 2015-5-19 ����1:59:33
 */
class MyMute extends Mycachetable{
	/**
	 * ���캯��
	 * 
	 * @param      void       
	 * @access     private
	 * @return     void
	 */
	function MyMute(){
	     $this->init('mute', 'muteid', 'article');
	}
}
?>