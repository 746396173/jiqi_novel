<DIV class="ManagerForm" id="FormDiv">
<div class="subManager">
	<FIELDSET>
	<LEGEND style="BACKGROUND: url(/modules/news/images/icon.gif) no-repeat 6px 50%; border-color:#FFFFFF; padding-left:25px;">��̬�����б�</LEGEND>
		<table align="center" cellpadding="0" cellspacing="1" class="grid" width="98%" style="margin-bottom:5px;">
	<tr> 
		<th width='15%'>������ʾ��������</th>
		<td><input type="text" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][blocknum]" value="<?=$set['blocknum']?>" size="7"> ��ʾ�����ջ�Ϊ0���ʾ����ȡ</td>
	</tr>
	<tr> 
		<th>�б�ÿҳ��������</th>
		<td><input type="text" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][pagesize]" value="<?=$set['pagesize']?>" size="7"> ��ʾ�����ջ�Ϊ0���ʾ����ȡ</td>
	</tr>
	<tr> 
		<th>�б�ҳ������ҳ��</th>
		<td><input type="text" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][maxpage]" value="<?=$set['maxpage']?>" size="7"> <font color="red">���ù����Ӱ�����������</font></td>
	</tr>
	<tr> 
		<th>�б�ҳģ��</th>
		<td><input type="text" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][listtemplate]" value="<?=$set['listtemplate']?>" size="25"></td>
	</tr>
	<tr> 
		<th>�����ļ�URL����</th>
		<td><input type="text" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][urlrule]" value="<?=$set['urlrule']?>" size="25"></td>
	</tr>
	<tr> <th colspan=2 style="text-align:center; font-size:14">�����ֶ�</th></tr>
	<tr> 
		<th>Ƶ ����<input type="hidden" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][fields][modelid][name]" value="Ƶ ��"></th>
		<td><select name="<?=$this->fieldpre?>[<?php echo $this->field;?>][fields][modelid][where]">
<option value=""></option><?php foreach($_SGLOBAL['model'] as $v){?>
<option value="<?php echo $v['modelid'];?>" <?php if($set['fields']['modelid']['where']==$v['modelid']) echo 'selected';?>><?php echo $v['name'];?></option><?php } ?>
</select> </td>
	</tr>
	<tr> 
		<th>�� Ŀ��<input type="hidden" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][fields][catid][name]" value="�� Ŀ"></th>
		<td><input type="text" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][fields][catid][where]" value="<?=$set['fields']['catid']['where']?>" size="25"> <font color="red">��д��Ŀ���</font></td>
	</tr>
	<tr> 
		<th>�� �⣺<input type="hidden" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][fields][title][name]" value="�� ��"></th>
		<td><input type="text" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][fields][title][where]" value="<?=$set['fields']['title']['where']?>" size="25"> </td>
	</tr>
	<tr> 
		<th>�ؼ��ʣ�<input type="hidden" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][fields][keywords][name]" value="�ؼ���"></th>
		<td><input type="text" name="<?=$this->fieldpre?>[<?php echo $this->field;?>][fields][keywords][where]" value="<?=$set['fields']['keywords']['where']?>" size="25"> </td>
	</tr>	
	</table>
	</FIELDSET> 
	</div>
</DIV>
