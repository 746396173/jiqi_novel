<?php
echo '<style>
.layer_notice{float:left; height:75px; width:170px;  overflow:hidden; display:none;  background:#78BA32; padding:10px; border:1px solid #628C1C;}
/*layer_notice li{ height:30px; line-height:30px;}
.layer_notice li a{ display:block; color:#fff;}
.layer_notice li a:hover{ background:#fff; color:#78BA32;}*/
.d6{ width:600px; height:auto; margin:0 auto;}
.d6 table{ background:#fff; border-collapse:collapse;table-layout: fixed}
.d6 table tr:hover{ background:#FC9}
.d6 table th{ color:#333; background:#f8f8f8;}
.d6 table th,table td{ height:30px; line-height:30px; padding:0 10px; white-space:nowrap; overflow:hidden;word-break: break-all}
.sort,.author,.money,.numb{ width:15%;}
.sort{ padding:0;}
.name,.date{ width:20%; height:30px; white-space:nowrap; overflow:hidden;text-overflow: ellipsis;}
.date{ text-align:right; color:#999;}
</style>
<form method="post" action="'.$this->_tpl_vars['adminprefix'].'">
<table class="grid" width="100%" align="center">
    <tr>
        <td class="odd">
            �ؼ��֣�<input name="keyword" type="text" value="'.$this->_tpl_vars['_REQUEST']['keyword'].'" class="text" size="15" maxlength="50">&nbsp;<input type="radio" name="searchkey" value="name" checked="checked" />&nbsp;�������&nbsp;<input type="radio" name="searchkey" value="articleid" />&nbsp;���±��
            &nbsp;&nbsp;����Ƶ����
            <select name="siteid" >
            	<option value="-1">-ѡ��Ƶ��-</option>
            	';
if (empty($this->_tpl_vars['channel'])) $this->_tpl_vars['channel'] = array();
elseif (!is_array($this->_tpl_vars['channel'])) $this->_tpl_vars['channel'] = (array)$this->_tpl_vars['channel'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['channel']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['channel']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['channel']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['channel']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['channel']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
            		<option value="'.$this->_tpl_vars['i']['key'].'" ';
if($this->_tpl_vars['siteid'] != "" && $this->_tpl_vars['siteid']==$this->_tpl_vars['i']['key']){
echo 'selected';
}
echo '>'.$this->_tpl_vars['channel'][$this->_tpl_vars['i']['key']]['name'].'</option>
            	';
}
echo '
            </select>
            &nbsp;&nbsp;����״̬��
            <select name="showbookpackage" >
                <option value="0" ';
if($this->_tpl_vars['_REQUEST']['showbookpackage']==0){
echo 'selected="selected"';
}
echo '>ȫ�����</option>
                <option value="1" ';
if($this->_tpl_vars['_REQUEST']['showbookpackage']==1){
echo 'selected="selected"';
}
echo '>�����������</option>
                <option value="2" ';
if($this->_tpl_vars['_REQUEST']['showbookpackage']==2){
echo 'selected="selected"';
}
echo '>��ͣ�������</option>
            </select>
            <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" /><input type="submit" name="dosubmit" class="button" value="�� ��">  
        </td>
    </tr>
</table>
</form>
<br />
<form action="'.$this->_tpl_vars['url_batchdel'].'" method="post" name="checkform" id="checkform" onSubmit="javascript:if(confirm(\'ȷʵҪ����ɾ������ô��\')) return true; else return false;">
<table class="grid" width="100%" align="center">
    <caption>��������ϼ�'.$this->_tpl_vars['bpcount'].'�������&nbsp;<a href="'.$this->_tpl_vars['adminprefix'].'&method=add_bp">[+��������]</a></caption>
    <tr align="center">
        <th width="5%">������</th>
        <th width="17%">�������</th>
        <th width="8%">���</th>
        <th width="8%">���¼۸�</th>
        <th width="10%">����Ƶ��</th>
        <th width="10%">�������</th>
        <th width="6%">����״̬</th>
        <!--<th width="6%">�ϼ�״̬</th>-->
        <th width="12%">����ʱ��</th>
        <th width="12%">��ͣ����ʱ��</th>
        <th width="6%">״̬����</th>
    </tr>
  <!--'.$this->_tpl_vars['adminprefix'].'-->
  ';
if (empty($this->_tpl_vars['bplist'])) $this->_tpl_vars['bplist'] = array();
elseif (!is_array($this->_tpl_vars['bplist'])) $this->_tpl_vars['bplist'] = (array)$this->_tpl_vars['bplist'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['bplist']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['bplist']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['bplist']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['bplist']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['bplist']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr bpid="'.$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['id'].'">
    <td class="odd" align="center">'.$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['id'].'</td>
    <td class="even" align="center">'.$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['name'].'</td>
    <td class="odd" align="center">'.$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['booknumber'].'����</td>
    <td class="even" align="center">'.$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['price'];
if($this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['pricetype']==1){
echo '�麣��';
}elseif($this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['pricetype']==2){
echo '��Ԫ';
}
echo '</td>
    <td class="odd" align="center">'.$this->_tpl_vars['channel'][$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['siteid']]['name'].'</td>
    <td class="even" align="center"><a class="j_bpdetails_jump" href="javascript:;" bpname="'.$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['name'].'">[��ʾ����]</a></td>
    <td class="odd" align="center">';
if($this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['showbookpackage']==1){
echo '��������';
}else{
echo '<p style="color:#aaaaaa">��ͣ����</p>';
}
echo '</td>
    <!--<td class="even" align="center">';
if($this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['putaway']==1){
echo '����';
}else{
echo '<p style="color:#aaaaaa">�¼�</p>';
}
echo '</td>-->
    <td class="odd" align="center">'.date('Y-m-d H:i:s',$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['createtime']).'</td>
    <td class="even" align="center">';
if($this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['updatetime']<=$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['createtime']){
echo '����';
}else{
echo date('Y-m-d H:i:s',$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['updatetime']);
}
echo '</td>
    <td class="odd" align="center"><a href="'.$this->_tpl_vars['adminprefix'].'&method=edit_bp&bpid='.$this->_tpl_vars['bplist'][$this->_tpl_vars['i']['key']]['id'].'" title="�༭"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/editor.gif" border="0" /></a>&nbsp;&nbsp;<a class="j_bpdel_sub" href="javascript:;"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/delete_on.gif" border="0" /></a></td>
  </tr>
  ';
}
echo '
<!--  <tr>
    <td width="3%" class="odd" align="center"><input type="checkbox" id="checkall" name="checkall" value="checkall" onclick="javascript: for (var i=0;i<this.form.elements.length;i++){ if (this.form.elements[i].name != \'checkkall\') this.form.elements[i].checked = form.checkall.checked; }"></td>
    <td colspan="6" align="left" class="odd"><input type="submit" name="Submit" value="����ɾ��" class="button"><input name="batchdel" type="hidden" value="1"><input name="url_jump" type="hidden" value="'.$this->_tpl_vars['url_jump'].'"><input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" /><strong></strong></td>
  </tr>-->
</table>
</form>
<div class="pagelink">'.$this->_tpl_vars['url_jumppage'].'</div>
<!--<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_local_url'].'/scripts/jquery-1.8.3.min.js"></script>-->
<script language="javascript" type="text/javascript">
$(function(){
    var bpdetails = $(".j_bpdetails_jump");
    bpdetails.on("click", function(){
        var bpid = $(this).parent().parent("tr").attr("bpid");
        var bpname = $(this).attr("bpname");
        var jumpurl = "'.$this->_tpl_vars['adminprefix'].'&method=show_on_bp";
        $.ajax({
            type:"POST",
            url:jumpurl,
            data:{\'id\':bpid},
            dataType:"json",
            success:function(data){
                var htmls = "";
                if (data.status == \'200\') {
                    htmls += \'<div class="d6"><table width="100%" border="1" bordercolor="#eeeeee" cellspacing="0" cellpadding="0"><tr><th width="15%" align="center" valign="middle" scope="col" class="sort">���</th><th width="20%" align="left" valign="middle" scope="col" class="name">��������</th><th width="15%" align="left" valign="middle" scope="col" class="author">����</th><th width="15%" align="left" valign="middle" scope="col" class="money">ԭ�ۼ�</th><th width="15%" align="left" valign="middle" scope="col" class="numb">����</th><th width="20%" align="left" valign="middle" scope="col" class="date">�������ʱ��</th></tr>\';
                    $.each(data.list, function(i, n){
                        htmls += \'<tr><td width="15%" align="center" valign="middle" class="sort">\'+n.sortname+\'</td>\';
                        htmls += \'<td width="20%" align="left" valign="middle" class="name">\'+n.articlename+\'</td>\';
                        htmls += \'<td width="15%" align="left" valign="middle" class="author">\'+n.author+\'</td>\';
                        htmls += \'<td width="15%" align="left" valign="middle" class="money">\'+n.saleprice+\'�麣��</td>\';
                        htmls += \'<td width="15%" align="left" valign="middle" class="numb">\'+n.size+\'</td>\';
                        htmls += \'<td width="20%" align="left" valign="middle" class="date">\'+n.createtime+\'</td>\';
                    });
                    htmls += "</table></div>";
//                    alert(htmls);
                } else {
                    htmls = "<div style=\'width:400px\'>û������...</div>";
                }
                $.layer({
                    type:1,
//                    shade:[0.8, \'#cccccc\'],
                    area:["auto", "auto"],
                    title:bpname,
//                    border:[0],
                    page:{
                        html:htmls
                    }
                });
            }
        });
    })
    $(".j_bpdel_sub").on("click", function(){
        var bpid = $(this).parent().parent("tr").attr("bpid");
        var jumpurl = "'.$this->_tpl_vars['adminprefix'].'&method=del_on_bp";
//        alert(111);
        $.layer({
            area:[\'auto\', \'auto\'],
            dialog:{
                msg:\'�����ɾ�����޷��ָ�����ȷ�ϼ���ɾ����\',
                btns:2,
                type:3,
                btn:[\'ɾ��\', \'ȡ��\'],
                yes:function() {
                    $.ajax({
                        type:"POST",
                        url:jumpurl,
                        data:{\'id\':bpid},
                        dataType:"json",
                        success:function(data) {
                            if (data.status==\'200\') {
                                //
                                layer.msg(\'ɾ���ɹ�\', 3, 1);
                                location.reload();
                            } else if (data.status==\'300\') {
                                // 
                                layer.msg(data.msg, 3, 3);
                            } else {
                                layer.msg(\'���粻���������Ժ�����\', 3, 3);
                            }
                        }
                    })
                }
            }
        })
    })
})
</script>';
?>