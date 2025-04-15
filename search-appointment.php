<?php
// Database connection setup
$host = 'localhost'; // Database host
$user = 'root'; // Database username
$password = ''; // Database password
$dbname = 'hospital4'; // Database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$appointments = [];
$search_id = '';

// If a search is performed, capture the search ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_id'])) {
    $search_id = $_POST['search_id'];

    // Fetch the appointment with the specific ID if search is performed
    $stmt = $conn->prepare("SELECT * FROM appo WHERE appointmentid = ?");
    $stmt->bind_param("s", $search_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $appointments[] = $result->fetch_assoc(); // Only include the found appointment
    } else {
        $error = "No appointment found with ID: " . htmlspecialchars($search_id);
    }
    $stmt->close();
} else {
    // Fetch all appointments if no search is performed
    $sql = "SELECT * FROM appo";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>

    <style>
        /* Styling for the page layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #f15a24;
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .sidebar h2 {
            text-align: center;
            font-size: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 15px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            padding: 10px;
            display: block;
            border-radius: 5px;
            background-color: #f15a24;
        }
        .sidebar ul li a:hover {
            background-color: #555;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: white;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
            text-align: center;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .highlight {
            background-color: #ffeb3b !important;
        }
        
         /* Existing styles */

    /* Styling for the search bar */
    .search-bar {
        margin-bottom: 20px;
        text-align: center;
    }
    .search-bar label {
        font-weight: bold;
        margin-right: 10px;
    }
    .search-bar input[type="text"] {
        padding: 8px;
        width: 250px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }
    .search-bar button {
        padding: 8px 15px;
        background-color: #f15a24;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    .search-bar button:hover {
        background-color: #d1451b;
    }


    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
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

        <!-- Content: Appointment View Table -->
        <div class="content">
            <h2>All Appointments</h2>

            <!-- Search Bar -->
            <div class="search-bar">
                <form method="POST" action="">
                    <label for="search_id">Search by Appointment ID:</label>
                    <input type="text" id="search_id" name="search_id" placeholder="Enter Appointment ID" value="<?php echo htmlspecialchars($search_id); ?>">
                    <button type="submit">Search</button>
                </form>
            </div>

            <?php if (isset($error)): ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Patient Name</th>
                            <th>Allotted Time</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Doctor Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($appointments) > 0) {
                            foreach ($appointments as $appointment) {
                                $highlight_class = ($appointment['appointmentid'] == $search_id) ? 'highlight' : '';
                                echo "<tr class='{$highlight_class}'>
                                        <td>" . htmlspecialchars($appointment['appointmentid']) . "</td>
                                        <td>" . htmlspecialchars($appointment['patientname']) . "</td>
                                        <td>" . htmlspecialchars($appointment['allottedtime']) . "</td>
                                        <td>" . htmlspecialchars($appointment['department']) . "</td>
                                        <td>" . htmlspecialchars($appointment['date']) . "</td>
                                        <td>" . htmlspecialchars($appointment['doctorname']) . "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No appointments found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>