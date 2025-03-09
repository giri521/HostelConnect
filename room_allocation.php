<?php
session_start();
include 'database.php';

// Check if the admin is logged in
if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch pending room booking requests along with payment screenshots
$query = "SELECT rb.id, rb.student_id, s.name, s.register_number, rb.room_number, rb.room_category, rb.payment_status, rb.payment_screenshot 
          FROM room_bookings rb 
          JOIN students s ON rb.student_id = s.id 
          WHERE rb.payment_status = 'Pending'";

$result = mysqli_query($conn, $query);

// Handle approval or rejection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update room booking status
    $update_query = "UPDATE room_bookings SET payment_status = '$status' WHERE id = '$booking_id'";
    if (mysqli_query($conn, $update_query)) {
        header("Refresh:0"); // Refresh the page to reflect changes
        exit();
    } else {
        echo "<script>alert('Error updating booking status.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Allocation - Admin Panel</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 20px;
        }
        .sidebar {
            width: 250px;
            position: fixed;
            height: 100%;
            background: #1e1e1e;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(255, 204, 0, 0.3);
        }
        .sidebar h2 {
            text-align: center;
            color: #ffcc00;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
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
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        h3 {
            text-align: center;
            color: #ffcc00;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #1e1e1e;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
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
        }
        .approve {
            background: green;
            color: white;
        }
        .reject {
            background: red;
            color: white;
        }
        img {
            width: 100px;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
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

<!-- Main Content -->
<div class="main-content">
    <h3>Room Allocation - Pending Requests</h3>

    <table>
        <tr>
            <th>Student Name</th>
            <th>Register Number</th>
            <th>Room Number</th>
            <th>Room Category</th>
            <th>Payment Screenshot</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['register_number']) ?></td>
                <td><?= htmlspecialchars($row['room_number']) ?></td>
                <td><?= htmlspecialchars($row['room_category']) ?></td>
                <td>
                    <?php if (!empty($row['payment_screenshot'])) { ?>
                        <a href="uploads/<?= htmlspecialchars($row['payment_screenshot']) ?>" target="_blank">
                            <img src="uploads/<?= htmlspecialchars($row['payment_screenshot']) ?>" alt="Payment Screenshot">
                        </a>
                    <?php } else { echo "No Image"; } ?>
                </td>
                <td><?= htmlspecialchars($row['payment_status']) ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="booking_id" value="<?= htmlspecialchars($row['id']) ?>">
                        <button type="submit" name="status" value="Approved" class="btn approve">Approve</button>
                        <button type="submit" name="status" value="Rejected" class="btn reject">Reject</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
