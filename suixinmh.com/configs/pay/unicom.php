<?php
//$jieqiPayset['unicom']['Productsid']=527;//�����̻���

$jieqiPayset['unicom']['orderkey']='a1b2c3';//key
$jieqiPayset['unicom']['callbackkey']='q1w2e3';//key

$jieqiPayset['unicom']['paytype']='��ͨ�ֻ���ֵ';  //ȷ��֧������

$jieqiPayset['unicom']['payurl']='http://ctucard.800617.com:8002/GetUnicom.asp'; //�µ���ַ

$jieqiPayset['unicom']['yanurl']='http://ctucard.800617.com:8002/VerificationUnicom.asp'; //��֤���ύ��ַ

//$jieqiPayset['unicom']['return_page']='http://www.shuhai.com/pay/checkunicom';  //֧���ɹ�����

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ�Ľ�ǮҲ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['unicom']['paylimit']=array(
//		'38'=>1,
		'400'=>10,
		'800'=>20//,
//		'1200'=>30
);
$jieqiPayset['unicom']['product_id']=array(
		'400'=>7110,
		'800'=>7120//,
//		'1200'=>527003
);
$jieqiPayset['unicom']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ
$jieqiPayset['unicom']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ��ֵ������

//$logName	= "paypal.log";
?>