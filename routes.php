<?php

//Authentication
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
// $router->get('/instructors', 'Admin\InstructorController@index');
$router->get('/admin/instructor/edit/{id}', 'Admin\InstructorController@edit');
$router->get('/admin/instructor/show/{id}', 'Admin\InstructorController@show');

$router->get('/admin/courses', 'Admin\CoursesController@index');
$router->get('/admin/courses/create', 'Admin\CoursesController@create');
$router->post('/admin/course/store', 'Admin\CoursesController@store');
$router->get('/admin/course/edit/{id}', 'Admin\CoursesController@edit');
$router->post('/admin/course/update/{id}', 'Admin\CoursesController@update');
$router->get('/admin/course/destroy/{id}', 'Admin\CoursesController@destroy');
$router->get('/admin/course/show/{id}', 'Admin\CoursesController@show');



//instructor
$router->get('/classes-index', 'Instructor\ClassController@index');
$router->get('/classes-create', 'Instructor\ClassController@create');
$router->post('/classes-store', 'Instructor\ClassController@store');
$router->get('/classes-edit/{id}', 'Instructor\ClassController@edit');
$router->post('/classes-update/{id}', 'Instructor\ClassController@update');
$router->get('/classes-show/{id}', 'Instructor\ClassController@show');
$router->get('/classes-destroy/{id}', 'Instructor\ClassController@destroy');



//frontend
$router->get('/', 'Frontend\FrontendController@index');
$router->get('/course-show/{id}', 'Frontend\FrontendController@show');

