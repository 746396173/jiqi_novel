<?php
echo '<table align="center" cellpadding="2" cellspacing="1" class="grid" width="100%">
	<caption>标签管理</caption>
	<tr>
		<td><a href=\''.$this->_tpl_vars['adminprefix'].'\' class="button">返回标签列表</a>
		</td>
	</tr>
</table>
<form name="myform" method="post" action="'.$this->_tpl_vars['adminprefix'].'&method=addData">
	<table cellpadding="2" cellspacing="1" class="grid" width="100%">
		<caption>添加标签</caption>
		<tr>
			<th style="width: 20%;"><strong>分类名称</strong></th>
			<td style="width: 50%;"><input type="text" name="name" placeholder="例：文章" /></td>
			<td style="width: 30%;color: red;">*名称不能超过20个字</td>
		</tr>
		<tr>
			<th style="width: 20%;"><strong>所述模块</strong></th>
			<td style="width: 50%;"><input type="text" name="module" placeholder="例：article" /></td>
			<td style="width: 30%;color: red;">*模块只能使用半角英文</td>
		</tr>
		<tr>
			<th style="width: 20%;"><strong>分类描述</strong></th>
			<td style="width: 50%;">
				<textarea name="description" cols="60" rows="10" style="resize:none;"></textarea>
				<p data-name="size_p">最多可以写<b style="font-weight: 700;color: #a31000;">80</b>个字，当前还能写&nbsp;<span style="font-weight: 700;color: #a31000;">80</span>&nbsp;个字</p>
			</td>
			<td style="width: 30%;color: red;">*文字不能超过80个字</td>
		</tr>
		<tr>
			<th style="width: 20%;"></th>
			<td style="width: 50%;">
				<input type="submit" name="next" value=" 添加 ">&nbsp;&nbsp;
				<input type="reset" name="reset" value=" 重置 ">
			</td>
			<td style="width: 30%;color: red;"></td>
		</tr>
	</table>
</form>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/base.positiontype.admin.js"></script>';
?>