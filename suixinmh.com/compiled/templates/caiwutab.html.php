<?php
echo '      <div class="t2">
       <h2>��������</h2>
       <ul class="tabs62">
        <li id="t_home_main"><a href="'.geturl('pay','home').'">��ֵ</a></li>
        <li id="t_userhub_czView"><a href="'.geturl('system','userhub','SYS=method=czView').'">��ֵ��¼</a></li>
        <li id="t_userhub_xfView"><a href="'.geturl('system','userhub','SYS=method=xfView').'">���Ѽ�¼</a></li>
        <li id="t_userhub_dyView"><a href="'.geturl('system','userhub','SYS=method=dyView').'">�Զ���������</a></li>
       </ul>       
      </div>
      
      <script>
	//��ֹtab ID��accordion id ��ͻ��tabID��t_
	var id =\''.$this->_tpl_vars['_REQUEST']['controller'].'\'+\'_\'+\''.$this->_tpl_vars['_REQUEST']['method'].'\';
	 $(\'#t_\'+id).addClass("thistab");
	 if(\''.$this->_tpl_vars['_REQUEST']['controller'].'\'==\'home\')
	 	$(\'#t_home_main\').addClass("thistab");
	</script>
';
?>