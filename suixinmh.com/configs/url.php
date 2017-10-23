<?php
$jieqiUrl['system']=Array
	(
	'userhub_main' => Array
		(
		'id' => 10,
		'modname' => 'system',
		'caption' => '�û�����',
		'controller' => 'userhub',
		'method' => '',
		'description' => '�û�����',
		'rule' => '/user/$method',
		'params' => '',
		'ishtml' => '0',
		'system' => '0'
		),
	'login_main' => Array
		(
		'id' => 13,
		'modname' => 'system',
		'caption' => '��½��½',
		'controller' => 'login',
		'method' => '',
		'description' => '',
		'rule' => '/login',
		'params' => '',
		'ishtml' => '0',
		'system' => '0'
		),
	'register_main' => Array
		(
		'id' => 35,
		'modname' => 'system',
		'caption' => '�û�ע��',
		'controller' => 'register',
		'method' => '',
		'description' => '',
		'rule' => '/register',
		'params' => '',
		'ishtml' => '0',
		'system' => '0'
		),
	'userhub_userinfo' => Array
		(
		'id' => 65,
		'modname' => 'system',
		'caption' => '�û���Ϣ',
		'controller' => 'userhub',
		'method' => 'userinfo',
		'description' => '',
		'rule' => '/user/{$uid}.html',
		'params' => 'uid=$uid',
		'ishtml' => 99,
		'system' => '0'
		),
	'help_main' => Array
		(
		'id' => 68,
		'modname' => 'system',
		'caption' => '����',
		'controller' => 'help',
		'method' => 'main',
		'description' => '',
		'rule' => '/help',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'about_main' => Array
		(
		'id' => 69,
		'modname' => 'system',
		'caption' => '��������',
		'controller' => 'about',
		'method' => '',
		'description' => '',
		'rule' => '/about/$method',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'tag_main' => Array
		(
		'id' => 70,
		'modname' => 'system',
		'caption' => '��ǩ·��',
		'controller' => 'tag',
		'method' => '',
		'description' => '',
		'rule' => '/postion/{$id}.html',
		'params' => 'id=$id',
		'ishtml' => 99,
		'system' => '0'
		),
	'userhub_zuozhe' => Array
		(
		'id' => 71,
		'modname' => 'system',
		'caption' => '������Ϣ',
		'controller' => 'userhub',
		'method' => 'zuozhe',
		'description' => '',
		'rule' => '/zuozhe/{$uid}.html',
		'params' => 'uid=$uid',
		'ishtml' => 99,
		'system' => '0'
		),
	'getpass_main' => Array
		(
		'id' => 98,
		'modname' => 'system',
		'caption' => '�һ�����',
		'controller' => 'getpass',
		'method' => '',
		'description' => '',
		'rule' => '/getpass',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'setpass_main' => Array
		(
		'id' => 99,
		'modname' => 'system',
		'caption' => '��������',
		'controller' => 'setpass',
		'method' => '',
		'description' => '',
		'rule' => '/setpass',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		),
	'checkcode_main' => Array
		(
		'id' => 162,
		'modname' => 'system',
		'caption' => '��֤��',
		'controller' => 'checkcode',
		'method' => '',
		'description' => '��֤��',
		'rule' => '/checkcode',
		'params' => '',
		'ishtml' => 99,
		'system' => '0'
		)
	)
?>