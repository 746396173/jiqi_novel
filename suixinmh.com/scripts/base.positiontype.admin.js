$(function(){
	// ȫ�ֳ�ʼ��
	var description_size = $("[data-name=size_p] b") ? $("[data-name=size_p] b").html() : 100;
	var less_size = $("[data-name=size_p] span");
	// ��ʼ�༭�е�����
	var init_size = $("textarea[name=description]").val().length;
	less_size.html(description_size-init_size);
	// �����ǰ����֤
	$("form[name=myform]").live("submit", function(){
		var _name = $("input[name=name]").val();
		var _module = $("input[name=module]").val();
		var _description = $("textarea[name=description]").val();
		var en_preg = new RegExp("^[a-zA-Z1-9]{1,20}$");
		if (_name.length<=0 || _name.length>20) {
			layer.alert("�������Ʊ�����1~20����֮��");
			return false;
		}
		if (!en_preg.test(_module)) {
			layer.alert("����ģ��ֻ��ʹ��1~20��Ӣ��");
			return false;
		}
		if (_description.length>80) {
			layer.alert("�����������ֲ��ܳ���80����");
			return false;
		}
	})
	// ��������������������
	$("textarea[name=description]").live("keydown", function(){
		var _this_size = $("textarea[name=description]").val().length;
		var _less = description_size - _this_size;
		less_size.html(_less);
	})
})
