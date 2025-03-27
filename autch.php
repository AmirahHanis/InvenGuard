<?php
session_start();

// Set timeout duration (30 minutes)
$timeout_duration = 1800; // 1800 seconds = 30 minutes

// Check if last activity is set and if timeout has passed
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy session
    header("Location: index.php?timeout=true"); // Redirect to login page with timeout flag
    exit();
}

// Update last activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();

// Redirect to login page if user is not authenticated
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
?>
