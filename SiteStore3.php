<?php 
include "conn.php"; 
include "autch.php"; 

session_start();
include 'conn.php'; // Ensure this file includes your database connection setup

// Fetch available items from the database
$sql = "SELECT ItemID, ItemName, StoreID FROM item WHERE amount > 0"; 
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['store'])) {
    $itemID = $_GET['id'];
    $storeID = $_GET['store'];

    // Fetch item details from the database
    $sql = "SELECT ItemID, ItemName, StoreID FROM item WHERE ItemID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $resultItem = $stmt->get_result();
    $item = $resultItem->fetch_assoc();

    if ($item) {
        // If item exists in the cart, increase the quantity
        if (isset($_SESSION['cart'][$itemID])) {
            $_SESSION['cart'][$itemID]['Amount'] += 1;
        } else {
            // Otherwise, add a new item to the cart, including StoreID
            $_SESSION['cart'][$itemID] = [
                'ItemID' => $item['ItemID'],
                'ItemName' => $item['ItemName'],
                'Amount' => 1,
                'StoreID' => $item['StoreID'] // Store ID is now saved in the session cart
            ];
        }
    }

    // Redirect to prevent form resubmission
    header("Location: SiteStore3.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title> Store 3 </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans);

* {box-sizing: border-box;}

body { 
  font-family: Verdana, sans-serif;
  width: 100%;
  height:100%;
    margin: 0;
  padding: 10px;
    display: flex;
  justify-content: center;
  align-items: center;
  font-family: 'Open Sans', sans-serif;
  background: linear-gradient(135deg, #2F4146 10%, #5C7D85 100%);
  
}

.button {
  background-color:#f1f1f1; 
  border-radius: 6px;
  color: black;
  padding: 24px 24px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 20px;
  font-family:verdana;
  font-weight: bold;
  margin: 4px 2px;
  cursor: pointer;
} 

a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}
.navbar {
  width: 100%;
  overflow: auto;
  background-color: black;
}

.navbar a {
  float: left;
  padding: 12px;
  color: black;
  text-decoration: none;
  font-size: 17px;
}

.navbar a:hover {
  background-color: dimgrey;
}

/* Create a right-aligned (split) link inside the navigation bar */
.navbar a.split {
  float: right;
  background-color: #04AA6D;
  color: white;
}

/* Three columns side by side */
.column {
  float: center;
  width: 44.4%;
  margin-bottom: 16px;
  padding: 0 8px;
}


.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}

a:link, a:visited {
  color: white;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

h1{
  font-size: 35px;
  font-family: Brush Script MT;
}


.main {
  width: 60%;
  background-color: white;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 5px 20px 50px #000;
  display: flex;
  flex-direction: column; /* Allows footer to be positioned properly */
  min-height: 100vh; /* Ensures it takes full height */
}

.container {
    width: 100%;
    margin: 20px auto;
}
.column-66 {
  float: center;
}

.large-font {
  font-size: 48px;
  text-align: center;
}

/* Float four columns side by side */
.column {
  float: left;
  width: 400px;
  margin: 50px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}


body .container {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: 40px 0;
}

/* outside box */
body .container .card {
  position: relative;
  min-width: 320px;
  height: 450px;
  box-shadow: inset 5px 5px 5px rgba(0, 0, 0, 0.2),
    inset -5px -5px 15px rgba(255, 255, 255, 0.1),
    5px 5px 15px rgba(0, 0, 0, 0.3), -5px -5px 15px rgba(255, 255, 255, 0.1);
  border-radius: 15px;
  margin: 30px;
  transition: 0.5s;
}


h2, h3 {
  font-family: "Poppins", sans-serif;
  font-weight: 900;
  text-align: center;
}

.footer {
  width: 100%;
  height: 140px;
  background-color: white;
  color: black;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative; /* Ensure it stays at the bottom */
}

   .logout-button {
        display: flex;
        align-items: center;
        text-decoration: none;
        padding: 5px;
    }
    
    .logout-img {
        width: 25px; /* Adjust size as needed */
        height: auto;
        cursor: pointer;
    }
    
    .logout-button:hover .logout-img {
        opacity: 0.7; /* Adds a hover effect */
    }

    h2 {
    color: #333;
}

form {
    display: flex;
    margin-bottom: 20px;
}

input[type="text"] {
    flex: 1;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 8px 15px;
    background-color: #5c67f2;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 10px;
}

button:hover {
    background-color: #454dcf;
}

.search-add {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Pushes left & right elements */
    width: 100%;
}

/* Left Side: Title & Search */
.left-section {
    display: flex;
    align-items: center;
    gap: 15px; /* Space between title and search */
}

/* Right Side: Add Item Button */
.right-section {
    display: flex;
    align-items: center;
}

.search-add form {
    display: flex;
    flex-grow: 1;
    max-width: 500px; /* Increase the width */
    height: 40px;
    border-radius: 25px;
    overflow: hidden;
    border: 1px solid white;
    background-color: black;
    align-items: center;
}

.search-add input {
    flex: 1;
    width: 100%; /* Ensures it takes full space */
    height: 100%;
    padding: 10px;
    border: none;
    outline: none;
    background: black;
    color: white;
    font-size: 16px;
    min-width: 1000px; /* Increase width */
    max-width: 1200px; /* Add max-width for control */
}


.search-add input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

/* Search Button */
.search-add button {
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 10px 15px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-add button img {
    width: 20px;
    height: 20px;
}

/* Add Item Button */
.add-button {
    padding: 10px 15px;
    background-color: black;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    white-space: nowrap; /* Prevents text wrapping */
    height: 40px; /* Matches search bar height */
    display: flex;
    align-items: center;
    justify-content: center;
}

.inventory-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 columns per row */
    gap: 20px; /* Adjust spacing */
    justify-content: center;
    align-items: center;
    max-width: 1200px; /* Adjust based on your layout */
    margin: auto;
}

.item-card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}


.item-card img {
    width: 200px;
    height:200px;
    object-fit: cover;
    border-radius: 5px;
}

.item-card h3 {
    margin: 10px 0;
    font-size: 18px;
}

.update-button {
    padding: 8px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.update-button:hover {
    background-color: #0056b3;
}

.back {
    display: flex;
    align-items: center;
    gap: 8px; /* Adds space between image and text */
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: black !important; /* Ensures white text */
    text-decoration: none; /* Removes underline */
    font-weight: bold;
}

.back:hover {
 background-color: grey;
}

.request-button {
    padding: 8px 15px;
    background-color:Red;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

</style>
</head>

<body>

<div class="main">

        <!-- Navigation Bar -->
        <div class="navbar">
            <a href="SiteHomePage.php" >Home</a> 
            <a href="inventorymenu.php" >Inventory</a> 
            <a href="formmenu.php" >Form</a>
            <a href="Mailbox.php" >Mailbox</a>
            <a href="logout.php" class="logout-button">
                <img src="img/signout.png" alt="Logout" class="logout-img">
            </a>
        </div>


        <!-- Menu Section -->
        <div class="container" style="background-color:#f1f1f1; text-align: center; padding: 20px;">
            <h3 style="margin-bottom: 40px;">Store 3 - Pipes and Fitting </h3>
            
          <!-- Search Bar & Add Item Button in a Flexbox Layout --> 
          <div class="search-add">
            <div class="left-section">
            <h5 style="margin-bottom: 20px;">List of Items</h5> 
            <form onsubmit="return false;">
                <input type="text" id="searchInput" placeholder="Search items..." onkeyup="searchItems()">
            </form>
            </div>
                  <div class="right-section">
                      <a href="SiteCheckout.php?storeID=3" class="add-button" style="margin-bottom: 20px;">Cart</a>
                  </div>
          </div>
          
        <div class="inventory-grid">
        <?php
            $sql = "SELECT * FROM item WHERE StoreID = 3"; // Fetch only Store 1 items
            $result = $conn->query($sql);
            $hasItems = false; // Flag to track if any items exist

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $hasItems = true; // At least one item exists
                        echo '<div class="item-card">';

                        // Decode the blob image
                        $imageData = base64_encode($row["ItemImage"]);
                        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

                        echo '<img src="' . $imageSrc . '" alt="' . $row["ItemName"] . '" width="150">';
                        echo '<h3 class="item-name">' . $row["ItemName"] . '</h3>';
                        echo '<p class="item-description">' . $row["Description"] . '</p>';

                        // Apply red color if Amount is 0, otherwise default color
                        $amountColor = ($row["Amount"] == 0) ? 'style="color: red;"' : '';
                        echo '<p ' . $amountColor . '>Amount: ' . $row["Amount"] . '</p>';

                        if ($row["Amount"] == 0) {
                            echo '<a href="requestform.php?id=' . $row["ItemID"] . '&StoreID=' . $row["StoreID"] . '" class="request-button">Request</a>';
                        } else {
                            echo '<a href="SiteStore3.php?id=' . $row["ItemID"] . '&store=' . $row["StoreID"] . '" class="update-button">Add</a>';
                        }

                        echo '</div>';
                    }
                }
            ?>
            
            <!-- Always include the "No items found" message, but hide it initially -->
            <p id="noRecordMessageSearch" style="text-align: center; color: red; font-weight: bold; font-size:20px; display: <?php echo ($hasItems ? 'none' : 'block'); ?>;">
                No items found.
            </p>
          </div>
        </div>
        
          <div style="display: flex; justify-content: center; align-items: center;">
            <a href="inventorymenu.php" class="back">
                <img src="img/backbutton.png" alt="Back" width="20" height="20"> Previous
            </a>
          </div>
        <br>
          <div class="footer">
              <img src="img/footer1.png"><br>
              <a>ALL RIGHT RESERVED BY &copy; InvenGuard @ Strength Electrical (M) SDN BHD </a>
          </div>
</div>

<script>
        function searchItems() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let itemCards = document.querySelectorAll(".item-card");
            let noRecordMessage = document.getElementById("noRecordMessageSearch");

            let found = false;

            itemCards.forEach(card => {
                let itemName = card.querySelector(".item-name").innerText.toLowerCase();
                let itemDesc = card.querySelector(".item-description").innerText.toLowerCase();

                if (itemName.includes(input) || itemDesc.includes(input)) {
                    card.style.display = "block"; // Show matching item
                    found = true;
                } else {
                    card.style.display = "none"; // Hide non-matching item
                }
            });

            // If no items found, show message; otherwise, hide it
            if (!found) {
                if (!noRecordMessage) {
                    noRecordMessage = document.createElement("p");
                    noRecordMessage.id = "noRecordMessageSearch";
                    noRecordMessage.style.color = "red";
                    noRecordMessage.style.fontWeight = "bold";
                    noRecordMessage.style.fontSize = "20px";
                    noRecordMessage.style.textAlign = "center";
                    noRecordMessage.innerText = "No items found.";
                    document.querySelector(".inventory-grid").appendChild(noRecordMessage);
                }
                noRecordMessage.style.display = "block";
            } else {
                if (noRecordMessage) noRecordMessage.style.display = "none";
            }
        }
      </script>
      
</body>
</html> 


