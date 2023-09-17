<?php
include_once('..\repositories\AuthRepository.php');

class AuthModel
{
    // MySQL側authテーブル
    // mail         varchar(512)
    // passcode     text
    // isUsed       tinyint(1)
    // failCount    int(10)     Default:0
    // isLock       tinyint(1)  Default:0

    //プロパティ
    private readonly AuthRepository $authRepository;
    public $mail;
    private $passcode;
    public $isUsed;
    public $failCount;
    public $isLock;

    // 課題: 全然モデルを使いこなせていない
    public function __construct($mail)
    {
        $auth = $this->authRepository->find($mail);
        $this->mail = $auth['mail'];
        $this->passcode = $auth['passcode'];
        $this->isUsed = $auth['isUsed'];
        $this->failCount = $auth['failCount'];
        $this->isLock = $auth['isLock'];
    }
}
