<?php
//$jieqiPayset['telecom']['Productsid']=527;//�����̻���

$jieqiPayset['telecom']['orderkey']='a1b2c3';//key
$jieqiPayset['telecom']['callbackkey']='q1w2e3';//key

$jieqiPayset['telecom']['paytype']='�����ֻ���ֵ';  //ȷ��֧������

$jieqiPayset['telecom']['payurl']='http://ctucard.800617.com:8002/get.asp'; //�µ���ַ

//$jieqiPayset['telecom']['return_page']='http://www.shuhai.com/pay/checktelecom';  //֧���ɹ�����

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ�Ľ�ǮҲ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['telecom']['paylimit']=array(
//		'38'=>1,
		'400'=>10,
		'800'=>20//,
//		'1200'=>30
);
$jieqiPayset['telecom']['product_id']=array(
		'400'=>7010,
		'800'=>7020//,
//		'1200'=>527003
);
$jieqiPayset['telecom']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ
$jieqiPayset['telecom']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ��ֵ������

//$logName	= "paypal.log";
?>