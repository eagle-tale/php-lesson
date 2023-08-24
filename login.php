<?php

require('classes\db.php');
session_start();
$idInput = $_POST["loginID"];
$passwordInput = $_POST["password"];

$db = new DB();

// 認証処理
if ($db->isMatchIdPass($idInput, $passwordInput)) {

    // DBのユーザー情報をセッションに保存
    $userinfo_array = $db->get_UserInfo($idInput);
    $_SESSION['id'] = $userinfo_array['loginId'];
    $_SESSION['permission'] = $userinfo_array['permission'];

    $_SESSION['msg'] = 'ログインしました。';
    header('Location: ./');
    exit();
} else {
    $_SESSION['msg'] = 'IDもしくはパスワードが間違っています。';
    header('Location: ./');
    exit();
}
