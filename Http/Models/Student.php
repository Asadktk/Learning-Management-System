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

        // Fetch courses with the specific instructor for each enrollment
        $sqlCourses = 'SELECT cr.*, ic.instructor_id, u_instructor.name AS instructor_name, u_instructor.email AS instructor_email
                   FROM enrollments AS e
                   JOIN courses AS cr ON e.course_id = cr.id
                   JOIN instructor_course AS ic ON e.id = ic.enrollment_id
                   JOIN instructors AS i ON ic.instructor_id = i.id
                   JOIN users AS u_instructor ON i.user_id = u_instructor.id
                   WHERE e.student_id = :id';
        $statementCourses = $this->db->connection->prepare($sqlCourses);
        $statementCourses->bindParam(':id', $id);
        $statementCourses->execute();
        $courses = $statementCourses->fetchAll(\PDO::FETCH_ASSOC);

        // Fetch classes for each course with the specific instructor
        $classes = [];
        foreach ($courses as $course) {
            $sqlClasses = 'SELECT c.*, u_instructor.name as instructor_name, u_instructor.email as instructor_email
                       FROM classes AS c
                       JOIN instructors AS i ON c.instructor_id = i.id
                       JOIN users AS u_instructor ON i.user_id = u_instructor.id
                       WHERE c.course_id = :course_id AND i.id = :instructor_id';
            $statementClasses = $this->db->connection->prepare($sqlClasses);
            $statementClasses->bindParam(':course_id', $course['id']);
            $statementClasses->bindParam(':instructor_id', $course['instructor_id']);
            $statementClasses->execute();
            $classesForCourse = $statementClasses->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($classesForCourse as $class) {
                $class['course'] = $course;
                $classes[] = $class;
            }
        }

        $student['courses'] = $courses;
        $student['classes'] = $classes;

        return $student;
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
