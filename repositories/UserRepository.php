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
            $query = "SELECT * FROM users WHERE mail = :id;";
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
            $query = 'SELECT id, mail, birthday, permission, createdDate FROM users';
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

            $mail = $user->mail;
            $birthday = $user->birthday;
            $query = 'INSERT INTO users(mail, password, birthday) VALUES(:mail, :password, :birthday);';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':password', $hash_pass);
            $stmt->bindParam(':birthday', $birthday);
            $stmt->execute();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function delete(UserModel $user)
    {
        // メモ：本来であれば、deletingFlagを1にする、等の方法を用い、実際にユーザーデータは消さない方がいい。
        try {
            $mail = $user->mail;
            $query = 'DELETE FROM users WHERE mail = :mail;';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }

    public function update(UserModel $oldUser, UserModel $newUser)
    {
        $new_mail = !empty($newUser->mail) ? $newUser->mail : $oldUser->mail;
        $new_birthday = !empty($newUser->birthday) ? $newUser->birthday : $oldUser->birthday;

        try {
            $query = 'UPDATE users SET mail = :new_mail, birthday = :new_birthday WHERE mail = :mail;';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':mail', $oldUser->mail);
            $stmt->bindParam(':new_mail', $new_mail);
            $stmt->bindParam(':new_birthday', $new_birthday);
            $stmt->execute();
        } catch (PDOException $e) {
            echo ('データベースエラー（PDOエラー）:' . $e->getMessage());
            throw $e;
        }
    }
}
