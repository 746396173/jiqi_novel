<?php
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='.$this->_tpl_vars['jieqi_charset'].'" />
<title>��������</title>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
<meta http-equiv="Cache-Control" content="no-transform " /> 
<meta name="keywords" content="'.$this->_tpl_vars['meta_keywords'].'" />
<meta name="description" content="'.$this->_tpl_vars['meta_description'].'" />
<meta name="author" content="'.$this->_tpl_vars['meta_author'].'" />
<meta name="copyright" content="'.$this->_tpl_vars['meta_copyright'].'" />
<link href="'.$this->_tpl_vars['jieqi_themeurl'].'style/help_center.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/extend.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'fonts/iconfont.css">
</head>

<body>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/header.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/nav.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/search.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
<div class="content1">
	<h1 id="tabs1"><a href="'.geturl('3g','help','SYS=method=main&helpno=1001').'" ';
if(!isset($this->_tpl_vars['_REQUEST']['helpno'])==1 ||$this->_tpl_vars['_REQUEST']['helpno']<='2000'){
echo ' class="thistab"';
}
echo '>��������</a><a href="'.geturl('3g','help','SYS=method=main&helpno=2101').'" ';
if($this->_tpl_vars['_REQUEST']['helpno']>='2001'){
echo ' class="thistab"';
}
echo '>���߰���</a></h1>
	<div class="main" id="tab_conbox1">
    	<ul class="cjwt tab1" ';
if($this->_tpl_vars['helpno']>=2001){
echo ' style="display:none;"';
}
echo $this->_tpl_vars['helpno'].'>
        	<li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1001){
echo ' maintithover';
}
echo '"><span>1��'.$this->_tpl_vars['jieqi_sitename'].'�ֻ�վ�˺ſ���ͨ����</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1001').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1001){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1001){
echo ' style=" display:none;"';
}
echo '>
                	���ԡ�'.$this->_tpl_vars['jieqi_sitename'].'��վ���ֻ�վ�Ѿ�ʵ�����˻���ͨ�������������վע���˺ţ����������ֻ�վ�ٴ�ע�ᣬ��ֵ�����ġ��ղ���ȫͬ����
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1002){
echo ' maintithover';
}
echo '"><span>2������������ô�죿</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1002').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1002){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1002){
echo ' style=" display:none;"';
}
echo '>
				    ����ϵ��վ�ͷ��޸����롣�ͷ�QQ��1964668087��
                	<!--�ڵ�¼���������������룿����֮����ת���һ�����ҳ�档Ŀǰ�ṩͨ��ע�������һ�����ķ���-->
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1003){
echo ' maintithover';
}
echo '"><span>3������޸����룿</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1003').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1003){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1003){
echo ' style=" display:none;"';
}
echo '>
                	��¼������վ��ҳ��������ǳƽ���������ģ�֮������˻�ҳ�棬��ῴ���޸������ѡ�
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1004){
echo ' maintithover';
}
echo '"><span>4����β鿴���ղص��鼮��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1004').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1004){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1004){
echo ' style=" display:none;"';
}
echo '>
                	��¼�󣬵����վ��ҳ���Ͻǵ��Ķ���ʷͼ�꣬�����������ܡ���ť�����߽����������ҳ�棬�������ܡ����鿴�����ղء�
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1005){
echo ' maintithover';
}
echo '"><span>5�����ֻ�����γ�ֵ��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1005').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1005){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1005){
echo ' style=" display:none;"';
}
echo '>
                	'.$this->_tpl_vars['jieqi_sitename'].'�ֻ�վĿǰ��ͨ���ֻ����ų�ֵ���ܣ��������£�<br />��1������ҳ�����е������ֵ����<br />��2��ѡ���ֵ�ֻ����ͣ�<br />��3��ѡ���ֵ��<br />��4�������ֵ�ֻ��ţ�������ύ����<br />�����ݳ�ֵ�������ڴ���
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1006){
echo ' maintithover';
}
echo '"><span>6����ֵ���˻��������û�䣿</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1006').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1006){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if(helpno!=1006){
echo ' style=" display:none;"';
}
echo '>
                	����취��<br />��1��ˢ�µ�ǰҳ�棻<br />��2���˳������µ�¼��<br />��3���������2�ַ�����Ч����ô����û�г�ֵ�ɹ�������ϵ��վ�ͷ����ͷ�QQ��1964668087��
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1007){
echo ' maintithover';
}
echo '"><span>7����β鿴�����¼��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1007').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1007){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1007){
echo ' style=" display:none;"';
}
echo '>
                	��¼�󣬽����������ҳ�棬����������¼�����鿴���ĳ�ֵ��¼�����Ѽ�¼��
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1008){
echo ' maintithover';
}
echo '"><span>8��Ϊʲô���޷��Ķ�VIP�½ڣ�</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1008').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1008){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1008){
echo ' style=" display:none;"';
}
echo '>
                	VIP�½���Ҫ���ĺ�����Ķ�����ֵ��ѡ����Ҫ����VIP�½ڲ�����ʾ֧��'.$this->_tpl_vars['egoldname'].'����󼴿��Ķ���
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1009){
echo ' maintithover';
}
echo '"><span>9��ΪʲôҪ������VIP��Ա��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1009').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1009){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1009){
echo ' style=" display:none;"';
}
echo '>
                	��ΪVIP��Ա����������������Ȩ��<br />��1������VIP�½ڣ�<br />��2������ϲ������ƷͶ��Ʊ��<br />��3��ӵ��VIP��Աר��ͼ�ꣻ<br />��4��������Ȩ����Ա���ּ��٣������ۿۣ�ÿ���Ƽ�Ʊ���͡�
                </div>
            </li>
            <li>
            	<div class="maintit ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1010){
