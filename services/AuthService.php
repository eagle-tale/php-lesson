<?php

require '../vendor/autoload.php';
require_once '..\vendor\phpgangsta\googleauthenticator\PHPGangsta\GoogleAuthenticator.php';
include_once('..\repositories\AuthRepository.php');

class AuthService
{
    private readonly AuthRepository $authRepository;
    private readonly PHPGangsta_GoogleAuthenticator $ga;

    public function __construct()
    {
        $this->authRepository = new AuthRepository;
        $this->ga = new PHPGangsta_GoogleAuthenticator();
    }

    public function createQR($mail)
    {
        // パスコードの状態を見て、
        // そもそも存在していなければパスコード発行&登録&QR表示
        // 一度もログイン試行していなければQR表示
        // 上記以外ならエラー表示
        // ・・・させたい

        if ($this->authRepository->is_userLocked($mail)) {
            //ロックされている場合、ログアウト
            header('Location: ./logout.php');
            exit;
        }

        if ($this->authRepository->is_passcodeUsed($mail)) {
            // パスコード取得
            $secret = $this->authRepository->get_passcode($mail);
        } else {
            //パスコード発行
            $secret = $this->createSecret();
            // パスコードのDBへの保存
            $this->authRepository->add_passcode($mail, $secret);
        }

        // サービス名
        $title = 'PHPログインアプリ';
        // ユーザー名
        $name = $mail;

        // QRコードURLの生成と表示
        $qrCodeUrl = $this->ga->getQRCodeGoogleUrl($name, $secret, $title);

        return $qrCodeUrl;
    }

    public function isCodeValid($mail, $authcode)
    {
        // 保存されているpasscodeを取得
        $passcode = $this->authRepository->get_passcode($mail);
        return $this->ga->verifyCode($passcode, $authcode);
    }

    public function authSuccess($mail)
    {
        // isUsedを1にする
        $this->authRepository->set_passcodeUsed($mail);

        // failCountをリセットする
        $this->authRepository->reset_failCount($mail);
    }

    public function authFailure($mail)
    {
        // failCountを+1する
        $this->authRepository->add_failCount($mail);

        // 規定数以上failCountがたまったらロック
        if ($this->authRepository->find($mail)['failCount'] > 4) {
            $this->authRepository->lock_user($mail);
        }
    }

    private function createSecret()
    {
        // 秘密鍵の生成
        $secret = $this->ga->createSecret();
        return $secret;
    }
}
