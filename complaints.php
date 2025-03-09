<?php
session_start();
include 'database.php';

if (!isset($_SESSION["student"])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION["student"];
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = mysqli_real_escape_string($conn, $_POST["category"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);

    $query = "INSERT INTO complaints (student_id, category, description, status, complaint_date) 
              VALUES ('$student_id', '$category', '$description', 'Pending', NOW())";

    if (mysqli_query($conn, $query)) {
        $message = "<p style='color: green; text-align: center;'>Complaint submitted successfully!</p>";
    } else {
        $message = "<p style='color: red; text-align: center;'>Error submitting complaint. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
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
            width: 50%;
            margin: auto;
        }
        select, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: none;
        }
        select {
            background: #333;
            color: white;
        }
        textarea {
            background: #333;
            color: white;
            resize: none;
        }
        button {
            background: #ffcc00;
            color: black;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #d4ac00;
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
        <h2>Submit Complaint</h2>
        <?= $message ?>
        <form method="POST">
            <label for="category">Complaint Category:</label>
            <select name="category" id="category" required>
                <option value="">-- Select Category --</option>
                <option value="Room Issues">Room Issues</option>
                <option value="Mess/Food Problems">Mess/Food Problems</option>
                <option value="Water Supply">Water Supply</option>
                <option value="Electricity">Electricity</option>
                <option value="Security">Security</option>
                <option value="Others">Others</option>
            </select>

            <label for="description">Describe the issue:</label>
            <textarea name="description" id="description" rows="4" required placeholder="Describe your complaint..."></textarea>

            <button type="submit">Submit Complaint</button>
        </form>
    </div>
</div>

</body>
</html>
