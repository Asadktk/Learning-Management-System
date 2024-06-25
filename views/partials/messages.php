<?php

use Core\Session;

// Check for success message
if (Session::has('success')) {
    $successMessage = Session::get('success');
    echo '<div class="alert alert-success">' . htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') . '</div>';
}

// Check for warning message
if (Session::has('warning')) {
    $warningMessage = Session::get('warning');
    echo '<div class="alert alert-warning">' . htmlspecialchars($warningMessage, ENT_QUOTES, 'UTF-8') . '</div>';
}

// Check for error message
if (Session::has('error')) {
    $errorMessage = Session::get('error');
    echo '<div class="alert alert-danger">' . htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') . '</div>';
}

// Check for validation errors (if it's an array)
if (Session::has('errors') && is_array(Session::get('errors'))) {
    echo '<div class="alert alert-danger"><ul>';
    foreach (Session::get('errors') as $error) {
        echo '<li>' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</li>';
    }
    echo '</ul></div>';
}

// Clear flash messages after displaying them
Session::unflash();
?>
