<?php
$this->_tpl_vars['jieqi_pagetitle'] = "�û�ע��-{$this->_tpl_vars['jieqi_sitename']}";
echo '<link rel="stylesheet" rev="stylesheet" href="'.$this->_tpl_vars['jieqi_themeurl'].'style/login.css" type="text/css" media="all" />
<link rel="stylesheet" href="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.css" />
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/jquery.validator.js"></script>
<script type="text/javascript" src="'.$this->_tpl_vars['jieqi_url'].'/scripts/validator-0.7.0/local/zh_CN.js"></script>
<div class="box_mid fix">
  <div class="regist fix">
    <h4>�û�ע��</h4>
    <div class="step"></div>
    <div class="box_form">
	<div id="result_14" class="tip-ok" style="display:none"></div>
     <form id="signup_form" class="signup" action="'.geturl('system','register').'" autocomplete="off" data-validator-option="{theme:\'simple_right\'}" >
<fieldset class="fix">
    <div class="form-item">
        <div class="field-name">�û�����</div>
        <div class="field-input">
          <input type="text" name="username" maxlength="30" autocomplete="off"  data-rule="�û���: required;username;remote['.geturl('system','register','SYS=method=checkUser').']" />
        </div>
    </div>
    <div class="form-item">
        <div class="field-name">���䣺</div>
        <div class="field-input">
          <input type="text" name="email" maxlength="40" autocomplete="off"  data-rule="����: required;email;remote['.geturl('system','register','SYS=method=checkEmail').']" />
        </div>
    </div>
    <div class="form-item">
        <div class="field-name">���룺</div>
        <div class="field-input">
          <input type="password" name="password" value="" autocomplete="off"  data-rule="����: required;password;" />
        </div>
    </div>
    <div class="form-item">
        <div class="field-name">ȷ�����룺</div>
        <div class="field-input">
          <input type="password" name="repassword" value="" autocomplete="off" data-rule="ȷ������: required;match(password);" />
        </div>
    </div>
    <div class="form-item">
        <div class="field-name">��֤�룺</div>
        <div class="field-input">
          <input type="text" name="checkcode" autocomplete="off" class="yzm" />
          <img src="'.$this->_tpl_vars['url_checkcode'].'" class="pic" id="checkcode" /><a id="recode" class="f_org2 pl10" onclick="$(\'#checkcode\').attr(\'src\',\''.$this->_tpl_vars['url_checkcode'].'?rand=\'+Math.random());" href="javascript:;">��һ��</a>
        </div>          
    </div>
    <div class="form-item">
     <div class="f12 g6 xy">
     <input type="checkbox" checked="checked" name="interest[]" class="check" data-rule="checked[1]" />�����Ķ���ͬ��<a href="javascript:void(0)" onclick="shxy()" class="f_blue">��'.$this->_tpl_vars['jieqi_sitename'].'�û�Э�顷</a>
     </div>
    </div>
    
    </div>
    <input type="hidden" name="jumpurl" value="'.$this->_tpl_vars['jumpurl'].'">
	<input type="hidden" name="formhash" value="';
echo form_hash(); 
echo '" />
    <div class="cl"><input id="btn-submit" name="dosubmit" class="btn-sn" type="submit" value="����ע��"></div>
</fieldset>
</form>
    </div>
  <div class="remark">   
    <div class="t">����'.$this->_tpl_vars['jieqi_sitename'].'�ʺţ� <a href="'.geturl('system','login').'" class="dl">�� ¼</a><p class="other f_blue">������¼��ʽ��<a href="javascript:;" id="otherlogin"><em></em>QQ��¼</a></p></div>
    <dl>
     <dt>ע���Ϊ'.$this->_tpl_vars['jieqi_sitename'].'��Ա������ӵ�У�</dt>
     <dd>&middot;ӵ�к�������ղظ���ͼ��</dd>
     <dd>&middot;Ͷ�Ƽ�Ʊ��ϲ����С˵,֧�����ߴ���</dd>
     <dd>&middot;����ΪVIP,�½ڶ������Ż�</dd>
     <dd>&middot;�����Ա,��õ��ϼ���Ʒ��㿴</dd>
    </dl>
    <dl>
     <dt class="tt">�ͷ�����</dt>
     <dd>����ʱ�䣺9:00-17:30</dd>
     <dd>����Q Q ��724171887</dd>
     <dd>����Q Q ��724171887</dd>
     <dd>΢�Ź��ں� pinshunet</dd>
     <!--<dd>�ͷ����䣺sxshuhai@qq.com</dd>-->
     <!--<dd>�������䣺sxshuhai@qq.com</dd>-->
    </dl>
  </div>
  </div>
