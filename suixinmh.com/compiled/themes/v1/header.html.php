<?php
echo '  <!--top_mini begin-->
  <div class="top_mini">
    <div class="wrap fix">
      <div class="userbar" id="userbar">      
        	';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'templates/loginheader.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
      </div>
      <div class="mini_r f_gray3">
       <a href="http://www.shuhai.com/" onClick="window.external.addFavorite(this.href,this.title);return false;" title=\'�麣��\' rel="sidebar" class="addfav">�����ղ�</a>
       |<a href="javascript:;"  onclick=this.style.behavior="url(#default#homepage)";this.setHomePage("http://www.ishufun.net/");  class="sethome"  title="Ʒ��С˵��" >��Ϊ��ҳ</a>
       |<a href="javascript:void(0)" id="StranLink" name="StranLink" class="fan"  title="����">����</a>
      </div>
    </div>
  </div><!--top_mini end-->
  <script type="text/javascript">loadheader();setInterval(loadheader,30000);</script>
  <div class="wrap">
    <div class="site">
     <a href="';
echo(JIEQI_URL); 
echo '" target="_blank" title="�麣С˵��" class="logo">�麣С˵��</a>
     <ul class="substation">
       <li>��<a href="javascript:alert(\'������\');" title="����С˵��">������</a></li>
       <li>��<a href="javascript:alert(\'������\');" title="�ֻ���">�ֻ���</a></li>
       <li>��<a href="javascript:alert(\'������\');" title="��ѧ��">��ѧ��</a></li>
     </ul>     
    </div>
'.jieqi_get_block(array('bid'=>'278', 'module'=>'system', 'filename'=>'', 'classname'=>'BlockSystemCustom', 'side'=>'', 'title'=>'���Ͻ�ͷ��������', 'vars'=>'', 'template'=>'', 'contenttype'=>'1', 'custom'=>'1', 'publish'=>'3', 'hasvars'=>'0'), 1).'
  </div>
  <!--nav begin-->
  <div class="nav">
   <div class="mainav">
    <ul>
     <li id="home" class="on" onclick="location.href=\''.$this->_tpl_vars['jieqi_url'].'/\'" style="cursor:pointer" title="��ҳ">��ҳ</li>
     <li id="top"><a href="'.geturl('article','top').'" target="_blank" title="���а�">���а�<em>|</em></a></li>
     <li id="search"><a href="/search/" title="��С˵" target="_blank">��С˵<em>|</em></a></li>
     <li><a href="/fuli/" title="���߸���" target="_blank">���߸���<em>|</em></a></li>
     <li id="masterPage"><a href="'.geturl('article','article','SYS=method=masterPage').'" title="����ר��" target="_blank">����ר��<em>|</em></a></li>
<!--     <li><a href="'.geturl('article','sort','SYS=sort=0&size=0&fullflag=2&operate=0&free=0&page=1').'">�걾<em>|</em></a></li>-->
     <li id="news"><a href="'.$this->_tpl_vars['jieqi_local_url'].'/news/"  target="_blank"title="��Ѷ">��Ѷ<em>|</em></a></li>
     <li><a href="/wap/html5.html" target="_blank" title="wap">wap</a><span class="fl">&nbsp;&nbsp;��</span><a class="client" href="/wap/anzhuo.html" target="_blank" title="�ͻ���">�ͻ���<img class="newapp" src="'.$this->_tpl_vars['jieqi_themeurl'].'images/new.png" alt="���¿ͻ���" /><em>|</em></a></li><!--�ֻ��Ķ�-->
     <li id="pay"><a class="f_red" href="'.geturl('pay','home').'" title="��ֵ" target="_blank">��ֵ<em>|</em></a></li>
     <!--<li id="help"><a href="/help" target="_blank" title="����">����<em>|</em></a></li>-->
     <li><a href="tencent://message/?uin=724171887" title="�ͷ�">�ͷ�<em>|</em></a></li>
<!--     <li><a href="javascript:void(0)">��̳<em>|</em></a></li>
     <li><a href="javascript:void(0)">����<em>|</em></a></li>
     <li><a href="javascript:void(0)">���澫Ʒ<em>|</em></a></li>
     <li><a href="javascript:void(0)">Ͷ���뽨��<em>|</em></a></li>-->
    </ul>
   </div>
   <div class="sortnav">
    <dl class="f_white">
     <dd class="one"><a href="/shuku/" title="���">���</a></dd><!--'.geturl('article','sort','SYS=sort=0&size=0&fullflag=0&operate=0&free=0&page=1').'-->
     <dd><a href="'.geturl('article','channel','class=dushi').'" title="����С˵">����</a>&middot;<a href="'.geturl('article','channel','class=yanqing').'" title="����С˵">����</a></dd>
     <dd><a href="'.geturl('article','channel','class=xuanhuan').'" title="����С˵">����</a>&middot;<a href="'.geturl('article','channel','class=xiuzhen').'" title="����С˵">����</a></dd>
     <dd><a href="'.geturl('article','channel','class=lishi').'" title="��ʷС˵">��ʷ</a>&middot;<a href="'.geturl('article','channel','class=wuxia').'" title="����С˵">����</a></dd>
     <dd><a href="'.geturl('article','channel','class=wangyou').'" title="����С˵">����</a>&middot;<a href="'.geturl('article','channel','class=jingji').'" title="����">����</a></dd>
     <dd><a href="'.geturl('article','channel','class=junshi').'" title="����С˵">����</a>&middot;<a href="'.geturl('article','channel','class=kehuan').'" title="�ƻ�С˵">�ƻ�</a></dd>
     <dd><a href="'.geturl('article','channel','class=kongbu').'" title="�ֲ�С˵">�ֲ�</a>&middot;<a href="'.geturl('article','channel','class=tongren').'" title="ͬ��С˵">ͬ��</a></dd>
     <dd><a href="'.$this->_tpl_vars['jieqi_local_url'].'/quanben/" title="ȫ��С˵">ȫ��</a>&middot;<a href="'.geturl('article','top','method=toplist','SYS=type=postdate&sortid=0&page=1').'" title="����С˵">����</a></dd>
    </dl>
   </div>
  </div><!--nav end-->
';
?>