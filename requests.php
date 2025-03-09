<?php
session_start();
include 'database.php'; // Include your database connection file

// Update status if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_id'], $_POST['status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    $update_sql = "UPDATE maintenance_requests SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $request_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: requests.php"); // Refresh the page
    exit();
}

// Fetch maintenance requests from the database
$sql = "SELECT * FROM maintenance_requests";
$result = mysqli_query($conn, $sql);

// Check if the user is logged in (if needed, you can implement the session check for maintenance login)
if (!isset($_SESSION["maintenance_id"])) {
    header("Location: maintenance_login.php"); // Redirect if not logged in
    exit();
}

// Logout Handling
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: maintenance_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Requests - HostelConnect</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-color: #121212;
            color: white;
        }
        .sidebar {
            width: 250px;
            background: #1e1e1e;
            padding-top: 20px;
            transition: 0.3s;
        }
        .sidebar h2 {
            text-align: center;
            color: #ffcc00;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }
        .sidebar ul li:hover {
            background: #ffcc00;
            color: black;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
        }
        .sidebar ul li:hover a {
            color: black;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #ffcc00;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background: #333;
        }
        td {
            background: #1e1e1e;
        }
        button {
            background-color: #ffcc00;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #ff9900;
        }
        .logout-btn {
            background: red;
            color: white;
            padding: 10px;
            border: none;
            text-align: center;
            width: 100%;
            cursor: pointer;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Maintenance Panel</h2>
        <ul>
            <li><a href="maintenance_dashboard.php">Dashboard</a></li> <!-- Reload dashboard -->
            <li><a href="requests.php">Requests</a></li> <!-- Go to requests.php -->
            <li><a href="?logout=true" class="logout-btn">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Maintenance Requests</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Room Number</th>
                <th>Service Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo isset($row['student_name']) ? $row['student_name'] : 'N/A'; ?></td>
                <td><?php echo isset($row['room_number']) ? $row['room_number'] : 'N/A'; ?></td>
                <td><?php echo isset($row['service_type']) ? $row['service_type'] : 'N/A'; ?></td>
                <td><?php echo isset($row['description']) ? $row['description'] : 'N/A'; ?></td>
                <td><?php echo isset($row['status']) ? $row['status'] : 'N/A'; ?></td>
                <td><?php echo isset($row['request_date']) ? $row['request_date'] : 'N/A'; ?></td>
                <td>
                    <?php if ($row['status'] != 'Completed') { ?>
                        <form method="POST" action="">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="In Progress" <?php if($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    <?php } else { ?>
                        No Action Available
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
