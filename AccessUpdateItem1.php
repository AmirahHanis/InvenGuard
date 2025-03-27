<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemID = $_POST["itemID"];
    $storeID = $_POST["storeID"];
    $itemName = $_POST["itemName"];
    $amount = $_POST["amount"];
    $description = $_POST["description"];

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

    if ($stmt->execute()) {
        $storeID = $_POST['storeID']; // Get the store ID from the form
        echo "<script>
                alert('Item updated successfully.');
                window.location.href = 'Officestore$storeID.php';
              </script>";
    } else {
        echo "Error updating item: " . $conn->error;
    }
      

    $stmt->close();
    $conn->close();
}
?>