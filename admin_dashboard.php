<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit();
}

$admin_username = $_SESSION["admin"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - HostelConnect</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1e1e1e;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
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
            border-bottom: 1px solid #333;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
        }
        .sidebar ul li a:hover {
            background: #ffcc00;
            color: black;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #1e1e1e;
            padding: 10px 20px;
            border-radius: 10px;
        }
        .header h1 {
            color: #ffcc00;
        }
        .logout {
            background: red;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
        }
        .logout:hover {
            background: darkred;
        }
        .dashboard-section {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="admin_dashboard.php">🏠 Dashboard</a></li>
        <li><a href="room_allocation.php">🛏️ Room Allocation</a></li>
        <li><a href="approve_leave.php">📜 Approve Leave Requests</a></li>
        <li><a href="students_list.php">📋 Students List</a></li>
        <li><a href="complaints_received.php">⚠️ Complaints Received</a></li>
       <li><a href="contact_messages.php">📞 Contact Messages</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
</div>

<div class="content">
    <div class="header">
        <h1>Welcome, <?php echo $admin_username; ?> 👋</h1>
        <form method="POST" action="logout.php">
            <button class="logout" type="submit">Logout</button>
        </form>
    </div>

    <div class="dashboard-section">
        <h2>📊 Admin Dashboard</h2>
        <p>Manage hostel rooms, approve requests, and oversee student allocations.</p>
    </div>
</div>

</body>
</html>
