<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
include_once('../controllers/UserController.php');
include_once('../controllers/ReminderController.php');

$userController = new UserController;
$reminderController = new ReminderController;
$date = new DateTime();
$username = $_SESSION['id'];
$mail_input = $_POST['mail'];

echo '現在のユーザー: ' . $username . '<br>';
echo '入力されたアドレス: ' . $mail_input . '<br>';

// POSTからの受け取り
if (isset($mail_input)) {

    if ($username == $mail_input) {
        // 一致するアドレスがある⇒メールを送る⇒ページ遷移
        // reminderテーブルにuser_id、hash、expire_dateを登録する処理
        $user_id = $userController->userInfo($mail_input)->id;

        // hash生成
        $hash = uniqid(bin2hex(random_bytes(1)));

        // expire_date算出
        $date->modify('+1 hour');
        $expire_date = $date->format('Y/m/d H:i:s');

        echo $user_id;
        echo '<br>';
        echo $hash;
        echo '<br>';
        print_r($expire_date);
        echo '<br>';

        // ReminderController経由でReminderRepositoryにAdd($user_id,$hash,$expire_date)とかで渡す
        $reminderController->save_hash($user_id, $hash, $expire_date);

        // メールを送る処理
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $to = $mail_input;
        $headers = "From: from@test.com";
        $subject = '【テスト】パスワード再設定メール';
        $message = <<< EOD
        以下のURLよりアクセスして、パスワードの再発行を行ってください。\n
        有効期限は  {$expire_date}  までです。\n
        http://localhost/nanobase/views/re-register_password.php?hash={$hash};

        EOD;

        if (mb_send_mail($to, $subject, $message, $headers)) {
            echo 'メールを送信しました。メールに記載されたURLから、パスワードを再設定してください。';
            echo '<li><a href="./">TOP</a></li>';
        } else {
            echo 'メールを送信できませんでした。';
            echo '<li><a href="./">TOP</a></li>';
        }
        exit();
    } else {
        // 一致するアドレスがない⇒エラー
        echo '登録されたメールアドレスと違います。<br>そのメールアドレスには送信できません<br>';
        echo '<li><a href="./reset_password.php">戻る</a></li>';
    }
} else {
    $_SESSION['msg'] = '不正なページ移動です。';
    header('Location: ./index.php');
    exit();
}

//* DEBUG ZONE */


echo uniqid(bin2hex(random_bytes(1)));
echo '<br>';
echo $date->format('Y/m/d H:i:s') . '<br>';
//* DEBUG ZONE */

?>

<!-- メニュー表示 -->
<?php
require('Menu.php');
$menu = new Menu;
$menu->show();
?>