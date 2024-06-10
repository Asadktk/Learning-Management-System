<?php

namespace Http\Models;

use Core\App;
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
        $sql = 'SELECT * FROM courses';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCourseDetails($courseId) {
        $sql = 'SELECT courses.*, users.name as instructor_name, instructors.id as instructor_id
                FROM courses
                LEFT JOIN instructor_course ON courses.id = instructor_course.course_id
                LEFT JOIN instructors ON instructors.id = instructor_course.instructor_id
                LEFT JOIN users ON users.id = instructors.user_id
                WHERE courses.id = :courseId';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['courseId' => $courseId]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function getCoursesByIds(array $courseIds)
    {
        if (empty($courseIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($courseIds), '?'));
        $sql = "SELECT * FROM courses WHERE id IN ($placeholders)";
        $statement = $this->db->connection->prepare($sql);
        $statement->execute($courseIds);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
}
