<?php
/**
 * ���ݳ��½�ͬ���ӿ�
 * <p>
 * ��������ġ��½ڡ�ѡ�����ݳ�,��ô��Ҫʵ�ִ˽ӿڡ�
 * @author chengyuan
 *
 */
interface iSynchronization
{
	/**
	 * ��ͬ��apiͬ���½�ʱ������½ڵ����ƣ����ݵ��в�ͬ�ĸ�ʽҪ��ͨ���˽ӿڴ���
	 * <p>
	 * ����api������ʵ�ִ˷���
	 * @param unknown $chapter		���ݳ��½����飨���ô��ݣ�
	 */
	public function handlePoolChapter(&$poolChapter);
}
?>