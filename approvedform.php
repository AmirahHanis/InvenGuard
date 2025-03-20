<?php
include 'conn.php'; // Ensure this file contains your database connection

if (!isset($_GET['id'])) {
    echo "Invalid Request.";
    exit;
}

$requestID = $_GET['id'];

// Fetch request details
$sql = "SELECT r.RequestID, r.PICName, i.ItemName, r.Amount, r.RequestDate, r.RequestStatus
        FROM requestform r
        JOIN item i ON r.ItemID = i.ItemID
        WHERE r.RequestID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $requestID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Request not found.";
    exit;
}

$row = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html>
<head>
<title>Approving Form</title>
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
  
/* Add some shadows to create a card effect */
.card {
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
  width : 200; 
  height :200;
  background-color:#DBDFE1;
}

/* Some left and right padding inside the container */
.container {
  width : 230; 
  height :230;
}

/* Clear floats */
.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
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


.main{
  width:60%;
  background-color: white;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 5px 20px 50px #000;
}

.container {
  padding: 10px;
}

.column-66 {
  float: left;
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

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
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

body .container .card:nth-child(1) .box .content a {
  background: #005A92;
}

body .container .card:nth-child(2) .box .content a {
  background: #005A92;
}


body .container .card .box {
  position: absolute;
  top: 20px;
  left: 20px;
  right: 20px;
  bottom: 20px;
  background: #292929;
  border-radius: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  transition: 0.5s;
}

body .container .card .box:hover {
  transform: translateY(-50px);
}

body .container .card .box:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 50%;
  height: 50%;
  background: rgba(255, 255, 255, 0.03);
}

body .container .card .box .content {
  padding: 20px;
  text-align: center;
}

body .container .card .box .content h2 {
  position: absolute;
  top: -10px;
  right: 30px;
  font-size: 8rem;
  color: rgba(255, 255, 255, 0.1);
}

body .container .card .box .content h3 {
  font-size: 1.8rem;
  color: #fff;
  z-index: 1;
  transition: 0.5s;
  margin-bottom: 15px;
}

body .container .card .box .content p {
  font-size: 1rem;
  font-weight: 300;
  color: rgba(255, 255, 255, 0.9);
  z-index: 1;
  transition: 0.5s;
}

body .container .card .box .content a {
  position: relative;
  display: inline-block;
  padding: 8px 20px;
  background: black;
  border-radius: 5px;
  text-decoration: none;
  color: white;
  margin-top: 20px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  transition: 0.5s;
}

body .container .card .box .content a:hover {
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);
  background: #fff;
  color: #000;
}

h2, h3 {
  font-family: "Poppins", sans-serif;
  font-weight: 900;
  text-align: center;
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

</style>
</head>

<body>

<div class="main">

        <!-- Navigation Bar -->
        <div class="navbar">
            <a href="home.php" >Home</a> 
            <a href="inventory.php" >Inventory</a> 
            <a href="user.php" >User</a>
            <a href="form.php" >Form</a>
            <a href="systemlogs.php" >System Logs</a>
            <a href="logout.php" class="logout-button">
                <img src="img/signout.png" alt="Logout" class="logout-img">
            </a>
        </div>


        <!-- Menu Section -->
        <div class="container" style="background-color:#f1f1f1">
            <h3 style="margin-bottom: 40px;">Request Form </h3>
            
            <form action="approvedaccess.php" method="post" enctype="multipart/form-data" style="max-width: 1000px; margin: auto; padding: 20px; border-radius: 10px; background: #f9f9f9;">
                <input type="hidden" name="requestID" value="<?php echo $row['RequestID']; ?>"
                required style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc;">

                <label>Person In Charge Name</label>
                <input type="text" value="<?php echo htmlspecialchars($row['PICName']); ?>" readonly
                style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc;"><br>

                <label>Item Name</label>
                <input type="text" value="<?php echo htmlspecialchars($row['ItemName']); ?>" readonly
                required style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc;">

                <label>Amount</label>
                <input type="text" value="<?php echo htmlspecialchars($row['Amount']); ?>" readonly
                required style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc;">

                <label>Date of Request</label>
                <input type="text" value="<?php echo htmlspecialchars($row['RequestDate']); ?>" readonly
                required style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc;">

                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="window.history.back();"
                        style="background: none; border: none; border-bottom: 1px solid black; color: black; padding: 10px; cursor: pointer;">
                        Cancel
                    </button>

                    <button type="submit" name="approve"
                        style="width: 100px; padding: 10px; background: black; color: white; border: none; border-radius: 5px; cursor: pointer;">
                        Approve
                    </button>
                </div>

            </form>
        </div>
        
          <div style="display: flex; justify-content: center; align-items: center;">
            <a href="form.php" class="back">
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


