<?php

//Authentication
$router->get('/login', 'AuthController@login');
$router->post('/authenticate', 'AuthController@authenticate');
$router->get('/register', 'AuthController@register');
$router->post('/register-store', 'AuthController@registerStore');
$router->delete('/logout', 'AuthController@logout');

// admin 
$router->get('/admin-dashboard', 'Admin\AdminController@index')->only('admin');


$router->get('/admin/students', 'Admin\StudentController@index')->only('admin');
$router->get('/admin/student/show/{id}', 'Admin\StudentController@show')->only('admin');
$router->get('/students/fetch', 'Admin\StudentController@getInstructors')->only('admin');
$router->get('/admin/student/block/{id}', 'Admin\StudentController@block')->only('admin');
$router->get('/admin/student/unblock/{id}', 'Admin\StudentController@unblock')->only('admin');
$router->get('/admin/student/destroy/{id}', 'Admin\StudentController@destroy')->only('admin');

$router->get('/instructors', 'Admin\InstructorController@index')->only('admin');
$router->get('/admin/instructor/show/{id}', 'Admin\InstructorController@show')->only('admin');
$router->get('/instructors/fetch', 'Admin\InstructorController@getInstructors')->only('admin');
$router->get('/admin/instructor/block/{id}', 'Admin\InstructorController@block')->only('admin');
$router->get('/admin/instructor/unblock/{id}', 'Admin\InstructorController@unblock')->only('admin');
$router->get('/admin/instructor/destroy/{id}', 'Admin\InstructorController@destroy')->only('admin');


$router->get('/admin/courses', 'Admin\CoursesController@index')->only('admin');
$router->get('/admin/courses/create', 'Admin\CoursesController@create')->only('admin');
$router->post('/admin/course/store', 'Admin\CoursesController@store')->only('admin');
$router->get('/admin/course/edit/{id}', 'Admin\CoursesController@edit')->only('admin');
$router->post('/admin/course/update/{id}', 'Admin\CoursesController@update')->only('admin');
$router->get('/admin/course/destroy/{id}', 'Admin\CoursesController@destroy')->only('admin');
$router->get('/admin/course/show/{id}', 'Admin\CoursesController@show')->only('admin');



//instructor
// $router->get('/admin-dashboard', 'Admin\AdminController@index')->only('instructor');

$router->get('/classes-index', 'Instructor\ClassController@index')->only('instructor');
$router->get('/classes-create', 'Instructor\ClassController@create')->only('instructor');
$router->post('/classes-store', 'Instructor\ClassController@store')->only('instructor');
$router->get('/classes-edit/{id}', 'Instructor\ClassController@edit')->only('instructor');
$router->post('/classes-update/{id}', 'Instructor\ClassController@update')->only('instructor');
$router->get('/classes-show/{id}', 'Instructor\ClassController@show')->only('instructor');
$router->get('/classes-destroy/{id}', 'Instructor\ClassController@destroy')->only('instructor');



//frontend
$router->get('/', 'Frontend\FrontendController@index');
$router->get('/course-show/{id}', 'Frontend\FrontendController@show');
$router->get('/course-enroll/{id}', 'Frontend\FrontendController@showEnrollmentForm');
$router->post('/course-enroll/{id}', 'Frontend\FrontendController@enrollStudent');

