<?php
echo '<link href="'.$this->_tpl_vars['jieqi_local_url'].'/themes/v1/style/mute.css" type="text/css" rel="stylesheet" />
	<div class="tier_con" id="mutediv" style="display: none;">
		<div class="tier_title">����</div>
		<p>��ѡ�����ʱ����</p>
		<div class="tier_x">
			<label><input type="radio" name="time" checked="checked" value="1"/>1�� </label>
			<label><input type="radio" name="time" value="3"/>3��</label>
			<label><input type="radio" name="time" value="7" />7��</label>
			<label><input type="radio" name="time" value="15"/>15��</label>
			<label><input type="radio" name="time" value="30"/>30��</label>
			<label><input type="radio" name="time" value="0"/>����</label>
		</div>
		<div ';
if($this->_tpl_vars['_REQUEST']['controller'] != 'reviews'){
echo 'style="display: none;"';
}
echo '>
			<p >ѡ����Է�Χ��</p>
			<div class="tier_x" >
				<label><input type="radio" name="area" checked="checked" value="0"/>�Ա������</label>
				<label><input type="radio" name="area" value="1"/>ȫվ����</label>
			</div>
		</div>
		<input type="hidden"  id="url_mute"   value="" />
		<input type="button" name="" id="" value="�ύ" class="tierbut" onclick="mute()"/>
	</div>
<script>
//���Ե�����
var muteLayer;
$(function(){ 
	$("a[name=\'mute\']").live({click:function(){
		$("#url_mute").val($(this).attr("url"));
		$("input[name=\'time\'][value=1]").attr("checked",\'checked\');
		$("input[name=\'area\'][value=0]").attr("checked",\'checked\');
		muteLayer = $.layer({
			shade : [0.5 , \'#000\' ],
			type : 1,
//			area : [\'60%\',\'560px\'],
			area : [\'auto\',\'auto\'],
			title : false,
			offset : [\'200px\' , \'50%\'],
			border : [6, 0.5 , \'#000\', true],
			zIndex : 1,
			page: {
		 	       dom: \'#mutediv\'
		 	    },
			close : function(index){
				layer.close(index);
				$(\'.ul_con\').hide();
			}
		});	
	}});
})
//����
function mute(){
	var mute_url = $("#url_mute").val()+\'&mt=\'+$("input[name=\'time\']:checked").val()+\'&area=\'+$("input[name=\'area\']:checked").val();
	var i = layer.load(0);
	
	';
if($this->_tpl_vars['_REQUEST']['controller']=='articleinfo'){
echo '
		var target = \'reviewcontent\';
	';
}else{
echo '
		var target = \'content\';
	';
}
echo '
	GPage.getJson(mute_url,function(data){
		layer.close(i);
	    if(data.status==\'OK\'){
	    	layer.close(muteLayer);//content
			GPage.loadpage(target, data.jumpurl, true,false);
		}else{
			layer.alert(data.msg, 8, !1);
		}
});
}
</script>';
?>