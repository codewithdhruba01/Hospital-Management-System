<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Delete Appointment</title>
    <link rel="stylesheet" href="appointment.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Appointment Manager</h2>
            <ul>
                <li><a href="add-appointment.php">Add</a></li>
                <li><a href="deiete-appointment1.php">Delete</a></li>
                <li><a href="search-appointment.php">Search</a></li>
                <li><a href="view-appointment.php">View</a></li>
                <li><a href="#">Home</a></li>
            </ul>
        </div>

        <div class="content">
            <h2>Enter Appointment ID to Show or Delete Appointment</h2>

            <?php
            // Database connection
            $host = 'localhost'; // Your database host
            $user = 'root'; // Your database username
            $password = ''; // Your database password
            $dbname = 'hospital4'; // Your database name

            // Create connection
            $conn = new mysqli("localhost","root","","hospital4");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Initialize variables for appointment details
            $appointmentid = 'appointmentid';
            $patientname = 'patientname';
            $allottedtime = 'allottedtime';
            $department = 'department';
            $date = 'date ';
            $doctorname = 'doctorname';

            // If the show button is clicked
            if (isset($_POST['showappointment'])) {
                $appointmentid = $_POST['appointmentid'];

                // SQL query to fetch the appointment details
                $sql = "SELECT * FROM appo WHERE appointmentid = '$appointmentid'";
                $stmt = $conn->prepare($sql);
                // $stmt->bind_param("i", $appointmentid);
                $stmt->execute();
                $result = $stmt->get_result();

                // If the appointment exists, fetch the data
                if ($result->num_rows > 0) {
                    $appointment = $result->fetch_assoc();
                    $patientname = $appointment['patientname'];
                    $allottedtime = $appointment['allottedtime'];
                    $department = $appointment['department'];
                    $date = $appointment['date'];
                    $doctorname = $appointment['doctorname'];
                } else {
                    echo "<p>No appointment found with ID: $appointmentid</p>";
                }
            }

            // If the delete button is clicked
            if (isset($_POST['deleteappointment'])) {
                $appointment_id = $_POST['appointmentid'];

                // SQL query to delete the appointment
                $sql = "DELETE FROM appo WHERE appointmentid = '$appointmentid' ";
                $stmt = $conn->prepare($sql);
                // $stmt->bind_param("i", $appointmentid);

                if ($stmt->execute()) {
                    echo "<p> has been deleted successfully.</p>";
                    // Clear the form data after deletion
                    $appointmentid = '';
                    $patientname = '';
                    $allottedtime = '';
                    $department = '';
                    $date = '';
                    $doctorname = '';
                } else {
                    echo "<p>Failed to delete appointment with ID $appointmentid.</p>";
                }
            }

            // Close the database connection
            $conn->close();
            ?>

            <!-- Form for showing and deleting appointment -->
            <form method="POST" actiozn="">
                <label>Appointment ID:</label>
                <input type="number" name="appointmentid" placeholder="Enter Appointment ID" value="<?php echo $appointmentid; ?>" required>

                <label>Patient Name:</label>
                <input type="text" name="patientname" value="<?php echo $patientname; ?>" disabled>

                <label>Allotted Time:</label>
                <input type="time" name="allottedtime" value="<?php echo $allottedtime; ?>" disabled>

                <label>Department:</label>
                <input type="text" name="department" value="<?php echo $department; ?>" disabled>

                <label>Date:</label>
                <input type="date" name="date" value="<?php echo $date; ?>" disabled>

                <label>Doctor Name:</label>
                <input type="text" name="doctorname" value="<?php echo $doctorname; ?>" disabled>

                <div class="button-group">
                    <button type="submit" name="showappointment">Show Appointment</button>
                    <button type="submit" name="deleteappointment">Delete Appointment</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
