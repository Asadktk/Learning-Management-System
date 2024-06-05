<?php
namespace Core\Middleware;
class Guest{

    public function handle(){
        if ($_SESSION['guest'] ?? false) {
            header('location: /');
            exit();
        }
    }

    
}