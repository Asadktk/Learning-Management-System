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

        $sql = 'SELECT user_id FROM instructors WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
        $user_id = $statement->fetchColumn();

        if ($user_id) {

            $sql = 'UPDATE instructors SET deleted_at = NOW() WHERE id = :id';
            $statement = $this->db->connection->prepare($sql);
            $statement->execute(['id' => $id]);


            $sql = 'UPDATE users SET deleted_at = NOW() WHERE id = :user_id';
            $statement = $this->db->connection->prepare($sql);
            $statement->execute(['user_id' => $user_id]);
        }
    }


    public function unblock($id)
    {

        $sql = 'SELECT user_id FROM instructors WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
        $user_id = $statement->fetchColumn();

        if ($user_id) {

            $sql = 'UPDATE instructors SET deleted_at = NULL WHERE id = :id';
            $statement = $this->db->connection->prepare($sql);
            $statement->execute(['id' => $id]);


            $sql = 'UPDATE users SET deleted_at = NULL WHERE id = :user_id';
            $statement = $this->db->connection->prepare($sql);
            $statement->execute(['user_id' => $user_id]);
        }
    }






    public function delete($id)
    {
        $sql = 'DELETE FROM instructors WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }


    public function countActiveInstructors()
    {
        $sql = 'SELECT COUNT(*) AS total_active_instructors 
            FROM instructors 
            WHERE deleted_at IS NULL';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result['total_active_instructors'];
    }


    public function getInstructorDetails($userId)
    {
        $sql = 'SELECT i.user_id, u.name, u.email, u.password
                FROM instructors i
                JOIN users u ON i.user_id = u.id
                WHERE i.user_id = :userId';

        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['userId' => $userId]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function getInstructorDetail($userId)
    {
        $sql = 'SELECT i.id, u.name, u.email, u.password
            FROM instructors i
            JOIN users u ON i.user_id = u.id
            WHERE i.user_id = :userId';

        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['userId' => $userId]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }


    public function getInstructorDetailsByUserId($userId)
    {
        $sql = "SELECT i.*, u.name as user_name, u.email as user_email
                FROM instructors i
                INNER JOIN users u ON i.user_id = u.id
                WHERE u.id = :userId";

        $statement = $this->db->connection->prepare($sql);
        $statement->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $name, $hashedPassword)
    {
        // SQL query to update the user's name and password (if provided)
        $query = "UPDATE instructors i
                  INNER JOIN users u ON i.user_id = u.id
                  SET u.name = :name";

        // Include password update if a new password is provided
        if (!empty($hashedPassword)) {
            $query .= ", u.password = :password";
        }

        $query .= " WHERE u.id = :userId";

        // Prepare the statement
        $statement = $this->db->connection->prepare($query);

        // Bind parameters
        $statement->bindValue(':name', $name, \PDO::PARAM_STR);
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);

        // Bind hashed password if provided
        if (!empty($hashedPassword)) {
            $statement->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
        }

        // Execute the statement
        $success = $statement->execute();

        return $success;
    }

    public function getHashedPassword($userId)
    {
        $query = "SELECT u.password
                  FROM users u
                  INNER JOIN instructors i ON u.id = i.user_id
                  WHERE i.user_id = :userId";

        $statement = $this->db->connection->prepare($query);
        $statement->execute(['userId' => $userId]);
        $result = $statement->fetchColumn(); // Assuming password is a single column

        return $result;
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
