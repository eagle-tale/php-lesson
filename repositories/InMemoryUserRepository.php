<?php
class InMemoryUserRepository implements IUserRepository
{

    private $userStore;

    public function __construct()
    {
        $this->userStore = new UserStore();
    }

    public function find($id)
    {
        return $this->userStore->find($id);
    }

    public function findAll()
    {
        try {
            return $this->userStore->findAll();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function save(UserModel $user, $password)
    {
        $hash_pass = password_hash($password, PASSWORD_DEFAULT);
        $this->userStore->save($user);
    }

    public function delete(UserModel $user)
    {
        $this->userStore->delete($user);
    }

    public function update(UserModel $oldUser, UserModel $newUser)
    {
        $this->userStore->update($oldUser, $newUser);
    }

    public function updatePassword(int $id, $new_password)
    {
        return true;
    }
}
