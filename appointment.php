<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
	header("location: login.php");
	exit;
}

// Validate and sanitize input
require('connection.inc.php');
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


  // Validate and sanitize input
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
  $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
  $license = mysqli_real_escape_string($conn, $_POST['license']);
  $engine = mysqli_real_escape_string($conn, $_POST['engine']);
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $mechanic = mysqli_real_escape_string($conn, $_POST['mechanic']);

  // Insert data into the database
  $sql = "INSERT INTO appointments (name, phone, color, license_number, engine_number, appointment_date, mechanic_name)
          VALUES ('$name', '$phone', '$color', '$license', '$engine', '$date', '$mechanic')";
	 if (mysqli_query($conn, $sql)) {
				$showAlert = true;
				// Get the name of the selected mechanic

				$query = "UPDATE mechanics SET appointments_booked = appointments_booked + 1 WHERE mechanic_name = '$mechanic'";
				mysqli_query($conn, $query);
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
} else {

}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Appointment Form</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500;600;700&display=swap" rel="stylesheet">
	<style>
		form {
    border: 2px solid black;
    width: 300px;
    padding: 20px;
    margin-left: 300px;
    margin-top: 170px;
    text-align: center;
    /* box-shadow: 0px 10px 30px 1px rgba(0, 0, 255, .2) ; */
    box-shadow: inset 1em 0em var(--background);
    border: none;
    border-radius: 15px;
    background-color: #003049; 
       }
	</style>
</head>
<body>
	<header>
       <?php include 'navbar.php'; ?>
    </header>
	<div class="container">
			 <div class="form-continer" styoe>
					<form action="/mechanicshop/appointment.php" method="post">
						<h2>Book Appointment</h2>
						<input type="text" id="name" name="name" placeholder="Name"  value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>"required>
						<input type="tel" id="phone" name="phone"  placeholder="Phone" required>
						<input type="text" id="color" name="color"  placeholder="Color" required>
						<input type="text" id="license" name="license" placeholder="License Number" required>
						<input type="text" id="engine" name="engine"  placeholder="Engine Number" required>
						<input type="date" id="date" name="date"  placeholder="Appointment Date" requied>
						<select id="mechanic" name="mechanic">	
						<?php
							$query = "SELECT mechanic_name FROM mechanics WHERE appointments_booked < appointments_monthly_limit";
							$result = mysqli_query($conn, $query);
							// Generate the options for the dropdown menu
							while ($row = mysqli_fetch_assoc($result)) {
							echo "<option value='{$row['mechanic_name']}'>{$row['mechanic_name']}</option>";
							}
						?>
						</select>
						<input type="submit" value="Submit" id="submit">
						<?php
						if ($showAlert){
							echo 'Appointment booked successfully!';
						}
						?>
					</form>
			 </div>
          <div class="appointments-container">
				<h2>My Appointments</h2>
				<?php
					if (isset($_GET['msg']) && $_GET['msg'] === 'success') {
					echo '<p class="success">Appointment successfully updated!</p>';
					}
				?>				
				<table>
				<tr>
					<th>Name</th>
					<th>Phone</th>
					<th>Color</th>
					<th>License Number</th>
					<th>Engine Number</th>
					<th>Appointment Date</th>
					<th>Mechanic Name</th>
					<th></th>
				</tr>
					<ul>
						<?Php 
							$sql = "SELECT * FROM appointments WHERE name = '{$_SESSION['username']}'";
							$result = mysqli_query($conn, $sql);
							
							if ($result) {
								while ($row = mysqli_fetch_assoc($result)) {
									
								echo '<tr>';
									echo '<td>' . $row['name'] . '</td>';
									echo '<td>' . $row['phone'] . '</td>';
									echo '<td>' . $row['color'] . '</td>';
									echo '<td>' . $row['license_number'] . '</td>';
									echo '<td>' . $row['engine_number'] . '</td>';
									echo '<td>' . $row['appointment_date'] . '</td>';
									echo '<td>' . $row['mechanic_name'] . '</td>';
									echo '<td><a href="edit_appointment.php?id=' . $row['id'] . '">Edit</a></td>';
								echo '</tr>';
								}
							} else {
								echo "Error: " . mysqli_error($conn);
							}
							mysqli_close($conn);
						?>
					</ul>
			</div> 
     </div>
</body>
</html>