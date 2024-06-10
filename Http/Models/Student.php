<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class Student
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getAllStudent()
    {
        $sql = 'SELECT i.*, u.name, u.email FROM students AS i 
            JOIN users AS u ON i.user_id = u.id 
            WHERE u.role_id = 3 ';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
