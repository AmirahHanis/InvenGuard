<?php
session_start();
include 'conn.php'; // Ensure this includes your DB connection

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// Step 1: Get Fullname based on Username
$stmt = $conn->prepare("SELECT fullname FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$fullname = $user['fullname'];

$stmt->close();

// Step 2: Fetch Notifications where PICName matches Fullname
$query = "SELECT * FROM notification WHERE PICName = ? ORDER BY ApprovedDate DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $fullname);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>
<title>Mailbox</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
    flex-direction: column; /* Stack elements vertically */
    align-items: flex-start; /* Align text to the left */
}

/* Make Approved Date bigger */
.approved-date {
    font-size: 20px; /* Increase font size */
    font-weight: bold; /* Make it bold */
    margin-bottom: 10px; /* Add spacing below */
}

/* Ensure item name has proper spacing */
.item-name {
    font-size: 16px;
    margin-bottom: 10px;
}

/* Ensure button is below the text */
.btn {
    display: inline-block;
    padding: 8px 12px;
    background:rgb(202, 203, 204);
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 5px; /* Adds spacing above the button */
}

.btn:hover {
    background:rgb(162, 162, 162);
}

.icon {
    width: 40px;
    height: 40px;
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
            <h3 style="margin-bottom: 40px;">Approved Request Form</h3>
            
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="log-card">
                  <p class="approved-date">
                      <img src="img/ready.png" alt="Approved" class="icon"> 
                      <strong>Approved Date:</strong> <?php echo date("d M Y", strtotime($row['ApprovedDate'])); ?>
                  </p>
                    <p class="item-name">Item: <?php echo $row['ItemName']; ?></p>
                    <a href="viewform3.php?id=<?php echo $row['NotificationID']; ?>" class="btn">View</a>
                </div>
            <?php } ?>

          
        </div>
        
          <div style="display: flex; justify-content: center; align-items: center;">
            <a href="Sitehomepage.php" class="back">
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
</html> 

<?php
$stmt->close();
$conn->close();
?>
