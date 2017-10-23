var Users = {
    msgStyle: 'background-color:#333; color:#fff; text-align:center; border:none; font-size:20px; padding:10px;',
    /**
     * ���͵���ʱ
     */
    RegSmsWait: function () {
        if (Users.se > 0){
            Users.q_btnv.val("���·���(" + Users.se + ")");
            Users.se--;
            setTimeout(Users.RegSmsWait, 1000);
        }else{
            Users.q_btnv.val("���»�ȡ��֤��");
            Users.q_btnv.removeAttr("disabled");
        }
    },
    /**
     * ����ʾ
     * @param {[type]} msg [Ҫ��ʾ����Ϣ]
     */
    ShowMsg:function(msg,t){
        t=t || 2;
        msg=msg ? msg:Users.msg_err;            
        layer.open({
            content: msg,
            style: Users.msgStyle,
            time: 2
        });
    },
    /**
     * �첽�ύ��
     * @param {Function} fn [description]
     */
    SendForm: function (fn) {
        fn=fn ? fn:function(msgs){                 
            if(msgs.status =='OK'){
                location.href=Users.form.elements.jumpurl_u.value;
            }else{
                Users.ShowMsg(msgs.msg);
            }
        };
        $.ajax({ // jq  
            url:$(Users.form).prop('action'),
            type:'post',
            async: false,
            data:$(Users.form).serialize(),
            dataType:'json',
            success:fn
        });
    },
    checkempty: function (name,msg) {
        var v;
        if(Users.msg_err)return false;
        msg=msg || '���������ݣ�';
        v  = Users.form.elements[name].value;
        if ( v.length < 2 ){
            Users.msg_err =msg;
        }
    },
    checkUserName: function (name) {
        var v;
        if(Users.msg_err)return false;
        v  = Users.form.elements[name].value;
        if ( v.length < 2 ){
            Users.msg_err ='�ǳ�С��2���ַ���';
        }else if(v.length > 25){
            Users.msg_err ='�ǳƴ���25���ַ���';
        }
    },
    checkUser: function (name) {
        var v,reg_phone;
        if(Users.msg_err)return false;
        v  = Users.form.elements[name].value;
        reg_phone =/(^(13[0-9]|14[57]|15[012356789]|17[\d]|18[0-9])\d{8}$)|(^170[059]\d{7}$)/;
        if ( v.length < 1){
            Users.msg_err ='�������ֻ����룡';
        }else if(!(reg_phone.test(v))){
            Users.msg_err ='�ֻ����벻��ȷ��';
        }
    },
    checkPassword: function (name) {
        var v;
        if(Users.msg_err)return false;
        v  = Users.form.elements[name].value;
        if ( v.length < 2 ){
            Users.msg_err ='����С��2λ����';
        }
    },
    checkCheckcode: function (name) {
        var v;
        if(Users.msg_err)return false;
        v = Users.form.elements[name].value;
        if ( v.length < 3 ){
            Users.msg_err ='��֤��С��3λ����';
        }
    },
    checkMsgcode: function (name) {
        var v;
        if(Users.msg_err)return false;
        v = Users.form.elements[name].value;
        if ( v.length !== 6){
            Users.msg_err ='������֤��λ������ȷ��';
        }else if(!(/^\d{6}$/.test(v))){
            Users.msg_err ='������֤�벻��ȷ��';
        }
    }
};

// ͳһ���첽��ʾ
$(document).ajaxSend(function(evt, request, settings){
  $("#loading").html('<img src="'+baseImgUrl+'/loading.gif" />');
});
$(document).ajaxComplete(function(evt, request, settings){
  $("#loading").empty();
});


