<?php
include "conn.php";
session_start();

// log events to database
function logEventToDatabase($event, $conn) {
    $sql = "INSERT INTO log_events (event) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $event);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch user details
    $query = "SELECT * FROM user WHERE username='{$username}'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hashedPassword = $user['password'];
        $position = trim(strtolower($user['position'])); // Normalize case & remove spaces

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['position'] = $position;
            $_SESSION['fullname'] = $user['fullname']; 


            // Redirect based on user position
            switch ($position) {
                case 'admin': // Change to lowercase
                    $redirectPage = 'home.php';
                    break;
                case 'office staff': // Change to lowercase
                    $redirectPage = 'OfficeHomePage.php';
                    break;
                case 'site staff': // Change to lowercase
                    $redirectPage = 'SiteHomePage.php';
                    break;
                default:
                    $redirectPage = 'index.php';
                    break;
            }

            // Log successful login
            logEventToDatabase("Login from: $username (Position: $position)", $conn);

            // Ensure session is saved before redirection
            session_write_close();
            header("Location: $redirectPage");
            exit();
        } else {
            // Incorrect password
            logEventToDatabase("Failed login attempt for username: $username", $conn);
            echo "<script>alert('Wrong Password'); window.location='index.php';</script>";
            exit();
        }
    } else {
        // User not found
        logEventToDatabase("Failed login attempt for non-existing username: $username", $conn);
        echo "<script>alert('Username does not exist'); window.location='index.php';</script>";
        exit();
    }
}
?>
