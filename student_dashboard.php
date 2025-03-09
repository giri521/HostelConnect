<?php
session_start();
include 'database.php';

if (!isset($_SESSION["student"])) {
    header("Location: student_login.php");
    exit();
}

// Fetch student details
$student_id = $_SESSION["student"];
$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

// Fetch room booking status
$booking_query = "SELECT * FROM room_bookings WHERE student_id = '$student_id' AND payment_status = 'Approved'";
$booking_result = mysqli_query($conn, $booking_query);
$approved_booking = mysqli_fetch_assoc($booking_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
            background: #1e1e1e;
            height: 100vh;
            padding: 20px;
            position: fixed;
            box-shadow: 2px 0 10px rgba(255, 204, 0, 0.3);
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffcc00;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 10px 0;
            background: #333;
            border-radius: 5px;
            text-align: center;
        }
        .sidebar a:hover {
            background: #ffcc00;
            color: black;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
            width: 100%;
        }
        .welcome, .notification {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
            text-align: center;
            margin-bottom: 20px;
        }
        .approved {
            background: rgba(0, 255, 0, 0.2);
            border-left: 5px solid green;
            padding: 15px;
            color: lightgreen;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>HostelConnect</h2>
    <a href="book_room.php">🏠 Book Hostel Room</a>
    <a href="maintenance_request.php">🔧 Maintenance Request</a>
    <a href="complaints.php">📢 File a Complaint</a>
    <a href="complaint_status.php">📌 Complaint Status</a>
    <a href="leave_request.php">📝 Leave Request</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<div class="content">
    <div class="welcome">
        <h2>Welcome, <?= $student['name'] ?> 👋</h2>
        <p>Register Number: <?= $student['register_number'] ?></p>
        <p>Department: <?= $student['department'] ?></p>
        <p>Year: <?= $student['year'] ?></p>
    </div>

    <?php if ($approved_booking): ?>
        <div class="notification approved">
            ✅ Your room booking (Room No: <?= $approved_booking['room_number'] ?>, <?= $approved_booking['room_category'] ?>) has been approved!
        </div>
    <?php endif; ?>
</div>

</body>
</html>
