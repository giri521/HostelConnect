<?php
session_start();
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
    <title>Maintenance Dashboard - HostelConnect</title>
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
        <h1>Welcome, Maintenance Team!</h1>
        <p>This is your dashboard. Manage hostel maintenance requests here.</p>
    </div>

</body>
</html>
