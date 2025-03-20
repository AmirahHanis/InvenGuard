<?php
// Start session (if needed)
session_start();

// Include database connection
include 'conn.php'; 

// Check if POST request contains 'itemID'
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemID'])) {
    // Sanitize and get itemID
    $itemID = intval($_POST['itemID']); // Ensure it's an integer

    // Ensure itemID is valid
    if ($itemID > 0) {
        // Fetch StoreID before deleting the item
        $sql_fetch = "SELECT StoreID FROM item WHERE ItemID = ?";
        
        if ($stmt_fetch = $conn->prepare($sql_fetch)) {
            $stmt_fetch->bind_param("i", $itemID);
            $stmt_fetch->execute();
            $stmt_fetch->bind_result($storeID);
            $stmt_fetch->fetch();
            $stmt_fetch->close();
            
            // Ensure StoreID is retrieved
            if (!empty($storeID)) {
                // Now delete the item
                $sql_delete = "DELETE FROM item WHERE ItemID = ?";
                
                if ($stmt_delete = $conn->prepare($sql_delete)) {
                    $stmt_delete->bind_param("i", $itemID);
                    
                    // Execute the deletion
                    if ($stmt_delete->execute()) {
                        // Redirect to Store page based on StoreID
                        header("Location: OfficeStore$storeID.php?delete=success");
                        exit();
                    } else {
                        die("Error deleting item: " . $stmt_delete->error);
                    }
                } else {
                    die("Error preparing delete query: " . $conn->error);
                }
            } else {
                die("Store ID not found for this item.");
            }
        } else {
            die("Error preparing fetch query: " . $conn->error);
        }
    } else {
        die("Invalid Item ID.");
    }
} else {
    die("Invalid request.");
}

// Close connection
$conn->close();
?>
