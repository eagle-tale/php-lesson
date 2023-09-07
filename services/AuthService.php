<?
require_once '..\vendor\phpgangsta\googleauthenticator\PHPGangsta\GoogleAuthenticator.php';
include_once('..\repositories\AuthRepository.php');
include_once('..\models\AuthModel.php');

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

        $this->authRepository->get_passcode($mail);

        // サービス名
        $title = 'TEST';

        // ユーザー名
        $name = $mail;

        $secret = $this->createSecret();

        // QRコードURLの生成と表示
        $qrCodeUrl = $this->ga->getQRCodeGoogleUrl($name, $secret, $title);

        return $qrCodeUrl;
    }

    public function createSecret()
    {
        // 秘密鍵の生成
        $secret = $this->ga->createSecret();
        return $secret;
    }
}