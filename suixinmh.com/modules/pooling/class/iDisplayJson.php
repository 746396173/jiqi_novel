<?php
/**
 * ���ݳ� �����ͣ�չʾ�����ݸ�ʽ��json �����ӿ�
 * <p>
//  * �˽ӿڶ��ˣ��鼮�б��ҳ���鼮�б��鼮���飬�½��б��½����ݽӿ�
 * @author chengyuan
 *
 */
interface iDisplayJson
{
	/**
	 * �鼮�б��ҳ�ӿ�
	 * <p>
	 * ����ʵ�ֽӿ�����������
	 * @param unknown $date
	 * @return $array
	 */
	public function articlePage($date);
	
	/**
	 * �鼮�б�ӿ�
	 * @param unknown $Array
	 */
	public function articleList($date);
	
	/**
	 * �鼮����ӿ�
	 * @param unknown $Array
	 */
	public function articleInfo($date);
	/**
	 * �½��б�
	 * @param unknown $Array
	 */
	public function chapterList($date);
	
	/**
	 * �½����ݽӿ�
	 * @param unknown $Array
	 */
	public function chapterContent($date);
}
?>