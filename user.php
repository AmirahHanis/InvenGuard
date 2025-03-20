<?php
include "conn.php"; 
include "autch.php"; 

// Fetch users from the database
$query = "SELECT id, fullname, position, profilepicture FROM user";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html>
<head>
  <title> User </title>
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
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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

p {
    text-align: center;
}

.user-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Creates 3 equal columns */
    gap: 20px; /* Adjust spacing between cards */
    justify-content: center;
    padding: 20px;
}

.user-card {
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.user-name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.user-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px; /* Adds spacing between profile picture and position */
}

.profile-pic {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
}

.user-position {
    font-size: 14px;
    color: gray;
    text-align: left;
}

.edit-icon {
    position: absolute;
    bottom: 10px;
    right: 10px;
    font-size: 18px;
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.edit-icon:hover {
    color: #0056b3;
}
.add-user {
    display: block;
    margin: 20px auto;
    padding: 10px 15px;
    background: black;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .user-list {
        grid-template-columns: repeat(2, 1fr); /* 2 columns on smaller screens */
    }
}

@media (max-width: 600px) {
    .user-list {
        grid-template-columns: repeat(1, 1fr); /* 1 column on mobile screens */
    }
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
        <div class="container" style="background-color:#f1f1f1; text-align: center; padding: 20px;">
        <h2>User</h2>
        <p>List of Users</p>

        <div class="user-list">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="user-card">
                    <h3 class="user-name"><?php echo htmlspecialchars($row['fullname']); ?></h3>
                    <div class="user-info">
                        <?php 
                        if (!empty($row['profilepicture'])) {
                            $imageData = base64_encode($row['profilepicture']);
                            $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                        } else {
                            $imageSrc = 'default-profile.jpg';
                        }
                        ?>
                        <img class="profile-pic" src="<?php echo $imageSrc; ?>" alt="Profile Picture">
                        <p class="user-position"><?php echo htmlspecialchars($row['position']); ?></p>
                       
                    </div>
                    <div style="position: relative;"> <!-- Edit Symbol -->
                    <a href="edituser.php?id=<?php echo $row['id']; ?>" class="edit-icon">✎</a>
                    </div>       
                </div>
            <?php } ?>
        </div>


        <button class="add-user" onclick="location.href='add_user.php'">Add User</button>
        </div>
        
          <div style="display: flex; justify-content: center; align-items: center;">
            <a href="inventory.php" class="back">
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


