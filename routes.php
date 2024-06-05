<?php
// return [
//     '/' => 'index.php',
//     '/about' => 'about.php',
//     '/notes' => 'notes/index.php',
//     '/note' => 'notes/show.php',
//     '/notes/create'=> 'notes/create.php',
//     '/contact' => 'contact.php',
// ];
//  var_dump($_SERVER['REQUEST_URI']);


$router->get('/', 'index.php');