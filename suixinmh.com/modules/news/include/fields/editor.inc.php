<script type="text/javascript" src="<?=$attachurl?>/lib/html/fckeditor/fckeditor.js"></script>
		<script language="JavaScript" type="text/JavaScript">
			var SiteUrl = "<?=$attachurl?>/modules/news/";
			var sBasePath = "<?=$attachurl?>/lib/html/" + 'fckeditor/';
			var oFCKeditor = new FCKeditor('<?=$this->field?>');
			oFCKeditor.BasePath = sBasePath;
			var Module = '<?=$this->formobj->model['tablename']?>';
			var catid  = '<?=$catid?>';
			oFCKeditor.Height = '<?=$this->setting['height']?>';
			oFCKeditor.Width = '<?=$this->setting['width']?>';
			oFCKeditor.ToolbarSet = '<?=$this->setting['toolbar']?>';
			oFCKeditor.ReplaceTextarea();
			//editor_data_id += '<?=$this->field?>|';
			//if (typeof(MM_time) == 'undefined') {
				//MM_time = setInterval(update_editor_data, 30000);
			///}
		</script>
		<div style='width:100%;text-align:left'><?php if($this->setting['openpagetag']){?>
			<span style='float:right;height:22px'>
				<span style='padding:1px;margin-right:10px;background-color: #fefe;border:#006699 solid 1px;'>
					<a href='javascript:insert_page("<?=$this->field?>")' title='�ڹ�괦�����ҳ���'>
						��ҳ
					</a>
				</span>
				<span style='padding:1px;margin-right:10px;background-color: #fefe;border:#006699 solid 1px;'>
					<a href='javascript:insert_page_title("<?=$this->field?>")' title='�ڹ�괦������ӱ���ķ�ҳ���'>
						�ӱ���
					</a>
				</span>
				<span style='padding:1px;margin-right:10px;background-color: #fefe;border:#006699 solid 1px;'>
					<div id='page_title_div' style='background-color: #fff;border:#006699 solid 1px;position:absolute;z-index:10;padding:1px;display:none;right:80px;'>
						<table cellpadding='0' cellspacing='1' border='0' class="grid">
							<tr>
								<td>
									�������ӱ������ƣ�
									<span id='msg_page_title_value'>
									</span>
								</td>
								<td>
									<span style='cursor:pointer;float:right;' onclick='javascript:$("#page_title_div").hide()'>
										��
									</span>
								</td>
								<tr>
									<td colspan='2'>
										<input name='page_title_value' id='page_title_value' value='' size='40'>
										&nbsp;
										<input type='button' value=' ȷ�� ' onclick='insert_page_title( "<?=$this->field?>",1);'>
									</td>
								</tr>
						</table>
					</div>
				</span>
			 
			</span><?php }?>
			<img src="/modules/news/images/editor_add.jpg" title='���ӱ༭���߶�' tag='1' fck="<?=$this->field?>" />
			&nbsp;
			<img src="/modules/news/images/editor_diff.jpg" title='���ٱ༭���߶�' tag='0' fck="<?=$this->field?>" />
		</div>
		<div id="MM_file_list_content" style="text-align:left">
		</div>
		<div id='FilePreview' style='Z-INDEX: 1000; LEFT: 0px; WIDTH: 10px; POSITION: absolute; TOP: 0px; HEIGHT: 10px; display: none;'>
		</div>
		<div id='content_save'>
		</div>