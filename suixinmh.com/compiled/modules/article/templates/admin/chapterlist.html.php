<?php
echo '<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/calendar/WdatePicker.js"></script>
<style type="text/css">
.layer_notice{float:left; height:75px; width:170px;  overflow:hidden; display:none;  background:#78BA32; padding:10px; border:1px solid #628C1C;}
</style>
<form name="frmsearch" method="post" action="?controller=chapter">
<table class="grid" width="100%" align="center">
    <tr>
        <td class="odd">�ؼ��֣�
            <input name="keyword" type="text" id="keyword" class="text" size="0" maxlength="50" value="'.$this->_tpl_vars['keyword'].'"> <input name="keytype" type="radio" class="radio" value="0"';
if($this->_tpl_vars['keytype']==0){
echo ' checked';
}
echo '>
            ��������
			<input type="radio" name="keytype" class="radio" value="1"';
if($this->_tpl_vars['keytype']==1){
echo ' checked';
}
echo '>
            ������
			<input type="radio" name="keytype" class="radio" value="2"';
if($this->_tpl_vars['keytype']==2){
echo ' checked';
}
echo '>
            ����ID &nbsp;&nbsp;
			<select name="nowagent" id="nowagent"><option value="0">-ѡ�����-</option>';
if (empty($this->_tpl_vars['agents'])) $this->_tpl_vars['agents'] = array();
elseif (!is_array($this->_tpl_vars['agents'])) $this->_tpl_vars['agents'] = (array)$this->_tpl_vars['agents'];
$this->_tpl_vars['j']=array();
$this->_tpl_vars['j']['columns'] = 1;
$this->_tpl_vars['j']['count'] = count($this->_tpl_vars['agents']);
$this->_tpl_vars['j']['addrows'] = count($this->_tpl_vars['agents']) % $this->_tpl_vars['j']['columns'] == 0 ? 0 : $this->_tpl_vars['j']['columns'] - count($this->_tpl_vars['agents']) % $this->_tpl_vars['j']['columns'];
$this->_tpl_vars['j']['loops'] = $this->_tpl_vars['j']['count'] + $this->_tpl_vars['j']['addrows'];
reset($this->_tpl_vars['agents']);
for($this->_tpl_vars['j']['index'] = 0; $this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['loops']; $this->_tpl_vars['j']['index']++){
	$this->_tpl_vars['j']['order'] = $this->_tpl_vars['j']['index'] + 1;
	$this->_tpl_vars['j']['row'] = ceil($this->_tpl_vars['j']['order'] / $this->_tpl_vars['j']['columns']);
	$this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['order'] % $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['column'] == 0) $this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['count']){
		list($this->_tpl_vars['j']['key'], $this->_tpl_vars['j']['value']) = each($this->_tpl_vars['agents']);
		$this->_tpl_vars['j']['append'] = 0;
	}else{
		$this->_tpl_vars['j']['key'] = '';
		$this->_tpl_vars['j']['value'] = '';
		$this->_tpl_vars['j']['append'] = 1;
	}
	echo '<option value="'.$this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uid'].'" ';
if($this->_tpl_vars['nowagent']==$this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uid']){
echo 'selected';
}
echo '>';
echo ($this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['name'] ? $this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['name'] : $this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uname']); 
echo '</option>';
}
echo '</select>
		  ��ʼ����ʱ�䣺<input name="start" id="start" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})" value="'.$this->_tpl_vars['start'].'" />
		  &nbsp;&nbsp;��������ʱ�䣺<input name="end" id="end" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})" value="'.$this->_tpl_vars['end'].'" />&nbsp;&nbsp;
            <input type="submit" name="btnsearch" class="button" value="�� ��"><input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
            &nbsp;&nbsp;&nbsp; <a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=chapter">�־��½�</a>
			&nbsp;&nbsp;&nbsp; <a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=chapter&chaptertype=volume">���з־�</a>
			&nbsp;&nbsp;&nbsp; <a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=chapter&display=1">�����½�</a></td>
    </tr>
