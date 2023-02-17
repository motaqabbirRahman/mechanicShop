<?php
require('connection.inc.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Appointment Form</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
	<form action="submit.php" method="post">
		<h2>Appointment Form</h2>
		<input type="text" id="name" name="name" placeholder="Name"  rrequired>
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
			mysqli_close($conn);

        ?>
		</select>
		<input type="submit" value="Submit" id="submit">
	</form>
</body>
</html>