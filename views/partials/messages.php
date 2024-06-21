<?php

use Core\Session;

// Check for success message
if (Session::has('success')) {
    echo '<div class="alert alert-success">' . Session::get('success') . '</div>';
}

// Check for warning message
if (Session::has('warning')) {
    echo '<div class="alert alert-warning">' . Session::get('warning') . '</div>';
}

// Check for error message
if (Session::has('error')) {
    echo '<div class="alert alert-danger">' . Session::get('error') . '</div>';
}

// Check for validation errors (if it's an array)
if (Session::has('errors') && is_array(Session::get('errors'))) {
    echo '<div class="alert alert-danger"><ul>';
    foreach (Session::get('errors') as $error) {
        echo '<li>' . $error . '</li>';
    }
    echo '</ul></div>';
}

// Clear flash messages after displaying them
Session::unflash();
?>
