<?php
@define('JIEQI_URL','http://www.suixinmh.com');
@define('JIEQI_SITE_NAME','����С˵');
@define('JIEQI_CONTACT_EMAIL','');
@define('JIEQI_MAIN_SERVER','');
@define('JIEQI_USER_ENTRY','');
@define('JIEQI_SITE_KEY','');
@define('JIEQI_META_KEYWORDS','����С˵������С˵��������С˵�Ķ������ÿ���С˵������С˵����ʷС˵������С˵������С˵������С˵������С˵��ԭ��������ѧ');
@define('JIEQI_META_DESCRIPTION','����С˵�Ķ����ṩ���ɡ�У԰����ʷ�����С���塢�ٳ������졢���¡����á���á��������������ƻá���Ϸ��ͬ�˵�����С˵�����Ķ�������С˵�Ķ���-www.ishufun.net');
@define('JIEQI_META_COPYRIGHT','Copyright @ 2014-2015 ishufun.net ����С˵�Ķ��� Allrights Reserved ��Ȩ����');
@define('JIEQI_BANNER','');
@define('JIEQI_LICENSE_KEY','');
@define('JIEQI_DB_TYPE','mysql');
@define('JIEQI_DB_CHARSET','gbk');
@define('JIEQI_DB_PREFIX','jieqi');
@define('JIEQI_DB_HOST','localhost');
//@define('JIEQI_DB_HOST','rm-bp1p6i6e32l9fzo2q.mysql.rds.aliyuncs.com');
@define('JIEQI_DB_USER','book');
@define('JIEQI_DB_PASS','OJoKFQ0QpPz317ir');
@define('JIEQI_DB_NAME','book');
@define('JIEQI_DB_PCONNECT','1');
@define('JIEQI_IS_OPEN','1');
@define('JIEQI_CLOSE_INFO','��վϵͳά���У�Ԥ��3��00�ָ������Ժ����......');
@define('JIEQI_PROXY_DENIED','1');
@define('JIEQI_THEME_SET','v1');
@define('JIEQI_TOP_BAR','');
@define('JIEQI_BOTTOM_BAR','<a href="http://www.miitbeian.gov.cn/" target="_blank" style="color:#FFFFFF">��ICP��16032081��-1</a> ���ݾ�Ծ����Ƽ����޹�˾��Ȩ����');
@define('JIEQI_PAGE_TAG','<ul>[prepage]<li><a href="{$prepage}" class="null">��һҳ</a></li>[/prepage][pages][pnum]6[/pnum][pnumchar]<li><a href="javascript:;" class="before">{$page}</a></li>[/pnumchar][pnumurl]<li><a href="{$pnumurl}">{$pagenum}</a></li>[/pnumurl]{$pages}[/pages][nextpage]<li><a href="{$nextpage}">��һҳ</a></li>[/nextpage]<em class="pr10">��{$page}/{$totalpage}ҳ</em></ul>');
@define('JIEQI_ERROR_MODE','0');
@define('JIEQI_ALLOW_REGISTER','1');
@define('JIEQI_DENY_RELOGIN','0');
@define('JIEQI_DATE_FORMAT','Y-m-d');
@define('JIEQI_TIME_FORMAT','H:i:s');
@define('JIEQI_REDIS_HOST','127.0.0.1');
@define('JIEQI_REDIS_PORT',6666);
@define('JIEQI_SESSION_EXPRIE','86400');
@define('JIEQI_SESSION_STORAGE','redis');
@define('JIEQI_SESSION_SAVEPATH','tcp://'.JIEQI_REDIS_HOST.':'.JIEQI_REDIS_PORT."?persistent=1");
@define('JIEQI_COOKIE_DOMAIN','suixinmh.com');
@define('JIEQI_CUSTOM_INCLUDE','0');
@define('JIEQI_ENABLE_CACHE','0');
@define('JIEQI_CACHE_LIFETIME','600');
@define('JIEQI_CACHE_DIR','cache');
@define('JIEQI_COMPILED_DIR','compiled');
@define('JIEQI_USE_GZIP','0');
@define('JIEQI_SILVER_USAGE','1');
@define('JIEQI_CHARSET_CONVERT','0');
@define('JIEQI_AJAX_PAGE','0');
@define('JIEQI_EGOLD_NAME','���');
@define('JIEQI_FORM_MAX','100%');
@define('JIEQI_FORM_MIDDLE','580');
@define('JIEQI_FORM_MIN','400');
@define('JIEQI_MAX_PAGES','0');
@define('JIEQI_PROMOTION_VISIT','0');
@define('JIEQI_PROMOTION_REGISTER','0');


/**
 * ���԰�-ϵͳͨ�����Ա�������
 *
 * ���԰�-ϵͳͨ�����Ա�������
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    system
 * @copyright  Copyright (c) QQ329222795
 * @author     $Author: huliming $
 * @version    $Id: lang_system.php 193 2014-07-25 02:52:44Z huliming $
 */

define('LANG_NO_PERMISSION', '�Բ�������Ȩ���ʸ�ҳ�棡'); 
define('LANG_NEED_ADMIN', '�Բ���ֻ��ϵͳ����Ա����ʹ�ñ����ܣ�');
define('LANG_NEED_LOGIN', '�Բ�������Ҫ��¼����ʹ�ñ����ܣ�');
define('LANG_NO_USER', '�Բ��𣬸��û������ڣ�');
define('LANG_DO_SUCCESS', '����ɹ�');
define('LANG_DO_FAILURE', '����ʧ��');
define('LANG_NOTICE', '�� ʾ');
define('LANG_SUBMIT', '�� ��');
define('LANG_RESET', '�� ��');
define('LANG_SAVE', '�� ��');
define('LANG_YES', '��');
define('LANG_NO', '��');
define('LANG_UNKNOWN', 'δ֪');
define('LANG_PLEASE_ENTER', '������%s');
define('LANG_NEED_ENTER', '%s��������');
define('LANG_ERROR_PARAMETER', '�Բ��𣬲�������');
define('LANG_DENY_PROXY', '�Բ��𣬱�վ��ֹͨ��������ʣ�');
define('LANG_DENY_POST', 'ϵͳϵͳά���У���ʱ�������½�ͷ���...');
define('LANG_MODULE_SYSTEM', 'ϵͳ����');
define('LANG_VERSION_FREE', '��Ѱ�');
define('LANG_VERSION_POPULAR', '�ռ���');
define('LANG_VERSION_STANDARD', '��׼��');
define('LANG_VERSION_PROFESSION', 'רҵ��');
define('LANG_VERSION_ENTERPRISE', '��ҵ��');
define('LANG_VERSION_DELUXE', '������');
define('LANG_VERSION_CUSTOM', '���ư�');

$jieqiGroups['1'] = '�ο�';
$jieqiGroups['2'] = 'ϵͳ����Ա';
$jieqiGroups['3'] = '��ͨ��Ա';
$jieqiGroups['4'] = '�߼���Ա';
$jieqiGroups['5'] = '���ݺ���';
$jieqiGroups['6'] = 'ר������';
$jieqiGroups['7'] = 'רְ����';
$jieqiGroups['8'] = 'ǩԼ�༭';
$jieqiGroups['9'] = '���α༭';
$jieqiGroups['10'] = '����';
$jieqiGroups['11'] = '��ְ����';
$jieqiGroups['12'] = '��վ��������Ա';
$jieqiGroups['13'] = '����ͷ�';
$jieqiGroups['14'] = '����רԱ';

?>