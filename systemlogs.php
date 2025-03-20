<?php 
include "conn.php"; 
include "autch.php"; 
?>

<!DOCTYPE html>
<html>
<head>
  <title> System Log </title>
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
    text-align: left;
}

        .timestamp {
            font-weight: bold;
            color: #333;
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

/* Left Side: Title & Search */
.left-section {
    display: flex;
    align-items: center;
    gap: 15px; /* Space between title and search */
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
            <h3 style="margin-bottom: 40px;">List of Request Form </h3>
            
          <div class="search-add" style="display: flex; justify-content: center; align-items: center; margin-bottom: 30px;">
              <div class="left-section" style="text-align: center;">
                  <form>
                      <input type="text" id="searchForm" placeholder="Search .." onkeyup="searchLogs()" required>
                      <button type="submit">Search</buttonlog>
                  </form>
              </div>
          </div>

            <div> 
                <?php
                    $query = "SELECT * FROM log_events ORDER BY timestamp DESC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='log-card'>
                                    <p class='timestamp'>Timestamp: {$row['timestamp']}</p>
                                    <p>{$row['event']}</p>
                                </div>";
                        }
                    } else {
                        echo "<p>No logs found.</p>";
                    }
                ?>
            </div>
            <!-- Hidden by default -->
            <p id="noLogsMessage" style="display: none; text-align: center; color: red; font-size: 20px; font-weight: bold;">No logs found.</p>
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

      <script>
      function searchLogs() {
          let input = document.getElementById("searchForm").value.toLowerCase();
          let logCards = document.querySelectorAll(".log-card");
          let noLogsMessage = document.getElementById("noLogsMessage");
          let found = false;

          logCards.forEach(card => {
              let text = card.innerText.toLowerCase();
              if (text.includes(input)) {
                  card.style.display = "block";
                  found = true;
              } else {
                  card.style.display = "none";
              }
          });

          // Show "No logs found." if no results match
          noLogsMessage.style.display = found ? "none" : "block";
      }


        </script>
</body>
</html> 


