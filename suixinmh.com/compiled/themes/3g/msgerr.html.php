<?php
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='.$this->_tpl_vars['jieqi_charset'].'" />
<title>������ʾ</title>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
<meta http-equiv="Cache-Control" content="no-transform " /> 
<link href="'.$this->_tpl_vars['jieqi_themeurl'].'style/registration_failed.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css">
     <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/promptPage.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'fonts/iconfont.css">
   <meta http-equiv="refresh" content=\'2; url=';
echo JIEQI_REFER_URL; 
echo '\'>

</head>

<body>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/header.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
<div class="shibaitit">
��ܰ��ʾ
</div>
<div class="img"><img src="'.$this->_tpl_vars['jieqi_themeurl'].'images/fail.gif"></div>
<p class="shibai">��������</p>
<p class="yuanyin">'.$this->_tpl_vars['errorinfo'].'<br />'.$this->_tpl_vars['debuginfo'].'</p>
<p class="jishi"><span>2</span>���ҳ�潫�Զ�������һ��ҳ��</p>
<p>
	<a href="';
echo JIEQI_REFER_URL; 
echo '" class="fhbut">����</a>
</p>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/bottom.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
</body>
</html>















';
?>