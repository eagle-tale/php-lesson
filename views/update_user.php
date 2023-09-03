<!-- この画面からはmailとbirthdayだけ変更可能 -->
<?php
include_once('..\controllers\UserController.php');

session_start();
$_SESSION['updatingId'] = $_POST["updateId"];
$updatingId = $_SESSION['updatingId'];
$controller = new UserController();
$user = $controller->userInfo($updatingId);

print_r($user);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー情報変更画面</title>
</head>

<body>
    <h2>ユーザー情報</h2>
    <form action="./update_user_action.php" method="post">
        <p>現在のLoginIDは <?php echo $user->mail ?></p>
        <label for="mail">LoginID(mail):</label>
        <input type="text" id="mail" name="newMail"><br><br>
        <p>現在の誕生日は <?php echo $user->birthday ?></p>
        <label for="birthday">誕生日:</label>
        <input type="date" id="birthday" name="newBirthday"><br><br>
        <input type="submit" value="送信">
    </form>
    <p><a href="./user_list_edit.php">ユーザー一覧に戻る</a></p>
</body>

</html>