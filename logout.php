<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Optional: Clear the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Redirect to the homepage or login page
header('Location: index.php'); // Change to the page you want to redirect to
exit();
?>
