<?php
echo '<script type="text/javascript">
$(function(){
	';
if($this->_tpl_vars['_REQUEST']['controller']=='home'){$this->_tpl_vars['_REQUEST']['method']='main';} 
echo '
  var ss = \''.$this->_tpl_vars['_REQUEST']['controller'].'\'+\'_\'+\''.$this->_tpl_vars['_REQUEST']['method'].'\';
  if(ss == \'userhub_inbox\' || ss == \'userhub_outbox\' || ss == \'userhub_draft\' || ss == \'userhub_toSysView\' || ss == \'userhub_messagedetail\'){
      $(\'#userhub_newmessage\').parent("dl.list_menu").show();
	  $(\'#userhub_newmessage\').children("a").addClass("focus");
  }
  if(ss == \'chapter_cmView\'){
      $(\'#article_masterPage\').parent("dl.list_menu").show();
	  $(\'#article_masterPage\').children("a").addClass("focus");
  }
//  if(\''.$this->_tpl_vars['_REQUEST']['method'].'\' == \'upaView\'){
//      $(\'#userhub_usereditView\').parent("dl.list_menu").show();
//	  $(\'#userhub_usereditView\').children("a").addClass("focus");
//  }
  if(\''.$this->_tpl_vars['_REQUEST']['method'].'\' == \'hotcomment\'){
      $(\'#userhub_comment\').parent("dl.list_menu").show();
	  $(\'#userhub_comment\').children("a").addClass("focus");
  }
  if(\''.$this->_tpl_vars['_REQUEST']['method'].'\' == \'uservip\'){
      $(\'#userhub_usermember\').parent("dl.list_menu").show();
	  $(\'#userhub_usermember\').children("a").addClass("focus");
  }
  if(\''.$this->_tpl_vars['_REQUEST']['method'].'\' == \'moderatorView\'){
      $(\'#userhub_review_view\').parent("dl.list_menu").show();
	  $(\'#userhub_review_view\').children("a").addClass("focus");
  }
  $(\'#\'+ss).parent("dl.list_menu").show();
  $(\'#\'+ss).children("a").addClass("focus");
  $("li#row em").click(function(){
  $(this).parent().parent().children("dl.list_menu").toggle(300);
  });
});

</script>
<!--sidebar2 begin-->
  <div class="sidebar2 fl bg4 fix">
	';
if($this->_tpl_vars['_USER']['uid']>0){
echo '
		';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'modules/article/templates/chongzhi.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '	<!--';
if($this->_tpl_vars['_REQUEST']['method']=='' || $this->_tpl_vars['_REQUEST']['method']=='avatarView'){
echo '
		';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'modules/article/templates/touxiang.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
	';
}else{
}
echo '-->
	';
}
echo '
    <ul class="column">
     <li><a href="'.geturl('system','userhub').'"><em class="def b">��ҳ</em></a></li>
     <li id="row"><a href="javascript:void(0)"><em class="account" >�ʺŹ���</em></a>
	 <dl class="list_menu" style="display:none">
       <dd id="userhub_usereditView"><a href="'.geturl('system','userhub','SYS=method=usereditView').'"><i>&middot;</i>��������</a></dd>
       <dd id="userhub_upaView"><a href="'.geturl('system','userhub','SYS=method=upaView').'"><i>&middot;</i>�޸�ͷ��</a></dd>
       <dd id="userhub_pwdview"><a href="'.geturl('system','userhub','SYS=method=pwdview').'"><i>&middot;</i>���뼰��ȫ</a></dd>
      </dl>
     </li>
     <li id="row"><a href="javascript:void(0)"><em class="trend" >�ҵ�'.$this->_tpl_vars['jieqi_sitename'].'</em></a>
      <dl class="list_menu" style="display:none">
       <dd id="userhub_comment"><a href="'.geturl('system','userhub','SYS=method=comment').'"><i>&middot;</i>�ҵ�����</a></dd>
       <dd id="userhub_friend"><a href="'.geturl('system','userhub','SYS=method=friend').'"><i>&middot;</i>�ҵĹ�ע</a></dd>
       <dd id="article_bcView"><a href="'.geturl('article','article','SYS=method=bcView').'"><i>&middot;</i>�ҵ����</a></dd>
       <dd id="userhub_newmessage"><a href="'.geturl('system','userhub','SYS=method=inbox').'"><i>&middot;</i>����Ϣ</a></dd>
       <dd id="userhub_usermember"><a href="'.geturl('system','userhub','SYS=method=usermember').'"><i>&middot;</i>��Ա��Ȩ</a></dd>
      </dl>
     </li>
     <li id="row"><a href="javascript:void(0)"><em class="fiscal" >��������</em></a>
      <dl class="list_menu" style="display:none">
       <dd id="home_main"><a href="'.geturl('pay','home').'"><i>&middot;</i>��ֵ</a></dd>
       <dd id="userhub_czView"><a href="'.geturl('system','userhub','SYS=method=czView').'"><i>&middot;</i>�ҵĳ�ֵ��¼</a></dd>
       <dd id="userhub_xfView"><a href="'.geturl('system','userhub','SYS=method=xfView').'"><i>&middot;</i>�ҵ����Ѽ�¼</a></dd>
       <dd id="userhub_dyView"><a href="'.geturl('system','userhub','SYS=method=dyView').'"><i>&middot;</i>�Զ���������</a></dd>
      </dl>
     </li>
     <li id="row"><a href="javascript:;"><em class="task">����ר��</em></a>
      <dl class="list_menu" style="display:none">
       <dd id="task_main"><a href="'.geturl('task','task','SYS=method=main').'"><i>&middot;</i>��������</a></dd>
       <dd id="task_czView"><a href="'.geturl('task','task','SYS=method=userfinished').'"><i>&middot;</i>���������</a></dd>
      </dl>
     </li>     
<!--     <li id="row"><a href="javascript:void(0)"><em class="vip" >��Աר��</em></a>
      <dl class="list_menu" style="display:none">
       <dd id="userhub_usermember"><a href="'.geturl('system','userhub','SYS=method=usermember').'"><i>&middot;</i>��Աר��</a></dd>
       <dd id="userhub_uservip"><a href="'.geturl('system','userhub','SYS=method=uservip').'"><i>&middot;</i>VIPר��</a></dd>
      </dl>
     </li>-->
<!--     <li id="row"><a href="javascript:;"><em class="review" >�ҵ�����</em></a>
      <dl class="list_menu" style="display:none;">
       <dd id="userhub_comment"><a href="'.geturl('system','userhub','SYS=method=comment').'"><i>&middot;</i>���������</a></dd>
       <dd id="userhub_hotcomment"><a href="'.geturl('system','userhub','SYS=method=hotcomment').'"><i>&middot;</i>�ظ�������</a></dd>
      </dl>
     </li>-->
	 ';
if($this->_tpl_vars['iswriter'] <= 0){
echo '
     	<li id="row"><a href="'.geturl('article','article','SYS=method=appwV').'"><em class="apply" >��������</em></a></li>
	  ';
}
echo '
	   <!--��Ʒ����ֻ����Ȩ�޵Ŀ���--> 
	  ';
if($this->_tpl_vars['iswriter'] > 0){
echo '<!--&& ($_REQUEST[\'controller\'] == \'userhub\' || $_REQUEST[\'controller\'] == \'article\' || $_REQUEST[\'controller\'] == \'chapter\')-->
	     <li id="row"><a href="javascript:void(0)"><em class="works">��Ʒ����</em></a>
	      <dl class="list_menu" style="display:none">
	       <dd id="article_step1View"><a href="'.geturl('article','article','SYS=method=step1View').'"><i>&middot;</i>��������</a></dd>
	       		<!-- �����ǰ����û�д��������飬�˹��ܵ㲻����ʾ -->
	       		<dd id="article_masterPage"><a href="'.geturl('article','article','SYS=method=masterPage').'"><i>&middot;</i>�ҵ���Ʒ��</a></dd>
	       		<dd id="chapter_newChapterView"><a href="'.geturl('article','chapter','SYS=method=newChapterView').'"><i>&middot;</i>���������½�</a></dd>
	       		<dd id="userhub_review_view"><a href="'.geturl('system','userhub','SYS=method=review_view').'"><i>&middot;</i>��������</a></dd>
	      </dl>
	     </li>
		 <li id="row"><a href="javascript:void(0)"><em class="income">�������</em></a>
	      <dl class="list_menu" style="display:none">
	      	<dd id="article_finance"><a href="'.geturl('article','article','SYS=method=finance').'"><i>&middot;</i>������Ϣ</a></dd>
			<dd id="article_income"><a href="'.geturl('article','article','SYS=method=income').'"><i>&middot;</i>�����±�</a></dd>
			<dd id="article_incomedetail"><a href="'.geturl('article','article','SYS=method=incomedetail').'"><i>&middot;</i>��������</a></dd>
			<!--<dd id="article_rewards"><a href="'.geturl('article','article','SYS=method=rewards').'"><i>&middot;</i>��������</a></dd>-->
			<dd id="article_exceptional"><a href="'.geturl('article','article','SYS=method=exceptional').'"><i>&middot;</i>������ϸ</a></dd>
			<!--<dd id="article_channelIncome"><a href="'.geturl('article','article','SYS=method=channelIncome').'"><i>&middot;</i>��������</a></dd>-->
	      </dl>
	     </li>
     ';
}
echo '
  </ul>
  <div class="kf"></div>
  </div><!--sidebar2 end-->';
?>