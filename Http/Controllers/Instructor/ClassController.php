<?php

namespace Http\Controllers\Instructor;

use Core\Session;
use Core\Container;
use Http\Models\User;
use Http\Models\Course;
use Http\Models\ClassModel;
use Http\Models\Enrollment;
use Http\Models\Instructor;
use Http\Models\RequestModel;
use Http\Validation\ClassValidator;

class ClassController
{

    public function __construct()
    {
        Container::handleErrors();
    }
    public function index()
    {
        $instructorEmail = $_SESSION['user']['email'] ?? null;

        if ($instructorEmail) {
            $userModel = new User();
            $instructor = $userModel->getInstructorByEmail($instructorEmail);

            if ($instructor) {
                $instructorId = $instructor['instructor_id'];

                $classModel = new ClassModel();
                $classes = $classModel->getClassesByInstructor($instructorId);


                $courseIds = array_column($classes, 'course_id');
                if (!empty($courseIds)) {
                    $courseModel = new Course();
                    $courses = $courseModel->getCoursesByIds($courseIds);

                    $coursesById = [];
                    foreach ($courses as $course) {
                        $coursesById[$course['id']] = $course;
                    }


                    $classesWithCourses = [];
                    foreach ($classes as $class) {
                        if (isset($coursesById[$class['course_id']])) {
                            $classesWithCourses[] = array_merge($class, ['course' => $coursesById[$class['course_id']]]);
                        } else {
                            $classesWithCourses[] = $class;
                        }
                    }

                    view('instructor/class/index.view.php', ['classesWithCourses' => $classesWithCourses]);
                } else {

                    view('instructor/class/index.view.php', ['courses' => []]);
                }
            } else {
                echo 'Instructor not found';
            }
        }
    }



    public function create()
    {
        $instructorId = $_SESSION['user']['id'];

        // Fetch the courses assigned to the instructor
        $courseModel = new Course();
        $courses = $courseModel->getCoursesByInstructorId($instructorId);

        // dd($courses);


        view('instructor/class/create.view.php', ['courses' => $courses, 'errors' => Session::get('errors', [])]);
    }


    public function store()
    {
        header('Content-Type: application/json');

        $validationErrors = ClassValidator::validate($_POST);

        if (!empty($validationErrors)) {
            http_response_code(422);
            echo json_encode(['errors' => $validationErrors]);
            exit;
        }

        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
        $userId = $_POST['user_id'];
        $courseId = $_POST['course_id'];

        $classModel = new ClassModel();

        $instructorId = $classModel->getInstructorId($userId);

        if (!$instructorId) {
            http_response_code(500);
            echo json_encode(['error' => 'Instructor ID not found']);
            exit;
        }

        $result = $classModel->createClass($courseId, $instructorId, $startTime, $endTime);

        if ($result === true) {
            echo json_encode(['message' => 'Class created successfully', 'redirect' => '/classes-index']);
        } elseif ($result === 'overlap') {
            http_response_code(422);
            echo json_encode(['error' => 'Another class overlaps with the specified time range.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to create class']);
        }
    }




    public function edit($id)
    {
        $classModel = new ClassModel();
        $courseClass = $classModel->getClassById($id);

        $courseModel = new Course();
        $courses = $courseModel->getAllCourses();

        if ($courseClass) {
            // Render edit view with class data
            view('instructor/class/edit.view.php', ['courseClass' => $courseClass, 'courses' => $courses]);
        } else {
            echo 'Class not found';
        }
    }

