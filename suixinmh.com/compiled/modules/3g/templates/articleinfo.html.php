<?php
echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="'.$this->_tpl_vars['jieqi_charset'].'">
    <title>'.$this->_tpl_vars['articlename'].'��ҳ,'.$this->_tpl_vars['author'].','.$this->_tpl_vars['sort'].'-'.$this->_tpl_vars['jieqi_sitename'].'</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="keywords" content="'.$this->_tpl_vars['meta_keywords'].'"/>
    <meta name="description" content="'.$this->_tpl_vars['meta_description'].'"/>
    <meta name="author" content="'.$this->_tpl_vars['meta_author'].'"/>
    <meta name="copyright" content="'.$this->_tpl_vars['meta_copyright'].'"/>
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/animate.min.css">
    <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/jquery.alertable.css"/>
    <style>
        .supportlinks li {
            width: 20%;
            text-align: center;
            float: left;
        }

        .supportlinks li a {
            display: block;
            width: 90%;
            max-width: 100px;
            min-width: 50px;
            margin: 0 auto;
        }

        .supportlinks li a img {
            width: 100%;
        }

        .bbdar {
            border-bottom: 1px dashed #CCC;
        }

        .commTitle {
            color: #3361a7;
        }

        .commTitle span {
            width: 18px;
            height: 18px;
            line-height: 18px;
            color: #fff;
            display: inline-block;
            border-radius: 1px;
            font-size: 10px;
            text-align: center;
        }

        .commTitle span.span1 {
            background: #5acde6;
        }

        .commTitle span.span2 {
            background: #37a5f0
        }
        .commTitle span.span3 {
            background: #dc147d
        }

        .commTitle span.span4 {
            background: #cd8c14
        }
        .shade{
            position:fixed;
            left:0px;
            right:0px;
            bottom:0px;
            top:0px;
            background: rgba(0,0,0,0.2);
            z-index: 8888;
        }
        .myAlert{
            position: absolute;
            left:50%;
            top:50%;
            width: 90%;
            margin-left:-45%;
            margin-top:-45%;
            transform: -webkit-translate(-50%,-50%);
            transform: translate(-50%,-50%);
            border-radius: 10px;
            background: #fff;
            color:#686868;
            font-size:14px;
            padding-bottom:50px;
        }
        .myAlert .title{
            height:35px;
            line-height:35px;
            padding:0 10px;
            border-bottom: 1px solid #9E9E9E;
        }
        .myAlert .txt{
            padding:7px;
            margin:0px;
        }
        .myAlert .title span{
            float:right;
            width:50%;
            height:100%;
        }
        .myAlert .title span{
            text-align: right;
        }
        .myAlert .title a{ 
            color:#009688;
            text-decoration: none;
        }
        .myAlert ul{
            margin:0px;
            padding:0px;
            overflow: hidden;
            width: 100%;
            padding-left:1.5%;
            padding-bottom:5px;
            border-bottom: 1px solid #d1cece;
        }
        .myAlert ul li{
            box-sizing:border-box;
            list-style: none;
            float:left;
            width:31.111%;
            margin-left:1.2%;
            margin-top:10px;
            height:35px;
            line-height: 35px;
            text-align: center;
            background:#e1dddd;
            border-radius: 4px;
        }
        .myAlert li.active{
            background: #1e8c23;    
            color: #fff;
        }
        .myAlert dl{
            margin:0;
            font-size:12px;
        }
        .myAlert dt{
            padding:5px 0 5px 10px;
        }
        .myAlert dd{
            padding:3px 0px;
            margin-left:20px;
        }
        .myAlert dd a{
            color:#534f4f;
        }
        .myAlert .bnt{
            
            width:100%;
            position: absolute;
            bottom: 7px;
            text-align: center;
        }
        .myAlert .bnt a:hover{
            background::#ee1515!important;
        }
        .bnt a{
            text-decoration: none;
            display: inline-block;
             border:0px;
            height:35px;
            line-height: 35px;
            width:150px;
            background:#009688;
            color:#fff;
            border-radius: 5px;
            transition: all 1s;
            -moz-transition: all 1s;    /* Firefox 4 */
            -webkit-transition: all 1s; /* Safari �� Chrome */
            -o-transition: all 1s;
        }
        .myAlert em{
            font-style: normal;
            font-weight: bold;
            font-size:13px;
            color:#df3048;
            padding:0 2px;
        }
        .synopsis{
           overflow: hidden;
          text-overflow: ellipsis;
          display: -webkit-box;
        
         -webkit-box-orient: vertical;
        
        }
        .restrict{
            float:right;

            margin-top:4px;
            color:#7040a1; 
        }
    </style>
