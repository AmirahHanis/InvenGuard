<?php
include "conn.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']); // Convert ID to integer for security

        // Prepare the DELETE query
        $query = "DELETE FROM user WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Redirect back to the user list with success message
                header("Location: user.php?msg=User Deleted Successfully");
                exit();
            } else {
                echo "Error: Unable to delete user.";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error in SQL preparation.";
        }
    } else {
        echo "Invalid user ID.";
    }
} else {
    echo "Unauthorized access.";
}

mysqli_close($conn);
?>
