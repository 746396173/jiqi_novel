<table cellpadding="0" cellspacing="0" class="grid">
			<tr> 
			  <th>Ĭ��ģ���б�</th>
			  <td><textarea name="setting[items]" rows="2" cols="20" id="items" style="height:100px;width:280px;"><?=$items?></textarea><br>��ʽ��ģ��·��|ģ������<p><span style="color:#ff0000">Ĭ�Ϸ��� /modules/news/templates/default/ Ŀ¼��</span></td>
			</tr>
			<tr> 
			  <th>�߶�</th>
			  <td><input type="text" name="setting[size]" value="<?=$size?>" size="5"> ��</td>
			</tr>
			<tr> 
			  <th>Ĭ��ֵ</th>
			  <td><input type="text" name="setting[defaultvalue]" size="40" value="<?=$defaultvalue?>"></td>
			</tr>
			<tr> 
				  <th>��ѡ�б���</th>
				  <td><input type="radio" name="setting[multiple]" value="1" onclick="javascript:<?php if($page_action=='add'){?>$('#maxlength').val(255);<? } ?>$('#setcols').hide();"> �� <input type="radio" name="setting[multiple]" value="0" onclick="javascript:<?php if($page_action=='add'){?>$('#maxlength').val(50);<? } ?>$('#setcols').show();"> ��</td>
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
$("input[name='setting[multiple]']").val(["<?=$multiple?>"]);
$("select[name='setting[fieldtype]']").val(["<?=$fieldtype?>"]);
<?php if($page_action=='add'){?>$('#minlength').val(0);$('#maxlength').val(50);<? } ?>
</script>