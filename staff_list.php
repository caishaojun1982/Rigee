<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ユビーネット</title>
</head>

<body>
  <?php

  try {
    // DataBaseを取得
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user = 'root';
    $password = "";
    $dbh = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    // DataBaseの内容を取得
    // $sql = 'SELECT * FROM mst_staff';
    $sql = 'SELECT code,name FROM mst_staff WHERE 1';
    $stmt = $dbh->query($sql);

    // 切断
    $dbh = null;

    print 'スタッフ一覧<br/><br/>';
    print '<form method="post" action="staff_branch.php">';

    while (true) {

      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($rec == false){

        break;
      }

      print '<input type="radio" name="staffcode"value="'.$rec['code'].'">';
      print $rec['name'];
      print '</br>';
    }

    print '</br>';
    print '<input type="submit" name="disp" value="詳細">';
    print '<input type="submit" name="add" value="追加">';
    print '<input type="submit" name="edit" value="修正">';
    print '<input type="submit" name="delete" value="削除">';
    print '</form>';

  } catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
  }

   ?>
</body>
</html>
