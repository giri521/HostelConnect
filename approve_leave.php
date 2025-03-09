<?php
session_start();
include 'database.php';

// Check if admin is logged in
if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch pending leave requests
$query = "SELECT lr.id, lr.student_id, s.name, s.register_number, lr.from_date, lr.to_date, lr.reason, lr.status 
          FROM leave_requests lr
          JOIN students s ON lr.student_id = s.id 
          WHERE lr.status = 'Pending'";

$result = mysqli_query($conn, $query);

// Handle leave approval/rejection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['leave_id'], $_POST['status'])) {
    $leave_id = mysqli_real_escape_string($conn, $_POST['leave_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update leave request status
    $update_query = "UPDATE leave_requests SET status = '$status' WHERE id = '$leave_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Leave request updated successfully!'); window.location.href='approve_leave.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating leave request.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Leave Requests - Admin Panel</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding-left: 270px; /* Space for sidebar */
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1e1e1e;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(255, 204, 0, 0.3);
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
            border-radius: 5px;
        }

        h3 {
            text-align: center;
            color: #ffcc00;
            margin-top: 20px;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            background: #1e1e1e;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
            margin: auto;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #444;
        }
        th {
            background: #ffcc00;
            color: black;
        }
        td {
            color: white;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .approve {
            background: green;
            color: white;
        }
        .approve:hover {
            background: darkgreen;
        }
        .reject {
            background: red;
            color: white;
        }
        .reject:hover {
            background: darkred;
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
        <li><a href="complaints.php">⚠️ Complaints Received</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
</div>

<h3>Approve Leave Requests</h3>

<table>
    <tr>
        <th>Student Name</th>
        <th>Register Number</th>
        <th>From Date</th>
        <th>To Date</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['register_number']) ?></td>
            <td><?= htmlspecialchars($row['from_date']) ?></td>
            <td><?= htmlspecialchars($row['to_date']) ?></td>
            <td><?= htmlspecialchars($row['reason']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="leave_id" value="<?= htmlspecialchars($row['id']) ?>">
                    <button type="submit" name="status" value="Approved" class="btn approve">Approve</button>
                    <button type="submit" name="status" value="Rejected" class="btn reject">Reject</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
