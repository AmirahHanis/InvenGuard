<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['cart'][$_GET['id']])) {
    unset($_SESSION['cart'][$_GET['id']]);
}

// Redirect back to checkout page
header("Location: SiteCheckout.php");
exit();
?>
