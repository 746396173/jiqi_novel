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



/*---�б�����ɸѡ ��ʼ-----------------------------------------------------------------------------------------------------------------*/

var j_screen_sort;
var get_content_run_after_fn;
$(function(){

  j_screen_sort=window.document.getElementById("screen_sort"); 
  if( j_screen_sort ){

    get_content_run_after_fn=function(){intScreeSelect();};
    intScreeSelect(j_screen_sort);
    $('#screen_sort').live('change',function(){
        var v,q_this=$(this);
        v=q_this.val();
        if( v.indexOf('time') !== -1 ){
          $('.screen_op').hide();
          $('.screen_time').show();
        }else{

          $('.screen_op').hide();
          $('.screen_text').show();
        }
    });
  }

});


/**
 * ����ת�ɼ�ֵ�ԣ��Ķ���
 * @param  {[type]} form [description]
 * @return {[type]}      [description]
 */
function getFormJson(form) {
  var o = {};
  var a = $(form).serializeArray();
  $.each(a, function () {
    if (o[this.name] !== undefined) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
    } else {
      o[this.name] = this.value || '';
    }
  });
  return o;
}


/**
 * ɸѡ�ύ��
 * @param  {[type]} j_this [description]
 * @return {[type]}        [description]  jq
 */
function screenFormSubmit(j_this){

  $('.screen_op:hidden :input').val('').removeAttr('checked').removeAttr('selected'); // ��λ
  filter=$.extend(filter,getFormJson(j_this)); // jq
  filter.page=1;
  get_content(location.href,function(){intScreeSelect();});

}



/**
 * ���ѡ��
 * @param {[type]} obj  [description]
 * @param {[type]} j_to [description]
 */
function setOption(obj,j_to){
  var i,op;
  op = window.document.createElement("OPTION"); 
  op.value = obj.v; 
  op.innerHTML = obj.h; 
  j_screen_sort.appendChild(op); 
}

/**
 * ��ʼselect
 * @return {[type]} [description]
 */
function intScreeSelect(j_this){

  j_screen_sort=j_this||window.document.getElementById("screen_sort"); 

  j_screen_sort.options.length = 0;

  $('.sortOr').each(function(index){
    var _z,q_this=$(this);
    _z=q_this.attr('_z');
    setOption({v:_z,h:q_this.html()},j_screen_sort);
  });

       
  if( typeof filter !== 'undefined' && typeof filter.screen_sort !== 'undefined' ){
    if( filter.screen_sort.indexOf('time') !== -1 ){
      $('.screen_op').hide();
      $('.screen_time').show().find('input[name=screen_t1]').val(filter.screen_t1);
      $('.screen_time').find('input[name=screen_t2]').val(filter.screen_t2);
    }else{

      $('.screen_op').hide();
      $('.screen_text').show().find('input').val(filter.screen_text);
    }
    
    $(j_screen_sort).find("option[value='"+filter.screen_sort+"']").attr("selected",true);

  }

}






/*---�б�����ɸѡ ����-----------------------------------------------------------------------------------------------------------------*/




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

  // �޸ĵ�ѡ״̬
  q_main.find('.static_img').live('click',function(){
    var q_this=$(this),url,img;
    filter.field_v=1-q_this.attr('_v');  
    post_fieldRev(q_this,function(data){
      if(data.status === 'OK'){
        img=filter.field_v === 1?'yes1.gif':'no1.gif';
        q_this.prop('src',baseImgUrl+img);
        q_this.attr('_v',filter.field_v);    
      }else{
        Users.ShowMsg(data.msg);
      }
    });
  });

});


// �ύ�޸ĺʹ��� js
function post_fieldRev(q_this,fun){
  var ar;
  filter.field_y=q_this.attr('_y');
  filter.field_i=q_this.parents('tr').attr('_i');
  ar=location.pathname.split('/');
  $.post('http://'+location.host+'/'+ar['1']+'/'+ar['2']+'/ajax',
    $.extend(filter,{ac:q_this.attr('_ac'),'ajax_request':1}),fun,'json'); // jq
}
// ��ȡ���ݺʹ���
function get_content(url,fn){
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
    if(fn)fn();
    if(get_content_run_after_fn)get_content_run_after_fn();
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
  var q_this=$(this),img=q_this.attr('_v') === '1'?'yes1.gif':'no1.gif';
  q_this.prop('src',baseImgUrl+img).prop('title','����޸�״̬').show();
  });
  q_main.find('.fieldRev').each(function(){$(this).prop('title','����޸�����'); });
}
/*---�б�ҳjs ����---------------------------------------------------------------------------*/

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




// ���ʱ��
$.datetimepicker.setLocale('ch');
/**
 * ��ʱ���¼�
 * @param  {[type]} j_this [description]
 * @return {[type]}        [description]
 */
function datetimepickerRun(j_this,format){
  format=format || "Y-m-d H:i";
  if( !j_this.runDate ){
    var dataS=j_this.value.length > 5?j_this.value:formatDate();
    j_this.runDate=1;
    $(j_this).datetimepicker({
      lang: "ch", 
      format:format, 
      value: dataS,
      step: 10
    });
    $(j_this).focus();
  }
}


/**
 * ��ʽ������
 * @param  {[type]} format [description]
 * @param  {[type]} date   [description]
 * @return {[type]}        [description]
 */
function formatDate(format,date){
  if( !date )date = new Date();
  var paddNum = function(num){
    return num>9?num:'0'+num;
  };
  //ָ����ʽ�ַ�
  var cfg = {
    yyyy : date.getFullYear(), //�� : 4λ
    yy : date.getFullYear().toString().substring(2),//�� : 2λ
    M  : date.getMonth() + 1,  //�� : ���1λ��ʱ�򲻲�0
    MM : paddNum(date.getMonth() + 1), //�� : ���1λ��ʱ��0
    d  : date.getDate(),   //�� : ���1λ��ʱ�򲻲�0
    dd : paddNum(date.getDate()),//�� : ���1λ��ʱ��0
    hh : date.getHours(),  //ʱ
    mm : date.getMinutes(), //��
    ss : date.getSeconds(), //��
  };
  if( !format )format = "yyyy-MM-dd hh:mm:ss";
  return format.replace(/([a-z])(\1)*/ig,function(m){return cfg[m];});
} 




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