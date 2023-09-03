<?php

// クラス宣言
class UserModel
{

    // プロパティ
    public $id;
    public $mail;
    public $birthday;
    public $permission;
    public $createdDate;

    public function __construct($mail, $birthday = "")
    {
        $this->mail = $mail;
        $this->birthday = $birthday;
    }
}
