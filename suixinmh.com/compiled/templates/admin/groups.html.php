<?php
echo '<table class="grid" width="100%" align="center">
  <caption>�û������</caption>
  <tr align="center">
    <th width="30">���</th>
    <th width="100">����</th>
    <th width="360">����</th>
    <th width="70">����</th>
  </tr>
  ';
if (empty($this->_tpl_vars['groups'])) $this->_tpl_vars['groups'] = array();
elseif (!is_array($this->_tpl_vars['groups'])) $this->_tpl_vars['groups'] = (array)$this->_tpl_vars['groups'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['groups']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['groups']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['groups']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['groups']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['groups']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr>
    <td class="odd" align="center">'.$this->_tpl_vars['groups'][$this->_tpl_vars['i']['key']]['groupid'].'</td>
    <td class="even" align="center">'.$this->_tpl_vars['groups'][$this->_tpl_vars['i']['key']]['name'].'</td>
    <td class="odd" align="left">'.$this->_tpl_vars['groups'][$this->_tpl_vars['i']['key']]['description'].'</td>
    <td class="even" align="center"><a href="'.$this->_tpl_vars['groups'][$this->_tpl_vars['i']['key']]['url_edit'].'">�༭</a>';
if($this->_tpl_vars['groups'][$this->_tpl_vars['i']['key']]['grouptype'] == 0){
echo '  <a href="javascript:if(confirm(\'ȷʵҪɾ�����û���ô��\')) document.location=\''.$this->_tpl_vars['groups'][$this->_tpl_vars['i']['key']]['url_del'].'\';">ɾ��</a>';
}
echo '</td>
  </tr>
  ';
}
echo '
  <tr>
    <td colspan="4" class="foot">&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">'.$this->_tpl_vars['form_addgroup'].'</td>
  </tr>
</table>
';
?>