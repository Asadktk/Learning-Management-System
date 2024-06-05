<?php

// Ensure autoloading and container setup
require __DIR__ . '/bootstrap.php';

use Core\App;
use Core\Seeder;

// Resolve the Database instance from the container
$db = App::resolve('Core\Database');

// Create a new Seeder instance with the resolved Database instance
$seeder = new Seeder($db);

// Run the seeder
$seeder->run();

echo "Database seeded successfully.";
