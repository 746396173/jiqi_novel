<?php
echo '<table class="grid" width="100%" align="center">
	<caption>�ɼ�����</caption>
    <tr>
        <td class="odd"><a href="'.$this->_tpl_vars['article_static_url'].'/admin/?controller=collectset"><font color="red">���زɼ������б�</font></a></td>
    </tr>
</table>
<table class="grid" width="100%" align="center">
<caption>'.$this->_tpl_vars['sitename'].'ҳ�������ɼ���������</caption>
  <tr align="center">
    <th width="40%">�ɼ���������</th>
    <th width="30%">���ɼ�ҳ��</th>
    <th width="30%">����</th>
  </tr>
  ';
if (empty($this->_tpl_vars['collectrows'])) $this->_tpl_vars['collectrows'] = array();
elseif (!is_array($this->_tpl_vars['collectrows'])) $this->_tpl_vars['collectrows'] = (array)$this->_tpl_vars['collectrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['collectrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['collectrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['collectrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['collectrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['collectrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr>
    <td class="odd" align="center">'.$this->_tpl_vars['collectrows'][$this->_tpl_vars['i']['key']]['title'].'</td>
    <td align="center" class="even">'.$this->_tpl_vars['collectrows'][$this->_tpl_vars['i']['key']]['maxpagenum'].'</td>
    <td align="center" class="odd"><a href="'.$this->_tpl_vars['article_static_url'].'/admin/?controller=collectset&method=collectpeditview&config='.$this->_tpl_vars['config'].'&cid='.$this->_tpl_vars['i']['key'].'">�༭</a> | <a href="javascript:if(confirm(\'ȷʵҪɾ���òɼ�����ô��\')) document.location=\''.$this->_tpl_vars['article_static_url'].'/admin/?controller=collectset&method=collectpage&action=del&config='.$this->_tpl_vars['config'].'&cid='.$this->_tpl_vars['i']['key'].'\'">ɾ��</a></td>
  </tr>
  ';
}
echo '
</table>
<br />
'.$this->_tpl_vars['addnewtable'].'
';
?>