<?php

namespace Http\Models;

use Core\App;
use Exception;
use Core\Database;

class Enrollment
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }


    public function enrollStudent($courseId, $instructorId, $userId)
    {
        $sql = 'SELECT id FROM students WHERE user_id = :userId';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['userId' => $userId]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {

            throw new Exception("Student ID not found for user ID: $userId");
        }

        $studentId = $result['id'];

        // Insert the enrollment record into the enrollments table
        $sql = 'INSERT INTO enrollments (instructorcourse_id, student_id, enrollment_date) 
                VALUES (
                    (SELECT id FROM instructor_course WHERE course_id = :courseId AND instructor_id = :instructorId),
                    :studentId,
                    NOW()
                )';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['courseId' => $courseId, 'instructorId' => $instructorId, 'studentId' => $studentId]);
    }

    public function isStudentEnrolled($courseId, $userId)
    {
        $sql = 'SELECT COUNT(*) AS count
                FROM enrollments e
                JOIN students s ON e.student_id = s.id
                WHERE s.user_id = :userId
                AND e.instructorcourse_id IN (
                    SELECT id
                    FROM instructor_course
                    WHERE course_id = :courseId
                )';

        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['userId' => $userId, 'courseId' => $courseId]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    // Enrollment model method
    public function getEnrolledStudentsCount($courseId, $instructorId)
    {
        // SQL query to count enrolled students
        $sql = 'SELECT COUNT(*) as enrolled_students 
                FROM enrollments e
                JOIN instructor_course ic ON e.instructorcourse_id = ic.id
                WHERE ic.course_id = :courseId AND ic.instructor_id = :instructorId';
        $statement = $this->db->connection->prepare($sql);
        $statement->bindValue(':courseId', $courseId, \PDO::PARAM_INT);
        $statement->bindValue(':instructorId', $instructorId, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result['enrolled_students'];
    }
}
