<?php
$jieqiPayset['paypal']['apiinfo'] = array(
//�����˺�
// 	'api_username' => 'business_api1.sh.com',
// 	'api_password' => 'BAWXRFAUEV38RJWT',
// 	'pai_signatuer' => 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-A1AR7NRT7OwDIcqcCdfHRlQEWw7P',
	
	//��ʽ�˺�
	'api_username' => 'lyhblue_api1.qq.com',
	'api_password' => 'RF7N3W4YJBJCSHAK',
	'pai_signatuer' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AEt2GtISi.lYXRBhATJJeTol5Wc8',
		
	"currency"=>"USD",  //����
	"desc"=>'shuhai coin',  //��Ʒ����
	
	//���Ե�ַ
// 	"return_page"=>"http://shuhai.ikusoo.net/modules/pay/paypal_return.php",  //֧���ɹ�����
// 	"cancel_page"=>"http://shuhai.ikusoo.net/modules/pay/buyegold.php?t=paypal",  //ȡ��֧������
	
	//��ʽ��ַ
	"return_page"=>"http://www.shuhai.com/pay/checkpaypal",  //֧���ɹ�����
	"cancel_page"=>"http://www.shuhai.com/pay/paypal",  //ȡ��֧������
);

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ�Ľ�ǮҲ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['paypal']['paylimit']=array(
		'5400'=>'10',
		'10800'=>'20',
		'27000'=>'50', 
		'54000'=>'100', 
		'108000'=>'200',  
		'270000'=>'500'
);
$jieqiPayset['paypal']['payscore']=array(
		'5400'=>'3000',
		'10800'=>'6000',
		'27000'=>'15000', 
		'54000'=>'30000', 
		'108000'=>'60000',  
		'270000'=>'150000'
);
$jieqiPayset['paypal']['exchange_rate']=6;  //��Ԫ������һ���
$jieqiPayset['paypal']['moneytype']='1';  //0 ����� 1��ʾ��Ԫ
$jieqiPayset['paypal']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ��ֵ������

$logName	= "paypal.log";
?>