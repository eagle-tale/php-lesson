<?php
require('classes/Menu.php');

// デバッグ用↓
if (isset($_POST['mail'])) {
    echo '入力されたアドレス: ' . $_POST['mail'];
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
    <form action="#" method="POST">
        <label for="mail">メールアドレス：</label>
        <input type="email" name="mail" id="mail" required>
        <input type="submit" value="送信">
    </form>

    <!-- メニュー表示 -->
    <?php $menu = new Menu;
    $menu->show();
    ?>

</body>

</html>