<?php
//΢��֧��

$jieqiPayset['weixin']['customerid']='154156';//�̻�������ϵͳ�ϵ��̻���

$jieqiPayset['weixin']['cardno']='32';//�̶�ֵ��32��΢��ɨ�룩

$jieqiPayset['weixin']['key']='f12cd165d28998a4cd981a7534249b83';  //key

$jieqiPayset['weixin']['payurl']='http://www.zhifuka.net/gateway/weixin/weixinpay.asp'; //pc����url

$jieqiPayset['weixin']['noticeurl']='http://www.mmread.com/pay/noticeweixin';  //�ص�url,���ṩ���첽�ص�

$jieqiPayset['weixin']['backurl'] = 'http://www.mmread.com/user/userview'; //֧���ɹ�����

$jieqiPayset['weixin']['wappayurl']='http://www.zhifuka.net/gateway/weixin/wap-weixinpay.asp'; //wap����url

$jieqiPayset['weixin']['wapnoticeurl']='http://m.mmread.com/pay/noticeweixinwap';  //wap�ص�url,���ṩ���첽�ص�

$jieqiPayset['weixin']['wapbackurl'] = 'http://m.mmread.com'; //wap֧���ɹ�����

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ��Ҳ��Ǯ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['weixin']['paylimit']=array('2000'=>'20', '3500'=>'30', '6000'=>'50', '11500'=>'100', '22000'=>'200', '55000'=>'500', '112000'=>'1000');

//֧�����ӻ���
$jieqiPayset['weixin']['payscore']=array('2000'=>'1000','3500'=>'1500', '6000'=>'2500', '11500'=>'5000', '22000'=>'10000', '55000'=>'25000', '112000'=>'50000');


$jieqiPayset['weixin']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ
$jieqiPayset['weixin']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ��ֵ������


?>