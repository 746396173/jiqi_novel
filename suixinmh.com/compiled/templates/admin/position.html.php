<?php
echo '<table class="grid" width="100%" align="center">
  <caption>��ǩ����</caption>
  <tr>
    <td style="width: 20%;"><a href=\''.$this->_tpl_vars['adminprefix'].'&method=add&step=one\'><font color="red">��ӱ�ǩ</font></a></td>
    <td style="width: 80%;overflow: hidden;">
    	<form action="'.$this->_tpl_vars['adminprefix'].'" method="post" style="float: right;">
			<label for="">��ǩID��</label>
			<input type="text" name="search_id" placeholder="����ǩid��ѯ" value="'.$this->_tpl_vars['_REQUEST']['search_id'].'" />
    		<label for="">��ѯ���ƣ�</label>
    		<input type="text" name="search_name" placeholder="����ǩ���Ʋ�ѯ" value="'.$this->_tpl_vars['_REQUEST']['search_name'].'" />
    		<label for="">�������ƣ�</label>
    		<select name="search_ptype">
    			<option value="0" ';
if($this->_tpl_vars['_REQUEST']['search_ptype']==0){
echo ' selected="selected"';
}
echo '>ȫ������</option>
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
if($this->_tpl_vars['_REQUEST']['search_ptype']==$this->_tpl_vars['i']['key']){
echo ' selected="selected"';
}
echo '>'.$this->_tpl_vars['ptypes'][$this->_tpl_vars['i']['key']]['module'].'&nbsp;|&nbsp;'.$this->_tpl_vars['ptypes'][$this->_tpl_vars['i']['key']]['name'].'</option>
    			';
}
echo '
    		</select>
    		<input type="submit" value="��������ѯ" class="button" style="cursor: pointer;" />
    		<a href="'.$this->_tpl_vars['adminprefix'].'">��ѯȫ��</a>
    	</form>
    </td>
  </tr>
</table>
<form method="post" action="'.$this->_tpl_vars['adminprefix'].'&method=order">
<table class="grid" width="100%" align="center">
    <caption>��ǩ�б�</caption>
    <tr>
        <th width="4%">����</th>
        <th width="4%">ID</th>
        <th width="12%">��ǩ����</th>
        <th width="5%">��ǩ����</th>
		<th width="13%">ģ����ñ�ǩ</th>
		<th width="25%">Զ�̵���js</th>
		<th width="7%">��ǩ����</th>
        <th width="7%">�������</th>
    </tr>';
if (empty($this->_tpl_vars['_PAGE']['rows'])) $this->_tpl_vars['_PAGE']['rows'] = array();
elseif (!is_array($this->_tpl_vars['_PAGE']['rows'])) $this->_tpl_vars['_PAGE']['rows'] = (array)$this->_tpl_vars['_PAGE']['rows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['_PAGE']['rows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['_PAGE']['rows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['_PAGE']['rows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['_PAGE']['rows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['_PAGE']['rows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	$this->_tpl_vars['posid']=$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['posid']; 
echo '
    <tr onmouseover="this.style.backgroundColor=\'#EAF8FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
      <td class="align_c"><input type="text" name="order['.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['posid'].']" value="'.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['listorder'].'" size="5"></td>
        <td class="align_c">'.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['posid'].'</td>
        <td class="align_c"><a href="?ac=position&op=view&posid='.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['posid'].'">'.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['name'].'</a></td>
        <td style="text-align: center;">';
if($this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['ptypeid']!=0){
echo $this->_tpl_vars['ptypes'][$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['ptypeid']]['module'].'|'.$this->_tpl_vars['ptypes'][$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['ptypeid']]['name'];
}else{
echo 'empty|δ����';
}
echo '</td>
		<td class="align_c"><input name="tagconfig" type="text" size="35" value="'.$this->_tpl_vars['_PAGE']['ltag'].'tag_system_'.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['posid'].'_'.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['name'].$this->_tpl_vars['_PAGE']['rtag'].'" onFocus="this.select()"></td>
		<td class="align_c"><input name="tagconfig" type="text" size="55" value="'.jieqi_geturl('system','tags',''.$this->_tpl_vars['posid'].'','js').'" onFocus="this.select()"></td>
		<td class="align_c">';
if($this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['type']=='0'){
echo '�Ƽ�λ';
}elseif($this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['type']=='1'){
echo '��ѯ����';
}else{
echo '�Զ�������';
}
echo '</td>
        <td class="align_c"><a href="'.$this->_tpl_vars['adminprefix'].'&method=view&posid='.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['posid'].'">Ԥ��</a>  | <a href="'.$this->_tpl_vars['adminprefix'].'&method=add&posid='.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['posid'].'">�޸�</a>  | <a href="javascript:confirmurl(\''.$this->_tpl_vars['adminprefix'].'&method=del&posid='.$this->_tpl_vars['_PAGE']['rows'][$this->_tpl_vars['i']['key']]['posid'].'\', \'�Ƿ�ɾ�����Ƽ�λ\')">ɾ��</a> </td>
    </tr>';
}
echo '  
</table>
<div class="button_box"><input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" /><input name="dosubmit" type="submit" value=" �������� " class="text"/></div>'.$this->_tpl_vars['_PAGE']['url_jumppage'].'
</form>
<table cellpadding="0" cellspacing="1" class="grid" width="100%">
  <caption>��ʾ��Ϣ</caption>
  <tr>
    <td>��ǩ����֧����ȫ�ֶ����£����ҿ����������ݣ����������顢ר����������ҳƵ���Ƽ����µ����ݡ�<br />
	��������ģ����ֱ�Ӳ���"<font color="red">'.$this->_tpl_vars['_PAGE']['ltag'].'tag_system_1_��ĿҳͼƬ����'.$this->_tpl_vars['_PAGE']['rtag'].'</font>"��ʽ�ı�ǩ��������ʾ��ǩ���õ���Ӧ���ݡ�<br />
	��ǩ��ʽ˵����<br />
	1����һ������"<font color="red">tag</font>"��ϵͳ�����ʶ�������޸ģ�<br />
	2���ڶ�������"<font color="red">system</font>"�ǵ�ǰģ������ƣ�ϵͳ���ݴ���������Ӧģ���µĴ������<br />
	4������������"<font color="red">1</font>"�ǵ�ǰ��ǩ�ı��ID����֤�ñ�Ŵ��ڼ��ɡ�<br />
	4�����ĸ�����"<font color="red">��ĿҳͼƬ����</font>"�Ǳ�ǩ���ƣ���ҳ���ǩ��һ��˵����
	</td>
  </tr>
</table>';
?>