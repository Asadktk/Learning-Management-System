<?php

namespace Http\Controllers\Frontend;

use Http\Models\Course;
use Http\Models\Student;
use Http\Models\ClassModel;
use Http\Models\Enrollment;
use Http\Models\Instructor;

class FrontendController
{
    public function index()
    {
        $courseModel = new Course();
        $instructorModel = new Instructor();


        $eventModel = new ClassModel();
        $userModel = new Student();

        // Fetch counts using respective model methods
        $studentCount = $userModel->countStudents();
        // dd($studentCount); // Assuming you have a method to count students
        $courseCount = $courseModel->countCourses(); // Assuming you have a method to count courses
        $eventCount = $eventModel->countClass(); // Assuming you have a method to count events
        $trainerCount = $instructorModel->countActiveInstructors();

        $courses = $courseModel->getAllCourses();
        $instructors = $instructorModel->getAllInstructors();

        view('frontend/index.view.php', ['courses' => $courses, 'instructors' => $instructors,'studentCount' => $studentCount,
            'courseCount' => $courseCount,
            'eventCount' => $eventCount,
            'trainerCount' => $trainerCount,]);
    }








    public function show($courseId)
    {
        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($courseId);

        // Convert instructor_ids from string to array
        if (isset($course['instructor_ids']) && is_string($course['instructor_ids'])) {
            $course['instructor_ids'] = explode(',', $course['instructor_ids']);
        }


        // Assuming `instructor_ids` is now an array of instructor IDs
        $enrollmentModel = new Enrollment();
        $enrolledStudents = [];

        foreach ($course['instructor_ids'] as $instructorId) {
            // Ensure the instructorId is an integer
            $instructorId = (int)trim($instructorId);



            $students = $enrollmentModel->getEnrolledStudentsCount($courseId, $instructorId);

            if (!empty($students)) {
                $enrolledStudents[$instructorId] = $students;
            }
        }

        // Check available seats
        $availableSeats = $courseModel->getAvailableSeats($courseId, $course['instructor_ids']);

        //    dd($availableSeats);

        // Pass course details and available seats to the view
        view('frontend/course/show.view.php', [
            'course' => $course,
            'availableSeats' => $availableSeats,
            'enrolledStudents' => $enrolledStudents
        ]);
    }



    public function showEnrollmentForm($courseId)
    {
        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($courseId);


        if (isset($course['instructor_ids']) && is_string($course['instructor_ids'])) {
            $course['instructor_ids'] = explode(',', $course['instructor_ids']);
        }

        if (isset($course['instructor_names']) && is_string($course['instructor_names'])) {
            $course['instructor_names'] = explode(',', $course['instructor_names']);
        }

        $availableSeats = $courseModel->getAvailableSeats($courseId, $course['instructor_ids']);


        view('frontend/course/enrolled.view.php', [
            'course' => $course,
            'availableSeats' => $availableSeats
        ]);
    }


    public function enrollStudent($courseId)
    {

        if (!isset($_SESSION['user']['id']) || !is_numeric($_SESSION['user']['id'])) {

            redirect('/login');
            exit;
        }

        $studentId = $_SESSION['user']['id'];

        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($courseId);

        if (!$course) {

            redirect('/404');
            exit;
        }


        $enrollmentModel = new Enrollment();
        $alreadyEnrolled = $enrollmentModel->isStudentEnrolled($courseId, $studentId);
        if ($alreadyEnrolled) {
            $_SESSION['error'] = 'already_enrolled';
            redirect("/course-enroll/{$courseId}");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $instructorId = $_POST['instructor_id'];


            $availableSeats = $courseModel->getAvailableSeats($courseId, [$instructorId]);

            if ($availableSeats <= 0) {
                $_SESSION['error'] = 'no_seats_available';
                redirect("/course-enroll/{$courseId}");
                exit;
            }


            $enrollmentModel->enrollStudent($courseId, $instructorId, $studentId);

            $_SESSION['success'] = 'enrollment_success';
            redirect("/course-enroll/{$courseId}");
            exit;
        }


        view('frontend/course/enrolled.view.php', ['course' => $course]);
    }

   
}
