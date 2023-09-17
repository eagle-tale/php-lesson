<?php

// クラス宣言
class DB
{
    static private $_instance = null;

    // プロパティ
    //接続するデータベースの情報
    protected $dsn = 'mysql:host=localhost;dbname=nanobase_07;port=3306';
    protected $user = 'root';
    protected $password = '';

    public $pdo;

    // コンストラクタ
    private function __construct()
    {
        try {
            // データベースへの接続開始
            $this->pdo = new PDO($this->dsn, $this->user, $this->password, array(PDO::ATTR_PERSISTENT => true));
        } catch (PDOException $e) {
            // データベースへの接続に失敗した場合
            echo ('データベースに接続できませんでした。' . $e->getMessage());
        }
    }

    static public function getInstance()
    {
        if (!isset($_instance)) {
            $_instance = new DB();
        }
        return $_instance;
    }
}
