<?php
echo '<script>
function tmpjiage(v){	
	$("dd[id^=\'v_\']").removeClass();
	$(\'#v_\'+v).addClass("hover");
	$(\'#egold\').val(v);
	$(\'#money_yuan\').val($(\'#v_\'+v).attr(\'money_yuan\'));
}
$(document).ready(function(){
	var id = \''.$this->_tpl_vars['_REQUEST']["method"].'\';
	if(id){
		$("#p_yeepay").removeClass();
		$(\'#p_\'+id).addClass("thistab");
	}
});
</script>

	<ul class="st fix" >
	  <li id="p_yeepay"><a href="'.geturl('pay','home','SYS=method=yeepay').'">����֧��</a></li>
	  <li id="p_alipay"><a href="'.geturl('pay','home','SYS=method=alipay').'">֧����֧��</a></li>
	  <li id="p_txfpay"><a href="'.geturl('pay','home','SYS=method=txfpay').'">���ų�ֵ</a></li>
	  <li id="p_cardpay"><a href="'.geturl('pay','home','SYS=method=cardpay').'">�ֻ���ֵ��</a></li>
	  <li id="p_gcardpay"><a href="'.geturl('pay','home','SYS=method=gcardpay').'">��Ϸ�㿨</a></li>
	  <li id="p_qcardpay"><a href="'.geturl('pay','home','SYS=method=qcardpay').'">Q��֧��</a></li>
	  <li id="p_paypal"><a href="'.geturl('pay','home','SYS=method=paypal').'">PayPal֧��</a></li>
	  <li id="p_wftpay"><a href="'.geturl('pay','home','SYS=method=wftpay').'">΢��֧��</a></li>
	</ul>
';
?>