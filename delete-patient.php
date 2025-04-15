
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Manager</title>
    <link rel="stylesheet" href="patient.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <h2>Patient Manager</h2>
            </div>
            <ul class="menu">
                <li><a href="add-patient.php">Add Patient</a></li>
                <li><a href="delete-patient.php">Delete Patient</a></li>
                <li><a href="update-patient.php">Update Patient</a></li>
                <li><a href="view-patient.php">View Patients</a></li>
                <li><a href="admin-portal.html">Home</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>Enter details to show or delete a patient</h1>

            <!-- PHP script to handle fetching and deleting patient data -->
            <?php
            $host = 'localhost'; // Database host
            $user = 'root'; // Database user
            $password = ''; // Database password
            $dbname = 'hospital'; // Database name

            // Create connection
            $conn = new mysqli("localhost", "root", "", "hospital");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Initialize empty variables for form inputs
            $patientID = $firstName = $lastName = $age = $gender = $address = '';
            $message = '';

            // Handle form submissions
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['show'])) {
                    // Show button is clicked
                    $patientID = $_POST["patientID"];
                    
                    // SQL query to fetch patient data
                    $sql = "SELECT * FROM patient WHERE patientID = '$patientID'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Fetch the patient's data
                        $row = $result->fetch_assoc();
                        $firstName = $row['firstName'];
                        $lastName = $row['lastName'];
                        $age = $row['age'];
                        $gender = $row['gender'];
                        $address = $row['address'];
                        $message = "<p>Patient details retrieved successfully.</p>";
                    } else {
                        $message = "<p>Patient not found.</p>";
                    }
                } elseif (isset($_POST['delete'])) {
                    // Delete button is clicked
                    $patientID = $_POST["patientID"];
                    
                    // SQL query to delete patient data
                    $sql = "DELETE FROM patient WHERE patientID = '$patientID'";

                    if ($conn->query($sql) === TRUE) {
                        $message = "<p>Patient with ID $patientID has been deleted successfully.</p>";
                        // Clear form fields after deletion
                        $firstName = $lastName = $age = $gender = $address = '';
                    } else {
                        $message = "<p>Error deleting record: " . $conn->error . "</p>";
                    }
                }
            }

            // Close connection
            $conn->close();
            ?>

            <!-- Form to display and delete patient details -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="patientID">Patient ID:</label>
                <input type="text" id="patientID" name="patientID" value="<?php echo $patientID; ?>"><br><br>

                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" readonly><br><br>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" readonly><br><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $age; ?>" readonly><br><br>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" disabled>
                    <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
                </select><br><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>" readonly><br><br>

                <!-- Button to show patient details -->
                <button type="submit" name="show">Show</button>

                <!-- Button to delete patient details -->
                <button type="submit" name="delete">Delete</button>

                
            </form>

            <!-- Display message -->
            <?php echo $message; ?>
        </div>
    </div>
</body>
</html>