<?php
session_start();
include 'database.php'; // Include database connection

// Check if the user is an admin (Add authentication if needed)
// Example: if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit(); }

// Delete message functionality
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM contact_messages WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    if (mysqli_stmt_execute($stmt)) {
        $success = "Message deleted successfully!";
    } else {
        $error = "Error deleting message.";
    }
    mysqli_stmt_close($stmt);
}

// Fetch all contact messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - HostelConnect</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            background: #1e1e1e;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        th {
            background: #ffcc00;
            color: black;
        }
        tr:hover {
            background: #333;
        }
        .delete-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background: darkred;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .success {
            background: green;
            color: white;
        }
        .error {
            background: red;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>HostelConnect</h2>
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

    <!-- Main Content -->
    <div class="content">
        <h2>Contact Messages</h2>
        
        <!-- Success or Error Messages -->
        <?php if (isset($success)) echo "<p class='message success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='message error'>$error</p>"; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo htmlspecialchars($row['message']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="contact_messages.php?delete_id=<?php echo $row['id']; ?>">
                        <button class="delete-btn">Delete</button>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
