<?php

include_once('..\repositories\IUserRepository.php');
include_once('..\db.php');

class UserRepository implements IUserRepository
{

    private readonly DB $db;
    private readonly PDO $pdo;

    public function __construct()
    {
        $db = DB::getInstance();
        $this->db = $db;
        $this->pdo = $db->pdo;
    }

    public function find($id)
    {
        try {
            $query = "SELECT * FROM users WHERE loginId = :id;";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
            return $queryResult;
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function findAll()
    {
        try {
            $query = 'SELECT id, loginId, birthday, permission, createdDate FROM users';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $queryResult;
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function save(UserModel $user, $password)
    {
        try {
            $hash_pass = password_hash($password, PASSWORD_DEFAULT);

            $loginId = $user->loginId;
            $birthday = $user->birthday;
            $query = 'INSERT INTO users(loginId, password, birthday) VALUES(:loginId, :password, :birthday);';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':loginId', $loginId);
            $stmt->bindParam(':password', $hash_pass);
            $stmt->bindParam(':birthday', $birthday);
            $stmt->execute();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }
}
