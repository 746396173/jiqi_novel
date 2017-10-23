<?php
$jieqiUrl['3g']=Array
	(
	'article_main' => Array
		(
		'id' => 141,
		'modname' => '3g',
		'caption' => 'С˵����',
		'controller' => 'article',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/article/$method',
		'params' => 'aid=$aid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'articleinfo_main' => Array
		(
		'id' => 142,
		'modname' => '3g',
		'caption' => 'С˵����',
		'controller' => 'articleinfo',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/book/{$aid}.htm',
		'params' => 'aid=$aid',
		'ishtml' => 99,
		'system' => '0'
		),
	'catalog_main' => Array
		(
		'id' => 143,
		'modname' => '3g',
		'caption' => 'Ŀ¼',
		'controller' => 'catalog',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/chapter/$aid/',
		'params' => 'aid=$aid&order=$order',
		'ishtml' => 99,
		'system' => '0'
		),
	'channel_main' => Array
		(
		'id' => 144,
		'modname' => '3g',
		'caption' => '���С˵����ҳ��',
		'controller' => 'channel',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/{$class}/',
		'params' => 'class=$class',
		'ishtml' => 99,
		'system' => '0'
		),
	'dispatcher_main' => Array
		(
		'id' => 145,
		'modname' => '3g',
		'caption' => '������',
		'controller' => 'dispatcher',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/{$type}/',
		'params' => 'type=$type',
		'ishtml' => 99,
		'system' => '0'
		),
	'getpass_main' => Array
		(
		'id' => 146,
		'modname' => '3g',
		'caption' => '�һ�����',
		'controller' => 'getpass',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/getpass',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'huodong_main' => Array
		(
		'id' => 147,
		'modname' => '3g',
		'caption' => '�',
		'controller' => 'huodong',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/huodong/$method/$aid.html',
		'params' => 'aid=$aid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'huodong_showBookCase' => Array
		(
		'id' => 148,
		'modname' => '3g',
		'caption' => '��ʾ���',
		'controller' => 'huodong',
		'method' => 'showBookCase',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/bookcase/{$type}/',
		'params' => 'type=$type',
		'ishtml' => 99,
		'system' => '0'
		),
	'login_main' => Array
		(
		'id' => 149,
		'modname' => '3g',
		'caption' => '��¼',
		'controller' => 'login',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/login',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'pay_main' => Array
		(
		'id' => 150,
		'modname' => '3g',
		'caption' => 'Ĭ�ϳ�ֵ·��',
		'controller' => 'pay',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/pay/$method',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'reader_main' => Array
		(
		'id' => 151,
		'modname' => '3g',
		'caption' => '�Ķ�',
		'controller' => 'reader',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/read/$aid/$cid.html',
		'params' => 'aid=$aid&cid=$cid',
		'ishtml' => 99,
		'system' => '0'
		),
	'register_main' => Array
		(
		'id' => 152,
		'modname' => '3g',
		'caption' => 'ע��',
		'controller' => 'register',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/register',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'reviews_main' => Array
		(
		'id' => 153,
		'modname' => '3g',
		'caption' => '���ۿ�����',
		'controller' => 'reviews',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/reviews/$aid/',
		'params' => 'aid=$aid&rid=$rid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'reviews_showReplies' => Array
		(
		'id' => 154,
		'modname' => '3g',
		'caption' => '���ۻظ��б�',
		'controller' => 'reviews',
		'method' => 'showReplies',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/showReplies/$aid/?rid=$rid&page=$page',
		'params' => 'aid=$aid&rid=$rid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'search_main' => Array
		(
		'id' => 155,
		'modname' => '3g',
		'caption' => '����',
		'controller' => 'search',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/search/$searchkey',
		'params' => 'searchkey=$searchkey',
		'ishtml' => 99,
		'system' => '0'
		),
	'setpass_main' => Array
		(
		'id' => 156,
		'modname' => '3g',
		'caption' => '��������',
		'controller' => 'setpass',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/setpass',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'shuku_main' => Array
		(
		'id' => 157,
		'modname' => '3g',
		'caption' => '���',
		'controller' => 'shuku',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/shuku/{$sort}_{$size}_{$fullflag}_{$operate}_{$free}_{$page}_{$siteid}.html',
		'params' => 'sort=$sort&size=$size&fullflag=$fullflag&operate=$operate&free=$free&page=$page&siteid=$siteid',
		'ishtml' => 99,
		'system' => '0'
		),
	'top_toplist' => Array
		(
		'id' => 158,
		'modname' => '3g',
		'caption' => '���а��б�',
		'controller' => 'top',
		'method' => 'toplist',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/top/{$type}_{$sortid}_{$page}.html',
		'params' => 'type=$type&sortid=$sortid',
		'ishtml' => 99,
		'system' => '0'
		),
	'userhub_main' => Array
		(
		'id' => 159,
		'modname' => '3g',
		'caption' => '��������',
		'controller' => 'userhub',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/user/$method',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'top_main' => Array
		(
		'id' => 160,
		'modname' => '3g',
		'caption' => '���а���ҳ',
		'controller' => 'top',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/top/',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'help_main' => Array
		(
		'id' => 161,
		'modname' => '3g',
		'caption' => 'FAQ',
		'controller' => 'help',
		'method' => '',
		'description' => '',
		'rule' => 'http://'.JIEQI_HTTP_HOST.'/help/',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		)
	)
?>