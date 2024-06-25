<?php

namespace Http\Models;

use Core\App;
use Exception;
use Core\Database;

class Course
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getAllCourses()
    {
        $sql = 'SELECT c.*, GROUP_CONCAT(u.name) AS instructor_names
            FROM courses AS c
            LEFT JOIN instructor_course AS ci ON c.id = ci.course_id
            LEFT JOIN instructors AS i ON ci.instructor_id = i.id
            LEFT JOIN users AS u ON i.user_id = u.id
            GROUP BY c.id';

        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function getCourse(){
        $sql = 'SELECT * from courses';

        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }






    public function getCoursesByInstructorId($instructorId)
    {
        $sql = 'SELECT courses.*, instructors.user_id
                FROM courses
                INNER JOIN instructor_course ON courses.id = instructor_course.course_id
                INNER JOIN instructors ON instructors.id = instructor_course.instructor_id
                WHERE instructors.user_id = :instructorId AND courses.deleted_at IS NULL';

        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['instructorId' => $instructorId]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function getCourseDetails($courseId)
    {
        $sql = 'SELECT courses.*, users.name as instructor_name, GROUP_CONCAT(instructors.id) as instructor_ids, GROUP_CONCAT(users.name) as instructor_names
                FROM courses
                LEFT JOIN instructor_course ON courses.id = instructor_course.course_id
                LEFT JOIN instructors ON instructors.id = instructor_course.instructor_id
                LEFT JOIN users ON users.id = instructors.user_id
                WHERE courses.id = :courseId
                GROUP BY courses.id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['courseId' => $courseId]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }



    public function getAvailableSeats($courseId, $instructorIds)
    {
        // Calculate available seats based on enrolled students
        $enrollmentModel = new Enrollment();

        // Initialize enrolled students count
        $totalEnrolledStudents = 0;

        // Iterate over each instructor to get their enrolled students count
        foreach ($instructorIds as $instructorId) {
            $enrolledStudentsCount = $enrollmentModel->getEnrolledStudentsCount($courseId, $instructorId);
            $totalEnrolledStudents += $enrolledStudentsCount;
        }

        // Fetch total available seats for the course
        $courseDetails = $this->getCourseDetails($courseId);
        $totalSeats = $courseDetails['available_seat'];

        // Calculate available seats
        $availableSeats = $totalSeats - $totalEnrolledStudents;

        return $availableSeats;
    }



    public function getCourseById($courseId)
    {
        $query = "SELECT * FROM courses WHERE id = :course_id";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindValue(':course_id', $courseId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }



    public function createCourse($title, $description, $fee, $availableSeat, $startDate, $endDate)
    {
        $query = "INSERT INTO courses (title, description, fee, available_seat, start_date, end_date) VALUES (:title, :description, :fee, :available_seat, :start_date, :end_date)";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':fee', $fee, \PDO::PARAM_INT);
        $stmt->bindValue(':available_seat', $availableSeat, \PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $startDate);
        $stmt->bindValue(':end_date', $endDate);

        if ($stmt->execute()) {
            return $this->db->connection->lastInsertId();
        } else {
            return false;
        }
    }


    public function titleExists($title)
    {
        $query = "SELECT COUNT(*) FROM courses WHERE title = :title";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }



    public function assignInstructorToCourse($instructorId, $courseId)
    {
        $query = "INSERT INTO instructor_course (instructor_id, course_id) VALUES (:instructor_id, :course_id)";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindValue(':instructor_id', $instructorId, \PDO::PARAM_INT);
        $stmt->bindValue(':course_id', $courseId, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }




    public function getInstructorsForCourse($courseId)
    {
        $query = "SELECT instructor_id FROM instructor_course WHERE course_id = :course_id";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindValue(':course_id', $courseId, \PDO::PARAM_INT);
        $stmt->execute();
        $instructors = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        return $instructors;
    }



    public function updateCourse($courseId, $title, $description, $fee, $availableSeat, $startDate, $endDate)
    {
        $query = "UPDATE courses SET title = :title, description = :description, fee = :fee, available_seat = :available_seat, start_date = :start_date, end_date = :end_date WHERE id = :courseId";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindValue(':courseId', $courseId, \PDO::PARAM_INT);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':fee', $fee, \PDO::PARAM_INT);
        $stmt->bindValue(':available_seat', $availableSeat, \PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $startDate);
        $stmt->bindValue(':end_date', $endDate);
        return $stmt->execute();
    }

    public function updateAssignedInstructors($courseId, $newInstructorIds)
    {
        // Remove existing assignments
        $this->deleteCourseInstructors($courseId);

        // Assign new instructors
        foreach ($newInstructorIds as $instructorId) {
            $this->assignInstructorToCourses($instructorId, $courseId);
        }
    }

    private function deleteCourseInstructors($courseId)
    {
        $query = "DELETE FROM instructor_course WHERE course_id = :courseId";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindValue(':courseId', $courseId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function assignInstructorToCourses($instructorId, $courseId)
    {
        $query = "INSERT INTO instructor_course (instructor_id, course_id) VALUES (:instructorId, :courseId)";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindValue(':instructorId', $instructorId, \PDO::PARAM_INT);
        $stmt->bindValue(':courseId', $courseId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCoursesByIds($courseIds)
    {
        $placeholders = implode(',', array_fill(0, count($courseIds), '?'));

        $sql = "SELECT * FROM courses WHERE id IN ($placeholders)";

        $statement = $this->db->connection->prepare($sql);

        foreach ($courseIds as $index => $courseId) {
            $statement->bindValue($index + 1, $courseId, \PDO::PARAM_INT);
        }

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllCoursesByCondtion($active = true)
    {
        // Constructing the WHERE condition based on the $active parameter
        $activeCondition = $active ? 'IS NULL' : 'IS NOT NULL';

        // Your SQL query with the dynamic WHERE clause
        $sql = 'SELECT * FROM courses WHERE deleted_at ' . $activeCondition;

        // Prepare and execute the statement
        $statement = $this->db->connection->prepare($sql);
        $statement->execute();

        // Fetch and return the result
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function softDeleteCourse($id)
    {
        // Soft delete course
        $sql = 'UPDATE courses SET deleted_at = NOW() WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }


    public function unblockCourse($id)
    {
        // Unblock course
        $sql = 'UPDATE courses SET deleted_at = NULL WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $id]);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }



    public function deleteCourse($id)
    {

        $query = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);


        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    public function countCourses()
    {
        $sql = 'SELECT COUNT(*) AS total_courses FROM courses';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result['total_courses'];
    }

    
}