</div><!--box_mid end-->
<!--�û�Э�� ������-->
<div id="cont" style="display:none;">
    	<h1>'.$this->_tpl_vars['jieqi_sitename'].'��Э��</h1>
		<p>
    	��ֻ�������������������з��������������'.$this->_tpl_vars['jieqi_sitename'].'��ע���ʺ�
		</p>
		<p>
		1. �ر���ʾ
		<br />'.$this->_tpl_vars['jieqi_sitename'].'��ͬ�ⰴ�ձ�Э��Ĺ涨���䲻ʱ�����Ĳ��������ṩ���ڻ���������ط���(���³�"�������")��Ϊ���������񣬷���ʹ����(���³�"�û�")ͬ�ⱾЭ���ȫ���������ҳ���ϵ���ʾ���ȫ����ע������û��ڽ���ע���������е��"ͬ��"��ť����ʾ�û���ȫ���ܱ�Э�����µ�ȫ�������Щ�������'.$this->_tpl_vars['jieqi_sitename'].'��������������ʱ���£�������Э��һ�������䶯��'.$this->_tpl_vars['jieqi_sitename'].'����������ص�ҳ������ʾ�޸����ݡ��޸ĺ�ķ���Э��һ����ҳ���Ϲ�������Ч����ԭ���ķ���Э�顣�û���ʹ��'.$this->_tpl_vars['jieqi_sitename'].'���ṩ�ĸ������֮ǰ��Ӧ��ϸ�Ķ�������Э�飬���û���ͬ�Ȿ����Э�鼰/����ʱ������޸ģ��û���������ȡ��'.$this->_tpl_vars['jieqi_sitename'].'���ṩ�ķ���
		</p>
		<p>
		2. ��������
		<br />
		2.1 '.$this->_tpl_vars['jieqi_sitename'].'���������ľ���������'.$this->_tpl_vars['jieqi_sitename'].'������ʵ������ṩ��������ѧ��Ʒ�Ķ�����̳(BBS)�������ҡ������ʼ��������������۵ȡ�'.$this->_tpl_vars['jieqi_sitename'].'��������ʱ������жϻ���ֹ���ֻ�ȫ����������Ȩ����
		<br />2.2 '.$this->_tpl_vars['jieqi_sitename'].'�����ṩ�������ʱ�����ܻ�Բ����������(����VIp��Ʒ�Ķ�)���û���ȡһ���ķ��á��ڴ�����£�'.$this->_tpl_vars['jieqi_sitename'].'���������ҳ��������ȷ����ʾ�����û��ܾ�֧���õȷ��ã�����ʹ����ص��������
		<br />2.3 �û���⣬'.$this->_tpl_vars['jieqi_sitename'].'�����ṩ��ص�������񣬳���֮���������������йص��豸(����ԡ����ƽ��������������뻥�����йص�װ��)������ķ���(��Ϊ���뻥������֧���ĵ绰�Ѽ�������)��Ӧ���û����и�����
		</p>
		<p>
		3. ʹ�ù���
		<br />
		3.1 �û�������ʹ��'.$this->_tpl_vars['jieqi_sitename'].'���������ʱ��������'.$this->_tpl_vars['jieqi_sitename'].'������ע�Ტ�ṩ׼ȷ�ĸ������ϣ�������������κα䶯�����뼰ʱ���¡����������ṩ��׼ȷ�����ܲ�����ط���ʱ��'.$this->_tpl_vars['jieqi_sitename'].'�����е��κ����Ρ�
		
		<br />3.2 �û�ע��ɹ���'.$this->_tpl_vars['jieqi_sitename'].'��������ÿ���û�һ���û��ʺż���Ӧ�����룬���û��ʺź��������û����𱣹ܣ��û�Ӧ���������û��ʺŽ��е����л���¼����������Ρ�
		
		<br />3.3 �û�ͬ�����'.$this->_tpl_vars['jieqi_sitename'].'��ͨ�������ʼ���������ʽ���û����͵���Ʒ���������������ҵ��Ϣ��
		
		<br />3.4 �û���ʹ��'.$this->_tpl_vars['jieqi_sitename'].'�������������У�������ѭ����ԭ��
		
		<br />(A) �����й��йصķ��ɺͷ��棻
		
		<br />(B) ����Ϊ�κηǷ�Ŀ�Ķ�ʹ���������ϵͳ��
		
		<br />(C) ������������������йص�����Э�顢�涨�ͳ���
		
		<br />(D) ��������'.$this->_tpl_vars['jieqi_sitename'].'���������ϵͳ�����κο��ܶԻ�������������ת��ɲ���Ӱ�����Ϊ��
		
		<br />(E) ��������'.$this->_tpl_vars['jieqi_sitename'].'���������ϵͳ�����κ�ɧ���Եġ��������˵ġ������Եġ������Եġ�ӹ������Ļ������κηǷ�����Ϣ���ϣ�
		
		<br />(F) ��������'.$this->_tpl_vars['jieqi_sitename'].'���������ϵͳ�����κβ�����'.$this->_tpl_vars['jieqi_sitename'].'������Ϊ��
		
		<br />(G) ��'.$this->_tpl_vars['jieqi_sitename'].'����������ҵ���ķ��񡢲�Ʒ��ҵ����ѯӦ��ȡ��Ӧ�����ṩ�Ĺ�ͨ�����������ڹ��ڳ��Ϸ����й�'.$this->_tpl_vars['jieqi_sitename'].'������ط���ĸ���������
		
		<br />(H) �緢���κηǷ�ʹ���û��ʺŻ��ʺų��ְ�ȫ©���������Ӧ����ͨ��'.$this->_tpl_vars['jieqi_sitename'].'����
		</p>
		<p>
		4. ��������Ȩ
		<br />4.1 '.$this->_tpl_vars['jieqi_sitename'].'���ṩ������������ݿ��ܰ��������֡������������ͼƬ��¼��ͼ��ȡ�������Щ�����ܰ�Ȩ�����̱귨�������Ʋ�����Ȩ���ɵı�����
		<br />4.2 �û�ֻ���ڻ��'.$this->_tpl_vars['jieqi_sitename'].'�����������Ȩ���˵�������Ȩ֮�����ʹ����Щ���ݣ����������Ը��ơ�������Щ���ݡ������������йص�������Ʒ��
		</p>
		<p>
		5. ��˽����
		<br />5.1 �����û����ر���δ�����ˣ�����˽��'.$this->_tpl_vars['jieqi_sitename'].'����һ��������ߣ���ˣ�����ĸ���໤�ˣ�ϣ��δ�����ˣ�������ʮ��������Ů������ʹ�ñ����񣬱����Ը�ĸ���໤�ˣ���������ע�ᣬ�ڽ��ܱ�����ʱ��Ӧ�Է����໤����ݼ����жϱ������Ƿ������δ�����ˡ� '.$this->_tpl_vars['jieqi_sitename'].'����֤�����⹫�������������5.2����������⣩�ṩ�û�ע�����ϼ��û���ʹ���������ʱ�洢��'.$this->_tpl_vars['jieqi_sitename'].'���ķǹ������ݣ�������������⣺
		<br />(A) ���Ȼ���û�����ȷ��Ȩ��
		<br />(B) �����йصķ��ɷ���Ҫ��
		<br />(C) ��������������ܲ��ŵ�Ҫ��
		<br />(D) Ϊά����ṫ�ڵ����棻
		<br />(E) Ϊά��'.$this->_tpl_vars['jieqi_sitename'].'���ĺϷ�Ȩ�档
		<br />5.2 '.$this->_tpl_vars['jieqi_sitename'].'�����ܻ���������������û��ṩ��ص���������ڴ�����£���õ�����ͬ��е���'.$this->_tpl_vars['jieqi_sitename'].'��ͬ�ȵı����û���˽�����Σ���'.$this->_tpl_vars['jieqi_sitename'].'���ɽ��û���ע�����ϵ��ṩ���õ�������
		<br />5.3�ڲ�͸¶�����û���˽���ϵ�ǰ���£�'.$this->_tpl_vars['jieqi_sitename'].'����Ȩ�������û����ݿ���м������������ѽ��з������������û����ݿ������ҵ�ϵ����á� ����'.$this->_tpl_vars['jieqi_sitename'].'�����û�����˽Ȩ�������˼����Ŭ����������Ȼ���ܱ�֤���еİ�ȫ������ʩʹ�û��ļ�����Ϣ�Ȳ����κ���ʽ����ʧ��
		</p>
		<p>
		6. ��������
		<br />6.1 '.$this->_tpl_vars['jieqi_sitename'].'�������߲���֤�������ˣ�
		<br />(A)�����񽫷�������Ҫ��
		<br />(B)�����񽫲��ܸ��š���ʱ�ṩ����ȫ�ɿ��򲻻����
		<br />(C)'.$this->_tpl_vars['jieqi_sitename'].'����Ŭ����֤������Ʒ�������ԣ�������������߻�������'.$this->_tpl_vars['jieqi_sitename'].'�����ܿ��Ƶ�ԭ������Ʒ�����ز��ܼ���ʱ��'.$this->_tpl_vars['jieqi_sitename'].'�����û����е��κ����Ρ�
		<br />(D)���û������ʻ�Ȩ������'.$this->_tpl_vars['jieqi_sitename'].'�����񹹳��ƻ�����ʱ��'.$this->_tpl_vars['jieqi_sitename'].'����Ȩֹͣ���ʺŵ�ʹ��Ȩ����
		<br />6.2�û���ȷͬ����ʹ��'.$this->_tpl_vars['jieqi_sitename'].'��������������ڵķ��ս���ȫ�����Լ��е�������ʹ��'.$this->_tpl_vars['jieqi_sitename'].'����������������һ�к��Ҳ�����Լ��е���'.$this->_tpl_vars['jieqi_sitename'].'�����û����е��κ����Ρ�
		</p>
		<p>
		7. ���������жϻ���ֹ
		<br />7.1 ����ϵͳά������������Ҫ������ͣ�������'.$this->_tpl_vars['jieqi_sitename'].'�������������Ƚ���ͨ�档
		<br />7.2 �緢�������κ�һ�����Σ�'.$this->_tpl_vars['jieqi_sitename'].'����Ȩ��ʱ�жϻ���ֹ���û��ṩ��Э�����µ�������������֪ͨ�û���
		<br />(A)�û��ṩ�ĸ������ϲ���ʵ��
		<br />(B)�û�Υ����Э���й涨��ʹ�ù���
		<br />7.3 ��ǰ�����������⣬'.$this->_tpl_vars['jieqi_sitename'].'��ͬʱ�����ڲ�����֪ͨ�û����������ʱ�жϻ���ֹ���ֻ�ȫ����������Ȩ�����������з�����жϻ���ֹ����ɵ��κ���ʧ��'.$this->_tpl_vars['jieqi_sitename'].'��������û����κε������е��κ����Ρ�
		</p>
		<p>
		8. ΥԼ�⳥
		<br />�û�ͬ�Ᵽ�Ϻ�ά��'.$this->_tpl_vars['jieqi_sitename'].'���������û������棬�����û�Υ���йط��ɡ������Э�����µ��κ��������'.$this->_tpl_vars['jieqi_sitename'].'�����κ����������������ʧ���û�ͬ��е��ɴ���ɵ����⳥���Ρ�
		</p>
		<p>
		9. ���ɹ�Ͻ
		<br />9.1 ��Э��Ķ�����ִ�кͽ��ͼ�����Ľ����Ӧ�����й����ɡ�
		<br />9.2 ��˫���ͱ�Э�����ݻ���ִ�з����κ����飬˫��Ӧ�����Ѻ�Э�̽����Э�̲���ʱ���κ�һ����Ӧ��'.$this->_tpl_vars['jieqi_sitename'].'���������������ڵص�����Ժ�������ϡ�
		</p>
		<p>
		10. ֪ͨ���ʹ�
		<br />��Э���������е�֪ͨ����ͨ����Ҫҳ�湫�桢�����ʼ��򳣹���ż����͵ȷ�ʽ���У��õ�֪ͨ�ڷ���֮����Ϊ���ʹ��ռ��ˡ�
		</p>
		<p>
		11. �����涨
		<br />11.1 ��Э�鹹��˫���Ա�Э��֮Լ����������й����˵�����Э�飬����Э��涨��֮�⣬δ���豾Э���������Ȩ����
		<br />11.2 �籾Э���е��κ��������������ԭ����ȫ�򲿷���Ч�򲻾���ִ��������Э�������������Ӧ��Ч������Լ������
		<br />11.3 ��Э���еı����Ϊ������裬���߷��ɻ���ԼЧ����
    </div>
