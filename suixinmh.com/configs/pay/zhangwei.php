<?php
$jieqiPayset['zhangwei']['app_id']='13';//�̻���� 

$jieqiPayset['zhangwei']['pType']='1';  //���ͣ��̶�ֵ

$jieqiPayset['zhangwei']['product_id']=array( //��Ʒ����
		'400'=>140000010,
		'800'=>140000020
);

$jieqiPayset['zhangwei']['cm']='M2040075';//��������

$jieqiPayset['zhangwei']['Notify_Url']='http://3g.shuhai.com/pay/zhangwei_notify'; //�첽֪ͨ��ַ

$jieqiPayset['zhangwei']['Return_Url']='http://3g.shuhai.com/pay/checkzhangwei';  //ͬ����ת��ַ

$jieqiPayset['zhangwei']['payurl']='http://gateway.zw88.net/v1/Pay/getway'; //�µ���ַ

//ҳ���ʽ��1����棬2���ʰ棬3�������棬4��XML ��Ӧ��Ĭ��Ϊ��2 

$jieqiPayset['zhangwei']['access_key']='PKwWJyP1HGrbH8nEiCmrWHExTPgGahcq';//����ӿ���Կ

$jieqiPayset['zhangwei']['secret_key']='sKbmys1kG4rk7JUWTZHyHhxwPTXNgzq';//�첽֪ͨ��Կ

$jieqiPayset['zhangwei']['checkurl']='http://gateway.zw88.net/v1/Pay/Verify';//��֤��ַ

$jieqiPayset['zhangwei']['paytype']='�ƶ��ֻ���ֵ';  //ȷ��֧������





//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ�Ľ�ǮҲ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['zhangwei']['paylimit']=array(
		'400'=>10,
		'800'=>20
);

$jieqiPayset['zhangwei']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ
$jieqiPayset['zhangwei']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ��ֵ������

//$logName	= "paypal.log";
?>