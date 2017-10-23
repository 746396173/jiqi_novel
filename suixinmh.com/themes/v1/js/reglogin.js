//��֤��ʼ��
$('#signup_form').validator({ 
    theme: 'yellow_right_effect',
    stopOnError:true,
    timely: 2,
    //�Զ������PS�����龡����ȫ�������ж������ͳһ����
    rules: {
        username: [/^[a-zA-Z0-9]+$/, '�û�����Ч! ��֧����ĸ�����֡�']
    },
    fields: {
        "user[name]": {
            rule: "required",
            tip: "����������������ϡ�",
            ok: "���ֺܰ���",
            msg: {required: "ȫ������!"}
        },
        "user[email]": {
            rule: "email;remote[check/email.php]",
            tip: "����ʼ���ַ��ʲô?",
            ok: "���ǽ�����㷢��ȷ���ʼ���",
            msg: {
                required: "���������ַ����!",
                email: "��������Ч�ĵ������䡣"
            }
        },
        "user[user_password]": {
            rule: "required;length[6~];password;strength",
            tip: "6��������ַ�! Ҫ����Щ��",
            ok: "",
            msg: {
                required: "���벻��Ϊ��!",
                length: "��������Ϊ6λ��"
            }
        },
        "user[screen_name]": {
            rule: "required;username;remote[check/user.php]",
            tip: "����,������Ժ�����޸ġ�",
            ok: "�û�������ʹ�á�<br>������Ժ�����޸ġ�",
            msg: {required: "�û�������!<br>������Ժ�����޸ġ�"}
        }
    },
    //��֤�ɹ�
    valid: function(form) {
        $.ajax({
            url: 'results.php',
            type: 'POST',
            data: $(form).serialize(),
            success: function(d){
                $('#result').fadeIn(300).delay(2000).fadeOut(500);
            }
        });
    }
});