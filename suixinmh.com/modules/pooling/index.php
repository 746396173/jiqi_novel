<?php
define('JIEQI_MODULE_NAME', 'pooling');
function getCategory_zuidie($category=0){//����ķ���
	$sort = array(
			1=>'����',
			2=>'����',
			3=>'����',
			4=>'����',
			5=>'��Խ',
			6=>'����',
			7=>'����',
			8=>'��ʷ',
			9=>'����',
			10=>'�ֲ�',
			11=>'�ഺ',
			12=>'����'
	);
	if(isset($sort[$category])) return $sort[$category];
	else return '����';
}
function getCategory_2345($category=0){//2345�ķ���
		 $sort = array(
		        1=>'����',
				2=>'����',
				3=>'����',
				4=>'��Ϸ',
				5=>'�ƻ�',
				6=>'����',
				7=>'��Ϸ',
				8=>'��ʷ',
				9=>'����',
				10=>'����',
				11=>'����',
				12=>'�ִ�����'
		 );
	     if(isset($sort[$category])) return $sort[$category];
		 else return '����';
	}
function getCategory_360($category=0){//360�ķ���
		 $sort = array(
		        1=>'����',
				2=>'����',
				3=>'����',
				4=>'��Ϸ',
				5=>'�ƻ�',
				6=>'����',
				7=>'���',
				8=>'��ʷ',
				9=>'����',
				10=>'����',
				11=>'����ͬ��',
				12=>'�ִ�����'
		 );
	     if(isset($sort[$category])) return $sort[$category];
		 else return '����';
	}
function getCategory_shenma($category=0){//����ķ���
		$sort = array(
				1=>'����',
				2=>'����',
				3=>'����',
				4=>'��Ϸ',
				5=>'�ƻ�',
				6=>'����',
				7=>'���',
				8=>'��ʷ',
				9=>'����',
				10=>'����',
				11=>'����',
				12=>'����'
		);
		if(isset($sort[$category])) return $sort[$category];
		else return '����';
	}
require '../../index.php';
?>