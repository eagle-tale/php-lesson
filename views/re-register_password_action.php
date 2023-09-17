<?php
session_start();
include_once('..\controllers\UserController.php');
// include_once('..\repositories\ReminderController.php');

$userController = new UserController;

$user_id = $_SESSION['user_id'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

if ($password == $password2) {
    if ($userController->updatePassword($user_id, $password)) {
        echo 'パスワード更新できました。';
        echo '<li><a href="./">TOP</a></li>';
    } else {
        echo 'パスワード更新できなかった';
        echo '<li><a href="./">TOP</a></li>';
    }
} else {
    echo '確認で入力されたパスワードが異なっています。<br>';
    echo "<a href='./re-register_password.php?hash={$_SESSION['hash']}>戻る</a>'";
}
