$(function(){
	// �ύ�¼�
	$("#j_submit").on("click", function(){
		var _back_url = $("a[data-act=act]").attr("href");
		var _form = $("#j_form");
		var _url = _form.attr("data-url");
		var _sname = $("input[name=sname]");
		var _markname = $("input[name=markname]");
		var _name = $("input[name=name]");
		var _compos = $("input[name=compos]");
		var _locked = $("input[name=locked]");
		// ��������֤
		if (_sname.val()=="" || _sname.val().length>25) {
			layer.msg("����������������Ϊ�ջ򳬹�25����");
			_sname.focus();
			return false;
		} else if (_markname.val()=="" || _markname.val().length>25) {
			layer.msg("��ʶ�ַ�����Ϊ�ջ򳬹�25����");
			_markname.focus();
			return false;
		} else if (_name.val()=="" || _name.val().length>25) {
			layer.msg("��¼������Ϊ�ջ򳬹�25����");
			_name.focus();
			return false;
		} else if (_compos.val()=="" || _compos.val().length>2) {
			layer.msg("����ֻ��ʹ��0~99������");
			_markname.focus();
			return false;
		} else {
			// ��֤ͨ�����ύ����
			GPage.postForm('j_form', _url, function(data){
				if (data.status=="OK") {
					// TODO::�ɹ���ת
					 window.location.href = _back_url;
				} else {
					// TODO::ʧ����ʾ
					layer.msg(data.msg,1,1);
				}
			})
		}
	})
	
	// ��ʾ����
	$("span[data-pw-act=act]").on("click", function(){
		var _pw = $(this).attr("data-pw");
		$(this).removeClass().html(_pw);
	})
	
	// ɾ����¼
	$("a[data-act=delete]").on("click", function(){
		var _this_tr = $(this).parent().parent();
		var _url = $(this).attr("data-url");
		var _id = _this_tr.attr("data-id");
		GPage.getJson(_url+"&sid="+_id, function(data){
			if (data.status=="OK") {
				_this_tr.remove();
				layer.msg("ɾ���ɹ�");
			} else {
				layer.alert(data.msg);
			}
		})
	})
	
	// ����䶯����
	$("input[name=byorder]").on("change", function(){
		var _value = $(this).val();
		var _ovalue = $(this).attr("data-ori");
		if (_value != _ovalue) {
			$(this).attr("data-act", "change");
		} else {
			$(this).attr("data-act", "none");
		}
	})
	
	// �����޸�����
	$("a[data-act=order]").on("click", function(){
		var _url = $(this).attr("data-url");
		var _params = "";
		// ���û�и�������ֹ�����¼�
		if ($("input[name=byorder][data-act=change]").index() < 0) {
			return false;
		}
		$.each($("input[name=byorder][data-act=change]"), function(i,n){
			var _id = $(n).parent().parent().attr("data-id");
			var _val = $(n).val();
			if (_val<0){_val=0}
			if (_val>99){_val=99}
			_params += "&sid_"+_id+"="+_val;
		})
		GPage.getJson(_url+_params, function(data){
			if (data.status=="OK") {
				location.reload();
			} else {
				layer.msg(data.msg);
			}
		})
	})
	layer.ready(function(){
		$('#login_form').bind('valid.form', function(e){
			e.preventDefault();
			GPage.postForm('login_form', this.action,function(data){
					if(data.status=='OK'){
						jumpurl(data.jumpurl);
					}else{
						layer.msg(data.msg);
						if(data.msg == '�Բ���У�������'){
							$("[name='checkcode']").focus();
						}else if(data.msg == '���������ע����ĸ��Сд�Ƿ�������ȷ����'){
							$("[name='password']").focus();
						}else if(data.msg =='���û������ڣ���ע����ĸ��Сд�Ƿ�������ȷ��'){
							$("[name='username']").focus();
						}
					}
			   });
		});
	});
})
















