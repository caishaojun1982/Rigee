<?php

session_start ();
session_regenerate_id (true);

if (isset ($_SESSION['member_login']) == false){

  print 'ようこそゲスト様　';
  print '<a href="member_login.html">会員ログイン</a><br />';
  print '<br />';
}else {
  print 'ようこそ';
  print $_SESSION['member_name'];
  print '様　';
  print '<a href="member_logout.php">ログアウト</a><br />';
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

  try{
    $pro_code = $_GET['procode'];

    $dsn = 'mysql:dbname=rigee;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM mst_product WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $pro_code;
    $stmt->execute ($data);

    $rec = $stmt->fetch (PDO::FETCH_ASSOC);
    $pro_name = $rec['name'];
    $pro_model = $rec['model'];
    $pro_price = $rec['price'];
    $pro_sale = $rec['sale'];
    $pro_size = $rec['size'];
    $pro_feature = $rec['feature'];
    $pro_pic_big = $rec['pic_big'];

    $dbh = null;

    if ($pro_pic_big == "") {

      $disp_gazou = "";
    }else {

      $disp_gazou = '<img src="../Rigee/product/gazou/'.$pro_pic_big.'".png>';
    }

    print '<a href="shop_cartin.php?procode='.$pro_code.'">カーとに入れる</a><br /><br />';
  }catch (Exception $e){

    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    print $e->getMessage ();
    exit();
  }
  ?>

  商品情報詳細<br />
  <br />
  <?php print $disp_gazou; ?>
  <br />
  商品コード:　   <?php print $pro_code; ?>
  <br />
  商品名:　　　  <?php print $pro_name; ?>
  <br />
  型番:　　　　  <?php print $pro_model; ?>
  <br />
  価格:　　　  　<?php print $pro_price; ?>円
  <br />
  特価－曜日:  　<?php print $pro_sale; ?>円
  <br />
  サイズ:　　  　<?php print "$pro_size inch"; ?>
  <br />
  特徴:         <?php print $pro_feature; ?>
  <br />
  <br />
  <form>
    <input type="button" onclick="history.back()" value="戻る">
  </form>

</body>
</html>
