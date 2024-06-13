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

    public function enrollStudentInCourse($studentId, $courseId, $instructorId)
    {
        // Check if the student exists
        $sqlStudent = 'SELECT id FROM students WHERE id = :studentId';
        $statementStudent = $this->db->connection->prepare($sqlStudent);
        $statementStudent->bindParam(':studentId', $studentId);
        $statementStudent->execute();
        $student = $statementStudent->fetch(\PDO::FETCH_ASSOC);

        if (!$student) {
            throw new Exception('Student not found');
        }

        // Check if the course exists
        $sqlCourse = 'SELECT id FROM courses WHERE id = :courseId';
        $statementCourse = $this->db->connection->prepare($sqlCourse);
        $statementCourse->bindParam(':courseId', $courseId);
        $statementCourse->execute();
        $course = $statementCourse->fetch(\PDO::FETCH_ASSOC);

        if (!$course) {
            throw new Exception('Course not found');
        }

        // Check if the instructor exists and is associated with the course
        $sqlInstructor = 'SELECT ic.id FROM instructor_course AS ic
                      JOIN instructors AS i ON ic.instructor_id = i.id
                      WHERE ic.course_id = :courseId AND i.id = :instructorId';
        $statementInstructor = $this->db->connection->prepare($sqlInstructor);
        $statementInstructor->bindParam(':courseId', $courseId);
        $statementInstructor->bindParam(':instructorId', $instructorId);
        $statementInstructor->execute();
        $instructorCourse = $statementInstructor->fetch(\PDO::FETCH_ASSOC);

        if (!$instructorCourse) {
            throw new Exception('Instructor not found for the given course');
        }

        // Create the enrollment record with enrollment_date
        $enrollmentDate = date('Y-m-d H:i:s'); 
        $sqlEnrollment = 'INSERT INTO enrollments (student_id, course_id, enrollment_date) VALUES (:studentId, :courseId, :enrollmentDate)';
        $statementEnrollment = $this->db->connection->prepare($sqlEnrollment);
        $statementEnrollment->bindParam(':studentId', $studentId);
        $statementEnrollment->bindParam(':courseId', $courseId);
        $statementEnrollment->bindParam(':enrollmentDate', $enrollmentDate);
        $statementEnrollment->execute();
        $enrollmentId = $this->db->connection->lastInsertId();

        // Associate the enrollment with the instructor
        $sqlInstructorCourse = 'INSERT INTO instructor_course (instructor_id, course_id, enrollment_id) VALUES (:instructorId, :courseId, :enrollmentId)';
        $statementInstructorCourse = $this->db->connection->prepare($sqlInstructorCourse);
        $statementInstructorCourse->bindParam(':instructorId', $instructorId);
        $statementInstructorCourse->bindParam(':courseId', $courseId);
        $statementInstructorCourse->bindParam(':enrollmentId', $enrollmentId);
        $statementInstructorCourse->execute();

        return $enrollmentId;
    }
}
