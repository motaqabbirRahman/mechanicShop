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

$sql = "UPDATE mechanics
SET appointments_monthly_limit = $dailyLimit
WHERE mechanic_name = '$name'";


if (mysqli_query($conn, $sql)) {
$showAlert = true;
header('Location: /mechanicshop/admin_dashboard.php?msg=updated');

exit();
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
			<form action="/mechanicshop/edit_mechanic.php" method="post">
				<h2>Modify Mechanic</h2>
				<input type="text" id="name" name="name" placeholder="Name" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" required>
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