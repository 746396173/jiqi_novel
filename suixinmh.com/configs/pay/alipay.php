<?php
//֧����alipay֧����ز���

$jieqiPayset['alipay']['payid']='2088911995276793';  //�������ID

$jieqiPayset['alipay']['paykey']='ww6qwshvrfdeboo26qfanavkliuozoxm';  //��Կֵ

$jieqiPayset['alipay']['payurl']='https://www.alipay.com/cooperate/gateway.do';  //�ύ���Է�����ַ

$jieqiPayset['alipay']['payreturn']='http://www.mmread.com/pay/checkalipay';  //���շ��صĵ�ַ ( ��ָ�����ַ)

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ��Ҳ��Ǯ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['alipay']['paylimit']=array('2000'=>'20', '3500'=>'30', '6000'=>'50', '11500'=>'100', '22000'=>'200', '55000'=>'500', '112000'=>'1000');

//֧�����ӻ���
$jieqiPayset['alipay']['payscore']=array('2000'=>'1000','3500'=>'1500', '6000'=>'2500', '11500'=>'5000', '22000'=>'10000', '55000'=>'25000', '112000'=>'50000');

$jieqiPayset['alipay']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['alipay']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ����


$jieqiPayset['alipay']['service']='create_direct_pay_by_user';  //��������
$jieqiPayset['alipay']['agent']='';  //������id
$jieqiPayset['alipay']['_input_charset']='GBK';  //�ַ���
$jieqiPayset['alipay']['body']='�����';  //��Ʒ����
$jieqiPayset['alipay']['payment_type']='1';  // ��Ʒ֧������ 1 ����Ʒ���� 2�������� 3���������� 4������ 5���ʷѲ��� 6������
$jieqiPayset['alipay']['show_url']='http://www.mmread.com';  //��Ʒ�����վ��˾
$jieqiPayset['alipay']['seller_email']='2562510780@qq.com';  //�������䣬����
$jieqiPayset['alipay']['sign_type']='MD5';  //ǩ����ʽ

$jieqiPayset['alipay']['notify_url']='http://www.mmread.com/pay/checkalipay'; //�첽������Ϣ
$jieqiPayset['alipay']['notifycheck']='http://notify.alipay.com/trade/notify_query.do';  //֪ͨ��֤��ַ

$jieqiPayset['alipay']['addvars']=array();  //���Ӳ���
?>