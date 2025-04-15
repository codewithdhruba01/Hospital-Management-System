<!-- <?php
if(isset($_GET['patientID'])){
    $a=$_GET['patientID'];
    $b=$_GET['firstName'];
    $c=$_GET['lastName'];
    $d=$_GET['age'];
    $e=$_GET['gender'];
    $f=$_GET['address'];
    $con=mysqli_connect("localhost","root","","hospital");
$sql="insert into patient (patientID,firstName,lastName,age,gender,address) values('$a','$b','$c','$d','$e','$f')";



$q=mysqli_query($con,$sql);
if($q==1){
    echo "Operation was successful!";
	// header("Location: add-patient.html");
}
else{
	// header("successfull");
    echo "Operation was not-successful!";

}
 }
?> -->
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
            <h1>Enter details to add a new patient</h1>

            <!-- PHP script to handle adding new patient -->
            <?php
            $host = 'localhost'; // Database host
            $user = 'root'; // Database user
            $password = ''; // Database password
            $dbname = 'hospital'; // Database name

            // Create connection
            $conn = new mysqli("localhost","root","","hospital");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Initialize variables for form inputs
            $patientID = $firstName = $lastName = $age = $gender = $address = '';
            $message = '';

            // Handle form submission for adding new patient
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['submit'])) {
                    // Get the form values
                    $patientID = $_POST["patientID"];
                    $firstName = $_POST["firstName"];
                    $lastName = $_POST["lastName"];
                    $age = $_POST["age"];
                    $gender = $_POST["gender"];
                    $address = $_POST["address"];

                    // Insert query to add new patient to the database
                    $sql = "INSERT INTO patient (patientID, firstName, lastName, age, gender, address) 
                            VALUES ('$patientID', '$firstName', '$lastName', '$age', '$gender', '$address')";

                    if ($conn->query($sql) === TRUE) {
                        $message = "<p>New patient added successfully!</p>";
                        // Clear form fields after successful insertion
                        $patientID = $firstName = $lastName = $age = $gender = $address = '';
                    } else {
                        $message = "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                    }
                }
            }

            // Close connection
            $conn->close();
            ?>

            <!-- Form to add a new patient -->
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

                <!-- Button to add new patient -->
                <button type="submit" name="submit">Submit</button>
                <button type="reset">Clear</button>
            </form>

            <!-- Display message -->
            <?php echo $message; ?>
        </div>
    </div>
</body>
</html>





