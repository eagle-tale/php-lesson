<?php
session_start();
require('Menu.php');

if (isset($_SESSION['id'])) {
    $username = $_SESSION['id'];

    // ページ表示回数カウント（おまけ機能）
    if (!isset($_SESSION['count'])) {
        $_SESSION['count'] = 1;
    } else {
        $_SESSION['count']++;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <title>TOP</title>
</head>

<body>
    <h2>トップページ</h2>
    <?php if (isset($_SESSION['msg'])) { ?>
        <div class="alertMessage">
            <?php echo $_SESSION['msg']; ?>
            <?php $_SESSION['msg'] = NULL ?>
        </div>

    <?php } ?>

    <?php if (isset($_SESSION['id'])) { ?>

        <p>こんにちは <?php echo htmlspecialchars($username, \ENT_QUOTES, 'UTF-8'); ?> さん </p>

        <!-- 管理者の場合 -->
        <?php if ($_SESSION['permission'] == 1) { ?>
            <p>あなたは管理者です。</p>
        <?php } ?>

        <p>このセッションでこのページにアクセスした回数: <?php echo $_SESSION['count']; ?> 回</p>

        <!-- メニュー表示 -->
        <?php $menu = new Menu;
        $menu->show();
        ?>


    <?php } else { ?>

        <h2>ログイン</h2>
        <form method="post" action=".\login_user_action.php">
            <label for="loginID">LoginID:</label>
            <input type="text" id="loginID" name="loginID" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>

        <p><a href="./register.php">ユーザー登録</a></p>

    <?php } ?>




</body>

</html>