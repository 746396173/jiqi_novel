<?php
echo '<!DOCTYPE html>
<html>

    <head>
        <meta charset="'.$this->_tpl_vars['jieqi_charset'].'">
        <title>�û�ע��-'.$this->_tpl_vars['SITE_WAP_URL'].'</title>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="keywords" content="'.$this->_tpl_vars['meta_keywords'].'" />
        <meta name="description" content="'.$this->_tpl_vars['meta_description'].'" />
        <meta name="author" content="'.$this->_tpl_vars['meta_author'].'" />
        <meta name="copyright" content="'.$this->_tpl_vars['meta_copyright'].'" />
        <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css"/>
        <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/extend.css"/>
        <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'fonts/iconfont.css"/>
        <style>
            html,
            body {
                background: #fff;
            }
            .lists{
                 display: -webkit-flex;
                display: flex;
                justify-content:center;
            }
        </style>
    </head>
    <body oncontextmenu="return false" onselectstart="return false" ondragstart="return false" onbeforecopy="return false" oncopy=document.selection.empty() onselect=document.selection.empty()>
        <div class="clearfix lh55 h55 bgcPink cfff tc f16">
            <a href="/" class="iconfont fl f18 cfff pl10">&#xe602;</a>
            ���ע��
            <a href="'.geturl('3g','login','SYS=jumpurl='.$this->_tpl_vars['jumpurl'].'').'" class="cfff fr f15 pr10">��¼</a>
        </div>
        <!--��������½-->
        <div class="">
            <div class="tc f14 mb10 mt10 c666"><b>��������¼</b></div>
            <ul class="clearfix tc wp80 mc lists">
                 <li class="wp25">
                    <a  class="db" href="javascript:;" onclick="location.href=\''.$this->_tpl_vars['SITE_WAP_URL'].'/qqlogin/?jumpurl=\'+document.getElementById(\'jumpurl\').value;" id="qqlogin">
                        <img width="47" height="47" src="'.$this->_tpl_vars['jieqi_themeurl'].'images/qq.png" alt="" />
                        <p class="pt5 pb5 c666">QQ�˺�</p>
                    </a>
                </li>
                <li class="wp25">
                    <a class="db" href="javascript:;" onclick="location.href=\''.$this->_tpl_vars['SITE_WAP_URL'].'/sinalogin/?jumpurl=\'+document.getElementById(\'jumpurl\').value;"><img width="47" height="47"
                        src="'.$this->_tpl_vars['jieqi_themeurl'].'images/weibo.png" alt="" />
                        <p class="pt5 pb5 c666">΢���˺�</p>
                    </a>
                </li>
              
                <li class="wp25">
                    <a class="db" href="javascript:;" onclick="location.href=\''.$this->_tpl_vars['SITE_WAP_URL'].'/wxlogin/?jumpurl=\'+document.getElementById(\'jumpurl\').value;" id="qqlogin"><img width="47" height="47" src="'.$this->_tpl_vars['jieqi_themeurl'].'images/weixin.png" alt="" />
                        <p class="pt5 pb5 c666">΢���˺�</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="pr tc p10" style="background:#fff url('.$this->_tpl_vars['jieqi_themeurl'].'images/line.png) repeat-x center center;"><span class="dib plf10 bgcfff c333 f14">��ʹ�ñ�վ�˺ŵ�¼</span></div>
        <form action="'.geturl('3g','register').'" method="post" id="regform">
            <div class="wp80 mc">
                <div class="mb20"><input type="text" class="bgcWhiteSmoke br0 p10 b bcddd wp100 bsi f14" placeholder="�˺ţ������˺�/����" name="username"/></div>
                <div class="mb20"><input type="text" class="bgcWhiteSmoke br0 p10 b bcddd wp100 bsi f14" placeholder="���룺6-10λ���ֻ�����ĸ" name="password"/></div>
              <!--   <div class="mb20 pr">
                    <input type="text" class="bgcWhiteSmoke br0 p10 b bcddd wp100 bsi f14" placeholder="����д��֤��" />
                    <a href="#" class="dib w80 h30 oh pa right5 top5"><img class="wp100 hp100" src="'.$this->_tpl_vars['jieqi_themeurl'].'images/code.jpg" alt="" /></a>
                </div> -->
                <div class="f14">
                    <input name="agree" type="checkbox" value="" class="vam mr5" />
                    <a href="'.$this->_tpl_vars['jieqi_themeurl'].'agreement.html">���Ѳ鿴��ͬ�����ء��û�ʹ��Э�顷</a>
                </div>
                <div class="mt20 mb30">
                    <a href="#" class="db lh40 h40 cfff f15 tc br3 bgcPink" onclick="document.getElementById(\'regform\').submit();">����ע��</a>
                </div>
            </div>
             <input type="hidden" name="jumpurl" id="jumpurl" value="'.urlencode($this->_tpl_vars['jumpurl']).'" />
            <input type="hidden" name="norepsw" value="1" />
            <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
        </form>
      ';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/bottom.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
    </body>

</html>';
?>