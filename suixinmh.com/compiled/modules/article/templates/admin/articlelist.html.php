<?php
echo '<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/calendar/WdatePicker.js"></script>
<style>
.layer_notice{float:left; height:75px; width:170px;  overflow:hidden; display:none;  background:#78BA32; padding:10px; border:1px solid #628C1C;}
/*layer_notice li{ height:30px; line-height:30px;}
.layer_notice li a{ display:block; color:#fff;}
.layer_notice li a:hover{ background:#fff; color:#78BA32;}*/
</style>
<form name="frmsearch" method="post" action="?controller=article">
<table class="grid" width="100%" align="center">
    <tr>
        <td class="odd">�ؼ��֣�
            <input name="keyword" type="text" id="keyword" value="'.$this->_tpl_vars['_REQUEST']['keyword'].'" class="text" size="15" maxlength="50"> <input name="keytype" type="radio" class="radio" value="0"';
if($this->_tpl_vars['_REQUEST']['keytype']=='0' || $this->_tpl_vars['_REQUEST']['keytype']==''){
echo ' checked';
}
echo '>��������
            <input type="radio" name="keytype" class="radio" value="1"';
if($this->_tpl_vars['_REQUEST']['keytype']=='1'){
echo ' checked';
}
echo '>���� 
			<input type="radio" name="keytype" class="radio" value="2"';
if($this->_tpl_vars['_REQUEST']['keytype']=='2'){
echo ' checked';
}
echo '>������ 
			<input type="checkbox" name="isvip" value="1"';
if($this->_tpl_vars['_REQUEST']['isvip']>0){
echo ' checked';
}
echo ' /> ֻ��ʾVIP&nbsp;&nbsp;
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
echo '</select>&nbsp;&nbsp;
            <select name="firstflag" id="firstflag">
            	<option value="">-ѡ����Դ-</option>
            	';
if (empty($this->_tpl_vars['soruce'])) $this->_tpl_vars['soruce'] = array();
elseif (!is_array($this->_tpl_vars['soruce'])) $this->_tpl_vars['soruce'] = (array)$this->_tpl_vars['soruce'];
$this->_tpl_vars['j']=array();
$this->_tpl_vars['j']['columns'] = 1;
$this->_tpl_vars['j']['count'] = count($this->_tpl_vars['soruce']);
$this->_tpl_vars['j']['addrows'] = count($this->_tpl_vars['soruce']) % $this->_tpl_vars['j']['columns'] == 0 ? 0 : $this->_tpl_vars['j']['columns'] - count($this->_tpl_vars['soruce']) % $this->_tpl_vars['j']['columns'];
$this->_tpl_vars['j']['loops'] = $this->_tpl_vars['j']['count'] + $this->_tpl_vars['j']['addrows'];
reset($this->_tpl_vars['soruce']);
for($this->_tpl_vars['j']['index'] = 0; $this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['loops']; $this->_tpl_vars['j']['index']++){
	$this->_tpl_vars['j']['order'] = $this->_tpl_vars['j']['index'] + 1;
	$this->_tpl_vars['j']['row'] = ceil($this->_tpl_vars['j']['order'] / $this->_tpl_vars['j']['columns']);
	$this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['order'] % $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['column'] == 0) $this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['count']){
		list($this->_tpl_vars['j']['key'], $this->_tpl_vars['j']['value']) = each($this->_tpl_vars['soruce']);
		$this->_tpl_vars['j']['append'] = 0;
	}else{
		$this->_tpl_vars['j']['key'] = '';
		$this->_tpl_vars['j']['value'] = '';
		$this->_tpl_vars['j']['append'] = 1;
	}
	echo '
            		<option value="'.$this->_tpl_vars['j']['key'].'" ';
if($this->_tpl_vars['firstflag'] != ""  && $this->_tpl_vars['firstflag']==$this->_tpl_vars['j']['key']){
echo 'selected';
}
echo '>'.$this->_tpl_vars['j']['value'].'</option>
            	';
}
echo '
            </select>&nbsp;&nbsp;
            <select name="fullflag" id="fullflag">
            	<option>-ѡ��״̬-</option>
        		<option value="2" ';
if($this->_tpl_vars['fullflag'] != "" && $this->_tpl_vars['fullflag']==2){
echo 'selected';
}
echo '>������</option>
        		<option value="1" ';
