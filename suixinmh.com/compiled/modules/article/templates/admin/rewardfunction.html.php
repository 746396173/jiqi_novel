<?php
echo '<div class="gridtop">
	<a href="'.$this->_tpl_vars['adminprefix'].'">';
if($this->_tpl_vars['_REQUEST']['method'] == "" || $this->_tpl_vars['_REQUEST']['method'] == "finance"){
echo '����Ȩ����';
}else{
echo '��Ȩ����';
}
echo '</a> 
	| <a href="'.$this->_tpl_vars['adminprefix'].'&method=reward">';
if($this->_tpl_vars['_REQUEST']['method'] == "reward"){
echo '����ѹ���';
}else{
echo '��ѹ���';
}
echo '</a>
	| <a href="javascript:alert(\'������...\')">�����¼</a>
	| <a href="javascript:alert(\'������...\')">���ܼ�¼</a>
</div>';
?>