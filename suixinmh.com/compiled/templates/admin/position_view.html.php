<?php
echo '<table align="center" cellpadding="2" cellspacing="1" class="grid" width="100%">
  <caption>��ǩ����</caption>
  <tr>
    <td><a href=\''.$this->_tpl_vars['adminprefix'].'&method=add&step=one\'><font color="red">��ӱ�ǩ</font></a> | <a href=\''.$this->_tpl_vars['adminprefix'].'\'>���ر�ǩ�б�</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="1" class="grid" width="100%">
    <caption>��ǩ����Ԥ��</caption>
    <tr> 
      <td>'.$this->_tpl_vars['_PAGE']['content'].'</td>
    </tr>
</table>
';
?>