<?php
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'templates/autor_head.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
';
$GLOBALS['jieqiTset']['jieqi_blocks_module'] = 'article';
echo '
';
$GLOBALS['jieqiTset']['jieqi_blocks_config'] = 'authorblocks';
echo '
<link href="'.$this->_tpl_vars['jieqi_themeurl'].'style/user.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.css" />

<link href="'.$this->_tpl_vars['jieqi_themeurl'].'style/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/layer/layer.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/page.js"></script>

<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_themeurl'].'js/jquery.jNice.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/calendar/WdatePicker.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/local/zh_CN.js"></script>
<script type="text/javascript">
	function bingVolume(){
		var val = $(\'#chaptername\').val();
		if(val == \'\' || val == null || val == \'undefined\'){
			layer.msg(\'��д�־�����\',1,{type:3,shade:false});
		}else{
			GPage.postForm(\'newvolume123\', $("#newvolume123").attr("action"),
					function(data){
						if(data.status==\'OK\'){
							$.ajaxSetup ({ cache: false });
							$(".xubox_close").click();
							layer.msg(data.msg,1,{type:1,shade:false},function(){
								$("#tabox").load(location.href + \' #tabox>*\',function(responseTxt,statusTxt,xhr){
									//���������jquery.jNice.js�ж���õģ�����ο�ע��
									bindselect();
								});
							});
						}else{
							layer.alert(data.msg, 8, !1);
							document.getElementById("newvolume123").reset();
						}
					}
			);
		}
	}
	function createVolume(){
		$.layer({
			shade : [0.5 , \'#000\' , true],
			type : 1,
			area : [\'770px\',\'auto\'],
			title : false,
			offset : [\'80px\' , \'50%\'],
			border : [10 , 0.3 , \'#000\', true],
			zIndex : 1,
			page : {dom : \'#juan\'},
			close : function(index){
				layer.close(index);
				$(\'.ul_con\').hide();
			}
		});
	}
</script>

<div id="main">
	';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'templates/autor_left.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
	<div class="right fl ov">
		<div class="tabox" id="tabox">
			<form name="chapterdel" id="chapterdel" action="'.geturl('article','chapter','SYS=method=batchHandle').'" class="jNice">
				<div class="t2">
					<h2>�½ڹ���</h2>
					<p class="fl">
					<div class="selt4 se4">
						<select name="aid" id="now_place1" size="1" class="selt5 f14" onchange="location.href=\''.geturl('article','chapter','SYS=method=cmView&aid=').'\'+this.value" style="display:none;">
							';
if (empty($this->_tpl_vars['articles'])) $this->_tpl_vars['articles'] = array();
elseif (!is_array($this->_tpl_vars['articles'])) $this->_tpl_vars['articles'] = (array)$this->_tpl_vars['articles'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['articles']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['articles']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['articles']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['articles']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['articles']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
							<option value="'.$this->_tpl_vars['articles'][$this->_tpl_vars['i']['key']]['articleid'].'" ';
if($this->_tpl_vars['articles'][$this->_tpl_vars['i']['key']]['articleid'] == $this->_tpl_vars['article']['articleid']){
echo ' selected ';
}
echo '>'.$this->_tpl_vars['articles'][$this->_tpl_vars['i']['key']]['articlename'].'</option>
							';
}
echo '
						</select>
					</div>
					</p>
					<p class="fr pt20 f_blue5"><a href="'.$this->_tpl_vars['article']['url_articleinfo'].'" target="_blank">��Ϣ</a>��<a href="'.geturl('article','index','SYS=&aid='.$this->_tpl_vars['article']['articleid'].'').'" target="_blank">�Ķ�</a></p>
				</div>
				<div class="opit f_blue5">
					<a href="javascript:void(0)" class="creat" onclick="createVolume()">�½��־�</a><a href="'.geturl('article','chapter','SYS=method=newChapterView&aid='.$this->_tpl_vars['article']['articleid'].'').'">�����½�</a><a href="'.geturl('article','article','SYS=method=editArticleView&aid='.$this->_tpl_vars['article']['articleid'].'').'">�༭����</a>';
if($this->_tpl_vars['delown']==1 || $this->_tpl_vars['delall']==1){
echo '<a href="javascript:delthis(\''.geturl('article','article','SYS=method=articleDelete&aid='.$this->_tpl_vars['article']['articleid'].'').'\',\'a\')">ɾ������</a>';
}
echo '<a href="javascript:delthis(\''.geturl('article','article','SYS=method=articleClean&aid='.$this->_tpl_vars['article']['articleid'].'').'\',\'cl\')">�������</a><!--  <a href="#">��������</a><a href="#">�½�ͶƱ</a>-->
				</div><!--opit end-->
				';
if (empty($this->_tpl_vars['chapterrows'])) $this->_tpl_vars['chapterrows'] = array();
elseif (!is_array($this->_tpl_vars['chapterrows'])) $this->_tpl_vars['chapterrows'] = (array)$this->_tpl_vars['chapterrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['chapterrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['chapterrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['chapterrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['chapterrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['chapterrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
				';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptertype'] == 1){
echo '
				<ul class="juan fix cl">
					<li class="fix">
						<div class="tit">
							<p class="bef">
								<em class="switch"></em> <em class="check"><input type="checkbox" name="checkid[]" id="checkid[]" value="'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'" /></em> <em class="num"></em><em class="name">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptername'].'</em>';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 0){
echo ' <em class="g3">����</em> ';
}elseif($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 1 || $this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 9){
echo ' <em class="red3"';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['comment']!=''){
echo ' tiptitle=ture title="'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['comment'].'"';
}
echo '>';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['comment'] !=''){
echo '��˲���';
}else{
echo '�ȴ����';
}
echo '</em>
								';
}else{
echo ' <em class="green2">��ʱ</em>('.date('Y-m-d H:i',$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['postdate']).') ';
}
echo '
							</p>
							<p class="aft f_blue5">
								<a href="'.geturl('article','chapter','SYS=method=editChapterView&aid='.$this->_tpl_vars['article']['articleid'].'&cid=').$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'"	class="abtn3">�޸ľ�</a>';
if($this->_tpl_vars['delown']==1 || $this->_tpl_vars['delall']==1){
echo '<a class="abtn3" href="javascript:delthis(\''.geturl('article','chapter','SYS=method=delChapter&aid='.$this->_tpl_vars['article']['articleid'].'&ctype=1&cid=').$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'\',\'v\');">ɾ���־�</a>';
}
echo '<a href="'.geturl('article','chapter','SYS=method=newChapterView&aid='.$this->_tpl_vars['article']['articleid'].'&vid=').$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'" class="abtn3">�����½�</a>
							</p>
						</div>
					</li>
				</ul>
				';
}else{
echo '
				<div class="zhang fix">
					<p class="bef3"><em class="check"><input type="checkbox" name="checkid[]" id="checkid[]" value="'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'"/></em><a href="'.geturl('article','reader','SYS=&aid='.$this->_tpl_vars['article']['articleid'].'&cid='.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'').'" class="f_gray2 f14 pr5" target="_blank">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptername'].'</a>
						';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['isvip'] == 1){
echo '
						<em class="v"></em>
						';
}
echo '
					</p>
					<p class="aft3 f_blue5">
						<a href="'.geturl('article','chapter','SYS=method=editChapterView&aid='.$this->_tpl_vars['article']['articleid'].'&cid=').$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'">�޸�</a>';
if($this->_tpl_vars['delown']==1 || $this->_tpl_vars['delall']==1){
echo '
						<a href="javascript:delthis(\''.geturl('article','chapter','SYS=method=delChapter&aid='.$this->_tpl_vars['article']['articleid'].'&ctype=0&cid=').$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'\',\'c\');">ɾ��</a>';
}
echo '
						';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 0){
echo '<em class="g3">����</em>('.date('Y-m-d H:i',$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['postdate']).')
						';
}elseif($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 1 || $this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 9){
echo ' <em class="red3"';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['comment']!=''){
echo ' tiptitle=ture title="'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['comment'].'"';
}
echo '>';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['comment'] !=''){
echo '��˲���';
}else{
echo '�ȴ����';
}
echo '</em>
						';
}else{
echo ' <em class="green2">��ʱ</em>('.date('Y-m-d H:i',$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['postdate']).') ';
}
echo '&nbsp;&nbsp;<span class="org">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['size_c'].' </span>��
					</p>
				</div>
				';
}
echo '
				';
}
echo '
				';
