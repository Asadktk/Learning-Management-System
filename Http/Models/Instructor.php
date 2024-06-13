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

    public function getAllInstructors($active = true)
    {
        // Constructing the WHERE condition based on the $active parameter
        $activeCondition = $active ? 'IS NULL' : 'IS NOT NULL';

        // Your SQL query with the dynamic WHERE clause
        $sql = 'SELECT i.*, u.name, u.email FROM instructors AS i 
            JOIN users AS u ON i.user_id = u.id 
            WHERE u.role_id = 2 AND i.deleted_at ' . $activeCondition;

        // Prepare and execute the statement
        $statement = $this->db->connection->prepare($sql);
        $statement->execute();

        // Fetch and return the result
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function getInstructorById($id)
    {
        $sql = 'SELECT i.*, u.name as user_name, u.email as user_email, c.id as class_id, c.course_id, cr.title, cr.description as course_description, cr.fee, cr.available_seat, cr.start_date, cr.end_date
            FROM instructors AS i 
            JOIN users AS u ON i.user_id = u.id 
            LEFT JOIN classes AS c ON i.id = c.instructor_id
            LEFT JOIN courses AS cr ON c.course_id = cr.id
            WHERE u.role_id = 2 AND i.id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $instructor = $statement->fetch(\PDO::FETCH_ASSOC);

        // Fetch all classes created by the instructor
        $sqlClasses = 'SELECT c.*, cr.title, cr.description as course_description, cr.fee, cr.available_seat, cr.start_date, cr.end_date, u.name as user_name, u.email as user_email
            FROM classes AS c
            LEFT JOIN courses AS cr ON c.course_id = cr.id
            LEFT JOIN instructors AS i ON c.instructor_id = i.id
            LEFT JOIN users AS u ON i.user_id = u.id
            WHERE c.instructor_id = :id';
        $statementClasses = $this->db->connection->prepare($sqlClasses);
        $statementClasses->bindParam(':id', $id);
        $statementClasses->execute();
        $classes = $statementClasses->fetchAll(\PDO::FETCH_ASSOC);

        $instructor['classes'] = $classes;

        return $instructor;
    }


    public function softDelete($id)
    {
        $sql = 'UPDATE instructors SET deleted_at = NOW() WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }

    public function unblock($id)
    {
        $sql = 'UPDATE instructors SET deleted_at = NULL WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM instructors WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }


    


    // public function updateInstructor($id, $name, $email, $password, $role_id)
    // {
    //     $sql = 'UPDATE users SET name = :name, email = :email, password = :password, role_id = :role_id WHERE id = :id';
    //     $statement = $this->db->connection->prepare($sql);
    //     $statement->bindParam(':name', $name);
    //     $statement->bindParam(':email', $email);
    //     $statement->bindParam(':password', $password); // You should hash the password before binding
    //     $statement->bindParam(':role_id', $role_id);
    //     $statement->bindParam(':id', $id);
    //     $statement->execute();
    // }


}
