<?php
include_once('..\exceptions\ApplicationServiceException.php');
include_once('..\models\UserModel.php');
include_once('..\data\UserResponseData.php');

class ApplicationService
{
    private readonly IUserRepository $userRepository;
    private readonly UserService $userService;

    public function __construct(IUserRepository $userRepository, $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function register($id, $password, $birthday)
    {
        $newUser = new UserModel($id, $birthday);

        // userServiceで重複確認
        if ($this->userService->exists($newUser)) {
            throw new ApplicationServiceException('すでにユーザーが存在します');
        }

        // userRepositoryで保存
        $this->userRepository->save($newUser, $password);
        return true;
    }

    public function login($id, $password)
    {
        if (!$this->userService->isValidUserInfo($id, $password)) {
            throw new ApplicationServiceException('idもしくはpasswordが間違っています');
        }

        return true;
    }

    public function userInfo($id)
    {
        $userInfo = $this->userRepository->find($id);
        return $this->createUserResponseData(
            $userInfo['id'],
            $userInfo['loginId'],
            $userInfo['birthday'],
            $userInfo['permission'],
            $userInfo['createdDate']
        );
    }

    public function userList()
    {
        $users = $this->userRepository->findAll();

        return array_map(function ($user) {
            return $this->createUserResponseData(
                $user['id'],
                $user['loginId'],
                $user['birthday'],
                $user['permission'],
                $user['createdDate']
            );
        }, $users);
    }

    private function createUserResponseData($id, $loginId, $birthday, $permission, $createDate)
    {
        return new UserResponseData(
            $id,
            $loginId,
            $birthday,
            $permission,
            $createDate
        );
    }
}