echo ' maintithover';
}
echo '"><span>10����γ�ΪVIP��Ա��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=1010').'" ';
if(isset($this->_tpl_vars['_REQUEST']['helpno'])==1 && $this->_tpl_vars['helpno']==1010){
echo ' class="ahover"';
}
echo '></a></div>
                <div class="maincon" ';
if($this->_tpl_vars['helpno']!=1010){
echo ' style=" display:none;"';
}
echo '>
                	ͨ���ۻ�VIP�ɳ�ֵ������VIP�û��ȼ���ÿ��ֵ1Ԫ�ɻ��100��VIP�ɳ�ֵ���ɳ�ֵ��100�㣬��������ΪV??IP1����Ա��
                </div>
            </li>
        </ul>
        <ul class="dzhelp tab1" ';
if($this->_tpl_vars['helpno']<=2000){
echo ' style="display:none;"';
}
echo '>
        	<li>
            	<a href="'.geturl('3g','help','SYS=method=main&helpno=2101').'" class="dzhelptit"><span>';
if($this->_tpl_vars['helpno']>=2101 && $this->_tpl_vars['helpno']<2200){
echo '-';
}else{
echo '+';
}
echo '</span>��ֵ</a>
            	<ul ';
if($this->_tpl_vars['helpno']<2101 || $this->_tpl_vars['helpno']>=2200){
echo ' style="display: none"';
}
echo '>
                	<li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2101){
echo ' maintithover';
}
echo '"><span>1.��θ��˻���ֵ��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2101').'" ';
if($this->_tpl_vars['helpno']==2101){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2101){
echo ' style=" display:none;"';
}
echo '>
                            ��¼֮������ҳ�������������ֵ����ť�����߽����������ҳ��������ֵ����
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2102){
echo ' maintithover';
}
echo '"><span>2.��ֵ�󲻵�����ô�죿</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2102').'" ';
if($this->_tpl_vars['helpno']==2102){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2102){
echo ' style=" display:none;"';
}
echo '>
                            '.$this->_tpl_vars['egoldname'].'��δ���˿���������ԭ����ɵģ�<br />��1�����ڳ�ֵ�����϶࣬���Գ�ֵͨ��ӵ������ֵ�ɹ��ٶȾͻ�������<br />��2�������ύ��ȥ֮��ϵͳҪ�����ݽ��к˶Բſ��Ը����ɹ�����ʧ�ܵĽ����<br />���30������û�е��ˣ���������ϵ��վ�ͷ���<br />�ͷ�QQ��1964668087
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2103){
echo ' maintithover';
}
echo '"><span>3.��ֵ���˻��������û�䣿</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2103').'" ';
if($this->_tpl_vars['helpno']==2103){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2103){
echo ' style=" display:none;"';
}
echo '>
                            ����취��<br />��1��ˢ�µ�ǰҳ�棻<br />��2���˳������µ�¼��<br />��3���������2�ַ�����Ч����ô����û�г�ֵ�ɹ�������ϵ��վ�ͷ���<br />�ͷ�QQ��1964668087��
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2104){
echo ' maintithover';
}
echo '"><span>4.��β鿴�ҵĳ�ֵ��¼��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2104').'" ';
if($this->_tpl_vars['helpno']==2104){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2104){
echo ' style=" display:none;"';
}
echo '>
                           ��¼֮�󣬽����������ҳ�棬����������¼������ῴ�����ĳ�ֵ��¼��
                        </div>
                    </li>
                </ul>
            </li>
            <li>
            	<a href="'.geturl('3g','help','SYS=method=main&helpno=2201').'" class="dzhelptit"><span>';
