<?php
session_start();
include 'database.php';

if (!isset($_SESSION["student"])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION["student"];
$message = "";

// Handle leave request submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_date = mysqli_real_escape_string($conn, $_POST['from_date']);
    $to_date = mysqli_real_escape_string($conn, $_POST['to_date']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    
    $insert_query = "INSERT INTO leave_requests (student_id, from_date, to_date, reason, status) 
                     VALUES ('$student_id', '$from_date', '$to_date', '$reason', 'Pending')";
    
    if (mysqli_query($conn, $insert_query)) {
        $message = "Leave request submitted successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch previous leave requests
$query = "SELECT from_date, to_date, reason, status, request_date FROM leave_requests WHERE student_id = '$student_id' ORDER BY request_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request</title>
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
        .container {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
            text-align: center;
            width: 70%;
            margin: auto;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #222;
            border: 1px solid #444;
            border-radius: 5px;
            color: white;
        }
        button {
            background: #ffcc00;
            color: black;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: bold;
        }
        button:hover {
            background: #e6b800;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: #222;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #444;
            text-align: left;
        }
        th {
            background: #333;
            color: #ffcc00;
        }
        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .pending { background: #ffcc00; color: black; }
        .approved { background: #28a745; color: white; }
        .rejected { background: #dc3545; color: white; }
        .message {
            margin-top: 10px;
            color: #28a745;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>HostelConnect</h2>
    <a href="student_dashboard.php">🏠 Dashboard</a>
    <a href="book_room.php">🛏 Book Room</a>
    <a href="maintenance_request.php">🔧 Maintenance Request</a>
    <a href="complaints.php">📢 File a Complaint</a>
    <a href="complaint_status.php">📌 Complaint Status</a>
    <a href="leave_request.php">📝 Leave Request</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<div class="content">
    <div class="container">
        <h2>Request Leave</h2>
        
        <form method="POST">
            <label>From Date:</label>
            <input type="date" name="from_date" required>
            
            <label>To Date:</label>
            <input type="date" name="to_date" required>
            
            <label>Reason:</label>
            <textarea name="reason" rows="3" required></textarea>
            
            <button type="submit">Submit Request</button>
        </form>

        <?php if ($message) { echo "<p class='message'>$message</p>"; } ?>

        <h2>Your Leave Requests</h2>
        <table>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Requested On</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= date('d M Y', strtotime($row['from_date'])) ?></td>
                    <td><?= date('d M Y', strtotime($row['to_date'])) ?></td>
                    <td><?= htmlspecialchars($row['reason']) ?></td>
                    <td>
                        <span class="status 
                            <?= $row['status'] == 'Pending' ? 'pending' : '' ?>
                            <?= $row['status'] == 'Approved' ? 'approved' : '' ?>
                            <?= $row['status'] == 'Rejected' ? 'rejected' : '' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td><?= date('d M Y, h:i A', strtotime($row['request_date'])) ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
