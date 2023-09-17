<?php
class UserResponseData
{
    // プロパティ
    public $id;
    public $mail;
    public $birthday;
    public $permission;
    public $createdDate;

    // TODO: 本当はコンストラクタでUserModel受け取った方が良い
    public function __construct($id, $mail, $birthday, $permission, $createdDate)
    {
        $this->id = $id;
        $this->mail = $mail;
        $this->birthday = $birthday;
        $this->permission = $permission;
        $this->createdDate = $createdDate;
    }
}
