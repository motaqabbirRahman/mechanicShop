<?php
			// Connect to the database
			$conn = mysqli_connect('localhost', 'root', '', 'mechanic_shop');
	
			// Retrieve the list of mechanics
			$query = "SELECT mechanic_name FROM mechanics WHERE appointments_booked < appointments_monthly_limit";
			$result = mysqli_query($conn, $query);
	
			// Generate the options for the dropdown menu
			while ($row = mysqli_fetch_assoc($result)) {
			  echo "<option value=\"" . $row['mechanic_name'] . "\">" . $row['mechanic_name'] . "</option>";
			}
	
			// Close the database connection
			mysqli_close($conn);

?>