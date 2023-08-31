<?php

// クラス宣言
class Menu
{

    // プロパティ
    protected $defaultMenu_array = [
        '<li><a href="./views/user_list.php">ユーザー一覧</a></li>',
        '<li><a href="./views/reset_password.php">パスワード再設定</a></li>',
        '<li><a href="./">TOP</a></li>',
        '<li><a href="./views/logout.php">ログアウト</a></li>'
    ];

    // メソッド
    public function show()
    {
        foreach ($this->defaultMenu_array as $menu) {
            echo $menu;
        }
    }
}
