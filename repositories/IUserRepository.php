<?php
interface IUserRepository
{
    public function find($id);

    public function findAll();

    public function save(UserModel $user, $password);
}