if($this->_tpl_vars['helpno']>=2201 && $this->_tpl_vars['helpno']<2300){
echo '-';
}else{
echo '+';
}
echo '</span>����</a>
            	<ul ';
if($this->_tpl_vars['helpno']<2201 || $this->_tpl_vars['helpno']>=2300){
echo ' style="display: none"';
}
echo '>
                	<li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2201){
echo ' maintithover';
}
echo '"><span>1.Ϊʲô���޷��Ķ�VIP�½ڣ�</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2201').'" ';
if($this->_tpl_vars['helpno']==2201){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2201){
echo ' style=" display:none;"';
}
echo '>
                            VIP�½���Ҫ���ĺ�����Ķ�����ֵ��ѡ����Ҫ����VIP�½ڲ�����ʾ֧��'.$this->_tpl_vars['egoldname'].'����󼴿��Ķ���
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2202){
echo ' maintithover';
}
echo '"><span>2.VIP�鼮��ô�շѵģ�</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2202').'" ';
if($this->_tpl_vars['helpno']==2202){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2202){
echo ' style=" display:none;"';
}
echo '>
                            ��վVIP���ݰ���200��1��'.$this->_tpl_vars['egoldname'].'�����շ�,��ÿ200������Ҫ֧��0.01Ԫ,Խ�ߵȼ���VIP�����ۿ�Խ��
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2203){
echo ' maintithover';
}
echo '"><span>3.��ֵ���������Ķ�VIP�½ڣ�</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2203').'" ';
if($this->_tpl_vars['helpno']==2203){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2203){
echo ' style=" display:none;"';
}
echo '>
                            ���ǡ�VIP�½���Ҫ�����ĺ�����Ķ����Ұ���200��1'.$this->_tpl_vars['egoldname'].'���мƷѡ�
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2204){
echo ' maintithover';
}
echo '"><span>4.�����VIP�½��޷��Ķ���</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2204').'" ';
if($this->_tpl_vars['helpno']==2204){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2204){
echo ' style=" display:none;"';
}
echo '>
                            ������������ϵͳ���⣬����ϵ��վ�ͷ�������ͷ�QQ��1964668087��
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2205){
echo ' maintithover';
}
echo '"><span>5.VIP�Ķ���Ҫ���¸�����</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2205').'" ';
if($this->_tpl_vars['helpno']==2205){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2205){
echo ' style=" display:none;"';
}
echo '>
                            ����Ҫ���Ѿ������VIP�½���������ʱ����Ķ���
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2206){
echo ' maintithover';
}
echo '"><span>6.��β鿴�ҵĶ��ļ�¼��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2206').'" ';
if($this->_tpl_vars['helpno']==2206){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2206){
echo ' style=" display:none;"';
}
echo '>
                            ��¼֮�󣬽����������ҳ�棬����������¼������ῴ���������Ѽ�¼��
                        </div>
                    </li>
                </ul>
            </li>
            <li>
            	<a href="'.geturl('3g','help','SYS=method=main&helpno=2301').'" class="dzhelptit"><span>';
