<?php

include_once('..\repositories\IAuthRepository.php');
include_once('..\models\AuthModel.php');
include_once('..\db.php');

class AuthRepository implements IAuthRepository
{
    private readonly DB $db;
    private readonly PDO $pdo;

    public function __construct()
    {
        $db = DB::getInstance();
        $this->db = $db;
        $this->pdo = $db->pdo;
    }

    public function find($mail)
    {
        try {
            $query = "SELECT * FROM users WHERE mail = :mail;";
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
    {
        try {
            $query = "SELECT passcode, isUsed FROM auth WHERE mail = :mail;";
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
}
