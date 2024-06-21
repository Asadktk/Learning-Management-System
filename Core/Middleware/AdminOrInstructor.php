<?php

namespace Core\Middleware;

class AdminOrInstructor
{
    public function handle()
    {
        $allowedRoles = ['admin', 'instructor'];

        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
            header('Location: /login');
            exit();
        }
    }
}