if($this->_tpl_vars['fullflag'] != "" && $this->_tpl_vars['fullflag']==1){
echo 'selected';
}
echo '>���걾</option>
            </select>
            <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" /><input type="submit" name="dosubmit" class="button" value="�� ��">
            <br /><a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article">ȫ������</a>  | <a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&display=sign">ǩԼ����</a> | <a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&display=show">��������</a> | <a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&display=hide">��������</a> | <a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&display=cool">��������</a> | <a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&display=empty">������</a>     
        </td><td class="odd" style="text-align:center"><a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=downexcel">���ص�EXCEL</a></td>
    </tr>
</table>
</form>
<br />
<form action="'.$this->_tpl_vars['url_batchdel'].'" method="post" name="checkform" id="checkform" onSubmit="javascript:if(confirm(\'ȷʵҪ����ɾ������ô��\')) return true; else return false;">
<table class="grid" width="100%" align="center">
<caption>'.$this->_tpl_vars['articletitle'].'</caption>
  <tr align="center">
    <th width="3%">ѡ��</th>
    <th width="12%">��������</th>
	<th width="3%">Ŀ¼</th>
    <th width="15%">�����½�</th>
    <th width="6%">����</th>
    <th width="3%">��Դ</th>
	<th width="5%">���</th>
	<th width="6%">������</th>
	<th width="4%">����</th>
    <th width="3%">����״̬</th>
    <th width="6%">����ʱ��</th>
    <th width="6%">����/ǩԼ</th>
	<th width="4%">�ղ�</th>
	<th width="4%">���</th>
	<th width="4%">�Ƽ�</th>
	<th colspan="4">״̬����</th>
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
  '.jieqi_geturl('article','article',''.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'').'
  <tr>
    <td class="odd" align="center">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['checkbox'].'</td>
    <td class="even">[<a href="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['url_class'].'" target="_blank">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['sort'].'</a>] <a href="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['url_articleinfo'].'" target="_blank">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articlename'].'</a>';
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articletype']>0){
echo '<img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/vip.gif" border="0" />';
}
echo '</td>
	<td class="even" align="center"><a href="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['url_articleindex'].'" target="_blank">Ŀ¼</a></td>
    <td class="odd"><a href="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['url_lastchapter'].'" target="_blank">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['lastvolume'].' '.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['lastchapter'].'</a></td>
    <td class="even" align="center">';
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['authorid'] == 0){
echo $this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['author'];
}else{
echo '<a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['authorid'].'').'" target="_blank">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['author'].'</a>';
}
echo '</td>
	<td class="even" align="center">'.$this->_tpl_vars['soruce'][$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['firstflag']].'</td>
	<td class="odd" align="center"><a href="javascript:;" onclick="selectAgent(this,'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].');">'.defaultval($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['agent'],'<font color=blue>�������</font>').'</a></td>
    <td class="odd" align="center"><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['posterid'].'').'" target="_blank">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['poster'].'</a></td>
	<td class="odd" align="center">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['size_c'].'</td>
	<td class="odd" align="center">';
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['fullflag']>0){
echo '���걾';
}else{
echo '<a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=fullflag&id='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" class="hottext" ajaxclick="true" retruemsg="false">��Ϊ�걾</a>';
}
echo '</td>
    <td class="odd" align="center">'.date('Y-m-d',$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['postdate']).'</td>
    <td class="even" align="center">'.date('Y-m-d H:i:s',$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['lastupdate']).'<br>';
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['signdate']>0 && $this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['permission']>3){
echo '<font color=red class="resign" data-id="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" title="�������������ǩԼʱ��">'.date('Y-m-d H:i:s',$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['signdate']).'</font>';
}else{
echo '<a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=permission&id='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" class="notice" ajaxclick="true" retruemsg="false">����Aǩ</a>';
}
echo '</td>
	<td class="even" align="center">'.defaultval($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['goodnum'],'0').'<br>('.defaultval($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['autogoodnum'],'0').'/';
echo bcsub($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['goodnum'],$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['autogoodnum']); 
echo ')</td>
	<td class="even" align="center">'.defaultval($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['visit'],'0').'</td>
	<td class="even" align="center">'.defaultval($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['vote'],'0').'</td>
	<td align="center" class="even">';
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['display']>0){
echo '<a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=show&id='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" ajaxclick="true" retruemsg="false"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/hide.gif" alt="�鼮״̬����" border="0" /></a>';
}else{
echo '<a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=hide&id='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" ajaxclick="true" retruemsg="false"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/show.gif" alt="�鼮״̬����" border="0" /></a>';
}
echo '</td>
	<td align="center" class="even">';
