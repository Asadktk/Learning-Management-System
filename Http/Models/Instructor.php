<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class Instructor
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getAllInstructors()
    {
        $sql = 'SELECT i.*, u.name, u.email FROM instructors AS i 
            JOIN users AS u ON i.user_id = u.id 
            WHERE u.role_id = 2 ';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    
}
