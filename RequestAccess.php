<?php
session_start();
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $userID = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $picName = isset($_POST['PICName']) ? htmlspecialchars(trim($_POST['PICName']), ENT_QUOTES, 'UTF-8') : null;
    $storeID = isset($_POST['StoreID']) ? (int)$_POST['StoreID'] : null;
    $itemID = isset($_POST['ItemID']) ? (int)$_POST['ItemID'] : null;
    $itemName = isset($_POST['ItemName']) ? htmlspecialchars(trim($_POST['ItemName']), ENT_QUOTES, 'UTF-8') : null;
    $amount = isset($_POST['Amount']) ? (int)$_POST['Amount'] : 1;
    
    // Set Malaysia time zone
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $requestDate = date('Y-m-d H:i:s');

    $requestStatus = "Pending";

    // Validate required fields
    if (!$userID || !$picName || !$storeID || !$itemID || !$itemName || !$amount) {
        die("<script>alert('Error: Missing required fields.'); window.location.href='requestform.php';</script>");
    }

    $query = "INSERT INTO requestform (id, PICName, StoreID, ItemID, Amount, RequestDate, RequestStatus) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isisiss", $userID, $picName, $storeID, $itemID, $amount, $requestDate, $requestStatus);


    // Execute and redirect
    if ($stmt->execute()) {
        echo "<script>
            alert('Request submitted successfully.');
            window.location.href='SiteStore$storeID.php';
        </script>";
    } else {
        echo "<script>alert('Error: " . htmlspecialchars($stmt->error) . "'); window.location.href='requestform.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
