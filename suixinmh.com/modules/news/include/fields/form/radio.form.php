<table cellpadding="0" cellspacing="0" class="grid">
<tr> 
	<th>ѡ���б�</th>
	<td><textarea name="setting[items]" rows="2" cols="20" id="items" style="height:100px;width:200px;"><?=$items?></textarea></td>
</tr>
<tr> 
	<th>Ĭ��ֵ</th>
	<td><input type="text" name="setting[defaultvalue]" size="40" value="<?=$defaultvalue?>"></td>
</tr>
			<tbody id="setcols" style="display:block">
				<tr> 
				  <th>�ֶ�����</th>
				  <td>
				  <select name="setting[fieldtype]">
				  <option value="CHAR">�����ַ� CHAR</option>
				  <option value="VARCHAR">�䳤�ַ� VARCHAR</option>
				  <option value="TINYINT">���� TINYINT(3)</option>
				  <option value="SMALLINT">���� SMALLINT(5)</option>
				  <option value="MEDIUMINT">���� MEDIUMINT(8)</option>
				  <option value="INT">���� INT(10)</option>
				  </select>
				  </td>
				</tr>
			</tbody>
		</table>
<script language="javascript">
$("select[name='setting[fieldtype]']").val(["<?=$fieldtype?>"]);
<?php if($page_action=='add'){?>$('#minlength').val(0);$('#maxlength').val(20);<? } ?>
</script>