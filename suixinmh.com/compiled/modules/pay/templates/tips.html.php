<?php
echo '<link href="'.$this->_tpl_vars['jieqi_themeurl'].'style/pop.css" type="text/css" rel="stylesheet" />
<!--pop4 begin-->
<div class="pop4" style="display:none;">
 <dl>
  <dt>��ֵ����������ô�죿</dt>
  <dd class="g6">��ֵ���ǰ�벻Ҫ�رմ˴��ڡ���ɳ�ֵ��������������������İ�ť��</dd>
  <dd class="b g3">�����¿���ҳ����ɸ������ѡ��</dd>
  <dd class="p_btn"><a href="'.geturl('system','userhub','SYS=method=czView').'">����ɳ�ֵ</a><a href="/help/?wz=q23">��ֵ��������</a></dd>
  <dd><a href="'.geturl('pay','home').'" class="f_blue1">��������ѡ���ֵ��ʽ</a></dd>
 </dl>
</div><!--pop4 end-->
<script language="javascript">
function checkForm(form, openpop){
	if(getUserId()>0)
	{
		if(typeof($("dd.other input").val())!=\'undefined\'){
			var input_val = $("dd.other input").val();
			if($(\'dd.other input\').attr("disabled")==\'disabled\'){
			}else{
				if(input_val!=\'\'&&input_val<20){
					layer.msg(\'�Զ���������20Ԫ\');
					return false;
				}
			}
		}
		if(openpop>0){
			$.layer({
//				shade : [0.5 , \'#000\' , true],
				type : 1,
				area : [\'550px\',\'auto\'],
				title : false,
				closeBtn: [0, true],
				border : [10 , 0.3 , \'#000\', true],
				zIndex : 1,
				page : {dom : \'.pop4\'}
			});
		}
	}else{
	    userLogin();
		return false;
	}
}
</script>';
?>