if($this->_tpl_vars['delown']==1 || $this->_tpl_vars['delall']==1 || $this->_tpl_vars['mangall'] == 1){
echo '
				<div class="opit2 fix cl">
					<div class="box">

						<input id="checkall" name="checkall" value="checkall" type="checkbox" onclick="javascript: for(var i=0;i<this.form.elements.length;i++){ if(this.form.elements[i].name != \'checkkall\'&&this.form.elements[i].name != \'op\') this.form.elements[i].checked = form.checkall.checked; }" /><label>ȫѡ</label>
						';
if($this->_tpl_vars['mangall'] == 1){
echo '
						<label><input name="op" type="radio" value="1" />��ʾ</label>
						<label><input name="op" type="radio" value="2" />����</label>
						';
}
echo '
						';
if($this->_tpl_vars['delown']==1 || $this->_tpl_vars['delall']==1){
echo '
						<label><input name="op" type="radio" value="3" />ɾ��</label>
						';
}
echo '
						<label><input name="op" type="radio" value="4" />�շ�</label>
						<label><input name="op" type="radio" value="5" />���</label>
						<input type="hidden" name="formhash" id="formhash" value="';
echo form_hash(); 
echo '" />
						<input type="button" value="�ύ" class="btn" onclick = "check_confirm();" />
					</div>
				</div>
				';
}
echo '
			</form>
			';
