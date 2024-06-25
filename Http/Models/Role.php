<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class Role
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    // public function getAllRoles()
    // {

    //     $sql = 'SELECT * FROM roles';
    //     $statement = $this->db->connection->prepare($sql);
    //     $statement->execute();
    //     return $statement->fetchAll(\PDO::FETCH_ASSOC);
    // }

    public function getAllRoles()
    {
        $sql = 'SELECT * FROM roles WHERE role != :admin';
        $statement = $this->db->connection->prepare($sql);
        $statement->bindValue(':admin', 'admin');
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
