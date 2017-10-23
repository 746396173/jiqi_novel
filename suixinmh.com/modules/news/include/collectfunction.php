<?php 
/**
 * ���²ɼ���غ�������
 *
 * ���²ɼ���غ�������
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    article
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: collectfunction.php 230 2008-11-27 08:46:07Z juny $
 */

if(!defined('_ROOT_')) exit;

//�ύ�ı���ת�ɱ���ı���
function jieqi_collectptos($str){
	$str=trim($str);
	$middleary=array('****', '!!!!', '~~~~', '^^^^', '$$$$');
	while(list($k, $v) = each($middleary)){
		if(strpos($str, $v)!==false){
			$tmpary=explode($v, $str);
			return array('left'=>strval($tmpary[0]), 'right'=>strval($tmpary[1]), 'middle'=>$v);
		}
	}
	return $str;
}

//����ı���ת����ʾ�ı���
function jieqi_collectstop($str){
	if(is_array($str))return $str['left'].$str['middle'].$str['right'];
	else return $str;
}

//�����ݱ��ת����preg���
function jieqi_collectmtop($str){
	switch($str){
		case '!!!!':
			return '([^\>\<]*)';
			break;
		case '~~~~':
			return '([^\<\>\'"]*)';
			break;
		case '^^^^':
			return '([^\<\>\d]*)';
			break;
		case '$$$$':
			return '([\d]*)';
			break;
		case '****':
		default:
			return '(.*)';
			break;
	}
}

//������Ĳɼ�����ת����ִ�е�
function jieqi_collectstoe($str){
	if(is_array($str)){
		$pregstr='/'.jieqi_pregconvert($str['left']).jieqi_collectmtop($str['middle']).jieqi_pregconvert($str['right']).'/is';
	}else{
		$pregstr=trim($str);
		if(strlen($pregstr) > 0 && substr($pregstr,0,1) != '/') $pregstr='/'.str_replace(array(' ', '/'), array('\s', '\/'), preg_quote($pregstr)).'/is';
	}
	return $pregstr;
}

//ƥ��һ�����
function jieqi_cmatchone($pregstr, $source){
	$matches=array();
	preg_match($pregstr, $source, $matches);
	if(!is_array($matches) || count($matches)==0){
		return false;
	}else{
		return $matches[count($matches)-1];
	}
}

// ƥ�������
function jieqi_cmatchall($pregstr, $source, $flags=0){
	$matches=array();
	if($flags == PREG_OFFSET_CAPTURE) preg_match_all($pregstr, $source, $matches, PREG_OFFSET_CAPTURE + PREG_SET_ORDER);
	else preg_match_all($pregstr, $source, $matches, PREG_SET_ORDER);
	if(!is_array($matches) || count($matches)==0){
		return false;
	}else{
		$ret=array();
		foreach($matches as $v){
			if(is_array($v)) $ret[]=$v[count($v)-1];
			else $ret[]=$v;
		}
		return $ret;
	}
}

?>