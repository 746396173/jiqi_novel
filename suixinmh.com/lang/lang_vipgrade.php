<?php
/**
 * ���԰�-VIP�������
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    system
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: lang_honors.php 193 2008-11-25 02:52:44Z juny $
 */
global $jieqiConfigs;
if(!$jieqiConfigs['article']) jieqi_getConfigs('article', 'configs');
$jieqiLang['system']['vipgrade']=1; //��ʾ�����԰��Ѿ�����
//admin/honors
$jieqiLang['system']['need_vipgrade_caption']='������VIP�������ƣ�';
$jieqiLang['system']['need_minscore_num']='���ִ��ڱ���Ϊ���֣�';
$jieqiLang['system']['need_maxscore_num']='����С�ڱ���Ϊ���֣�';
$jieqiLang['system']['max_than_min']='����С�ڵ�ֵ������ڵ��ڻ��ִ��ڵ�ֵ��';
$jieqiLang['system']['add_vipgrade_failure']='VIP�������ʧ�ܣ��������Ա��ϵ��';
$jieqiLang['system']['edit_vipgrade_failure']='����VIP����ʧ�ܣ��������Ա��ϵ��';
$jieqiLang['system']['edit_vipgrade']='�޸�VIP����';
$jieqiLang['system']['add_vipgrade']='����VIP����';
$jieqiLang['system']['add_vipgrade_succ']='����VIP����ɹ�';

//table field
$jieqiLang['system']['table_vipgrade_caption']='VIP��������';
$jieqiLang['system']['table_vipgrade_minscore']='���ִ���';
$jieqiLang['system']['table_vipgrade_maxscore']='����С��';
$jieqiLang['system']['table_vipgrade_photo']='ͼƬ��ʶ';
$jieqiLang['system']['table_vipgrade_setting']='����';
$jieqiLang['system']['table_vipgrade_head1']='���ּ���';
$jieqiLang['system']['table_vipgrade_head2']='�����ۿ�';
$jieqiLang['system']['table_vipgrade_head3']='������Ʊ�����¶�����'.ceil($jieqiConfigs['article']['vipvotes']/100).'Ԫ�ɻ�ã�1��/�£�';
$jieqiLang['system']['table_vipgrade_head4']='������Ʊ��ÿ������'.ceil($jieqiConfigs['article']['vipvotes']/100).'Ԫ�ɵã������ޣ�';
$jieqiLang['system']['table_vipgrade_head5']='�����Ƽ�Ʊ';

?>