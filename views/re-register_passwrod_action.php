<?php
session_start();
include_once('..\repositories\UserController.php');
// include_once('..\repositories\ReminderController.php');

$userController = new UserController;

$password = $_POST['password'];
$password2 = $_POST['password2'];

if ($password == $password2) {
} else {
    echo '確認で入力されたパスワードが異なっています。<br>';
    echo "<a href='./re-register_password.php?hash={$_SESSION['hash']}>戻る</a>'";
}
