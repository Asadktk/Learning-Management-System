<?php

namespace Http\Controllers\Frontend;

use Core\Session;
use Core\Validator;
use Http\Models\Role;
use Http\Models\User;
use Core\Authenticator;
use Http\Models\Course;
use Http\Models\Student;
use Http\Models\Enrollment;
use Http\Models\Instructor;

class StudentController
{
    public function viewProfile()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user']['id']) || !is_numeric($_SESSION['user']['id'])) {
            redirect('/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        $studentModel = new Student();

        $studentDetails = $studentModel->getStudentDetails($userId);

        if (!$studentDetails) {
            redirect('/404');
            exit;
        }

        view('frontend/student/profile.view.php', ['studentDetails' => $studentDetails]);
    }


    public function updateProfile()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user']['id']) || !is_numeric($_SESSION['user']['id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        // Validate and sanitize input
        $userId = $_SESSION['user']['id'];
        $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';


        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['error' => 'Name field is required']);
            exit;
        }

        $studentModel = new Student();

        $data = [
            'user_id' => $userId,
            'name' => $name
        ];
        if ($studentModel->updateStudentName($data)) {
            $response = [
                'message' => 'Profile updated successfully',
                'redirect' => '/student-profile'
            ];
            echo json_encode($response);
        } else {
            http_response_code(500);
            $response = ['error' => 'Failed to update profile'];
            echo json_encode($response);
        }
        exit;
    }


    public function myCourses()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user']['id']) || !is_numeric($_SESSION['user']['id'])) {
            http_response_code(401);
            echo 'Unauthorized';
            exit;
        }

        // Get the student ID from session
        $studentId = $_SESSION['user']['id'];

        // Instantiate your Student model (adjust the class name if needed)
        $studentModel = new Student(); // Assuming you have a Student model

        // Fetch courses for the student
        $courses = $studentModel->getCoursesForStudent($studentId);

        return view('frontend/student/mycourse.view.php', ['courses' => $courses]);
    }
}
