
window.isChromeApp = window.chrome && window.chrome.storage ? !0 : !1;
window.Store = function() {var t = {}; if (isChromeApp) {e = !1; return {set: function(i, r) {t[i] = r, e || (e = !0, setTimeout(function() {e = !1; try {chrome.storage.sync.set(t, function() {}); } catch(i) {console.log("Failed to save :("); } }, 3e3)); }, get: function(e, i) {return t[e] ? t[e] : void chrome.storage.sync.get(e, function(e) {for (var r in e) t[r] = e[r]; i && i(); }); }, remove: function(e) {delete t[e], chrome.storage.sync.remove(e, function(t) {}); } }; } i = function() {try {return "localStorage" in window && null !== window.localStorage; } catch(t) {return ! 1; } } (); return i ? {set: function(e, i) {t[e] = i; try {localStorage.setItem(e, i); } catch(r) {} }, get: function(e, i) {return i && i(), t[e] ? t[e] : localStorage.getItem(e); }, remove: function(t) {return localStorage.removeItem(t); } }: {set: function() {}, get: function(t, e) {e && e(); }, remove: function() {} }; } ();

/**
 * ��ȡ·��
 * @param  {[type]} arr [description]
 * @return {[type]}     [description]
 */
function getUrl(arr,start,end){  // js
  var ar=location.pathname.split('/');
  start=start || 1;
  end=end || 2;
  ar= ar.slice(start, end);
  Array.prototype.push.apply(ar, arr); 
  return 'http://'+location.host+'/'+ar.join("/");
}


