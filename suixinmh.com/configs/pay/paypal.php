<?php
$jieqiPayset['paypal']['apiinfo'] = array(
//测试账号
// 	'api_username' => 'business_api1.sh.com',
// 	'api_password' => 'BAWXRFAUEV38RJWT',
// 	'pai_signatuer' => 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-A1AR7NRT7OwDIcqcCdfHRlQEWw7P',
	
	//正式账号
	'api_username' => 'lyhblue_api1.qq.com',
	'api_password' => 'RF7N3W4YJBJCSHAK',
	'pai_signatuer' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AEt2GtISi.lYXRBhATJJeTol5Wc8',
		
	"currency"=>"USD",  //币种
	"desc"=>'shuhai coin',  //商品名称
	
	//测试地址
// 	"return_page"=>"http://shuhai.ikusoo.net/modules/pay/paypal_return.php",  //支付成功返回
// 	"cancel_page"=>"http://shuhai.ikusoo.net/modules/pay/buyegold.php?t=paypal",  //取消支付返回
	
	//正式地址
	"return_page"=>"http://www.shuhai.com/pay/checkpaypal",  //支付成功返回
	"cancel_page"=>"http://www.shuhai.com/pay/paypal",  //取消支付返回
);

//这个参数不设置的话，用户可以购买任意值的虚拟货币，按照一元钱100币折算。如果设置了这个参数，则购买金额只能按照里面的设置，对应的金钱也按对应关系折算，如 '1000'=>'10' 是指 1000虚拟币需要10元
$jieqiPayset['paypal']['paylimit']=array(
		'5400'=>'10',
		'10800'=>'20',
		'27000'=>'50', 
		'54000'=>'100', 
		'108000'=>'200',  
		'270000'=>'500'
);
$jieqiPayset['paypal']['payscore']=array(
		'5400'=>'3000',
		'10800'=>'6000',
		'27000'=>'15000', 
		'54000'=>'30000', 
		'108000'=>'60000',  
		'270000'=>'150000'
);
$jieqiPayset['paypal']['exchange_rate']=6;  //美元对人民币汇率
$jieqiPayset['paypal']['moneytype']='1';  //0 人民币 1表示美元
$jieqiPayset['paypal']['paysilver']='0';  //0 表示冲值成金币 1表示冲值成银币

$logName	= "paypal.log";
?>