    public function update($id)
    {
        header('Content-Type: application/json');

        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
        $userId = $_POST['user_id'];

        if ($startTime >= $endTime) {
            http_response_code(400);
            echo json_encode(['error' => 'Start time must be less than end time']);
            exit;
        }

        $courseId = $_POST['course_id'];

        $classModel = new ClassModel();
        $instructorId = $classModel->getInstructorId($userId);

        if (!$instructorId) {
            http_response_code(500);
            echo json_encode(['error' => 'Instructor ID not found']);
            exit;
        }

        $result = $classModel->updateClass($id, $courseId, $instructorId, $startTime, $endTime);

        if ($result) {
            $response = [
                'message' => 'Class updated successfully',
                'redirect' => '/classes-index'
            ];
        } else {
            $response = [
                'error' => 'Failed to created class'
            ];
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function show($id)
    {
        $classModel = new ClassModel();
        $courseClass = $classModel->getClassById($id);

        $courseModel = new Course();
        $courses = $courseModel->getAllCourses();

        if ($courseClass) {

            view('instructor/class/show.view.php', ['courseClass' => $courseClass, 'courses' => $courses]);
        } else {
            echo 'Class not found';
        }
    }


    public function instructorCourse()
    {
        $instructorId = $_SESSION['user']['id']; // Assuming session structure

        // Fetch the courses assigned to the instructor
        $courseModel = new Course();
        $courses = $courseModel->getCoursesByInstructorId($instructorId);

        // Pass courses to your view
        view('instructor/enrolledstudents/enrolledstudent.view.php', ['courses' => $courses,]);
    }






    public function enrolledStudents($courseId)
    {
        // Get the user ID from the session
        $userId = $_SESSION['user']['id'];

        // Get the instructor ID from the user ID
        $userModel = new User();
        $instructorId = $userModel->getInstructorIdByUserId($userId);
        if (!$instructorId) {
            echo 'Instructor not found';
            return;
        }

        // Initialize the ClassModel to fetch enrolled students
        $classModel = new Enrollment();

        // Fetch enrolled students for the specific course and instructor
        $enrolledStudents = $classModel->getEnrolledStudents($courseId, $instructorId);

        // Fetch the course details
        $courseModel = new Course();
        $course = $courseModel->getCourseById($courseId);

        // Pass the data to the view
        view('instructor/enrolledstudents/showstudents.view.php', [
            'course' => $course,
            'enrolledStudents' => $enrolledStudents
        ]);
    }


    public function profileShow()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user']['id']) || !is_numeric($_SESSION['user']['id'])) {
            redirect('/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        $instructorModel = new Instructor();

        $instructorDetails = $instructorModel->getInstructorDetails($userId);
        if (!$instructorDetails) {
            redirect('/404');
            exit;
        }

        view('instructor/profile/show.view.php', ['instructorDetails' => $instructorDetails]);
    }


    public function updateProfile()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Extract POST data
            $userId = $_POST['user_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $newPassword = $_POST['password'];

            // Initialize the instructor model
            $instructorModel = new Instructor();

            // Get current hashed password
            $currentHashedPassword = $instructorModel->getHashedPassword($userId);

            // Hash the new password if provided; otherwise, keep the current hashed password
            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            } else {
                $hashedPassword = $currentHashedPassword; // Keep the current hashed password
            }

            // Call updateProfile method in model
            $success = $instructorModel->updateProfile($userId, $name, $hashedPassword);

            if ($success) {
                // Redirect to profile view or success page
                redirect('/instructor/profile');
            } else {
                // Handle update failure (e.g., show error message)
                echo "Failed to update profile.";
            }
        }
    }

    public function courses()
    {

        $courseModel = new Course();
        $courses = $courseModel->getCourse();

        view('instructor/courses/courses.view.php', ['courses' => $courses]);
    }



    public function sendRequest()
    {
      

        if (!isset($_SESSION['user']['id']) || !is_numeric($_SESSION['user']['id'])) {
            redirect('/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $instructorModel = new Instructor();

        $instructorDetails = $instructorModel->getInstructorDetail($userId);
       

        if (!$instructorDetails) {
            redirect('/404'); 
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            if (!isset($_POST['course_id'])) {
                echo "Course ID is required.";
                return;
            }

            
            $courseId = $_POST['course_id'];

            $requestData = [
                'instructor_id' => $instructorDetails['id'],
                'course_id' => $courseId,
                'status' => true 
            ];

            $requestModel = new RequestModel();

            $success = $requestModel->createRequest($requestData);

            if ($success) {
                // Redirect to success page or appropriate view
                redirect('/courses');
            } else {
                // Handle insertion failure (e.g., show error message)
                echo "Failed to send request.";
            }
        }

       
        $courseModel = new Course();
        $courses = $courseModel->getCourses(); 

        // Load view with necessary data
        view('request/send_request.view.php', [
            'courses' => $courses,
            'instructorDetails' => $instructorDetails // Pass instructor details to the view
        ]);
    }


    public function destroy($id)
    {
        $classModel = new ClassModel();
        $result = $classModel->deleteClass($id);


        if ($result) {
            $response = [
                'message' => 'Class deleted successfully',
                'redirect' => '/classes-index'
            ];
        } else {
            $response = [
                'error' => 'Failed to deleted class'
            ];
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
