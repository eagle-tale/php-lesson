<?php
interface IUserRepository
{
    public function find($mail);

    public function findAll();

    public function save(UserModel $user, $password);

    public function delete(UserModel $user);

    public function update(UserModel $oldUser, UserModel $newUser);

    public function updatePassword(int $id, $new_password);
}
