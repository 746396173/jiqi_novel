<?php
echo '<link href="'.$this->_tpl_vars['jieqi_themeurl'].'style/user.css" type="text/css" rel="stylesheet" />
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
 $this->_template_include(array('template_include_tpl_file' => 'templates/membertab.html', 'template_include_vars' => array()));
 $this->_tpl_vars = $_template_tpl_vars;
 unset($_template_tpl_vars);
echo '
	  <ul id="tab_conbox" class="f0">
	  <li class="fix" style="display:none;">
         <div class="tips2 p10">����ǰΪVIP����Ϊ<em class="org"> '.$this->_tpl_vars['_USER']['vipgrade'].'  </em>��Ա����ǰ�ɳ�ֵ<em class="org"> '.$this->_tpl_vars['_USER']['vip'].' </em>��   </div>
         <div class="member">
          <h3>VIP�ɳ���ϵ</h3>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabl4 g6">
            <tr class="bgt">
             <th scope="col">vip�ȼ�</th>
             ';
if (empty($this->_tpl_vars['vipgrade'])) $this->_tpl_vars['vipgrade'] = array();
elseif (!is_array($this->_tpl_vars['vipgrade'])) $this->_tpl_vars['vipgrade'] = (array)$this->_tpl_vars['vipgrade'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['vipgrade']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['vipgrade']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['vipgrade']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['vipgrade']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['vipgrade']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
            	 <th scope="col"><em class="'.$this->_tpl_vars['vipgrade'][$this->_tpl_vars['i']['key']]['photo'].'"></em></th>
			 ';
}
echo '
            </tr>
            <tr>
             <td align="center" valign="middle">�ɳ�ֵҪ��</td>
             ';
if (empty($this->_tpl_vars['vipgrade'])) $this->_tpl_vars['vipgrade'] = array();
elseif (!is_array($this->_tpl_vars['vipgrade'])) $this->_tpl_vars['vipgrade'] = (array)$this->_tpl_vars['vipgrade'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['vipgrade']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['vipgrade']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['vipgrade']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['vipgrade']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['vipgrade']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
             	<td align="center" valign="middle">';
if($this->_tpl_vars['vipgrade'][$this->_tpl_vars['i']['key']]['minscore'] >0){
echo ' '.$this->_tpl_vars['vipgrade'][$this->_tpl_vars['i']['key']]['minscore'];
}else{
echo '0';
}
echo '</td>
             ';
}
echo '
            </tr>
            <tr>
             <td colspan="8" align="left" valign="middle">
              <dl class="how_jf fix">
               <dt>��λ��VIP�ɳ�ֵ?</dt>
               <dd>ÿ��ֵ1Ԫ���100��VIP�ɳ�ֵ</dd>
               <!--<dd>ÿ����100��һ��2�����</dd>
               <dd>ÿͶ1����Ʊ���2�����</dd>-->
              </dl>
             </td>
            </tr>
            </table>
          <h3>�� �� �� Ȩ</h3>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabl4 g6">
            <tr class="bgt f14">
             <th width="222" align="center" valign="middle" scope="col"></th>
             <th width="137" align="center" valign="middle" scope="col">vip0</th>
             <th width="137" align="center" valign="middle" scope="col">vip1</th>
             <th width="137" align="center" valign="middle" scope="col">vip2</th>
             <th width="137" align="center" valign="middle" scope="col">vip3</th>
             <th width="137" align="center" valign="middle" scope="col">vip4</th>
             <th width="137" align="center" valign="middle" scope="col">vip5</th>
			 <th width="137" align="center" valign="middle" scope="col">vip6</th>
            </tr>
            <tr>
             <td width="222" align="center" valign="middle">��Ա���ּ���</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['0']['jifenjiasu']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip'][$this->_tpl_vars['0']['key']]['jifenjiasu']*100; 
echo '%';
}
echo '</td> 
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['1']['jifenjiasu']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['1']['jifenjiasu']*100; 
echo '%';
}
echo '</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['2']['jifenjiasu']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['2']['jifenjiasu']*100; 
echo '%';
}
echo '</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['3']['jifenjiasu']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['3']['jifenjiasu']*100; 
echo '%';
}
echo '</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['4']['jifenjiasu']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['4']['jifenjiasu']*100; 
echo '%';
}
echo '</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['5']['jifenjiasu']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['5']['jifenjiasu']*100; 
echo '%';
}
echo '</td>
			 <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['6']['jifenjiasu']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['6']['jifenjiasu']*100; 
echo '%';
}
echo '</td>
            </tr>
            <tr>
             <td width="222" align="center" valign="middle">�����ۿ�</td>
          	 <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['0']['dingyuezhekou']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip'][$this->_tpl_vars['0']['key']]['dingyuezhekou']*10; 
