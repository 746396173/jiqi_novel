<table cellpadding="0" cellspacing="0" class="grid" bgcolor="#ffffff">
			<tr> 
			  <th>ȡֵ��Χ</th>
			<td><input type="text" name="setting[minnumber]" value="<?=$minnumber?>" size="5"> - <input type="text" name="setting[maxnumber]" value="<?=$maxnumber?>" size="5"></td>
			</tr>
			<tr> 
			  <th>С��λ����</th>
			  <td>
			  <select name="setting[decimaldigits]">
			  <option value="-1">�Զ�</option>
			  <option value="0">0</option>
			  <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			  <option value="5">5</option>
			  </select>
			</td>
			</tr>
			<tr> 
			  <th>Ĭ��ֵ</th>
			  <td><input type="text" name="setting[defaultvalue]" value="<?=$defaultvalue?>" size="40"></td>
			</tr>
</table>
<script language="javascript">
$("select[name='setting[decimaldigits]']").val(["<?=$decimaldigits?>"]);
</script>