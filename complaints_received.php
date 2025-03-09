<?php
session_start();
include 'database.php';

// Check if the admin is logged in
if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch complaints from the database
$query = "SELECT c.id, c.student_id, s.name, s.register_number, c.description, c.complaint_text, c.status 
          FROM complaints c 
          JOIN students s ON c.student_id = s.id 
          ORDER BY c.id DESC";

$result = mysqli_query($conn, $query);

// Handle status update securely using prepared statements
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complaint_id'], $_POST['status'])) {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];

    // Prevent SQL injection using prepared statements
    $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $complaint_id);

    if ($stmt->execute()) {
        echo "<script>alert('Complaint status updated successfully!'); window.location.reload();</script>";
    } else {
        echo "<script>alert('Error updating complaint status.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints Received - Admin Panel</title>
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
            box-shadow: 3px 0 10px rgba(255, 204, 0, 0.3);
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
            font-size: 16px;
        }

        .sidebar ul li a:hover {
            background: #ffcc00;
            color: black;
            border-radius: 5px;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        h3 {
            text-align: center;
            color: #ffcc00;
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
            padding: 6px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin: 2px;
        }

        .pending { background: orange; color: black; }
        .inprogress { background: blue; color: white; }
        .resolved { background: green; color: white; }
        .rejected { background: red; color: white; }

        /* Responsive Design */
        @media screen and (max-width: 800px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
            }

            table {
                font-size: 14px;
            }
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
        <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h3>Complaints Received</h3>

    <table>
        <tr>
            <th>Student Name</th>
            <th>Register Number</th>
            <th>Description</th>
            <th>Complaint</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['register_number']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['complaint_text']) ?></td>
                <td class="<?= strtolower(str_replace(' ', '', $row['status'])) ?>">
                    <?= htmlspecialchars($row['status']) ?>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="complaint_id" value="<?= $row['id'] ?>">
                        <button type="submit" name="status" value="Pending" class="btn pending">Pending</button>
                        <button type="submit" name="status" value="In Progress" class="btn inprogress">In Progress</button>
                        <button type="submit" name="status" value="Resolved" class="btn resolved">Resolved</button>
                        <button type="submit" name="status" value="Rejected" class="btn rejected">Rejected</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
