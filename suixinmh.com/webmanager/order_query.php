<?
$nocheck=true;
include_once("db.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=GB18030">
    <title>Untitled Document</title>
</head>

<body>
<form name="form1" method="post" action="">
    ������Ϣ��
    <input name="orderid" type="text" id="orderid" size="40">
    ��51CP��ͷ��2016��ͷһ�������룩<br>
    ��վ��ˮ�ţ�
    <input name="webid" type="text" id="webid" size="30">
    (5-7λ�����ִ�)
    <input type="submit" name="submit" id="submit" value="��ѯ">
</form>
<?
$orderid=trim($_POST['orderid']);
$webid=trim($_POST['webid']);
if ($orderid || $webid) {
    if ($orderid)
        $sql="select * from jieqi_pay_paylog where retserialno='$orderid'";
    else
        $sql="select * from jieqi_pay_paylog where payid='$webid'";

    $r=mysql_query($sql);
    $d=mysql_fetch_array($r);
    if ($d) {
        $sql="select * from jieqi_system_users where uid=".$d['buyid'];
        $r1=mysql_query($sql);
        $userinfo=mysql_fetch_array($r1);
        $sql="select * from jieqi_system_connect where uid=".$userinfo['uid'];
        $r2=mysql_query($sql);
        $d2=mysql_fetch_array($r2);
        if ($d2) {
            $usertype=$d2['type'];
        }
        else {
            $usertype="��վע��";
        }
        ?>
        <table width="95%" border="1">
            <tbody>
            <tr>
                <th scope="col">�û���</th>
                <th scope="col">������</th>
                <th scope="col">��ֵ���</th>
                <th scope="col">��ֵʱ��</th>
            </tr>
            <tr>
                <td><?=$d['buyname']?>&nbsp;</td>
                <td><?=$d['retserialno']?>&nbsp;</td>
                <td><?=$d['money']/100?>&nbsp;</td>
                <td><?=date("Y-m-d H:i:s",$d['buytime'])?>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        <br>
        <br>
        <table width="51%" height="180" border="1" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td width="32%">&nbsp;�û���</th>
                <td width="68%"><?=$userinfo['uname']?>&nbsp;</th>
            </tr>
            <tr>
                <td>�˺�����</td>
                <td><?=$usertype?></td>
            </tr>
            <tr>
                <td>�˻����</td>
                <td><?=$userinfo['egold']."���,".$userinfo['esilver']."��ȯ"?></td>
            </tr>
            </tbody>
        </table>
        <p>&nbsp;</p>
        <?
    }
    else {
        echo "û�鵽";
    }
}
?>
</body>
</html>