<?php

include_once('..\services\AuthService.php');

class AuthController
{
    private readonly AuthService $authService;


    public function __construct()
    {
        $this->authService = new AuthService;
    }

    public function createQR($mail)
    {
        $this->authService->createQR($mail);
    }

    public function createSecret()
    {
        $this->authService->createSecret();
    }
}
