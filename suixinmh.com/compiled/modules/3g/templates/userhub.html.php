<?php
$this->_tpl_vars['jieqi_pagetitle'] = "我的账户-最新原创小说大全-{$this->_tpl_vars['jieqi_sitename']}";
echo '
';
$this->_tpl_vars['meta_keywords'] = '最新小说,原创小说,小说大全,小说库';
echo '
';
$this->_tpl_vars['meta_description'] = "{$this->_tpl_vars['jieqi_sitename']}书库提供最新的原创小说大全，提供各类网络小说在线阅读，希望大家支持{$this->_tpl_vars['jieqi_sitename']}!";
echo '
<!DOCTYPE html>
<html>

    <head>
        <meta charset="'.$this->_tpl_vars['jieqi_charset'].'">
        <title>个人中心</title>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="Cache-Control" content="no-transform " />
        <meta name="keywords" content="'.$this->_tpl_vars['meta_keywords'].'" />
        <meta name="description" content="'.$this->_tpl_vars['meta_description'].'" />
        <meta name="author" content="'.$this->_tpl_vars['meta_author'].'" />
        <meta name="copyright" content="'.$this->_tpl_vars['meta_copyright'].'" />
        <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'css/common.css">
        <link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'fonts/iconfont.css">
      
        <style>
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
            .ps input[type=text],.ps input[type=password]{
                width:95%;
                margin:0 auto;
                height:30px;
                outline:none;
                -webkit-tap-highlight-color: rgba(0,0,0,0); 
                padding-left:10px;
                border:1px solid #bcbbbb;
                border-radius:5px;
                box-shadow: 1px 1px 5px #cdcaca;

            }
            .ps{
              padding-bottom:5px;
            }
            .ps input[type=submit]{ 
                outline:none;
                -webkit-tap-highlight-color: rgba(0,0,0,0); 
                background:#f0234e;
                height:30px;
                width:200px;
                border:none;
                border-radius: 5px;
                color:#fff;
                display: block;
                margin :0 auto;
                margin-top:5px;

            }
            .ps span{
                font-size:12px;
            }
            .ps .item {  
                float:right; clear:both;  
                 border-color: #b1aeae;  
                 margin-top:14px;
              
            } 
            .ps .dot-top {  
                font-size: 0;  
                line-height: 0;  
                border-width: 10px;  
            
                border-top-width: 0;  
                border-style: dashed;  
                border-bottom-style: solid;  
                border-left-color: transparent;  
                border-right-color: transparent;  
            }
            .ps .dot-bottom {  
                font-size: 0;  
                line-height: 0;  
                border-width: 10px;  
               
                border-bottom-width: 0;  
                border-style: dashed;  
                border-top-style: solid;  
                border-left-color: transparent;  
                border-right-color: transparent;  
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
        <!--账号信息-->
        <div class="mt10 bgcfff pb10 plf10">
            <h1 class="ptb10 f16 clearfix" style="color: #1fb3b6;border-bottom:#dad9d9 1px solid;">账号信息<span class="fr"><a class="f12" href="'.geturl('system','userhub','SYS=method=logout').'">退出登录</a></span>
            </h1>
            <div class="clearfix f14 lh30 mt10">'.$this->_tpl_vars['_USER']['username'].'（id:'.$this->_tpl_vars['_USER']['uid'].'）<span class="fr cOrange1"><a href="'.geturl('3g','pay').'" target="_self">立即充值</a></span></div>
            <div class="lh30 f14">余额：<span class="cRed">'.$this->_tpl_vars['_USER']['egolds'].'</span> '.$this->_tpl_vars['egoldname'].'
                <div class="dib commTitle ml5"><span class="span1">普</span></div>
            </div>
            <div class="lh30 f14">其他：<span class="cRed">'.$this->_tpl_vars['_USER']['esilvers'].'</span>
            书券
            </div>
            <div  class="lh30 f14">
                <span class="dengji_tit">我的等级：</span>
                ';
if($this->_tpl_vars['_USER']['vipphoto'] == 'goldvip'){
echo '
                <span class="dengji_con"><span class="vv v'.$this->_tpl_vars['_USER']['vipphoto'].'"></span>包年VIP</span>
                ';
}else{
echo '
                <span class="dengji_con"><span class="vv v'.$this->_tpl_vars['_USER']['vipphoto'].'"></span>'.$this->_tpl_vars['_USER']['vipgrade'].'级</span>
                ';
}
echo '
                <span class="tixi fr"><a href="'.geturl('3g','userhub','SYS=method=uservip').'">VIP成长体系</a></span>
            </div>
             

        </div>
        <!--积分相关-->
        <div class="mt10 bgcfff pb10 plf10">
            <h1 class="ptb10 f16" style="color:#1fb3b6;border-bottom:#dad9d9 1px solid;">积分相关
            </h1>
            <div class="f14 pt15 pb10">
                <span class="cOrange1">'.$this->_tpl_vars['_USER']['score'].'</span> 积分
                  <div class="tixi fr"><a href="'.geturl('3g','userhub','SYS=method=usermember').'">会员积分体系</a></div>
            </div>
        </div>
    
        <div class="f15 lh40 mt10  bgcfff plf10">
            <ul>
           <!--      <li class="bb bcddd lastbb"><a href="bindOther.html" class="cOrange1 db">绑定其他账号登录</a></li>
                <li class="bb bcddd lastbb"><a href="setAccount.html" class="cOrange1 db">设置登录账号</a></li> -->
                <li class="bb bcddd lastbb"><a href="'.geturl('3g','userhub','SYS=method=czView').'" class="db">充值记录</a></li>
                <li class="bb bcddd lastbb"><a href="'.geturl('3g','userhub','SYS=method=xfView').'" class="db">订阅记录</a></li>
               
                 <li class="bb bcddd lastbb ps">
                   <a href="javascript:;" class="db keybut">修改密码  <span class="item dot-bottom"></span></a>
                    <form action="'.geturl('3g','userhub','SYS=method=updatePwd').'" method="post">
                        <div class="xgmm" style="display: none;">
                            <p>
                                <span>旧的密码</span>
                                <input type="password" name="oldpass" placeholder="请输入旧的密码" />
                            </p>
                            <p>
                                <span>新的密码</span>
                                <input type="password" name="newpass" placeholder="请输入新的密码" />
                             
                            </p>
                            <p>
                               <span>重复密码</span>
                                <input type="password" name="repass" placeholder="请再次输一次新的密码" />
                                <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
                            </p>
                            <p>
                                <input type="hidden" name="action" id="action" value="update" />
                                <input type="submit" class="submit" value="提交" />
                            </p>
                        </div>
                    </form>
                 </li>

            </ul>
        </div>
       
    ';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/bottom.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
     <script src="'.$this->_tpl_vars['jieqi_themeurl'].'js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $("a.keybut").click(function(){
                var box = $("div.xgmm");
                if(box.is(":hidden")){
                    box.show();
                    $(this).find("span").removeClass("dot-bottom");
                      $(this).find("span").addClass("dot-top");
                }else{
                    box.hide();
                      $(this).find("span").removeClass("dot-top");
                      $(this).find("span").addClass("dot-bottom");
                }

            });

        });
    </script>
    </body>


</html>';
?>