</head>

<body>
<!--nav-->
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/header.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '

<div class="p10 pr pl90" style="min-height: 110px;">
    <img class="w80 h110 pa left10" src="'.$this->_tpl_vars['url_image'].'" alt="">
    <div class="ml10">
        <h2 class="f16 c333 fwn tEllipsis">'.$this->_tpl_vars['articlename'].'</h2>
        <h2 class="f12 c666 fwn mt5">���ࣺ'.$this->_tpl_vars['sort'].'</h2>
        <h3 class="f12 c666 fwn mtb5">���£�'.date('m-d H:i',$this->_tpl_vars['lastupdate']).'<span class="ml10">';
if(intval($this->_tpl_vars['size_w'])>=1){
echo $this->_tpl_vars['size_w'].'��';
}else{
echo $this->_tpl_vars['size_c'];
}
echo '��</span></h3>
        <div class="lh1_6 c666 pr pr50 f14">��ע΢�Ź��ںš�ů��ʡ��������´��Ķ�<span class="pa right0 top0 p3 cfff f10 br3" style="background: #c8923d;">'.$this->_tpl_vars['fullflag_tag'].'</span></div>
    </div>
</div>
<table cellpadding="0" cellspacing="0" class="wp100 plf10 tc f14">
    <tbody>
    <tr>
        <td>
            <a href="'.geturl('3g','catalog','SYS=aid='.$this->_tpl_vars['articleid'].'').'" class="db bgcRed cfff h35 lh35 br2">��ʼ�Ķ�</a>
        </td>
        <td class="w10"></td>
        <td>
            <a href="'.geturl('3g','huodong','SYS=method=addBookCase&aid='.$this->_tpl_vars['articleid'].'').'" class="db b bcddd c666 bgcfff bsi h35 lh35 br2">�ղر���</a>
        </td>
    </tr>
    </tbody>
</table>
<div class="plf10 pt10 mtb10 bt bcddd">
    <ul class="clearfix tc">
        <li class="fl wpT30 fnItem1">
            <a href="javascript:;" class="db cOrange1">
                <b class="db f14">'.$this->_tpl_vars['vipvote'].'</b>
                <span class="db c333 lh25">ͶƱ</span>
            </a>
        </li>
        <li class="fl wpT30 bsi bl br bcddd fnItem2">
            <a href="javascript:;" class="db cOrange1">
                <b class="db f14">'.$this->_tpl_vars['votenum'].'</b>
                <span class="db c333 lh25">�Ƽ�</span>
            </a>
        </li>
        <li class="fl wpT30">
            <a href="#ds" class="db cOrange1">
                <b class="db f14">'.$this->_tpl_vars['rewardnum'].'</b>
                <span class="db c333 lh25">����</span>
            </a>
        </li>
    </ul>
</div>
<div class="bgcddd c666 f16 plf10 lh35">��Ʒ���</div>
<div class="p10 ti2 lh25 f14  synopsis " style="-webkit-line-clamp: 4;">
    '.$this->_tpl_vars['intro'].'
</div>
  <div class="pr10" style="overflow: hidden;">
        <span class="restrict">չ��</span>
 </div>
