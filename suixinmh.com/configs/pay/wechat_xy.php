<?php
//������΢��֧���������
$jieqiPayset['wechat_wap']['customerid']='101550023512';	//�̻���
$jieqiPayset['wechat_wap']['cardno']='32';	//֧����ʽ���̶�ֵ32
$jieqiPayset['wechat_wap']['noticeurl']='http://'.JIEQI_HTTP_HOST.'/pay/wechat_xy_notify'; //�첽֪ͨ��ַ
$jieqiPayset['wechat_wap']['backurl']='http://'.JIEQI_HTTP_HOST.'/pay/checkwechat';  //�ص���ַ
$jieqiPayset['wechat_wap']['key']='948853631d42da72ce7d08e140488677';  //��Կ
$jieqiPayset['wechat_wap']['payurl']='https://pay.swiftpass.cn/pay/gateway';  //΢���ֻ���ҳ ֧�������ַ

$jieqiPayset['wechat_wap']['appid'] = 'wxe40804eefad91598';
$jieqiPayset['wechat_wap']['appkey'] = 'fc03c47bc3346a1855d0e2dd744b520e';


$jieqiPayset['wechat_wap']['remarks']=array( //�̻��Զ�����Ϣ
	'30'=>JIEQI_EGOLD_NAME.'30Ԫ��ֵ',
	'50'=>JIEQI_EGOLD_NAME.'50Ԫ��ֵ',
	'100'=>JIEQI_EGOLD_NAME.'100Ԫ��ֵ',
	'200'=>JIEQI_EGOLD_NAME.'200Ԫ��ֵ',
	'500'=>JIEQI_EGOLD_NAME.'500Ԫ��ֵ',
	'1000'=>JIEQI_EGOLD_NAME.'1000Ԫ��ֵ'
	);





$huodong_setting=array(
    'from_time'=>strtotime("2017-01-28 00:00:00"),
    'to_time'=>strtotime("2017-02-05 23:59:59"),
    'notify'=>"ӭ����,���鷻��ֵ�ʹ���,�����ѵò��ݴ��Ŷ,�����������<br>\n ��50Ԫ��1000���+1�γ齱���ᣬ<br>\n��100Ԫ��3500���+2�γ齱���ᣬ<br>\n��200��5000���+5�γ齱���ᣬ<br>\n��500Ԫ��15000���+15�γ齱���ᣬ<br>\n��1000Ԫ��35000���+35�γ齱����<br>\n�ʱ�䣺2017-1-28��2017-2-5<br><a href='/huodong/newyear/'>�鿴��ϸ�����&gt;&gt;</a><br>\n"
);


if (time()>=$huodong_setting['from_time'] && time()<=$huodong_setting['to_time']) {
    $jieqiPayset['wechat_wap']['paylimit'] = array(
        '100' => '13500',
        '30' => '3000',
        '50' => '6000',
        '200' => '25000',
        '500' => '65000',
        '1000' => '135000'
    );
    $jieqiPayset['wechat_wap']['notify'] = $huodong_setting['notify'];
    $jieqiPayset['wechat_wap']['in_huodong'] = 1;
}
else {
    $jieqiPayset['wechat_wap']['paylimit'] = array(
        '30' => '3000',
        '50' => '5500',
        '100' => '11200',
        '200' => '23000',
        '500' => '60000',
        '1000' => '125000'
    );
    $jieqiPayset['wechat_wap']['in_huodong'] = 0;
}





$jieqiPayset['wechat_wap']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['wechat_wap']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ����




?>