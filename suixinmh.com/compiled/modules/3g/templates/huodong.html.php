<?php
$this->_tpl_vars['articleid']=$this->_tpl_vars['article']['articleid']; 
echo '
';
if($this->_tpl_vars['_REQUEST']['method']=='vipvote' || $this->_tpl_vars['_REQUEST']['method']=='main'){
echo '
  <div class="yuep">
	<p class="surplus">�˻����:<em class="b"> '.$this->_tpl_vars['egolds'].' </em>';
echo JIEQI_EGOLD_NAME; 
echo '<a href="'.geturl('3g','pay').'" class="fr f-org2">��ֵ</a></p>
	<p class="t">�Ȿ��д��ʵ��̫���ˣ��Ҿ���Ͷ��Ʊ</p>
	<form name="vipvoteform" id="vipvoteform" action="'.geturl('3g','huodong','SYS=method=vipvote&aid='.$this->_tpl_vars['articleid'].'').'" method="post">
	  <dl class="group3-6 clearfix">
	    <dd class="col-x-4 current"><a href="javascript:;" role="button" media="handheld" onclick="act(\'\',this)" id="1" >1����Ʊ</a></dd>
	    <dd class="col-x-4"><a href="javascript:;" role="button" media="handheld" onclick="act(\'\',this)" id="2" >2����Ʊ</a></dd>
	    <dd class="dwn"><button type="submit" class="btn01 btn-blue2">ȷ��ͶƱ</button></dd>
	  </dl>
	  <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '">
	  <input type="hidden" name="stat" id="current" value="1"/>
	</form>
	<dl class="li-txt">
	  <dt>��ܰ��ʾ��</dt>
	  <dd>����ǰ������Ʊ��<em class="series"> '.$this->_tpl_vars['maxvote'].' </em>�š���������ʹ��<em class="series"> '.$this->_tpl_vars['pollnum'].' </em>����Ʊ������Ͷ<em class="series"> ';
echo $this->_tpl_vars['maxvote']-$this->_tpl_vars['pollnum']; 
echo ' </em>��</dd>
	  <dd>�Ե�����ƷͶ��Ʊ��ͶƱ����Ϊ<em class="series"> 2 </em>�ţ�</dd>
	  <dd>�������ѶԵ�ǰ��ƷͶ��<em class="series"> '.$this->_tpl_vars['yitou'].' </em>����Ʊ������Ͷ<em class="series"> ';
echo 2-$this->_tpl_vars['yitou']; 
echo ' </em>�ţ�</dd>
	  <dd>ÿͶ1����Ʊ�������ɻ��<em class="series"> '.$this->_tpl_vars['getscore'].' </em>���֡�</dd>
	  <dd>ÿһ���Դ��ͱ���<em class="series"> 1000 </em>'.$this->_tpl_vars['egoldname'].'��������1��������Ʊ��û�����ޡ�</dd>
	  <dd><a href="'.geturl('3g','help').'" target="_blank" class="f_blue5">�鿴��Ʊ��÷�����ʹ�ù���>> </a></dd>
	  <!-- <dd>����ǰ������Ʊ��<em class="red"> '.$this->_tpl_vars['maxvote'].' </em>��</dd>
	  <dd>�Ե�����ƷͶ��Ʊ��ͶƱ����Ϊ<em class="red"> ';
if($this->_tpl_vars['maxvote'] > 0){
echo $this->_tpl_vars['maxvote'].' ';
}else{
echo ' 2';
}
echo '</em>��</dd>
	  <dd>��������ʹ��<em class="red"> '.$this->_tpl_vars['pollnum'].' </em>����Ʊ������Ͷ<em class="red"> ';
echo $this->_tpl_vars['maxvote']-$this->_tpl_vars['pollnum']; 
echo ' </em>��</dd>
	  <dd>ÿͶ1����Ʊ�������ɻ��<em class="red"> '.$this->_tpl_vars['getscore'].' </em>���֡�</dd>
	  <dd>ÿ���ͱ���<em class="red"> 1000 </em>'.$this->_tpl_vars['egoldname'].'���ɻ��1��������Ʊ��û�����ޡ�</dd> -->
	</dl>
  </div><!-- ���Ľ��� -->
';
}elseif($this->_tpl_vars['_REQUEST']['method']=='vote'){
echo '
  <div class="tuij">
	<p class="surplus">�˻����:<em class="b"> '.$this->_tpl_vars['egolds'].' </em>';
echo JIEQI_EGOLD_NAME; 
echo '<a href="/pay" class="fr f-org2">��ֵ</a></p>
	<form name="voteform" id="voteform" action="'.geturl('3g','huodong','SYS=method=vote&aid='.$this->_tpl_vars['articleid'].'').'" method="post">
	  <dl class="group3-6 clearfix">
	    <dt class="t">�Ȿ��д��ʵ��̫���ˣ��Ҿ���Ͷ�Ƽ�Ʊ</dt>
	    <dd class="col-x-4 current2"><a href="javascript:;" role="button" media="handheld" onclick="act(2,this)" id="1">1��Ʊ</a></dd>
		<dd class="col-x-4"><a href="javascript:;" role="button" media="handheld" onclick="act(2,this)" id="2">2��Ʊ</a></dd>
		<dd class="col-x-4"><a href="javascript:;" role="button" media="handheld" onclick="act(2,this)" id="3">3��Ʊ</a></dd>
		<dd class="col-x-4"><a href="javascript:;" role="button" media="handheld" onclick="act(2,this)" id="4">4��Ʊ</a></dd>
		<dd class="col-x-4"><a href="javascript:;" role="button" media="handheld" onclick="act(2,this)" id="5">5��Ʊ</a></dd>
		<dd class="col-x-4"><a href="javascript:;" role="button" media="handheld" onclick="act(2,this)" id="all">ȫ��Ʊ</a></dd>
	  	<dd class="dwn"><button type="submit" class="btn01 btn-org3">ȷ��ͶƱ</button></dd>
	  </dl>
	  <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
	  <input type="hidden" name="stat" id="current2" value="1"/>
	</form>
	<dl class="li-txt">
	  <dt>��ܰ��ʾ��</dt>
	  <dd>��ÿ����Ͷ�Ƽ�ƱΪ<em class="series"> '.$this->_tpl_vars['maxvote'].' </em>�ţ������Ѿ�ʹ��<em class="series"> '.$this->_tpl_vars['pollnum'].' </em>�ţ�</dd>
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
	  <!-- <dd>ÿ��ͶƱ����Ϊ<em class="red"> '.$this->_tpl_vars['maxvote'].' </em>��</dd>
	  <dd>�������Ѿ�ʹ��<em class="red"> '.$this->_tpl_vars['pollnum'].' </em>��</dd>
	  ';
$this->_tpl_vars['num'] = $this->_tpl_vars['maxvote']-$this->_tpl_vars['pollnum']; 
echo '
	  ';
if($this->_tpl_vars['num'] > 0){
echo '
	  <dd>������ʣ���Ƽ�Ʊ��Ϊ<em class="red"> '.$this->_tpl_vars['num'].' </em>��</dd>
	  ';
}else{
echo '
	  <dd class="red">��Ǹ����������Ƽ�Ʊ�����꣬���������ɣ�</dd>
	  ';
}
echo '
	  <dd>ÿ��1���Ƽ�Ʊ�������ɻ��<em class="red"> '.$this->_tpl_vars['getscore'].' </em>���֡�</dd> -->
	</dl>
  </div><!-- �Ƽ����� -->
';
}elseif($this->_tpl_vars['_REQUEST']['method']=='reward'){
echo '
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'modules/3g/templates/reward.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
';
}
echo '
<script>
  $(function(){
    $(\'form\').on(\'submit\', function(e){
   	  e.preventDefault();
	  GPage.postForm(this.name, this.action,function(data){
		$("#tab_box1 *").remove();
  		layer.open({
		    content: data.msg,
		    btn: [\'OK\'],
//		    shadeClose: function(){
//		    	window.location.reload();
//		    },
		    yes: function(){
		    	window.location.reload();
		    }
		});
	  });
 	});
  });
</script>';
?>