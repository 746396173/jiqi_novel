<table cellpadding="0" cellspacing="0" class="grid">
				<tr> 
				  <th>�ı�������</th>
				  <td><input type="text" name="setting[rows]" value="<?=$rows?>" size="10"></td>
				</tr>
				<tr> 
				  <th>�ı�������</th>
				  <td><input type="text" name="setting[cols]" value="<?=$cols?>" size="10"></td>
				</tr>
				<tr> 
				  <th>Ĭ��ֵ</th>
				  <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:60px;width:250px;"><?=$defaultvalue?></textarea></td>
				</tr>
				<tr> 
				  <th>�Ƿ�����Html</th>
				  <td><input type="radio" name="setting[enablehtml]" id='enablehtml' value="1"> �� <input type="radio" name="setting[enablehtml]" id='enablehtml' value="0"> ��</td>
				</tr>
			</table>
<script language="javascript">
$("input[name='setting[enablehtml]']").val(["<?=$enablehtml?>"]);
</script>