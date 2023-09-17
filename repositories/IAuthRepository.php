<?php
interface IAuthRepository
{
    public function find($mail);

    public function add_passcode($mail, $passcode);

    public function get_passcode($mail);

    public function add_failCount($mail);

    public function reset_failCount($mail);

    public function lock_user($mail);

    public function set_passcodeUsed($mail);
}
