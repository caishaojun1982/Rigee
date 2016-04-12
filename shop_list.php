<?php

session_start ();
session_regenerate_id (true);

if (isset ($_SESSION['member_login']) == false) {

  print 'ようこそゲスト様　';
  print '<a href="member_login.html">会員ログイン</a><br/>';
  print '<br/>';
}else {

  print 'ようこそ';
  print $SESSION['member_name'];
  print ' 様　';
  print '<a href="member_logout.php">ログアウト</a><br/>';
  print '<br/>';
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

  $dsn = 'mysql:dbname=rigee;host=localhost;charset=utf8';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT * FROM mst_product WHERE 1';
  $stmt = $dbh->prepare ($sql);
  $stmt->execute ();

  $dbh = null;

  // print '商品一覧<br /><br />';
  // 先頭のImageのレイアウト
  print '<a href="../Rigee/shop_list.php"><img src="../Rigee/logo-rigee2.png" alt="画像の説明文"></a>';
  print '<a href="../Rigee/shop_list.php"><img src="../Rigee/logo-t.png" alt="画像の説明文"></a>';

  print '<a href="../Rigee/shop_list.php"><img src="../Rigee/nav01.png" alt="ホームへ"></a>';
  print '<a href="../Rigee/shop_list.php"><img src="../Rigee/nav04.png" alt="会社説明"></a>';
  print '<a href="../Rigee/shop_cartlook.php"><img src="../Rigee/nav02.png" alt="カート"></a>';
  print '<a href="../Rigee/staff_login/staff_login.html"><img src="../Rigee/nav05.png" alt="ログイン"></a><br/>';

  // TODO: 特価商品

  $index = 1;
  while (true) {

    $rec = $stmt->fetch (PDO::FETCH_ASSOC);

    if ($rec == false) {

      break;
    }

    print '<a href="shop_product.php?procode='.$rec['code'].'"><img src="../Rigee/product/gazou/'.$rec['pic_big'].'" alt="画像の説明文"></a>';

    if ($index % 3 == 0){
      print '<br />';
    }
  }
  print '<br />';
  print '<a href="shop_cartlook.php">カートを見る</a><br />';

} catch (Exception $e) {

  print 'ただいま障害により大変ご迷惑をお掛けしております。';
  print $e->getMessage ();
	exit();
}

 ?>
</body>
</html>
