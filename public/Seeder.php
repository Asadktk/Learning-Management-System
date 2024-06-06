<?php
// Include the Database class and your config file
require_once '../Core/Database.php';
$config = require_once '../config.php';

// Create a new instance of the Database class
$database = new Core\Database($config['database']);

// Define table structure and seed data for roles
$roles = 'roles';
$rolesColumns = 'id INT AUTO_INCREMENT PRIMARY KEY, role VARCHAR(255), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL';
$rolesData = [
    ['role' => 'admin'],
    ['role' => 'instructor'],
    ['role' => 'student'],
];

// Create the roles table and seed data if it doesn't exist
if (!$database->tableExists($roles)) {
    $database->createTable($roles, $rolesColumns);
    $database->seedData($roles, $rolesData);
}

// Define table structure for users
$users = 'users';
$usersColumns = 'id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), email VARCHAR(255), password VARCHAR(255), role_id INT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL';

// Define seed data for users
$usersData = [
    ['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'role_id' => 1],
    ['name' => 'Arsalan', 'email' => 'arsalan@example.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'role_id' => 2],
    ['name' => 'Ali', 'email' => 'ali@example.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'role_id' => 3],
];

// Create the users table if it doesn't exist
if (!$database->tableExists($users)) {
    // Create the users table
    $database->createTable($users, $usersColumns);

    // Add foreign key constraint
    $database->addForeignKey($users, 'role_id', $roles, 'id');

    // Seed the users table with data
    $database->seedData($users, $usersData);

    echo "Users table created and seeded successfully!";
} else {
    echo "Users table already exists!";
}

// Define table structure for instructors
$instructors = 'instructors';
$instructorsColumns = 'id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL';

// Define seed data for instructors (assumes user_id 2 is an instructor)
$instructorsData = [
    ['user_id' => 2], // Arsalan Instructor
];

// Create the instructors table if it doesn't exist
if (!$database->tableExists($instructors)) {
    // Create the instructors table
    $database->createTable($instructors, $instructorsColumns);

    // Add foreign key constraint
    $database->addForeignKey($instructors, 'user_id', $users, 'id');

    // Seed the instructors table with data
    $database->seedData($instructors, $instructorsData);

    echo "Instructors table created and seeded successfully!<br>";
} else {
    echo "Instructors table already exists!<br>";
}

// Define table structure for students
$students = 'students';
$studentsColumns = 'id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL';

// Define seed data for students (assumes user_id 3 is a student)
$studentsData = [
    ['user_id' => 3], // Ali Student
];

// Create the students table if it doesn't exist
if (!$database->tableExists($students)) {
    // Create the students table
    $database->createTable($students, $studentsColumns);

    // Add foreign key constraint
    $database->addForeignKey($students, 'user_id', $users, 'id');

    // Seed the students table with data
    $database->seedData($students, $studentsData);

    echo "Students table created and seeded successfully!<br>";
} else {
    echo "Students table already exists!<br>";
}


// Define table structure for courses
$courses = 'courses';
$coursesColumns = 'id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255), description TEXT, start_date DATE, end_date DATE, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL';

// Define seed data for courses
$coursesData = [
    ['title' => 'Mathematics', 'description' => 'Introduction to Mathematics', 'start_date' => '2024-06-01', 'end_date' => '2024-07-01'],
    ['title' => 'Physics', 'description' => 'Introduction to Physics', 'start_date' => '2024-06-15', 'end_date' => '2024-07-15'],
];

// Create the courses table if it doesn't exist
if (!$database->tableExists($courses)) {
    // Create the courses table
    $database->createTable($courses, $coursesColumns);

    // Seed the courses table with data
    $database->seedData($courses, $coursesData);

    echo "Courses table created and seeded successfully!<br>";
} else {
    echo "Courses table already exists!<br>";
}

// Define table structure for instructor_course
$instructorCourse = 'instructor_course';
$instructorCourseColumns = 'instructor_id INT, course_id INT, PRIMARY KEY (instructor_id, course_id)';

// Define seed data for instructor_course (assuming Arsalan is the instructor of Mathematics course)
$instructorCourseData = [
    ['instructor_id' => 1, 'course_id' => 1], // Arsalan Instructor for Mathematics
];

// Create the instructor_course table if it doesn't exist
if (!$database->tableExists($instructorCourse)) {
    // Create the instructor_course table
    $database->createTable($instructorCourse, $instructorCourseColumns);

    // Define foreign key constraints
    $database->addForeignKey($instructorCourse, 'instructor_id', 'instructors', 'id');
    $database->addForeignKey($instructorCourse, 'course_id', 'courses', 'id');

    // Seed the instructor_course table with data
    $database->seedData($instructorCourse, $instructorCourseData);

    echo "Instructor_course table created and seeded successfully!<br>";
} else {
    echo "Instructor_course table already exists!<br>";
}

// Define table structure for enrollments
$enrollments = 'enrollments';
$enrollmentsColumns = 'id INT AUTO_INCREMENT PRIMARY KEY, enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, student_id INT, course_id INT, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL';

// Define seed data for enrollments (assuming Ali is enrolled in Mathematics course)
$enrollmentsData = [
    ['student_id' => 1, 'course_id' => 1], // Ali Student for Mathematics
];

// Create the enrollments table if it doesn't exist
if (!$database->tableExists($enrollments)) {
    // Create the enrollments table
    $database->createTable($enrollments, $enrollmentsColumns);

    // Define foreign key constraints
   
    $database->addForeignKey($enrollments, 'student_id', 'students', 'id');
    $database->addForeignKey($enrollments, 'course_id', 'courses', 'id');
    // Seed the enrollments table with data
    $database->seedData($enrollments, $enrollmentsData);

    echo "Enrollments table created and seeded successfully!<br>";
} else {
    echo "Enrollments table already exists!<br>";
}

// Define table structure for classes
$classes = 'classes';
$classesColumns = 'id INT AUTO_INCREMENT PRIMARY KEY, course_id INT, instructor_id INT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, deleted_at TIMESTAMP NULL';

// Define seed data for classes (assuming Arsalan is conducting classes for Mathematics course)
$classesData = [
    ['course_id' => 1, 'instructor_id' => 1], // Mathematics course with Arsalan Instructor
];

// Create the classes table if it doesn't exist
if (!$database->tableExists($classes)) {
    // Create the classes table
    $database->createTable($classes, $classesColumns);

    // Define foreign key constraints
    $database->addForeignKey($classes, 'course_id', 'courses', 'id');
    $database->addForeignKey($classes, 'instructor_id', 'instructors', 'id');

    // Seed the classes table with data
    $database->seedData($classes, $classesData);

    echo "Classes table created and seeded successfully!<br>";
} else {
    echo "Classes table already exists!<br>";
}
