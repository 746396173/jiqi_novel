<?php
echo '<link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.css" />
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/local/zh_CN.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/calendar/WdatePicker.js"></script>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'modules/article/templates/admin/rewardfunction.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
<form name="frmsearch" method="post" action="'.$this->_tpl_vars['adminprefix'].'">
<table class="grid" width="100%" align="center">
    <tr>
        <td class="odd">�ؼ��֣�
            <input name="keyword" type="text" id="keyword" class="text" size="0" maxlength="50" value="'.$this->_tpl_vars['keyword'].'"> 
            <label><input name="keytype" type="radio" class="radio" value="0"';
if($this->_tpl_vars['keytype']==0){
echo ' checked';
}
echo '>
            ��������</label><label>
			<input type="radio" name="keytype" class="radio" value="1"';
if($this->_tpl_vars['keytype']==1){
echo ' checked';
}
echo '>
	    ����ID</label><label>
			<input type="radio" name="keytype" class="radio" value="2"';
if($this->_tpl_vars['keytype']==2){
echo ' checked';
}
echo '>
            ���� &nbsp;&nbsp;</label>
             <select name="nowagent" id="nowagent">
 				<option value="0">-ѡ�����-</option>
 				';
if (empty($this->_tpl_vars['agents'])) $this->_tpl_vars['agents'] = array();
elseif (!is_array($this->_tpl_vars['agents'])) $this->_tpl_vars['agents'] = (array)$this->_tpl_vars['agents'];
$this->_tpl_vars['j']=array();
$this->_tpl_vars['j']['columns'] = 1;
$this->_tpl_vars['j']['count'] = count($this->_tpl_vars['agents']);
$this->_tpl_vars['j']['addrows'] = count($this->_tpl_vars['agents']) % $this->_tpl_vars['j']['columns'] == 0 ? 0 : $this->_tpl_vars['j']['columns'] - count($this->_tpl_vars['agents']) % $this->_tpl_vars['j']['columns'];
$this->_tpl_vars['j']['loops'] = $this->_tpl_vars['j']['count'] + $this->_tpl_vars['j']['addrows'];
reset($this->_tpl_vars['agents']);
for($this->_tpl_vars['j']['index'] = 0; $this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['loops']; $this->_tpl_vars['j']['index']++){
	$this->_tpl_vars['j']['order'] = $this->_tpl_vars['j']['index'] + 1;
	$this->_tpl_vars['j']['row'] = ceil($this->_tpl_vars['j']['order'] / $this->_tpl_vars['j']['columns']);
	$this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['order'] % $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['column'] == 0) $this->_tpl_vars['j']['column'] = $this->_tpl_vars['j']['columns'];
	if($this->_tpl_vars['j']['index'] < $this->_tpl_vars['j']['count']){
		list($this->_tpl_vars['j']['key'], $this->_tpl_vars['j']['value']) = each($this->_tpl_vars['agents']);
		$this->_tpl_vars['j']['append'] = 0;
	}else{
		$this->_tpl_vars['j']['key'] = '';
		$this->_tpl_vars['j']['value'] = '';
		$this->_tpl_vars['j']['append'] = 1;
	}
	echo '
 				<option value="'.$this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uid'].'" ';
if($this->_tpl_vars['nowagent']==$this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uid']){
echo 'selected';
}
echo '>
 					';
echo ($this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['name'] ? $this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['name'] : $this->_tpl_vars['agents'][$this->_tpl_vars['j']['key']]['uname']); 
echo '
 				</option>
 				';
}
echo '
 			</select>
            <select name="nowauthorize" id="nowauthorize">
            	<option value="">-ѡ����Ȩ����-</option>
            		<option value="1" ';
if($this->_tpl_vars['nowauthorize']==1){
echo 'selected';
}
echo '>�麣ǩԼ</option>
            		<option value="2" ';
if($this->_tpl_vars['nowauthorize']==2){
echo 'selected';
}
echo '>������</option>
            		<option value="3" ';
if($this->_tpl_vars['nowauthorize']==3){
echo 'selected';
}
echo '>������ɹ�</option>
            </select>
            <input type="submit" name="btnsearch" class="button" value="�� ��"><input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
    </tr>
