<?php
echo '<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/calendar/WdatePicker.js"></script>
  <table width="100%" align="center" cellpadding="0" cellspacing="1" class="grid">
  <form name="frmsearch" method="post" action="'.$this->_tpl_vars['jieqi_modules']['pay']['url'].'/admin/?method=pay">  <tr>
      <td class="odd">�ؼ��֣�
        <input name="keyword" type="text" id="keyword" class="text" size="0" maxlength="50" value="'.$this->_tpl_vars['keyword'].'" />
          <input type="radio" name="keytype" class="radio" value="0"';
if($this->_tpl_vars['keytype']!=1){
echo ' checked="checked" ';
}
echo '/>
        �������
        <input name="keytype" type="radio" class="radio" value="1"';
if($this->_tpl_vars['keytype']==1){
echo ' checked="checked" ';
}
echo ' />
        �û���
<!--        <input type="radio" name="keytype" class="radio" value="2" />
        ����״̬
        <input type="radio" name="keytype" class="radio" value="3" />
        �ֻ���-->
<!--      </td>
        <td class="odd">-->
        
            ��Դ:
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
        ����״̬��
		  <select name="payflag">
		    <option value="all" ';
if($this->_tpl_vars['payflag']=='all'){
echo 'selected';
}
echo '>-δѡ��-</option>
		    <option value="3" ';
if($this->_tpl_vars['payflag']==3){
echo 'selected';
}
echo '>δȷ��</option>
		    <option value="1" ';
if($this->_tpl_vars['payflag']==1){
echo 'selected';
}
echo '>֧���ɹ�</option>
		    <option value="2" ';
if($this->_tpl_vars['payflag']==2){
echo 'selected';
}
echo '>�ֹ�ȷ��</option>
		  </select>
<!--		<input type="radio" name="payflag" class="radio" value="0" ';
if($this->_tpl_vars['payflag']==0||$this->_tpl_vars['payflag']==''){
echo 'checked';
}
echo '>δȷ��
		<input type="radio" name="payflag" class="radio" value="1" ';
if($this->_tpl_vars['payflag']==1){
echo 'checked';
}
echo '>֧���ɹ�
		<input type="radio" name="payflag" class="radio" value="2" ';
if($this->_tpl_vars['payflag']==2){
echo 'checked';
}
echo '>�ֹ�ȷ��-->
<!--		<input name="action" type="hidden" value="submit" />-->
<!--            <input type="submit" name="btnsearch" class="button" value="������������">         -->
<!--        </td>
		<td>-->&nbsp;&nbsp;֧����ʽ��
		  <select name="paytype">
		    <option value="all">-δѡ��-</option>
		    ';
if (empty($this->_tpl_vars['paytyperows'])) $this->_tpl_vars['paytyperows'] = array();
elseif (!is_array($this->_tpl_vars['paytyperows'])) $this->_tpl_vars['paytyperows'] = (array)$this->_tpl_vars['paytyperows'];
$this->_tpl_vars['j']=array();
$this->_tpl_vars['j']['columns'] = 1;
$this->_tpl_vars['j']['count'] = count($this->_tpl_vars['paytyperows']);
$this->_tpl_vars['j']['addrows'] = count($this->_tpl_vars['paytyperows']) % $this->_tpl_vars['j']['columns'] == 0 ? 0 : $this->_tpl_vars['j']['columns'] - count($this->_tpl_vars['paytyperows']) % $this->_tpl_vars['j']['columns'];
$this->_tpl_vars['j']['loops'] = $this->_tpl_vars['j']['count'] + $this->_tpl_vars['j']['addrows'];
reset($this->_tpl_vars['paytyperows']);
for($this->_tpl_vars['j']['index'] = 0; $this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['loops']; $this->_tpl_vars['j']['index']++){
	$this->_tpl_vars['j']['order'] = $this->_tpl_vars['j']['index'] + 1;
	$this->_tpl_vars['j']['row'] = ceil($this->_tpl_vars['j']['order'] / $this->_tpl_vars['j']['columns']);
	$this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['order'] % $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['column'] == 0) $this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['count']){
		list($this->_tpl_vars['j']['key'], $this->_tpl_vars['j']['value']) = each($this->_tpl_vars['paytyperows']);
		$this->_tpl_vars['j']['append'] = 0;
	}else{
		$this->_tpl_vars['j']['key'] = '';
		$this->_tpl_vars['j']['value'] = '';
		$this->_tpl_vars['j']['append'] = 1;
	}
	echo '
		    	<option value="'.$this->_tpl_vars['j']['key'].'" ';
if($this->_tpl_vars['paytype']==$this->_tpl_vars['j']['key']){
echo 'selected';
}
echo '>'.$this->_tpl_vars['paytyperows'][$this->_tpl_vars['j']['key']]['name'].'</option>
			';
}
echo '
		  </select>&nbsp;&nbsp;
		  ��ʼʱ�䣺<input name="start" id="start" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})" value="'.$this->_tpl_vars['start'].'" />
		  &nbsp;&nbsp;����ʱ�䣺<input name="end" id="end" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})" value="'.$this->_tpl_vars['end'].'" />&nbsp;
        <input type="submit" name="search" class="button" value="ȷ ��" /> <input type="submit" name="download" class="button" value="�� ��" /> <a href="'.$this->_tpl_vars['jieqi_url'].'/modules/pay/admin/?start=';
echo date('Y-m',time()); 
echo '">�ۺ�ͳ��</a>
		</td>
    </tr>
