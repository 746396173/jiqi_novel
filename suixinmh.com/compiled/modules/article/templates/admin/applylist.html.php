<?php
echo '<div class="gridtop">���������¼&nbsp;&nbsp;&nbsp; <a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=apply">ȫ����¼</a> | <a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=apply&display=ready">�����¼</a> | <a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=apply&display=success">�����¼</a> | <a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=apply&display=failure">���ܼ�¼</a></div>
<table class="grid" width="100%" align="center">
  <tr align="center">
    <th width="18%">����ʱ��</th>
    <th width="15%">������</th>
    <th width="18%">���ʱ��</th>
    <th width="15%">�����</th>
    <th width="10%">���״̬</th>
    <th width="10%">��������</th>
    <th width="14%">����</th>
  </tr>
  ';
if (empty($this->_tpl_vars['rows'])) $this->_tpl_vars['rows'] = array();
elseif (!is_array($this->_tpl_vars['rows'])) $this->_tpl_vars['rows'] = (array)$this->_tpl_vars['rows'];
$this->_tpl_vars['i']=array();
$this->_tpl_vars['i']['columns'] = 1;
$this->_tpl_vars['i']['count'] = count($this->_tpl_vars['rows']);
$this->_tpl_vars['i']['addrows'] = count($this->_tpl_vars['rows']) % $this->_tpl_vars['i']['columns'] == 0 ? 0 : $this->_tpl_vars['i']['columns'] - count($this->_tpl_vars['rows']) % $this->_tpl_vars['i']['columns'];
$this->_tpl_vars['i']['loops'] = $this->_tpl_vars['i']['count'] + $this->_tpl_vars['i']['addrows'];
reset($this->_tpl_vars['rows']);
for($this->_tpl_vars['i']['index'] = 0; $this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['loops']; $this->_tpl_vars['i']['index']++){
	$this->_tpl_vars['i']['order'] = $this->_tpl_vars['i']['index'] + 1;
	$this->_tpl_vars['i']['row'] = ceil($this->_tpl_vars['i']['order'] / $this->_tpl_vars['i']['columns']);
	$this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['order'] % $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['column'] == 0) $this->_tpl_vars['i']['column'] = $this->_tpl_vars['i']['columns'];
	if($this->_tpl_vars['i']['index'] < $this->_tpl_vars['i']['count']){
		list($this->_tpl_vars['i']['key'], $this->_tpl_vars['i']['value']) = each($this->_tpl_vars['rows']);
		$this->_tpl_vars['i']['append'] = 0;
	}else{
		$this->_tpl_vars['i']['key'] = '';
		$this->_tpl_vars['i']['value'] = '';
		$this->_tpl_vars['i']['append'] = 1;
	}
	echo '
  <tr style="background-color:pink;">
    <td class="odd" align="center">'.date('Y-m-d H:i',$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applytime']).'
    </td>
    <td class="even"><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyuid'].'').'" target="_blank">'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyname'].'</a></td>
    <td class="odd">
    	';
if($this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['authtime'] != 0){
echo '
    		'.date('Y-m-d H:i',$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['authtime']).'
    	';
}
echo '
    </td>
    <td class="even"><a href="'.geturl('system','userhub','method=userinfo','uid='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['authuid'].'').'" target="_blank">'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['authname'].'</a></td>
    <td class="odd" align="center">
    	';
if($this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyflag'] == 0){
echo '
    		<span class="blue">����</span>
    	';
}elseif($this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyflag'] == 1){
echo '
    		����
    	';
}else{
echo '
    		<span class="green">�ܾ�</span>
    	';
}
echo '
    </td>
    <td class="even" align="center"><a href="javascript:;" onclick="showChapter('.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyid'].');">����鿴</a></td>
    <div style="display:none;" id="ap_'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyid'].'">'.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applytext'].'</div>
    <td class="odd" align="center">
    	';
if($this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyflag'] == 0){
echo '
    		<a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=apply&action=audit&display='.$this->_tpl_vars['display'].'&applyuid='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyuid'].'&aid='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyid'].'">���</a> 
    		<a href="'.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=apply&action=refusal&display='.$this->_tpl_vars['display'].'&aid='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyid'].'">�ܾ�</a> 
    	';
}
echo '
    		<a href="javascript:if(confirm(\'ȷʵҪɾ���������¼ô��\')) document.location=\''.$this->_tpl_vars['article_dynamic_url'].'/admin/?controller=apply&action=del&display='.$this->_tpl_vars['display'].'&aid='.$this->_tpl_vars['rows'][$this->_tpl_vars['i']['key']]['applyid'].'\'">ɾ��</a></td>
  </tr>
  ';
}
echo '
</table>
<div class="pages">'.$this->_tpl_vars['url_jumppage'].'</div>
<script>
function showChapter(ap_id){
 	$.layer({
 	    type: 1,
 	    title: false,
 	   //	fix: false,
 	    area: [\'600px\', \'600px\'],
 	    offset: [\'20px\' , \'\'],
 	    //shade: [0],
 	    page: {
 	        //dom: \'#ap_\'+ap_id
 	       html:\'<div style="width:600px;height:600px;overflow-y:scroll;">\'+$(\'#ap_\'+ap_id).text()+\'</div>\'
 	    }
 	});
}
</script>';
?>