if($this->_tpl_vars['helpno']>=2301 && $this->_tpl_vars['helpno']<2400){
echo '-';
}else{
echo '+';
}
echo '</span>��Ʊ</a>
            	<ul ';
if($this->_tpl_vars['helpno']<2301 || $this->_tpl_vars['helpno']>=2400){
echo ' style="display: none"';
}
echo '>
                	<li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2301){
echo ' maintithover';
}
echo '"><span>1.ʲô����Ʊ��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2301').'" ';
if($this->_tpl_vars['helpno']==2301){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2301){
echo ' style=" display:none;"';
}
echo '>
                            ��Ʊ��VIP��Ա�û�ר�е�Ʊ�֣�������ѡ'.$this->_tpl_vars['jieqi_sitename'].'ǩԼ��Ʒ����Ʊ�����������ڸ�������ҳ��鿴��
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2302){
echo ' maintithover';
}
echo '"><span>2.��λ����Ʊ��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2302').'" ';
if($this->_tpl_vars['helpno']==2302){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2302){
echo ' style=" display:none;"';
}
echo '>
                            Ŀǰ�����Ʊ�ķ�ʽ���������֣�<br />��1��VIP��Աͨ�������½����ѣ��ﵽָ����׼�����VIP�ȼ�������Ʊ��<br />��2��VIP��Ա���δ�����Ʒ1000'.$this->_tpl_vars['egoldname'].'�������1��������Ʊ�������ޡ�<br />ע�����»�õ�������Ʊ������һ�������ӵ��û��˻��С�
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2303){
echo ' maintithover';
}
echo '"><span>3.��Ʊʹ�ù���</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2303').'" ';
if($this->_tpl_vars['helpno']==2303){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2303){
echo ' style=" display:none;"';
}
echo '>
                            ��1��ֻ�ܶ�'.$this->_tpl_vars['jieqi_sitename'].'��ǩԼ����ƷͶ��Ʊ��<br />��2��Ͷ��Ʊʱ��ѡ����ҪͶ��Ʊ������ͶƱ��ĿǰVIP��Ա�Ե�����Ʒÿ������Ͷ2����Ʊ��<br />��3��������Ʊ���������׺�������Ʊ��һ�ɵ�����Ч���������ϣ�����������ʹ�á�
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2304){
echo ' maintithover';
}
echo '"><span>4.���Ͷ��Ʊ��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2304').'" ';
if($this->_tpl_vars['helpno']==2304){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2304){
echo ' style=" display:none;"';
}
echo '>
                            �����鼮����ҳ�棬����Ʒ��̬�������Ͷ��Ʊ����ť��Ϊ��ϲ������ƷͶ��һƱ��
                        </div>
                    </li>
                </ul>
            </li>
            <li>
            	<a href="'.geturl('3g','help','SYS=method=main&helpno=2401').'" class="dzhelptit"><span>';
if($this->_tpl_vars['helpno']>=2401 && $this->_tpl_vars['helpno']<2500){
echo '-';
}else{
echo '+';
}
echo '</span>��ȯ</a>
            	<ul ';
