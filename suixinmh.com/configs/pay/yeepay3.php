<?php
//�ױ�yeepay֧����ز���
$jieqiPayset['yeepay']['messageType']='Buy';  //֧�����󣬹̶�ֵ"Buy"

//$jieqiPayset['yeepay']['payid']='10001126856';  //�̻����      ������
$jieqiPayset['yeepay']['payid']='10011415194'; 

//$jieqiPayset['yeepay']['paykey']='69cl522AV6q613Ii4W6u8K6XuW8vM1N6bFgyv769220IuYe9u37N4y7rI4Pl';  //��ԿmerchantKey      ������
$jieqiPayset['yeepay']['paykey']='o9XYE8mg6Y6K06737u9t3qV5i0A7xpE82365rSw3p32hQ438cgz40u685fCR';   //��ʽʹ��

//$jieqiPayset['yeepay']['payurl']='http://tech.yeepay.com:8080/robot/debug.action';   //�����ַ       ������
$jieqiPayset['yeepay']['payurl']='https://www.yeepay.com/app-merchant-proxy/node';  //��ʽʹ��
$jieqiPayset['yeepay']['payurl_wap']='http://www.yeepay.com/app-merchant-proxy/wap/controller.action';  //wap��ʽʹ��

$jieqiPayset['yeepay']['payreturn']='http://www.shuhai.com/modules/pay/yeepayreturn.php';  //���շ������ݵĵ�ַ (www.domain.com ��ָ�����ַ)       ��ʽʹ��

$jieqiPayset['yeepay']['cur']='CNY';  //���ҵ�λ
$jieqiPayset['yeepay']['productId']='virtual money';  //��Ʒ��
$jieqiPayset['yeepay']['productDesc']='virtual money';  //��Ʒ����
$jieqiPayset['yeepay']['productCat']='virtual money';  //��Ʒ����
$jieqiPayset['yeepay']['sMctProperties']='shuhai userid';  //���Ӳ���
$jieqiPayset['yeepay']['frpId']='';  //���Ӳ���
$jieqiPayset['yeepay']['addressFlag']='0';  //��Ҫ��д�ͻ���Ϣ 0������Ҫ  1:��Ҫ
$jieqiPayset['yeepay']['needResponse']='1';  //�Ƿ���ҪӦ����ƣ�Ĭ�ϻ�"0"Ϊ����Ҫ,"1"Ϊ��Ҫ


//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ�Ľ�ǮҲ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
$jieqiPayset['yeepay']['paylimit']=array('100'=>'1','105'=>'1','1080'=>'10', '1500'=>'15', '2180'=>'20', '3000'=>'30', '5480'=>'50', '6000'=>'60', '11000'=>'100', '22500'=>'200', '30000'=>'300', '55800'=>'500');


//֧�����ӻ���
//$jieqiPayset['yeepay']['payscore']=array('105'=>'10','1080'=>'108','2180'=>'218', '5480'=>'548', '11000'=>'1100', '22500'=>'2250', '55800'=>'5580');

$jieqiPayset['yeepay']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['yeepay']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ��ֵ������

$logName	= "YeePay_HTML.log";




