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

    public function register($mail, $password, $birthday)
    {
        $newUser = new UserModel($mail, $birthday);

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
            $userInfo['mail'],
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
                $user['mail'],
                $user['birthday'],
                $user['permission'],
                $user['createdDate']
            );
        }, $users);
    }

    private function createUserResponseData($id, $mail, $birthday, $permission, $createDate)
    {
        return new UserResponseData(
            $id,
            $mail,
            $birthday,
            $permission,
            $createDate
        );
    }

    public function delete($mail)
    {
        $user = new UserModel($mail);

        // メモ：本来であればここで一度管理者による実行かどうかチェックした方がよい
        // （ブラウザ側のSESSIONでのみ判断しているため）

        // userServiceで重複確認
        if (!$this->userService->exists($user)) {
            throw new ApplicationServiceException('そのユーザーは存在しません');
        }

        // userRepositoryで削除
        return $this->userRepository->delete($user);
    }

    public function update($oldLoginId, $newLoginId, $birthday)
    {
        $oldUser = new UserModel($oldLoginId);
        $newUser = new UserModel($newLoginId, $birthday);

        // メモ：本来であればここで一度管理者による実行かどうかチェックした方がよい
        // （ブラウザ側のSESSIONでのみ判断しているため）

        // userServiceで存在確認
        if (!$this->userService->exists($oldUser)) {
            throw new ApplicationServiceException('そのユーザーは存在しません');
        }

        // userServiceで重複確認
        if ($this->userService->exists($newUser)) {
            throw new ApplicationServiceException('すでにそのmailは登録されています');
        }


        $oldUser->birthday = $this->userRepository->find($oldUser->id)->birthday;

        // userRepositoryで更新
        $this->userRepository->update($oldUser, $newUser);
        return true;
    }
}
