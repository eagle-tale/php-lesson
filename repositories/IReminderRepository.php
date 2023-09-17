<?php
interface IReminderRepository
{
    public function save($user_id, $hash, $expire_date);

    public function findUserFromHash($hash);
}