</table>
</form>
<br />
<form action="'.geturl('article','chapter','SYS=method=delChapters').'" method="post" name="checkform" id="checkform">
<table class="grid" width="100%" align="center">
<caption>'.$this->_tpl_vars['articletitle'].'</caption>
  <tr align="center">
    <th width="5%">ѡ��</th>
    <th width="15%">��������</th>
    <th width="15%">�½�����</th>
    <th width="10%">������</th>
	<th width="10%">���</th>
    <th width="7%">�½�����(��'.$this->_tpl_vars['totalsize'].'��)</th>
	<th width="4%">Ƶ��</th>
    <th width="10%">����/����</th>
    <th width="6%">����</th>
	<th width="8%">״̬</th>
	<th width="10%">����</th>
  </tr>
  ';
if (empty($this->_tpl_vars['articlerows'])) $this->_tpl_vars['articlerows'] = array();
elseif (!is_array($this->_tpl_vars['articlerows'])) $this->_tpl_vars['articlerows'] = (array)$this->_tpl_vars['articlerows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['articlerows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['articlerows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['articlerows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['articlerows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['articlerows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr>
    <td class="odd" align="center">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['checkbox'].'</td>
    <td class="even"><a href="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['url_articleinfo'].'" target="_blank">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articlename'].'</a></td>
    <td class="odd">';
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['chaptertype'] == 0){
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['display'] > 0){
echo '
	<a href="'.geturl('article','chapter','SYS=method=editChapterView&aid='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'&cid=').$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['chapterid'].'" target="_blank">
	';
}else{
echo '<a href="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['url_lastchapter'].'" target="_blank">';
}
echo $this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['chaptername'].'</a>';
}else{
echo $this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['chaptername'];
}
echo '</td>
    <td class="even" align="center"><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['posterid'].'').'" target="_blank">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['poster'].'</a></td>
	<td align="center">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['agent'].'</td>
    <td class="odd" align="center">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['size_c'].'</td>
	<td class="odd" align="center">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['channel'].'</td>
    <td class="even" align="center">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['lastupdate'].'<br>'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['postdate'].'</td>
    <td class="odd" align="center">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['typename'].'</td>
	<td class="odd" align="center">';
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['display'] == 0){
echo '����';
}else if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['display'] == 1){
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['comment'] !=''){
echo '<span class="red" tiptitle=ture title="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['comment'].'">�����޸�</span>';
}else{
echo '<span class="blue">����</span>';
}
}else if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['display'] == 2){
echo '<span class="green">��ʱ</span>';
}else if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['display'] == 9){
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['comment'] !=''){
echo '<span class="red" tiptitle=ture title="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['comment'].'">�����޸�</span>';
}else{
echo '<span class="org">��ʱ����</span>';
}
}
echo '</td>
	<td class="odd" align="center">';
if(($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['display'] == 1 || $this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['display'] == 9) && $this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['comment'] ==''){
echo '<a href="?controller=chapter&method=checkchapter&aid='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'&cid='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['chapterid'].'"  title=\''.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['chaptername'].'\' checkchapter="true">���</a>';
}
echo '</td>
  </tr>
  ';
}
echo '
  <tr>
    <td width="3%" class="odd" align="center"><input type="checkbox" id="checkall" name="checkall" value="checkall" onclick="javascript: for (var i=0;i<this.form.elements.length;i++){ if (this.form.elements[i].name != \'checkkall\') this.form.elements[i].checked = form.checkall.checked; }"></td>
    <td colspan="6" align="left" class="odd"><!--<input type="button" name="Submit" value="����ɾ��" class="button" onclick="javascript:if(confirm(\'ȷʵҪ����ɾ���½�ô��\')) this.form.submit();">--><input name="batchdel" type="hidden" value="1"></td>
  </tr>
</table>
</form>
<table width="100%"  border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td width="12%" align="right"><!--<input type="submit" name="Submit" value="����ɾ��" class="button">
                <input name="batchdel" type="hidden" value="1">--></td>
    <td width="88%" align="right">'.$this->_tpl_vars['url_jumppage'].'</td>
  </tr>
</table>
<div>
        <ul class="layer_notice"><li><b>[ѡ�����]</b><a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=article&action=setagent&uid=-1" agentclick="true">���</a></li>';
