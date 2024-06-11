<?php

namespace Core;

class Authenticator
{
    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)->query(
            'SELECT users.*, roles.role as role FROM users 
             JOIN roles ON users.role_id = roles.id 
             WHERE users.email = :email', 
            ['email' => $email]
        )->find();

        // Debug: Print the user object
        // var_dump('User: ', $user);

        if ($user && password_verify($password, $user['password'])) {
            $this->login($user); 
            return $user;
        }

        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'] 
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }
}
