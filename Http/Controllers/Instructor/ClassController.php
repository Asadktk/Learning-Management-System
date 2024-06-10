<?php

namespace Http\Controllers\Instructor;

use Http\Models\User;
use Core\Authenticator;
use Http\Models\ClassModel;
use Http\Models\Course;

class ClassController
{
    public function index()
    {
        $instructorEmail = $_SESSION['user']['email'] ?? null;
        
        if ($instructorEmail) {
            $userModel = new User();
            $instructor = $userModel->getInstructorByEmail($instructorEmail);

            if ($instructor) {
                $instructorId = $instructor;

                $classModel = new ClassModel();

                $classes = $classModel->getClassesByInstructor($instructorId);
                // dd($classes);

                // Extract course IDs from classes
                $courseIds = array_column($classes, 'course_id');
                if (!empty($courseIds)) {
                    $courseModel = new Course();

                    $courses = $courseModel->getCoursesByIds($courseIds);
                    // Pass the data to the view
                    view('instructor/class/index.view.php', ['courses' => $courses]);
                } else {
                    // Handle the case where no classes are found for the instructor
                    // Redirect or display an error message
                }
            } else {
                // Handle the case where instructor ID is not found in the session
                // Redirect or display an error message
            }
        }
    }

    public function create()
    {
        $courseModel = new Course();
        $courses = $courseModel->getAllCourses();
    
        // Pass courses to the view
        view('instructor/class/create.view.php', ['courses' => $courses]);
    }

    public function store()
    {
        
        // Validate start and end times
        $startTime = $_POST['start_time'];
        $endTime = $_POST['end_time'];
    
        if ($startTime >= $endTime) {
            // Return error response
            http_response_code(400);
            echo json_encode(['error' => 'Start time must be less than end time']);
            exit;
        }
    
        $courseId = $_POST['course_id'];
    
        $instructorId = $_SESSION['user']['id']; 
    
        $classModel = new ClassModel();
        $classModel->createClass($courseId, $instructorId);
    
        // Return success response
        http_response_code(200);
        echo json_encode(['message' => 'Class created successfully']);
    }
    
}
