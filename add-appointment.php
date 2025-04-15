


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointment</title>
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
                <li><a href="view-appointment.php">View Appointment</a></li>
                <li><a href="font-deskportal.html">Home </a></li>
            </ul>
        </div>

        <div class="content">
            <h2>Enter details to add new appointment</h2>
            <!-- PHP form action to handle appointment creation -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label>Appointment ID (auto generated):</label>
                <input type="text" name="appointmentid" disabled>

                <label>Patient Name:</label>
                <input type="text" name="patientname" placeholder="Enter Patient Name" required>

                <label>Allotted Time:</label>
                <input type="time" name="allottedtime" required>

                <label>Department:</label>
                <select name="department" required>
                    <option value="">--Select Department--</option>
                    <option value="cardiology">Cardiology</option>
                    <option value="neurology">Neurology</option>
                    <option value="orthopedics">Orthopedics</option>
					
                </select>

                <label>Date:</label>
                <input type="date" name="date" required>

                <label>Doctor Name:</label>
                <input type="text" name="doctorname" placeholder="Enter Doctor Name" required>

                <div class="button-group">
                    <button type="submit" name="submit">Submit</button>
                </div>
            </form>

            <!-- PHP code to handle the form submission -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Database connection
                $host = 'localhost'; // Your database host
                $user = 'root'; // Your database user
                $password = ''; // Your database password
                $dbname = 'hospital4'; // Your database name

                // Create a new MySQL connection
                $conn = new mysqli("localhost","root","","hospital4");

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve form input values
                $patientname = $_POST['patientname'];
                $allottedtime = $_POST['allottedtime'];
                $department = $_POST['department'];
                $date = $_POST['date'];
                $doctorname = $_POST['doctorname'];

                // Prepare the SQL query to insert the appointment
                $sql = "INSERT INTO appo (patientname, allottedtime, department, date, doctorname)
                        VALUES (?, ?, ?, ?, ?)";

                // Prepare and bind the SQL statement
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $patientname, $allottedtime, $department, $date, $doctorname);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<p>New appointment has been added successfully!</p>";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();
            }
            ?>
        </div>
    </div>
</body>
</html>

