<?php



$router->get('/', 'index.php');
$router->get('/students', 'student.php');
$router->get('/instructors', 'Admin/Instructor/index.php');
// Add the POST route for running the seeder
// $router->post('/run-seeder', 'Seeder.php');