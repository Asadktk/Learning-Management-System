<?php

namespace Http\Controllers\Admin;

use Http\Models\Student;

class StudentController
{
    public function index()
    {
        $instructorModel = new Student();
        $students = $instructorModel->getAllStudents();
    //  dd($students);
        view('admin/student/index.view.php', [
            'students' => $students
        ]);
    }

    public function getInstructors()
    {
        $active = $_GET['active'] === 'true';
        $studentsModel = new Student();
        $students = $studentsModel->getAllStudents($active);

        echo json_encode($students);
    }

    public function show($id)
    {

        $studentModel = new Student();
        $student = $studentModel->getStudentById($id);

        view('admin/student/show.view.php', [
            'student' => $student
        ]);
    }

    

    public function block($id)
    {
        $StudentModel = new Student();
        $StudentModel->softDelete($id);
        header('Location: /admin/students');
    }

    public function unblock($id)
    {
        $StudentModel = new Student();
        $StudentModel->unblock($id);
        header('Location: /admin/students');
    }

    public function destroy($id)
    {
        $StudentModel = new Student();
        $StudentModel->delete($id);
        header('Location: /admin/students');
    }
   
}
