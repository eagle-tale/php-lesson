<?php
include_once('..\controllers\UserController.php');
date_default_timezone_set('Asia/Tokyo');

session_start();
$idInput = $_POST["mail"];
$passwordInput = $_POST["password"];
$birthdayInput = $_POST["birthday"];
$controller = new UserController();
$isSuccess = $controller->register($idInput, $passwordInput, $birthdayInput);

// 認証処理
if (!$isSuccess) {
    $msg = '同じユーザーネームが存在します。';
    $link = '<a href="register.php">戻る</a>';
} else {
    $msg = '会員登録が完了しました';
    $link = '<a href="../">ログインページ</a>';
}
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>