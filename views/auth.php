<?php
session_start();
require_once '..\controllers\AuthController.php';

// セッションにidが入っていなければ弾く
if (!isset($_SESSION['id'])) {
    $_SESSION['msg'] = '不正なページ移動です。';
    header('Location: ./');
    exit();
}

$mail = $_SESSION['id'];
// echo 'id:' . $mail . '<br>';
$auth = new AuthController();

// authcodeがあれば入力された数字が正しいか確認
if (isset($_POST['authcode'])) {
    $authcode = $_POST['authcode'];
    echo 'inputcode:' . $authcode . '<br>';
    if ($auth->isCodeValid($mail, $authcode)) {
        $auth->authSuccess($mail);
        $_SESSION['msg'] = 'ログインしました。';
        header('Location: ./');
        exit();
    } else {
        // 認証失敗
        $auth->authFailure($mail);
        header('Location: ./logout.php');
    }
} else {
    // authcodeがなければ、QR生成
    $qrCodeUrl = $auth->createQR($mail);
?>

    <head>
        <title>2段階認証</title>
    </head>

    <body>
        <h2>2段階認証画面</h2>
        <span>▼下記のQRコードをGoogle Authenticatorで読み取ってください。</span>
        <div class="qr-area">
            <img src="<?php echo $qrCodeUrl; ?>"></img>
        </div>
        <br>
        <div class="form-area">
            <form action="" method="post">
                <label for="authcode">コードを入力</label><br>
                <input type="text" name="authcode" placeholder="6桁の数値を入力してください" value="" required><br>
                <input type="submit" name="submit" value="認証">
            </form>
        </div>

    <?php } ?>

    <p>
        ◆このページでやりたいこと<br>
        1. ログイン後、本ページに飛ぶ（セッションにmailが入っている）<br>
        2. viewからcontroller->createQR($mail)を呼び出す<br>
        3. createQR内で<br>
        　a. mailに対してパスコード（秘密鍵）が存在していなければパスコード発行&登録&QR表示<br>
        　b. パスコードが存在している&1度もQRを使用していない&失敗回数多くないなら、そのパスコードでQR表示<br>
        　c. 失敗回数多いなら、エラーメッセージ<br>
        4. QR表示をユーザーが読み取り、GoogleAuthenticatorで出てくる6文字の数字をページに入力する。<br>
        5. viewからcontroller->isCodeValid($mail, $authcode)を呼び出す<br>
        6.isCodeValid内で入力された数字が正しいかチェックし、boolを返す。

    </p>

    <li><a href="./logout.php">ログアウト</a></li>

    </body>