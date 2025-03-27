<?php include "autch.php"; 

session_start();
require 'conn.php'; // Ensure your DB connection is included

// Get logged-in user's full name from session
$loggedInUser = $_SESSION['fullname'];

// Fetch the latest 2 approved requests for this user
$query = "SELECT ApprovedDate, StockEntryDate, RequestDate 
          FROM notification 
          WHERE PICName = ? 
          ORDER BY ApprovedDate DESC 
          LIMIT 2";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $loggedInUser);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
  <title> Home Page </title>
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
  float: left;
  width: 44.4%;
  margin-bottom: 16px;
  padding: 0 8px;
}

/* Display the columns below each other instead of side by side on small screens */
@media screen and (max-width: 230px) {
  .column {
    width : 200; 
  height :200;
  display: block;
  background-color:#FFFFFF;
  }
  .bg-img {
  /* The image used */
  width : 200; 
  height :200;
  display: block;
  background-color:#FFFFFF;
  }
  body{
    width : 200; 
  height :200;
  display: block;
  background-color:#FFFFFF;
  }

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


.main{
  width:60%;
  background-color: white;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 5px 20px 50px #000;
}

.container {
  padding: 20px;
  display: flex;
  flex-direction: column; /* Stack elements vertically */
  align-items: flex-start; /* Keep headings aligned to the left */
  max-width: 1200px;
  margin: 40px auto; /* Center container horizontally */
}


h3 {
  font-family: "Poppins", sans-serif;
  font-weight: 900;
  text-align: center;
  width: 100%; /* Ensure it spans the full container */
  display: block; /* Ensure it behaves like a block element */
}

h4 {
  font-family: "Poppins", sans-serif;
  font-weight: 900;
  text-align: center;
  width: 100%; /* Ensure it spans the full container */
  display: block; /* Ensure it behaves like a block element */
}

.footer {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 140px;
  background-color: White;
  color: black;
  text-align: center;
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

    .video-container {
    width: 100%;
    max-width: 100%;
    height: auto;
    display: flex;
    justify-content: center;
}

.video-container video {
    width: 100%;
    height: auto;
    max-height: 100%;
    border-radius: 10px;
}

.row {
    display: flex;
    justify-content: center; /* Centers the content inside */
    width: 100%; /* Take full width */
}

.column-66 {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.store-list {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
}

/* Store Card */
.store-card {
    background: linear-gradient(to bottom right, #f0f0f0, #ffffff);
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    width: 450px;
    height: auto;
    text-align: center;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.store-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

/* Card Heading */
.store-card h3 {
    font-size: 20px;
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
}

/* Request List */
.request-list {
    list-style: none;
    padding: 0;
    text-align: left;
    width: 100%;
}

.request-list li {
    background: rgba(113, 159, 210, 0.1);
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 16px;
}

.request-list li span {
    display: block;
    margin: 3px 0;
}

.no-request {
    color: #ff4d4d;
    font-weight: bold;
}

/* Responsive Design */
@media (max-width: 768px) {
    .store-list {
        flex-direction: column;
        align-items: center;
    }
}


h4 {
  font-family: "Poppins", sans-serif;
  font-weight: 900;
  text-align: center;
  width: 100%; /* Ensure it spans the full container */
  display: block; /* Ensure it behaves like a block element */
}

.icon {
    width: 40px;
    height: 40px;
    margin-right: 8px;
    vertical-align: middle;
}

.small-icon {
    width: 18px; /* Adjust size as needed */
    height: 18px;
    margin-right: 6px;
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
  

    <div class="video-container">
    <video autoplay loop muted playsinline controlsList="nodownload noplaybackrate nofullscreen">
            <source src="video/slide1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>


          <!-- Menu Section -->
    <div class="container" style="background-color:#f1f1f1" >
        <h4>Inventory Tracking and Stock Management System</h4><br>
        <p style="text-align: left; font-size: 20px; font-weight: bold; margin-left: 60px;">Welcome</p> 
        <p style="text-align: left; color: gray; margin-left: 60px;">Home Page</p>
          
        <div class="row">
            <div class="column-66">  
                <div class="store-list">
                    <!-- Approved Requests -->
                    <div class="store-card">
                    <h3><img src="img/ready.png" alt="Approved Request" class="icon"> Approved Requests</h3>
                        <ul class="request-list">
                            <?php if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <li>
                                      <span class="request-date">
                                          <img src="img/calendar.png" alt="Request Date" class="small-icon"> 
                                          Request: <?php echo date("d M", strtotime($row['RequestDate'])); ?>
                                      </span> 
                                      <span class="approved-date">
                                          <img src="img/approved.png" alt="Approved Date" class="small-icon"> 
                                          Approved: <?php echo date("d M", strtotime($row['ApprovedDate'])); ?>
                                      </span> 
                                      <span class="stock-entry">
                                          <img src="img/in-stock.png" alt="Stock Entry" class="small-icon"> 
                                          Stock Entry: <?php echo !empty($row['StockEntryDate']) ? date("d M", strtotime($row['StockEntryDate'])) : "TBA"; ?>
                                      </span>
                                  </li>
                            <?php } } else { ?>
                              <li class="no-request">
                                  <img src="img/forbidden.png" alt="No Request" class="small-icon"> 
                                  No approved requests found
                              </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



    </div>
  

 <div class="footer">
  <img src="img/footer1.png"><br>
  <a>ALL RIGHT RESERVED BY &copy; InvenGuard @ Strength Electrical (M) SDN BHD </a>
      </div>
</div>
</body>
</html> 
