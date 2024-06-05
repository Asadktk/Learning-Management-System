<?php

namespace Core;

class Seeder
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function run()
    {
        $this->createTables();
        $this->seedData();
    }

    protected function createTables()
    {
        $this->db->query("

        CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL
        );
           
        ");
    }

    protected function seedData()
    {
        $this->db->query("INSERT INTO roles (name) VALUES
        ('admin'),
        ('instructor'),
        ('student')
    ");
    }
}
