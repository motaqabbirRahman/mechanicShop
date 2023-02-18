<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require('connection.inc.php');
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    // $exists=false;

    // Check whether this username exists
    $existSql = "SELECT * FROM `users` WHERE username = '$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows > 0){
        // $exists = true;
        $showError = "Username Already Exists";
    }
    else{
        // $exists = false; 
        if(($password == $cpassword)){
            // $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` ( `username`, `password`) VALUES ('$username', '$password')";
            $result = mysqli_query($conn, $sql);
            if ($result){
                $showAlert = true;
            }
        }
        else{
            $showError = "Passwords do not match";
        }
    }
}
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500;600;700&display=swap" rel="stylesheet">
    <title>Sign Up</title>
</head>
<header>
</header>
<body>
    <body>
	<form action="/mechanicshop/signup.php" method="post">
		<h2>Sign Up</h2>
    <label for="username">Username</label>
		<input type="text" id="username" name="username" required placeholder="username">
    <label for="password">Password</label>
		<input type="password" id="password" name="password" required placeholder="password">
    <label for="cpassword">Confirm Password</label>
    <input type="password" id="cpassword" name="cpassword" required placeholder="confirm password">
    <?php 
      if ($showAlert){
        echo'<strong>Account Created Successfully!</strong>';
      }
      if ($showError){
        echo $showError;
      }
    ?>
  <input type="submit" value="Sign Up" id="signupButton">
  </form>
</body>
</html>