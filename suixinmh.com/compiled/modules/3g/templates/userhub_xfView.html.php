<?php
echo '<!DOCTYPE html>
<html>

    <head>
        <meta charset="'.$this->_tpl_vars['jieqi_charset'].'">
       <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta http-equiv="Cache-Control" content="no-transform " /> 
        <meta name="keywords" content="'.$this->_tpl_vars['meta_keywords'].'" />
        <meta name="description" content="'.$this->_tpl_vars['meta_description'].'" />
        <meta name="author" content="'.$this->_tpl_vars['meta_author'].'" />
        <meta name="copyright" content="'.$this->_tpl_vars['meta_copyright'].'" />
        <title>³äÖµ¼ÇÂ¼</title>
        <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css">
        <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'fonts/iconfont.css">
        <style>
            .chargeTable td {
                border-top: #eee 1px solid;
            }
            table th,table td{
                font-weight: 500;
               
            }
            .activeH2{
                border-bottom: 2px solid #D50D56;
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
        ';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/paylogin.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
        <div class="clearfix cardtype bgcfff m10 plf10 br5">
            <h2 class="fwn f16 c333 lh40 fl mr20"><a href="'.geturl('3g','userhub','SYS=method=czView').'">³äÖµ¼ÇÂ¼</a></h2>
            <h2 class="fwn f16 c333 lh40 fl  activeH2"><a href="'.geturl('3g','userhub','SYS=method=xfView').'">¶©ÔÄ¼ÇÂ¼</a></h2>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="lh35 tc chargeTable">
                <tr bgcolor="#EEEEEE" class="f14">
                    <th scope="col">Êé±Ò</th>
                    <th scope="col">¶©ÔÄ</th>
                    <th scope="col">Ê±¼ä</th>
                </tr>
               ';
if (empty($this->_tpl_vars['pay'])) $this->_tpl_vars['pay'] = array();
elseif (!is_array($this->_tpl_vars['pay'])) $this->_tpl_vars['pay'] = (array)$this->_tpl_vars['pay'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['pay']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['pay']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['pay']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['pay']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['pay']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	$this->_tpl_vars['aid']=$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['articleid'];$this->_tpl_vars['cid']=$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['chapterid'];$this->_tpl_vars['bg']=$this->_tpl_vars['i']['order']%2; 
echo '
                <tr ';
if($this->_tpl_vars['bg'] == 1){
echo ' class="line"';
}
echo '>
                    <td><div class="shb"><span>'.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['saleprice'].'</span>';
echo JIEQI_EGOLD_NAME; 
echo '</div></td>
                    <td><a href="/read/'.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['articleid'].'/'.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['chapterid'].'.html">¶©ÔÄ¡¶'.truncate($this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['articlename'],'18','¡­').'¡·</a><br/><a href="/read/'.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['articleid'].'/'.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['chapterid'].'.html"><span class="zhang">'.truncate($this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['chaptername'],'23','¡­').'</span></a></td>
                    <td><span class="time">'.date('Y-m-d H:i:s',$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['buytime']).'</span></td>
                </tr>
                ';
}
echo '
            </table>
            <div class="fanye">
                '.$this->_tpl_vars['url_jumppage'].'
            </div>
        </div>
        <div class="p10 mb10">
            <a href="'.geturl('3g','userhub').'" class="cRed f14">·µ»Ø¸öÈËÖÐÐÄ</a>
        </div>
        <!--footer-->
      ';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/bottom.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
    </body>
    <script src="'.$this->_tpl_vars['jieqi_themeurl'].'js/jquery.min.js"></script>
</html>';
?>