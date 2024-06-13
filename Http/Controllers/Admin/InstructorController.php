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

    public function getInstructors()
    {
        $active = $_GET['active'] === 'true';
        $instructorModel = new Instructor();
        $instructors = $instructorModel->getAllInstructors($active);

        echo json_encode($instructors);
    }

    public function show($id)
    {

        $instructorModel = new Instructor();
        $instructor = $instructorModel->getInstructorById($id);

        view('admin/instructor/show.view.php', [
            'instructor' => $instructor
        ]);
    }

    public function block($id)
    {
        $instructorModel = new Instructor();
        $instructorModel->softDelete($id);
        header('Location: /instructors');
    }

    public function unblock($id)
    {
        $instructorModel = new Instructor();
        $instructorModel->unblock($id);
        header('Location: /instructors');
    }

    public function destroy($id)
    {
        $instructorModel = new Instructor();
        $instructorModel->delete($id);
        header('Location: /instructors');
    }
}
