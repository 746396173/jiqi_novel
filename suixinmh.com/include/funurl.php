<?php 
/**
 * ���url·����غ���
 *
 * ���url·����غ���
 * 
 * ����ģ�壺��
 * 
 * @category   jieqicms
 * @package    system
 * @copyright  Copyright (c) Hangzhou Jieqi Network Technology Co.,Ltd. (http://www.jieqi.com)
 * @author     $Author: juny $
 * @version    $Id: funuser.php 243 2008-11-28 02:59:57Z juny $
 */

/**
 * �û���Ϣ���url
 * 
 * @param      int         $id �û�id
 * @param      string      $type ҳ������ 'info' - ������Ϣҳ, 'space' - ���˿ռ�ҳ(Ĭ��)
 * @access     public
 * @return     string
 */
function jieqi_url_system_user($id, $type=''){
	global $jieqiModules;
	switch($type){
		case 'info':
			return JIEQI_USER_URL.'/userinfo.php?id='.$id;
			break;
		case 'page':
			return JIEQI_USER_URL.'/userpage.php?uid='.$id;
			break;
		case 'space':
		default:
			return !empty($jieqiModules['space']['publish']) ? $jieqiModules['space']['url'].'/space.php?uid='.$id : JIEQI_USER_URL.'/userpage.php?uid='.$id;
			break;
	}
}
/**
 * �����û�ͷ��ͼƬurl
 * 
 * @param      int         $uid �û�id
 * @param      int         $size �������� 'd'=>ͼƬĿ¼��'o'=>ԭͼ, 'l'=>��ͼ(Ĭ��)��'m'=>��ͼ, 's'=>Сͼ, 'i'=>ͼ��, 'a'=>����ǰ�漸���ϲ�������
 * @param      int         $type ͼƬ���� -1 ϵͳ�Զ��жϣ�0 ��ͷ�� 1=>'.gif', 2=>'.jpg', 3=>'.jpeg', 4=>'.png', 5=>'.bmp'
 * @param      bool        $retdft ��ͷ���Ƿ񷵻�Ĭ��ͷ���ַ��true-�ǣ�Ĭ�ϣ���false-��
 * @access     public
 * @return     mixed
 */
function jieqi_url_system_avatar($uid, $size = 'l', $type = -1, $retdft = true){
	global $jieqiConfigs;
	global $jieqi_image_type;
	if(!isset($jieqiConfigs['system'])) jieqi_getConfigs('system', 'configs');
	if(empty($jieqi_image_type)) $jieqi_image_type=array(1=>'.gif', 2=>'.jpg', 3=>'.jpeg', 4=>'.png', 5=>'.bmp');
	$base_avatar = '';
	if($uid == 0 || $type == 0 || ($type > 0 && !isset($jieqi_image_type[$type]))){
		if($retdft){
			$base_avatar = JIEQI_USER_URL.'/images';
			$type = 2;
			$uid = 'noavatar';
		}else{
			return false;
		}
	}elseif($type < 0){
		return JIEQI_USER_URL.'/avatar.php?uid='.$uid.'&size='.$size;
		//��������òü����ܣ�ͳһͷ��ͼƬ .jpg������û�и�ֵͷ�����;��ó������
		//if(function_exists('gd_info') && $jieqiConfigs['system']['avatarcut']) $type = 2;
		//else return JIEQI_USER_URL.'/avatar.php?uid='.$uid.'&size='.$size;
	}
	$prefix = $jieqi_image_type[$type];
	if(empty($base_avatar)) $base_avatar = jieqi_uploadurl($jieqiConfigs['system']['avatardir'], $jieqiConfigs['system']['avatarurl'], 'system').jieqi_getsubdir($uid);
	switch($size){
		case 'd':
			return $base_avatar;
			break;
		case 'o':
			return $base_avatar.'/'.$uid.$prefix;
			break;
		case 'l':
			return $base_avatar.'/'.$uid.'l'.$prefix;
			break;
		case 'm':
			return $base_avatar.'/'.$uid.'m'.$prefix;
			break;
		case 's':
			return $base_avatar.'/'.$uid.'s'.$prefix;
			break;
		//case 'i':
			//return $base_avatar.'/'.$uid.'i'.$prefix;
			//break;
		case 'a':
		default:
			return array('l'=>$base_avatar.'/'.$uid.$prefix, 's'=>$base_avatar.'/'.$uid.'s'.$prefix, 'i'=>$base_avatar.'/'.$uid.'i'.$prefix, 'd'=>$base_avatar);
			break;
	}
	//�ж���û�������ļ���û����ʹ��Ĭ��ͷ��

}


