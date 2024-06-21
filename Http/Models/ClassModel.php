<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class ClassModel
{
    protected $db;
    protected $table = 'classes';

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getClassesByInstructor($instructorId)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE instructor_id = :instructorId';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['instructorId' => $instructorId]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createClass($courseId, $instructorId, $startTime, $endTime)
    {

       

        $existingClasses = $this->getClassesByInstructorAndTimeRange($instructorId, $startTime, $endTime);
        if (!empty($existingClasses)) {
            return 'overlap'; // There is a class that overlaps with the specified time range
        }

        $query = "INSERT INTO " . $this->table . " (course_id, instructor_id, start_time, end_time) VALUES (:course_id, :instructor_id, :start_time, :end_time)";

        $stmt = $this->db->connection->prepare($query);


        $stmt->bindParam(":course_id", $courseId);
        $stmt->bindParam(":instructor_id", $instructorId);
        $stmt->bindParam(":start_time", $startTime);
        $stmt->bindParam(":end_time", $endTime);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getClassesByInstructorAndTimeRange($instructorId, $startTime, $endTime)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE instructor_id = :instructorId AND ((start_time BETWEEN :startTime AND :endTime) OR (end_time BETWEEN :startTime AND :endTime))';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['instructorId' => $instructorId, 'startTime' => $startTime, 'endTime' => $endTime]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getClassesByInstructors($instructorId)
    {
        $sql = 'SELECT classes.*, courses.name as course_name, courses.description as course_description 
                FROM ' . $this->table . '
                JOIN courses ON classes.course_id = courses.id
                WHERE classes.instructor_id = :instructorId';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['instructorId' => $instructorId]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInstructorId($userId)
    {
        $query = "SELECT id FROM instructors WHERE user_id = :userId";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    public function getClassById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateClass($id, $courseId, $instructorId, $startTime, $endTime)
    {
        $query = "UPDATE " . $this->table . " SET course_id = :course_id, instructor_id = :instructor_id, start_time = :start_time, end_time = :end_time WHERE id = :id";

        $stmt = $this->db->connection->prepare($query);

        // bind values
        $stmt->bindParam(":course_id", $courseId);
        $stmt->bindParam(":instructor_id", $instructorId);
        $stmt->bindParam(":start_time", $startTime);
        $stmt->bindParam(":end_time", $endTime);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function deleteClass($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->connection->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