if (empty($this->_tpl_vars['agents'])) $this->_tpl_vars['agents'] = array();
elseif (!is_array($this->_tpl_vars['agents'])) $this->_tpl_vars['agents'] = (array)$this->_tpl_vars['agents'];
$this->_tpl_vars['j']=array();
$this->_tpl_vars['j']['columns'] = 1;
$this->_tpl_vars['j']['count'] = count($this->_tpl_vars['agents']);
$this->_tpl_vars['j']['addrows'] = count($this->_tpl_vars['agents']) % $this->_tpl_vars['j']['columns'] == 0 ? 0 : $this->_tpl_vars['j']['columns'] - count($this->_tpl_vars['agents']) % $this->_tpl_vars['j']['columns'];
$this->_tpl_vars['j']['loops'] = $this->_tpl_vars['j']['count'] + $this->_tpl_vars['j']['addrows'];
reset($this->_tpl_vars['agents']);
for($this->_tpl_vars['j']['index'] = 0; $this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['loops']; $this->_tpl_vars['j']['index']++){
	$this->_tpl_vars['j']['order'] = $this->_tpl_vars['j']['index'] + 1;
	$this->_tpl_vars['j']['row'] = ceil($this->_tpl_vars['j']['order'] / $this->_tpl_vars['j']['columns']);
	$this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['order'] % $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['column'] == 0) $this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['count']){
		list($this->_tpl_vars['j']['key'], $this->_tpl_vars['j']['value']) = each($this->_tpl_vars['agents']);
		$this->_tpl_vars['j']['append'] = 0;
	}else{
		$this->_tpl_vars['j']['key'] = '';
		$this->_tpl_vars['j']['value'] = '';
		$this->_tpl_vars['j']['append'] = 1;
	}
	echo '
        	<li style="height:25px; line-height:25px;">['.$this->_tpl_vars['groups'][$this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['groupid']].']<a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=article&action=setagent&uid='.$this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uid'].'" agentclick="true">';
echo ($this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['name'] ? $this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['name'] : $this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uname']); 
echo '</a></li>
            ';
}
echo '<input type="hidden" value="0" id=\'tmpid\'>
        </ul>
</div>
<div style="display:none; height:450px;" id="hidden"></div>
<script language="javascript">
function selectAgent(_this, articleid){
	var s = layer.tips($(\'.layer_notice\').html(), _this, {
        guide: 1,
		maxWidth:190,
		closeBtn:[0,true], //��ʾ�رհ�ť
        style: [\'background-color:#FFF8ED; color:#000; width:190;border:1px solid #FF9900\', \'#FF9900\']//[\'background-color:#FFF8ED; color:#000; border:1px solid #FF9900\', \'#FF9900\']
    });
	$(\'#tmpid\').val(articleid);
}
layer.ready(function(){
	$("[agentclick]").live(\'click\',function(event){
		event.preventDefault();
		var id = $(\'#tmpid\').val();
		var i = layer.load();//layer.load(0);
		GPage.getJson(urlParams(this.href, \'id=\'+id),
			function(data){
			    if(data.status==\'OK\'){			    	
					GPage.loadpage(\'content\', data.jumpurl, true, false);
					layer.closeAll();
				}else{
					layer.alert(data.msg, 8, !1);
				}
			}
		);
	});	
	$("[checkchapter]").live(\'click\',function(event){
		event.preventDefault();
		var gurl = urlParams(this.href, \'date=\'+Math.random());
		var pagei = $.layer({
			type:2,
			shade : [0.6 , \'#000\' , true],
			border : [10 , 0.3 , \'#000\', true],
			area: [\'700px\', \'600px\'],
			title: \'�½���ˡ�\'+this.title+\'��\',
			closeBtn: [0,true],
			iframe:{src: gurl}
		});
	});	
   $("[tiptitle]").live(\'mouseenter\',function(event){
		layer.tips(this.title,this, {
			maxWidth:185,
			guide:1,
			closeBtn:[0, true]
		});	 
	});	 
});
</script>
';
?>