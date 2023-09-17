<?php
include_once('..\controllers\UserController.php');
date_default_timezone_set('Asia/Tokyo');

session_start();
$deletingId = $_POST["deleteId"];
$controller = new UserController();
$isSuccess = $controller->delete($deletingId);

// 認証処理
if (!$isSuccess) {
    $msg = '削除に失敗しました。';
    $link = '<a href="./user_list_edit.php">戻る</a>';
} else {
    $msg = '削除が完了しました。';
    $link = '<a href="./user_list_edit.php">戻る</a>';
}
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>