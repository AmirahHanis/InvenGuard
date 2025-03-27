<?php
session_start();
include 'conn.php'; 

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to login if not authenticated
    exit();
}

// Retrieve the logged-in user's fullname
$username = $_SESSION['username'];
$userQuery = $conn->prepare("SELECT fullname FROM user WHERE username = ?");
$userQuery->bind_param("s", $username);
$userQuery->execute();
$userResult = $userQuery->get_result();
$userRow = $userResult->fetch_assoc();
$fullname = $userRow['fullname'];

// Fetch request records for the logged-in user, joining item table to get ItemName
$query = $conn->prepare("
    SELECT r.RequestID, r.RequestDate, i.ItemName, r.RequestStatus 
    FROM requestform r
    JOIN item i ON r.ItemID = i.ItemID
    WHERE r.PICName = ?
");
$query->bind_param("s", $fullname);
$query->execute();
$result = $query->get_result();
?>


<!DOCTYPE html>
<html>
<head>
  <title> Form Page </title>
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

.log-card {
            width: 800px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .log-content {
            display: flex;
            flex-direction: column;
        }
        .log-status {
            display: flex;
            align-items: center;
            gap: 10px; /* Space between status badges */
        }
        .status {
            padding: 5px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .status-approved {
            background: green;
            color: white;
        }
        .status-pending {
            background: red;
            color: white;
        }
        .status-default {
            background: white;
            color: black;
        }
       
    .log-detail {
    display: flex;
    align-items: center;
    gap: 5px; /* Adjust spacing */
    margin: 0;
    padding: 0;
    }

    .log-content a {
    display: inline-block; /* Ensures the link only takes up the text size */
    padding: 1px;
    font-size: 18px;
    }

    .log-content a:hover {
        color: blue;
        background-color: rgba(0, 0, 255, 0.1); /* Light blue background */
        border-radius: 3px; /* Slight rounded corners */
    }

    .log-content p {
    margin: 0;
    padding: 0;
    text-align: left;
    margin-bottom: 10px;
}

.icon {
    width: 30px;
    height: 30px;
    margin-right: 8px;
    vertical-align: middle;
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
            <h3 style="margin-bottom: 40px;">List of Request Form </h3>
            
          <!-- Centered Search Bar & Add Item Button -->
          <div class="search-add" style="display: flex; justify-content: center; align-items: center;">
              <div class="left-section" style="text-align: center;">
                  <h5 style="margin-bottom: 20px;"><strong>Request Form</strong></h5>
                  <form>
                      <input type="text" id="searchForm" placeholder="Search by Name/Date.." onkeyup="searchRequests()" required>
                  </form>
              </div>
          </div>
          
          <div id="logContainer">
              <?php if ($result->num_rows > 0): ?>
                  <?php while ($row = $result->fetch_assoc()): ?>
                      <div class="log-card">
                          <div class="log-content">
                          <p>
                              <strong>
                                  <a href="viewform4.php?id=<?php echo $row['RequestID']; ?>" class="log-date" style="text-decoration: none; color: black;">
                                      <img src="img/calendar.png" alt="Date" class="icon">
                                      Date: <?php echo $row['RequestDate']; ?>
                                  </a>
                              </strong>
                          </p>
                              <div class="log-detail log-item">Item: <?php echo $row['ItemName']; ?></div>
                          </div>
                          <div class="log-status">
                              <?php if ($row['RequestStatus'] === 'Approved'): ?>
                                  <span class="status status-approved">Approved</span>
                                  <span class="status status-default">Pending</span>
                              <?php elseif ($row['RequestStatus'] === 'Pending'): ?>
                                  <span class="status status-default">Approved</span>
                                  <span class="status status-pending">Pending</span>
                              <?php endif; ?>
                          </div>
                      </div>
                  <?php endwhile; ?>
              <?php endif; ?>
          </div>

          <!-- Always present the "No requests found" message but hide it initially -->
          <p id="noRecordMessage" style="text-align: center; color: red; font-weight: bold; font-size: 20px; display: none;">
              No requests found.
          </p>
        
        </div>
        
          <div style="display: flex; justify-content: center; align-items: center;">
            <a href="SiteHomePage.php" class="back">
                <img src="img/backbutton.png" alt="Back" width="20" height="20"> Previous
            </a>
          </div>
        <br>
          <div class="footer">
              <img src="img/footer1.png"><br>
              <a>ALL RIGHT RESERVED BY &copy; InvenGuard @ Strength Electrical (M) SDN BHD </a>
          </div>
</div>
</body>

    <script>
        function searchRequests() {
          let input = document.getElementById("searchForm").value.toLowerCase().trim();
          let logCards = document.querySelectorAll(".log-card");
          let noRecordMessage = document.getElementById("noRecordMessage");
          let found = false;

          logCards.forEach(card => {
              let itemName = card.querySelector(".log-item").innerText.toLowerCase().trim();
              let requestDate = card.querySelector(".log-date").innerText.toLowerCase().replace("date: ", "").trim();

              if (itemName.includes(input) || requestDate.includes(input)) {
                  card.style.display = "flex"; // Keep original layout
                  found = true;
              } else {
                  card.style.display = "none";
              }
          });

          // Show "No requests found" only if no items match
          if (noRecordMessage) {
              noRecordMessage.style.display = found ? "none" : "block";
          }
      }

    </script>
</html> 


