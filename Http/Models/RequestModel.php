<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class RequestModel
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function createRequest($requestData)
    {
        try {
            $stmt = $this->db->connection->prepare("INSERT INTO requests (instructor_id, course_id, status) VALUES (:instructor_id, :course_id, :status)");
            $stmt->bindParam(':instructor_id', $requestData['instructor_id']);
            $stmt->bindParam(':course_id', $requestData['course_id']);
            $stmt->bindParam(':status', $requestData['status']);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }




    public function getAllRequests()
    {
        $sql = 'SELECT r.*, c.title AS course_title, u.name AS instructor_name
            FROM requests r
            JOIN courses c ON r.course_id = c.id
            JOIN instructors i ON r.instructor_id = i.id
            JOIN users u ON i.user_id = u.id';

        $statement = $this->db->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getRequestById($requestId)
    {
        $sql = 'SELECT * FROM requests WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['id' => $requestId]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function assignCourseToInstructor($courseId, $instructorId)
    {
        $sql = 'INSERT INTO instructor_course (course_id, instructor_id) VALUES (:courseId, :instructorId)';
        $statement = $this->db->connection->prepare($sql);
        return $statement->execute([
            'courseId' => $courseId,
            'instructorId' => $instructorId
        ]);
    }

    public function deleteRequest($requestId)
    {
        $sql = 'DELETE FROM requests WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        return $statement->execute(['id' => $requestId]);
    }

    public function updateRequestStatus($requestId, $status)
    {
        $sql = 'UPDATE requests SET status = :status WHERE id = :id';
        $statement = $this->db->connection->prepare($sql);
        return $statement->execute([
            'id' => $requestId,
            'status' => $status
        ]);
    }
}
