$(function(){
//******�������ģ�飺START******
	// ��װһ���༭ͼ�㺯��
	var formTips = function(showUrl, id, type) {
		GPage.getJson(showOneUrl+"&type="+type+"&tid="+id, function(data){
			if (data.status=="OK") {
				var _form = $($('#J_add_form')[0]);
				_form.find("input[name=taskid]").val(data.msg.taskid);
				_form.find("input[name=taskname]").val(data.msg.taskname);
				_form.find("textarea[name=description]").val(data.msg.description);
				_form.find("select[name=type]").val(data.msg.type);
				_form.find("tr").eq(2).after(data.msg.ruleForm);
				if(_form.find(".sign_option")!='') {
					_form.find("tr").eq(2).after(data.msg.rewardsForm);
				} else {
					_form.find(".sign_option").after(data.msg.rewardsForm);
				}
				if(data.msg.isshow == 0){
					_form.find("input[name=isshow]").eq(1).attr('checked','checked');
					_form.find("input[name=isshow]").eq(0).removeAttr('checked');
				}else{
					_form.find("input[name=isshow]").eq(0).attr('checked','checked');
					_form.find("input[name=isshow]").eq(1).removeAttr('checked');
				}
				layer.autoArea(0);
			} else {
				layer.msg(data.msg);
			}
		})
	}
	
	var this_layer;
	
	// �������ť
	$("#add_task").on("click", function(){
		$('#J_add_form')[0].reset();
		$(".sign_option").remove();
		$("#J_task_submit").attr("data-url", addFormUrl);
		this_layer = $.layer({
			type : 1,
			area : ['600px', 'auto'],
			title : '���һ���µ�����',
			offset : ['30px' , '50%'],
//			zIndex : 1,
			page : {dom : '#J_add_task'},
			close : function(index){
				layer.close(index);
				$('.ul_con').hide();
			}
		});
	});
	// �༭����ť
	$(".J_edit_task").on("click", function(){
		$('#J_add_form')[0].reset();
		$(".sign_option").remove();
		var tid = $(this).parent().attr("data-id");
		var type = $(this).parent().attr("data-type");
		formTips(showOneUrl, tid, type);
		$("#J_task_submit").attr("data-url", editFormUrl);
		$.layer({
			type : 1,
			area : ['600px', 'auto'],
			title : '�༭һ������',
			offset : ['30px' , '50%'],
//			zIndex : 1,
			page : {dom : '#J_add_task'},
			close : function(index){
				layer.close(index);
				$('.ul_con').hide();
			}
		});
	});
	// ɾ������ť
	$(".J_del_task").on("click", function(){
		var tid = $(this).parent().attr("data-id");
		var _this_tr = $(this).parent().parent();
		layer.confirm('����һ��ɾ���򲻿ɻָ���ȷ��ɾ����', function(){
		   	GPage.getJson(delFormUrl+"&taskid="+tid, function(data){
				if (data.status=="OK") {
					layer.closeAll();
					layer.msg('�����ɹ�', 1, 1);
					_this_tr.remove();
				} else {
					layer.closeAll();
					layer.msg(data.msg);
				}
			});
		}, 'ȷ��ɾ��', function(){
			layer.closeAll();
		});
//		$.layer({
//		    shade: [0],
//		    area: ['auto','auto'],
//		    dialog: {
//		        msg: '����һ��ɾ���򲻿ɻָ���ȷ��ɾ����',
//		        btns: 2,                    
//		        type: 4,
//		        btn: ['ȷ��','ȡ��'],
//		        yes: function(){
//			        	GPage.getJson(delFormUrl+"&taskid="+tid, function(data){
//						if (data.status=="OK") {
//							layer.closeAll();
//							layer.msg('�����ɹ�', 1, 1);
//							_this_tr.remove();
//						} else {
//							layer.closeAll();
//							layer.msg(data.msg);
//						}
//					})
////		            layer.msg('��Ҫ', 1, 1);
//		        }, no: function(){
//		          	layer.closeAll();
//		        }
//		    }
//		});
	})

	
	// �첽��ȡ���������б�
	$("#J_task_type").on("change", function(){
		var typeName = $(this).val();
		var _this = $(this);
		console.log(this_layer);
		if (typeName == 0) {
			$(".sign_option").remove();
			layer.autoArea(this_layer);
			return false;
		}
		GPage.getJson(typeUrl+"&type="+typeName, function(data){
			if (data.status=="OK") {
				$(".sign_option").remove();
				_this.parent().parent().after(data.msg);
				layer.autoArea(this_layer);
			} else {
				layer.msg(data.msg);
			}
		})
	})
	
/*	var checkForm = function (selor,name){
	  var task = $(""+selor+"[name='"+name+"']");
	  var this_length = arguments[2] ? arguments[2] : 0;
	  if(name == 'type' && task.val() == 0){
		alert('��ѡ����������');
		return false;
	  }else if(task.val() == "" || task.val().length > this_length && name != 'type'){
		alert('����Ϊ�ջ򳬹�'+this_length+'����');
		task.focus();
		return false;
	  }
	  return true;
	}*/
	
	function check_form(){
		this.check = function(selor,name){
			this.task = $(""+selor+"[name='"+name+"']");
			this.this_length = arguments[2] ? arguments[2] : 0;
		  if(name == 'type' && this.task.val() == 0){
			alert('��ѡ����������');
			return false;
		  }else if(this.task.val() == "" || this.task.val().length > this.this_length && name != 'type'){
			alert('����Ϊ�ջ򳬹�'+this.this_length+'����');
			this.task.focus();
			return false;
		  }
		  return true;
		}
	}
	
	// �ύһ���������¼�/�༭
	$("#J_task_submit").on("click", function(){
		var thisUrl = $(this).attr("data-url");
		if($("#grade_type").length>0){
			if($("#grade_type").val()=='isvip'){
				$("#score input").val('').remove();
			}else if($("#grade_type").val()=='score'){
				$("#isvip input").val('').remove();
			}
		}
	  /*var task_name = $("input[name='taskname']");
		var task_description = $("textarea[name='description']");
		var task_type = $("select[name='type']");*/
		var check = new check_form();
		//alert(check.this_length);
		if(!check.check("input","taskname",10)) return false;
		if(!check.check("textarea","description",300)) return false;
		if(!check.check("select","type")) return false;
		/*if (!checkForm("input","taskname",10)) return false;
		if (!checkForm("textarea","description",300)) return false;
		if (!checkForm("select","type")) return false;*/
		
		GPage.postForm('J_add_form', thisUrl, function(data){
			
			if (data.status=="OK") {
//				layer.closeAll();
//				layer.msg('�����ɹ�', 1, 1);
				location.reload();
			} else {
				layer.msg(data.msg);
			}
		})
	})
	
	// �ȼ������ж�����
	$("#grade_type").live("change", function(){
		var typeName = $(this).val();
		var _this = $(this);
		if (typeName == 'score') {
			$("#score").show();
			$("#isvip").hide();
//			$(".sign_option").remove();
			layer.autoArea(this_layer);//this_
			return false;
		}else if(typeName == 'isvip'){
			$("#score").hide();
			$("#isvip").show();
			layer.autoArea(this_layer);//this_
			return false;
		}
	})
//******�������ģ�飺END******

//******������ģ�飺START******
	// �������ť
	$("a[data-act=add_question]").on("click", function(){
		$('#J_add_form')[0].reset();
		$("p[data-p=articlename]").val("");
		$("#J_question_submit").attr("data-url", addFormUrl);
		this_layer = $.layer({
			type : 1,
			area : ['auto', 'auto'],
			title : '�������Ŀ',
			offset : ['30px' , '50%'],
			page : {dom : '#J_add_question'},
			close : function(index){
				layer.close(index);
				$('.ul_con').hide();
			}
		});
	});
	
	// �༭����ť
	$("a[data-act=edit]").on("click", function(){
		var _id = $(this).parent().parent("tr").attr("data-id");
		var _form = $('#J_add_form')[0];
		$("#J_question_submit").attr("data-url", editFormUrl);
		_form.reset();
		// ��װ�༭ҳ��
		GPage.getJson(urlParams(showOneUrl, "qid="+_id), function(data){
			if (data.status=="OK") {
				// �ؽ��༭�б�
//				var _questionnumber = 0;
//				for (key in data.msg.options) {
//					_questionnumber++;
//				}
//				var _htmls = "";
				$($(_form).find("textarea[name=question]")).val(data.msg.question);
//				$(_form).find("select[name=questionnumber]").val(_questionnumber);
//				if (_questionnumber>=3 && $("tr[data-option=3]").length<=0) {
//					_htmls += '<tr data-option="3"><th class="td_title">ѡ��C</th><td class="td_contents"><input class="text" style="width: 200px" type="text" name="options[3]"/>&nbsp;&nbsp;<input type="radio" name="rightoption" value="3" /></td><td class="td_span"><span></span></td></tr>';
//					$("tr[data-option=4]").remove();
//				}
//				if (_questionnumber==4 && $("tr[data-option=4]").length<=0) {
//					_htmls += '<tr data-option="4"><th class="td_title">ѡ��D</th><td class="td_contents"><input class="text" style="width: 200px" type="text" name="options[4]"/>&nbsp;&nbsp;<input type="radio" name="rightoption" value="4" /></td><td class="td_span"><span></span></td></tr>';
//				}
//				if (_questionnumber==2) {
//					$("tr[data-option=3]").remove();
//					$("tr[data-option=4]").remove();
//				}
//				$("tr[data-option=2]").after(_htmls);
				$.each(data.msg.options, function(i, n){
					$(_form).find("tr[data-option="+i+"]").find("input:text").val(n);
				})
				$(_form).find("input[name=rightoption][value="+data.msg.rightoption+"]").attr("checked", true);
				$(_form).find("input[name=aid]").val(data.msg.aid);
				$(_form).find("p[data-p=articlename]").html("��"+data.msg.articlename+"��");
				$(_form).find("input[name=qid]").val(_id);
			} else {
				layer.msg(data.msg);
				return false;
			}
		})
		$("input[name=aid]").val(_id);
		
		this_layer = $.layer({
			type : 1,
			area : ['auto', 'auto'],
			title : '�༭�������',
			offset : ['30px' , '50%'],
			page : {dom : '#J_add_question'},
			close : function(index){
				layer.close(index);
				$('.ul_con').hide();
			}
		});
		layer.autoArea(this_layer);
	});
	
	// Ԥ������
	$("a[data-act=showone]").on("click", function(){
		var _id = $(this).parent().parent("tr").attr("data-id");
		var _htmls = "";
		GPage.getJson(urlParams(showOneUrl, "qid="+_id), function(data){
			if (data.status=="OK") {
				_htmls += "<p style='font-weight: 700'>"+data.msg.question+"</p><hr />";
				$.each(data.msg.options, function(i, n){
					if (data.msg.rightoption == i) {
						_htmls += "<p style='color:green'>ѡ��"+i+"��";
					} else {
						_htmls += "<p>ѡ��"+i+"��";
					}
					_htmls += n+"</p>";
				})
				layer.alert(_htmls, 4, !1);
			} else {
				layer.msg(data.msg);
			}
		})
	})
	
	// ɾ������
	$("a[data-act=del]").on("click", function(){
		var _this_tr = $(this).parent().parent("tr");
		var _id = _this_tr.attr("data-id");
			layer.confirm('����һ��ɾ���򲻿ɻָ���ȷ��ɾ����', function(){
				GPage.getJson(urlParams(delFormUrl, "qid="+_id), function(data){
				if (data.status=="OK") {
					_this_tr.remove();
					layer.msg("ɾ���ɹ�", 1, 1);
				} else {
					layer.msg(data.msg);
				}
			})
		})
	})
	
	// ѡ����֤
	$("input[name=rightoption]").on("change", function(){
		if ($.trim($(this).prev("input").val())=='') {
			layer.alert("��ѡ��û������");
			$(this).removeAttr("checked");
		}
	})
	
	// ���ѡ������
//	$("select[data-act=questionnumber_change]").on("change", function(){
//		var _this = $(this);
//		var _htmls_options = $("tr[data-option]");
//		var _htmls = "";
//		if (_this.val()=="2") {
//			$("tr[data-option=3]").children().children("input:text").attr("readonly", "readonly").removeAttr("name");
//			$("tr[data-option=4]").children().children("input:text").attr("readonly", "readonly").removeAttr("name");
//			$("tr[data-option=3]").children().children("input:text").attr("placeholder", "����ѡ").val("");
//			$("tr[data-option=4]").children().children("input:text").attr("placeholder", "����ѡ").val("");
//		} else if (_this.val()=="3") {
//			if ($("tr[data-option=3]").length<=0) {
//				$("tr[data-option=3]").children().children("input:text").attr("name", "options[3]").removeAttr("readonly");
//			}
//			$("tr[data-option=4]").children().children("input:text").attr("readonly", "readonly").removeAttr("name");
//			$("tr[data-option=4]").children().children("input:text").attr("placeholder", "����ѡ").val("");
//		} else if (_this.val()=="4") {
//			if ($("tr[data-option=3]").length<=0) {
//				$("tr[data-option=3]").children().children("input:text").attr("name", "options[3]").removeAttr("readonly");
//			}
//			if ($("tr[data-option=4]").length<=0) {
//				$("tr[data-option=4]").children().children("input:text").attr("name", "options[3]").removeAttr("readonly");
//			}
//		}
////		_htmls_options.last().after(_htmls);
////		layer.autoArea(this_layer);
//	})
	
	// ����鼮ID�ķ��ط���
	$("input[data-act=articleid_change]").on("focusout", function(){
		var _aid = $(this).val();
		if (_aid!="") {
			GPage.getJson(urlParams(checkUrl,"aid="+_aid), function(data){
				if (data.status=="OK") {
					$("p[data-p=articlename]").html("��"+data.msg+"��");
				} else {
					$("p[data-p=articlename]").html("���鼮ID������");
				}
			})
		}
	})
	
	// ����/�༭����
	$("#J_question_submit").on("click", function(){
		var _url = $(this).attr("data-url");
//		var _form = $("#J_add_form");
		GPage.postForm('J_add_form', _url, function(data){
			if (data.status=="OK") {
//				layer.msg('����ɹ�', 1, 1);
				location.reload();
			} else {
				layer.msg(data.msg);
			}
		})
	})
//******������ģ�飺END******
})





















