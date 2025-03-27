<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="https://rsms.me/inter/inter-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/style.css" />
<head>
    <title> Login Page</title>

<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans);

    html { width: 100%; height:100%; overflow:hidden; }

    body {
    width: 100%;
    height: 100vh;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Open Sans', sans-serif;
    background: linear-gradient(135deg, #2F4146 10%, #5C7D85 100%);
}
  .main{
    width: 500px;
    height: 600px;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 5px 20px 50px #000;
  }

  #chk{
    display: none;
  }

    .signup
  {
    position: relative;
    width:100%;
    height: 100%;
  }

    label
  {
      color: #fff;
      font-size: 3.0em;
      justify-content: center;
      text-align: center;
      display: flex;
      margin: 70px;
      font-weight: bold;
      cursor: pointer;
  }

    .signup label
  {
      color: #fff;
      font-size: 1.8em;
      justify-content: center;
      text-align: center;
      display: flex;
      margin: 20px;
      font-weight: bold;
      cursor: pointer;
  }

    input
  {
      width: 60%;
      height: 20px;
      background: #e0dede;
      justify-content: center;
      display: flex;
      margin: 10px auto;
      padding: 10px;
      border: none;
      outline: none;
      border-radius: 5px;
  }

    button
  {
      width: 50%;
      height: 30px;
      margin: 10px auto;
      justify-content: center;
        display: block;
        color: #5E9C76;
        font-size: 1em;
        font-weight: bold;
        margin-top: 20px;
        outline: none;
        border: none;
        border-radius: 5px;
        transition: .2s ease-in;
        cursor: pointer;
  }

    button:hover
  {
      background: #79B38F;
  }

    .login
  {
      height: 460px;
      background: #eee;
      border-radius: 60% / 10%;
      transform: translateY(-180px);
      transition: .8s ease-in-out;
  }

    .login label
  {
      color: #4F8F68;
      transform: scale(.6);
  }

    #chk:checked ~ .login
  {
      transform: translateY(-500px);
  }

    p.round2
  {
      justify-content: center;
      text-align: center;
      font-size: 14px;
      font-family: verdana;
      line-height: 1.8;
      color:  white;
      border: 1px solid dimgray;
      border-radius: 16px;
      padding: 20px;
      margin: 20px;
  }

  i
  {
      font-size: 12px;
      justify-content: center;
      display: flex;
  }
  
  .create-account-link 
  {
    display: block; /* Makes the hyperlink a block-level element */
    text-align: center; /* Centers the text horizontally */
    color: #573b8a; /* Sets the color of the hyperlink */
    text-decoration: none; /* Removes underline from the hyperlink */
    transform: scale(.8);
  }

</style></head>
<body><br>


<div class="main"> 
    <input type="checkbox" id="chk" aria-hidden="true">

    <!-- Login Form-->

    <div class="signup">
        <form>
        <video autoplay loop muted playsinline>
        <source src="video/banner1.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
              <label>Inventory Tracking and Stock Management System <br> Strength Electrical (M) SDN BHD
              </label>
              <p class="round2">Welcome to InvenGuard. <br> Login using account that has been registered.</p>
        </form>
      </div>


      <div class="login">
        <form action="Access.php" method="POST">
          <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="username" id="Username" placeholder="Username" value=""required="true">
                <input type="Password" name="password" id="Password" placeholder="Password" value=""required="true">
                <i class="bi bi-eye-slash" id="togglePassword"> show password</i>
            <button type="submit" id="submit" class="submit" value ="login" name="submit">Login</button>
            <hr>
        </form>
      </div>

  </div>
    
    <!-- Script for visible password-->
    <script>
       
function register() {
  window.location.assign("register.php")
}
function admin() {
  window.location.assign("admin_login.php")
}


        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#Password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

    </script>


</body>
</html>