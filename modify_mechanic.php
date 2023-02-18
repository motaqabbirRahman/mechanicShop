<?php
session_start();

if(!isset($_SESSION['adminLoggedin']) || $_SESSION['adminLoggedin']!=true){
	header("location: admin_login.php");
	exit;
}

// Validate and sanitize input
require('connection.inc.php');
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Validate and sanitize input
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$dailyLimit = filter_input(INPUT_POST, 'dailyLimit', FILTER_SANITIZE_NUMBER_INT);

// Insert data into the database
$sql = "INSERT INTO mechanics (mechanic_name, appointments_monthly_limit, appointments_booked)
VALUES ('$name', $dailyLimit, 0)";

if (mysqli_query($conn, $sql)) {
$showAlert = true;
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
} else {

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css" class="style">
    <title>Modify Mechanic</title>
</head>
<body>
    <div class="form-container">
			<form action="/mechanicshop/modify_mechanic.php" method="post">
				<h2>Add New Mechanic</h2>
				<input type="text" id="name" name="name" placeholder="Name" required>
                <input type="number" id="dailyLimit" name="dailyLimit" placeholder="Daily Limit" required>
				<input type="submit" value="Submit" id="submit">
				<?php
				if ($showAlert){
					echo 'Added uccessfully!';
				}
				?>
			</form>
    
</body>
</html>