<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestID = $_POST['requestID'];
    $picName = $_POST['picName'];
    $itemName = $_POST['itemName'];
    $amount = $_POST['amount'];
    $requestDate = $_POST['requestDate'];
    $approvedDate = $_POST['approvedDate'];
    $stockEntryDate = $_POST['stockEntryDate'];

    // Get ItemID from item table
    $sql = "SELECT ItemID FROM item WHERE ItemName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $itemName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $itemID = $row['ItemID'];
    } else {
        echo "Item not found.";
        exit();
    }
    $stmt->close();

    // Insert into notification table
    $sql = "INSERT INTO notification (RequestID, PICName, ItemID, ItemName, Amount, RequestDate, ApprovedDate, StockEntryDate)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isisssss", $requestID, $picName, $itemID, $itemName, $amount, $requestDate, $approvedDate, $stockEntryDate);

    if ($stmt->execute()) {
        echo "<script>
            alert('Notification successfully recorded!');
            window.location.href = 'form2.php'; 
        </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>
