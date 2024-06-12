<?php

namespace Http\Controllers\Admin;

use Http\Models\Instructor;

class InstructorController
{
    public function index()
    {
        $instructorModel = new Instructor();
        $instructors = $instructorModel->getAllInstructors();
     
        view('admin/instructor/index.view.php', [
            'instructors' => $instructors
        ]);
    }

    public function show($id)
    {   
        
        $instructorModel = new Instructor();
        $instructor = $instructorModel->getInstructorById($id);
        
        view('admin/instructor/show.view.php', [
            'instructor' => $instructor
        ]);
    }
}
