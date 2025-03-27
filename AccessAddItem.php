<?php
// Database connection using MySQLi with error handling
$conn = new mysqli("localhost", "root", "", "fyp");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $storeID = filter_input(INPUT_POST, 'storeID', FILTER_SANITIZE_NUMBER_INT);
    $itemName = htmlspecialchars(trim($_POST['itemName']), ENT_QUOTES, 'UTF-8'); // Prevent XSS
    $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_INT);
    $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8'); // Prevent XSS

    // Handle file upload securely
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['itemImage']['tmp_name'];
        $imageData = file_get_contents($fileTmpPath); // Read file as binary
    } else {
        die("File upload failed or not provided.");
    }

    // Use Prepared Statements to prevent SQL Injection
    $sql = "INSERT INTO item (StoreID, ItemName, Amount, ItemImage, Description) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $storeID, $itemName, $amount, $imageData, $description);

    if ($stmt->execute()) {
        // Capture event details securely
        $timestamp = date("Y-m-d H:i:s");
        $event = "New item added: $itemName (Store ID: $storeID, Amount: $amount)";

        // Use Prepared Statements for logging
        $logSql = "INSERT INTO log_events (timestamp, event) VALUES (?, ?)";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("ss", $timestamp, $event);
        $logStmt->execute();
        $logStmt->close();

        echo "<script>
                alert('Item added successfully.');
                window.location.href = 'store$storeID.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
