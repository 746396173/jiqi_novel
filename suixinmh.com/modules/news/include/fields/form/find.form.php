<table cellpadding="0" cellspacing="0" class="grid">
	<tr> 
		<th>������ʾ��������</th>
		<td><input type="text" name="setting[blocknum]" value="<?=$blocknum?>" size="7"> ��ʾ�����ջ�Ϊ0���ʾ����ȡ</td>
	</tr>
	<tr> 
		<th>�б�ÿҳ��������</th>
		<td><input type="text" name="setting[pagesize]" value="<?=$pagesize?>" size="7"> ��ʾ�����ջ�Ϊ0���ʾ����ȡ</td>
	</tr>
	<tr> 
		<th>�б�ҳ������ҳ��</th>
		<td><input type="text" name="setting[maxpage]" value="<?=$maxpage?>" size="7"> <font color="red">���ù����Ӱ�����������</font></td>
	</tr>
	<tr> 
		<th>�б�ҳģ��</th>
		<td><input type="text" name="setting[listtemplate]" value="<?=$listtemplate?>" size="25"></td>
	</tr>
	<tr> 
		<th>�����ļ�URL����</th>
		<td><input type="text" name="setting[urlrule]" value="<?=$urlrule?>" size="25"></td>
	</tr>
	<tr> <th colspan=2 style="text-align:center; font-size:14">�����ֶ�</th></tr>
	<tr> 
		<th>Ƶ ����<input type="hidden" name="setting[fields][modelid][name]" value="Ƶ ��"></th>
		<td><select name="setting[fields][modelid][where]" id="setting[fields][modelid][where]">
<option value=""></option><?php foreach($_SGLOBAL['model'] as $v){?>
<option value="<?php echo $v['modelid'];?>"><?php echo $v['name'];?></option><?php } ?>
</select> </td>
	</tr>
	<tr> 
		<th>�� Ŀ��<input type="hidden" name="setting[fields][catid][name]" value="�� Ŀ"></th>
		<td><input type="text" name="setting[fields][catid][where]" value="<?=$this->setting['fields']['catid']['where']?>" size="25"> ��ʽ:<font color="red">��������|ֵ</font></td>
	</tr>
	<tr> 
		<th>�� �⣺<input type="hidden" name="setting[fields][title][name]" value="�� ��"></th>
		<td><input type="text" name="setting[fields][title][where]" value="" size="25"> ��ʽ:<font color="red">��������|ֵ</font></td>
	</tr>
	<tr> 
		<th>�ؼ��ʣ�<input type="hidden" name="setting[fields][keywords][name]" value="�ؼ���"></th>
		<td><input type="text" name="setting[fields][keywords][where]" value="" size="25"> ��ʽ:<font color="red">��������|ֵ</font></td>
	</tr>	
</table>
<script language="javascript">
$("select[name='setting[fields][modelid][where]']").val(["<?=$this->setting['fields']['modelid']['where']?>"]);
<?php if($page_action=='add'){?>$('#minlength').val(0);$('#maxlength').val(255);<? } ?>
</script>