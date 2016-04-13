<?php

session_start ();
session_regenerate_id (true);

if (isset ($_SESSION['member_login']) == false) {

  print 'ようこそゲスト様　';
  // print '<a href="member_login.html">会員ログイン</a><br/>';
  print '<a href="shop_form.html">会員ログイン</a><br/>';
  print '<br/>';
}else {

  print 'ようこそ';
  print $SESSION['member_name'];
  print ' 様　';
  // print '<a href="member_logout.php">ログアウト</a><br/>';
  print '<a href="shop_form.html">ログアウト</a><br/>';
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

  <a href="../Rigee/shop_list.php"><img src="../Rigee/logo-rigee2.png" alt="画像の説明文"></a>
  <a href="../Rigee/shop_list.php"><img src="../Rigee/logo-t.png" alt="画像の説明文"></a>
  <a href="../Rigee/shop_list.php"><img src="../Rigee/nav01.png" alt="ホームへ"></a>
  <a href="../Rigee/shop_list.php"><img src="../Rigee/nav04.png" alt="会社説明"></a>
  <a href="../Rigee/shop_cartlook.php"><img src="../Rigee/nav02.png" alt="カート"></a>
  <a href="../Rigee/staff_login/staff_login.html"><img src="../Rigee/nav05.png" alt="ログイン"></a>
  <br/>

<?php

// セール中がどうか
function isOnSale ($saleWeek){

  $datetime = new DateTime();
  $week = array("日", "月", "火", "水", "木", "金", "土");
  $w = (int)$datetime->format('w');

  if($saleWeek == $week[$w]){
    return true;
  }else {
    return false;
  }
}

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

  while (true) {

    $rec = $stmt->fetch (PDO::FETCH_ASSOC);

    if ($rec == false) {

      break;
    }

    if (isOnSale ($rec['sale_week']) == true){

      $sale_pro = $rec;
    }else {

      $normal_pro[] = $rec;
    }
  }

  // セール商品
  $sale_week = $sale_pro['sale_week'];
  print "$sale_week 曜日の特価商品：";
  print '<br/>';
  print '<a href="shop_product.php?procode='.$sale_pro['code'].'"><img src="../Rigee/product/gazou/'.$sale_pro['pic_big'].'" alt="画像の説明文"></a>';
  print '<br/>';
  // セール商品の詳細
  print $sale_pro['model'];
  print '<br/>';
  print $sale_pro['feature'];
  print '<br/>';
  print $sale_pro['price'];
  print '<br/>';

  // 普通の商品
  for ($i=0; $i <count($normal_pro); $i++) {
    print '<a href="shop_product.php?procode='.$normal_pro[$i]['code'].'"><img src="../Rigee/product/gazou/'.$normal_pro[$i]['pic_big'].'" alt="画像の説明文"></a>';
  }

  // 普通商品
  while (true) {

    $rec = $stmt->fetch (PDO::FETCH_ASSOC);

    if ($rec == false) {

      break;
    }

    if (isOnSale ($rec['sale_week']) == false){

      print '<a href="shop_product.php?procode='.$rec['code'].'"><img src="../Rigee/product/gazou/'.$rec['pic_big'].'" alt="画像の説明文"></a>';
    }
  }

  print '<br />';
  print '<br />';
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
