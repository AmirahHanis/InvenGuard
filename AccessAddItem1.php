<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent XSS
    $itemID = htmlspecialchars($_POST["itemID"], ENT_QUOTES, 'UTF-8');
    $storeID = htmlspecialchars($_POST["storeID"], ENT_QUOTES, 'UTF-8');
    $itemName = htmlspecialchars($_POST["itemName"], ENT_QUOTES, 'UTF-8');
    $amount = htmlspecialchars($_POST["amount"], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST["description"], ENT_QUOTES, 'UTF-8');

    // Check if a new image is uploaded
    if ($_FILES["itemImage"]["size"] > 0) {
        $image = file_get_contents($_FILES["itemImage"]["tmp_name"]);

        // Update with new image
        $sql = "UPDATE item SET StoreID = ?, ItemName = ?, Amount = ?, Description = ?, ItemImage = ? WHERE ItemID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issbbi", $storeID, $itemName, $amount, $description, $image, $itemID);
    } else {
        // Update without changing the image
        $sql = "UPDATE item SET StoreID = ?, ItemName = ?, Amount = ?, Description = ? WHERE ItemID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssi", $storeID, $itemName, $amount, $description, $itemID);
    }

    // Execute query safely
    if ($stmt->execute()) {
        echo "<script>
                alert('Item updated successfully.');
                window.location.href = 'Officestore" . htmlspecialchars($storeID, ENT_QUOTES, 'UTF-8') . ".php';
              </script>";
    } else {
        echo "Error updating item: " . $conn->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
