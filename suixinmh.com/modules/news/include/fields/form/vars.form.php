<table cellpadding="0" cellspacing="0" class="grid" width='90%'>
				<tr> 
				  <th>����Html��ǩ</th>
				<td><input type="radio" name="setting[enablehtml]" value="1"> �� <input type="radio" name="setting[enablehtml]" value="0"> ��</td>
				</tr>
		<tbody id='var_trs'<?php if(!$vars){?> style='display:none'<?php }?>>
		<tr> <th colspan=2 style="text-align:center; font-size:14">Ĭ�ϱ���</th></tr>
            <?php
			//print_r($vars);
				if(count($vars)>0){ 
				     $i=0;
				     foreach($vars as $k=>$v){
				?>
				<tr id="vars_id<?php echo $i;?>"><th width='15%'><strong><?php echo $k;?></strong></th><td><textarea name='setting[vars][<?php echo $k;?>]' style='width:80%;height:80px'><?php echo $v;?></textarea> <input type='button' onClick="DelTableRow('vars_id<?php echo $i;?>');" value='�Ƴ�'></td></tr>
				<?php
				     $i++;
				    } 
				 }?>
		</tbody>
			<tr> 
			  <th><strong>Ĭ��ֵ</strong><br>
		      ������</th>
			  <td><input type="text" id="var_name" value="֧������" style="height:22px;" onFocus="javascript:if(this.value=='֧������') this.value='';"> 
			  <!--<select class="select" size="1" name="var_type" id="var_type">
				<option value="1">�ı���</option>
				<option value="2">�ı���</option>
			  </select>-->
			<input type="button" id="add_var" value=" ��ӱ��� "></td>
			</tr>
		</table>
<script language="javascript">
var vars_hang = <?php echo count($vars);?>;
$('#add_var').click(
    function(){
	   var name = $("#var_name").val();
	   var result=name.match(/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[\w])*$/);
	   if($("textarea[name='setting[var]["+name+"]']").val()!=undefined){
	       alert('�������������ظ���');
		   $("#var_name").focus();
		   return false;
	   }
	   if(name=='' || !result){
	      alert('���������������֡���ĸ��������ɣ�');
		  $("#var_name").focus();
	   }else{
	       var c = "<tr id=\"vars_id"+vars_hang+"\"><th width='15%'><strong>"+name+"</strong></th><td><textarea name='setting[vars]["+name+"]' style='width:80%;height:80px'></textarea> <input type='button' onClick=\"DelTableRow('vars_id"+vars_hang+"');\" value='�Ƴ�'></td></tr>";
		      $("#var_trs").append(c); 
			  $("#var_trs").show();
			  $("input[type='button']").addClass('button_style');
			  vars_hang++;
	   }
	}
);

$("input[name='setting[enablehtml]']").val(["<?=$enablehtml?>"]);
$("select[name='setting[fileformnum]']").val(["<?=$fileformnum?>"]);
$("input[type='button']").addClass('button_style');
<?php if($page_action=='add'){?>$('#minlength').val(0);$('#maxlength').val('');<? } ?>
</script>