<?php
echo '<form name="frmsearch" method="post" action="'.$this->_tpl_vars['article_static_url'].'/admin/?controller=articlelog">
<table class="grid" width="100%" align="center">
    <tr>
        <td class="odd">�ؼ��֣�
            <input name="keyword" type="text" id="keyword" class="text" size="0" maxlength="50"> <input name="keytype" type="radio" class="radio" value="0" checked>
            ������Ա
            <input type="radio" name="keytype" class="radio" value="1">
            �������� &nbsp;&nbsp;
            <input type="submit" name="btnsearch" class="button" value="�� ��">         
        </td>
    </tr>
</table>
</form>
<br />
<table class="grid" width="100%" align="center">
<caption>����ɾ����¼</caption>
  <tr align="center" valign="middle">
    <th width="20%">����</th>
    <th width="20%">ʱ��</th>
    <th width="30%">�����û�</th>
    <th width="30%">��������</th>
  </tr>
  ';
if (empty($this->_tpl_vars['logrows'])) $this->_tpl_vars['logrows'] = array();
elseif (!is_array($this->_tpl_vars['logrows'])) $this->_tpl_vars['logrows'] = (array)$this->_tpl_vars['logrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['logrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['logrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['logrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['logrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['logrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr valign="middle">
    <td align="center" class="odd">'.$this->_tpl_vars['logrows'][$this->_tpl_vars['i']['key']]['date'].'</td>
    <td align="center" class="even">'.$this->_tpl_vars['logrows'][$this->_tpl_vars['i']['key']]['time'].'</td>
    <td class="odd"><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['logrows'][$this->_tpl_vars['i']['key']]['userid'].'').'" target="_blank">'.$this->_tpl_vars['logrows'][$this->_tpl_vars['i']['key']]['username'].'</a></td>
    <td class="even">'.$this->_tpl_vars['logrows'][$this->_tpl_vars['i']['key']]['articlename'].'</td>
  </tr>
  ';
}
echo '
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">'.$this->_tpl_vars['url_jumppage'].'</td>
  </tr>
</table>
<br /><br />
';
?>