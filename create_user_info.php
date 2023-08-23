<?php

date_default_timezone_set('Asia/Tokyo');

session_start();
require('Db_controller.php');
$db = new Db();

$idInput = $_POST["loginID"];
$passwordInput = $_POST["password"];

// 認証処理
if (!$db->createUser($idInput, $passwordInput)) {
    $msg = '同じユーザーネームが存在します。';
    $link = '<a href="register.php">戻る</a>';
} else {
    $msg = '会員登録が完了しました';
    $link = '<a href="./">ログインページ</a>';
}

?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>