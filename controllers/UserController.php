<?php

include_once('..\services\ApplicationService.php');
include_once('..\factories\ApplicationServiceFactory.php');
include_once('..\config.php');

class UserController
{

    private readonly ApplicationService $applicationService;

    public function __construct()
    {
        // Configの設定を元にFactoryからサービス生成
        $this->applicationService = ApplicationServiceFactory::createApplicationService(Config::getEnvironment());
    }

    public function register($id, $password, $birthday)
    {
        return $this->applicationService->register($id, $password, $birthday);
    }

    public function login($id, $password)
    {
        return $this->applicationService->login($id, $password);
    }

    public function userInfo($id)
    {
        return $this->applicationService->userInfo($id);
    }

    public function userList()
    {
        return $this->applicationService->userList();
    }

    public function delete($id)
    {
        return $this->applicationService->delete($id);
    }

    public function update($oldMail, $newMail, $birthday)
    {
        return $this->applicationService->update($oldMail, $newMail, $birthday);
    }

    public function updatePassword($id, $password)
    {
        return $this->applicationService->updatePassword($id, $password);
    }
}
