<?php

namespace Http\Controllers\Frontend;

use Core\Session;
use Core\Validator;
use Http\Models\Role;
use Http\Models\User;
use Core\Authenticator;
use Http\Models\Course;
use Http\Models\Enrollment;
use Http\Models\Instructor;

class FrontendController
{
    public function index()
    {
        $courseModel = new Course();
        $instructorModel = new Instructor();

        $courses = $courseModel->getAllCourses();
        $instructors = $instructorModel->getAllInstructors();

        view('frontend/index.view.php', ['courses' => $courses, 'instructors' => $instructors]);
    }

    public function show($courseId)
    {

        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($courseId);
        // dd($course);
        view('frontend/course/show.view.php', ['course' => $course]);
    }


    public function showEnrollmentForm($courseId)
    {

        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($courseId);


        view('frontend/course/enrolled.view.php', ['course' => $course]);
    }

    public function enrollStudent($courseId)
    {

        if (isset($_SESSION['user']['id'])) {

            $studentId = $_SESSION['user']['id'];


            $courseModel = new Course();
            $course = $courseModel->getCourseDetails($courseId);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $instructorId = $_POST['instructor_id'];

                // Perform enrollment
                $enrollmentModel = new Enrollment();
                $enrollmentModel->enrollStudent($courseId, $instructorId, $studentId);

                // Redirect or display success message
                // Redirect to a success page or display a success message
            }

            // Load view
            view('frontend/course/enrolled.view.php', ['course' => $course]);
        } else {
            redirect('/login');
        }
    }
}
