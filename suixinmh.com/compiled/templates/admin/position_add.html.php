<?php
echo '<table align="center" cellpadding="2" cellspacing="1" class="grid" width="100%">
  <caption>��ǩ����</caption>
  <tr>
    <td><a href=\''.$this->_tpl_vars['adminprefix'].'&method=add&step=one\'><font color="red">��ӱ�ǩ</font></a> | <a href=\''.$this->_tpl_vars['adminprefix'].'\'>���ر�ǩ�б�</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="1" class="grid" width="100%">
<form action="'.$this->_tpl_vars['adminprefix'].'&method=add&posid='.$this->_tpl_vars['_SGLOBAL']['position']['posid'].'" method="post" name="myform" onSubmit="return CheckForm();">
    <caption>';
if($this->_tpl_vars['_SGLOBAL']['position']['posid']>0){
echo '�༭';
}else{
echo '���';
}
if($this->_tpl_vars['_SGLOBAL']['position']['type']=='0'){
echo '�Ƽ�λ';
}elseif($this->_tpl_vars['_SGLOBAL']['position']['type']=='1'){
echo '��ѯ����';
}else{
echo '�Զ�������';
}
echo '</caption>
	<tr> 
      <th width=\'15%\'><font color="red">*</font> <strong>';
if($this->_tpl_vars['_SGLOBAL']['position']['type']=='0'){
echo '�Ƽ�λ';
}elseif($this->_tpl_vars['_SGLOBAL']['position']['type']=='1'){
echo '��ѯ����';
}else{
echo '�Զ�������';
}
echo '����</strong></th>
      <td><input type="text" name="info[name]" id="name" value="'.$this->_tpl_vars['_SGLOBAL']['position']['name'].'" size="30" require="true" datatype="limit" min="2" max="30" msg="��������2���ַ�����30���ַ�"></td>
    </tr>
    <tr> 
      <th width=\'15%\'><font color="red">*</font> <strong>��ǩ����</strong></th>
      <td>
		<select name="ptypeid" id="j_ptypeid">
			<option value="0" ';
if($this->_tpl_vars['_SGLOBAL']['position']['ptypeid']==0){
echo ' selected="selected" ';
}
echo ' style="color: red;">δ����</option>
			';
if (empty($this->_tpl_vars['ptypes'])) $this->_tpl_vars['ptypes'] = array();
elseif (!is_array($this->_tpl_vars['ptypes'])) $this->_tpl_vars['ptypes'] = (array)$this->_tpl_vars['ptypes'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['ptypes']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['ptypes']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['ptypes']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['ptypes']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['ptypes']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
			<option value="'.$this->_tpl_vars['i']['key'].'" ';
if($this->_tpl_vars['_SGLOBAL']['position']['ptypeid']==$this->_tpl_vars['i']['key']){
echo ' selected="selected"';
}
echo '>'.$this->_tpl_vars['ptypes'][$this->_tpl_vars['i']['key']]['module'].'&nbsp;|&nbsp;'.$this->_tpl_vars['ptypes'][$this->_tpl_vars['i']['key']]['name'].'</option>
			';
}
echo '
		</select>
      </td>
    </tr>
	<tr> 
      <th><font color="red">*</font> <strong>����Ȩֵ</strong></th>
      <td><input type="text" name="info[listorder]" id="listorder"  value="'.$this->_tpl_vars['_SGLOBAL']['position']['listorder'].'" size="10" require="true" datatype="number" msg="����������"></td>
    </tr>
	
	';
if($this->_tpl_vars['_SGLOBAL']['position']['type']=='2'){
echo '
		<tr> 
      <th><strong>��������</strong></th>
      <td>
	<textarea name="setting[content]" id="content" rows="20" cols="130">'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['content'].'</textarea></td>
    </tr>	
	';
}
echo '
	
	';
