<?php
echo '<style>
.layer_notice{float:left; height:75px; width:170px;  overflow:hidden; display:none;  background:#78BA32; padding:10px; border:1px solid #628C1C;}
.d6{ width:600px; height:auto; margin:0 auto;}
.d6 table{ background:#fff; border-collapse:collapse;table-layout: fixed}
.d6 table tr:hover{ background:#FC9}
.d6 table th{ color:#333; background:#f8f8f8;}
.d6 table th,table td{ height:30px; line-height:30px; padding:0 10px; white-space:nowrap; overflow:hidden;word-break: break-all}
.sort,.author,.money,.numb{ width:15%;}
.sort{ padding:0;}
.name,.date{ width:20%; height:30px; white-space:nowrap; overflow:hidden;text-overflow: ellipsis;}
.date{ text-align:right; color:#999;}
.layer_notice{float:left; height:75px; width:170px;  overflow:hidden; display:none;  background:#78BA32; padding:10px; border:1px solid #628C1C;}
</style>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/calendar/WdatePicker.js"></script>
<script type="text/javascript">
	var addFormUrl = "'.$this->_tpl_vars['adminprefix'].'&method=addQuestion";
	var editFormUrl = "'.$this->_tpl_vars['adminprefix'].'&method=editQuestion";
	var delFormUrl = "'.$this->_tpl_vars['adminprefix'].'&method=delOneQuestion";
	var showOneUrl = "'.$this->_tpl_vars['adminprefix'].'&method=showOneQuestion";
	var checkUrl = "'.$this->_tpl_vars['adminprefix'].'&method=getArticleName";
</script>
<form name="frmsearch" method="post" action="'.$this->_tpl_vars['adminprefix'].'&method=main">
<table class="grid" width="100%" align="center">
    <tr>
        <td class="odd">�ؼ��֣�
            <input name="keyword" type="text" id="keyword" value="'.$this->_tpl_vars['_REQUEST']['keyword'].'" class="text" size="15" maxlength="50">&nbsp;<input type="radio" name="searchkey" value="question" ';
if($this->_tpl_vars['_REQUEST']['searchkey']=='question' || !isset($this->_tpl_vars['_REQUEST']['searchkey'])){
echo 'checked="checked"';
}
echo ' />&nbsp;��������&nbsp;<input type="radio" name="searchkey" value="articlename" ';
if($this->_tpl_vars['_REQUEST']['searchkey']=='articlename'){
echo 'checked="checked"';
}
echo ' />&nbsp;�鼮����&nbsp;<input type="radio" name="searchkey" value="aid" ';
if($this->_tpl_vars['_REQUEST']['aid']=='articleid'){
echo 'checked="checked"';
}
echo ' />&nbsp;�鼮ID
            &nbsp;&nbsp;&nbsp;<input type="submit" class="button" style="cursor:pointer" value="�� ��">
            &nbsp;&nbsp;&nbsp;<a href="'.$this->_tpl_vars['adminprefix'].'" class="button" >����ȫ��</a>
        </td>
    </tr>
</table>
</form>
<br />
<table class="grid" width="100%" align="center">
    <caption>�ʴ�����б�(��ǰ����'.$this->_tpl_vars['qbcount'].'����Ŀ)&nbsp;<a href="javascript:;" data-act="add_question">[+����һ������]</a></caption>
    <tr align="center">
        <th width="5%">��ĿID</th>
        <th width="35%">��������</th>
        <th width="10%">Ԥ��</th>
        <th width="20%">�����鼮</th>
        <th width="15%">����ʱ��</th>
        <th width="15%">����</th>
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
        <tr data-id="'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['qid'].'">
            <td align="center">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['qid'].'</td>
            <td align="left">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['question'].'</td>
            <td align="center"><a href="javascript:;" data-act="showone">���Ԥ��</a></td>
            <td align="center">��'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['articlename'].'��</td>
            <td align="center">'.date('Y-m-d H:i:s',$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['createtime']).'</td>
            <td align="center"><a href="javascript:;" data-act="edit">�༭</a>&nbsp;|&nbsp;<a href="javascript:;" data-act="del">ɾ��</a></td>
        </tr>
    ';
}
echo '
</table>
<div class="pagelink">'.$this->_tpl_vars['url_jumppage'].'</div>
<!--add a new task form-->
<div id="J_add_question" style="display:none; position:fix;">
	<form name="question_from" id="J_add_form" action="javascript:;">
		<table class="add_task_box grid">
			<tr>
				<th class="td_title">��������</th>
				<td class="td_contents"><textarea class="textarea" name="question" cols="40" rows="3"></textarea></td>
				<td class="td_span"><span>*�������ó���60����</span></td>
			</tr>
			<!--<tr>
				<th class="td_title">ѡ������</th>
				<td class="td_contents">
					<select data-act="questionnumber_change" name="questionnumber" style="width: 100px">
						<option value="2" selected="selected">2��</option>
						<option value="3">3��</option>
						<option value="4">4��</option>
					</select>
				</td>
				<td class="td_span"><span></span></td>
			</tr>-->
			<tr data-option="1">
				<th class="td_title">ѡ��A</th>
				<td class="td_contents">
					<input class="text" style="width: 200px" type="text" name="options[1]"/>&nbsp;&nbsp;<input type="radio" name="rightoption" value="1" /></td>
				<td class="td_span"><span>*�������ó���60����</span></td>
			</tr>
			<tr data-option="2">
				<th class="td_title">ѡ��B</th>
				<td class="td_contents">
					<input class="text" style="width: 200px" type="text" name="options[2]"/>&nbsp;&nbsp;<input type="radio" name="rightoption" value="2" /></td>
				<td class="td_span"><span></span></td>
			</tr>
			<tr data-option="3">
				<th class="td_title">ѡ��C</th>
				<td class="td_contents">
					<input class="text" style="width: 200px" type="text" name="options[3]"/>&nbsp;&nbsp;<input type="radio" name="rightoption" value="3" /></td>
				<td class="td_span"><span></span></td>
			</tr>
			<tr data-option="4">
				<th class="td_title">ѡ��D</th>
				<td class="td_contents">
					<input class="text" style="width: 200px" type="text" name="options[4]"/>&nbsp;&nbsp;<input type="radio" name="rightoption" value="4" /></td>
				<td class="td_span"><span></span></td>
			</tr>
			<tr>
				<th class="td_title">�����鼮ID</th>
				<td class="td_contents"><input data-act="articleid_change"  style="width: 200px" class="text" name="aid" width="40%"/></td>
				<td class="td_span"><span></span></td>
			</tr>
			<tr>
				<th class="td_title">�����鼮</th>
				<td class="td_contents"><p  style="width: 80px" data-p="articlename"></p></td>
				<td class="td_span"><span></span></td>
			</tr>
			<tr>
				<td class="td_title">
					<input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
					<input type="hidden" name="qid" value="" />
				</td>
				<td class="td_contents"><a href="javascript:;" id="J_question_submit" class="button" data-url="">�ύ</a></td>
				<td class="td_span"><span></span></td>
			</tr>
		</table>
	</form>
</div>
<!--add a new task form:end-->
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_local_url'].'/scripts/mod.task.admin.js"></script>';
?>