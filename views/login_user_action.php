<?php

include_once('..\controllers\UserController.php');

session_start();
$idInput = $_POST["id"];
$passwordInput = $_POST["password"];
$controller = new UserController();
$isSuccess = $controller->login($idInput, $passwordInput);

// 認証処理
if ($isSuccess) {
    // DBのユーザー情報をセッションに保存
    $userInfo = $controller->userInfo($idInput);
    $_SESSION['id'] = $userInfo->mail;
    $_SESSION['permission'] = $userInfo->permission;

    header('Location: ./auth.php');
    exit();
} else {
    $_SESSION['msg'] = 'IDもしくはパスワードが間違っています。';
    header('Location: ./');
    exit();
}
