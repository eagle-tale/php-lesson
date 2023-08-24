<?php

// クラス宣言
class User
{

    // プロパティ
    public $id;
    public $age;
    public $name;

    // メソッド
    public function selfIntroduction() 
    {
        echo "名前は $this->name です。年齢は $this->age です。";
    }
}
