<?php
/**
 * api collect interface
 * @author chengyuan  2014-8-21
 */
interface iCollect
{
	/**
	 * �ɼ����������ƥ�䱾�ص����ID,ʵ����ĸ����ṩһ����Ĭ��ʵ�֣�ʵ������Ը��������д��
	 * @param unknown $sort
	 * @return sortid
	 * 2014-8-21 ����3:30:29
	 */
	public function getLocalSortId($sort,$channel);
	/**
	 * ��ȡ�ɼ�վ��ͱ�վ�ķ����Ӧ��ϵ����Ӧ��վ����shortcaption����
	 *
	 * 2014-8-25 ����2:28:56
	 * 
	 * modify by chengyuan 2015-7-28 ͨ���������û�ȡ
	 */
// 	public function getSortMapping();

	/**
	 * �ɼ������б�
	 * <p>
	 * ÿ�������Ĳɼ��б��ʽ������ͬ���е�ֻ��������ţ��������е�����ϸ��Ϣ
	 * <p>
	 * ����������ӿ��ṩ�����鼮��ϸ��Ϣ���򷽷�ʵ�ֵ���articleList���ɡ�
	 * @param unknown $cid		����Id
	 * @param unknown $page		��ҳ
	 */
	public function collectList($cid,$page);
	/**
	 * collectList�ӿڵ����·�װ�ӿ�
	 * @param unknown $item
	 * @param unknown $channel
	 */
	public function simplePackingArticle($item,$channel);
	/**
	 * ��ȡ�����ڵĲɼ�������ϸ��Ϣ�б�
	 * @param unknown $cid
	 * @param unknown $page
	 * @return array('rows'=>array('articleid'=>article,'articleid'=>article....),'channel'=>$channel)
	 * 2014-8-21 ����3:53:38
	 */
	public function articleList($cid,$page,$aids=array());
	/**
	 * ����urlָ����xml�½��б�ΪArray����ͨ��$lastchapteridָ���ϴθ���λ�á�
	 * @param unknown $url				�½��б�url��xml�ļ�
	 * @param number $lastchapterid		�ϴθ��µ����½�ID��Ĭ��0
	 */
	public function parseChapters($url,$lastchapterid=0);

	/**
	 * ��װ��article
	 * @param unknown $item
	 * @param unknown $channel
	 * 2014-8-21 ����3:46:15
	 */
	public function packingArticle($item,$channel,$loadLocalArticle = true);
	/**
	 * ��װparseChapters�ӿڽ�����Array��Ϊchapter��ʽ�����飬ͳһ����������ʽ
	 * @param unknown $item
	 * 2014-8-22 ����9:39:06
	 */
	public function packingChapter($item);

}
?>