<!--�����ܲ�-->
<div class="mt10 bgcfff">
    <h1 class="mlf10 ptb10 f16" id="ds" style="color: #1fb3b6;border-bottom:#dad9d9 1px solid;">���ͣ����ͼ����ͣ�</h1>
    <div class="m10 pb15">
        <ul class="clearfix supportlinks">
            ';
if (empty($this->_tpl_vars['reward_item'])) $this->_tpl_vars['reward_item'] = array();
elseif (!is_array($this->_tpl_vars['reward_item'])) $this->_tpl_vars['reward_item'] = (array)$this->_tpl_vars['reward_item'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['reward_item']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['reward_item']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['reward_item']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['reward_item']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['reward_item']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
            <li>
                <a href="'.geturl('3g','huodong','SYS=method=reward&aid='.$this->_tpl_vars['articleid'].'&item='.$this->_tpl_vars['reward_item'][$this->_tpl_vars['i']['key']]['item'].'').'"><img src="'.$this->_tpl_vars['jieqi_themeurl'].'/reward/img/'.$this->_tpl_vars['reward_item'][$this->_tpl_vars['i']['key']]['pic'].'" alt="" /></a>'.$this->_tpl_vars['reward_item'][$this->_tpl_vars['i']['key']]['name'].'</li>
            ';
}
echo '
        </ul>
        <!--��������-->
        ';
if(empty($this->_tpl_vars['reward_list']) == 0){
echo '
        <div class="bgceee mt10">
            <ul class="p10 f12">
                <li class="lh25 f14 bb bcccc pb5">��������</li>
                ';
if (empty($this->_tpl_vars['claqueList'])) $this->_tpl_vars['claqueList'] = array();
elseif (!is_array($this->_tpl_vars['claqueList'])) $this->_tpl_vars['claqueList'] = (array)$this->_tpl_vars['claqueList'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['claqueList']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['claqueList']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['claqueList']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['claqueList']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['claqueList']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
                <li class="lh35 bbdar tEllipsis"><span class="mr5">'.$this->_tpl_vars['claqueList'][$this->_tpl_vars['i']['key']]['username'].'</span> ������ <span class="ml5 c333">'.$this->_tpl_vars['claqueList'][$this->_tpl_vars['i']['key']]['name'].'*'.$this->_tpl_vars['claqueList'][$this->_tpl_vars['i']['key']]['number'].'</span></li>
                ';
}
echo '
                <li class="mt10 tc f14"><a href="'.geturl('3g','huodong','SYS=method=claqueList&aid='.$this->_tpl_vars['articleid'].'').'">�鿴����������¼</a></li>
            </ul>
        </div>
        ';
}
echo '
    </div>
</div>
<!--�½�Ŀ¼-->
<div class="mt10 bgcfff">
    <h1 class="mlf10 ptb10 f16" style="color: #1fb3b6;border-bottom:#dad9d9 1px solid;">�½�Ŀ¼</h1>
    <div class="m10">
        <ul>
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
            <li class="bb bcddd ptb5">
                ';
if($this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['ctype'] == 'volume'){
echo '
                ';
}else{
echo '
                <a href="'.geturl('3g','reader','SYS=aid='.$this->_tpl_vars['articleid'].'&cid='.$this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['cid'].'').'" class="db f12 c666 lh20">
                    <span class="db">'.$this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['cname'];
if($this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['isvip'] == 1){
echo '<img src="'.$this->_tpl_vars['jieqi_themeurl'].'images/vip.jpg" />';
}
echo '</span>
                    <span class="db">���£�'.date('Y-m-d H:i',$this->_tpl_vars['indexrows'][$this->_tpl_vars['i']['key']]['lastupdate']).'</span>
                </a>
                ';
}
echo '
            </li>
            ';
}
echo '
        </ul>
    </div>
    <div class="tc mt10 pb10 f14">
        <a href="'.geturl('3g','catalog','SYS=aid='.$this->_tpl_vars['articleid'].'').'" class="db lh35 bgceee c666 br3">�鿴�����½�</a>
    </div>
