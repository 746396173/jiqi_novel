<?php
include_once("db.php");
check_level(99);





if ($_POST['action']) {
    $username=trim($_POST['username']);
	$level=trim($_POST['level']);
	$qd=trim($_POST['qd']);
	
    if (!$username) {
        jieqi_printfail("�������˺�");
        exit();
    }
    elseif (!$level) {
		jieqi_printfail("������Ȩ�޵ȼ�");
        exit();
    }
    elseif (!$qd) {
		jieqi_printfail("������������Χ");
        exit();
    }
    else {
        $d = query("select uid from jieqi_system_users where uname='$username'");
        if (!$d) {
			jieqi_printfail("û������û�");
        		exit();
        }
        else {
			$uid=$d['uid'];
            $sql = "insert into jieqi_system_qdadmin (uid,level,qd) values('$uid','$level','$qd')";
            query($sql);
            $errmsg="";
            $succmsg="����˻��ɹ�";
        }
    }
}


?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="GBK">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ishufun.net��̨����ϵͳ</title>
  <meta name="description" content="����һ�� index ҳ��">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="assets/css/admin.css">
  <style type="text/css">
  body,td,th {
	font-size: 10px;
}
  </style>
  <link href="jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
  <link href="jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<script src="jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">������ʹ��<strong>��ʱ</strong>���������Amaze UI �ݲ�֧�֡� �� <a href="http://browsehappy.com/" target="_blank">���������</a>
  �Ի�ø��õ����飡</p>
<![endif]-->

<header class="am-topbar admin-header">
  <div class="am-topbar-brand"><strong>Pinshu</strong><small>��̨����</small></div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">�����л�</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li></li>
      <li class="am-dropdown" data-am-dropdown>
      </li>
      <li></li>
    </ul>
  </div>
</header>

<div class="am-cf admin-main">
<?
include("menu.php");
?>

  <!-- content start -->
  <div class="admin-content">
<div class="am-g">
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" >
    <input type="hidden" name="action" value="1">
  <div class="am-u-sm-12">
      <? if ($errmsg) {
          echo "<font color=#FF0000>$errmsg</font>";
      }
      if ($succmsg) {
          echo $succmsg;
      }

      ?>
  <table width="95%" border="1" cellpadding="0" cellspacing="0">
  <tbody>

            <tr>
              <td width="14%" height="28">��½�˺�</td>
              <td width="86%">
                <input type="text" name="username" id="username"></td>
            </tr>
            <tr>
              <td height="28">Ȩ�޵ȼ�</td>
              <td>
                <input name="level" type="text" id="level" value="1"></td>
            </tr>
            <tr>
              <td height="28">�����������Χ</td>
              <td><input name="qd" type="text" id="qd">
                ����дʾ����all��ʾȫ����_�»���ģ��ƥ������һλ 1____ ��ʾ1��ͷ��5λ�ַ�)</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td><input type="submit" name="button" id="button" value="���"></td>
              </tr>

          </tbody>
      </table>
    </div>
      </form>
    </div>

    <div class="am-g"></div>
  </div>
  <!-- content end -->

</div>

<footer>
  <hr>
  <p class="am-padding-left">&copy; 2014 AllMobilize, Inc. Licensed under MIT license.</p>
</footer>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/polyfill/rem.min.js"></script>
<script src="assets/js/polyfill/respond.min.js"></script>
<script src="assets/js/amazeui.legacy.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/amazeui.min.js"></script>
<!--<![endif]-->
<script src="assets/js/app.js"></script>
</body>
</html>
