<?php
//������΢��֧���������
//cpcode=qwyo
//��������=M21I0023
$jieqiPayset['rdo_wap']['cpCode']='qwyo';
$jieqiPayset['rdo_wap']['channelCode']='M21I0023';
$jieqiPayset['rdo_wap']['payUrl']='http://121.43.234.27:10002/payplat_api/huinengrdo/cmwap';
$jieqiPayset['rdo_wap']['noticeurl']='http://m.huandie.com/pay/wechat_notify'; //�첽֪ͨ��ַ
$jieqiPayset['rdo_wap']['backurl']='http://m.huandie.com/pay/checkwechat';  //�ص���ַ

$jieqiPayset['rdo_wap']['remarks']=array( //�̻��Զ�����Ϣ
    '1000'=>JIEQI_EGOLD_NAME.'10Ԫ��ֵ',
    '1500'=>JIEQI_EGOLD_NAME.'15Ԫ��ֵ',
    '2000'=>JIEQI_EGOLD_NAME.'20Ԫ��ֵ',
    '2500'=>JIEQI_EGOLD_NAME.'25Ԫ��ֵ',
	'3000'=>JIEQI_EGOLD_NAME.'30Ԫ��ֵ'
	);

$jieqiPayset['rdo_wap']['feeCode']=array( //�̻��Զ�����Ϣ
    '1000'=>'72000010',
    '1500'=>'72000015',
    '2000'=>'72000020',
    '2500'=>'72000025',
    '3000'=>'72000030'
);



//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ��Ҳ��Ǯ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
//$jieqiPayset['rdo_wap']['paylimit']=array('1'=>'0.01', '2000'=>'20', '5000'=>'50', '10000'=>'100', '20000'=>'200', '50000'=>'500', '100000'=>'1000');
$jieqiPayset['rdo_wap']['paylimit']=array(
    '1000'=>'10',
    '1500'=>'15',
	'2000'=>'20',
    '2500'=>'25',
	'3000'=>'30'
);
//֧�����ӻ���
//$jieqiPayset['rdo_wap']['payscore']=array('2000'=>'1000', '5000'=>'2500', '10000'=>'5000', '20000'=>'10000', '50000'=>'25000', '100000'=>'50000');

$jieqiPayset['rdo_wap']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['rdo_wap']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ����

?>