if(count($this->_tpl_vars['chapterrows']) > 2){
echo '
			<form name="chaptersort" id="chaptersort" action="'.geturl('article','chapter','SYS=method=sortChapter').'" method="post" class="jNice">
				<div class="box_note2 cl bg5">
					<div class="tit pt20">�½�����</div>
					<dl class="box_form fix pb10" id="sort">
						<dd class="fix">
							<em class="tt2">ѡ���½ڻ�־�</em>
							<div class="int">
								<div class="selt4">
									<select size="1" class="sel2 mt4 f14"  name="fromid" id="fromid" style="display:none;">
										';
if (empty($this->_tpl_vars['chapterrows'])) $this->_tpl_vars['chapterrows'] = array();
elseif (!is_array($this->_tpl_vars['chapterrows'])) $this->_tpl_vars['chapterrows'] = (array)$this->_tpl_vars['chapterrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['chapterrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['chapterrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['chapterrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['chapterrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['chapterrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
										';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptertype'] == 0){
echo '
										<option value="'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterorder'].'">|-'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptername'].'</option>
										';
}else{
echo '
										<option value="'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterorder'].'">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptername'].'</option>
										';
}
echo '
										';
}
echo '
									</select>
								</div>
								<span class="hint">������λ�ý��ڴ˾�֮��,����ڴ˾���ŵĻ����ϼ�1</span>
							</div>
						</dd>
						<dd class="fix">
							<em class="tt2">�ƶ�����</em>
							<div class="int">
								<div class="selt4">
									<select size="1" class="sel2 mt4 f14" name="toid" id="toid" style="display:none" >
										<option value="0">--��ǰ��--</option>
										';
