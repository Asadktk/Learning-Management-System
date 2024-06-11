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

