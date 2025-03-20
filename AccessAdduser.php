<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fyp");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST['id'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $position = $_POST['position'];

    // Hash the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Handle file upload
    if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['error'] == 0) {
        $profilePicture = file_get_contents($_FILES['profilepicture']['tmp_name']);
    } else {
        $profilePicture = null;
    }

    // Prepare and execute SQL query
    $sql = "INSERT INTO user (username, password, fullname, position, ProfilePicture) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $id, $hashed_password, $fullname, $position, $profilePicture);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('User added successfully!');
                window.location.href = 'user.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'add_user.php';
              </script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