<!--    <tr>
      <td colspan="3" class="odd"><a href="'.$this->_tpl_vars['jieqi_url'].'/modules/pay/admin/paylog2.php">������ʾ</a>�ɹ�֧����';
if (empty($this->_tpl_vars['paytyperows'])) $this->_tpl_vars['paytyperows'] = array();
elseif (!is_array($this->_tpl_vars['paytyperows'])) $this->_tpl_vars['paytyperows'] = (array)$this->_tpl_vars['paytyperows'];
$this->_tpl_vars['j']=array();
$this->_tpl_vars['j']['columns'] = 1;
$this->_tpl_vars['j']['count'] = count($this->_tpl_vars['paytyperows']);
$this->_tpl_vars['j']['addrows'] = count($this->_tpl_vars['paytyperows']) % $this->_tpl_vars['j']['columns'] == 0 ? 0 : $this->_tpl_vars['j']['columns'] - count($this->_tpl_vars['paytyperows']) % $this->_tpl_vars['j']['columns'];
$this->_tpl_vars['j']['loops'] = $this->_tpl_vars['j']['count'] + $this->_tpl_vars['j']['addrows'];
reset($this->_tpl_vars['paytyperows']);
for($this->_tpl_vars['j']['index'] = 0; $this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['loops']; $this->_tpl_vars['j']['index']++){
	$this->_tpl_vars['j']['order'] = $this->_tpl_vars['j']['index'] + 1;
	$this->_tpl_vars['j']['row'] = ceil($this->_tpl_vars['j']['order'] / $this->_tpl_vars['j']['columns']);
	$this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['order'] % $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['column'] == 0) $this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['count']){
		list($this->_tpl_vars['j']['key'], $this->_tpl_vars['j']['value']) = each($this->_tpl_vars['paytyperows']);
		$this->_tpl_vars['j']['append'] = 0;
	}else{
		$this->_tpl_vars['j']['key'] = '';
		$this->_tpl_vars['j']['value'] = '';
		$this->_tpl_vars['j']['append'] = 1;
	}
	echo '<a href="'.$this->_tpl_vars['jieqi_url'].'/modules/pay/admin/paylog2.php?paytype='.$this->_tpl_vars['paytyperows'][$this->_tpl_vars['j']['key']]['type'].'"> '.$this->_tpl_vars['paytyperows'][$this->_tpl_vars['j']['key']]['name'].' </a>';
}
echo '<a href="'.$this->_tpl_vars['jieqi_url'].'/modules/pay/admin/paylogquery.php" target="_blank"> ����ͳ�� </a></td>
    </tr>--></form>
  </table>

<br />
<table class="grid" width="100%" align="center">
  <caption>����֧����¼ ���ܽ�'.$this->_tpl_vars['sum'].'�� ��'.$this->_tpl_vars['egoldname'].'��'.$this->_tpl_vars['totalegold'].'������'.$this->_tpl_vars['totalnum'].'����¼��</caption>
  <tr align="center" valign="middle">
    <th width="10%">���</th>
    <th width="8%">����</th>
    <th width="8%">ʱ��</th>
    <th width="12%">�û���</th>
	<th width="10%">���</th>
    <th width="12%">�������</th>
    <th width="7%">��Դ</th>
    <th width="12%">֧����ʽ</th>
    <th width="5%">����״̬</th>
    <th width="">����</th>
  </tr>
  ';
if (empty($this->_tpl_vars['payrows'])) $this->_tpl_vars['payrows'] = array();
elseif (!is_array($this->_tpl_vars['payrows'])) $this->_tpl_vars['payrows'] = (array)$this->_tpl_vars['payrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['payrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['payrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['payrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['payrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['payrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr valign="middle">
    <td align="center" class="odd">'.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['payid'].'</td>
    <td align="center" class="odd">'.date('Y-m-d',$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['buytime']).'</td>
    <td align="center" class="even">'.date('H:i:s',$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['buytime']).'</td>
    <td align="center" class="odd">';
if($this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['buyname'] == ''){
echo $this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['buyinfo'];
}else{
echo '<a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['buyid'].'').'" target="_blank">'.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['buyname'].'</a>';
}
echo '</td>
	<td align="center" class="even">'.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['money'].' ';
if($this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['moneytype']==1){
echo '��Ԫ';
}else{
echo 'Ԫ';
}
echo '</td>
    <td align="center" class="even">'.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['egold'].'</td>
    <td align="center">'.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['from'].'</td>
    <td align="center" class="odd">';
if($this->_tpl_vars['paytyperows'][$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['paytype']] != null){
echo $this->_tpl_vars['paytyperows'][$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['paytype']]['name'];
}else{
echo $this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['paytype'];
}
echo '</td>
    <td class="even">'.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['payflag_c'].'</td>
    <td align="center" class="odd">';
if($this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['payflag'] == 0){
echo '<a href="'.$this->_tpl_vars['jieqi_modules']['pay']['url'].'/admin/?method=pay&action=confirm&id='.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['payid'].'" ajaxclick="true" confirm="ȷ���ֹ����������¼��" retruemsg="false">�ֹ�����</a> | <a href="'.$this->_tpl_vars['jieqi_modules']['pay']['url'].'/admin/?method=pay&action=del&id='.$this->_tpl_vars['payrows'][$this->_tpl_vars['i']['key']]['payid'].'" ajaxclick="true" confirm="ȷ��ɾ��������¼��" retruemsg="false">ɾ��</a>';
}
echo '</td>
  </tr>
  ';
}
echo '
</table>
<table class="hide" width="100%"  border="0" cellspacing="0" cellpadding="0">
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