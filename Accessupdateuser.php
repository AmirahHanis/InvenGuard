<?php
include("conn.php"); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $position = $_POST['position'];
    $updateFields = [];
    $params = [];
    $types = "";

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
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $updateFields[] = "password = ?";
        $params[] = $password;
        $types .= "s";
    }

    // Update username (if allowed)
    if (!empty($_POST['username'])) {
        $updateFields[] = "username = ?";
        $params[] = $_POST['username'];
        $types .= "s";
    }

    // Profile picture handling (fixing BLOB handling)
    if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['size'] > 0) {
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

        // Dynamically bind parameters
        $stmt->bind_param($types, ...$params);

        if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['size'] > 0) {
            $stmt->send_long_data(array_search($profilePicture, $params), $profilePicture);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Data successfully updated'); window.location.href='user.php';</script>";
        } else {
            echo "<script>alert('Error updating data'); window.location.href='Accessupdateuser.php?id=$id';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('No changes detected'); window.location.href='user.php?id=$id';</script>";
    }

    $conn->close();
}
?>
