<?php
echo '<table align="center" cellpadding="2" cellspacing="1" class="grid" width="100%">
	<caption>��ǩ����</caption>
	<tr>
		<td><a href=\''.$this->_tpl_vars['adminprefix'].'\' class="button">���ر�ǩ�б�</a>
		</td>
	</tr>
</table>
<form name="myform" method="post" action="'.$this->_tpl_vars['adminprefix'].'&method=addData">
	<table cellpadding="2" cellspacing="1" class="grid" width="100%">
		<caption>���ӱ�ǩ</caption>
		<tr>
			<th style="width: 20%;"><strong>��������</strong></th>
			<td style="width: 50%;"><input type="text" name="name" placeholder="��������" /></td>
			<td style="width: 30%;color: red;">*���Ʋ��ܳ���20����</td>
		</tr>
		<tr>
			<th style="width: 20%;"><strong>����ģ��</strong></th>
			<td style="width: 50%;"><input type="text" name="module" placeholder="����article" /></td>
			<td style="width: 30%;color: red;">*ģ��ֻ��ʹ�ð��Ӣ��</td>
		</tr>
		<tr>
			<th style="width: 20%;"><strong>��������</strong></th>
			<td style="width: 50%;">
				<textarea name="description" cols="60" rows="10" style="resize:none;"></textarea>
				<p data-name="size_p">������д<b style="font-weight: 700;color: #a31000;">80</b>���֣���ǰ����д&nbsp;<span style="font-weight: 700;color: #a31000;">80</span>&nbsp;����</p>
			</td>
			<td style="width: 30%;color: red;">*���ֲ��ܳ���80����</td>
		</tr>
		<tr>
			<th style="width: 20%;"></th>
			<td style="width: 50%;">
				<input type="submit" name="next" value=" ���� ">&nbsp;&nbsp;
				<input type="reset" name="reset" value=" ���� ">
			</td>
			<td style="width: 30%;color: red;"></td>
		</tr>
	</table>
</form>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/base.positiontype.admin.js"></script>';
?>