/**
 * $description	: ����ϵͳ������javascript����
 * 				: *��ҪjQuery֧��
 * $copyright	: shuhai@2015-01-13
 * $createtime	: 2015-01-13
 */
$(function(){
	// ***ǰ̨������
	// �û������ɰ�ť
	$(".J_set_finish").on("click", function(){
		var taskid = $(this).attr("data-id");
		var _this = $(this);
		GPage.getJson(urlParams(sendUrl,"tid="+taskid), function(data){
			if (data.status=="OK") {
				layer.msg('������ɸ��������ٽ�������',1,1);
				_this.removeClass();
				_this.addClass("taked");
				_this.html("");
				_this.html("�����");
				_this.off("click");
			} else {
				layer.msg(data.msg);
			}
		})
	})
	

})
