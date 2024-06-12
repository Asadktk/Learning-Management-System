<?php

namespace Http\Controllers\Admin;

use Http\Models\Course;
use Http\Models\Instructor;

class CoursesController
{
    public function index()
    {
        $cours = new Course();
        $courses = $cours->getAllCourses();
        
        view('admin/course/index.view.php', [
            'courses' => $courses
        ]);
    }

    public function create(){

        view('admin/course/create.view.php');
    }

    public function store()
    {
        $title = $_POST['title'];
        $description = $_POST['textarea-input'];
        $fee = $_POST['fee'];
        $availableSeat = $_POST['available_seat'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        $cours = new Course();
        $result = $cours->createCourse($title, $description, $fee, $availableSeat, $startDate, $endDate);

        if ($result) {
            $response = [
                'message' => 'Course created successfully',
                'redirect' => '/admin/courses'
            ];
        } else {
            $response = [
                'error' => 'Failed to created Course'
            ];
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    public function show($id){
        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($id);

        return view('admin/course/show.view.php', ['course' => $course]);

    }


    public function edit($id){

        $courseModel = new Course();
        $course = $courseModel->getCourseDetails($id);

        return view('admin/course/edit.view.php', ['course' => $course]);


    }


    public function update($id) {
        // Retrieve the form data
        $title = $_POST['title'];
        $description = $_POST['description'] ?? null;
        $fee = $_POST['fee'] ?? null;
        $availableSeat = $_POST['available_seat'] ?? null;
        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
    
        $course = new Course();
        $result = $course->update($id, $title, $description, $fee, $availableSeat, $startDate, $endDate);


        if ($result) {
            $response = [
                'message' => 'Course updated successfully',
                'redirect' => '/admin/courses'
            ];
        } else {
            $response = [
                'error' => 'Failed to update Course'
            ];
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    
    public function destroy($id)
    {   
        $courseModel = new Course();
        $result = $courseModel->deleteCourse($id);

        redirect('/admin/courses');

    
        // if ($result) {
        //     // Course deleted successfully
        //     $response = [
        //         'message' => 'Course deleted successfully',
        //         'redirect' => '/admin/courses'
        //     ];
        // } else {
        //     // Failed to delete course
        //     $response = [
        //         'error' => 'Failed to delete course'
        //     ];
        // }
    
        // // Send JSON response
        // header('Content-Type: application/json');
        // echo json_encode($response);
    }
    
}
