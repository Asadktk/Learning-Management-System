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
        $courseModel = new Course();
        $courses = $courseModel->getAllCourses();

        // Pass courses to the view
        view('instructor/class/create.view.php', ['courses' => $courses]);
    }

    public function store()
    {


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

        $classModel = new ClassModel();

        $result = $classModel->createClass($courseId, $instructorId, $startTime, $endTime);

        if ($result) {
            echo json_encode(['message' => 'Class created successfully', 'redirect' => '/classes-index']);
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
            echo json_encode(['message' => 'Class updated successfully', 'redirect' => '/classes-index']);
            
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update class']);
        }
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

    public function destroy($id)
    {
        $classModel = new ClassModel();
        $result = $classModel->deleteClass($id);

        if ($result) {
            echo json_encode(['message' => 'Class deleted successfully', 'redirect' => '/classes-index']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete class']);
        }
    }
}
