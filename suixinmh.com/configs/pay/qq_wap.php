<?php
//������QQ֧���������
$jieqiPayset['qq_wap']['customerid']='153953';	//�̻���
$jieqiPayset['qq_wap']['cardno']='36';	//֧����ʽ���̶�ֵ36
$jieqiPayset['qq_wap']['noticeurl']='http://m.ishufun.net/pay/qq_notify'; //�첽֪ͨ��ַ
$jieqiPayset['qq_wap']['backurl']='http://m.ishufun.net/pay/checkqq';  //�ص���ַ
$jieqiPayset['qq_wap']['key']='96ef7f8e7f5d3260b0457c103c69f36d';  //��Կ
$jieqiPayset['qq_wap']['payurl']='http://www.zhifuka.net/gateway/QQpay/QQpay.asp';  //΢���ֻ���ҳ ֧�������ַ

$jieqiPayset['qq_wap']['remarks']=array( //�̻��Զ�����Ϣ
//	'1'=>JIEQI_EGOLD_NAME.'1�ֲ���', 
//	'2000'=>JIEQI_EGOLD_NAME.'20Ԫ��ֵ', 
	'3000'=>JIEQI_EGOLD_NAME.'30Ԫ��ֵ',
	'5500'=>JIEQI_EGOLD_NAME.'50Ԫ��ֵ',
	'11200'=>JIEQI_EGOLD_NAME.'100Ԫ��ֵ',
	'23000'=>JIEQI_EGOLD_NAME.'200Ԫ��ֵ',
	'60000'=>JIEQI_EGOLD_NAME.'500Ԫ��ֵ',
	'125000'=>JIEQI_EGOLD_NAME.'1000Ԫ��ֵ'
);



//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ��Ҳ��Ǯ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
//$jieqiPayset['qq_wap']['paylimit']=array('1'=>'0.01', '2000'=>'20', '5000'=>'50', '10000'=>'100', '20000'=>'200', '50000'=>'500', '100000'=>'1000');
$jieqiPayset['qq_wap']['paylimit']=array(
//	'1'=>'0.01',
//	'500'=>'5',
//	'2000'=>'20', 
	'3000'=>'30',
	'5500'=>'50',
	'11200'=>'100',
	'23000'=>'200',
	'60000'=>'500',
	'125000'=>'1000'
);
//֧�����ӻ���
//$jieqiPayset['qq_wap']['payscore']=array('2000'=>'1000', '5000'=>'2500', '10000'=>'5000', '20000'=>'10000', '50000'=>'25000', '100000'=>'50000');

$jieqiPayset['qq_wap']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['qq_wap']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ����

?>