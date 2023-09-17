<?php

include_once('..\repositories\IAuthRepository.php');
include_once('..\db.php');

class AuthRepository implements IAuthRepository
{
    private readonly PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getInstance()->pdo;
    }

    // mailをキーにDB検索し見つかったら結果を配列で返す
    public function find($mail)
    {
        try {
            $query = "SELECT * FROM auth WHERE mail = :mail;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            return $queryResult;
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function add_passcode($mail, $passcode)
    {
        if (empty($this->find($mail))) {
            try {
                //存在していなければ新たにINSERT
                $query = "INSERT INTO auth (mail, passcode) VALUE (:mail, :passcode);";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
                $stmt->bindValue(':passcode', $passcode, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
                throw $e;
            }
        } else {
            // 存在していればUPDATE
            try {
                $query = "UPDATE auth SET passcode = :passcode WHERE mail = :mail;";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
                $stmt->bindValue(':passcode', $passcode, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
                throw $e;
            }
        }
    }

    public function get_passcode($mail)
    // 課題:本当はモデルをreturnするほうがいいんじゃないか。
    {
        $passcode = $this->find($mail)['passcode'];
        return $passcode;
    }

    public function add_failCount($mail)
    {
        try {
            $query = "UPDATE auth SET failCount = failCount+1 WHERE mail = :mail;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function reset_failCount($mail)
    {
        try {
            $query = "UPDATE auth SET failCount = 0 WHERE mail = :mail;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function lock_user($mail)
    {
        try {
            $query = "UPDATE auth SET isLock = 1 WHERE mail = :mail;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function set_passcodeUsed($mail)
    {
        try {
            $query = "UPDATE auth SET isUsed = 1 WHERE mail = :mail;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function is_passcodeUsed($mail)
    {
        return !empty($this->find($mail)['isUsed']);
    }

    public function is_userLocked($mail)
    {
        return !empty($this->find($mail)['isLock']);
    }
}
