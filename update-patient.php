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
            <h1>Enter details to show or update a patient</h1>

            <!-- PHP script to handle fetching and updating patient data -->
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
                } elseif (isset($_POST['update'])) {
                    // Update button is clicked
                    $patientID = $_POST["patientID"];
                    $firstName = $_POST["firstName"];
                    $lastName = $_POST["lastName"];
                    $age = $_POST["age"];
                    $gender = $_POST["gender"];
                    $address = $_POST["address"];
                    
                    // SQL query to update patient data
                    $sql = "UPDATE patient SET firstName='$firstName', lastName='$lastName', age='$age', gender='$gender', address='$address' WHERE patientID='$patientID'";

                    if ($conn->query($sql) === TRUE) {
                        $message = "<p>Patient details updated successfully.</p>";
                    } else {
                        $message = "<p>Error updating record: " . $conn->error . "</p>";
                    }
                }
            }

            // Close connection
            $conn->close();
            ?>

            <!-- Form to display and update patient details -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="patientID">Patient ID:</label>
                <input type="text" id="patientID" name="patientID" value="<?php echo $patientID; ?>"><br><br>

                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>"><br><br>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>"><br><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $age; ?>"><br><br>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
                </select><br><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>"><br><br>

                <!-- Button to show patient details -->
                <button type="submit" name="show">Show</button>

                <!-- Button to update patient details -->
                <button type="submit" name="update">Update</button>

                
            </form>

            <!-- Display message -->
            <?php echo $message; ?>
        </div>
    </div>
</body>
</html>