<?php
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=" />
<title>��Աר��</title>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
<meta name="keywords" content="'.$this->_tpl_vars['meta_keywords'].'" />
<meta name="description" content="'.$this->_tpl_vars['meta_description'].'" />
<meta name="author" content="'.$this->_tpl_vars['meta_author'].'" />
<meta name="copyright" content="'.$this->_tpl_vars['meta_copyright'].'" />
<link href="'.$this->_tpl_vars['jieqi_themeurl'].'style/member.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/extend.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'fonts/iconfont.css">
<script src="'.$this->_tpl_vars['jieqi_themeurl'].'js/jquery.min.js"></script>
</head>

<body class="padbar">
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/header.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
<div class="wrap2 clearfix">
  <ul class="tab2 clearfix" id="tabs">
    <li class="col-x-6';
if($this->_tpl_vars['_REQUEST']['method']=='uservip'){
echo ' thistab';
}
echo '"><a href="javascript:;">VIP�ȼ�</a></li>
    <li class="col-x-6';
if($this->_tpl_vars['_REQUEST']['method']=='usermember'){
echo ' thistab';
}
echo '"><a href="javascript:;">��Ա����</a></li>
  </ul>
  <div id="tab_conbox">
   <div';
if($this->_tpl_vars['_REQUEST']['method']=='usermember'){
echo ' style="display:none;"';
}
echo '>
    <p class="mylev"><span class="iv iv0"></span> ����'.$this->_tpl_vars['_USER']['vipgrade'].'����Ա����ǰVIP�ɳ�ֵ'.$this->_tpl_vars['_USER']['vip'].'��</p>    
    
    <span class="txtabox m12">
     <h3>VIP�ɳ���ϵ</h3>
     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablbg">
  <tr>
    <th width="40%" align="left" valign="middle" scope="col">VIP�ȼ�</th>
    <th width="60%" align="left" valign="middle" scope="col">�ɳ�ֵҪ��</th>
  </tr>
  <tr>
    <td align="left" valign="middle">VIP0</td>
    <td align="left" valign="middle">0</td>
  </tr>
  <tr>
    <td align="left" valign="middle">VIP1</td>
    <td align="left" valign="middle">100</td>
  </tr>
  <tr>
    <td align="left" valign="middle">VIP2</td>
    <td align="left" valign="middle">5000</td>
  </tr>
  <tr>
    <td align="left" valign="middle">VIP3</td>
    <td align="left" valign="middle">20000</td>
  </tr>
  <tr>
    <td align="left" valign="middle">VIP4</td>
    <td align="left" valign="middle">40000</td>
  </tr>
  <tr>
    <td align="left" valign="middle">VIP5</td>
    <td align="left" valign="middle">70000</td>
  </tr>
  <tr>
    <td align="left" valign="middle">VIP6</td>
    <td align="left" valign="middle">100000</td>
  </tr>
</table>
     <p class="dwntxt clearfix">ÿ��ֵ1Ԫ���100��VIP�ɳ�ֵ<a href="/pay/" class="btn0 btnorg">��ֵ</a></p>
    </span><!--txtbox end-->
    
    <span class="txtabox m12">
     <h3>�ȼ���Ȩ</h3>
     <ul>
      <li>(1)�����½ڶ����ۿۣ��ȼ�Խ���ۿ�Խ�࣬��߿���7.5�ۣ�</li>
      <li>(2)��Ա���ּ��٣��ȼ�Խ�߼��ٱ���Խ�ߣ�</li>
      <li>(3)ר��ͼ�꣬��ͬ�ȼ�VIP��Ա��ӵ�и���ר���ſ�ͼ�ꣻ</li>
      <li>(4)ÿ����Ʊ���ͣ��ȼ�Խ�߻�����ƱԽ�ࣻ</li>
      <li>(5)ÿ�ն��������Ƽ�Ʊ���ȼ�Խ�߻����Ƽ�ƱԽ�ࣻ</li>
      <li>(6)VIP1�������ϵȼ���Ա���Բ�����Ʒ��Ʊ��ѡ��</li>
     </ul>
     <p class="dwntxt clearfix"></p>
    </span><!--txtbox end-->
   </div><!--firstdiv end-->
   
   <div';
