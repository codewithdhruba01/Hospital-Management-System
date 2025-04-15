<?php
// Database connection setup
$host = 'localhost'; // Database host
$user = 'root'; // Database username
$password = ''; // Database password
$dbname = 'hospital4'; // Database name

// Create connection
$conn = new mysqli("localhost","root","","hospital4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$appointments = [];

// Fetch all appointments from the database
$sql = "SELECT * FROM appo";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    
    <style>
        /* Styling for the page layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #f15a24;
            color: white;
            padding: 15px;
            height: 100vh;
            
        }
        .sidebar h2 {
            text-align: center;
            color: white;
            font-size: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 15px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            background-color: #f15a24;
            padding: 10px;
            display: block;
            border-radius: 5px;
        }
        .sidebar ul li a:hover {
            background-color: #555;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: white;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Appointment Manager</h2>
            <ul>
                <li><a href="add-appointment.php">Add Appointment</a></li>
                <li><a href="delete-appointment.php">Delete Appointment</a></li>
                <li><a href="search-appointment.php">Search Appointment</a></li>
                <li><a href="view-appointment.php">View Appointments</a></li>
                <li><a href="fontpage.html">Home</a></li>
            </ul>
        </div>

        <!-- Content: Appointment View Table -->
        <div class="content">
            <h2>All Appointments</h2>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Allotted Time</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Doctor Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($appointments) > 0) {
                            foreach ($appointments as $appointment) {
                                echo "<tr>
                                        <td>{$appointment['appointmentid']}</td>
                                        <td>{$appointment['patientname']}</td>
                                        <td>{$appointment['allottedtime']}</td>
                                        <td>{$appointment['department']}</td>
                                        <td>{$appointment['date']}</td>
                                        <td>{$appointment['doctorname']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No appointments found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>