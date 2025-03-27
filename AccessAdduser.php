<?php
session_start(); // Start session to track logged-in user

// Database connection
$conn = new mysqli("localhost", "root", "", "fyp");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    // Get form data and sanitize input
    $id = trim($_POST['id']);
    $password = $_POST['password'];
    $fullname = trim($_POST['fullname']);
    $position = trim($_POST['position']);

    // Get the logged-in user
    $adminUser = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown';

    // Check for SQL Injection or XSS
    $pattern = '/[\'\";<>(){}&]/';
    if (preg_match($pattern, $id) || preg_match($pattern, $fullname) || preg_match($pattern, $position)) {
        logEventToDatabase("🚨 Suspicious input detected for user registration", $conn);
        echo "<script>alert('🚨 Suspicious input detected! Item was not added.'); window.history.back();</script>";
        exit();
    }

    // Validate password strength
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        logEventToDatabase("❌ Weak password attempt by $adminUser", $conn);
        echo "<script>alert('❌ Password must be at least 8 characters and include letters, numbers, and symbols.'); window.history.back();</script>";
        exit();
    }

    // Hash the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Handle file upload securely
    $profilePicture = null;
    if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($_FILES['profilepicture']['tmp_name']);

        if (!in_array($file_type, $allowed_types)) {
            logEventToDatabase("❌ Invalid file type upload attempt by $adminUser", $conn);
            echo "<script>alert('❌ Invalid file type. Please upload a JPG, PNG, or GIF image.'); window.history.back();</script>";
            exit();
        }

        $profilePicture = file_get_contents($_FILES['profilepicture']['tmp_name']);
    }

    // Prepare and execute SQL query using prepared statements
    $sql = "INSERT INTO user (username, password, fullname, position, ProfilePicture) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $id, $hashed_password, $fullname, $position, $profilePicture);

    if ($stmt->execute()) {
        logEventToDatabase("✅ User '$id' added successfully by $adminUser", $conn);
        echo "<script>
                alert('✅ User added successfully!');
                window.location.href = 'user.php';
              </script>";
    } else {
        logEventToDatabase("❌ Error adding user '$id' by $adminUser: " . $stmt->error, $conn);
        echo "<script>
                alert('❌ Error: " . $stmt->error . "');
                window.history.back();
              </script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
