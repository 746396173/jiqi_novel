  <!-- sidebar start -->
  <div class="admin-sidebar">
    <ul class="am-list admin-sidebar-list">
      <li><a href="admin-index.php"> ��̨������ҳ</a></li>
      <li><a href="admin-payment.php"> ������ֵͳ��</a></li>
        <?
        if ($_SESSION['qd_admin_level']>=99) {
        ?>
<!--      <li><a href="copy_books.php"> �����鼮</a></li>-->
        <li><a href="admin-qduser.php"> �ƹ�רԱ����</a></li>
      <li><a href="admin-cp.php"> cp�˺Ź���</a></li>
      <li><a href="admin-cppay.php"> cp�������</a></li>

        <?
        }
        ?>
      <li><a href="logout.php"> ע��</a></li>
    </ul>
</div>
  <!-- sidebar end -->