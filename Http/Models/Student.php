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

    public function getAllStudents($active = true)
    {
        $activeCondition = $active ? 'IS NULL' : 'IS NOT NULL';

        $sql = 'SELECT i.*, u.name, u.email FROM students AS i 
            JOIN users AS u ON i.user_id = u.id 
            WHERE u.role_id = 3 AND i.deleted_at ' . $activeCondition;
        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getStudentById($id)
    {
        // Fetch student details along with user information
        $sql = 'SELECT s.*, u.name as user_name, u.email as user_email
                FROM students AS s 
                JOIN users AS u ON s.user_id = u.id 
                WHERE u.role_id = 3 AND s.id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $student = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$student) {
            return null;
        }

        // Fetch courses and instructors for each enrollment using the instructor_course table
        $sqlCourses = 'SELECT cr.*, ic.instructor_id, u_instructor.name AS instructor_name, u_instructor.email AS instructor_email
                       FROM enrollments AS e
                       JOIN instructor_course AS ic ON e.instructorcourse_id = ic.id
                       JOIN courses AS cr ON ic.course_id = cr.id
                       JOIN instructors AS i ON ic.instructor_id = i.id
                       JOIN users AS u_instructor ON i.user_id = u_instructor.id
                       WHERE e.student_id = :student_id';
        $statementCourses = $this->db->connection->prepare($sqlCourses);
        $statementCourses->bindParam(':student_id', $id);
        $statementCourses->execute();
        $courses = $statementCourses->fetchAll(\PDO::FETCH_ASSOC);

        if (!$courses) {
            // Debugging step: Print the query or an error message
            // echo "No courses found for the student.";
            return null;
        }

        // Debugging step: Print courses
        // echo '<pre>';
        // print_r($courses);
        // echo '</pre>';
        // die();

        $student['courses'] = $courses;

        return $student;
    }

    public function getStudentDetails($userId)
    {
        $sql = 'SELECT s.user_id, u.name, u.email, u.password
                FROM students s
                JOIN users u ON s.user_id = u.id
                WHERE s.user_id = :userId';

        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['userId' => $userId]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }



    public function softDelete($id)
    {
        $sql = 'UPDATE students SET deleted_at = NOW() WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }

    public function unblock($id)
    {
        $sql = 'UPDATE students SET deleted_at = NULL WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM students WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }
}
