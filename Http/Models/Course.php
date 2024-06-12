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

    public function getCourseDetails($courseId)
    {
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
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $title, $description, $fee, $availableSeat, $startDate, $endDate) {
        $query = "UPDATE courses SET title = :title, description = :description, fee = :fee, available_seat = :available_seat, start_date = :start_date, end_date = :end_date WHERE id = :id";
        
        $stmt = $this->db->connection->prepare($query);
    
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':fee', $fee, \PDO::PARAM_INT);
        $stmt->bindValue(':available_seat', $availableSeat, \PDO::PARAM_INT);
        $stmt->bindValue(':start_date', $startDate);
        $stmt->bindValue(':end_date', $endDate);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false; 
        }
    }


    public function deleteCourse($id)
{
    // Prepare the SQL query
    $query = "DELETE FROM courses WHERE id = :id";
    $stmt = $this->db->connection->prepare($query);
    $stmt->bindParam(":id", $id, \PDO::PARAM_INT); // Assuming $id is an integer
    
    // Execute the query
    if ($stmt->execute()) {
        return true; // Return true if deletion was successful
    }

    return false; // Return false if deletion failed
}
    
}
