<?php
echo '    <div class="user2 f_blue fix">
      <dl>
       <dt class="img"><img src="'.jieqi_geturl('system','avatar',''.$this->_tpl_vars['_USER']["uid"].'','l',''.$this->_tpl_vars['_USER']["avatar"].'').'" onerror="javascript:this.src=\''.$this->_tpl_vars['jieqi_themeurl'].'images/head502.gif\'"/><span class="mask"></span></dt>
       <dd><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['_USER']["uid"].'').'">'.$this->_tpl_vars['_USER']['username'].'</a>
       </dd>
       <dd><a class="'.$this->_tpl_vars['_USER']['vipphoto'].' vs" title="'.$this->_tpl_vars['_USER']['vipgrade'].'����Ա" href="'.geturl('system','userhub','SYS=method=uservip').'"></a><!--'.$this->_tpl_vars['_USER']['usergroup'].'--></dd>
       <dd><a class="rk'.$this->_tpl_vars['_USER']['honorid'].' rks" title="'.$this->_tpl_vars['_USER']['honor'].'" href="'.geturl('system','userhub','SYS=method=usermember').'"></a><!--<a href="'.geturl('system','userhub','SYS=method=logout').'" class="exit">�˳�</a>--></dd>
      </dl>
    </div>
    <dl class="assets">
     <dd><em>��</em>'.$this->_tpl_vars['_USER']['egolds'].$this->_tpl_vars['egoldname'].'<a href="'.geturl('pay','home').'" target="_blank" class="recharge2">��ֵ</a></dd>
     <dd><em>��ȯ��</em>'.$this->_tpl_vars['_USER']['esilvers'].'��ȯ&nbsp;<a href="/help/?wz=q38" target="_blank" class="f_blue5">ʹ��˵��&gt;&gt;</a></dd>
     <dd><em>���֣�</em>'.$this->_tpl_vars['_USER']['score'].'</dd>
     <dd><em>С��ʾ��</em>1Ԫ=100�麣��</dd>
    </dl>
';
?>