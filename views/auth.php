<?php
require_once '..\controllers\AuthController.php';

$mail = "test@test";

$auth = new AuthController();

$qrCodeUrl = $auth->createQR($mail);

?>

<img src="<?php echo $qrCodeUrl; ?>"></img>