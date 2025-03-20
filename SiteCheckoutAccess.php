<?php
session_start();
include "conn.php"; // Database connection

date_default_timezone_set('Asia/Kuala_Lumpur');

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty!'); window.location.href='Sitecheckout.php';</script>";
    exit();
}

// Validate required fields
if (!isset($_POST['id'], $_POST['PICName'], $_POST['CheckoutDate'], $_POST['amount'])) {
    echo "<script>alert('Invalid request. Missing required fields.'); window.location.href='Sitecheckout.php';</script>";
    exit();
}

$userID = (int) $_POST['id'];
$picName = $_POST['PICName'];
$checkoutDate = date('Y-m-d H:i:s', strtotime($_POST['CheckoutDate']));

// Insert checkout data
$sql = "INSERT INTO checkoutform (id, PICName, StoreID, ItemID, Amount, CheckoutDate) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

foreach ($_POST['amount'] as $itemID => $amount) {
    $storeID = $_POST['StoreID'][$itemID];

    // Insert into checkoutform
    $stmt->bind_param("isiiss", $userID, $picName, $storeID, $itemID, $amount, $checkoutDate);
    $stmt->execute();

    // ✅ Reduce item stock in the database
    $updateStockSql = "UPDATE item SET Amount = Amount - ? WHERE ItemID = ? AND StoreID = ? AND Amount >= ?";
    $updateStmt = $conn->prepare($updateStockSql);
    $updateStmt->bind_param("iiii", $amount, $itemID, $storeID, $amount);
    $updateStmt->execute();

    // Check if stock update was successful
    if ($updateStmt->affected_rows === 0) {
        echo "<script>alert('Not enough stock for item ID: $itemID'); window.location.href='Sitecheckout.php';</script>";
        exit();
    }
}

// Clear cart after checkout
unset($_SESSION['cart']);

echo "<script>alert('Checkout successful!'); window.location.href='SiteStore$storeID.php';</script>";

$stmt->close();
$conn->close();
?>
