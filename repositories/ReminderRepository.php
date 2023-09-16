<?php

include_once('..\repositories\IReminderRepository.php');
include_once('..\db.php');

class ReminderRepository implements IReminderRepository
{
    private readonly DB $db;
    private readonly PDO $pdo;

    public function __construct()
    {
        $db = DB::getInstance();
        $this->db = $db;
        $this->pdo = $db->pdo;
    }

    public function save($user_id, $hash, $expire_date)
    {
        try {
            $query = 'INSERT INTO reminder(user_id, hash, expire_date) VALUES(:user_id, :hash, :expire_date);';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':hash', $hash);
            $stmt->bindParam(':expire_date', $expire_date);
            $stmt->execute();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function findUserFromHash($hash)
    {
        try {
            $query = "SELECT user_id FROM reminder WHERE hash = :hash;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':hash', $hash, PDO::PARAM_STR);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            return $queryResult;
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }
}