</table>
</form>
<table class="grid" width="100%" align="center" id="list">
	<caption><label>��Ȩ����[<a id="add"  title="������">+����¼�¼</a>][<a href="'.$this->_tpl_vars['adminprefix'].'&method=finance" title="������Ϣ�޸�����">������Ϣ�޸�����</a>]</label></caption>
  <tr align="center">
  	<th width="2%"></th>
    <th width="18%">��ƷID</th>
    <th width="15%">��Ʒ����</th>
    <th width="18%">����</th>
    <th width="15%">��Ȩ����</th>
    <th width="10%">���</th>
    <th width="10%">��Ȩ��Ϣ</th>
    <th width="">����</th>
  </tr>
  ';
if (empty($this->_tpl_vars['rows'])) $this->_tpl_vars['rows'] = array();
elseif (!is_array($this->_tpl_vars['rows'])) $this->_tpl_vars['rows'] = (array)$this->_tpl_vars['rows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['rows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['rows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['rows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['rows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['rows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr>
      <td  align="center"><input type="checkbox" name="selbox"/>
    </td>
    <td  align="center">'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['articleid'].'
    </td>
    <td ><a href="'.geturl('article','articleinfo','aid='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['articleid'].'').'" target="_blank">'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['articlename'].'</a></td>
    <td >
    
    
    ';
if($this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['authorid'] == 0){
echo $this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['author'];
}else{
echo '<a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['authorid'].'').'" target="_blank">'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['author'].'</a>';
}
echo '
    </td>
    <td  align="center">
    	';
if($this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['authorize']==1){
echo '�麣ǩԼ';
}elseif($this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['authorize']==2){
echo '������';
}else{
echo '������ɹ�';
}
echo '
    </td>
    <td  align="center">
    	'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['agent'].'
    </td>
    <td  align="center"><a href="javascript:;" name="view_contract" value="'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['copyrightid'].'">[�鿴]</a></td>
    <td  align="center">
    	<!-- �༭����ֻ����������Ȩ���û��ſ�ʹ�� -->
    	';
if($this->_tpl_vars['manageallarticle']==1){
echo '
   			<a href="javascript:;" name="edit_contract" value="'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['copyrightid'].'" title="�޸�"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/editor.gif" border="0" /></a>
   		';
}
echo '
  		<!-- ����Ա��ɾ��Ȩ�� -->
  		';
if(JIEQI_IS_ADMIN==1){
echo '
  			<a href="'.$this->_tpl_vars['adminprefix'].'&method=deleteContract&id='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['copyrightid'].'" ajaxclick="true"  confirm="ȷ��ɾ����Ȩ��Ϣ��" retruemsg="false" title="ɾ��"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/delete_on.gif" border="0" /></a>
  		';
}
echo '
  </tr>
  ';
}
echo '
</table>
<div class="pages">'.$this->_tpl_vars['url_jumppage'].'</div>
<form name="add_contract" id="add_contract" method="post" action="'.$this->_tpl_vars['adminprefix'].'&method=addContract" style="display:none" ajaxpost="true" retruemsg="true">
<table class="grid" width="400px" align="center" id="list">
<caption>�����Ʒ��Ȩ��Ϣ</caption>
<tr>
	<td colspan="2" align="center">��ͬ��Ϣ</td>
</tr>
<tr>
	<td>��ƷID</td><td><input name="articleid" type="text" id="articleid" class="text" size="0" maxlength="50" data-rule="required;"><font color="red">*</font></td>
</tr>
<tr>
	<td>���߱���</td><td><input name="author" type="text" id="author"  size="0" maxlength="50" disabled><font color="red">*</font></td>
</tr>
<tr>
	<td>��Ʒ����</td><td><input name="articlename" type="text" id="articlename"  style="" size="0" maxlength="50" disabled ><font color="red">*</font></td>
</tr>
<tr>
	<td>���α༭</td><td><input name="agent" type="text" id="agent"  size="0"  maxlength="50" disabled ><font color="red">*</font></td>
</tr>
<tr>
	<td>ǩԼ�༭</td><td><input name="signagent" type="text" id="signagent" class="text"  size="0"  maxlength="50"></td>
</tr>
<tr>
	<td>��������</td><td><input name="realname" type="text" id="realname" class="text" size="0" maxlength="50"></td>
</tr>
<tr>
	<td>��ͬ���</td><td><input name="contract" type="text" id="contract" class="text" size="0" maxlength="50" data-rule="required;"><font color="red">*</font></td>
</tr>
<tr>
	<td>��Ȩ����</td><td>
            <select name="authorize" id="authorize" class="text"> 
            		<option value="1" ';
if($this->_tpl_vars['authorize']==1){
echo 'selected';
}
echo '>�麣ǩԼ</option>
            		<option value="2" ';
if($this->_tpl_vars['authorize']==2){
echo 'selected';
}
echo '>������</option>
            		<option value="3" ';
if($this->_tpl_vars['nowauthorize']==3){
echo 'selected';
}
echo '>������ɹ�</option>
            </select>
<font color="red">*</font></td>
</tr>
<tr>
	<td>ǩԼ�۸�</td>
	<td>
		<select name="signup" id="signup" class="text">
            		<option value="1" >���ǩԼ</option>
            		<option value="3" >�ֳɵͱ�</option>
            		<option value="4" >�ֳ�</option>
            </select><font color="red">*</font>
            <label id="signupprice_lbl"></label>
	</td> 
</tr>
<tr>                         
	<td>��ͬ��ʼʱ��</td><td><input name="begindate" id="begindate" autocomplete="off" type="text" class="Wdate" onfocus="WdatePicker({maxDate:\'#F{$dp.$D(\\\'enddate\\\',{d:-1})||\\\'2030-10-01\\\'}\'})" data-rule="required;"/><font color="red">*</font></td>
</tr>
<tr>
	<td>��ͬ����ʱ��</td><td><input name="enddate" id="enddate" autocomplete="off" type="text" class="Wdate" onfocus="WdatePicker({minDate:\'#F{$dp.$D(\\\'begindate\\\',{d:1})}\',maxDate:\'2030-10-01\'})" /></td>
</tr>
<!-- <tr>
	<td colspan="2" align="center">������Ϣ</td>
</tr>
<tr>
	<td>�տ�������</td><td><input name="payee" type="text" id="payee" class="text" size="0" maxlength="4" ></td>
</tr>
<tr>
	<td>���֤����</td><td><input name="sid" type="text" id="sid" class="text" size="20" maxlength="18" ></td>
</tr>
<tr>
	<td>���֤��ַ</td><td><input name="address" type="text" id="address" class="text" size="45" maxlength="70" ></td>
</tr>
<tr>
	<td>ͨѶ��ַ</td><td><input name="communication" type="text" id="communication" class="text" size="45" maxlength="70" ></td>
</tr>
<tr>
	<td>�����е�ַ</td><td><input name="bankaddress" type="text" id="bankaddress" class="text" size="45" maxlength="70" ></td>
</tr>
<tr>
	<td>�����˺�</td><td><input name="banknumber" type="text" id="banknumber" class="text" size="30" maxlength="70" ></td>
</tr>
<tr>
	<td>��ע</td><td><textarea maxlength="120" name="remark" id="remark" cols="30" rows="3" ></textarea>��120������</td>
</tr>-->
<tr>
	<td colspan="2" align="center"><button type="submit" >�ύ</button><input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" /></td>
</tr> 
</table>
</form>
<table class="grid" id="detail" style="display:none"  width="500px" >
<caption>��Ʒ��Ȩ��Ϣ</caption>
<tr>
	<td colspan="4" align="center"><h3>��ͬ��Ϣ</h3></td>
</tr>
<tr>
	<td align="right"><h4>��ƷID</h4></td>
	<td id="v_articleid"></td>
	<td align="right"><h4>��ͬ���</h4></td>
	<td id="v_contract"></td>
</tr>
<tr>
	<td align="right"><h4>��Ʒ����</h4></td>
	<td id="v_articlename"></td>
	<td align="right"><h4>���߱���</h4></td>
	<td id="v_author"></td>
</tr>
<tr>
	<td align="right"><h4>��������</h4></td>
	<td id="v_realname"></td>
	<td align="right"><h4>��Ȩ����</h4></td>
	<td id="v_authorize"></td>
</tr>
<tr>
	<td align="right"><h4>ǩԼ�۸�</h4></td>
	<td id="v_signup"></td>
	<td colspan="2" id="v_signupprice"></td>
</tr>
<tr>
	<td align="right"><h4>��ͬ��ʼʱ��</h4></td>
	<td id="v_begindate"></td>
	<td align="right"><h4>��ͬ����ʱ��</h4></td>
	<td id="v_enddate"></td>
</tr>
<tr>
	<td align="right"><h4>ǩԼ�༭</h4></td>
	<td id="v_signagent"></td>
	<td align="right"><h4>���α༭</h4></td>
	<td id="v_agent"></td>
</tr>
<!-- <tr>
	<td colspan="4" align="center"><h3>������Ϣ</h3></td>
</tr>
<tr>
	<td align="right"><h4>�տ�������</h4></td>
	<td colspan="3" id="v_payee"></td>
</tr>
<tr>
	<td align="right"><h4>���֤����</h4></td>
	<td colspan="3" id="v_sid"></td>
</tr>
<tr>
	<td align="right"><h4>���֤��ַ</h4></td>
	<td colspan="3" id="v_address"></td>
</tr>
<tr>
	<td align="right"><h4>ͨѶ��ַ</h4></td>
	<td colspan="3" id="v_communication"></td>
</tr>
<tr>
	<td align="right"><h4>�����е�ַ</h4></td>
	<td colspan="3" id="v_bankaddress"></td>
</tr>
<tr>
	<td align="right"><h4>�����˺�</h4></td>
	<td colspan="3" id="v_banknumber"></td>
</tr>
<tr>
	<td align="right"><h4>��ע</h4></td>
	<td colspan="3" id="v_remark"></td>
</tr> -->
</table>
<script>

$(document).ready(function(){
	//���ǩԼ
	var price_type1 = "<input size=\'3\' name=\'param1\' id=\'param1\' maxlength=\'5\' />Ԫ<input size=\'3\' name=\'param2\' id=\'param2\' maxlength=\'3\' />ǧ��<input size=\'3\' name=\'param3\' id=\'param3\' maxlength=\'3\'/>%���߷ֳ�<font color=\'red\'>*</font>";
	//���ȫ��
	var price_type2 = "<input size=\'3\' name=\'param1\' id=\'param1\' maxlength=\'3\' />Ԫÿǧ��";
	//�ֳɵͱ�
	var price_type3 = "<input size=\'3\' name=\'param1\' id=\'param1\' maxlength=\'3\' />����<input size=\'3\' name=\'param2\' id=\'param2\' maxlength=\'5\' />Ԫ�ͱ�<font color=\'red\'>*</font>";
	$("#add_contract").hide();
	$("#signupprice_lbl").html(price_type1);
	$("#add").click(function(){
		$(\'#add_contract\')[0].reset();
		$(\'#articleid\').attr("readonly",false);
		$(\'#add_contract caption\').text("�����Ʒ��Ȩ��Ϣ");
		$(\'#add_contract\').attr(\'action\', \''.$this->_tpl_vars['adminprefix'].'&method=addContract\');
		 $.layer({
				shade : [0.5 , \'#000\' , true],
				type : 1,
//				area : [\'60%\',\'560px\'],
				area : [\'400px\',\'430px\'],
				title : false,
				offset : [\'60px\' , \'50%\'],
				border : [10 , 0.3 , \'#000\', true],
				zIndex : 1,
				page: {
			 	       dom: \'#add_contract\'
			 	    },
				close : function(index){
					layer.close(index);
					$(\'.ul_con\').hide();
				}
			});	
		 $("#articleid").focus();
	});
	//��֤��Ȩ�鼮��Ч��
	$("#articleid").blur(function(){
		//ajaxȡ������Ϣ
		var re =/^[0-9]+$/;
		if(!re.test($(this).val())){
			layer.msg(\'����д��Ч����ƷID��\',1,{type:8,shade:false});
			$("#articleid").focus();
			return;
		}
		GPage.getJson(\''.$this->_tpl_vars['adminprefix'].'&method=getArticle&aid=\'+$(this).val(),function(data){
			if(data.status==\'OK\'){
				$("#articlename").val(data.msg[\'articlename\']);
				$("#author").val(data.msg[\'author\']);
				$("#agent").val(data.msg[\'agent\']);
			}else{
				layer.alert(data.msg, 8, !1);
			}
		})
	});
	//��Ȩ����->ǩԼ�۸�
	$("#authorize").change(function(){
		var type = $(this).val();
		var signup_item1 = $("<option>").val(1).text("���ǩԼ");
		var signup_item2 = $("<option>").val(2).text("���ȫ��");
		var signup_item3 = $("<option>").val(3).text("�ֳɵͱ�");
		var signup_item4 = $("<option>").val(4).text("�ֳ�");
		//��ʼ��
		$("#signup").empty();
		$("#enddate").nextAll().remove();
		$("#enddate").attr("novalidate",true);
		if(type == 1){
			$("#signup").append(signup_item1);
			$("#signup").append(signup_item3);
			$("#signup").append(signup_item4);
		}else if(type == 2){
			$("#signup").append(signup_item3);
			$("#signup").append(signup_item4);
			
			$("#enddate").removeAttr("novalidate");
			$("#enddate").parent().append("<font color=\\"red\\">*</font>");
			$("#enddate").attr("data-rule","required;");
		}else if(type == 3){
			$("#signup").append(signup_item2);
			$("#signup").append(signup_item3);
			$("#signup").append(signup_item4);
			
			$("#enddate").removeAttr("novalidate");
			$("#enddate").parent().append("<font color=\\"red\\">*</font>");
			$("#enddate").attr("data-rule","required;");
		}
		$("#signup").change(); //�����¼������ü۸�
	});
	//ǩԼ�۸���ϸ
	$("#signup").change(function(){
		var type = $(this).val()
		if(type == 1){
			$("#signupprice_lbl").html(price_type1);
		}else if(type == 2){
			$("#signupprice_lbl").html(price_type2);
		}else if(type == 3){
			$("#signupprice_lbl").html(price_type3);
		}else{
			$("#signupprice_lbl").html("");
		}
	});
	//�޸�
	$("a[name=\'edit_contract\']").click(function(){
		var id = $(this).attr("value");
		GPage.getJson(\''.$this->_tpl_vars['adminprefix'].'&method=getCopyright&id=\'+id,function(data){
			if(data.status==\'OK\'){
				for(var key in data.msg){
					if($(\'#\'+key)[0]){
						$(\'#\'+key).val("");
						if(data.msg[key]){
							$(\'#\'+key).val(data.msg[key]);
						}
					}
				} 
				$("#authorize").val(data.msg["authorize_code"]);//��Ȩ���������б�Ĭ��ѡ��
				$("#authorize").change(); //�����¼���������Ȩ����
				$("#signup").val(data.msg["signup_code"]);//ǩԼ���������б�Ĭ��ѡ��
				$("#signup").change(); //�����¼������ü۸���ϸ
				$("#param1").val(data.msg["signupprice1"]);
				$("#param2").val(data.msg["signupprice2"]);
				$("#param3").val(data.msg["signupprice3"]);
				$(\'#articleid\').attr("readonly","readonly");
				$(\'#add_contract caption\').text("�޸���Ʒ��Ȩ��Ϣ");
				$(\'#add_contract\').attr(\'action\', \''.$this->_tpl_vars['adminprefix'].'&method=editContract&id=\'+id);
				$.layer({
					shade : [0.5 , \'#000\' , true],
					type : 1,
//					area : [\'60%\',\'560px\'],
					area : [\'400px\',\'430px\'],
					title : false,
					offset : [\'60px\' , \'50%\'],
					border : [10 , 0.3 , \'#000\', true],
					zIndex : 1,
					page: {
				 	       dom: \'#add_contract\'
				 	    },
					close : function(index){
						layer.close(index);
						$(\'.ul_con\').hide();
					}
				});	
			}else{
				layer.alert(data.msg, 8, !1);
			}
		})
	});
	//��Ȩ����
	$("a[name=\'view_contract\']").click(function(){
		var id = $(this).attr("value");
		GPage.getJson(\''.$this->_tpl_vars['adminprefix'].'&method=getCopyright&id=\'+id,function(data){
			if(data.status==\'OK\'){
				for(var key in data.msg){
					if($(\'#v_\'+key)[0]) {
						$(\'#v_\'+key).text("");
						if(data.msg[key]){
							$(\'#v_\'+key).text(data.msg[key]);
						}
					}
				} 
				 $.layer({
						shade : [0.5 , \'#000\' , true],
						type : 1,
//						area : [\'60%\',\'560px\'],
						area : [\'500px\',\'200px\'],
						title : false,
						offset : [\'100px\' , \'50%\'],
						border : [10 , 0.3 , \'#000\', true],
						zIndex : 1,
						page: {
					 	       dom: \'#detail\'
					 	    },
						close : function(index){
							layer.close(index);
							$(\'.ul_con\').hide();
						}
					});	
			}else{
				layer.alert(data.msg, 8, !1);
			}
		})
	});
	$("#list tr:not(\':first\')").bind("mouseover",function(){
		 $(this).css("background","#DDF2FF");
	});
	$("#list tr:not(\':first\')").bind("mouseout",function(){
		if($(this).find("input[name=\'selbox\']").attr("checked")){
			$(this).css("background","#C3E8FF");
		}else{
			$(this).css("background","#ffffff");
		}
	});
})
</script>';
?>