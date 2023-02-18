<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
	header("location: login.php");
	exit;
}

require('connection.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
  $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
  $license = mysqli_real_escape_string($conn, $_POST['license']);
  $engine = mysqli_real_escape_string($conn, $_POST['engine']);
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $mechanic = mysqli_real_escape_string($conn, $_POST['mechanic']);

  $sql = "UPDATE appointments SET name='$name', phone='$phone', color='$color', license_number='$license', engine_number='$engine', appointment_date='$date', mechanic_name='$mechanic' WHERE id='$id'";
  if (mysqli_query($conn, $sql)) {
    // header('Location: /mechanicshop/appointment.php?msg=success');

    /*new line*/

    if ($_SESSION['user_type'] == "admin") {
      // redirect to admin dashboard if user is an admin
      header('Location: /mechanicshop/admin_dashboard.php?msg=success');
      exit();
      } else {
          // redirect to user dashboard if user is a regular user
          header('Location: /mechanicshop/appointment.php?msg=success');
          exit();
      }

    /*new line */
    $query = "UPDATE mechanics SET appointments_booked = appointments_booked + 1 WHERE mechanic_name = '$mechanic'";
				mysqli_query($conn, $query);
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
} else {
  $id = mysqli_real_escape_string($conn, $_GET['id']);
  $sql = "SELECT * FROM appointments WHERE id='$id'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
  } else {
    echo "Error fetching record: " . mysqli_error($conn);
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Appointment</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <form action="/mechanicshop/edit_appointment.php" method="post">
    <h2>Edit Appointment</h2>
    
    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
    <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $row['name'] ?>" required>
    <input type="tel" id="phone" name="phone" placeholder="Phone" value="<?php echo $row['phone'] ?>" required>
    <input type="text" id="color" name="color" placeholder="Color" value="<?php echo $row['color'] ?>" required>
    <input type="text" id="license" name="license" placeholder="License Number" value="<?php echo $row['license_number'] ?>" required>
    <input type="text" id="engine" name="engine" placeholder="Engine Number" value="<?php echo $row['engine_number'] ?>" required>
    <input type="date" id="date" name="date" placeholder="Appointment Date" value="<?php echo $row['appointment_date'] ?>" required>
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
        <input type="submit" value="Update" id="updateButton">

        </form>
        </body>
        </html>
        <?php mysqli_close($conn); ?>



