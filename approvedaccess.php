<?php
include 'conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
    $requestID = $_POST['requestID'];

    // Update request status and approval date
    $sql = "UPDATE requestform 
            SET RequestStatus = 'Approved', ApprovedDate = NOW() 
            WHERE RequestID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $requestID);

    if ($stmt->execute()) {
        echo "<script>alert('Request Approved Successfully!'); window.location.href='form.php';</script>";
    } else {
        echo "<script>alert('Error Approving Request'); window.history.back();</script>";
    }
}
?>
