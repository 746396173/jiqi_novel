<?php
//����ͨwftpay֧���������

$jieqiPayset['wftpay']['service']='pay.weixin.scancode';	//�ӿ�����
$jieqiPayset['wftpay']['version']='1.1';				//�汾��
$jieqiPayset['wftpay']['mch_id']='008702901170001';  //�̻���
$jieqiPayset['wftpay']['body']=array(
	'1000'=>'�麣��10Ԫ��ֵ', 
	'2000'=>'�麣��20Ԫ��ֵ', 
	'5000'=>'�麣��50Ԫ��ֵ', 
	'10000'=>'�麣��100Ԫ��ֵ', 
	'22500'=>'�麣��200Ԫ��ֵ', 
	'55800'=>'�麣��500Ԫ��ֵ', 
	'112000'=>'�麣��1000Ԫ��ֵ'
	);
$jieqiPayset['wftpay']['notify_url']='http://www.shuhai.com/pay/checkwftpay'; //֪ͨ��ַ
$jieqiPayset['wftpay']['payurl']='https://pay.swiftpass.cn/pay/gateway';  //����url
$jieqiPayset['wftpay']['sign']='93982e32f55dc73f9065425fde749570';  //��Կֵ



//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ��Ҳ��Ǯ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['wftpay']['paylimit']=array('1000'=>'10', '2000'=>'20', '5000'=>'50', '10000'=>'100', '22500'=>'200', '55800'=>'500', '112000'=>'1000');

//֧�����ӻ���
$jieqiPayset['wftpay']['payscore']=array('1000'=>'500','2000'=>'1000', '5000'=>'2500', '10000'=>'5000', '22500'=>'10000', '55800'=>'25000', '112000'=>'50000');

$jieqiPayset['wftpay']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['wftpay']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ����

?>