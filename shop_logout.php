<?php

session_start ();
$_SESSION = array ();
if (isset ($_COOKIE[session_name ()]) == true) {

  setcookie (session_name (), "", time () - 42000, '/');
}
session_destroy ();
 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ユビーネット</title>
</head>
<body>

ログアウトしました。<br />
<br />
<a href="../Rigee/shop_list.php">ホームページのメイン画面へ</a>

</body>
</html>
