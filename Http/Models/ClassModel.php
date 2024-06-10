<?php

namespace Http\Models;

use Core\App;
use Core\Database;

class ClassModel
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getClassesByInstructor($instructorId)
    {$instructorId = 1;
        $sql = 'SELECT * FROM classes WHERE instructor_id = :instructorId';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['instructorId' => $instructorId]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createClass($courseId, $instructorId)
    {
        $sql = 'INSERT INTO classes (course_id, instructor_id) VALUES (:courseId, :instructorId)';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute([
            'courseId' => $courseId,
            'instructorId' => $instructorId,
        ]);
    }

    public function getClassesByInstructors($instructorId)
    {
        $sql = 'SELECT classes.*, courses.name as course_name, courses.description as course_description 
                FROM classes
                JOIN courses ON classes.course_id = courses.id
                WHERE classes.instructor_id = :instructorId';
        $statement = $this->db->connection->prepare($sql);
        $statement->execute(['instructorId' => $instructorId]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

}
