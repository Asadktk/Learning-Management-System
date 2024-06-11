<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class User
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function attempt($email, $password)
    {
        $user = $this->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        }

        return false;
    }

    public function getUserByEmail($email)
    {
        // Retrieve user record from the database based on the provided email
        $sql = 'SELECT * FROM users WHERE email = :email';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function registerUser($name, $email, $password, $role_id)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->db->connection->beginTransaction();

        try {
            $sql = 'INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)';
            $statement = $this->db->connection->prepare($sql);
            $statement->execute(['name' => $name, 'email' => $email, 'password' => $hashedPassword, 'role_id' => $role_id]);

            if ($statement->rowCount() > 0) {
                $userId = $this->db->connection->lastInsertId();

                if ($role_id == 3) {    
                    $sql = 'INSERT INTO students (user_id) VALUES (:user_id)';
                } elseif ($role_id == 2) {
                    $sql = 'INSERT INTO instructors (user_id) VALUES (:user_id)';
                }

                $statement = $this->db->connection->prepare($sql);
                $statement->execute(['user_id' => $userId]);

                if ($statement->rowCount() <= 0) {
                    $this->db->connection->rollBack();
                    return false;
                }

                $this->db->connection->commit();
                return true;
            }
        } catch (\PDOException $e) {
            $this->db->connection->rollBack();
            return false;
        }

        return false;
    }

    public function getInstructorByEmail($email)
    {
        $sql = 'SELECT instructors.id AS instructor_id, users.email
                FROM users
                INNER JOIN instructors ON users.id = instructors.user_id
                WHERE users.email = :email';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['email' => $email]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
    
}
