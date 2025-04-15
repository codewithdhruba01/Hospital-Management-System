<?php
$con = mysqli_connect("localhost", "root", "", "hospital");

$patientID = '';
if (isset($_GET['search'])) {
    $patientID = $_GET['patientID']; // Get the ID from the form
}

if ($patientID) {
    // If an ID is provided, fetch the record for that ID
    $sql = "SELECT * FROM patient WHERE patientID = '$patientID'";
} else {
    // Otherwise, fetch all records
    $sql = "SELECT * FROM patient";
}

$q = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    
    <style>
        /* Your existing CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: #333;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }

        a:hover {
            color: #45a049;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
            width: 300px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>




















    

    

    <table border="1">
        <tr>
            <th>patientID</th>
            <th>firstName</th>
            <th>lastName</th>
            <th>age</th>
            <th>gender</th>
            <th>address</th>
            

        </tr>

        <?php
        while ($r = mysqli_fetch_array($q)) {
        ?>
        <tr>
            <td><?php echo $r['patientID']; ?></td>
            <td><?php echo $r['firstName']; ?></td>
            <td><?php echo $r['lastName']; ?></td>
            <td><?php echo $r['age']; ?></td>
            <td><?php echo $r['gender']; ?></td>
            <td><?php echo $r['address']; ?></td>
            
            
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
