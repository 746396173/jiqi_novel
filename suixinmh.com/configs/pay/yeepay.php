<?php
//�ױ�yeepay֧����ز���

$jieqiPayset['yeepay']['payid']='10012466170';  //�̻����10011326468

$jieqiPayset['yeepay']['paykey']='9h0q544oyoS5ko53o47403sy4138G11756859rLqHQbxJSM96l9Ur86WWK82';  //��ԿֵJzG3ZGP40Z01t9L7n8H7208i6RM9BUZAoHz84I6954Z152p5M8789y9922Gt

$jieqiPayset['yeepay']['payurl']='https://www.yeepay.com/app-merchant-proxy/node';  //�ύ���Է�����ַ

$jieqiPayset['yeepay']['payreturn']='http://www.mmread.com/pay/checkyeepay';  //���շ��صĵ�ַ (www.domain.com ��ָ�����ַ)

//������������õĻ����û����Թ�������ֵ��������ң�����һԪǮ100�����㡣������������������������ֻ�ܰ�����������ã���Ӧ��Ҳ��Ǯ����Ӧ��ϵ���㣬�� '1000'=>'10' ��ָ 1000�������Ҫ10Ԫ
if($_REQUEST['method']=='cardpay'){//�ֻ���ֵ��
	$jieqiPayset['yeepay']['paylimit']=array('800'=>'10', '1600'=>'20', '2400'=>'30', '4000'=>'50', '8000'=>'100', '16000'=>'200', '24000'=>'300', '40000'=>'500', '80000'=>'1000');
}elseif($_REQUEST['method']=='gcardpay'){//��Ϸ�㿨
	$jieqiPayset['yeepay']['paylimit']=array('400'=>'5', '800'=>'10', '1200'=>'15', '1600'=>'20', '2000'=>'25','2400'=>'30', '2800'=>'35', '3600'=>'45','4000'=>'50', '8000'=>'100', '16000'=>'200', '24000'=>'300', '28000'=>'350', '40000'=>'500', '80000'=>'1000');
}elseif($_REQUEST['method']=='qcardpay'){//QQ��
	$jieqiPayset['yeepay']['paylimit']=array('400'=>'5', '800'=>'10', '1200'=>'15', '1600'=>'20', '2400'=>'30', '4000'=>'50', '4800'=>'60', '8000'=>'100', '16000'=>'200');
}else{
	$jieqiPayset['yeepay']['paylimit']=array('2000'=>'20', '3500'=>'30', '6000'=>'50', '11500'=>'100', '22000'=>'200', '55000'=>'500', '112000'=>'1000');
}
//֧�����ӻ���
//$jieqiPayset['yeepay']['payscore']=array('1000'=>'100', '2000'=>'200', '3000'=>'300', '5000'=>'500', '10000'=>'1000');

$jieqiPayset['yeepay']['moneytype']='0';  //0 ����� 1��ʾ��Ԫ

$jieqiPayset['yeepay']['paysilver']='0';  //0 ��ʾ��ֵ�ɽ�� 1��ʾ����



$jieqiPayset['yeepay']['addressFlag']='0';  //��Ҫ��д�ͻ���Ϣ 0������Ҫ  1:��Ҫ

$jieqiPayset['yeepay']['messageType']='Buy';  //ҵ������

$jieqiPayset['yeepay']['cur']='CNY';  //���ҵ�λ

$jieqiPayset['yeepay']['productId']='';  //��Ʒ��

$jieqiPayset['yeepay']['productDesc']='';  //��Ʒ����

$jieqiPayset['yeepay']['productCat']='';  //��Ʒ����

$jieqiPayset['yeepay']['sMctProperties']='';  //���Ӳ���
$jieqiPayset['yeepay']['frpId']='';  //���Ӳ���

$jieqiPayset['yeepay']['needResponse']='1';  //�Ƿ���ҪӦ����ƣ�Ĭ�ϻ�"0"Ϊ����Ҫ,"1"Ϊ��Ҫ

$jieqiPayset['yeepay']['payfrom']=array(
'1000000-NET'   => '�ױ���Ա֧��',
'SZX'           => '������֧����',
'ABC-NET'       => '�й�ũҵ����',
'BCCB-NET'      => '��������',
'BOCO-NET'      => '��ͨ����',
'CCB-NET'       => '��������',
'CIB-NET'       => '��ҵ����',
'CMBCHINA-NET'  => '��������',
'CMBCHINA-PHONE'=> '���е绰����',
'CMBC-NET'      => '�й�������������',
'CMBC-PHONE'    => '�����绰����',
'ICBC-NET'      => '�й���������',
'JUNNET-NET'    => '����һ��ͨ',
'SNDACARD-NET'    => 'ʢ��',
'SZX-NET'    => '������',
'ZHENGTU-NET'    => '��;��',
'QQCARD-NET'    => 'Q�ҿ�',
'UNICOM-NET'    => '��ͨ��',
'JIUYOU-NET'    => '���ο�',
'YPCARD-NET'    => '�ױ�e��ͨ',
'NETEASE-NET'    => '���׿�',
'WANMEI-NET'    => '������',
'SOHU-NET'    => '�Ѻ���',
'TELECOM-NET'    => '���ſ�',
'ZONGYOU-NET'    => '����һ��ͨ',
'TIANXIA-NET'    => '����һ��ͨ',
'TIANHONG-NET'    => '���һ��ͨ',
'LIANHUAOKCARD-NET'=>'����OK ��',
'POST-NET'      => '�й�����',
'SDB-NET'       => '���ڷ�չ����',
'SHTEL-NET'     => '���ž��ſ�',
'SPDB-NET'      => '�Ϻ��ֶ���չ����',
'TONGCARD-NET'  => '����֧��(ͨ��)'
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
'POST-NET'      => 'yeepay-other',
'SDB-NET'       => 'yeepay-bank',
'SHTEL-NET'     => 'yeepay-other',
'SPDB-NET'      => 'yeepay-bank',
'JUNNET-NET'    => 'yeepay-other',
'SNDACARD-NET'    => 'yeepay-other',
'SZX-NET'    => 'yeepay-other',
'ZHENGTU-NET'    => 'yeepay-other',
'QQCARD-NET'    => 'yeepay-other',
'UNICOM-NET'    => 'yeepay-other',
'JIUYOU-NET'    => 'yeepay-other',
'YPCARD-NET'    => 'yeepay-other',
'NETEASE-NET'    => 'yeepay-other',
'WANMEI-NET'    => 'yeepay-other',
'SOHU-NET'    => 'yeepay-other',
'TELECOM-NET'    => 'yeepay-other',
'ZONGYOU-NET'    => 'yeepay-other',
'TIANXIA-NET'    => 'yeepay-other',
'TIANHONG-NET'    => 'yeepay-other',
'LIANHUAOKCARD-NET'=>'yeepay-other',
'TONGCARD-NET'  => 'yeepay-other'
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

?>