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
        $res = $this->userRepository->find($user->loginId);
        // 戻り値にユーザーデータが入っていればすでに存在するデータ
        return !empty($res);
    }

    public function delete(UserModel $user)
    {
        $res = $this->userRepository->delete($user->loginId);
        return true;
    }

    public function update(UserModel $oldUser, UserModel $newUser)
    {
        $res = $this->userRepository->update($oldUser, $newUser);
        return true;
    }



    public function isValidUserInfo($id, $password)
    {
        $res = $this->userRepository->find($id);
        print_r('findのクエリ結果:');
        print_r($res);
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