if($this->_tpl_vars['_REQUEST']['method']=='uservip'){
echo ' style="display:none;"';
}
echo '>    
    <p class="mylev"><span class="is is1"></span> ����ǰ�û�����Ϊ'.$this->_tpl_vars['_USER']['honor'].'������Ա����'.$this->_tpl_vars['_USER']['score'].'��</p>   
    
    <span class="txtabox m12">
     <h3>��Ա������ϵ</h3>
     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablbg">
  <tr>
    <th width="30%" scope="col">�û��ȼ�</th>
    <th width="30%" scope="col">���</th>
    <th width="40%" scope="col">����Ҫ��</th>
  </tr>
  <tr>
    <td>1��</td>
    <td>�б�</td>
    <td>0</td>
  </tr>
  <tr>
    <td>2��</td>
    <td>�ϵȱ�</td>
    <td>200</td>
  </tr>
  <tr>
    <td>3��</td>
    <td>��ʿ</td>
    <td>500</td>
  </tr>
  <tr>
    <td>4��</td>
    <td>��ʿ</td>
    <td>1000</td>
  </tr>
  <tr>
    <td>5��</td>
    <td>��ʿ</td>
    <td>2000</td>
  </tr>
  <tr>
    <td>6��</td>
    <td>׼ξ</td>
    <td>3000</td>
  </tr>
  <tr>
    <td>7��</td>
    <td>��ξ</td>
    <td>5000</td>
  </tr>
  <tr>
    <td>8��</td>
    <td>�г�</td>
    <td>7000</td>
  </tr>
  <tr>
    <td>9��</td>
    <td>��ξ</td>
    <td>9000</td>
  </tr>
  <tr>
    <td>10��</td>
    <td>��ξ</td>
    <td>11000</td>
  </tr>
  <tr>
    <td>11��</td>
    <td>��У</td>
    <td>15000</td>
  </tr>
  <tr>
    <td>12��</td>
    <td>��У</td>
    <td>20000</td>
  </tr>
  <tr>
    <td>13��</td>
    <td>��У</td>
    <td>25000</td>
  </tr>
  <tr>
    <td>14��</td>
    <td>��У</td>
    <td>30000</td>
  </tr>
  <tr>
    <td>15��</td>
    <td>�ٽ�</td>
    <td>40000</td>
  </tr>
  <tr>
    <td>16��</td>
    <td>�н�</td>
    <td>50000</td>
  </tr>
  <tr>
    <td>17��</td>
    <td>�Ͻ�</td>
    <td>60000</td>
  </tr>
  <tr>
    <td>18��</td>
    <td>��</td>
    <td>70000</td>
  </tr>
  <tr>
    <td>19��</td>
    <td>Ԫ˧</td>
    <td>80000</td>
  </tr>
  <tr>
    <td>20��</td>
    <td>��Ԫ˧</td>
    <td>100000</td>
  </tr>
</table>
    
    <span class="txtabox m12 mx0">
     <h3>���ֻ��;��</h3>
     <ul>
      <li>(1)ע�᣺���û�ע�ᣬ����10��;</li>
      <li>(2)��¼��5��/�죻������¼3�����ϣ��ɻ�ø������;</li>
      <li>(3)�ղأ�2��/�죬���մ�������;</li>
      <li>(4)���ͣ������麣��*20%�����մ�������;</li>
      <li>(5)Ͷ�Ƽ�Ʊ��2��/�ţ��������ޣ�</li>
      <li>(6)������������������5��/�Σ������ظ�2��/�Σ���������20��/�Σ���������</li>
      <li>(7)��ֵ����ֵ���*50����������</li>
      <li>(8)����VIP�½ڣ��½���*2����������</li>
      <li>(9)Ͷ��Ʊ��5��/�ţ���������</li>
     </ul>
    </span><!--txtbox end-->

   </div><!--seconddiv end-->
  
  
  </div> <!--tab_conbox end--> 
</div>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/bottom.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
<script>
$(function(){
	$("#tabs li").click(function(){
		var activeindex = $("#tabs").find("li").index(this);//alert(activeindex);
		$(this).addClass("thistab").siblings("li").removeClass("thistab");
		$("#tab_conbox").children().eq(activeindex).show().siblings().hide();
	});
});
</script>
</body>
</html>
';
?>