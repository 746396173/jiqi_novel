<table cellpadding="0" cellspacing="0" class="grid">
				<tr> 
				  <th>�Ƿ�����Html</th>
				<td><input type="radio" name="setting[enablehtml]" value="1"> �� <input type="radio" name="setting[enablehtml]" value="0"> ��</td>
				</tr>
			<tr> 
			  <th>�Ƿ񱣴�Զ����Ƶ�ļ���</th>
			<td><input type="radio" name="setting[enablesaveimage]" value="1"> �� <input type="radio" name="setting[enablesaveimage]" value="0"> �� <span style="color:#ff0000">����Զ����Ƶ��Դ���Զ����浽���ط�����!���ļ���ѡ���</span></td>
			</tr>
			<tr> 
			  <th>Ĭ����ʾ���ٸ��ϴ�λ��</th>
			  <td><select class="select" size="1" name="setting[fileformnum]" id="fileformnum">
<option value="1">1��</option>
<option value="2">2��</option>
<option value="3">3��</option>
<option value="4">4��</option>
<option value="5">5��</option>
<option value="6">6��</option>
<option value="7">7��</option>
<option value="8">8��</option>
<option value="9">9��</option>
<option value="10">10��</option>
</select></td>
			</tr>
			<tr> 
			  <th>�����ϴ�����Ƶ��С</th>
			  <td><input type="text" name="setting[maxsize]" value="<?=$maxsize?>" size="7"> KB ��ʾ��1KB=1024Byte��1MB=1024KB *<br />���������������ϴ�����Ϊ<font color="red"><?=ini_get('upload_max_filesize')?></font>���������ֵ��С�ڻ����<font color="red"><?=ini_get('upload_max_filesize')?></font></td>
			</tr>
			<tr> 
			  <th>�����ϴ���Ƶ����</th>
			  <td><input type="text" name="setting[fileextname]" value="<?=$fileextname?>" size="40"></td>
			</tr>
		<tr>
		  <th>��Ƶ������</th>
		  <td><textarea name="setting[servers]" rows="3" cols="60"  style="height:80px;width:400px;"><?=$servers?></textarea></td>
		</tr>
				<tr> 
				  <th>�ϴ���Ƶʱ�Զ����䱸ע</th>
				<td><input type="radio" name="setting[enabledescription]" value="1"> �� <input type="radio" name="setting[enabledescription]" value="0"> ��</td>
				</tr>
		</table>
<script language="javascript">
$("input[name='setting[enablehtml]']").val(["<?=$enablehtml?>"]);
$("select[name='setting[fileformnum]']").val(["<?=$fileformnum?>"]);
$("input[name='setting[enabledescription]']").val(["<?=$enabledescription?>"]);
$("input[name='setting[enablesaveimage]']").val(["<?=$enablesaveimage?>"]);
<?php if($page_action=='add'){?>$('#minlength').val(0);$('#maxlength').val('');<? } ?>
</script>