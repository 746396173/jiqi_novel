<?php
$jieqiUrl['wenxue']=Array
	(
	'articleinfo_main' => Array
		(
		'id' => 72,
		'modname' => 'wenxue',
		'caption' => 'С˵����',
		'controller' => 'articleinfo',
		'method' => '',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/book/{$aid}.htm',
		'params' => 'aid=$aid',
		'ishtml' => 99,
		'system' => '0'
		),
	'huodong_main' => Array
		(
		'id' => 73,
		'modname' => 'wenxue',
		'caption' => '�',
		'controller' => 'huodong',
		'method' => '',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/huodong/$method/$aid.html',
		'params' => 'aid=$aid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'index_main' => Array
		(
		'id' => 74,
		'modname' => 'wenxue',
		'caption' => 'С˵Ŀ¼',
		'controller' => 'index',
		'method' => '',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/read/$aid/',
		'params' => 'aid=$aid',
		'ishtml' => 99,
		'system' => '0'
		),
	'reader_main' => Array
		(
		'id' => 75,
		'modname' => 'wenxue',
		'caption' => 'С˵�Ķ�',
		'controller' => 'reader',
		'method' => '',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/read/$aid/$cid.html',
		'params' => 'aid=$aid&cid=$cid',
		'ishtml' => 99,
		'system' => '0'
		),
	'reviews_main' => Array
		(
		'id' => 76,
		'modname' => 'wenxue',
		'caption' => '���ۿ�����',
		'controller' => 'reviews',
		'method' => '',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/reviews/$aid/',
		'params' => 'aid=$aid&rid=$rid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'reviews_showReplies' => Array
		(
		'id' => 77,
		'modname' => 'wenxue',
		'caption' => '���ۻظ��б�',
		'controller' => 'reviews',
		'method' => 'showReplies',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/showReplies/$aid/?rid=$rid&page=$page',
		'params' => 'aid=$aid&rid=$rid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'shuku_main' => Array
		(
		'id' => 78,
		'modname' => 'wenxue',
		'caption' => '���',
		'controller' => 'shuku',
		'method' => '',
		'description' => '���',
		'rule' => 'http://wenxue.shuhai.com/shuku/{$sort}_{$size}_{$fullflag}_{$operate}_{$free}_{$page}.html',
		'params' => 'sort=$sort&size=$size&fullflag=$fullflag&operate=$operate&free=$free&page=$page',
		'ishtml' => 99,
		'system' => '0'
		),
	'top_main' => Array
		(
		'id' => 79,
		'modname' => 'wenxue',
		'caption' => '���а�',
		'controller' => 'top',
		'method' => '',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/top/',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'top_toplist' => Array
		(
		'id' => 80,
		'modname' => 'wenxue',
		'caption' => '���а��б�',
		'controller' => 'top',
		'method' => 'toplist',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/top/{$type}_{$sortid}_{$page}.html',
		'params' => 'type=$type&sortid=$sortid',
		'ishtml' => 99,
		'system' => '0'
		),
	'channel_main' => Array
		(
		'id' => 81,
		'modname' => 'wenxue',
		'caption' => '���С˵Ƶ��ҳ��',
		'controller' => 'channel',
		'method' => '',
		'description' => '',
		'rule' => 'http://wenxue.shuhai.com/{$class}/',
		'params' => 'class=$class',
		'ishtml' => 99,
		'system' => '0'
		),
	'reader_readvip' => Array
		(
		'id' => 128,
		'modname' => 'wenxue',
		'caption' => 'vip',
		'controller' => 'reader',
		'method' => 'readvip',
		'description' => 11,
		'rule' => 'http://wenxue.shuhai.com/readvip/$aid/$cid',
		'params' => 'aid=$aid&cid=$cid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		)
	)
?>