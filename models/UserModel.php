<?php

// クラス宣言
class UserModel
{

    // プロパティ
    public $id;
    public $loginId;
    public $birthday;
    public $permission;
    public $createdDate;

    public function __construct($loginId, $birthday = "")
    {
        $this->loginId = $loginId;
        $this->birthday = $birthday;
    }
}
