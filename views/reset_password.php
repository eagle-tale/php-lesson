<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
include_once('.\Menu.php');
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
    <form action="./reset_password_action.php" method="POST">
        <label for="mail">メールアドレス：</label>
        <input type="email" name="mail" id="mail" required>
        <input type="submit" value="送信">
    </form>


    <p>
        ◆このページでやりたいこと<br>
        1. メールアドレスを入力してもらう<br>
        2. 登録されているメールアドレスと一致している場合<br>
        　a. reminderテーブルにuser_id、hash、expire_dateを登録する<br>
        　b. メールアドレス宛にメール送信。hashを付与したURLを記載しておく。<br>
        3. ユーザーがメール内のURLをクリックしたらGET値に記載されているhashとreminderテーブルに記載されているhashを照合<br>
        4. hashが合っていた場合、パスワード変更画面へ移動する。<br>

    </p>
    <!-- メニュー表示 -->
    <?php $menu = new Menu;
    $menu->show();
    ?>

</body>

</html>