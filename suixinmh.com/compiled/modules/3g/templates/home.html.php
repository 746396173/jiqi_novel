<?php
$this->_tpl_vars['meta_keywords'] = 'С˵,�ÿ���С˵,С˵��,С˵�Ƽ�,���С˵';
echo '
';
$this->_tpl_vars['jieqi_pagetitle'] = "{$this->_tpl_vars['jieqi_sitename']}-���С˵,����С˵,��ÿ���С˵�Ƽ�";
echo '
';
$this->_tpl_vars['meta_description'] = "{$this->_tpl_vars['jieqi_sitename']}Ϊ���Ӱ������ԭ��С˵�Ż�,Ҳ������Ǳ��������С˵��վ,{$this->_tpl_vars['jieqi_sitename']}ÿ��ӵ�к������С˵����,��������С˵,��ԽС˵,����С˵,����С˵,����С˵,����С˵,�ֲ�С˵,����С˵,��ʷС˵�ȸ�������С˵�����Ķ�,���������ڻ㼯�˷�����,������ѧʢ��,���ÿ���С˵�Ƽ�������,����ÿ�������С˵��վ��";
echo '
<style>
    ul img{ 

            width:90px!important;
            height:120px!important;;
     }
</style>
';
$_template_tpl_vars = $this->_tpl_vars;
 $this->_template_include(array('template_include_tpl_file' => 'themes/3g/search.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
<div class="mt10 bgcfff">
            
    <div class="mlf10 ptb10 f16" style="color: #1fb3b6;">�����Ƽ�</div>
    '.jieqi_geturl('system', 'tags', array('id'=>363, 'name'=>'%5B%D0%C2%B0%E6WAP%5D%5B%CA%D7%D2%B3%5D%5B%C8%C8%C3%C5%CD%C6%BC%F6%5D')).'
    <div class="ptb10 bt bcddd plf10">
        '.jieqi_geturl('system', 'tags', array('id'=>364, 'name'=>'%5B%D0%C2%B0%E6WAP%5D%5B%CA%D7%D2%B3%5D%5B%C8%C8%C3%C5%CD%C6%BC%F6%CE%C4%D7%D6%5D')).'
    </div>
</div>
<div class="mt10 bgcfff">
    <h1 class="mlf10 ptb10 f16" style="color: #1fb3b6;" >���л���</h1>
    '.jieqi_geturl('system', 'tags', array('id'=>365, 'name'=>'%5B%D0%C2%B0%E6WAP%5D%5B%CA%D7%D2%B3%5D%5B%B6%BC%CA%D0%BB%E9%D2%F6%5D')).'
    <div class="f14">
        '.jieqi_geturl('system', 'tags', array('id'=>366, 'name'=>'%5B%D0%C2%B0%E6WAP%5D%5B%CA%D7%D2%B3%5D%5B%B6%BC%CA%D0%BB%E9%D2%F6%CE%C4%B1%BE%5D')).'
    </div>
</div>
<div class="mt10  bgcfff">
    <h1 class="mlf10 ptb10 f16" style="color: #1fb3b6;">�����ܲ�</h1>
    '.jieqi_geturl('system', 'tags', array('id'=>367, 'name'=>'%5B%D0%C2%B0%E6WAP%5D%5B%CA%D7%D2%B3%5D%5B%BA%C0%C3%C5%D7%DC%B2%C3%5D')).'
    <div class="f14">
        '.jieqi_geturl('system', 'tags', array('id'=>368, 'name'=>'%5B%D0%C2%B0%E6WAP%5D%5B%CA%D7%D2%B3%5D%5B%BA%C0%C3%C5%D7%DC%B2%C3%CE%C4%B1%BE%5D')).'
    </div>
</div>
<div class="mt10  bgcfff">
    <div class="mlf10 ptb10 f16" style="color:#1fb3b6;">����ר��</div>
    '.jieqi_geturl('system', 'tags', array('id'=>369, 'name'=>'%5B%D0%C2%B0%E6WAP%5D%5B%CA%D7%D2%B3%5D%5B%B4%F3%C9%F1%D7%A8%C7%F8%5D')).'
</div>
<div class="mt10 bgcfff">
    <div class="mlf10 ptb10 f16" style="color:#1fb3b6;">�걾ר��</div>
    '.jieqi_geturl('system', 'tags', array('id'=>370, 'name'=>'%5B%D0%C2%B0%E6WAP%5D%5B%CA%D7%D2%B3%5D%5B%CD%EA%B1%BE%D7%A8%C7%F8%5D')).'
</div>

';
?>