</div>
<!--statr ���� -->
<div class="shade" style="display: none;">
        <div class="myAlert animated bounceIn">
            <div class="title"><span><a href="javascript:;" class="close">�ر�</a></span></div>  
             <p class="txt">�Ȿ��̫����,�Ҿ���ҪͶƱ</p> 
             <ul class="ticket" style="display: none;">
                <li>1����Ʊ</li>
                <li>2����Ʊ</li>
             </ul>
             <ul class="ticket">
                <li class="active">1��Ʊ</li>
                <li>2��Ʊ</li>
                <li>3��Ʊ</li>
                <li>4��Ʊ</li>
                <li>5��Ʊ</li>
                <li>6��Ʊ</li>
             </ul>
                <dl class="prompt1" style="display: none;">
                  <dt>��ܰ��ʾ��</dt>
                  <dd>����ǰ������Ʊ��<em class="series"> '.$this->_tpl_vars['vip_maxvote'].'</em>�š���������ʹ��<em class="series"> '.$this->_tpl_vars['pollnum'].' </em>����Ʊ������Ͷ<em class="series">  ';
echo $this->_tpl_vars['maxvote']-$this->_tpl_vars['pollnum']; 
echo ' </em>��</dd>
                  <dd>�Ե�����ƷͶ��Ʊ��ͶƱ����Ϊ<em class="series"> 2 </em>�ţ�</dd>
                  <dd>�������ѶԵ�ǰ��ƷͶ��<em class="series"> '.$this->_tpl_vars['yitou'].'</em>����Ʊ������Ͷ<em class="series"> ';
echo 2-$this->_tpl_vars['yitou']; 
echo ' </em>�ţ�</dd>
                  <dd>ÿͶ1����Ʊ�������ɻ��<em class="series">  '.$this->_tpl_vars['vip_getscore'].'</em>���֡�</dd>
                  <dd>ÿһ���Դ��ͱ���<em class="series"> 1000 </em>��ң�������1��������Ʊ��û�����ޡ�</dd>
                  <dd><a  href="'.geturl('3g','help').'" target="_blank" class="f_blue5">�鿴��Ʊ��÷�����ʹ�ù���&gt;&gt; </a></dd>
                </dl>
                 <dl class="prompt1">
                  <dt>��ܰ��ʾ��</dt>
                  <dd>��ÿ����Ͷ�Ƽ�ƱΪ<em>'.$this->_tpl_vars['maxvote'].'</em>�ţ������Ѿ�ʹ��<em>'.$this->_tpl_vars['pollnum'].'</em>��:</dd>
                   ';
if(($this->_tpl_vars['maxvote']-$this->_tpl_vars['pollnum'])>0) { 
echo '<dd>������ʣ���Ƽ�Ʊ��Ϊ<em class="series"> ';
echo $this->_tpl_vars['maxvote']-$this->_tpl_vars['pollnum']; 
echo ' </em>��</dd>';
}else{ 
echo '
     <dd class="series">��Ǹ����������Ƽ�Ʊ�����꣬����������</dd>';
} 
echo '
                  
                  <dd>ÿ��1���Ƽ�Ʊ�������ɻ��<em class="series"> '.$this->_tpl_vars['getscore'].' </em>���֡�</dd>
      <dd class="series"><a href="'.geturl('3g','help').'" target="_blank" class="f_blue4">��λ���Ƽ�Ʊ��</a></dd>
                </dl>
                <div class="bnt">
                    <a href="#">ȷ��ͶƱ</a>
                </div>
         </div>
</div>
<!-- end ���� -->
<div class="mt10 bgcfff p10">
    <div class="pb10 f16 clearfix" style="border-bottom: #dad9d9 1px solid;color: #1fb3b6;">����
        <a href="'.geturl('3g','reviews','SYS=aid='.$this->_tpl_vars['articleid'].'').'" class="dib f12 cfff fr tc w70 lh25" style="background: #9f9386;">��������</a>
    </div>
    ';
