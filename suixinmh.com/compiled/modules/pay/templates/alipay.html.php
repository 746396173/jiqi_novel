<?php
echo '<link href="'.$this->_tpl_vars['jieqi_themeurl'].'style/user.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.css" />
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/local/zh_CN.js"></script>
<script>
function tmpjiag(v){	
	$("dd[id^=\'v_\']").removeClass();
	$("dd.other.hover").removeClass("hover");
	$("dd.other input").attr("disabled","disabled");
	$(\'#v_\'+v).addClass("hover");
	$(\'#egold\').val(v);
	$(\'#money_yuan\').val($(\'#v_\'+v).attr(\'money_yuan\'));
}
$(document).ready(function(){
	$("dd.other").click(function(){
		$("dd[id^=\'v_\']").removeClass();
		$(this).addClass("hover");
		$(this).find("input").removeAttr("disabled");
		var jine = $(this).find("input").val();
		if(jine>=1){
			var ejine = jine*100;
			//$(this).next("p").find("em").html(ejine);
			$(\'#egold\').val(ejine);
			$(\'#money_yuan\').val(jine);
		}else{
			$(this).find("input").val(\'\');
			$(this).find("p").find("em").html(0);
			$(\'#money_yuan\').val(0);
			$(\'#egold\').val(0);
			$(this).find("input").focus();
		}
		$(this).find("input").on("keyup",function(){
			var y = $(this).val();
			$(this).val(parseInt(y.replace(/\\D/g,\'\')));
			var jine = $(this).val();
			if(parseInt(jine)>=1){
				var ejine = jine*100;
				if(!isNaN(ejine)){
					$(this).next("p").find("em").html(ejine);
					$(\'#egold\').val(ejine);
					$(\'#money_yuan\').val(jine);
				}else{
					$(this).next("p").find("em").html(0);
					$(\'#egold\').val(0);
					$(\'#money_yuan\').val(0);
				}
			}else{
				$(this).val(\'\');
				$(this).next("p").find("em").html(0);
				$(\'#egold\').val(0);
				$(\'#money_yuan\').val(0);
				$(this).focus();
				return false;
			}
		});
	});
});
</script>
<!--wrap2 begin-->
<div class="wrap2">
  ';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'modules/article/templates/bookFunction.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
  <!--article2 begin-->
  <div class="article3 fr">
   <!--tabox begin-->
    <div class="tabox">
	  ';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'templates/caiwutab.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
      <ul id="tab_conbox" class="f0 fix">
        <li class="fix">
          <div class="pay f12">
		  ';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'modules/pay/templates/paytab.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
            <ul id="tab_con11" class="pay_dwn fix">
              <li>
			  <form id="payfrm" name="payfrm" method="post" onSubmit="return checkForm(this, 1);" target="_blank" action="'.geturl('pay','home','SYS=method=alipay').'" data-validator-option="{theme:\'yellow_top\'}">
                <!--box_note2 begin-->
                <div class="box_note2 cl mt10">
                 <h3 class="tit3">��ѡ����Ҫ��ֵ�Ľ�</h3>
                 <dl class="lisd_m fix">
				 ';
if (empty($this->_tpl_vars['paylimit'])) $this->_tpl_vars['paylimit'] = array();
elseif (!is_array($this->_tpl_vars['paylimit'])) $this->_tpl_vars['paylimit'] = (array)$this->_tpl_vars['paylimit'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['paylimit']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['paylimit']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['paylimit']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['paylimit']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['paylimit']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	if($this->_tpl_vars['i']['order']==2){$this->_tpl_vars['egold']=$this->_tpl_vars['i']['key'];$this->_tpl_vars['money_yuan']=$this->_tpl_vars['paylimit'][$this->_tpl_vars['i']['key']];} 
echo '
				 ';
if($this->_tpl_vars['i']['key']>1000){
echo '
                  <dd id="v_'.$this->_tpl_vars['i']['key'].'"';
if($this->_tpl_vars['i']['order']==1){
echo ' class="hover"';
}
echo ' onclick="tmpjiag('.$this->_tpl_vars['i']['key'].');" money_yuan="'.$this->_tpl_vars['paylimit'][$this->_tpl_vars['i']['key']].'"';
if($this->_tpl_vars['i']['key']>=20000){
echo ' title="����';
echo $this->_tpl_vars['i']['key']*0.05; 
echo '��ȯ"';
}
echo '><b>'.$this->_tpl_vars['paylimit'][$this->_tpl_vars['i']['key']].'Ԫ</b><br />('.$this->_tpl_vars['i']['key'].'�麣��)</dd>
				  ';
}
echo '
				  ';
}
echo '
                  <dd class="other"><b>������</b><input name="jine" type="text" data-rule="range[20~]" disabled="disabled" />Ԫ<p>(<em>0</em>�麣��)</p></dd>
                 </dl>
				 <input type="hidden" name="egold" id="egold" value="'.$this->_tpl_vars['egold'].'">
				 <input type="hidden" name="money_yuan" id="money_yuan" value="'.$this->_tpl_vars['money_yuan'].'">
				 <input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '">
                 <dl class="lisd_note">
                  <dt>˵����</dt>
                  <dd>1.�Զ��������20Ԫ��</dd>
                  <dd>2.�һ�������1Ԫ=100�麣�ң�</dd>
                  <dd>3.���γ�ֵ200Ԫ������1000��ȯ�����γ�ֵ500Ԫ������2500��ȯ��������ͣ�</dd>   
                  <dd>4.���͵���ȯ�����ڶ��Ĳ���VIP�½ڣ��������ڴ��͡�</dd>             
                 </dl>
                </div><!--box_note2 end-->
                <p class="pt20 cl pb10"><button type="submit" class="btn">��ʼ��ֵ&gt;&gt;</button></p>
				</form>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div><!--tabox end-->
  </div><!--article2 end-->
</div><!--wrap2 end-->
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'modules/pay/templates/tips.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
';
?>