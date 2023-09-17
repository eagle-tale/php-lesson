<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
include_once('../controllers/ReminderController.php');
$reminderContloller = new ReminderController;
$hash = $_GET['hash'];


// GETからの受取
if (isset($hash)) {
    if ($reminderContloller->whosHash($hash)) {
        $_SESSION['user_id'] = $reminderContloller->whosHash($hash);
        $_SESSION['hash'] = $hash;
        // 下部のHTMLを生成
    };
} else {
    // 何も入っていない場合
    $_SESSION['msg'] = '不正なページ移動です。';
    header('Location: ./index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード変更</title>
</head>

<body>
    <h2>パスワード再設定</h2>
    <form action="./re-register_password_action.php" method="POST">
        <label for="password">パスワード：</label>
        <input type="password" name="password" id="password" required>
        <label for="password2">パスワード（確認）：</label>
        <input type="password2" name="password2" id="password2" required>
        <input type="submit" value="送信">
    </form>
</body>

</html>