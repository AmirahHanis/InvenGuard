<?php
include "conn.php";
session_start();

// Secure session settings (only regenerate in production)
if ($_SERVER['SERVER_NAME'] !== 'localhost') { 
    session_regenerate_id(true);
}

// Log events securely
function logEventToDatabase($event, $conn) {
    $sql = "INSERT INTO log_events (event) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $event);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Brute force protection (limit login attempts)
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if ($_SESSION['login_attempts'] >= 5) {
    echo "<script>alert('Too many failed attempts. Try again later.'); window.location='index.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    // Validate and sanitize input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Username and Password are required!'); window.location='index.php';</script>";
        exit();
    }

    // Prevent XSS
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($user) {
        $hashedPassword = $user['password'];
        $position = strtolower(trim($user['position']));

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['position'] = $position;
            $_SESSION['fullname'] = $user['fullname'];

            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;

            // Determine redirect page based on position
            $redirectPages = [
                'admin' => 'home.php',
                'office staff' => 'OfficeHomePage.php',
                'site staff' => 'SiteHomePage.php'
            ];
            $redirectPage = $redirectPages[$position] ?? 'index.php';

            // Log successful login
            logEventToDatabase("Login successful for: $username (Position: $position)", $conn);

            session_write_close();
            header("Location: $redirectPage");
            exit();
        } else {
            $_SESSION['login_attempts']++;
            logEventToDatabase("Failed login attempt for username: $username", $conn);
            echo "<script>alert('Wrong Password'); window.location='index.php';</script>";
            exit();
        }
    } else {
        $_SESSION['login_attempts']++;
        logEventToDatabase("Failed login attempt for non-existing username: $username", $conn);
        echo "<script>alert('Username does not exist'); window.location='index.php';</script>";
        exit();
    }
}
?>
