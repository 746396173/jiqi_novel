<?php
echo '<table class="grid" width="100%" align="center">
  <caption>��ǩ�������</caption>
  <tr>
    <td>
    	<form action="'.$this->_tpl_vars['adminprefix'].'" method="post">
    		<label for="">����������</label>
    		<input type="text" name="name" placeholder="֧��ģ����ѯ" />
    		<input type="submit" class="button" value="����" />
    		<a href="'.$this->_tpl_vars['adminprefix'].'" class="button">����ȫ��</a>
    	</form>
    </td>
  </tr>
</table>
<form method="post" action="'.$this->_tpl_vars['adminprefix'].'&method=order">
<table class="grid" width="100%" align="center">
    <caption>��ǩ�����б�&nbsp;[<a href=\''.$this->_tpl_vars['adminprefix'].'&method=add\'>+<span>����µı�ǩ</span></a>]</caption>
    <tr>
        <th width="4%">ID</th>
        <th width="20%">��������</th>
		<th width="15%">��Ӧģ��</th>
		<th width="35%">����</th>
		<th width="16%">����ʱ��</th>
        <th width="10%">�������</th>
    </tr>
    ';
if (empty($this->_tpl_vars['lists'])) $this->_tpl_vars['lists'] = array();
elseif (!is_array($this->_tpl_vars['lists'])) $this->_tpl_vars['lists'] = (array)$this->_tpl_vars['lists'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['lists']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['lists']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['lists']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['lists']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['lists']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
    	<tr onmouseover="this.style.backgroundColor=\'#EAF8FF\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
	        <td class="align_c">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['id'].'</td>
	        <td class="align_c">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['name'].'</td>
			<td class="align_c">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['module'].'</td>
			<td class="align_c">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['description'].'</td>
			<td class="align_c">'.date('Y-m-d H:i:s',$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['createtime']).'</td>
	        <td class="align_c"><a href="'.$this->_tpl_vars['adminprefix'].'&method=edit&ptid='.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['id'].'">�޸�</a>  | <a href="javascript:confirmurl(\''.$this->_tpl_vars['adminprefix'].'&method=del&ptid='.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['id'].'\', \'�Ƿ�ɾ�����Ƽ�λ\')">ɾ��</a> </td>
    	</tr>
    ';
}
echo '  
</table>
'.$this->_tpl_vars['url_jumppage'].'
</form>';
?>