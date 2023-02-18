<div class="navbar">
  <div class="left-nav">
    <a href="#" class="active">Mechanics</a>
    <a href="#" >Car Parts</a>
  </div>

  <div class="right-nav">
      <!-- <a href="login.php">Login</a>
      <a href="adminlogin.php">Admin Login</a>
      <a href="signup.php">Sign Up</a> -->
    <?php
    // check if the user is logged in
    if(isset($_SESSION['username'])){
      // display the username and logout option
       echo '<div class="login" style="display: inline-block; margin-left: 700px;">Welcome: ' . $_SESSION['username'] . '</div>';
      echo '<div class="login">' .  '<a href="logout.php">Logout</a></div>';
     
    }
    else{
      // display the login, admin login, and sign up options
      echo '<div class="login">
              <a href="login.php">Login</a>
              <a href="admin_login.php">Admin Login</a>
              <a href="signup.php">Sign Up</a>
            </div>';
    }
    ?>

  </div>
</div>
