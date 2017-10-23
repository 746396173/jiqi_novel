<?php
/*
	[Cms news] (C) 2009-2010 Cms Inc.
	$Id: cutimage.inc.php  2010-04-27 17:15:09Z huliming $
*/
if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}
//$op = empty($_PAGE['_GET']['op']) ? "" : $_PAGE['_GET']['op'];

//�ж�Ŀ���ļ��Ƿ����
$old_thumb = JIEQI_ROOT_PATH.$_PAGE['_GET']['thumb'];
if(!is_file($old_thumb)) jieqi_printfail('<base target=\'_self\'>'.LANG_ERROR_PARAMETER);

//��������ͼƬ�����ֳߴ�
$_SCONFIG['avatarbw'] = '150';
$_SCONFIG['avatarbh'] = '150';
$_SCONFIG['avatarsw'] = '120';
$_SCONFIG['avatarsh'] = '120';
$_SCONFIG['avatariw'] = '100';
$_SCONFIG['avatarih'] = '100';

//ȡ��ͼƬ��Ϣ
$ext = fileext($old_thumb);
$filename = basename($old_thumb);
$filesavedir = str_replace($filename, '', $old_thumb);

$tmp150_save = $filesavedir.str_replace(".{$ext}", '', $filename)."_{$_SCONFIG['avatarbw']}.{$ext}";
$tmp120_save = $filesavedir.str_replace(".{$ext}", '', $filename)."_{$_SCONFIG['avatarsw']}.{$ext}";
$tmp100_save = $filesavedir.str_replace(".{$ext}", '', $filename)."_{$_SCONFIG['avatariw']}.{$ext}";
//�ж��Ƿ��Ѿ��ü���
$returnmsg = lang_replace('cutfile_exists');
$fileurl = str_replace(JIEQI_ROOT_PATH, '', $tmp150_save);
if(is_file($tmp150_save)) exit("<script language='javascript'> try{ alert('{$returnmsg}');window.returnValue='{$fileurl}';}catch(e){} window.close();</script>");

if($op == 'cutsave') {//��ʼ�ü�
	
	//��ȡͼƬ��ȡ����
	$posary=explode(',', $_PAGE['_POST']['cut_pos']);
	foreach($posary as $k=>$v) $posary[$k]=intval($v);
	
	//����ͼƬѹ��������
	include_once(JIEQI_ROOT_PATH.'/lib/image/imageresize.php');
	$imgresize = new ImageResize();
	$imgresize->load($old_thumb);
	if($posary[2]>0 && $posary[3]>0) $imgresize->resize($posary[2], $posary[3]);
	
	//��ʼ����150*150
	$imgresize->cut($_SCONFIG['avatarbw'], $_SCONFIG['avatarbh'], intval($posary[0]), intval($posary[1]));
	$runstatu = $imgresize->save($tmp150_save);
	$fileurl = $runstatu ?str_replace(JIEQI_ROOT_PATH, '', $tmp150_save) :$_PAGE['_GET']['thumb'];

	//��ʼ����120*120
	$imgresize->resize($_SCONFIG['avatarsw'], $_SCONFIG['avatarsh']);
	$imgresize->save($tmp120_save);
	
	//��ʼ����100*100
	$imgresize->resize($_SCONFIG['avatariw'], $_SCONFIG['avatarih']);
	$imgresize->save($tmp100_save);
	exit("<script language='javascript'> try{ window.returnValue='{$fileurl}';}catch(e){} window.close();</script>");	
} else {//����ͼƬ�����

}
//template('admin/cutimage');
?>
