<?php include "autch.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <title> Inventory Page </title>
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

.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 3.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
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
  height: auto; /* Change from fixed 850px to allow flexible height */
  background-color: white;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 5px 20px 50px #000;
  display: flex;
  flex-direction: column; /* Ensures content stacks properly */
  align-items: center; /* Centers content horizontally */
  justify-content: center; /* Centers content vertically */
}


.container {
  padding: 10px;
  height:500px;
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
  margin-top: auto; /* Pushes the footer to the bottom */
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
            margin-bottom: 5px;
        }

        .store-list {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .store-card {
          background: white;
          padding: 15px;
          border-radius: 8px;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
          width: 300px;
          height: 200px;
          text-align: center;
          transition: transform 0.2s;

          /* Flexbox for centering */
          display: flex;
          flex-direction: column;
          justify-content: center; /* Centers content vertically */
          align-items: center; /* Centers content horizontally */
      }


        .store-card:hover {
            transform: translateY(-5px);
        }

        .store-card h3 {
            margin: 10px 0;
            font-size: 18px;
        }

        .store-card p {
            margin: 5px 0;
            color: #555;
        }

        .store-card strong {
            font-weight: bold;
            display: block;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .store-list {
                flex-direction: column;
                align-items: center;
            }
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
        <div class="container" style="background-color:#f1f1f1">
        <div class="row">
            <div class="column-66">
                <h2>Inventory</h2>
                <h4>List of Store</h4><br>
                    <div class="store-list">
                        <a href="Sitestore1.php" class="store-card" style="text-decoration: none; color: inherit;">
                            <h3>Store 1</h3>
                            <p>Location: Jalan Andenium 5</p>
                            <strong>Cables, Wires, Cable Management</strong>
                        </a>

                        <a href="Sitestore2.php" class="store-card" style="text-decoration: none; color: inherit;">
                            <h3>Store 2</h3>
                            <p>Location: Jalan Andenium 13</p>
                            <strong>Switch, Sockets, Panels</strong>
                        </a>

                        <a href="Sitestore3.php" class="store-card" style="text-decoration: none; color: inherit;">
                            <h3>Store 3</h3>
                            <p>Location: Jalan Andenium 3</p>
                            <strong>Pipes, and fitting</strong>
                        </a>
                    </div><br><br>
            </div>
        </div>
        </div>
  <br>

    <div class="footer">
        <img src="img/footer1.png"><br>
        <a>ALL RIGHT RESERVED BY &copy; InvenGuard @ Strength Electrical (M) SDN BHD </a>
    </div>
</div>
</body>
</html> 
