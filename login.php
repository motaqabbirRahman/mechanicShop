<?php
require('connection.inc.php');
require('functions.inc.php');
$msg = '';
if(isset($_POST['submit'])){
//   echo  $username=get_safe_value($conn,$_POST['username']);
//   echo $password=get_safe_value($conn,$_POST['password']);
     $username = mysqli_real_escape_string($conn,$_POST['username']);
     $password = mysqli_real_escape_string($conn,$_POST['password']);
     
     $sql = "select * from users where username='$username' and password='$password'";
     $res = mysqli_query($conn,$sql);
     $count = mysqli_num_rows($res);
     if($count>0){
        $_SESSION['USER_LOGIN']='yes';
        $_SESSION['ADMIN_USERNAME']=$username;
        header('location:dashboard.php');
        die();
     }
     else{
       $msg = "Please enter valid login details";
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
    <title>Login</title>
</head>
<header>
</header>
<body>
    <body>
	<form action="login.php" method="post">
		<h2>Login</h2>
		<input type="text" id="username" name="username" required placeholder="username">
		<input type="password" id="password" name="password" required placeholder="password">
		<input type="submit" name="submit" value="Login" id="loginButton">  
		<p class="register">Not registered yet? <a class="link" href="signin.php">register</a> </p>
        <p class="register"><a class="link" href="appointment.html">admin login</a> </p>
        <div class="errorMsg"><?php echo $msg?></div>
	</form>
</body>
</html>