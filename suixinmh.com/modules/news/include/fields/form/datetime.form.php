<table cellpadding="0" cellspacing="0" class="grid" bgcolor="#ffffff">
			<tr> 
			  <th>ʱ���ʽ��</th>
			  <td>
			  <select name="setting[format]">
			  <option value="Y-m-d H:i:s"><?=date('Y-m-d H:i:s')?></option>
			  <option value="Y-m-d H:i"><?=date('Y-m-d H:i')?></option>
			  <option value="Y-m-d"><?=date('Y-m-d')?></option>
			  <option value="m-d"><?=date('m-d')?></option>
			  </select>
			  </td>
			</tr>
			<tr> 
			  <th>Ĭ��ֵ��</th>
			  <td>
			  <input type="radio" name="setting[defaulttype]" value="0"/>��<br />
			  <input type="radio" name="setting[defaulttype]" value="1"/>��ǰʱ��<br />
			  <input type="radio" name="setting[defaulttype]" value="2"/>ָ��ʱ�䣺<input type="text" name="setting[defaultvalue]" value="<?=$defaultvalue?>" size="22"></td>
			</tr>
		</table>
<script language="javascript">
$("select[name='setting[format]']").val(["<?=$format?>"]);
$("input[name='setting[defaulttype]']").val(["<?=$defaulttype?>"]);
</script>