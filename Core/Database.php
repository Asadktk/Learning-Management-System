<?php

namespace Core;

use PDO;

class Database
{
    public $connection;
    public $statement;
    public function __construct($config, $username = 'root', $password = '')
    {


        $dsn = 'mysql:' . http_build_query($config, '', ';');
        // $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
        $this->connection = new PDO($dsn, $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
        // return $statement;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }
    public function find()
    {
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();

        if (!$result) {
            abort();
        }

        return $result;
    }

    // Method to execute SQL queries for table creation or seeding
    public function executeRaw($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    // Method to create a table
    public function createTable($tableName, $columns)
    {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columns)";
        $this->executeRaw($sql);
    }

    // Method to insert data into a table
    public function seedData($tableName, $data)
    {
        foreach ($data as $row) {
            $keys = array_keys($row);
            $columns = implode(', ', $keys);
            $placeholders = implode(', ', array_fill(0, count($keys), '?'));
            $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
            $this->executeRaw($sql, array_values($row));
        }
    }

    public function tableExists($tableName)
    {
        $stmt = $this->connection->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$tableName]);
        return $stmt->rowCount() > 0;
    }

    public function addForeignKey($tableName, $columnName, $refTableName, $refColumnName)
    {
        $sql = "ALTER TABLE $tableName ADD CONSTRAINT fk_$tableName" . "_" . "$columnName FOREIGN KEY ($columnName) REFERENCES $refTableName($refColumnName)";
        $this->executeRaw($sql);
    }
}
