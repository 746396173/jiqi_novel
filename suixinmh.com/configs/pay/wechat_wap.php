<?php
//������΢��֧���������
$jieqiPayset['wechat_wap']['customerid']='154740';	//�̻���
$jieqiPayset['wechat_wap']['cardno']='32';	//֧����ʽ���̶�ֵ32
$jieqiPayset['wechat_wap']['noticeurl']='http://'.JIEQI_HTTP_HOST.'/pay/wechat_notify'; //�첽֪ͨ��ַ
$jieqiPayset['wechat_wap']['backurl']='http://'.JIEQI_HTTP_HOST.'/pay/checkwechat';  //�ص���ַ
$jieqiPayset['wechat_wap']['key']='8d829506f88e650c0087a5bf3017e4e2';  //��Կ
$jieqiPayset['wechat_wap']['payurl']='http://www.zhifuka.net/gateway/weixin/wap-weixinpay.asp';  //΢���ֻ���ҳ ֧�������ַ


$jieqiPayset['wechat_wap']['remarks']=array( //�̻��Զ�����Ϣ
   // '1'=>JIEQI_EGOLD_NAME.'1Ԫ��ֵ',
    '30'=>JIEQI_EGOLD_NAME.'30Ԫ��ֵ',
    '50'=>JIEQI_EGOLD_NAME.'50Ԫ��ֵ',
    '100'=>JIEQI_EGOLD_NAME.'100Ԫ��ֵ',
    '200'=>JIEQI_EGOLD_NAME.'200Ԫ��ֵ',
    '500'=>JIEQI_EGOLD_NAME.'500Ԫ��ֵ',
    '1000'=>JIEQI_EGOLD_NAME.'1000Ԫ��ֵ'
);
$huodong_setting=array(
    'from_time'=>strtotime("2017-04-29 00:00:00"),
    'to_time'=>strtotime("2017-05-01 23:59:59"),
    'notify'=>"ӭ51,΢��С˵��ֵ�ʹ���,�����������<br>\n ��50Ԫ��600���<br>\n��100Ԫ��5000���<br>\n��200��12000���<br>\n��500Ԫ��20000���<br>\n��1000Ԫ��50000���<br>\n�ʱ�䣺2017-4-29��2017-5-1<br>\n"
);


if (time()>=$huodong_setting['from_time'] && time()<=$huodong_setting['to_time']) {
    $jieqiPayset['wechat_wap']['paylimit'] = array(
      //  '1'=>'100',
        '30' => '3000',
        '50' => '5600',
        '100' => '15000',
        '200' => '32000',
        '500' => '70000',
        '1000' => '150000'
    );
    $jieqiPayset['wechat_wap']['notify'] = $huodong_setting['notify'];
    $jieqiPayset['wechat_wap']['in_huodong'] = 1;
}
else {
    $jieqiPayset['wechat_wap']['paylimit'] = array(
      //  '1'=>'100',
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