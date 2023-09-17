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
        return $this->authService->createQR($mail);
    }

    public function isCodeValid($mail, $authcode)
    {
        return $this->authService->isCodeValid($mail, $authcode);
    }

    public function authSuccess($mail)
    {
        $this->authService->authSuccess($mail);
    }

    public function authFailure($mail)
    {
        $this->authService->authFailure($mail);
    }
}
