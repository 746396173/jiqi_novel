<?php
/*
    *�����������ݱ�����
	[HLM CMS] (C) 2009-2014 Cms Inc.
	$Id: my_cachetable.php 12398 2014-05-04 15:26:38Z huliming $
*/
include_once (JIEQI_ROOT_PATH . '/lib/my_cachetable.php');
class MyTag extends Mycachetable{
	/**
	 * ���캯��
	 * 
	 * @param      void       
	 * @access     private
	 * @return     void
	 */
	function MyTag(){
	     $this->init('tag', 'tagid', 'article');
	}
}
?>