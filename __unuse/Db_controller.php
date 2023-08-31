<?php

// クラス宣言
<<<<<<<< Updated upstream:classes/db.php
class DB
========
class Db_controller
>>>>>>>> Stashed changes:__unuse/Db_controller.php
{
    static private $_instance = null;

    // プロパティ
    private static DB $instance = null;
    //接続するデータベースの情報
    private PDO $pdo;
    private string $dsn = 'mysql:host=localhost;dbname=nanobase_07;port=3306';
    private string $user = 'root';
    private string $password = '';

<<<<<<<< Updated upstream:classes/db.php
========
    public $pdo;
>>>>>>>> Stashed changes:__unuse/Db_controller.php

    // コンストラクタ
    private function __construct()
    {
        try {
            // データベースへの接続開始
            $this->pdo = new PDO($this->dsn, $this->user, $this->password, array(PDO::ATTR_PERSISTENT => true));
        } catch (PDOException $e) {
            // データベースへの接続に失敗した場合
            die($e->getMessage());
        }
    }

    static public function getInstance(){
        if (!isset($_instance)){
            $_instance = new DB();
        }
        return $_instance;
    }

    // メソッド

    public static function getInstance(): ?DB
    {
        if (!isset(self::$instance)) {
            self::$instance = new DB();
        }
        return self::$instance;
    }
    ///
    // ログイン時の認証
    ///
    public function isMatchIdPass($id, $password): ?bool
    {
        try {
            $query = 'SELECT loginId, password, permission FROM users WHERE loginId = :id;';
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

    ///
    // GET:ユーザー情報
    // 引数で与えられたユーザーの情報を返す
    // ⇒オブジェクトで返すようにした方がいい
    ///
    public function get_UserInfo($id): ?array
    {
        $query = 'SELECT loginId, permission, birthday, createdDate FROM users WHERE loginId = :id;';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);

        return $queryResult;
    }

    ///
    // GET:ユーザーリスト
    // DBのユーザー情報を全て返す
    // $permissionLevel= 0 or 1 : 一般/アドミンで返す情報を切り替える
    ///
    public function get_UserList($permissionLevel = 0): ?array
    {
        switch ($permissionLevel) { //一般ユーザー

            case 0:
                echo '一般ユーザーです';

                try {
                    $query = 'SELECT id, loginId, birthday, permission FROM users';
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute();
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    $e->getMessage();
                }

                return $queryResult;
            case 1:
                echo '管理者ユーザーです';

                try {
                    $query = 'SELECT id, loginId, birthday, permission, createdDate FROM users';
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute();
                    $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    $e->getMessage();
                }

                return $queryResult;
            default:
                echo 'Unexpected error occured at get_UserList method.';
                return ['name' => 'エラー'];
        }
    }
    ///
    // ユーザー登録時の処理
    // （現在はID重複チェックしかない。今後、チェックが増えるにつれて返り値をboolではなくて、別のものにしたほうがいいかも）
    ///
    public function createUser($id, $password): ?bool
    {
        try {
            // IDが既に登録されていないか確認
            $query = 'SELECT loginId FROM users WHERE loginId = :id;';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $queryResult = $stmt->fetch();

            if ($queryResult['loginId'] ?? "") {
                // IDが重複している場合
                echo '認証失敗';
                return false;
            } else {
                // IDが重複していなければinsert
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);

                $query = 'INSERT INTO users(loginId, password) VALUES(:id, :password);';
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':password', $hash_pass);
                $stmt->execute();

                return true;
            }
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            return false;
        }
    }
}