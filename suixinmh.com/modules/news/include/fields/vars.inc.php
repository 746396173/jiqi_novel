<DIV class="ManagerForm" id="FormDiv">
<div class="subManager">
	<FIELDSET>
	<LEGEND style="BACKGROUND: url(/modules/news/images/icon.gif) no-repeat 6px 50%; border-color:#FFFFFF; padding-left:25px;">��̬����</LEGEND>
		<table align="center" cellpadding="0" cellspacing="1" class="grid" width="98%" style="margin-bottom:5px;">
		<tbody id='<?php echo $this->field?>_trs'<?php if(!$vars){?> style='display:none'<?php }?>>
            <?php
				if(count($vars)>0){ 
				     $i=0;
				     foreach($vars as $k=>$v){
				?>
			<tr valign="middle" align="left" id="<?php echo $this->field?>_subject<?php echo $i;?>">
				 <th style="cursor:hand;text-align:left;" width="30%" onClick="ShowVarsLabel('<?php echo $this->field?>_id<?php echo $i;?>');">
					 <img src="/modules/news/images/close.gif" width="18" height="18" id="<?php echo $this->field?>_id<?php echo $i;?>img"><strong><?php echo $k;?></strong>: [�����/���ر�ǩ]
				  </th><th> <input type='button' onClick="DelTableRow('<?php echo $this->field?>_id<?php echo $i;?>');$('#<?php echo $this->field?>_subject<?php echo $i;?>').remove(); " value='�Ƴ�'></th>
			 </tr>
				<tr id="<?php echo $this->field?>_id<?php echo $i;?>" style='display:none'><td colspan="2"><textarea name='<?php echo $this->field?>_content[<?php echo $k;?>]' style='width:99%;height:80px'><?php echo $v;?></textarea><br>���ñ�ǩ��<span>{?</span>$_PAGE['data']['<?php echo $this->field?>']['<?php echo $k;?>']?}</td></tr>
				<?php
				     $i++;
				    } 
				 }?>
		</tbody>
		<tr> 
			  <td colspan="2" style="text-align:left;"><strong>������</strong>:<input type="text" id="<?php echo $this->field?>_name" value="" style="height:22px;"> 
			<input type="button" id="add_<?php echo $this->field?>" value=" ��ӱ��� "> ֧������</td>
		</tr>
	</table>
	</FIELDSET> 
	</div>
</DIV>
<script language="javascript">
var vars_hang = <?php echo count($vars);?>;
$('#add_<?php echo $this->field?>').click(
    function(){
	   var name = $("#<?php echo $this->field?>_name").val();
	   var result=name.match(/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[\w])*$/);
	   if($("textarea[name='<?php echo $this->field?>_content["+name+"]']").val()!=undefined){
	       alert('�������������ظ���');
		   $("#<?php echo $this->field?>_name").focus();
		   return false;
	   }
	   if(name=='' || !result){
	      alert('���������������֡���ĸ��������ɣ�');
		  $("#<?php echo $this->field?>_name").focus();
	   }else{
	       var c = "<tr valign=\"middle\" align=\"left\"><th style=\"cursor:hand;text-align:left;\" width=\"30%\" onClick=\"ShowVarsLabel('<?php echo $this->field?>_id"+vars_hang+"');\"><img src=\"/modules/news/images/close.gif\" width=\"18\" height=\"18\" id=\"<?php echo $this->field?>_id"+vars_hang+"img\"><strong>"+name+"</strong>: [�����/���ر�ǩ]</th><th> <input type='button' onClick=\"DelTableRow('<?php echo $this->field?>_id"+vars_hang+"');\" value='�Ƴ�'></th> </tr><tr id=\"<?php echo $this->field?>_id"+vars_hang+"\"><td colspan=\"2\"><textarea name='<?php echo $this->field?>_content["+name+"]' style='width:99%;height:80px'></textarea><br>���ñ�ǩ��<span>{?</span>$_PAGE['data']['<?php echo $this->field?>']['"+name+"']?}</td></tr>";
		      $("#<?php echo $this->field?>_trs").append(c); 
			  $("#<?php echo $this->field?>_trs").show();
			  $("input[type='button']").addClass('button_style');
			  vars_hang++;
	   }
	}
);
</script>