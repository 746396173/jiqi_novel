<?php
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset='.$this->_tpl_vars['jieqi_charset'].'" />
    <title>'.$this->_tpl_vars['article']['articlename'].'�����½�,С˵'.$this->_tpl_vars['article']['articlename'].'ȫ���Ķ�-'.$this->_tpl_vars['jieqi_sitename'].'</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
    <meta name="keywords" content="'.$this->_tpl_vars['article']['articlename'].','.$this->_tpl_vars['article']['articlename'].'С˵,'.$this->_tpl_vars['article']['articlename'].'ȫ���Ķ�,'.$this->_tpl_vars['article']['articlename'].'�޵���">
    <meta name="description" content="'.$this->_tpl_vars['article']['articlename'].'Ϊ'.$this->_tpl_vars['article']['author'].'���Ĵ���,'.$this->_tpl_vars['jieqi_sitename'].'�ṩ'.$this->_tpl_vars['article']['articlename'].'�����½���'.$this->_tpl_vars['article']['articlename'].'ȫ���Ķ�,����ͶƱ���ղ�֧��'.$this->_tpl_vars['article']['articlename'].'С˵,'.$this->_tpl_vars['article']['articlename'].'�޵�������Ķ�����'.$this->_tpl_vars['jieqi_sitename'].'��">
    <meta name="author" content="'.$this->_tpl_vars['article']['author'].'" />
    <meta name="copyright" content="'.$this->_tpl_vars['article']['articlename'].'" />
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/extend.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'fonts/iconfont.css">
    <style type="text/css">
        .content2{ width:95%; margin:2.5%; background:#FFF;padding-bottom:5%;}
        .content2 h2{ width:95%; height:40px; border-bottom:1px solid #b8d8ec; padding:2px 2.5%; font-size:18px;font-weight:normal; line-height: 40px;}
        .content2 ul{ overflow:hidden;}
        .content2 ul li{ width:95%; height:40px; line-height:40px; margin:0 2.5%; border-bottom:1px solid #ebebeb; overflow:hidden;}
        .content2 ul li a{ font-size:16px; line-height:40px; color:#27201f; overflow:hidden; float:left; display:block;}
        .fanye{
            width:300px;
            height:40px;
            margin:0 auto;
            text-align: center;
            position: relative;
        }
        .fanye div{
            position: absolute;
            top:10px;
        }
        .fanye a{
                 color:#fff!important;
                line-height: 30px;
        }
        .fanye div:nth-child(1),.fanye div:nth-child(3){
            width:70px;
            height:30px;
            background:#df3048;
        
            border-radius: 4px;
        }
        .fanye div:nth-child(1){
            left:0px;

        }
        .fanye div:nth-child(2){
             left:50%;
            margin-left: -25px;
        }
        .fanye div:nth-child(3){
           right:0px;
        }
        .fanye div.inbut select{
            width:50px;
            height:30px;
            border-radius: 4px;
            text-align: center;
           

        }
    </style>
    <script language="javascript">
        function read(a,c){
            document.location.href=\'/read/\'+a+\'/\'+c+\'.html\';
        }
    </script>
</head>
<body oncontextmenu="return false" onselectstart="return false" ondragstart="return false" onbeforecopy="return false" oncopy=document.selection.empty() onselect=document.selection.empty()>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/header.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '

<div class="plf10 ptb15 pr">Ŀ¼
			<span class="pa right10 top10 dib b bcRed br5 paixu clearfix">
			<a class="';
if($this->_tpl_vars['order']=='asc'){
echo ' dib ptb5 plf10 fl br bcRed bgcRed cfff';
}else{
echo 'dib ptb5 plf10 fl';
}
echo '" href="'.geturl('3g','catalog','SYS=aid='.$this->_tpl_vars['article']['articleid'].'&order=asc').'">����</a>
			<a class="';
if($this->_tpl_vars['order']=='desc'){
echo ' dib ptb5 plf10 fl br bcRed bgcRed cfff';
}else{
echo 'dib ptb5 plf10 fl';
}
echo '" href="'.geturl('3g','catalog','SYS=aid='.$this->_tpl_vars['article']['articleid'].'&order=desc').'">����</a>
		</span>
</div>
<!--con-->
<div class="lh25 c333 bgcfff f14 addList">
    <ul class="lh40">
        <li class="pr pl10 pr10 bb bcddd">
            <a class="cRed" href="'.geturl('3g','reader','SYS=aid='.$this->_tpl_vars['article']['articleid'].'&cid='.$this->_tpl_vars['article']['lastchapterid'].'').'">
                <span class="bgcRed cfff pl3 pr3 mr5">����</span>'.$this->_tpl_vars['article']['lastchapter'].'
            </a>
            <span class="pa f12 c888 right10">'.$this->_tpl_vars['article']['date'].'</span>
        </li>
        ';
if (empty($this->_tpl_vars['indexrows'])) $this->_tpl_vars['indexrows'] = array();
elseif (!is_array($this->_tpl_vars['indexrows'])) $this->_tpl_vars['indexrows'] = (array)$this->_tpl_vars['indexrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['indexrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['indexrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['indexrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['indexrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['indexrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
        <li class="pr pl10 pr10 bb bcddd" onclick="read('.$this->_tpl_vars['article']['articleid'].','.$this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['cid'].')">
            ';
if($this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['ctype'] == 'volume'){
echo '
            '.$this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['vname'].'
            ';
}else{
echo '
            <a href="'.geturl('3g','reader','SYS=aid='.$this->_tpl_vars['article']['articleid'].'&cid='.$this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['cid'].'').'">'.$this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['cname'];
if($this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['isvip'] == 1){
echo '<img src="'.$this->_tpl_vars['jieqi_themeurl'].'images/vip.jpg" />';
}
echo '
            <span class="pa f12 c888 right10">'.$this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['size_c'].'��</span></a>
            ';
}
echo '
        </li>
        ';
}
echo '
    </ul>
</div>
<div class="fanye">
    '.$this->_tpl_vars['url_jumppage'].'
</div>
<div class="content2">
    <h2 align="center" >�����ע���ںţ���������Ķ�</h2>
    <div class="con" align="center">
        <img src="'.$this->_tpl_vars['jieqi_themeurl'].'/images/weixin.jpg" /><br />
        <div align="left">
            &nbsp&nbsp&nbsp&nbsp��ܰ��ʾ��<br />
            &nbsp&nbsp&nbsp&nbsp1�������ʹ��΢���������ֱ�ӳ���ͼƬʶ���ά�룻<br />
            &nbsp&nbsp&nbsp&nbsp2�������ʹ�÷�΢����������ͼ��Ȼ��ʹ��΢��ɨһɨ >> ��� >> ɨ���ά���ע��</div>
    </div>
</div>
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