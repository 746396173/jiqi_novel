<table cellpadding="0" cellspacing="0" class="grid">
			<tr> 
			  <th>��Ա��Ȩ�ޱ�ʶ��</th>
			  <td><input type="text" name="setting[rolepriv]" value="<?=$rolepriv?>" size="15" readonly> </td>
			</tr>
			<tr> 
			  <th>ȫѡ<input boxid='defaultvalue' type='checkbox' onclick="checkall('defaultvalue')" ><br><strong>Ĭ��ֵ��</strong></th>
			  <td><?=$group?></td>
			</tr>
		   </table>
			<tbody id="setcols" style="display:block">
				<tr> 
				  <th>�ֶ�����</th>
				  <td>
				  <select name="setting[fieldtype]">
				  <option value="CHAR">�����ַ� CHAR</option>
				  <option value="VARCHAR">�䳤�ַ� VARCHAR</option>
				  </select>
				  </td>
				</tr>
			</tbody>
		</table>
<script language="javascript">
$("select[name='setting[fieldtype]']").val(["<?=$fieldtype?>"]);
<?php if($page_action=='add'){?>$('#minlength').val(0);$('#maxlength').val(255);<? } ?>
</script>