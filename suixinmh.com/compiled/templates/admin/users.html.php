<?php
echo '<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/calendar/WdatePicker.js"></script>
<form name="frmquery" method="post" action="'.$this->_tpl_vars['jieqi_url'].'/web_admin/?controller=users">
<table class="grid" width="100%" align="center">
  <tr class="odd" align="center">
	<td>
	<a href="?controller=users">ȫ����Ա</a>';
if (empty($this->_tpl_vars['grouprows'])) $this->_tpl_vars['grouprows'] = array();
elseif (!is_array($this->_tpl_vars['grouprows'])) $this->_tpl_vars['grouprows'] = (array)$this->_tpl_vars['grouprows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['grouprows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['grouprows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['grouprows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['grouprows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['grouprows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo ' | <a href="?controller=users&groupid='.$this->_tpl_vars['grouprows'][$this->_tpl_vars['i']['key']]['groupid'].'">'.$this->_tpl_vars['grouprows'][$this->_tpl_vars['i']['key']]['groupname'].'</a>';
}
echo '
	</td>
  </tr>
  <tr>
    <td class="even">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="hide">
      <tr>
        <td width="5%" valign="middle">��Ա����'.$this->_tpl_vars['rowcount'].'</td>
        <td width="80%" valign="middle">
		��ʼע��ʱ�䣺<input name="start" id="start" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})" value="'.$this->_tpl_vars['start'].'" />
		  &nbsp;&nbsp;&nbsp;&nbsp;����ע��ʱ�䣺<input name="end" id="end" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})" value="'.$this->_tpl_vars['end'].'" />&nbsp;&nbsp;&nbsp;
		            ��Դ��
        <select name="sel_site" id="sel_site">
                    <option value="-1">-ȫ����Դ-</option>
                    ';
if (empty($this->_tpl_vars['sites'])) $this->_tpl_vars['sites'] = array();
elseif (!is_array($this->_tpl_vars['sites'])) $this->_tpl_vars['sites'] = (array)$this->_tpl_vars['sites'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['sites']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['sites']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['sites']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['sites']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['sites']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
                    <option value="'.$this->_tpl_vars['i']['key'].'" ';
if($this->_tpl_vars['sel_site'] != "" && $this->_tpl_vars['sel_site']==$this->_tpl_vars['i']['key']){
echo 'selected';
}
echo '>'.$this->_tpl_vars['i']['value'].'</option>
                    ';
}
echo '
                </select>
		�û����ƣ�
        <input name="keyword" type="text" class="text" id="keyword" size="20" maxlength="50">
	    <input name="keytype" type="radio" value="uname" checked="checked" />�û��� 
		<input name="keytype" type="radio" value="name" />�ǳ�
          <input name="keytype" type="radio" value="uid" />UID
          <input type="submit" name="Submit" value="�� ��" class="button">&nbsp;&nbsp;
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
<br />
<form action="" method="post" name="checkform" id="checkform">
<table class="grid" width="100%" align="center">
<caption>�û��б�</caption>
  <tr align="center" class="head">
    <td width="10%" valign="middle">�û���</td>
	<td width="10%" valign="middle">�ǳ�</td>
    <td width="10%" valign="middle">ע������</td>
	<td width="10%" valign="middle">����½</td>
	<td width="10%" valign="middle">����½IP</td>
    <td width="5%" valign="middle">�ȼ�</td>
    <td width="5%" valign="middle">��Դ</td>
    <td width="6%" valign="middle">����ֵ</td>
    <td width="5%" valign="middle">����</td>
	<td width="6%" valign="middle">VIP����</td>
    <td width="10%" valign="middle">'.$this->_tpl_vars['jieqi_sitename'].'��/����</td>
<td width="6%" valign="middle">����</td>
    <td valign="middle">����</td>
  </tr>
  ';
if (empty($this->_tpl_vars['userrows'])) $this->_tpl_vars['userrows'] = array();
elseif (!is_array($this->_tpl_vars['userrows'])) $this->_tpl_vars['userrows'] = (array)$this->_tpl_vars['userrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['userrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['userrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['userrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['userrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['userrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr valign="middle">
    <td class="even"><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['userid'].'').'" target="_blank">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['username'].'</a></td>
	<td align="center" class="odd"><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['userid'].'').'" target="_blank">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['name'].'</a></td>
    <td align="center" class="even">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['regdate'].'</td>
	<td align="center" class="even">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['setting']['logindate'].'</td>
	<td align="center" class="even">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['setting']['lastip'].'</td>
    <td class="even">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['group'].'</td>
    <td align="center" class="even">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['from'].'</td>
    <td align="center" class="odd">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['experience'].'</td>
    <td align="center" class="even">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['score'].'</td>
	<td align="center" class="even">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['isvip'].'</td>
    <td align="center" class="odd">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['egold'].'/'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['esilver'].'</td><td align="center" class="even">'.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['source'].'</td>
    <td align="center" class="even"><a href="'.$this->_tpl_vars['jieqi_url'].'/web_admin/?controller=usermanage&id='.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['userid'].'">����</a> <a href="'.$this->_tpl_vars['jieqi_url'].'/web_admin/?controller=users&action=login&id='.$this->_tpl_vars['userrows'][$this->_tpl_vars['i']['key']]['userid'].'" target="_blank">��½</a></td>
  </tr>
  ';
}
echo '
</table>
</form>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">'.$this->_tpl_vars['url_jumppage'].'</td>
  </tr>
</table>

';
?>