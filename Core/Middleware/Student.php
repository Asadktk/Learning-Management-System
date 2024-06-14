<?php
namespace Core\Middleware;
class Student{

    public function handle(){
        if ($_SESSION['role'] !== 'student') {
            header('Location: /login');
            exit();
        }
    }

    
}