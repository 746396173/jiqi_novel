<table cellpadding="0" cellspacing="0" class="grid">
			<tr> 
			  <th>�༭����ʽ��</th>
			  <td><input type="radio" name="setting[toolbar]" value="basic"> ����� <input type="radio" name="setting[toolbar]" value="standard"> ��׼�� <input type="radio" name="setting[toolbar]" value="full"> ȫ����</td>
			</tr>
			<tr> 
			  <th>�༭����С��</th>
			  <td>�� <input type="text" name="setting[width]" value="<?=$width?>" size="4"> px �� <input type="text" name="setting[height]" value="<?=$height?>" size="4"> px</td>
			</tr>
			<tr> 
			  <th>Ĭ��ֵ��</th>
			  <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:100px;width:250px;"><?=$defaultvalue?></textarea></td>
			</tr>
			<tr> 
			  <th>��ҳ��Ŧ��</th>
			  <td><input type="radio" name="setting[openpagetag]" value="1"> �� <input type="radio" name="setting[openpagetag]" value="0"> �ر�</td>
			</tr>
			<tr> 
			  <th>���ݴ洢��ʽ��</th>
			  <td><input type="radio" name="setting[storage]" value="database" checked> ���ݿ�洢<!-- <input type="radio" name="setting[storage]" value="file"> �ı��洢--></td>
			</tr>
			<tr> 
			  <th>�Ƿ���������ͼ��</th>
			  <td><select class="select" size="1" name="setting[thumb_enable]" id="thumb_enable">
<option value="-1">ϵͳĬ��</option>
<option value="0">����������ͼ</option>
<option value="1">��������ͼ</option>
</select> ����ͼ��С <input name="setting[thumb_width]" type="text" id="thumb_width" value="<?=$thumb_width?>" size="5" maxlength="5"> X <input name="setting[thumb_height]" type="text" id="thumb_height" value="<?=$thumb_height?>" size="5" maxlength="5"> px  <p><span style="color:#ff0000">�Ա��ֶ��е�ͼƬ�ϴ��Ƿ�������ͼ����[�����ý�������Ŀ��<a href="/admin/configs.php?mod=news#catorder3">��������</a>�������]</span></td>
			</tr>
			<tr> 
			  <th>�Ƿ�����ˮӡ��</th>
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
			<tr> 
			  <th>�Ƿ������վ�����ӣ�</th>
			<td><input type="radio" name="setting[enablereplaceurls]" value="1"> �� <input type="radio" name="setting[enablereplaceurls]" value="0"> �� <p><span style="color:#ff0000">���������еķǱ�վ������</span></td>
			</tr>
			<tr> 
			  <th>�Ƿ񱣴�Զ��ͼƬ��</th>
			<td><input type="radio" name="setting[enablesaveimage]" value="1"> �� <input type="radio" name="setting[enablesaveimage]" value="0"> �� <p><span style="color:#ff0000">���������е�Զ��ͼƬ��Դ���Զ����浽���ط�����</span></td>
			</tr>
			<tr> 
			  <th>�Ƿ񱣴�Զ��Flash��</th>
			<td><input type="radio" name="setting[enablesaveflash]" value="1"> �� <input type="radio" name="setting[enablesaveflash]" value="0"> �� <p><span style="color:#ff0000">���������е�Flash��Դ ���Զ����浽���ط�����</span></td>
			</tr>
			<tr>
			<th>��������Զ���ļ���</th>
			<td>�Ƿ�����<input type="checkbox" name="setting[enablesavefile]" value="1">  �ļ���׺��ʽ:<input type="text" name="setting[savefileext]" value="<?=$savefileext?>">
			  <span style="color:#ff0000">ֻ������������ʾ��ʵ��ַ���ļ����ļ����˹���</span></td>
		  </tr>
			<tr>
			<th>���õ�HTML��ǩ��</th>
			<td><input type="text" name="setting[forbidwords]" value='<?=$forbidwords?>' size='60' maxlength='200'><br />
			  <span style="color:#ff0000">���������ֶ��еĲ���HTML��ǩ����ֹ��ҳ���Ρ������ǩ��"|"�ָ������磺script|div|iframe</span></td>
		  </tr>
		</table>
<script language="javascript">
$("input[name='setting[toolbar]']").val(["<?=$toolbar?>"]);
$("input[name='setting[openpagetag]']").val(["<?=$openpagetag?>"]);
$("select[name='setting[thumb_enable]']").val(["<?=$thumb_enable?>"]);
$("select[name='setting[attachwater]']").val(["<?=$attachwater?>"]);
$("input[name='setting[enablereplaceurls]']").val(["<?=$enablereplaceurls?>"]);
$("input[name='setting[enablesaveimage]']").val(["<?=$enablesaveimage?>"]);
$("input[name='setting[enablesaveflash]']").val(["<?=$enablesaveflash?>"]);
<?php if($enablesavefile>0){?>$("input[name='setting[enablesavefile]']").attr('checked','checked');<? } ?>
<?php if($page_action=='add'){?>$('#minlength').val(0);$('#maxlength').val('');<? } ?>
</script>