if($this->_tpl_vars['helpno']<2401 || $this->_tpl_vars['helpno']>=2500){
echo ' style="display: none"';
}
echo '>
                	<li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2401){
echo ' maintithover';
}
echo '"><span>1��ʲô����ȯ��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2401').'" ';
if($this->_tpl_vars['helpno']==2401){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2401){
echo ' style=" display:none;"';
}
echo '>
                            ����ȯ��'.$this->_tpl_vars['jieqi_sitename'].'������һ������ң���'.$this->_tpl_vars['egoldname'].'��ֵ��������VIP�½ڶ��ġ�
                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2402){
echo ' maintithover';
}
echo '"><span>2����ȯ��ʹ�÷�Χ</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2402').'" ';
if($this->_tpl_vars['helpno']==2402){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2402){
echo ' style=" display:none;"';
}
echo '>
                            ����ȯ��'.$this->_tpl_vars['jieqi_sitename'].'ȫվͨ�ã�����'.$this->_tpl_vars['jieqi_sitename'].'��Wapվ���ֻ��ͻ��ˣ�����������ʹ�����ƣ�<br />��1����ȯ���������½ڶ��ģ���֧����Ʒ���͵����ѹ��ܣ�<br />��2��ʹ����ȯ���Ľ��޷���ö�����Ʊ��<br />��3��ʹ����ȯ����VIP�½ڣ��������û�Ա���֡�

                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2403){
echo ' maintithover';
}
echo '"><span>3����λ����ȯ��</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2403').'" ';
if($this->_tpl_vars['helpno']==2403){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2403){
echo ' style=" display:none;"';
}
echo '>
                            ��Ŀǰ��'.$this->_tpl_vars['jieqi_sitename'].'�û�����ͨ������;���������ȯ��<br />��1��VIP��Ա����������ȯ
<br />��2���������µ�'.$this->_tpl_vars['egoldname'].'���Ѷ�ȣ���һ�·�����ȯ
<br />���㹫ʽ�����·�����ȯ����s=����'.$this->_tpl_vars['egoldname'].'���Ѷ��m*5%
<br />ע�����Ѱ������ĺʹ��͡�
<br />��3��ÿ��ǩ��������ȯ
<br />�ۼ�ǩ����7�죬����20��ȯ���ۼ�ǩ����15�죬����30��ȯ���ۼ�ǩ��һ���£�����50��ȯ��
<br />��4����Ϊ'.$this->_tpl_vars['jieqi_sitename'].'ǩԼ���ߣ�����5000��ȯ
<br />��5���μ��ض�������ȯ
<br />'.$this->_tpl_vars['jieqi_sitename'].'�ᶨ�ھ��и������ݷḻ�Ļ��ֻҪ�μ���Щ������л����÷�����ȯ������

                        </div>
                    </li>
                    <li>
                        <div class="maintit ';
if($this->_tpl_vars['helpno']==2404){
echo ' maintithover';
}
echo '"><span>4����ȯ��ʹ�÷���</span><a href="'.geturl('3g','help','SYS=method=main&helpno=2404').'" ';
if($this->_tpl_vars['helpno']==2404){
echo ' class="ahover"';
}
echo '></a></div>
                        <div class="maincon" ';
if($this->_tpl_vars['helpno']!=2404){
echo ' style=" display:none;"';
}
echo '>
                            ����ȯ��������VIP�½ڶ��ģ��������£�
<br />��1������ǰ10��VIP�½ڣ�Ĭ������ʹ����ȯ�ֿ�֧��������ȯ���㣬������'.$this->_tpl_vars['egoldname'].'���룻
<br />��2��ǰ10�������VIP�½ڣ��ڶ���ʱ��'.$this->_tpl_vars['egoldname'].'����ȯ����һ�������۳�������ȯ���㣬����'.$this->_tpl_vars['egoldname'].'����

                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/bottom.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/js.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
</body>
</html>

';
?>