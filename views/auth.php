<?php
session_start();
require_once '..\controllers\AuthController.php';

$mail = $_SESSION['id'];
echo 'id:' . $mail . '<br>';

$auth = new AuthController();
$qrCodeUrl = $auth->createQR($mail);

// 入力された数字が正しいか確認
if (isset($_SESSION['authcode'])) {
    $authcode = $_SESSION['authcode'];
    if ($auth->isCodeValid($mail, $authcode)) {
        $_SESSION['msg'] = 'ログインしました。';
        header('Location: ./');
        exit();
    }
}

?>

<div class="qr-area">
    <img src="<?php echo $qrCodeUrl; ?>"></img>
</div>

<div class="form-area">
    <label for="authcode">コードを入力</label><br>
    <input type="text" name="authcode" placeholder="6桁の数値を入力してください" value="" required><br>
    <input type="submit" name="submit" value="認証">

</div>

<p>
    ◆このページでやりたいこと<br>
    1. ログイン後、本ページに飛ぶ（セッションにmailが入っている）<br>
    2. viewからcontroller->createQR($mail)を呼び出す<br>
    3. createQR内で<br>
    　a. mailに対してパスコード（秘密鍵）が存在していなければパスコード発行&登録&QR表示<br>
    　b. パスコードが存在している&失敗回数多くないなら、そのパスコードでQR表示<br>
    　c. 失敗回数多いなら、エラーメッセージ<br>
    4. QR表示をユーザーが読み取り、GoogleAuthenticatorで出てくる6文字の数字をページに入力する。<br>
    5. viewからcontroller->isCodeValid($mail, $authcode)を呼び出す<br>
    6.isCodeValid内で入力された数字が正しいかチェックし、boolを返す。

</p>

<li><a href="./logout.php">ログアウト</a></li>