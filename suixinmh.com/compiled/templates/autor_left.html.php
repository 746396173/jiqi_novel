<?php
echo '  <div class="left fl ov">
    <div class="left_h"><a href="'.$this->_tpl_vars['jieqi_modules']['article']['url'].'/myarticle.php"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/modules/article/templates/style/images/left_bg_h.jpg" width="195" height="45" /></a></div>
    <div class="left_m">
      <div class="menu_zzjs_1">
        <div class="tit_zzjs_net">
          <h3><a href="'.$this->_tpl_vars['jieqi_modules']['article']['url'].'/masterPage">��Ʒ����</a></h3>
        </div>
        <div class="txt_zzjs_net">
          <ul>
            <li><a href="'.$this->_tpl_vars['jieqi_modules']['article']['url'].'/step1View">������Ʒ</a></li>
            <li><a href="'.$this->_tpl_vars['jieqi_modules']['article']['url'].'/masterPage">��Ʒ����</a></li>
            <!--<li><a href="'.$this->_tpl_vars['article_static_url'].'/ytuijian.php">�����Ƽ�</a></li>-->
            <!--<li><a href="'.$this->_tpl_vars['article_static_url'].'/yqiany.php">����ǩԼ</a></li>-->
            <!--<li><a href="'.$this->_tpl_vars['article_static_url'].'/ymyapply.php">�ҵ�����</a></li>-->
            <!--<li><a href="'.$this->_tpl_vars['article_static_url'].'/newdraft.php">��ʱ����</a></li>  -->
          </ul>
        </div>
      </div>
      <!--menu_zzjs_1-->
      <div class="menu_zzjs_1">
        <div class="tit_zzjs_net">
          <h3><a href="javascript:showmenu_zzjs(3);">�ҵ���Ʒ</a></h3>
        </div>
        <div class="txt_zzjs_net">
          <ul>
            ';
if (empty($this->_tpl_vars['articlerows'])) $this->_tpl_vars['articlerows'] = array();
elseif (!is_array($this->_tpl_vars['articlerows'])) $this->_tpl_vars['articlerows'] = (array)$this->_tpl_vars['articlerows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['articlerows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['articlerows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['articlerows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['articlerows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['articlerows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
            <li><a href="'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['url_articleinfo'].'">'.$this->_tpl_vars['articlerows'][$this->_tpl_vars['i']['key']]['articlename'].'</a></li>
            ';
}
echo '
          </ul>
        </div>
      </div>
      <!--menu_zzjs_1-->
      <div class="menu_zzjs_1">
        <div class="tit_zzjs_net">
          <h3><a href="#">����Աͨ��</a></h3>
        </div>
        <div class="txt_zzjs_net">
          <ul>
            <li><a href="#">�ҵĶ�����</a></li>
            <li><a href="#">��ϵ����Ա</a></li>
          </ul>
        </div>
      </div>
      <!--menu_zzjs_1-->
      <div class="menu_zzjs_1">
        <div class="tit_zzjs_net">
          <h3><a href="#">�������</a></h3>
        </div>
        <div class="txt_zzjs_net">
          <ul>
            <!--<li><a href="'.$this->_tpl_vars['article_static_url'].'/writerinfo.php">ǩԼ������Ϣ</a></li>-->
            <li><a href="#">����ͳ��</a></li>
            <li><a href="#">��������ѯ</a></li>
          </ul>
        </div>
      </div>
      <!--menu_zzjs_1-->
      <div class="menu_zzjs_1">
        <div class="tit_zzjs_net">
          <h3><a href="#">��վ��Ϣ</a></h3>
        </div>
        <div class="txt_zzjs_net">
          <ul>
            <li><a href="#">��վ����</a></li>
            <li><a href="'.$this->_tpl_vars['jieqi_local_url'].'">������վ��ҳ</a></li>
            <li><a href="'.$this->_tpl_vars['jieqi_user_url'].'/logout">�˳���½</a></li>
          </ul>
        </div>
      </div>
      <!--menu_zzjs_1--> 
    </div>
    <div class="left_f"><img src="'.$this->_tpl_vars['jieqi_local_url'].'/modules/article/templates/style/images/left_bg_f.jpg" width="223" height="66" /></div>
  </div>';
?>