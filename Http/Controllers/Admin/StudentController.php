<?php

namespace Http\Controllers\Admin;

use Http\Models\Admin\Student;

class StudentController
{
    public function index()
    {
        $instructorModel = new Student();
        $students = $instructorModel->getAllStudent();
    //  dd($students);
        view('admin/student/index.view.php', [
            'students' => $students
        ]);
    }

    public function create()
    {
        dd('sdf');
        view('admin/student/create.view.php');
    }
}
