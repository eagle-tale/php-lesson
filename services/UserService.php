<?php
include_once('..\repositories\IUserRepository.php');
include_once('..\models\UserModel.php');

class UserService
{
    private readonly IUserRepository $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function exists(UserModel $user)
    {
        $res = $this->userRepository->find($user->mail);
        // 戻り値にユーザーデータが入っていればすでに存在するデータ
        return !empty($res);
    }

    public function delete(UserModel $user)
    {
        $this->userRepository->delete($user);
        return true;
    }

    public function update(UserModel $oldUser, UserModel $newUser)
    {
        $this->userRepository->update($oldUser, $newUser);
        return true;
    }

    public function isValidUserInfo($id, $password)
    {
        $res = $this->userRepository->find($id);
        // 認証処理(指定したハッシュがパスワードにマッチしているかチェック)
        if (password_verify($password, $res['password'])) {
            echo '認証成功';
            return true;
        } else {
            echo '認証失敗';
            return false;
        }
    }
}
