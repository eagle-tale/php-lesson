<?php

use function PHPUnit\Framework\isEmpty;

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

    public function userInfo($mail)
    {
        // TODO: 本当はUserModelを作ってcreateUserResponseDataに渡した方が良い
        $userInfo = $this->userRepository->find($mail);

        if ($userInfo == NULL) {
            // IDが見つからない場合
            return NULL;
        }

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
        // TODO: 本当はUserModelを作ってcreateUserResponseDataに渡した方が良い
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
    // TODO: 本当はUserModelを受け取ってUserResponseDataに渡した方が良い
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

        // userServiceで削除
        return $this->userService->delete($user);
    }

    public function update($oldLoginId, $newLoginId, $birthday)
    {
        // TODO：本来であれば管理者による実行かどうかチェックした方がよい
        // （ブラウザ側のSESSIONでのみ判断しているため）

        $oldUser = new UserModel($oldLoginId);
        $oldUser->birthday = $this->userRepository->find($oldUser->mail)['birthday'];
        $birthday = !empty($birthday) ? $birthday : $oldUser->birthday;
        $newUser = new UserModel($newLoginId, $birthday);

        // userServiceで存在確認
        if (!$this->userService->exists($oldUser)) {
            throw new ApplicationServiceException('そのユーザーは存在しません');
        }

        if (!empty($newLoginId)) {
            // 変更後のメールアドレスが入力されている場合
            // userServiceで重複確認
            if ($this->userService->exists($newUser)) {
                throw new ApplicationServiceException('すでにそのmailは登録されています');
            }
        } else {
            $newUser->mail = $oldUser->mail;
        }

        // userServiceで更新
        $this->userService->update($oldUser, $newUser);
        return true;
    }

    public function updatePassword($id, $password)
    {
        return $this->userRepository->updatePassword($id, $password);
    }
}
