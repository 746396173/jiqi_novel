<?php
echo '<div class="footer">
<div class="footer_nav">
<p><a href="'.geturl('system','about','SYS=method=index').'" target="_blank">��������</a>|<a href="'.geturl('system','about','SYS=method=business').'" target="_blank">��������</a>|<a href="'.geturl('system','about','SYS=method=partner').'" target="_blank">��Ȩ����</a>|<a href="'.geturl('system','userhub','SYS=method=uservip').'" target="_blank" class="f_red3">VIP��Ա����</a>|<a href="'.geturl('system','userhub').'" target="_blank" class="f_red3">����Ͷ��</a>|<a href="'.geturl('pay','home').'" target="_blank" class="f_red3">֧������</a>|<a href="'.geturl('system','about','SYS=method=contact').'" target="_blank">��ϵ����</a>|<a href="'.$this->_tpl_vars['jieqi_local_url'].'/link.html" target="_blank">��������</a></p></div>
Copyright(C) 2011-2014 ishufun.net All Rights Reserved ��Ȩ���� Ʒ����<br />
Ʒ������Ȩ���У�δ����ɲ���ת�� ��ICP��15006371��<br />
���������߷�����Ʒʱ������ع��һ�������Ϣ����취�涨�����Ǿܾ��κ�ɫ��С˵��һ�����֣�����ɾ����<br />
��վ����¼��Ʒ���������⡢������ۼ���վ����֮�������������Ϊ���뱾վ�����޹�<br />
<div class="website_logo">
 <em class="beianxinxi"><a target="_blank" title="��վ������Ϣ" href="javascript:;">��վ������Ϣ(����)</a></em>
 <em class="yingyezhizhao"><a target="_blank" title="Ӫҵִ�ձ�����Ϣ" href="javascript:;">Ӫҵִ�ձ�����Ϣ(����)</a></em>
 <em class="shwj_110"><a target="_blank" title="��������110" href="javascript:;">��������110</a></em>
 <em class="jbzx"><a target="_blank" title="������Ϣ�ٱ�����" href="javascript:;">������Ϣ�ٱ�����</a></em>
 <a  key ="53fee642efbfb03413888bae"  logo_size="124x47"  logo_type="realname"  href="http://www.anquan.org" ><script src="http://static.anquan.org/static/outer/js/aq_auth.js"></script></a>
 <!--������վͼƬLOGO��װ��ʼ-->
<span class="kxyz"><script src="http://kxlogo.knet.cn/seallogo.dll?sn=e14091661010053930hdkj000000&size=0"></script></span>
<!--������վͼƬLOGO��װ����-->
</div>
<!--�麣С˵��������Ϲ������·����ġ����ڰ����ַ�֪ʶ��Ȩ���°������÷�������������������<br />
���������ֶν�������������棬Ŀǰ��ع��������Ѿ�ץ����������15�������������վ����ֹͣ��Ȩ��Ϊ��--><div class="pt5 dn"><script type="text/javascript" src="'.$this->_tpl_vars['jieqi_local_url'].'/js/tj.js"></script><script type="text/javascript" src="'.$this->_tpl_vars['jieqi_local_url'].'/scripts/gb.js"></script></div>
';
if($this->_tpl_vars['_REQUEST']['controller']=='channel'){
echo '<div class="ad4"><script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/js/2.js"></script></div>';
}
echo '
';
if($this->_tpl_vars['_REQUEST']['controller']=='index'){
echo '<div class="ad4"><script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/js/3.js"></script></div>';
}
echo '
';
if($this->_tpl_vars['_REQUEST']['controller']=='reader'){
echo '<div class="ad4"><script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/js/4.js"></script></div>';
}
echo '

</div>';
if($this->_tpl_vars['_REQUEST']['controller']!='articleinfo' && $this->_tpl_vars['_REQUEST']['controller']!='index' && $this->_tpl_vars['_REQUEST']['controller']!='reader'){
echo '<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16","bdCustomStyle":"'.$this->_tpl_vars['jieqi_themeurl'].'style/slide_share.css"},"slide":{"type":"slide","bdImg":"2","bdPos":"right","bdTop":"250"}};with(document)0[(getElementsByTagName(\'head\')[0]||body).appendChild(createElement(\'script\')).src=\'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=\'+~(-new Date()/36e5)];</script>';
}
echo '
';
?>