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

$message = '';
$error = '';

// If the "Delete" button is clicked, delete the appointment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $appointmentid = $_POST['appointmentid'];
    
    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM appo WHERE appointmentid = '$appointmentid'");
    // $stmt->bind_param("s", $appointmentid);
    
    if ($stmt->execute()) {
        $message = "Appointment with ID: " . htmlspecialchars($appointmentid) . " has been deleted.";
    } else {
        $error = "Failed to delete the appointment.";
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Appointment</title>
    <link rel="stylesheet" href="appointment.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Appointment Manager</h2>
            <ul>
                <li><a href="add-appointment.php">Add Appointment</a></li>
                <li><a href="deiete-appointment1.php">Delete Appointment</a></li>
                <li><a href="search-appointment.php">Search Appointment</a></li>
                <li><a href="view-appointment.php">View Appointments</a></li>
                <li><a href="home.php">Home</a></li>
            </ul>
        </div>

        <div class="content">
            <h2>Delete Appointment</h2>
            <form method="POST" action="">
                <label for="appointment_id">Appointment ID:</label>
                <input type="text" name="appointmentid" id="appointmentid" required>
                <button type="submit" name="delete">Delete</button>
            </form>

            <?php if ($error): ?>
                <div style="color: red;"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($message): ?>
                <div style="color: green;"><?php echo $message; ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>