<?php
echo '<link rel="stylesheet" type="text/css" href="'.$this->_tpl_vars['jieqi_local_url'].'/templates/admin/style/mod_task_admin.css"/>
<script type="text/javascript">
	var addFormUrl = "'.$this->_tpl_vars['adminprefix'].'&method=addNewTask";
	var editFormUrl = "'.$this->_tpl_vars['adminprefix'].'&method=editOneTask";
	var delFormUrl = "'.$this->_tpl_vars['adminprefix'].'&method=delOneTask";
	var typeUrl = "'.$this->_tpl_vars['adminprefix'].'&method=getTaskTypeRule";
	var showOneUrl = "'.$this->_tpl_vars['adminprefix'].'&method=showOneTask";
</script>
<table align="center" cellpadding="2" cellspacing="1" class="grid" width="100%">
  <caption>�������</caption>
  <tr>
    <td><a href=\'javascript:void(0)\' id="add_task"><font color="red">�������</font></a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="1" class="grid" width="100%">
    <caption>�����б�</caption>
    <tr>
    	<th width="4%">����ID</th>
        <th width="15%">��������</th>
        <th width="15%">��������</th>
        <th width="35%">��������</th>
		<th width="15%">����ʱ��</th>
		<th width="6">��ʾ״̬</th>
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
    		<tr>
    			<td align="center" width="4%">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['taskid'].'</td>
    			<td align="center" width="15%">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['taskname'].'</td>
    			<td align="center" width="15%">'.$this->_tpl_vars['taskTypes'][$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['type']].'</td>
    			<td align="left" width="35%" style="padding-left: 5px;">'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['description'].'</td>
    			<td align="center" width="15%">'.date('Y-m-d H:i:s',$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['createtime']).'</td>
    			<td align="center" width="6%">';
if($this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['isshow']==1){
echo '<span class="blue">��ʾ</span>';
}else{
echo '<span class="red">����</span>';
}
echo '</td>
    			<td align="center" width="10%" data-id="'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['taskid'].'" data-type="'.$this->_tpl_vars['lists'][$this->_tpl_vars['i']['key']]['type'].'"><a class="J_edit_task" href="javascript:;">�༭</a>|<a href="javascript:;" class="J_del_task">ɾ��</a></td>
    		</tr>
    ';
}
echo '  
</table>																																																																																																																																																																																																																																																																																													
<div class="pagelink">'.$this->_tpl_vars['url_jumppage'].'</div>
<!--add a new task form-->
<div id="J_add_task" style="display:none; position:fix;">
	<form name="task_from" id="J_add_form" action="javascript:;">
		<table class="add_task_box grid">
			<tr>
				<th class="td_title">��������</th>
				<td class="td_contents"><input class="text" style="width: 200px" type="text" name="taskname" /></td>
				<td class="td_span"><span>*�������ó���10����</span></td>
			</tr>
			<tr>
				<th class="td_title">��������</th>
				<td class="td_contents"><textarea class="textarea" name="description" cols="40" rows="10"></textarea></td>
				<td class="td_span"><span>*�������ó���300����</span></td>
			</tr>
			<tr>
				<th class="td_title">��������</th>
				<td class="td_contents">
					<select id="J_task_type" name="type">
						<option value="0">��ѡ����������...</option>
						';
if (empty($this->_tpl_vars['taskTypes'])) $this->_tpl_vars['taskTypes'] = array();
elseif (!is_array($this->_tpl_vars['taskTypes'])) $this->_tpl_vars['taskTypes'] = (array)$this->_tpl_vars['taskTypes'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['taskTypes']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['taskTypes']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['taskTypes']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['taskTypes']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['taskTypes']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
							<option value="'.$this->_tpl_vars['i']['key'].'">'.$this->_tpl_vars['taskTypes'][$this->_tpl_vars['i']['key']].'</option>
						';
}
echo '
					</select>
				</td>
				<td class="td_span"><span></span></td>
			</tr>
			<tr>
				<th class="td_title">ǰ̨�Ƿ���ʾ</th>
				<td class="td_contents"><input type="radio" name="isshow" value="1" checked="checked"/>��ʾ <input type="radio" name="isshow" value="0"/>����ʾ</td>
				<td class="td_span"><span></span></td>
			</tr>
			<tr>
				<td class="td_title">
					<input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
					<input type="hidden" name="taskid" value="" />
				</td>
				<td class="td_contents"><a href="javascript:;" id="J_task_submit" class="button" data-url="">�ύ</a></td>
				<td class="td_span"><span></span></td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_local_url'].'/scripts/mod.task.admin.js"></script>
';
?>