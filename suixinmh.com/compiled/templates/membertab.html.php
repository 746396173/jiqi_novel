<?php
echo '      <div class="t2">
       <h2>��Աר��</h2>
       <ul class="tabs62">
        <li';
if($this->_tpl_vars['_REQUEST']['method']==usermember){
echo ' class="thistab"';
}
echo '><a href="'.geturl('system','userhub','SYS=method=usermember').'">��Աר��</a></li>
        <li';
if($this->_tpl_vars['_REQUEST']['method']==uservip){
echo ' class="thistab"';
}
echo '><a href="'.geturl('system','userhub','SYS=method=uservip').'">VIPר��</a></li>
       </ul>       
      </div>';
?>