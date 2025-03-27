<?php
session_start();
include("conn.php");

// Function to log events with the current session user
function logEventToDatabase($event, $conn) {
    $loggedUser = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown';

    // Ensure we do not append the username twice
    if (strpos($event, "by $loggedUser") === false) {
        $event .= " by $loggedUser";
    }

    $sql = "INSERT INTO log_events (event) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $event);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = trim($_POST['id']);
    $fullname = trim($_POST['fullname']);
    $position = trim($_POST['position']);
    $updateFields = [];
    $params = [];
    $types = "";

    // Prevent SQL Injection & XSS
    $pattern = '/[\'\";<>(){}&]/';
    if (preg_match($pattern, $id) || preg_match($pattern, $fullname) || preg_match($pattern, $position)) {
        logEventToDatabase("Security Alert: Suspicious input detected", $conn);
        echo "<script>alert('🚨 Suspicious input detected!'); window.history.back();</script>";
        exit();
    }

    // Update full name
    if (!empty($fullname)) {
        $updateFields[] = "fullname = ?";
        $params[] = $fullname;
        $types .= "s";
    }

    // Update position
    if (!empty($position)) {
        $updateFields[] = "position = ?";
        $params[] = $position;
        $types .= "s";
    }

    // Update password if provided
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];

        // Validate password strength
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            logEventToDatabase("Weak password attempt for user update", $conn);
            echo "<script>alert('❌ Weak password!'); window.history.back();</script>";
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $updateFields[] = "password = ?";
        $params[] = $hashed_password;
        $types .= "s";
    }

    // Update username if provided
    if (!empty($_POST['username'])) {
        $username = trim($_POST['username']);

        if (preg_match($pattern, $username)) {
            logEventToDatabase("Security Alert: Suspicious username update attempt", $conn);
            echo "<script>alert('🚨 Suspicious input detected!'); window.history.back();</script>";
            exit();
        }

        $updateFields[] = "username = ?";
        $params[] = $username;
        $types .= "s";
    }

    // Profile picture handling
    if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['size'] > 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['profilepicture']['tmp_name']);

        if (!in_array($file_type, $allowed_types)) {
            logEventToDatabase("Invalid file upload attempt", $conn);
            echo "<script>alert('❌ Invalid file type.'); window.history.back();</script>";
            exit();
        }

        $profilePicture = file_get_contents($_FILES['profilepicture']['tmp_name']);
        $updateFields[] = "ProfilePicture = ?";
        $params[] = $profilePicture;
        $types .= "b";
    }

    if (count($updateFields) > 0) {
        $sql = "UPDATE user SET " . implode(", ", $updateFields) . " WHERE id = ?";
        $params[] = $id;
        $types .= "i";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['size'] > 0) {
            $stmt->send_long_data(array_search($profilePicture, $params), $profilePicture);
        }

        if ($stmt->execute()) {
            logEventToDatabase("User information updated successfully", $conn);
            echo "<script>alert('✅ Data updated successfully'); window.location.href='user.php';</script>";
        } else {
            logEventToDatabase("Update failed: Error updating data", $conn);
            echo "<script>alert('❌ Error updating data'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        logEventToDatabase("No changes detected during update", $conn);
        echo "<script>alert('⚠️ No changes detected'); window.location.href='user.php';</script>";
    }

    $conn->close();
}
?>
