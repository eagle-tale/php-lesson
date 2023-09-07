<?php

class AuthModel
{
    // MySQL側authテーブル
    // mail         varchar(512)
    // passcode     text
    // isUsed       tinyint(1)
    // failCount    int(10)     Default:0
    // isLock       tinyint(1)  Default:0

    //プロパティ
    private $mail;
    private $passcode;
    private $isUsed;
    private $failCount;
    private $isLock;
}