if (empty($this->_tpl_vars['chapterrows'])) $this->_tpl_vars['chapterrows'] = array();
elseif (!is_array($this->_tpl_vars['chapterrows'])) $this->_tpl_vars['chapterrows'] = (array)$this->_tpl_vars['chapterrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['chapterrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['chapterrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['chapterrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['chapterrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['chapterrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
										';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptertype'] == 0){
echo '
										<option value="'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterorder'].'">|-'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptername'].'</option>
										';
}else{
echo '
										<option value="'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterorder'].'">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptername'].'</option>
										';
}
echo '
										';
}
echo '
									</select>
								</div>
								<span class="red3 pl10">֮��</span>
								<p class="cl pt10">
									<input type="hidden" name="aid" id="aid" value="'.$this->_tpl_vars['article']['articleid'].'" />
									<button class="btn" type="submit">ȷ��</button>
								</p>
							</div>
						</dd>
					</dl>
				</div>
			</form>
			';
}
echo '
			<script type="text/javascript">
				function check_confirm(){
					var ids = $(\'input[name="checkid[]"]:checked\').val();
					var op = $(\'input[name="op"]:checked\').val();
					if(ids == \'\' || ids == null || ids == \'undefined\'){
						layer.msg(\'����ѡ��Ҫ��������Ŀ!\',1,{type:3,shade:false});
					}else if(op == \'\' || op == null || op == \'undefined\'){
						layer.msg(\'��ѡ�����!\',1,{type:3,shade:false});
					}else{
						var msg = $(\'input[name="op"]:checked\').parent().text();
						//ɾ��
						$.layer({
							shade : [0], //����ʾ����
							area : [\'auto\',\'auto\'],
							title:\'ȷ������\',
							dialog : {
								msg:\'ȷʵҪ\'+msg+\'ѡ�м�¼ô��\',
								btns : 2,
								type : 4,
								btn : [\'ȷ��\',\'ȡ��\'],
								yes : function(){
									GPage.postForm(\'chapterdel\', $(\'#chapterdel\').attr(\'action\'),
											function(data){
												if(data.status==\'OK\'){
													$.ajaxSetup ({ cache: false });
													layer.msg(data.msg,1,{type:1,shade:false},function(){
														$("#tabox").load(location.href + \' #tabox>*\',function(responseTxt,statusTxt,xhr){
															//���������jquery.jNice.js�ж���õģ�����ο�ע��
															bindselect();
														});
													});
												}else{
													layer.alert(data.msg, 8, !1);
												}
											});
								},
								no : function(){
									$(".xubox_close").click();
									checkform.reset();
								}
							}
						});
					}
				}

				function delthis(url,op){
					var msg = \'\';
					if(op == \'c\'){
						//ɾ���½�
						msg=\'ȷʵҪɾ��ѡ���½���\';
					}else if(op == \'v\'){
						//ɾ����
						msg=\'ȷʵҪɾ��ѡ�о���\';
					}else if(op == \'a\'){
						//ɾ������
						msg=\'ȷʵҪɾ��������ɾ�����ܸ�ԭ�������������\';
					}else if(op == \'cl\'){
						//�������
						msg=\'ȷʵҪ�����������պ��ܸ�ԭ�������������\';
					}
					$.layer({
						shade : [0], //����ʾ����
						area : [\'auto\',\'auto\'],
						dialog : {
							msg:msg,
							btns : 2,
							type : 4,
							btn : [\'ȷ��\',\'ȡ��\'],
							yes : function(){
								GPage.getJson(url,
										function(data){
											if(data.status==\'OK\'){
												$.ajaxSetup ({ cache: false });
												layer.msg(data.msg,1,{type:1,shade:false},function(){
													if(op == \'a\'){
														//�ض���
														location.href=\''.geturl('article','article','SYS=method=masterPage').'\';
													}else{
														//�ֲ�ˢ��
														$("#tabox").load(location.href + \' #tabox>*\',function(responseTxt,statusTxt,xhr){
															//���������jquery.jNice.js�ж���õģ�����ο�ע��
															bindselect();
														});
													}
												});
											}else{
												layer.alert(data.msg, 8, !1);
											}
										});
							},
							no : function(){
								$(".xubox_close").click();
							}
						}
					});
				}
				layer.ready(function(){
					$("[tiptitle]").each(function(event){
						layer.tips(this.title,this, {
							maxWidth:185,
							guide:0,
							closeBtn:[0, true]
						});
					});
				});
			</script>


			<!-- create volume begin -->
			<div class="box_note2 cl bg5" id="juan" style="display:none; position:fix;">
				<form name="newvolume123" id="newvolume123"  class="jNice" action="'.geturl('article','chapter','SYS=method=saveVolume').'" autocomplete="off" data-validator-option="{theme:\'simple_right\'}">
					<div class="tit pt20">�����·־�</div>
					<dl class="box_form fix pb10" id="volume_area">
						';
if($this->_tpl_vars['hasvolume'] == 1){
echo '
						<dd class="fix">
							<em class="tt2">ѡ��������λ�ã�</em>
							<div class="int">
								<div class="selt4" id="selt4">
									<select id="now_place1" name="previous_volume" class="selt5 f14" style="display:none;">
										';
if (empty($this->_tpl_vars['volumes'])) $this->_tpl_vars['volumes'] = array();
elseif (!is_array($this->_tpl_vars['volumes'])) $this->_tpl_vars['volumes'] = (array)$this->_tpl_vars['volumes'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['volumes']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['volumes']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['volumes']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['volumes']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['volumes']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
										<option value="'.$this->_tpl_vars['volumes'][$this->_tpl_vars['i']['key']]['volumeid'].'">'.$this->_tpl_vars['volumes'][$this->_tpl_vars['i']['key']]['volumename'].'</option>
										';
}
echo '
									</select>
								</div><!--selt4 end-->
								<span class="hint">������λ�ý��ڴ˾�֮��,����ڴ˾���ŵĻ����ϼ�1</span>
							</div>
						</dd>
						';
}
echo '
						<dd class="fix" id="fix">
							<em class="tt2">�����ķ־����ƣ�</em>
							<div class="int">
								<input name="chaptername" id="chaptername" type="text" class="input1 fl"  />
							</div>
						</dd>
						<dd class="fix" id="fix">
							<em class="tt2">˵����</em>
							<div class="int">
								<textarea name="manual" cols="5" rows="20" class="inp3"></textarea>
								<span class="hint">�˴���д���Ǿ�ļ�����ݣ�֮�����ʾ�ھ��˵��ҳ���С��벻Ҫ����140�֡�</span>
							</div>
						</dd>

						<dd class="fix">
							<em class="tt2">��ʱ������</em>
							<div class="int">
								<input name="postdate" id="postdate" autocomplete="off" type="text" class="input3 fl" readonly="readonly" onClick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\',minDate:\'%y-%M-%d #{%H+2}:%m:%s\',maxDate:\'%y-%M-{%d+15}\'})"/>
								<span class="hint cl">��ʱ������ֻ��ѡ�����15�����ڵ�ʱ����з�����</span>
							</div>
							<!--<div class="int2">
                            <p class="cl">
                                <p class="pb20 cl"><input type="button" value="����" class="btn" onclick="bingVolume();"/></p>
                            </p>
                             <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
                             <input type="hidden" name="aid" id="aid" value="'.$this->_tpl_vars['article']['articleid'].'" />
                        </div>-->
						</dd>
						<dd class="fix">
							<em class="tt2">��֤�룺</em>
							<div class="int">
								<input type="text" name="checkcode" class="input1 fl" style="width:160px;" maxlength="4" autocomplete=��off��/><img src="'.$this->_tpl_vars['jieqi_local_url'].'/checkcode.php" height="28" class="pic" id="checkcode2" /><a class="f_org2 pl10" href="javascript:;" onclick="$(\'#checkcode2\').attr(\'src\',\''.$this->_tpl_vars['jieqi_local_url'].'/checkcode.php?rand=\'+Math.random());">��һ��</a>
								<p class="pb20 cl"><input type="button" value="����" class="btn" onclick = "bingVolume();" /></p>
								<input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
								<input type="hidden" name="aid" id="aid" value="'.$this->_tpl_vars['article']['articleid'].'" />
							</div>
						</dd>
					</dl>
				</form>
			</div>
			<!-- create volume end -->

		</div>
</div>
</div>
<!--header end-->
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'templates/autor_footer.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);

?>