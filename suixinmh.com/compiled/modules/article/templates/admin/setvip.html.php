<?php
echo '<style type="text/css">
.layer_notice{float:left; height:75px; width:170px;  overflow:hidden; display:none;  background:#78BA32; padding:10px; border:1px solid #628C1C;}
</style>
<!--<form action="'.geturl('article','chapter','SYS=method=delChapters').'" method="post" name="checkform" id="checkform">-->
<table class="grid" width="100%" align="center">
<caption>��'.$this->_tpl_vars['articlename'].'��</caption>
<tr><td colspan="7">˵����<br />1�����ܣ����Խ�֮ǰ���½���Ϊvip��������V�󷢲����½��Զ���V����<br />2���������vip������½�<span class="red">֮��</span>��<span class="red">����</span>�½ڣ��������£��������Ѿ���V���½ڣ�������Ϊvip�½ڣ��½ڼ۸������Զ����ɣ�ͬʱ��<span class="red">������V</span>���������Ѿ���V�����£���<br />3���־��Ѿ���V�½ڲ������á�</td></tr>
  <tr align="center">
    <th width="10%">����</th>
    <th width="10%">�½����</th>
    <th width="30%">�½�����</th>
    <th width="10%">����</th>
    <th width="10%">�۸�</th>
	<th width="10%">״̬</th>
    <th width="20%">����/����</th>
  </tr>
  ';
if (empty($this->_tpl_vars['chapterrows'])) $this->_tpl_vars['chapterrows'] = array();
elseif (!is_array($this->_tpl_vars['chapterrows'])) $this->_tpl_vars['chapterrows'] = (array)$this->_tpl_vars['chapterrows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['chapterrows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['chapterrows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['chapterrows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['chapterrows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['chapterrows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptertype'] >0){
echo ' style="background-color:#eee;"';
}else{
echo ' onmouseover="this.style.backgroundColor=\'#DDF2FF\';" onmouseout="this.style.backgroundColor=\'#ffffff\';"';
}
echo '>
    <td align="center">';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptertype']<1&&$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['isvip']<1){
echo '<a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=article&method=setvip&cid='.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'" target="_blank" class="set">����vip</a>';
}
echo '</td>
    <td align="center">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterorder'].'</td>
    <td>';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptertype'] == 0){
echo '<a href="'.geturl('article','reader','SYS=aid='.$this->_tpl_vars['aid'].'&cid='.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chapterid'].'').'" target="_blank">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptername'].'</a>';
}else{
echo '<b>'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['chaptername'].'</b>';
}
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['isvip']>0){
echo '<img src="'.$this->_tpl_vars['jieqi_local_url'].'/images/vip.gif" border="0" />';
}
echo '</td>
    <td align="center">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['size_c'].'</td>
    <td align="center">'.$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['saleprice'].'</td>
	<td align="center">';
if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 0){
echo '����';
}else if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 1){
echo '<span class="blue">����</span>';
}else if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 2){
echo '<span class="green">��ʱ</span>';
}else if($this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['display'] == 9){
echo '<span class="org">��ʱ����</span>';
}
echo '</td>
    <td align="center">'.date('Y-m-d H:i:s',$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['lastupdate']).'<br>'.date('Y-m-d H:i:s',$this->_tpl_vars['chapterrows'][$this->_tpl_vars['i']['key']]['postdate']).'</td>
  </tr>
  ';
}
echo '
</table>
<!--</form>-->
<script language="javascript">
layer.ready(function(){
//	$(".set").click(function(){
//		event.preventDefault();
//		var i = layer.load();//layer.load(0);
//		GPage.getJson(urlParams(this.href),
//			function(data){
//			    if(data.status==\'OK\'){			    	
//					GPage.loadpage(\'content\', data.jumpurl, true, false);
//					layer.closeAll();
//				}else{
//					layer.alert(data.msg, 8, !1);
//				}
//			}
//		);
//	});
//	$("[agentclick]").live(\'click\',function(event){
//		event.preventDefault();
//		var id = $(\'#tmpid\').val();
//		var i = layer.load();//layer.load(0);
//		GPage.getJson(urlParams(this.href, \'id=\'+id),
//			function(data){
//			    if(data.status==\'OK\'){			    	
//					GPage.loadpage(\'content\', data.jumpurl, true, false);
//					layer.closeAll();
//				}else{
//					layer.alert(data.msg, 8, !1);
//				}
//			}
//		);
//	});			 
});
</script>';
?>