$jieqiPayset['yeepay']['payfrom']=array(
'1000000-NET'   => '�ױ���Ա֧��',
'SZX'           => '������֧����',
'ABC-NET-B2C'       => '�й�ũҵ����',
'BCCB-NET'      => '��������',
'BOCO-NET-B2C'      => '��ͨ����',
'CCB-NET-B2C'       => '��������',
'CIB-NET-B2C'       => '��ҵ����',
'CMBCHINA-NET-B2C'  => '��������',
'CMBCHINA-PHONE'=> '���е绰����',
'CMBC-NET-B2C'      => '�й���������',
'CMBC-PHONE'    => '�����绰����',
'ICBC-NET-B2C'      => '�й���������',
'BOC-NET-B2C'      => '�й�����',
'JUNNET-NET'    => '����һ��ͨ(��Ҫ�ر�ͨ�ſ�ʹ��)',
'LIANHUAOKCARD-NET'=>'����OK ��(��Ҫ�ر�ͨ�ſ�ʹ��)',
'POST-NET'      => '�й�����(��Ҫ�ر�ͨ�ſ�ʹ��)',
'SDB-NET'       => '���ڷ�չ����',
'SHTEL-NET'     => '���ž��ſ�(��Ҫ�ر�ͨ�ſ�ʹ��)',
'SPDB-NET'      => '�Ϻ��ֶ���չ����',
'TONGCARD-NET'  => '����֧��(ͨ��)(��Ҫ�ر�ͨ�ſ�ʹ��)',
'SZX-NET'  => '�����г�ֵ��(��Ҫ�ر�ͨ�ſ�ʹ��)',
'UNICOM-NET'  => '��ͨ��ֵ��',
'TELECOM-NET'  => '���ų�ֵ��',
'ICBC-WAP'  => '�й���������WAPͨ��',
'CMBCHINA-WAP'  => '��������WAPͨ��',
'CCB-WAP'  => '�й���������WAPͨ��',
'QQCARD-NET'  => 'Q�ҿ�'
);

$jieqiPayset['yeepay']['paytype']=array(
'1000000-NET'   => 'yeepay',
'SZX'           => 'yeepay-szx',
'ABC-NET'       => 'yeepay-bank',
'BCCB-NET'      => 'yeepay-bank',
'BOCO-NET'      => 'yeepay-bank',
'CCB-NET'       => 'yeepay-bank',
'CIB-NET'       => 'yeepay-bank',
'CMBCHINA-NET'  => 'yeepay-bank',
'CMBCHINA-PHONE'=> 'yeepay-bank',
'CMBC-NET'      => 'yeepay-bank',
'CMBC-PHONE'    => 'yeepay-bank',
'ICBC-NET'      => 'yeepay-bank',
'JUNNET-NET'    => 'yeepay-other',
'LIANHUAOKCARD-NET'=>'yeepay-other',
'POST-NET'      => 'yeepay-other',
'SDB-NET'       => 'yeepay-bank',
'SHTEL-NET'     => 'yeepay-other',
'SPDB-NET'      => 'yeepay-bank',
'TONGCARD-NET'  => 'yeepay-other',
'SZX-NET'  => 'yeepay-other',
'UNICOM-NET'  => 'yeepay-other',
'TELECOM-NET'  => 'yeepay-other',
'ICBC-WAP'  => 'yeepay-bank-wap',
'CMBCHINA-WAP'  => 'yeepay-bank-wap',
'CCB-WAP'  => 'yeepay-bank-wap',
'QQCARD-NET'  => 'yeepay-other'
);

$jieqiPayset['yeepay']['addvars']=array();  //���Ӳ���

/*
�ױ�Ĭ��֧�� /modules/pay/buyegold.php?t=yeepaypay
��Ӧģ�� /modules/pay/templates/yeepaypay.html

�ױ������� /modules/pay/buyegold.php?t=yeeszxpay
��Ӧģ�� /modules/pay/templates/yeeszxpay.html

paytype.php ���ܵ�֧���������ã������ױ�֧���Ļ�����ԭ�����û����ϼ�����������

$jieqiPaytype['yeepay'] = array('name' => '�ױ���Ա֧��', 'shortname' => '�ױ���Ա', 'description'=>'', 'url' => 'http://www.yeepay.com');

$jieqiPaytype['yeepay-szx'] = array('name' => '�ױ������п�֧��', 'shortname' => '�ױ�������', 'description'=>'', 'url' => 'http://www.yeepay.com');

$jieqiPaytype['yeepay-bank'] = array('name' => '�ױ����п�֧��', 'shortname' => '�ױ����п�', 'description'=>'', 'url' => 'http://www.yeepay.com');

$jieqiPaytype['yeepay-other'] = array('name' => '�ױ�����֧��', 'shortname' => '�ױ�����', 'description'=>'', 'url' => 'http://www.yeepay.com');
*/
/*
Q�ҿ���
10,15,20,30,50,60,100,200

�ƶ���ֵ����
30 50 100 10 20 200 300 500 1000

��ͨ��ֵ����
20 30 50 100 300 500

���ų�ֵ����
50 100
*/
?>