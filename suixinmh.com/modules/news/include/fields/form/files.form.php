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
				  <td><input type="radio" name="setting[enablehtml]" value="1"> �� <input type="radio" name="setting[enablehtml]" value="0"> ��</td>
				</tr>
<tr> 
			  <th>�����ϴ����ļ���С</th>
			  <td><input type="text" name="setting[maxsize]" value="<?=$maxsize?>" size="5">KB ��ʾ��1KB=1024Byte��1MB=1024KB *</td>
			</tr>
			<tr> 
			  <th>�����ϴ����ļ���չ</th>
			  <td><input type="text" name="setting[fileextname]" value="<?=$fileextname?>" size="40"></td>
			</tr>
			<tr> 
			  <th>ͼƬ�ļ��Ƿ���������ͼ��</th>
			  <td><select class="select" size="1" name="setting[thumb_enable]" id="thumb_enable">
<option value="-1">ϵͳĬ��</option>
<option value="0">����������ͼ</option>
<option value="1">��������ͼ</option>
</select> ����ͼ��С <input name="setting[thumb_width]" type="text" id="thumb_width" value="<?=$thumb_width?>" size="5" maxlength="5"> X <input name="setting[thumb_height]" type="text" id="thumb_height" value="<?=$thumb_height?>" size="5" maxlength="5"> px  <p><span style="color:#ff0000">�Ա��ֶ��е�ͼƬ�ϴ��Ƿ�������ͼ����[�����ý�������Ŀ��<a href="/admin/configs.php?mod=news#catorder3">��������</a>�������]</span></td>
			</tr>
			<tr> 
			  <th>ͼƬ�ļ��Ƿ�����ӡ��</th>
			  <td><select class="select" size="1" name="setting[attachwater]" id="attachwater">
<option value="-1">ϵͳĬ��</option>
<option value="0">����ˮӡ</option>
<option value="1">��������</option>
<option value="2">��������</option>
<option value="3">��������</option>
<option value="4">�в�����</option>
<option value="5">�в�����</option>
<option value="6">�в�����</option>
<option value="7">�ײ�����</option>
<option value="8">�ײ�����</option>
<option value="9">�ײ�����</option>
<option value="10">���λ��</option>
</select> ˮӡͼƬ�ļ� <input type="text" name="setting[attachwimage]" value='<?=$attachwimage?>' size='30' maxlength='100'> <p><span style="color:#ff0000">���� JPG/PNG/GIF ��ʽ��Ĭ��ֻ�����ļ��������� /modules/news/images Ŀ¼��</span></td>
			</tr>
		</table>
<script language="javascript">
$("input[name='setting[enablehtml]']").val(["<?=$enablehtml?>"]);
$("select[name='setting[thumb_enable]']").val(["<?=$thumb_enable?>"]);
$("select[name='setting[attachwater]']").val(["<?=$attachwater?>"]);
<?php if($page_action=='add'){?>$('#minlength').val(0);$('#maxlength').val('');<? } ?>
</script>