<script type="text/javascript">
layer.ready(function(){
	$(\'#signup_form\').bind(\'valid.form\', function(){
		  GPage.postForm(\'signup_form\', this.action,
			   function(data){
					if(data.status==\'OK\'){
						layer.msg(data.msg,1,{type:1,shade:false},function(){
							jumpurl(data.jumpurl);
						});
					}else{
						//$(\'#recode\').click();
						$(\'#result_14\').html(data.msg).fadeIn(300).delay(2000).fadeOut(1000);
						if(data.msg == \'�Բ���У�������\'){
							$("[name=\'checkcode\']").focus();
							$(\'#recode\').click();
						}
					}
			   }
		  );
	});
	var jumpurl_c = "'.$this->_tpl_vars['jieqi_url'].'";
	var url_c = "'.$this->_tpl_vars['url'].'/qqlogin/";
	if (jumpurl_c && jumpurl_c!="undefined"){
		url_c = url_c + "?jumpurl=" + jumpurl_c;
	}
   $("#otherlogin").bind("click",function(){
		otherlogin(url_c);
	});
});
function shxy(){
	$.layer({
		type: 1,
		title: false,
		offset: [\'160px\' , \'\'],
		area: [\'980px\', \'auto\'],
//		shade: [0],
		page: {
			dom: \'#cont\'
		}, 
		success: function(){
//			layer.shift(\'left\',400); //��߶�������
		}
	});
}
</script>';
?>