if($this->_tpl_vars['_SGLOBAL']['position']['type']=='2'){
echo '
	<tr> 
      <th><strong>ģ���ļ�˵��</strong></th>
      <td>����Ĭ��ģ���ļ�Ϊ��block_content.html������/templates/blocksĿ¼�£����������������ģ���ļ���Ҳ�����ڴ�Ŀ¼��ģ���ļ��������ձ�ʾʹ��Ĭ��ģ�塣</td>
    </tr>
	';
}
echo '
	';
if($this->_tpl_vars['_SGLOBAL']['position']['type']=='1'){
echo '
	<tr> 
      <th><strong>�����ļ�</strong></th>
      <td>';
if($this->_tpl_vars['_SGLOBAL']['position']['setting']['filename']!=''){
echo $this->_tpl_vars['_SGLOBAL']['position']['setting']['filename'].'.php';
}else{
echo '�Զ�������';
}
echo '</td>
    </tr>
	';
if($this->_tpl_vars['_SGLOBAL']['position']['setting']['description']!=''){
echo '
	<tr> 
      <th><strong>��������</strong></th>
      <td>'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['description'].'</td>
    </tr>
	';
}
echo '
	';
if($this->_tpl_vars['_SGLOBAL']['position']['setting']['filename']!='' && $this->_tpl_vars['_SGLOBAL']['position']['setting']['hasvars']>0){
echo '
	<tr> 
      <th><strong>�������</strong></th>
      <td><textarea  name="setting[vars]" id="vars" rows="3" cols="60">'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['vars'].'</textarea>
	  </td>
    </tr>
	';
}
echo '
	';
if($this->_tpl_vars['_SGLOBAL']['position']['setting']['filename']==''){
echo '
		<tr> 
      <th><strong>��������</strong></th>
      <td>
	<textarea name="setting[content]" id="content" rows="15" cols="80">'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['content'].'</textarea></td>
    </tr>	
	';
}
echo '
	<input type="hidden" name="setting[bid]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['bid'].'"> 
	<input type="hidden" name="setting[module]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['module'].'"> 
	<input type="hidden" name="setting[filename]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['filename'].'"> 
	<input type="hidden" name="setting[classname]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['classname'].'">
	<input type="hidden" name="setting[contenttype]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['contenttype'].'"> 
	<input type="hidden" name="setting[custom]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['custom'].'"> 
	<input type="hidden" name="setting[publish]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['publish'].'"> 
	<input type="hidden" name="setting[hasvars]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['hasvars'].'"> 
	';
}
echo '
	
	<tr> 
      <th><font color="red">*</font> <strong>ģ���ļ�</strong></th>
      <td><input type="text" name="setting[template]" id="template" value="'.$this->_tpl_vars['_SGLOBAL']['position']['setting']['template'].'" size="25" require="true"></td>
    </tr>

	
    <tr> 
      <th></th>
      <td> 
	  <input type="hidden" name="info[type]" value="'.$this->_tpl_vars['_SGLOBAL']['position']['type'].'"> 
	  <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
	  <input type="submit" name="dosubmit" value=" ȷ�� "> 
      &nbsp; <input type="reset" name="reset" value=" ��� ">
	  </td>
    </tr>
	</form>
</table>
<script language=\'JavaScript\' type=\'text/JavaScript\'>
function CheckForm(){
	if(document.myform.name.value==\'\'){
		alert(\'';
if($this->_tpl_vars['_SGLOBAL']['position']['type']=='0'){
echo '�Ƽ�λ';
}elseif($this->_tpl_vars['_SGLOBAL']['position']['type']=='1'){
echo '��ѯ����';
}else{
echo '�Զ�������';
}
echo '���ƣ�\');
		document.myform.name.focus();
		return false;
	}
	if(document.myform.listorder.value==\'\'){
		alert(\'����������Ȩֵ��\');
		document.myform.listorder.focus();
		return false;
	}
	if(document.myform.template.value==\'\'){
		alert(\'������ģ���ļ���\');
		document.myform.template.focus();
		return false;
	}
	if(document.getElementById("j_ptypeid").value==0){
		alert(\'����Ϊ�ñ�ǩ����һ������\');
		return false;
	}
}
</script>';
?>