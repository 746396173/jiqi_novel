<tr valign="middle" align="left">
     <th style="cursor:hand" onClick="ShowLabel('f_<?php echo $field;?>');" align="left"><?php if($star) echo '<font color="red">*</font>';?>
		 <img src="<?php echo $_SGLOBAL['news']['url'];?>/images/<?php if($data['adopt']=='' && !$star) echo 'close'; else echo 'open';?>.gif" width="18" height="18" id="f_<?php echo $field;?>img"><strong  id='rule1name'><?php echo $name;?></strong>: [�����/���ر�ǩ]
	  </th>
     <th><?php echo $name;?></th>
 </tr>
<tr id="f_<?php echo $field;?>" style="display:<?php if($data['adopt']=='' && !$star) echo 'none'?>">
    <th>
	<?php if($star) echo '<font color="red">*</font>';?><font color=blue>����<?php echo $name;?>�ɼ�����</font>
	<br /><label><input name="setting[fields][<?php echo $field;?>][add_introduce]" type="checkbox"  value="1"<?php if($data['add_introduce']>0 || $page_action == 'add') echo ' checked';?>>�Ƿ��ȡ����</label><br><input type="text" name="setting[fields][<?php echo $field;?>][introcude_length]" value="<?php if($data['introcude_length']>0) echo $data['introcude_length']; else echo '200';?>" size="3">�ַ�������ժҪ<br/><label><input type='checkbox' name='setting[fields][<?php echo $field;?>][auto_thumb]' value="1"<?php if($data['auto_thumb']>0 || $page_action == 'add') echo ' checked';?>>�Ƿ��ȡ���ݵ�</label><br><input type="text" name="setting[fields][<?php echo $field;?>][auto_thumb_no]" value="<?php if($data['auto_thumb_no']>0) echo $data['auto_thumb_no']; else echo '1';?>" size="2" class="">��ͼƬ��Ϊ����ͼƬ
	</th>
    <td><textarea name="setting[fields][<?php echo $field;?>][adopt]" id="f_<?php echo $field;?>" rows="4" cols="60" <?php if($star>0){?> require="true" datatype="limit" msg="����д����<?php echo $name;?>�ɼ�����"<?php }?>><?php echo $data['adopt'];?></textarea>
	<br><font color=blue>(���·�ҳ��һҳ�ɼ�����)</font><br>
	<textarea name="setting[fields][<?php echo $field;?>][nextpage]" id="f_<?php echo $field;?>" rows="4" cols="60"><?php echo $data['nextpage'];?></textarea>
	</td>
</tr>
<tr id="f_<?php echo $field;?>trim" style="display:<?php if($data['adopt']=='' && !$star) echo 'none'?>">
    <th><font color=blue>����<?php echo $name;?>��Ϣ�滻ɾ��</font><br>�ɶ�����˹���ÿ���������һ�У���ʹ���滻��ǩ���磺&lt;div>!&lt;/div>|�滻����</th>
    <td><textarea name="setting[fields][<?php echo $field;?>][filter]" id="f_<?php echo $field;?>filter" rows="4" cols="60"><?php echo $data['filter'];?></textarea></td>
</tr>