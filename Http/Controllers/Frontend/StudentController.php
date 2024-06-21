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
            // Redirect to login if user is not logged in or if user id is not numeric
            redirect('/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // Assuming you have instantiated your Student model
        $studentModel = new Student();

        // Fetch student details from students and users tables
        $studentDetails = $studentModel->getStudentDetails($userId);

        if (!$studentDetails) {
            // Handle case where student details are not found
            // For example, redirect to a 404 page or handle appropriately
            redirect('/404');
            exit;
        }

        // Load view for student profile with student details
        view('frontend/student/profile.view.php', ['studentDetails' => $studentDetails]);
    }
}
