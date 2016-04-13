<?php

try {

  $user_id = $_POST['id'];
  $user_pass = $_POST['pass'];

  $user_id = htmlspecialchars ($user_id);
  $user_pass = htmlspecialchars ($user_pass);

  $user_pass = md5 ($user_pass);

  $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT name FROM dat_sales WHERE id=? AND password=?';
  $stmt = $dbh->prepare ($sql);
  $data[] = $user_id;
  $data[] = $user_pass;

  print "$user_id, $user_pass";

  $stmt->execute ($data);

  print 'pass execute';

  $dbh = null;

  $rec = $stmt->fetch (PDO::FETCH_ASSOC);

  if ($rec == false) {
    print 'スタッフコードかパスワードが間違っています。<br />';
	  print '<a href="shop_login.php"> 戻る</a>';
  }else {
    session_start ();
    $_SESSION['member_login'] = 1;
    $_SESSION['member_name'] = $rec['name'];
    header ('location:shop_list.php');
    exit ();
  }

} catch (PDOException $e) {

  print 'ただいま障害により大変ご迷惑をお掛けしております。<br/>';
  echo "Error: " . $e->getMessage();
	exit();
}


 ?>
