<?php
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset='.$this->_tpl_vars['jieqi_charset'].'" />
    <title>'.$this->_tpl_vars['chapter']['title'].'-'.$this->_tpl_vars['article']['articlename'].'-'.$this->_tpl_vars['jieqi_sitename'].'�׷�</title>
    <meta name="keywords" content="'.$this->_tpl_vars['article']['articlename'].','.$this->_tpl_vars['article']['articlename'].'�����Ķ�">
    <meta name="description" content="'.$this->_tpl_vars['chapter']['title'].'��'.$this->_tpl_vars['jieqi_sitename'].'�������ȷ�����,��ӭ����Ķ�'.$this->_tpl_vars['chapter']['title'].'��һ��,'.$this->_tpl_vars['article']['articlename'].'�׷�'.$this->_tpl_vars['jieqi_sitename'].'www.shuhai.com��">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
    <meta http-equiv="Cache-Control" content="no-transform " />
    <meta name="copyright" content="" />
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'fonts/iconfont.css">
    <style>
        .content{
        width: 95%;
        margin: 10px auto;
        height: auto;
        background: #fff;
        overflow: hidden;
        }
        .content p.title {
        width: 95%;
        margin: 0 2.5%;
        height: 40px;
        border-bottom: 1px solid #c5c5c5;
        line-height: 40px;
        font-size: 18px;
        color: #2e2e2e;
        }
        .content p.chapter {
            line-height: 20px;
            font-size: 17px;
            color: #df3048;
            margin-top: 10px;
            margin-left: 2.5%;
        }
        .content p.name {
            line-height: 15px;
            font-size: 14px;
            margin-left: 2.5%;
            margin-top: 5px;
            color: #414141;
        }
        .content .details {
            width: 89%;
            height: auto;
            margin: 10px 2.5%;
            border: 1px solid #cecece;
            background: #f7f7f7;
            padding: 3%;
        }
        .content .details p.info {
            font-size: 14px;
            color: #3e3e3e;
            line-height: 30px;
        }
        .content .details p.yue {
             clear: both;
        }
        .content .details span.vip_icon {
            display: block;
            width: 53px;
            height: 15px;
            margin-top: 7px;
            margin-left: 2.5%;
        }
        .content a.pay{width: 46%;height: auto;background: #ff6666;display: inline-block;margin-left: 2.5%;line-height: 40px;color: #fff;text-align: center;border-radius: 5px;margin-bottom: 10px;float: left;}
        .content a.pay1{width: 92%;height: auto;background: #ff6666;display: inline-block;margin-left: 2.5%;line-height: 40px;color: #fff;text-align: center;border-radius: 5px;margin-bottom: 10px;float: left;}
        .content a.recharge{width: 46%;height: auto;background: #df3048;display: inline-block;margin-right: 2.5%;line-height: 40px;color: #fff;text-align: center;border-radius: 5px;float: right;}
        </style>
</head>

<body>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/header.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '

<div class="content">
    <p class="title">�½ڶ�����Ϣ</p>
    <p class="chapter"><img src="'.$this->_tpl_vars['jieqi_themeurl'].'images/vip.jpg"/>'.$this->_tpl_vars['chapter']['chaptername'].'</p>
    <p class="name">��'.$this->_tpl_vars['article']['articlename'].'��</p>
    <div class="details">
        <p class="info fl">�˻���<a href="'.geturl('3g','userhub').'">'.$this->_tpl_vars['_USER']['username'].'</a></p><span class="vip_icon fl v '.$this->_tpl_vars['_USER']['vipphoto'].'"></span>
        <p class="info yue">��ǰ��<span class="red">'.$this->_tpl_vars['_USER']['egolds'].'</span>'.$this->_tpl_vars['egoldname'].'/'.$this->_tpl_vars['_USER']['esilvers'].'��ȯ</p>
        <p class="info">�½�������';
echo (ceil($this->_tpl_vars['chapter']['size']/2)); 
echo '</p>
        <p class="info">����ԭ�ۣ�<span class="red">'.$this->_tpl_vars['chapter']['saleprice'].'</span>';
echo JIEQI_EGOLD_NAME; 
echo '</p>
        <p class="info">�ۺ�۸�';
if($this->_tpl_vars['vipgrade']['setting']['dingyuezhekou']>0){
echo $this->_tpl_vars['chapter']['saleprice']*$this->_tpl_vars['vipgrade']['setting']['dingyuezhekou']; 
echo JIEQI_EGOLD_NAME; 
}else{
echo '���ۿ�';
}
echo '</p>
        <p class="info">��';
if($this->_tpl_vars['vipgrade']['setting']['dingyuezhekou']>0){
echo $this->_tpl_vars['vipgrade']['caption'].'����';
echo $this->_tpl_vars['vipgrade']['setting']['dingyuezhekou']*10; 
echo '���½ڶ����Ż�';
}else{
echo $this->_tpl_vars['vipgrade']['caption'].'���������ܶ����ۿ�';
}
echo '��</p>
        <!--<p class="info">��������ʹ��';
if($this->_tpl_vars['chapter']['shuquan'] == ''){
echo '0';
}else{
echo $this->_tpl_vars['chapter']['shuquan'];
}
echo '��ȯ�ֿ�֧��</p>-->
        ';
if($this->_tpl_vars['_USER']['egolds'] < $this->_tpl_vars['chapter']['saleprice'] && $this->_tpl_vars['_USER']['esilvers'] < $this->_tpl_vars['chapter']['saleprice']){
echo '
        <p class="info">�ף������˻����㶩��Ŷ�������Ǯ֧��һ�°�</p>
        ';
}else{
echo '
        <p class="info">�������ģ��ӵ�ǰ�½��������к���VIP�½�</p>
        ';
}
echo '
    </div>
    ';
if($this->_tpl_vars['_USER']['egolds'] > $this->_tpl_vars['chapter']['saleprice'] || $this->_tpl_vars['_USER']['esilvers'] > $this->_tpl_vars['chapter']['saleprice']){
echo '
    <a href="'.geturl('3g','reader','SYS=method=buychapter&aid='.$this->_tpl_vars['article']['articleid'].'&cid='.$this->_tpl_vars['chapter']['chapterid'].'').'" class="pay">���ı���</a>
    ';
if($this->_tpl_vars['_USER']['egolds'] > $this->_tpl_vars['chapter']['saleprice']){
echo '
    <a href="'.geturl('3g','reader','SYS=method=xbuychapter&aid='.$this->_tpl_vars['article']['articleid'].'&cid='.$this->_tpl_vars['chapter']['chapterid'].'').'" class="pay">��������</a>
    ';
}
echo '
    ';
}else{
echo '
    <a href="'.geturl('3g','pay').'" class="pay1">��ֵ</a>
    ';
}
echo '
</div>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/bottom.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
</body>
</html>';
?>