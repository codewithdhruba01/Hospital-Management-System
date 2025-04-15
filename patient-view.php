
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Manager</title>
    <link rel="stylesheet" href="patient.css">
    <style>
        body {
            margin: 0;
            
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 200px;
            background-color: #FF4500;
            padding-top: 20px;
            position: fixed;
            height: 100%;
            overflow: auto;
        }

        .sidebar .logo h2 {
            color: white;
            text-align: center;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
            
        }

        .sidebar ul li a {
            color: white;
            display: block;
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            background-color: ;
        }

        /* Main content and header styling */
        .main-content {
            margin-left: 200px; /* Space for sidebar */
            flex-grow: 1;
            padding: 20px;
            height: 100%;
        }

        .header {
            background-color: ;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            position: fixed;
            width: calc(100% - 200px); /* Full width minus sidebar */
            top: 0;
            left: 200px;
        }

        .search-bar {
            margin-top: 80px; /* Space for fixed header */
            margin-bottom: 20px;
            /* margin-left: 300px; */
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr.highlight {
            background-color: yellow;
        }


input[type="text"], input[type="number"], select {
    width: 200px;
    /* padding: 5px; */
    margin-bottom: 20px;
}



    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar
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
        </div> -->

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                View and Manage Patients
            </div>

            <!-- Search Form -->
            <div class="search-bar">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="searchID">ID Search:</label>
                    <input type="text" id="searchID" name="searchID" value="<?php echo isset($_POST['searchID']) ? $_POST['searchID'] : ''; ?>">
                    <button type="submit">Search</button>
                </form>
            </div>

            <!-- PHP to Fetch and Display Patients in Table -->
            <?php
            // Database connection
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $dbname = 'hospital';

            // Create connection
            $conn = new mysqli("localhost", "root", "", "hospital");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Search logic
            $searchID = '';
            $highlightID = '';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['searchID'])) {
                    $searchID = $_POST['searchID'];
                    $highlightID = $searchID; // Highlight the row
                }
            }

            // Fetch patients from the database
            $sql = "SELECT * FROM patient";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Patient ID</th><th>First Name</th><th>Last Name</th><th>Age</th><th>Gender</th><th>Address</th></tr>";

                // Loop through each patient record and display in table
                while ($row = $result->fetch_assoc()) {
                    // Highlight row if patient ID matches the search input
                    $highlightClass = ($row['patientID'] == $highlightID) ? 'highlight' : '';

                    echo "<tr class='$highlightClass'>";
                    echo "<td>" . $row["patientID"] . "</td>";
                    echo "<td>" . $row["firstName"] . "</td>";
                    echo "<td>" . $row["lastName"] . "</td>";
                    echo "<td>" . $row["age"] . "</td>";
                    echo "<td>" . $row["gender"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No patients found.</p>";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>