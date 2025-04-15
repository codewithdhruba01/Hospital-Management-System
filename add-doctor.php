<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="add-doctor.css">
</head>
<body>

<div class="container">
    <h2>Add New Doctor</h2>

    <?php
        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "hospital4");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Auto-generate Doctor ID
        $result = $conn->query("SELECT MAX(id) AS max_id FROM doctors");
        $row = $result->fetch_assoc();
        $doctor_id = $row['max_id'] + 1;

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $department = $_POST['department'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];

            // Insert data into the database
            $sql = "INSERT INTO doctors (id, name, age, gender, department, city, phone)
                    VALUES ('$doctor_id', '$name', '$age', '$gender', '$department', '$city', '$phone')";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>New doctor added successfully!</p>";
            } else {
                echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }

        $conn->close();
    ?>

    <form action="" method="POST">
        <label for="doctor_id">Doctor ID (Auto-generated):</label>
        <input type="text" id="doctor_id" name="doctor_id" value="<?php echo $doctor_id; ?>" readonly>

        <label for="name">Doctor Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="department">Department:</label>
        <select id="department" name="department" required>
            <option value="Cardiology">Cardiology</option>
            <option value="Neurology">Neurology</option>
            <option value="Pediatrics">Pediatrics</option>
            <option value="Orthopedics">Orthopedics</option>
            <option value="Radiology">Radiology</option>
            <!-- Add other departments as needed -->
        </select>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>

        <button type="submit">Add Doctor</button>
    </form>
</div>

</body>
</html>