<?php

session_start ();
session_regenerate_id (true);

if (isset($_SESSION['member_login']) == false)
{
  print 'ようこそゲスト様　';
  print '<a href="shop_login.php">会員ログイン</a><br />';
  print '<br />';
}
else
{
  print 'ようこそ';
  print $_SESSION['member_name'];
  print '様　';
  print '<a href="shop_logout.php">ログアウト</a><br />';
  print '<br />';
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ユビーネット</title>
</head>
<body>

<?php

try {

  $pro_code = $_GET['procode'];

  print "$pro_code";

  $dsn='mysql:dbname=rigee;host=localhost;charset=utf8';
  $user='root';
  $password='';
  $dbh=new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT * FROM mst_product WHERE code=?';
  $stmt = $dbh->prepare ($sql);
  $data[] = $pro_code;
  $stmt->execute ($data);

  $rec = $stmt->fetch (PDO::FETCH_ASSOC);
  $pro_name = $rec['name'];

  if (isset ($_SESSION['cart']) == true){

    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];

    if (in_array ($pro_code, $cart) == true){

      print "$pro_name その商品はすでにカートに入っています。<br/><br/>";
      print '<a href="shop_list.php">商品一覧に戻る</a>';
      exit();
    }
  }
  $cart[] = $pro_code;
  $kazu[] = 1;
  $_SESSION['cart'] = $cart;
  $_SESSION['kazu'] = $kazu;

} catch (Exception $e) {

  print 'ただいま障害により大変ご迷惑をお掛けしております。';
  print $e->getMessage ();
	exit();
}

 ?>

 <?php print $pro_name; ?>カートに追加しました。<br />
<br />
<a href="shop_list.php">商品一覧に戻る</a>

</body>
</html>
