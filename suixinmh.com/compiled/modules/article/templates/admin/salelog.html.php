<?php
echo '<form name="frmsearch" method="post" action="'.$this->_tpl_vars['jieqi_url'].'/modules/article/web_admin/?controller=salelog">
<table class="grid" width="100%" align="center">
    <tr>
        <td class="odd">�ؼ��֣�
            <input name="keyword" type="text" id="keyword" class="text" size="0" maxlength="50" value="'.$this->_tpl_vars['keyword'].'"> <input name="keytype" type="radio" class="radio" value="0" ';
if($this->_tpl_vars['keytype']!=1){
echo ' checked="checked" ';
}
echo '>
            �û�ID &nbsp;&nbsp;
            <input type="radio" name="keytype" class="radio" value="1" ';
if($this->_tpl_vars['keytype']==1){
echo ' checked="checked" ';
}
echo '>
            �û��� &nbsp;&nbsp;
            <input type="submit" name="btnsearch" class="button" value="�� ��">         
        </td>
    </tr>
</table>
</form>
<br />
<table class="grid" width="100%" align="center">
<caption>���¶��ļ�¼</caption>
  <tr align="center" valign="middle">
  	<th width="14%">�û�</th>
    <th width="22%">��������</th>
    <th width="28%">�����½�</th>
    <th width="12%">�������</th>
	<th width="20%">����ʱ��</th>
  </tr>
  ';
if (empty($this->_tpl_vars['pay'])) $this->_tpl_vars['pay'] = array();
elseif (!is_array($this->_tpl_vars['pay'])) $this->_tpl_vars['pay'] = (array)$this->_tpl_vars['pay'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['pay']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['pay']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['pay']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['pay']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['pay']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr valign="middle">
  	<td align="center" class="even"><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['accountid'].'').'" target="_blank">';
echo str_replace($this->_tpl_vars['keyword'],'<span class="blue">'.$this->_tpl_vars['keyword'].'</span>' ,$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['account']); 
echo '</a></td>
    <td align="left" class="odd"><a href="'.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['url_articleinfo'].'" target="_blank">';
echo str_replace($this->_tpl_vars['keyword'],'<span class="blue">'.$this->_tpl_vars['keyword'].'</span>' ,$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['articlename']); 
echo '</a></td>
    <td align="left" class="even"><a href="'.geturl('article','reader','aid='.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['articleid'].'','cid='.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['chapterid'].'').'" target="_blank">'.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['chaptername'].'</a></td>
    <td align="center" class="odd">'.$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['saleprice'].'</td>
    <td align="center" class="odd">'.date('Y-m-d H:i:s',$this->_tpl_vars['pay'][$this->_tpl_vars['i']['key']]['buytime']).'</td>
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