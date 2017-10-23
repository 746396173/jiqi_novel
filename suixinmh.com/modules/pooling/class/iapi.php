<?php
/**
 * api�ӿڣ�������api��Ҫʵ�ִ˽ӿ�
 * @author chengyuan  2014-6-27
 *
 */
interface iApi
{
	/**
	 * �������������ݳص�����
	 * @param unknown $channleid	����ID
	 * @param unknown $article			���ݳ�����
	 * 2014-7-1 ����9:17:14
	 */
	public function push($channleid,$article);
	/**
	 * URL����
	 * @param unknown $url
	 * @param unknown $mode
	 * @param unknown $params
	 * @param string $header
	 * 2014-7-3 ����11:36:21
	 */
	public function request($url, $mode, $params=array(),$header = 'Content-Type: text/plain; charset=utf-8;');
	/**
	 * ��ȡ������������Ϣ
	 * @param unknown $articleid	��������ID
	 * 2014-7-2 ����10:18:12
	 */
	public function get_lastupdate($articleid);
	/**
	 * ��������
	 * @param unknown $articleid	���͵����±�վid
	 * @param unknown $data			������Ϣ
	 * 2014-7-2 ����10:24:47
	 */
	public function addBook($articleid,$data);
	/**
	 * ����һ���½�
	 * @param unknown $message
	 * 2014-7-3 ����10:05:58
	 */
	public function addChapter($message);
}
?>