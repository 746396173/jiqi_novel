<?php
//�ױ�yeepay֧����ز���

$jieqiPayset['yeepay_wap']['callbackurl']='http://m.mmread.com/pay/yeepay_notify';  //�̻���̨ϵͳ�ص���ַ

$jieqiPayset['yeepay_wap']['fcallbackurl']='http://m.mmread.com/pay/checkyeepay';  //�̻�ǰ̨ϵͳ�ص���ַ

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ��Ҳ��Ǯ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['yeepay_wap']['paylimit']=array(
//		'2'=>'0.02', 
		'2000'=>'20', 
		'3500'=>'30',
		'6000'=>'50', 
		'11500'=>'100', 
		'22000'=>'200', 
		'55000'=>'500'
		);
		
$jieqiPayset['yeepay_wap']['subject']=array(
//	'1'=>'1�ֲ���', 
//	'500'=>'5:00', 
	'2000'=>'$20', 
	'3500'=>'$30', 
	'6000'=>'$50', 
	'11500'=>'$100', 
	'22000'=>'$200', 
	'55000'=>'$500'
	);

$jieqiPayset['yeepay_wap']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['yeepay_wap']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ����

$jieqiPayset['yeepay_wap']['paytype']='�ױ�һ��';

$jieqiPayset['yeepay_wap']['addvars']=array();  //���Ӳ���

?>