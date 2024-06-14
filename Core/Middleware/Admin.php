<?php
namespace Core\Middleware;
class Admin{

    public function handle(){
        if ($_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

       
    }

    
}