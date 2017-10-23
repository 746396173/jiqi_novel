<?php
/*
	[JQ NEWS] (C) 2007-2008 CMS Inc.
	$Id: lang_showmessage.php 10870 2010-04-14 18:30:21Z huliming $
*/

if(!defined('IN_JQNEWS')) {
	exit('Access Denied');
}

$jieqiLang['news'] = array(

    //global
	'message_notice' => '��Ϣ��ʾ',
    'users_do_not_exists' => '���û�������',
	'data_not_exists' => 'ָ�������ݲ�����',
	'data_is_exists' => '�����Ѿ�����',
	'add_success' =>'�����ɹ�!',
	'edit_success' =>'�޸ĳɹ�!',
	'please_select_area' => '��ѡ�����',
	'please_select_type' => '��ѡ�����',
	'please_select_catid' => '��ѡ����Ŀ',
	'form_data_error' => '�뽫��������д����!',
    'to_login' => '����Ҫ�ȵ�¼���ܼ���������',
	'system_is_default' => 'ϵͳĬ��',
	'submit_invalid' => '����������·����ȷ�����֤���������޷��ύ���볢��ʹ�ñ�׼��web��������в�����',
	//attachment.php
	'not_upload_admin' =>'<font color=red>�Բ���,��û���ļ��ϴ�Ȩ�ޣ�</font>',
	'image_size_failure' =>'<font color=red>ͼƬ�ϴ�ʧ��,ͼƬ��С���ܳ��� \\1KB !</font>',
	'attach_size_failure' =>'�ļ��ϴ�ʧ��,������С���ܳ��� \\1KB !',
	'file_mime_failure' =>'ϵͳ��ֹ�ϴ� [\\1] MIME�����ļ�!',
	'file_extname_failure' =>'ϵͳ��ֹ��չ��Ϊ \\1 ���ļ��ϴ�!',
	'upload_max_filesize' =>'�ļ���С������ϵͳ���õ������ϴ����ֵ!',
	'file_upload_success' =>'�ļ��ϴ��ɹ�!',
	'cutfile_exists' =>'ͼƬ�Ѿ����ü���,�벻Ҫ�ظ�������ϵͳ���Զ�ѡ���Ѳü���ͼƬ!',
	'file_other_failure' =>'δ֪����!',
	//comment.inc.php
	'review_post_success' =>'�����ύ�ɹ���',
	'review_post_check' =>'�����ύ�ɹ����ȴ�����Ա��ˣ�',
	'review_post_failure' =>'д������ʱ��������������һ�Σ�',
	'review_minsize_limit' =>'�Բ����������ݲ������� \\1 �ֽڣ�',
	'review_maxsize_limit' =>'�Բ����������ݲ��ö��� \\1 �ֽڣ�',
	//admin/content.inc.php
	'article_not_pages' =>'����ҳ',
	'article_auto_pages' =>'�Զ���ҳ',
	'article_trigger_pages' =>'�ֶ���ҳ',
	'article_post_success' =>'�����ɹ�',
	'article_update_success' =>'�޸ĳɹ�',
	'article_title_exists' =>'���±�����ڣ�',
	'article_title_noexists' =>'���±��ⲻ���ڣ�',
	'article_delete_success' =>'�ɹ�ɾ�� <font color=\'blue\'>\\1</font> �����£�',
	'article_recycle_success' =>'�ɹ�ת�� <font color=\'blue\'>\\1</font> ������������վ��',
	'article_is_errors' => '��������²����ڻ�δͨ����ˣ�',
	//admin/selectfile.php
	'file_dir' =>'�ļ���',
	'file_dirtype' =>'<Ŀ¼>',
	//admin/model.inc.php
	'model_default_items' => 'ѡ��ֵ1|ѡ������1',
	'model_not_exists' => '�Բ��������ģ�Ͳ����ڣ�',
	'modelfield_not_exists' => '������ֶβ����ڣ�',
	'scorefield_not_edit' => '�����ֶβ�����༭��',
	'modelfield_is_exists' => '�ֶ����Ѵ��ڣ�',
	'modelfield_error' => ' �ֶ���ֻ����Ӣ����ĸ�����ֺ��»�����ɣ���������ĸ��ͷ�������»��߽�β',
	'modeltable_error' => ' ����ֻ����Ӣ����ĸ��������ɣ���������ĸ��ͷ',
	'modeltable_is_exists' => '�������Ѵ��ڣ�',
	//admin/create.inc.php
	'index_upload_success' => '��վ��ҳ���³ɹ���<br>��С�� <font color=\'blue\'>\\1</font>',
	'index_upload_failure' => '��վ��ҳ����ʧ��,����Ŀ¼ <font color=\'blue\'>\\1</font> �Ƿ��п�дȨ�ޣ�',
	'start_upload_category' => '��ʼ������Ŀҳ...',
	'not_upload_content' => '<font color=\'red\'>�����趨������û�в�ѯ����Ҫ���ɵ��������ݣ�</font>',
	'start_upload_next' => '<font color=\'blue\'>\\1</font> ��Ŀ����Ҫ���£���ʼ����...',
	'category_upload_success' => '<font color=\'blue\'>\\1</font> ��Ŀ������ɣ�',
	'category_page_upload_success' => '<font color=\'blue\'>\\1</font> ��Ŀ <font color=\'red\'>\\2</font> ҳ������ɣ�',
	'category_upload_failure' => '<font color=\'blue\'>\\1</font> ��Ŀ����ʧ��,���ݲ����ڻ���Ŀ¼û��дȨ�ޣ�',
	'show_upload_success' => '������� <font color=\'red\'>\\1</font> ����Ϣ<br />����� <font color=\'red\'>\\2</font> ����<font color=\'red\'>\\3</font>��,���� <font color=\'red\'>\\4</font> ��',
	'all_upload_success' => '������ɣ�',
	//admin/collect.php
	'all_collect_task' => 'ȫ���ɼ�����',
	'collect_article_success' => '��<font color=blue>\\1</font>���ɼ��ɹ���',
	'collect_article_failure' => '��<font color=blue>\\1</font>��д������ʱʧ�ܣ�',
	'collect_url_failure' => '��ȡ�Է���վʧ�ܣ������ǶԷ��޷����ʻ��߱���������ֹԶ�̶�ȡ��ҳ��<br />URL: <a href="\\1" target="_blank">\\2</a>',
	'collect_ajaxurl_failure' => '��ȡ�Է���վ����ʧ�ܣ���<a href="javascript:getPage(\\1);"><font color=blue>����</font></a>��<br />URL: <a href="\\2" target="_blank">\\3</a>',
	'parse_articleid_failure' => '����URL�ɼ�ʧ�ܣ������ǲɼ����������߶Է���վ��ʱ�޷��򿪣�<br />URL: <a href="\\1" target="_blank">\\2</a>',
	'pageid_collect_next' => '��ҳ�ɼ���ɣ������ɼ���һҳ�����¡�<br /><br />��ҳ�ǵ� \\1 ҳ���������ɼ� \\2 ҳ',
	'pageurl_collect_next' => '��ҳ�ɼ���ɣ������ɼ���һҳ�����¡�<br /><br />��һҳ��<a href="\\1">\\2</a>',
	'collect_title_exists' => '���¡�<font color=blue>\\1</font>���Ѿ����ڣ��Զ�������',
	'collect_fields_error' => '��\\1������ʧ�ܣ������ǶԷ���ҳ��ʽ�䶯���²ɼ��������<br />URL��<a href="\\2" target="_blank">\\3</a><br />',
	//admin/category.php
	'category_add_success' =>'��Ŀ��ӳɹ�!',
	'category_not_exists' => '�Բ���!ϵͳ�����ڴ�Ŀ¼��',
	'category_not_do' => '�Բ���!ϵͳ��ֹ������Ŀת�Ƶ�����Ŀ��',
	'category_exists_arrchild' => '���棺����Ŀ�´�����Ŀ¼��Ϊ��ϵͳ�����ȶ�����ֹ�˲�����'
);
?>