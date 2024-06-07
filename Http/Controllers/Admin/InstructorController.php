<?php

namespace Http\Controllers\Admin;

use Http\Models\Admin\Instructor;

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
}