echo '��';
}
echo '</td> 
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['1']['dingyuezhekou']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['1']['dingyuezhekou']*10; 
echo '��';
}
echo '</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['2']['dingyuezhekou']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['2']['dingyuezhekou']*10; 
echo '��';
}
echo '</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['3']['dingyuezhekou']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['3']['dingyuezhekou']*10; 
echo '��';
}
echo '</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['4']['dingyuezhekou']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['4']['dingyuezhekou']*10; 
echo '��';
}
echo '</td>
             <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['5']['dingyuezhekou']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['5']['dingyuezhekou']*10; 
echo '��';
}
echo '</td>
			 <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['6']['dingyuezhekou']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['6']['dingyuezhekou']*10; 
echo '��';
}
echo '</td>
            </tr>
            <tr>
             <td width="222" align="center" valign="middle">������Ʊ<br />�����¶�����';
echo ceil($this->_tpl_vars['configs']['article']['vipvotes'])/100; 
echo 'Ԫ�ɻ�ã�1��/�£�</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['0']['baodiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip'][$this->_tpl_vars['0']['key']]['baodiyuepiao'].'��';
}
echo '</td> 
              <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['1']['baodiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['1']['baodiyuepiao'].'��';
}
echo '</td>
              <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['2']['baodiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['2']['baodiyuepiao'].'��';
}
echo '</td>
              <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['3']['baodiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['3']['baodiyuepiao'].'��';
}
echo '</td>
              <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['4']['baodiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['4']['baodiyuepiao'].'��';
}
echo '</td>
              <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['5']['baodiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['5']['baodiyuepiao'].'��';
}
echo '</td>
			  <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['6']['baodiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['6']['baodiyuepiao'].'��';
}
echo '</td>
            </tr>
            <tr>
             <td width="222" align="center" valign="middle">������Ʊ<br />��ÿ������';
echo ceil($this->_tpl_vars['configs']['article']['vipvegold'])/100; 
echo 'Ԫ�ɵã������ޣ�</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['0']['xiaofeiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip'][$this->_tpl_vars['0']['key']]['xiaofeiyuepiao'].'��';
}
echo '</td> 
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['1']['xiaofeiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['1']['xiaofeiyuepiao'].'��';
}
echo '</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['2']['xiaofeiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['2']['xiaofeiyuepiao'].'��';
}
echo '</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['3']['xiaofeiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['3']['xiaofeiyuepiao'].'��';
}
echo '</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['4']['xiaofeiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['4']['xiaofeiyuepiao'].'��';
}
echo '</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['5']['xiaofeiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['5']['xiaofeiyuepiao'].'��';
}
echo '</td>
			   <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['6']['xiaofeiyuepiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['6']['xiaofeiyuepiao'].'��';
}
echo '</td>
            </tr>
            <tr>
             <td width="222" align="center" valign="middle">VIPר��ͼ��</td>
             <td width="137" align="center" valign="middle">��</td>
             <td colspan="6" align="center" valign="middle">��ͬVIP�ȼ���Ա��ӵ�и���ר���ſ�ͼ��Ŷ��</td>
             </tr>
            <tr>
             <td width="222" align="center" valign="middle">ÿ�������Ƽ�Ʊ</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['0']['tuijianpiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip'][$this->_tpl_vars['0']['key']]['tuijianpiao'].'��';
}
echo '</td> 
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['1']['tuijianpiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['1']['tuijianpiao'].'��';
}
echo '</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['2']['tuijianpiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['2']['tuijianpiao'].'��';
}
echo '</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['3']['tuijianpiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['3']['tuijianpiao'].'��';
}
echo '</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['4']['tuijianpiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['4']['tuijianpiao'].'��';
}
echo '</td>
               <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['5']['tuijianpiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['5']['tuijianpiao'].'��';
}
echo '</td>
			   <td width="137" align="center" valign="middle">';
if($this->_tpl_vars['vip']['6']['tuijianpiao']==0){
echo '��';
}else{
echo $this->_tpl_vars['vip']['6']['tuijianpiao'].'��';
}
echo '</td>
            </tr>
            <tr>
             <td width="222" align="center" valign="middle">����������Ȩ</td>
             <td width="137" align="center" valign="middle">?</td>
             <td width="137" align="center" valign="middle">?</td>
             <td width="137" align="center" valign="middle">?</td>
             <td width="137" align="center" valign="middle">?</td>
             <td width="137" align="center" valign="middle">?</td>
             <td width="137" align="center" valign="middle">?</td>
			 <td width="137" align="center" valign="middle">?</td>
            </tr>
            </table>
         </div>
        </li>
	</ul>
	</div>
  </div>
</div>';
?>