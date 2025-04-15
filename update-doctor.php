<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital4");

// Check for a successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctor = null; // Variable to store doctor info

// Fetch doctor information when Show button is clicked
if (isset($_POST['show'])) {
    $doctor_id = $_POST['doctor_id'];
    
    // Query to fetch doctor information based on ID
    $sql = "SELECT * FROM doctors WHERE id = '$doctor_id'";
    $stmt = $conn->prepare($sql);
    // $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if doctor found
    if ($result->num_rows > 0) {
        $doctor = $result->fetch_assoc();
    } else {
        echo "<p style='color: red; text-align: center;'>Doctor not found</p>";
    }
    $stmt->close();
}

// Update doctor information when Update button is clicked
if (isset($_POST['update'])) {
    $doctor_id = $_POST['doctor_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    
    // Update query
    $sql = "UPDATE doctors SET name=?, age=?, gender=?, department=?, city=?, phone=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssi", $name, $age, $gender, $department, $city, $phone, $doctor_id);
    
    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Doctor information updated successfully</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Failed to update doctor information</p>";
    }
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Doctor Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            color: #555;
        }

        input, select, button {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Doctor Information</h2>
    
    <!-- Form to enter doctor ID and show information -->
    <form method="post">
        <label for="doctor_id">Enter Doctor ID:</label>
        <input type="number" name="doctor_id" id="doctor_id" required>
        <button type="submit" name="show">Show</button>
    </form>

    <!-- Form to display and update doctor information if doctor is found -->
    <?php if ($doctor): ?>
        <form method="post">
            <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">

            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $doctor['name']; ?>" required>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" value="<?php echo $doctor['age']; ?>" required>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="Male" <?php if ($doctor['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($doctor['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($doctor['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <label for="department">Department:</label>
            <input type="text" name="department" id="department" value="<?php echo $doctor['department']; ?>" required>

            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php echo $doctor['city']; ?>" required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" value="<?php echo $doctor['phone']; ?>" required>

            <button type="submit" name="update">Update</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>