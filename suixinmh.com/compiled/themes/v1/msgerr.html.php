<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='.$this->_tpl_vars['jieqi_charset'].'" />
<title>������ʾ</title>
<link href="'.$this->_tpl_vars['jieqi_themecss'].'" type="text/css" rel="stylesheet" />
<!--[if IE 6]>
<script src="'.$this->_tpl_vars['jieqi_themeurl'].'js/DD_belatedPNG.js" type="text/javascript"></script>
<script type="text/javascript">
DD_belatedPNG.fix(\'div, ul, img, li, input,span,h3,h2,a\');
</script>
<![endif]-->
</head>

<body class="bg7">
<div class="pap">
   <em class="ico1"></em>
   <p class="tit">���ִ���</p>
  <p class="txt"><br />����ԭ��'.$this->_tpl_vars['errorinfo'].'<br />'.$this->_tpl_vars['debuginfo'].'<br />�� <a href="javascript:history.back(1)">�� ��</a> ������<br /><br /></p>
  <div class="dwn tc">
    <a href="javascript:window.close()" class="dbtn">��&nbsp;&nbsp;��</a>
    <div class="orn"></div>
  </div>
</div>
</body>
</html>
';
?>