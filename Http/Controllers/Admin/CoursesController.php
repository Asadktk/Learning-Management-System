<?php

namespace Http\Controllers\Admin;

use Exception;
// use Core\Validator;
use Core\Session;
use Core\Container;
use Http\Models\Course;
use Http\Models\Instructor;
use Http\Validation\CourseValidator;

class CoursesController
{

    protected function respondWithError($message, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode(['error' => $message]);
        exit;
    }

    public function __construct()
    {
        Container::handleErrors();
    }

    public function index()
    {
        $cours = new Course();
        $courses = $cours->getAllCourses();

        view('admin/course/index.view.php', [
            'courses' => $courses,
            'errors' => Session::get('errors', []),

        ]);
    }

    public function create()
    {

        $instructor = new Instructor();

        $instructors = $instructor->getAllInstructors(true);
        view('admin/course/create.view.php', ['instructors' => $instructors, 'errors' => Session::get('errors', [])]);
    }


    public function store()
    {

        try {

            $validationErrors = CourseValidator::validate($_POST);
            if (!empty($validationErrors)) {
                $this->respondWithError($validationErrors, 422);
            }

            // Check if title already exists
            $title = $_POST['title'];
            $course = new Course();
            if ($course->titleExists($title)) {
                $this->respondWithError(['title' => 'Title already exists.'], 422);
            }

            // All validation passed, proceed with course creation
            $description = $_POST['description'];
            $fee = $_POST['fee'];
            $availableSeat = $_POST['available_seat'];
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];

            $courseId = $course->createCourse($title, $description, $fee, $availableSeat, $startDate, $endDate);

            if ($courseId) {
                // Assign instructors to the course
                $instructorIds = $_POST['instructor_ids'];
                foreach ($instructorIds as $instructorId) {
                    $course->assignInstructorToCourse($instructorId, $courseId);
                }

                Session::flash('success', 'Course created successfully.');
                $response = [
                    'message' => 'Course created successfully',
                    'redirect' => '/admin/courses'
                ];
            } else {
                Session::flash('error', 'Failed to create Course');
                $response = [

                    'error' => 'Failed to create Course'
                ];
            }

            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (Exception $exception) {
            // Handle exceptions
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'details' => $exception->getMessage()]);
            exit;
        }
    }




    public function show($id)
    {
        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($id);

        return view('admin/course/show.view.php', ['course' => $course]);
    }


    public function edit($id)
    {
        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($id);

        // Get all instructors
        $instructorModel = new Instructor();

        $instructors = $instructorModel->getAllInstructors(true);

        // Get selected instructors for the course
        $selectedInstructors = $courseModel->getInstructorsForCourse($id);

        return view('admin/course/edit.view.php', ['course' => $course, 'instructors' => $instructors, 'selectedInstructors' => $selectedInstructors]);
    }


    public function update($courseId)
    {
        try {
            // Fetch existing course details and validate inputs
            $courseModel = new Course();
            $existingCourse = $courseModel->getCourseById($courseId);

            if (!$existingCourse) {
                $this->respondWithError('Course not found', 404);
            }

            // Validate instructor_ids input
            if (!isset($_POST['instructor_ids']) || !is_array($_POST['instructor_ids']) || empty($_POST['instructor_ids'])) {
                throw new Exception("At least one instructor must be selected.");
            }

            // Proceed with updating course details
            $title = $_POST['title'];
            $description = $_POST['description'];
            $fee = $_POST['fee'];
            $availableSeat = $_POST['available_seat'];
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];

            $result = $courseModel->updateCourse($courseId, $title, $description, $fee, $availableSeat, $startDate, $endDate);

            if ($result) {
                // Update assigned instructors
                $newInstructorIds = $_POST['instructor_ids'];
                $courseModel->updateAssignedInstructors($courseId, $newInstructorIds);

                // Respond with success message
                $response = [
                    'message' => 'Course updated successfully',
                    'redirect' => '/admin/courses'
                ];
                Session::flash('success', 'Course updated successfully.');
            } else {
                Session::flash('error', 'Failed to update Course');
                $response = [
                    'error' => 'Failed to update Course'
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (Exception $exception) {
            // Handle exceptions
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'details' => $exception->getMessage()]);
            exit;
        }
    }



    public function destroy($id)
    {
        try {
            $courseModel = new Course();
            $result = $courseModel->deleteCourse($id);

            if ($result) {

                Session::flash('success', 'Course deleted successfully.');
                $response = [
                    'message' => 'Course deleted successfully',
                    'redirect' => '/admin/courses'
                ];
            } else {

                $response = [
                    'error' => 'Failed to delete course'
                ];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (Exception $exception) {

            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'details' => $exception->getMessage()]);
            exit;
        }
    }
}
