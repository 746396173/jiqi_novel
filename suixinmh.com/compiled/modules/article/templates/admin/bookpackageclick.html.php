<?php
echo '<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/calendar/WdatePicker.js"></script>
<style>
.layer_notice{float:left; height:75px; width:170px;  overflow:hidden; display:none;  background:#78BA32; padding:10px; border:1px solid #628C1C;}
/*layer_notice li{ height:30px; line-height:30px;}
.layer_notice li a{ display:block; color:#fff;}
.layer_notice li a:hover{ background:#fff; color:#78BA32;}*/
</style>
<form name="frmsearch" method="post" action="'.$this->_tpl_vars['adminprefix'].'&method=bpclick">
<table class="grid" width="100%" align="center">
    <tr>
        <td class="odd">�ؼ��֣�
            <input name="keyword" type="text" id="keyword" value="'.$this->_tpl_vars['_REQUEST']['keyword'].'" class="text" size="15" maxlength="50">&nbsp;<input type="radio" name="searchkey" value="bpname" ';
if($this->_tpl_vars['_REQUEST']['searchkey']=='bpname' || !isset($this->_tpl_vars['_REQUEST']['searchkey'])){
echo 'checked="checked"';
}
echo ' />&nbsp;�������&nbsp;<input type="radio" name="searchkey" value="bookname" ';
if($this->_tpl_vars['_REQUEST']['searchkey']=='bookname'){
echo 'checked="checked"';
}
echo ' />&nbsp;�鼮����&nbsp;<input type="radio" name="searchkey" value="authorname" ';
if($this->_tpl_vars['_REQUEST']['searchkey']=='authorname'){
echo 'checked="checked"';
}
echo ' />&nbsp;����
            &nbsp;&nbsp;�������ڣ�<input onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})" type="text" name="start" value="'.$this->_tpl_vars['_REQUEST']['start'].'" />
            -&nbsp;<input onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:00\'})" type="text" name="end" value="'.$this->_tpl_vars['_REQUEST']['end'].'" />
            &nbsp;&nbsp;����״̬��
            <select name="overtime" >
                <option value="0" ';
if($this->_tpl_vars['_REQUEST']['overtime']==0 ||!$this->_tpl_vars['_REQUEST']['overtime']){
echo 'selected="selected"';
}
echo '>ȫ�����</option>
                <option value="1" ';
if($this->_tpl_vars['_REQUEST']['overtime']==1){
echo 'selected="selected"';
}
echo '>δ�������</option>
                <option value="2" ';
if($this->_tpl_vars['_REQUEST']['overtime']==2){
echo 'selected="selected"';
}
echo '>�ѹ������</option>
            </select>
            <input type="submit" name="dosubmit" class="button" style="cursor:pointer" value="�� ��">
        </td>
    </tr>
</table>
</form>
<br />
<table class="grid" width="100%" align="center">
    <caption>����Ķ�ͳ�ƣ���'.$this->_tpl_vars['count'].'����¼��</caption>
    <tr align="center">
        <th width="5%">���۱��</th>
        <th width="13%">�������</th>
        <th width="13%">�鼮����</th>
        <th width="10%">����</th>
        <th width="10%">�Ķ���</th>
        <th width="9%">������ۼ�</th>
        <!--<th width="16%">�Ķ���</th>-->
        <th width="15%">����ʱ��</th>
        <th width="8%">����״̬</th>
    </tr>
    ';
if (empty($this->_tpl_vars['salelist'])) $this->_tpl_vars['salelist'] = array();
elseif (!is_array($this->_tpl_vars['salelist'])) $this->_tpl_vars['salelist'] = (array)$this->_tpl_vars['salelist'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['salelist']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['salelist']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['salelist']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['salelist']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['salelist']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
        <tr>
            <td align="center">'.$this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['saleid'].'</td>
            <td align="center">'.$this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['bpname'].'</td>
            <td align="center">'.$this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['bookname'].'</td>
            <td align="center">'.$this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['authorname'].'</td>
            <td align="center">'.$this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['clicks'].'</td>
            <td align="center">'.$this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['price'];
if($this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['pricetype']==1){
echo '�麣��';
}else{
echo '��Ԫ';
}
echo '</td>
            <!--<td align="center"><a id="j_bpsale_list" bpsale-id="'.$this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['id'].'" href="javascript:;">������鿴��ϸ��</a></td>-->
            <td align="center">'.date('Y-m-d H:i:s',$this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['end_time']).'</td>
            <td align="center">';
if($this->_tpl_vars['salelist'][$this->_tpl_vars['i']['key']]['end_time']>=time()){
echo '<p style="color:#66ff00">δ����</p>';
}else{
echo '<p style="color:#cc6666">����</p>';
}
echo '</td>
        </tr>
    ';
}
echo '
</table>
<div class="pagelink">'.$this->_tpl_vars['url_jumppage'].'</div>

';
?>