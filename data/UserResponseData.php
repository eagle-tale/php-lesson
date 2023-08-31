<?php
class UserResponseData {
    // プロパティ
    public $id;
    public $loginId;
    public $birthday;
    public $permission;
    public $createdDate;

    // TODO: 本当はコンストラクタでUserModel受け取った方が良い
    public function __construct($id, $loginId, $birthday, $permission, $createdDate) {
        $this->id = $id;
        $this->loginId = $loginId;
        $this->birthday = $birthday;
        $this->permission = $permission;
        $this->createdDate = $createdDate;
    }
}