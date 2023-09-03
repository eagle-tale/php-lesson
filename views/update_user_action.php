<?php
include_once('..\controllers\UserController.php');

session_start();
$currentMail = $_SESSION["updatingId"];
$newMail = $_POST["newMail"];
$newBirthday = $_POST["newBirthday"];
$controller = new UserController();
$isSuccess = $controller->update($currentMail, $newMail, $newBirthday);

// 認証処理
if (!$isSuccess) {
    $msg = '変更に失敗しました。';
    $link = '<a href="./user_list_edit.php">戻る</a>';
} else {
    $msg = '変更が完了しました';
    $link = '<a href="./user_list_edit.php">戻る</a>';
}

$_SESSION["updatingId"] = "";
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>