<?php
$jieqiPayset['txfpay']['paytype']='���ų�ֵ';  //ȷ��֧������

$jieqiPayset['txfpay']['payurl']='http://pay.tianxiafu.cn/DirectFillAction';//http://pay.tianxiafu.cn/DirectFillAction';  //�ύ���Է�����ַ//http://pay.tianxiafu.cn/txf_xezf/DirectFillAction

$jieqiPayset['txfpay']['return_wap']='http://wap.shuhai.com/pay/checktxfpay';  //wap��֪ͨ��ַ

$jieqiPayset['txfpay']['merchant_no_wap']=573;//wap���̻���

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ�Ľ�ǮҲ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['txfpay']['paylimit']=array(
//		'76'=>2,
//		'114'=>3,
		'190'=>5,
		'380'=>10,
		'780'=>20,
		'1200'=>30
);
$jieqiPayset['txfpay']['product_id']=array(
//		'76'=>573001,
//		'114'=>573005,
		'190'=>573006,
		'380'=>573002,
		'780'=>573003,
		'1200'=>573004
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