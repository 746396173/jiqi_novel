<?php
echo '<div class="p10 f14 c888 tc">
    ';
if($this->_tpl_vars['_USER']['uid']>0){
echo '
     <div class="f16 mt10 plf10">�˻���<span class="cOrange1">'.$this->_tpl_vars['_USER']['egolds'].'</span>'.$this->_tpl_vars['egoldname'].'</div>
    ';
}else{
echo '
    <i class="iconfont f20 cPink mr5 vam">&#xe614;</i>��ֵ���� <a class="cRed b bcRed br2 pl5 pr5" href="'.geturl('3g','login').'">��½</a> ����û���˺� <a class="cBlue b bcBlue br2 pl5 pr5" href="'.geturl('3g','register').'">���ע��</a>
    ';
}
echo '
</div>
<!--���-->
 ';
?>