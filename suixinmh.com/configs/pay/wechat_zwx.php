<?php
//��΢��΢��֧���������
$jieqiPayset['wechat_zwx']['customerid']='15124229';	//�̻���
$jieqiPayset['wechat_zwx']['noticeurl']='http://'.JIEQI_HTTP_HOST.'/pay/wechat_zwx_notify'; //�첽֪ͨ��ַ
$jieqiPayset['wechat_zwx']['backurl']='http://'.JIEQI_HTTP_HOST.'/pay/checkwechat_zwx';  //�ص���ַ
$jieqiPayset['wechat_zwx']['key']='7ff9318e7d0cd6238ae999d08a11446a';  //��Կ
$jieqiPayset['wechat_zwx']['payurl']='https://api.zwxpay.com/pay/unifiedorder';  //΢���ֻ���ҳ ֧�������ַ




$jieqiPayset['wechat_zwx']['remarks']=array( //�̻��Զ�����Ϣ
	'3000'=>JIEQI_EGOLD_NAME.'30Ԫ��ֵ', 
	'5500'=>JIEQI_EGOLD_NAME.'50Ԫ��ֵ', 
	'11200'=>JIEQI_EGOLD_NAME.'100Ԫ��ֵ', 
	'23000'=>JIEQI_EGOLD_NAME.'200Ԫ��ֵ', 
	'60000'=>JIEQI_EGOLD_NAME.'500Ԫ��ֵ', 
	'125000'=>JIEQI_EGOLD_NAME.'1000Ԫ��ֵ'
	);



$jieqiPayset['wechat_zwx']['paylimit']=array(
	'3000'=>'30', 
	'5500'=>'50', 
	'11200'=>'100', 
	'23000'=>'200', 
	'60000'=>'500',
	'125000'=>'1000'
);

if (date("Y-m-d")>='2016-09-01' && date("Y-m-d")<='2016-10-07'){
    $jieqiPayset['wechat_zwx']['gift'] = array(
        '3000'=>'300',
        '5500'=>'800',
        '11200'=>'2000',
        '23000'=>'5000',
        '60000'=>'15000',
        '125000'=>'30000'
    );
}
else {
    $jieqiPayset['wechat_zwx']['gift'] = array();
}

//֧�����ӻ���
//$jieqiPayset['wechat_zwx']['payscore']=array('2000'=>'1000', '5000'=>'2500', '10000'=>'5000', '20000'=>'10000', '50000'=>'25000', '100000'=>'50000');

$jieqiPayset['wechat_zwx']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['wechat_zwx']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ����

?>