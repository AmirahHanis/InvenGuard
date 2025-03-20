<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "fyp");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to detect SQL Injection patterns
function detectSQLInjection($input) {
    return preg_match('/\b(SELECT|INSERT|UPDATE|DELETE|DROP|UNION|OR\s+\d|AND\s+\d|--|#)\b/i', $input);
}

// Function to detect XSS patterns
function detectXSS($input) {
    return preg_match('/(<script|onerror|onload|javascript:|alert|eval|document\.cookie|href=|<iframe|<img|style=|expression\(|vbscript:)/i', $input);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 🚨 Check for SQL Injection & XSS before sanitization
    if (detectSQLInjection($_POST['storeID']) || detectSQLInjection($_POST['itemName']) || detectSQLInjection($_POST['description']) || 
        detectXSS($_POST['storeID']) || detectXSS($_POST['itemName']) || detectXSS($_POST['description'])) {
        echo "<script>alert('🚨 Suspicious input detected! Item was not added.'); window.history.back();</script>";
        exit();
    }

    // ✅ Sanitize input AFTER validation
    $storeID = htmlspecialchars($_POST['storeID'], ENT_QUOTES, 'UTF-8');
    $itemName = htmlspecialchars($_POST['itemName'], ENT_QUOTES, 'UTF-8');
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_INT);
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

    // Validate amount
    if ($amount === false) {
        echo "<script>alert('Invalid amount. Please enter a valid number.'); window.history.back();</script>";
        exit();
    }

    // ✅ Secure File Upload Handling
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['itemImage']['tmp_name'];
        $fileSize = $_FILES['itemImage']['size'];
        $fileType = mime_content_type($fileTmpPath);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        // Check file extension
        $fileExt = strtolower(pathinfo($_FILES['itemImage']['name'], PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($fileType, $allowedTypes) || !in_array($fileExt, $allowedExts)) {
            echo "<script>alert('Invalid file type. Only JPG, PNG, and GIF images are allowed.'); window.history.back();</script>";
            exit();
        }

        // Limit file size (e.g., max 2MB)
        if ($fileSize > 2 * 1024 * 1024) {
            echo "<script>alert('File is too large. Maximum 2MB allowed.'); window.history.back();</script>";
            exit();
        }

        $imageData = file_get_contents($fileTmpPath);
    } else {
        echo "<script>alert('Error uploading file.'); window.history.back();</script>";
        exit();
    }

    // ✅ Use Prepared Statement
    $sql = "INSERT INTO item (StoreID, ItemName, Amount, ItemImage, Description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo "<script>alert('Database error: Unable to prepare statement.'); window.history.back();</script>";
        exit();
    }
    
    $stmt->bind_param("ssiss", $storeID, $itemName, $amount, $imageData, $description);

    if ($stmt->execute()) {
        // ✅ Secure Logging with Prepared Statement
        $timestamp = date("Y-m-d H:i:s");
        $event = "New item added: " . $itemName . " (Store ID: " . $storeID . ", Amount: " . $amount . ")";
        
        $logSql = "INSERT INTO log_events (timestamp, event) VALUES (?, ?)";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("ss", $timestamp, $event);
        $logStmt->execute();

        echo "<script>
                alert('✅ Item added successfully.');
                window.location.href = 'store$storeID.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('❌ Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