/**
 * ����PATH_INFOα��̬URL
 * 
 * @param      string      $url Ĭ�ϵĶ�̬url
 * @param      string      $prefix α��̬��ַ��׺���� .html��Ĭ��Ϊ��
 * @access     public
 * @return     string
 */
function jieqi_url_system_pathinfo($url, $prefix=''){
	if(!in_array($prefix, array('.html', '.htm'))) $prefix='';
	$pos=strpos($url, '?');
	if($pos > 0){
		$parmary = explode('&', substr($url, $pos+1));
		$pstr='';
		foreach($parmary as $v){
			$tmpary = explode('=', $v);
			if(isset($tmpary[1])) $pstr.='/'.$tmpary[0].'/'.$tmpary[1];
		}
		return substr($url, 0, $pos).$pstr.$prefix;
	}else{
		return $url;
	}
}
/**
 * ����ģ���ǩ
 * 
 * @param      string        $tag ��ǩ��ʶ
 * @access     public
 * @return     string
 */
 function jieqi_url_system_tags($tag, $return = 'html'){
     global $_SGLOBAL,$_SCONFIG,$_OBJ,$jieqiModules;
	 //if(!defined('IN_JQNEWS')) @define('IN_JQNEWS', TRUE);
	 if(!defined('_ROOT_')) @define('_ROOT_', JIEQI_ROOT_PATH);
	 if(!is_array($tag)) $id = $tag;
	 else $id = $tag['id'];
	 include_once(JIEQI_ROOT_PATH.'/lib/my_position.php');
	 if(!is_object($_OBJ['position'])) $_OBJ['position'] = new MyPosition();
	 if($data = $_OBJ['position']->get($id)){
	     if($param = jieqi_exechars("<{!!!!}>", urldecode($tag['name']), true)){
		     if($param[0]) $data['setting']['vars'] = $param[0];
			 //echo $param[0];
			 if($param[1]) $data['setting']['template'] = $param[1];
		 }
	     $data['setting']['title'] = $data['name'];
		 switch($data['type']){
			 case '0':
				 $data['setting']['vars'] = $data['data'];
				 $data['setting']['side'] = 1;
				 $data['setting']['bid'] = $tag['id'];
				 $data['setting']['module'] = 'news';
				 $data['setting']['filename'] = 'block_commend';
				 $data['setting']['classname'] = 'BlockNewsCommend';
				 $data['setting']['contenttype'] = 1;
				 $data['setting']['custom'] = 0;
				 $data['setting']['publish'] = 3;
				 $data['setting']['hasvars'] = 2;
			 break;
			 case '2':
				 $data['setting']['vars'] = $data['setting']['content'];
				 $data['setting']['side'] = 1;
				 $data['setting']['bid'] = $id;
				 $data['setting']['module'] = 'system';
				 $data['setting']['filename'] = 'block_content';
				 $data['setting']['classname'] = 'BlockContent';
				 $data['setting']['contenttype'] = 1;
				 $data['setting']['custom'] = 0;
				 $data['setting']['publish'] = 3;
				 $data['setting']['hasvars'] = 2;
			 break;
			 default :
				 $data['setting']['side'] = 1;
				 $data['setting']['publish'] = 3;
			 break;
		 }
		 if($return == 'html'){
		     include_once(JIEQI_ROOT_PATH.'/header.php');
		     return jieqi_get_block($data['setting'],1);
		 } else {
		     $temp = '';
		     foreach($data['setting'] as $k=>$v){
			      if($temp) $temp.='&'.$k.'='.urlencode($v);
				  else $temp.=$k.'='.urlencode($v);
			 }
			 return htmlspecialchars_array('<script language="javascript" type="text/javascript" src="'.JIEQI_LOCAL_URL.'/app.php?id='.$id.'"></script>');
		 }
	 }else{
	     return "Data is error[".@urldecode($tag['name'])."]!";
	 }
 }

?>