if(!empty($this->_tpl_vars['reviewrows']) == 1){
echo '
    ';
if (empty($this->_tpl_vars['reviewrows'])) $this->_tpl_vars['reviewrows'] = array();
elseif (!is_array($this->_tpl_vars['reviewrows'])) $this->_tpl_vars['reviewrows'] = (array)$this->_tpl_vars['reviewrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['reviewrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['reviewrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['reviewrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['reviewrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['reviewrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
    <div class="pl35 ptb10 pr bb bcddd" style="min-height:30px;">
        <div class="pa left0 top10 w30 h30 oh br3">
            <!--<img src="'.$this->_tpl_vars['reviewrows'][$this->_tpl_vars['i']['key']]['avatar'].'" class="wp100" alt="" />-->
        </div>
        <div class="commTitle">
            '.$this->_tpl_vars['reviewrows'][$this->_tpl_vars['i']['key']]['poster'].'
        </div>
        <div class="lh20">'.truncate($this->_tpl_vars['reviewrows'][$this->_tpl_vars['i']['key']]['posttext'],'150','����','1').'</div>
    </div>
    ';
}
echo '
    ';
}
echo '

    <div class="tc mt10 f14">
        <a href="'.geturl('3g','reviews','SYS=aid='.$this->_tpl_vars['articleid'].'').'" class="db lh35 bgceee c666 br3">�鿴��������</a>
    </div>
</div>

';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/bottom.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
</body>

 <script src="'.$this->_tpl_vars['jieqi_themeurl'].'js/jquery.min.js"></script>
 <script src="'.$this->_tpl_vars['jieqi_themeurl'].'js/share/jquery.alertable.min.js"></script>
 <script>
    /*start��������*/
    var index=0;
    var stat=1;
      $(".fnItem1,.fnItem2").on("click",function(){
           index=$(this).index();
           $(".shade").show();
           $(".ticket,.prompt1").hide();
           $(".ticket").eq(index).show();
           $(".prompt1").eq(index).show();

      })
      //ѡƱ
      $(".ticket li").on("click",function(){
         stat=$(this).index()+1;
         $(this).siblings().removeClass("active");
         $(this).addClass("active");
                
      });
      /*��������*/
       $(".shade").on("click",function(ev) {
           // body...
           if(ev.target==this){
               $(this).hide();
                stat=1;
                $(".ticket li").siblings().removeClass("active");
                $(".ticket li").eq(0).addClass("active");
           }
       })
       $(".close").on("click",function(ev) {
           // body...
          
               $(".shade").hide();
                stat=1;
                $(".ticket li").siblings().removeClass("active");
                $(".ticket li").eq(0).addClass("active");
           
       })
       $(".myAlert .bnt").on("click",function(){
          var formhash="';
echo form_hash(); 
echo '";
          var _url=index==0?"'.geturl('3g','huodong','SYS=method=vipvote&aid='.$this->_tpl_vars['articleid'].'').'":"'.geturl('3g','huodong','SYS=method=vote&aid='.$this->_tpl_vars['articleid'].'').'";
          $.ajax({
                 type: \'POST\',
                 url: _url ,
                 dataType:"json",
                 data:{"formhash":formhash,"stat":stat},
                 success: function(data){
                        console.log(data);
                        if(data.stat=="succ"){
                             $.alertable.alert(data.msg);
                             setTimeout(function() {
                                 window.location.reload();
                             },2000);
                            
                        }
                        else{
                          $.alertable.alert(data.msg);
                        }
                      
                       
                      
              
                } 
                           
            }); 


       })
       /*end ����*/
       /*�ſ������������*/
       $(".restrict").on(\'click\',function(){
            if($(this).text()=="չ��"){
                $(this).text("����");
                $(".synopsis").attr("style","");
            }
            else{
                  $(this).text("չ��");
                 $(".synopsis").attr("style","-webkit-line-clamp: 4;");
            }
      
       })

 </script>
</html>
';
?>