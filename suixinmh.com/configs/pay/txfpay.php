<?php
/*$jieqiPayset['txfpay']['apiinfo'] = array(
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
	"return_page"=>"http://w.shuhai.com/pay/checkpaypal",  //֧���ɹ�����
	"cancel_page"=>"http://w.shuhai.com/pay/paypal",  //ȡ��֧������
);
*/
$jieqiPayset['txfpay']['paytype']='���ų�ֵ';  //ȷ��֧������

$jieqiPayset['txfpay']['payurl']='http://pay.tianxiafu.cn/DirectFillAction';//http://pay.tianxiafu.cn/DirectFillAction';  //�ύ���Է�����ַ//http://pay.tianxiafu.cn/txf_xezf/DirectFillAction

$jieqiPayset['txfpay']['return_page']='http://www.shuhai.com/pay/checktxfpay';  //֧���ɹ�����

//$jieqiPayset['txfpay']['return_wap']='http://wap.shuhai.com/pay/checktxfpay';  //wap��֪ͨ��ַ

$jieqiPayset['txfpay']['merchant_no']=527;//�����̻���

//$jieqiPayset['txfpay']['merchant_no_wap']=573;//wap���̻���

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ�Ľ�ǮҲ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['txfpay']['paylimit']=array(
		'380'=>10,
		'780'=>20,
		'1200'=>30
);
$jieqiPayset['txfpay']['product_id']=array(
		'380'=>527001,
		'780'=>527002,
		'1200'=>527003
);
/*$jieqiPayset['txfpay']['payscore']=array(
		'5400'=>'3000',
		'10800'=>'6000',
		'27000'=>'15000', 
		'54000'=>'30000', 
		'108000'=>'60000',  
		'270000'=>'150000'
);
$jieqiPayset['txfpay']['exchange_rate']=6;  //��Ԫ������һ���
*/
$jieqiPayset['txfpay']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ
$jieqiPayset['txfpay']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ��ֵ������

//$logName	= "paypal.log";
?>