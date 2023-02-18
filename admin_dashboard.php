<?php
session_start();

if(!isset($_SESSION['adminLoggedin']) || $_SESSION['adminLoggedin']!=true){
	header("location: admin_login.php");
	exit;
}
require('connection.inc.php');

if (isset($_POST['mechanicId'])) {
  $mechanicId = mysqli_real_escape_string($conn, $_POST['mechanicId']);

  // Delete the mechanic record from the database
  $sql = "DELETE FROM mechanics WHERE mechanic_name = '$mechanicId'";
  mysqli_query($conn, $sql);
  // Redirect to the current page with a success message
  header('Location: ' . $_SERVER['PHP_SELF'] . '?msg=deleted');
exit();

  }



?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    /* Navigation bar styles */
    nav {
      background-color: #333;
      color: white;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      width: 200px;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 20px;
    }
    
    nav a {
      color: white;
      text-decoration: none;
      padding: 10px;
    }
    
    /* Main content styles */
    main {
      margin-left: 200px;
      padding: 20px;
    
    }
    
  </style>
  <script>
function deleteMechanic(mechanicId) {
        if (confirm('Are you sure you want to delete this mechanic?')) {
          fetch('admin_dashboard.php', {
            method: 'POST',
            body: new URLSearchParams({
              mechanicId: mechanicId
            })
          })
          .then(function(response) {
            if (response.ok) {
              location.reload();
            } else {
              console.log('Error deleting mechanic');
            }
          })
          .catch(function(error) {
            console.log(error);
          });
        }
      }

  </script>
</head>
<body>
  <!-- Navigation bar -->
  <nav>
    <?php
        if(isset($_SESSION['username'])){
      // display the username and logout option
       echo '<div style="margin-bottom:10px;"> Welcome: ' . $_SESSION['username'] . '</div>'; echo '<div>' .  '<a style="padding: 5px;  background-color:#d62828;"  href="admin_logout.php">Logout</a></div>';
    }
    ?>
    <a href="#appointment-details">Appointment Details</a>
    <a href="#mechanics-status">Mechanics Status</a>
  </nav>
  
  <!-- Main content -->
  <main>
    <div id="appointment-details">
      <h2 style="color:white;">Appointment Details</h2>
      <?php 
      if (isset($_GET['msg']) && $_GET['msg'] === 'success') {
  echo '<p class="success">Appointment successfully updated!</p>';
        }
      ?>
      <table>
        <thead>
          <tr>
            <th>Client Name</th>
            <th>Phone</th>
            <th>Color</th>
            <th>License No.</th>
            <th>Engine No.</th>
            <th>Appointment Date</th>
            <th>Mechanic Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <ul>
			    <?Php 
          require('connection.inc.php');
					$sql = "SELECT * FROM appointments";
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
      </table>
    </div>
    
    <div id="mechanics-status">
      <h2 style="color:white;">Mechanics Status  <a href="add_mechanic.php">Add Mehcanic</a></h2>
            <?php 
              if (isset($_GET['msg']) && $_GET['msg'] === 'updated') {
          echo '<p class="success">Successfully updated!</p>';
                }
      ?>
      <div>
           
      </div>
      <table>
        <thead>
          <tr>
            <th>Mechanic Name</th>
            <th>Daily Car Count</th>
            <th>Appointments Booked</th>
            <th>Action</th>
          </tr>
        </thead>
        <?Php 
          require('connection.inc.php');
					$sql = "SELECT * FROM mechanics";
					$result = mysqli_query($conn, $sql);
                    
					if ($result) {
						while ($row = mysqli_fetch_assoc($result)) {
							
				          echo '<tr>';
							echo '<td>' . $row['mechanic_name'] . '</td>';
							echo '<td>' . $row['appointments_monthly_limit'] . '</td>';
							echo '<td>' . $row['appointments_booked'] . '</td>';
							echo '<td><a href="edit_mechanic.php?id=' . $row['mechanic_name'] . '">Update</a>
                  <button class="delete-btn" onclick="deleteMechanic(\'' . $row['mechanic_name'] . '\')">Delete</button>
                   </td>';
                
                 
						 echo '</tr>';
						}
					} else {
						echo "Error: " . mysqli_error($conn);
					}
					mysqli_close($conn);

				
				?>
      </table>
    </div>
  </main>
</body>
</html>