if($this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articletype']>0){
echo '<a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=novip&id='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" class="hottext" ajaxclick="true" confirm="��ȷ��Ҫȡ��VIP��" retruemsg="false">ȡ��VIP</a>';
}else{
echo '<a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=isvip&id='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" ajaxclick="true" retruemsg="false" confirm="��ȷ��Ҫ��ͨVIP��">����VIP</a>';
}
echo '<br /><a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&method=setvip&aid='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" title="�½�������V" class="green">�½���V(��)</a></td>
    <td align="center" class="even"><a href="'.geturl('article','chapter','SYS=method=cmView&aid='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'').'" target="_blank" title="�½ڹ���"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/editor.gif" border="0" /></a></td>
    <td align="center" class="even"><a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=download&id='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" class="notice" title="����"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/download.gif" border="0" /></a></td>
	<!--<td align="center" class="even"><a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=del&id='.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articleid'].'" ajaxclick="true"  confirm="ȷ��ɾ�������£�" retruemsg="false" title="ɾ��"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/delete_on.gif" border="0" /></a></td>-->
  </tr>
  ';
}
echo '
  <!--<tr>-->
    <!--<td width="3%" class="odd" align="center"><input type="checkbox" id="checkall" name="checkall" value="checkall" onclick="javascript: for (var i=0;i<this.form.elements.length;i++){ if (this.form.elements[i].name != \'checkkall\') this.form.elements[i].checked = form.checkall.checked; }"></td>-->
    <!--<td colspan="6" align="left" class="odd"><input type="submit" name="Submit" value="����ɾ��" class="button"><input name="batchdel" type="hidden" value="1"><input name="url_jump" type="hidden" value="'.$this->_tpl_vars['url_jump'].'"><input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" /><strong></strong></td>-->
  <!--</tr>-->
</table>
</form>
<div class="pages">'.$this->_tpl_vars['url_jumppage'].'</div>

<div>
        <ul class="layer_notice"><li><b>[ѡ�����]</b><a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=setagent&uid=-1" agentclick="true">���</a></li>';
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
        	<li style="height:25px; line-height:25px;">['.$this->_tpl_vars['groups'][$this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['groupid']].']<a href="'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=setagent&uid='.$this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uid'].'" agentclick="true">';
echo ($this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['name'] ? $this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['name'] : $this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uname']); 
echo '</a></li>
            ';
}
echo '<input type="hidden" value="0" id=\'tmpid\'>
        </ul>
</div>
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
	$(".resign").live("click",function(){
		var oldtime = $(this).html();
		var aid = $(this).attr("data-id");
		var url = "'.$this->_tpl_vars['article_dynamic_url'].'/web_admin/?controller=article&action=resign&id="+aid;
		var msg = "�����ı���<input id=\\"resign\\" onclick=\\"WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})\\" value=\\""+oldtime+"\\" />";
		$.layer({
		    area: [\'auto\',\'auto\'],
		    title: \'����ѡ��ǩԼʱ��\',
		    dialog: {
		        msg: msg,
		        btns: 2,                    
		        type: 4,
		        btn: [\'ȷ��\', \'ȡ��\'],
		        yes: function(){
					var time = $("#resign").val();
					url += "&signdate="+time;
					var i = layer.load(0);
					if(!targetid) var targetid = \'content\';
					GPage.getJson(url,function(data){
							layer.close(i);
						    if(data.status==\'OK\'){
		//						if(retruemsg!=\'false\' &&  retruemsg) 
								layer.msg(data.msg, 1, 1);//alert(data.jumpurl);
								GPage.loadpage(targetid, data.jumpurl, true,false);
							}else{
								layer.alert(data.msg, 8, !1);
							}
					});
		        }
		    }
		});
//		layer.confirm(msg, function(){
//			var time = $("#resign").val();
//			url += "&signdate="+time;
//			var i = layer.load(0);
//			if(!targetid) var targetid = \'content\';
//			GPage.getJson(url,function(data){
//					layer.close(i);
//				    if(data.status==\'OK\'){
////						if(retruemsg!=\'false\' &&  retruemsg) 
//						layer.msg(data.msg, 1, 1);//alert(data.jumpurl);
//						GPage.loadpage(targetid, data.jumpurl, true,false);
//					}else{
//						layer.alert(data.msg, 8, !1);
//					}
//			});
//		},"����ѡ��ǩԼʱ��")
	});
}); 
</script>';
?>