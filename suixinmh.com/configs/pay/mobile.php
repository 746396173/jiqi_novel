<?php
//���� �ƶ� ��Ҫ������֤��

$jieqiPayset['mobile']['spid']='999';//Spid

$jieqiPayset['mobile']['cpid']='1111111';//������id

$jieqiPayset['mobile']['appid']='222';//Ӧ��id

$jieqiPayset['mobile']['ctimid']='500101';//�Ʒ���id

$jieqiPayset['mobile']['passid']='333';//ͨ��id

$jieqiPayset['mobile']['channelcode']='444';//����code

$jieqiPayset['mobile']['callback']='http://3g.shuhai.com/pay/checkmobile';//ͬ��cp�Ķ�����ַ

$jieqiPayset['mobile']['forward']='http://3g.shuhai.com/pay/';//���ذ�ť��ת�ĵ�ַ

$jieqiPayset['mobile']['payurl']='http://pay3.miliroom.com:13579/H5/paymentUrlapi.do'; //�µ���ַ

$jieqiPayset['mobile']['paytype']='�ƶ���ֵ_��ʽ2';  //ȷ��֧������




//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ�Ľ�ǮҲ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['mobile']['paylimit']=array(
		'38'=>1,
		'380'=>10,
		'780'=>20//,
//		'1200'=>30
);

$jieqiPayset['mobile']['service_provider']=array(
		'1'=>'�ƶ�',
		'2'=>'��ͨ',
		'3'=>'����' //�ݲ�֧��
);


$jieqiPayset['mobile']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ
$jieqiPayset['mobile']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ��ֵ������

//$logName	= "paypal.log";
?>