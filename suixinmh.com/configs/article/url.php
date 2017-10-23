<?php
$jieqiUrl['article']=Array
	(
	'article_main' => Array
		(
		'id' => 25,
		'modname' => 'article',
		'caption' => 'С˵����',
		'controller' => 'article',
		'method' => '',
		'description' => '',
		'rule' => '/article/$method',
		'params' => 'aid=$aid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'volume_main' => Array
		(
		'id' => 26,
		'modname' => 'article',
		'caption' => '�������',
		'controller' => 'volume',
		'method' => '',
		'description' => '',
		'rule' => '/author/volume.html',
		'params' => 'method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'chapter_main' => Array
		(
		'id' => 28,
		'modname' => 'article',
		'caption' => '�½ڿ�����',
		'controller' => 'chapter',
		'method' => '',
		'description' => '',
		'rule' => '/chapter/$method',
		'params' => 'method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'search_main' => Array
		(
		'id' => 29,
		'modname' => 'article',
		'caption' => '����',
		'controller' => 'search',
		'method' => '',
		'description' => '',
		'rule' => '/search/$searchkey/$page',
		'params' => 'searchkey=$searchkey',
		'ishtml' => 99,
		'system' => '0'
		),
	'reader_readvip' => Array
		(
		'id' => 39,
		'modname' => 'article',
		'caption' => '���VIP�½�����',
		'controller' => 'reader',
		'method' => 'readvip',
		'description' => '',
		'rule' => '/readvip/$aid/$cid',
		'params' => 'aid=$aid&cid=$cid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'articleinfo_main' => Array
		(
		'id' => 41,
		'modname' => 'article',
		'caption' => 'С˵����',
		'controller' => 'articleinfo',
		'method' => '',
		'description' => '',
		'rule' => '/book/{$aid}.htm',
		'params' => 'aid=$aid',
		'ishtml' => 99,
		'system' => '0'
		),
	'top_main' => Array
		(
		'id' => 42,
		'modname' => 'article',
		'caption' => '���а�',
		'controller' => 'top',
		'method' => '',
		'description' => '',
		'rule' => '/top/',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'index_main' => Array
		(
		'id' => 43,
		'modname' => 'article',
		'caption' => '���С˵�½�Ŀ¼',
		'controller' => 'index',
		'method' => '',
		'description' => '',
		'rule' => '/book/$aid/',
		'params' => 'aid=$aid',
		'ishtml' => '0',
		'system' => 1
		),
	'reader_main' => Array
		(
		'id' => 44,
		'modname' => 'article',
		'caption' => '���С˵�½�����',
		'controller' => 'reader',
		'method' => '',
		'description' => '',
		'rule' => '/book/$aid/$cid.html',
		'params' => 'aid=$aid&cid=$cid',
		'ishtml' => '0',
		'system' => 1
		),
	'channel_main' => Array
		(
		'id' => 47,
		'modname' => 'article',
		'caption' => '���С˵Ƶ��ҳ��',
		'controller' => 'channel',
		'method' => '',
		'description' => 'ԭ��sortid=$sortid',
		'rule' => '/{$class}/',
		'params' => 'class=$class',
		'ishtml' => 99,
		'system' => '0'
		),
	'reviews_main' => Array
		(
		'id' => 50,
		'modname' => 'article',
		'caption' => '���ۿ�����',
		'controller' => 'reviews',
		'method' => '',
		'description' => '',
		'rule' => '/reviews/$aid/',
		'params' => 'aid=$aid&rid=$rid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'reviews_showReplies' => Array
		(
		'id' => 53,
		'modname' => 'article',
		'caption' => '���ۻظ��б�',
		'controller' => 'reviews',
		'method' => 'showReplies',
		'description' => '',
		'rule' => '/showReplies/$aid/?rid=$rid&page=$page',
		'params' => 'rid=$rid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'huodong_main' => Array
		(
		'id' => 58,
		'modname' => 'article',
		'caption' => 'С˵����������',
		'controller' => 'huodong',
		'method' => '',
		'description' => '',
		'rule' => '/huodong/$method/$aid.html',
		'params' => 'aid=$aid&method=$method',
		'ishtml' => 99,
		'system' => '0'
		),
	'top_toplist' => Array
		(
		'id' => 63,
		'modname' => 'article',
		'caption' => '���а��б�',
		'controller' => 'top',
		'method' => 'toplist',
		'description' => '',
		'rule' => '/top/{$type}_{$sortid}_{$page}.html',
		'params' => 'type=$type&sortid=$sortid',
		'ishtml' => 99,
		'system' => '0'
		),
	'shuku_main' => Array
		(
		'id' => 66,
		'modname' => 'article',
		'caption' => '���',
		'controller' => 'shuku',
		'method' => '',
		'description' => '',
		'rule' => '/shuku/{$sort}_{$size}_{$fullflag}_{$operate}_{$free}_{$page}_{$siteid}.html',
		'params' => 'sort=$sort&size=$size&fullflag=$fullflag&operate=$operate&free=$free&page=$page&siteid=$siteid',
		'ishtml' => 99,
		'system' => '0'
		),
	'bookpackage_main' => Array
		(
		'id' => 129,
		'modname' => 'article',
		'caption' => '����ר��',
		'controller' => 'bookpackage',
		'method' => '',
		'description' => '',
		'rule' => '/bookpack/',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		)
	)
?>