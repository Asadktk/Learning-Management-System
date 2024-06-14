<?php

namespace Http\Controllers;

use Core\Session;
use Core\Validator;
use Http\Models\Role;
use Http\Models\User;
use Core\Authenticator;

class AuthController
{
    public function login()
    {
        view('login.view.php', [
            'errors' => Session::get('errors', []),
            'old' => Session::get('old', [])
        ]);
    }

    public function authenticate()
    {
        $errors = [];

        if (!Validator::email($_POST['email'])) {
            $errors['email'] = 'Invalid email format.';
        }

        if (!Validator::string($_POST['password'], 1)) {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            Session::flash('errors', $errors);
            Session::flash('old', [
                'email' => $_POST['email']
            ]);

            return redirect('/login');
        }

        $authenticator = new Authenticator();
        $user = $authenticator->attempt($_POST['email'], $_POST['password']);

        if ($user) {

            Session::put('role', $user['role']);

            switch ($user['role']) {
                case 'admin':
                case 'instructor':
                    return redirect('/admin-dashboard');
                case 'user':
                    return redirect('/');
                default:
                    return redirect('/');
            }
        } else {
            $errors['email'] = 'No matching account found for that email address and password.';
            Session::flash('errors', $errors);
            Session::flash('old', [
                'email' => $_POST['email']
            ]);

            return redirect('/login');
        }
    }

    public function register()
    {
        $roles = (new Role())->getAllRoles();
        // dd($roles);
        view('register.view.php', [
            'roles' => $roles,
            'errors' => Session::get('errors', []),
            'old' => Session::get('old', [])
        ]);
    }

    public function registerStore()
    {
        // dd('uyasd');
        $errors = [];

        // Validate form inputs
        if (!Validator::email($_POST['email'])) {
            $errors['email'] = 'Invalid email format.';
        }

        // Add more validation rules as needed...

        if (!empty($errors)) {
            Session::flash('errors', $errors);
            Session::flash('old', $_POST);
            return redirect('/register');
        }

        // Check if user already exists
        $userModel = new User();
        if ($userModel->getUserByEmail($_POST['email'])) {
            // User already exists, show error
            $errors['email'] = 'User with this email already exists.';
            Session::flash('errors', $errors);
            Session::flash('old', $_POST);
            return redirect('/register');
        }

        // Create a new user
        $user = $userModel->registerUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role_id']);

        if ($user) {
            // User registered successfully
            // Redirect to login page or any other page
            return redirect('/login');
        } else {
            // Failed to register user
            $errors['email'] = 'Failed to register user.';
            Session::flash('errors', $errors);
            Session::flash('old', $_POST);
            return redirect('/register');
        }
    }


    public function logout()
    {

        // Destroy session data
        session_destroy();

        header('Location: /');
        exit();
    }
}