var Users = {
  msgStyle: 'background-color:#333; color:#fff; text-align:center; border:none; font-size:20px; padding:10px;',
   
  /**
   * ���͵���ʱ
   */
  RegSmsWait: function () {
    if (Users.se > 0) {
      Users.q_btnv.val("���·���(" + Users.se + ")");
      Users.se--;
      setTimeout(Users.RegSmsWait, 1000);
    }else {
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
      time: t
    });
  },

  // �ύ��
  FormSubmit:function(e){
    var da=$(this).data("da");
    e.preventDefault();
    Users.form=this;
    Users.msg_err=false;
    if(da.fn_f)da.fn_f();
    if( Users.checkeError()) return false;
    da.fn=da.fn || function(msg){                 
      if(msg.status === 'OK'){
        location.href=msg.jumpurl;
      }else{
        Users.ShowMsg(msg.msg);
      }
    };
    Users.SendForm(da.fn);
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

  checkeError: function () {
     if( Users.msg_err !== false ){
        Users.ShowMsg();
        return true;
      }
      return false;
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

  checkCheckcode: function (name,l) {
    var v;
    l=l||3;
    if(Users.msg_err)return false;
    v = Users.form.elements[name].value;
    if ( v.length < l ){
      Users.msg_err ='��֤��С��'+l+'λ����';
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


/*---�б�ҳjs ��ʼ---------------------------------------------------------------------------*/
$(function(){
  if(typeof q_main==="undefined" )return false;
  if(typeof GLO_D==="undefined"  )window.GLO_D={"filter":{}};
  // �޸�����
  q_main.find('.fieldRev').live('click',fieldRevFn);
  q_main.find('.fieldRev').each(function(){$(this).prop('title','����޸�����'); });

});

// �޸�����
function fieldRevFn(){
  var nu=25;
  var q_input=$("<input type='text'></allEles>"), q_this=$(this),o_v,v,url,q_par;
  q_input.css({
    'width':q_this.width()+nu,
    'height':q_this.height(),
    'padding':'9px 0',
    'font-weight':q_this.css('font-weight')
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
      GLO_D.filter.field_v=v; 
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
}

// �ύ�޸ĺʹ���
function post_fieldRev(q_this,fun){
  GLO_D.filter.field_y=q_this.attr('_y');
  GLO_D.filter.field_i=q_this.parents('tr').attr('_i');
  $.post(GLO_D.fieldRev_url,$.extend(GLO_D.filter,{ac:'setPa','ajax_request':1}),fun,'json'); // jq
}



/*----Ԫ���----------------------------------------------------------------------------------------------------------------------*/
 

if( !Store.get("new_ear_day_show") ){
  $(function(){
    if( location.href.search(/\/login/i) !== -1 )return false;
    html=' <div class="hide_box" id="new_ear_day_box" style="display: none; margin: 0px;width: 350px;"> <h4 style="margin:0;"><a href="javascript:void(0)" title="x" id="new_ear_day_close">��</a>������ֳɡ���ȷ������ʽ����!</h4><a href="/help/notes?id=3"><img id="new_ear_day_img" style="max-width: 350px;" src="/themes/tuike/img/new_ear_day.jpg" alt=""></a></div>';
    $('body').append(html);
    easyDialog.open({
      "container": 'new_ear_day_box',
    });

    showFunc();
    function showFunc(){ // jq
      if( $('#new_ear_day_img:visible').size() ===0 ){             
        setTimeout(showFunc,10);
        return false;
      }

      var h=document.documentElement.clientHeight;//
      var h_img=$('#new_ear_day_img').height();

      if( h-h_img < 23 ){
        $('#new_ear_day_img').css('maxHeight',h-23);
        $('#new_ear_day_box').css('maxWidth',$('#new_ear_day_img').width());
      }
      var h1=-$('#dialog_box').outerHeight(true)/2;
      var h2=-$('#dialog_box').height()/2;
      h=h1<h2?h1:h2;
      $('#dialog_box').css('marginTop',h );

      $('#new_ear_day_close').click(function() {             
        easyDialog.close();
      });
    }
  });
  Store.set("new_ear_day_show", 1 );
}

/*----Ԫ���----------------------------------------------------------------------------------------------------------------------*/
 


/*----����֪ͨ----------------------------------------------------------------------------------------------------------------------*/
if( !Store.get("new_year_day_show") ){
    $(function(){
      if( location.href.search(/\/login/i) !== -1 )return false;
      var str='<div class="hide_box" id="to_alert" style="display: none; margin: 0px;box-shadow: 0 0 5px #ddd;">'+
            '<h4 style="text-align: center;height: 40px;line-height: 40px;font-size: 20px;"><a href="javascript:void(0)" title="x" id="close_alert">��</a>���ڳ������������ֹ���</h4>'+
            '<p style="padding-bottom: 0;">�𾴵Ŀͻ���</p>'+
            '<p style=" padding-bottom: 0; text-indent: 2em;">����!</p>'+
            '<p style=" text-indent: 2em;">��2017��01��23���������Ʒֳ�ƽ̨�ƹ���������ʱ����ͳ���ڳ��ٹ�ϵ��ͣ���ַ���2��6�տ�ʼ�ָ����֡�ƽ̨���๦��������ת�����������Ĳ��㣬�����½⣡���������λ�������ݸ����꣡Ԥף2017׬����������</p>'+
            '<p >���Ͼ���֪Ϥ�� лл��</p>'+
            '<p style="text-align: right;">��������Ƽ��ɷ����޹�˾</p>'+
            '<p style="text-align: right;padding-right: 37px;">2017��01��17��</p>'+
            '<div style="margin: 10px auto;width: 13%;">'+
            '<button class="u-btn u-btn-primary" id="btn-know">֪����</button>'+ 
            '</div>'+
        '</div>';
      $('body').append(str);
      easyDialog.open({container: 'to_alert'});
      $('#close_alert').click(function() {
        easyDialog.close();
      });
      $('#btn-know').click(function() {
       easyDialog.close();
      });
      $('#overlay').live('click',function(){
       easyDialog.close();
      });
  });
  Store.set("new_year_day_show", 1 );
}
/*----����֪ͨ----------------------------------------------------------------------------------------------------------------------*/


 
/*----����֪ͨ-С˵���-----------------------------------------------------------------------------------------------------------*/
if( !Store.get("new_year_day_show_w") ){
    $(function(){
      if( location.href.search(/\/login/i) !== -1 )return false;
      var str='<div class="hide_box" id="to_alert" style="display: none; margin: 0px;box-shadow: 0 0 5px #ddd;">'+
            '<h4 style="text-align: center;height: 40px;line-height: 40px;font-size: 20px;"><a href="javascript:void(0)" title="x" id="close_alert">��</a>����С˵��ֵ�����֪ͨ</h4>'+
            '<p style="padding-bottom: 0;">�𾴵Ŀͻ���</p>'+
            '<p style=" padding-bottom: 0; text-indent: 2em;">����!</p>'+
            '<p style=" text-indent: 2em;">��λ������֪Ϥ������С˵�����ڴ����ڼ����߷�˿��С˵��ֵ�Żݻ���ڳ�Ϧ�������ܹ�7��Ļʱ�䣨����鵽���洦�꿴������������ڼ�ʱ��ֵ��������������ƹ���������ǰ֪ͨ�������λ���������ʱ�����ƹ㣬���뷭����</p>'+
            '<p style="text-align: right;">��������Ƽ��ɷ����޹�˾</p>'+
            '<p style="text-align: right;padding-right: 37px;">2017��01��20��</p>'+
            '<div style="margin: 10px auto;width: 13%;">'+
            '<button class="u-btn u-btn-primary" id="btn-know">֪����</button>'+ 
            '</div>'+
        '</div>';
      $('body').append(str);
      easyDialog.open({container: 'to_alert'});
      $('#close_alert').click(function() {
        easyDialog.close();
      });
      $('#btn-know').click(function() {
       easyDialog.close();
      });
      $('#overlay').live('click',function(){
       easyDialog.close();
      });
  });
  Store.set("new_year_day_show_w", 1 );
}
/*----����֪ͨ-С˵���-----------------------------------------------------------------------------------------------------------*/
 
 


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