<?php


$router->get('/login', 'AuthController@login');
$router->post('/authenticate', 'AuthController@authenticate');
$router->get('/register', 'AuthController@register');
$router->post('/register-store', 'AuthController@registerStore');
$router->delete('/logout', 'AuthController@logout');

// admin 
$router->get('/admin-dashboard', 'Admin\AdminController@index');
$router->get('/students', 'Admin\StudentController@index');
$router->get('/students/create', 'Admin\StudentController@create');
$router->get('/instructors', 'Admin\InstructorController@index');

//instructor
$router->get('/classes-index', 'Instructor\ClassController@index');
$router->get('/classes-create', 'Instructor\ClassController@create');
$router->post('/classes-store', 'Instructor\ClassController@store');



//frontend
$router->get('/', 'Frontend\FrontendController@index');
$router->get('/course-show/{id}', 'Frontend\FrontendController@show');

// $router->get('/', 'index.php');
// $router->get('/students', 'student.php');
// $router->get('/instructors', 'Admin/Instructor/index.php');



// Add the POST route for running the seeder
// $router->post('/run-seeder', 'Seeder.php');