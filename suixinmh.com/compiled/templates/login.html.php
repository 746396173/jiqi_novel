<?php
$this->_tpl_vars['jieqi_pagetitle'] = "用户登陆-{$this->_tpl_vars['jieqi_sitename']}";
echo '<link rel="stylesheet" rev="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'style/login.css" type="text/css" media="all" />
<link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.css" />
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/local/zh_CN.js"></script>
<div class="box_mid fix">
  <div class="login">
   <h3>用户登录</h3>
   <div id="result_14" class="tip-ok" style="display:none">登录成功</div>
<form id="login_form" class="signup" action="'.$this->_tpl_vars['url_login'].'" method="post" autocomplete="off">
<fieldset>
    <div class="form-item">
        <div class="field-name">用户名:</div>
        <div class="field-input">
          <input type="text" maxlength="30" name="username" data-rule="用户名:required"/>
        </div>
    </div>
    <div class="form-item">
        <div class="field-name">密码:</div>
        <div class="field-input">
          <input type="password" name="password" autocomplete="off" data-rule="密码:required;length[3~]" />
        </div>
    </div>
    <div class="form-item">
        <div class="field-name">验证码:</div>
        <div class="field-input">
          <input type="text" name="checkcode" class="yzm" maxlength="6" autocomplete=”off”/>
          <img src="'.$this->_tpl_vars['url_checkcode'].'" class="pic" id="checkcode" /><a id="recode" class="f_org2 pl10" href="javascript:;">换一张</a>
          <p><input name="usecookie" type="checkbox" value="1" checked="checked" class="check" />记住我(1个月免登录)</p>
        </div>
    </div>
</fieldset>';
 $this->_tpl_vars['url'] = JIEQI_LOCAL_URL;  
echo '
    <input type="hidden" name="jumpurl"  id="jumpurl" value="'.urlencode($this->_tpl_vars['jumpurl']).'">
    <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '">
<button id="btn-submit" class="btn-submit2" type="submit">登录</button>
<p class="snback f_blue"><br />忘记密码？点击<a href="'.geturl('system','getpass').'" title="找回密码">找回密码</a></p>
</form>
<script type="text/javascript">
layer.ready(function(){
    $("#qqlogin").live("click",function(){
		otherlogin("'.$this->_tpl_vars['url'].'/qqlogin/?jumpurl="+$("#jumpurl").val());
	});
	$(\'#login_form\').bind(\'valid.form\', function(event){
		event.preventDefault();
		$("#btn-submit").attr("disabled", "disabled");
		$(\'#btn-submit\').html(\'正在进入中...\');
		  GPage.postForm(\'login_form\', this.action,
			   function(data){
					if(data.status==\'OK\'){
						jumpurl(data.jumpurl);
					}else{
					    $("#btn-submit").attr("disabled", false);
						$(\'#btn-submit\').html(\'登录\');
						$(\'#result_14\').html(data.msg).fadeIn(300).delay(2000).fadeOut(1000);
						if(data.msg == \'对不起，校验码错误！\'){
							$("[name=\'checkcode\']").focus();
							$(\'#recode\').click();
						}else if(data.msg == \'密码错误，请注意字母大小写是否输入正确！！\'){
							$("[name=\'password\']").focus();
						}else if(data.msg ==\'该用户不存在，请注意字母大小写是否输入正确！\'){
							$("[name=\'username\']").focus();
						}
					}
			   }
		  );
	});
});
$(\'#recode\').click(function(){
	$(\'#checkcode\').attr(\'src\',\''.$this->_tpl_vars['url_checkcode'].'?rand=\'+Math.random());
});
</script>
  </div>
  <div class="lother">
   <h3>用户注册</h3>
   还没有'.$this->_tpl_vars['jieqi_sitename'].'账号？
   <a href="'.geturl('system','register').'"  title="立即注册" class="reg"></a>
   你也可以用站外账号登录:
    <p class="o_login"><a href="javascript:;" id="qqlogin" title="腾讯QQ" class="qq"></a><!---<a href="javascript:alert(\'敬请期待...\')"  title="新浪微博" class="sina"></a>--></p>
  </div>
</div>';
?>