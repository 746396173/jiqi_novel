<?php
@define('JIEQI_URL','http://yun.mmd6666.com');
@define('YOUYUEBOOK_URL','http://www.mmd6666.com');
@define('YOUYUEBOOK_URL_M','http://m.mmd6666.com');

@define('JIEQI_SITE_NAME','youyueС˵');
@define('JIEQI_CONTACT_EMAIL','');
@define('JIEQI_MAIN_SERVER','');
@define('JIEQI_USER_ENTRY','');
@define('JIEQI_SITE_KEY','');
@define('JIEQI_META_KEYWORDS','����, ������, ����С˵��, �ÿ���С˵������С˵, ����С˵����ʷС˵������С˵������С˵��ԭ��������ѧ');
@define('JIEQI_META_DESCRIPTION','����С˵���ṩ���顢���ɡ�У԰����ʷ�����С���塢���졢���¡����á���á��������������ƻá���Ϸ��ͬ�˵�����С˵�����Ķ�������С˵��-www.mmd6666.com');
@define('JIEQI_META_COPYRIGHT','Copyright @ 2014-2016 mmd6666.com �����Ķ��� Allrights Reserved ��Ȩ����');
@define('JIEQI_BANNER','');
@define('JIEQI_LICENSE_KEY','');
@define('JIEQI_DB_TYPE','mysql');
@define('JIEQI_DB_CHARSET','gbk');
@define('JIEQI_DB_PREFIX','jieqi');
@define('JIEQI_DB_HOST','10.24.33.222');
@define('JIEQI_DB_USER','xiaoshuo');
@define('JIEQI_DB_PASS','p7p9bVQ3fvJWezuC');
@define('JIEQI_DB_NAME','youyuebook');
@define('JIEQI_DB_PCONNECT','1');
@define('JIEQI_IS_OPEN','1');
@define('JIEQI_CLOSE_INFO','��վϵͳά���У�Ԥ��3��00�ָ������Ժ����......');
@define('JIEQI_PROXY_DENIED','1');
@define('JIEQI_THEME_SET','v1');
@define('JIEQI_TOP_BAR','');
@define('JIEQI_BOTTOM_BAR','<a href="http://www.miitbeian.gov.cn/" target="_blank" style="color:#FFFFFF">��ICP��16032081��-1</a> ���ݾ�Ծ����Ƽ����޹�˾��Ȩ����');

@define('JIEQI_PAGE_TAG','<div> <span id="page_totalcount_span" style="width:auto;padding:0 6px;">{$totalcount} ����¼ {$page}/{$totalpage} ҳ</span> [firstpage]<a class="end" href="{$firstpage}">1</a>[/firstpage][prepage] <a class="pre" href="{$prepage}"></a> [/prepage] [pages] [pnumchar] <span class="current">{$page}</span> [/pnumchar] [pnumurl] <a class="num" href="{$pnumurl}">{$pagenum}</a> [/pnumurl] {$pages} [/pages] [nextpage] <a class="next" href="{$nextpage}"></a> [/nextpage] [lastpage] <a class="end" href="{$lastpage}">{$totalpage}</a> [/lastpage] </div>');


@define('JIEQI_ERROR_MODE','0');
@define('JIEQI_ALLOW_REGISTER','1');
@define('JIEQI_DENY_RELOGIN','0');
@define('JIEQI_DATE_FORMAT','Y-m-d');
@define('JIEQI_TIME_FORMAT','H:i:s');

@define('JIEQI_REDIS_HOST','10.24.33.222');
@define('JIEQI_REDIS_PORT',6666);
@define('JIEQI_SESSION_EXPRIE','86400');
@define('JIEQI_SESSION_STORAGE','redis');
@define('JIEQI_SESSION_SAVEPATH','tcp://'.JIEQI_REDIS_HOST.':'.JIEQI_REDIS_PORT."?persistent=2");


@define('JIEQI_COOKIE_DOMAIN','yun.mmd6666.com'); 
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
@define('WECHAT_PAY_TYPE_WEB',2); // 1Ϊ����֧����2Ϊ�Լ���΢��֧��
@define('MINIMUM_MONEY',100); // ��͵����ֽ��
@define('PAY_SYN_MONEY_QD',0.85); // ����ת���ֽ����
@define('PAY_SYN_MONEY_TK',0.10); // �ƹ��ת���ֽ����
@define('JIEQI_REDIS_FIX','NEWADMIN_'); // 


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

$jieqiGroups['1'] = '����';
$jieqiGroups['2'] = '����';
$jieqiGroups['3'] = '����';
$jieqiGroups['6'] = '�ƿ�';
$jieqiGroups['7'] = '�Լ�����';


$jieqiGroups['8'] = 'ǩԼ�༭';
$jieqiGroups['9'] = '���α༭';
$jieqiGroups['10'] = '����';
$jieqiGroups['11'] = '��ְ����';
$jieqiGroups['12'] = '��վ��������Ա';
$jieqiGroups['13'] = '����ͷ�';
$jieqiGroups['14'] = '����רԱ';


$feeTypeAr=array('0'=>'�����','1'=>'��ۼ�','2'=>'����');

?>