<?php

namespace Http\Controllers\Frontend;

use Core\Session;
use Core\Validator;
use Http\Models\Role;
use Http\Models\User;
use Http\Models\Course;  
use Core\Authenticator;
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

}
