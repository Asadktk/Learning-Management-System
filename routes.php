<?php


$router->get('/login', 'AuthController@login');
$router->post('/authenticate', 'AuthController@authenticate');
$router->get('/register', 'AuthController@register');
$router->post('/register-store', 'AuthController@registerStore');
$router->delete('/logout', 'AuthController@logout');

$router->get('/', 'Admin\AdminController@index');
$router->get('/students', 'Admin\StudentController@index');
$router->get('/students/create', 'Admin\StudentController@create');
$router->get('/instructors', 'Admin\InstructorController@index');
// $router->get('/', 'index.php');
// $router->get('/students', 'student.php');
// $router->get('/instructors', 'Admin/Instructor/index.php');



// Add the POST route for running the seeder
// $router->post('/run-seeder', 'Seeder.php');