/*---�б�ҳjs ��ʼ---------------------------------------------------------------------------*/
$(function(){
  if(typeof(q_main) == "undefined" )return false;
  show_sort_order_img();
  // �첽��ҳ
  q_main.find('.m-page a').live('click',function(){
    var stL,href=$(this).attr('href');
    if( href.length < 8 )return false;
    stL=href.indexOf('page=')+5;
    filter.page=parseInt(href.slice(stL,stL+4));
    get_content(location.href);
    return false;
  });
  // ���������ִ��
  q_main.find('.sortOr').live('click',function(){
    var q_this=$(this),z=q_this.attr('_z');
    filter.sort=z!==filter.order?'ASC': (filter.sort === 'ASC'?'DESC':'ASC');
    filter.order=z;
    filter.page=1;
    get_content(location.href);
  });
  // �޸�����
  q_main.find('.fieldRev').live('click',function(){
    var nu=25;
    var q_input=$("<input type='text'></allEles>"), q_this=$(this),o_v,v,url,q_par;
    q_input.css({
      'width':q_this.width()+nu,
      'height':q_this.height(),
      'font-size':q_this.css('font-size'),
      'font-weight':q_this.css('font-weight'),
      'color':q_this.css('color')
    });
    o_v=q_this.html();
    q_par=q_this.parent();
    q_par.css('width',parseInt(q_par.css('width'))+1);
    q_this.after(q_input).hide();
    q_input.val((o_v==='(��)'?'':o_v)).select().blur(function(){
      v=q_input.val();
      q_par.css('width','auto');
      q_input.remove();
      if(v.length > 1 && v != o_v && v != '(��)'){
        q_this.html(v).show();
        filter.field_v=v; 
        post_fieldRev(q_this,function(data){
          if(data.status !== 'OK'){
            q_this.html(o_v);
            Users.ShowMsg(data.msg);
          }
        });
      }else{
        q_this.show();
      }
    });
  });



});

// �ύ�޸ĺʹ���
function post_fieldRev(q_this,fun){
  filter.field_y=q_this.attr('_y');
  filter.field_i=q_this.parents('tr').attr('_i');
  $.post('http://'+location.host+'/manager/manuser/ajax',
        $.extend(filter,{ac:'setPa','ajax_request':1}),fun,'json'); // jq
}

// ��ȡ���ݺʹ���
function get_content(url){
  filter.ajax_request=1;
  $.post(url,filter,function(html){
    var obj,ar=html.split("aj||ax");         
    obj=$.parseJSON(ar['0']);              
    if(obj.status==='OK'){
      filter=obj.filter;
      q_main.html( ar['1'] );
      show_sort_order_img();
    }else{
      Users.ShowMsg(obj.msg);
    }
  },'html');
}
// ��ʾ��ǰ�����ͼƬ,ѭ����ʾ״̬
function show_sort_order_img(){
  $('#sortOrImg').remove();
  q_main.find('.sortOr').each(function(){
    var q_this=$(this);
    if( q_this.attr('_z') === filter.order){
      q_this.after('<img id="sortOrImg" src="'+baseImgUrl+'sort_'+
        filter.sort+'.gif" />');
    }
  });
  q_main.find('.static_img').each(function(){
    var q_this=$(this),img=q_this.attr('_v') === '1'?'yes.gif':'no.gif';
    q_this.prop('src',baseImgUrl+img).prop('title','����޸�״̬').show();
  });
  q_main.find('.fieldRev').each(function(){$(this).prop('title','����޸�����'); });
}
/*---�б�ҳjs ����---------------------------------------------------------------------------*/




/**
 * ����һ��cookie
 * @param  {[type]} name  [description]
 * @param  {[type]} value [description]
 * @param  {[type]} days  [description]
 * @return {[type]}       [description]
 */
function createCookie(name, value, days,domnai) {
    var expires,date;
    if (days) {
        date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        expires = "; expires="+date.toGMTString();
    }else{
        expires = "";
    }
    domnai=domnai||'';         
    document.cookie = name+"="+value+expires+domnai+";path=/";//domain=.chanel.com;path=/
} 
/**
 * ��ȡһ��cookie
 * @param  {[type]} name [description]
 * @return {[type]}      [description]
 */
function readCookie(name) {
    var nameEQ,ca,i,c;
    nameEQ = name + "=";
    ca = document.cookie.split(';');
    for(i=0;i < ca.length;i++) {
        c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
//eraseCookie('compare');
//eraseCookie('selecook');
/**
 * ɾ��һ��cookie
 * @param  {[type]} name [description]
 * @return {[type]}      [description]
 */ 
function eraseCookie(name,domnai) {
    domnai=domnai||'';
    createCookie(name, "", -1,domnai);
}