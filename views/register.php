<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録画面</title>
</head>

<body>
    <h2>ユーザー情報</h2>
    <form action="./register_user_action.php" method="post">
        <label for="loginID">LoginID:</label>
        <input type="text" id="loginID" name="loginID" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="送信">
    </form>
    <p>すでに登録済みの方は<a href="../">こちら</a></p>
</body>

</html>