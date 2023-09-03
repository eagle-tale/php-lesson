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

    // メソッド

    ///
    // ログイン時の認証
    ///
    public function isMatchIdPass($id, $password): ?bool
    {
        try {
            $query = 'SELECT mail, password, permission FROM users WHERE mail = :id;';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $queryResult = $stmt->fetch();

            // 認証処理(指定したハッシュがパスワードにマッチしているかチェック)
            if (password_verify($password, $queryResult['password'])) {
                echo '認証成功';

                return true;
            } else {
                echo '認証失敗';

                return false;
            }
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            return false;
        }
    }
}
