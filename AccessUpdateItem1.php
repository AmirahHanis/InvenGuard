<?php
include("conn.php");

// Function to detect SQL Injection patterns
function detectSQLInjection($input) {
    return preg_match('/\b(SELECT|INSERT|UPDATE|DELETE|DROP|UNION|OR\s+\d|AND\s+\d|--|#)\b/i', $input);
}

// Function to detect XSS patterns
function detectXSS($input) {
    return preg_match('/(<script|on\w+=|javascript:|vbscript:|expression\(|document\.|window\.|eval\(|innerHTML|outerHTML|href=|src=)/i', $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 🚨 Validate and check for SQL Injection / XSS before sanitization
    if (detectSQLInjection($_POST['itemID']) || detectSQLInjection($_POST['storeID']) || detectSQLInjection($_POST['itemName']) || 
        detectSQLInjection($_POST['description']) || detectXSS($_POST['itemName']) || detectXSS($_POST['description'])) {
        echo "<script>alert('🚨 Suspicious input detected! Update aborted.'); window.history.back();</script>";
        exit();
    }

    // ✅ Sanitize Input AFTER Validation
    $itemID = intval($_POST["itemID"]);
    $storeID = intval($_POST["storeID"]);
    $itemName = htmlspecialchars(trim($_POST["itemName"]), ENT_QUOTES, 'UTF-8');
    $amount = filter_var($_POST["amount"], FILTER_VALIDATE_INT);
    $description = htmlspecialchars(trim($_POST["description"]), ENT_QUOTES, 'UTF-8');

    // Validate required fields
    if (!$itemID || !$storeID || !$amount) {
        echo "<script>alert('❌ Invalid input detected. Please enter valid data.'); window.history.back();</script>";
        exit();
    }

    // ✅ Secure File Upload Handling (if a new image is uploaded)
    $updateImage = false;
    if (isset($_FILES["itemImage"]) && $_FILES["itemImage"]["size"] > 0) {
        $fileTmpPath = $_FILES["itemImage"]["tmp_name"];
        $fileSize = $_FILES["itemImage"]["size"];
        $fileType = mime_content_type($fileTmpPath);

        // Allowed image formats
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExt = strtolower(pathinfo($_FILES['itemImage']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileType, $allowedTypes) || !in_array($fileExt, $allowedExts)) {
            echo "<script>alert('❌ Invalid file type. Only JPG, PNG, and GIF images are allowed.'); window.history.back();</script>";
            exit();
        }

        // Limit file size (Max 2MB)
        if ($fileSize > 2 * 1024 * 1024) {
            echo "<script>alert('❌ File too large. Maximum size is 2MB.'); window.history.back();</script>";
            exit();
        }

        $image = file_get_contents($fileTmpPath);
        $updateImage = true;
    }

    // ✅ Secure SQL Update
    if ($updateImage) {
        $sql = "UPDATE item SET StoreID = ?, ItemName = ?, Amount = ?, Description = ?, ItemImage = ? WHERE ItemID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "<script>alert('❌ Database error: Unable to prepare statement.'); window.history.back();</script>";
            exit();
        }
        $stmt->bind_param("issbbi", $storeID, $itemName, $amount, $description, $image, $itemID);
    } else {
        $sql = "UPDATE item SET StoreID = ?, ItemName = ?, Amount = ?, Description = ? WHERE ItemID = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "<script>alert('❌ Database error: Unable to prepare statement.'); window.history.back();</script>";
            exit();
        }
        $stmt->bind_param("isssi", $storeID, $itemName, $amount, $description, $itemID);
    }

    // Execute Query
    if ($stmt->execute()) {
        // ✅ Secure Logging with Prepared Statement
        $timestamp = date("Y-m-d H:i:s");
        $event = "Updated item: " . $itemName . " (Store ID: " . $storeID . ", Amount: " . $amount . ")";
        
        $logSql = "INSERT INTO log_events (timestamp, event) VALUES (?, ?)";
        $logStmt = $conn->prepare($logSql);
        $logStmt->bind_param("ss", $timestamp, $event);
        $logStmt->execute();

        echo "<script>
                alert('✅ Item updated successfully.');
                window.location.href = 'Officestore$storeID.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('❌ Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
