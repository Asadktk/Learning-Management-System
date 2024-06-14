<?php
namespace Core\Middleware;
class Instructor{

    public function handle(){
    
        if ($_SESSION['role'] !== 'instructor') {
            header('Location: /login');
            exit();
        }
    }

    
}