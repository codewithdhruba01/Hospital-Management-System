<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital4");

// Check for a successful connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all doctors from the database
$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Doctors Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e2e2e2;
        }

        .no-records {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>All Doctors Information</h2>

    <table>
        <tr>
            <th>Doctor ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Department</th>
            <th>City</th>
            <th>Phone Number</th>
        </tr>

        <?php
        // Check if there are results and display each doctor
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['city']}</td>
                        <td>{$row['phone']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='no-records'>No records found</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>

    </table>
</div>
</body>
</html>