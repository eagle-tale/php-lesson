<?php
interface IUserRepository
{
    public function find($id);

    public function findAll();

    public function save(UserModel $user, $password);

    public function delete(UserModel $user);

    public function update(UserModel $oldUser, UserModel $newUser);
}
