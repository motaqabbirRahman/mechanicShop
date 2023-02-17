<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
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
</head>
<body>
  <!-- Navigation bar -->
  <nav>
    <a href="">Dashboard</a>
    <a href="#appointment-details">Appointment Details</a>
    <a href="#mechanics-status">Mechanics Status</a>
  </nav>
  
  <!-- Main content -->
  <main>
    <div id="appointment-details">
      <h2 style="color:blue;">Appointment Details</h2>
      <table>
        <thead>
          <tr>
            <th>Client Name</th>
            <th>Phone</th>
            <th>Car Registration</th>
            <th>Appointment Date</th>
            <th>Mechanic Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Alice Johnson</td>
            <td>123-456-7890</td>
            <td>ABC123</td>
            <td>2023-02-16</td>
            <td>Bob Smith</td>
            <td><button>Edit</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <div id="mechanics-status">
      <h2 style="color:blue;">Mechanics Status</h2>
      <table>
        <thead>
          <tr>
            <th>Mechanic Name</th>
            <th>Daily Car Count</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Bob Smith</td>
            <td>8</td>
            <td><button>Edit</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
