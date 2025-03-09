<?php
session_start();
include 'database.php';

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $college_mail = $_POST['college_mail'];
    $dob = $_POST['dob']; // DOB is used as password

    // Validate student login using prepared statements
    $query = "SELECT * FROM students WHERE college_mail = ? AND dob = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $college_mail, $dob);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if ($student) {
        $_SESSION["student"] = $student['id']; // Store student ID in session
        header("Location: student_dashboard.php");
        exit();
    } else {
        $login_error = "Invalid Email or Date of Birth!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - HostelConnect</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
            display: flex;
            height: 100vh;
            margin: 0;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #1e1e1e;
            padding: 20px;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 10px rgba(255, 204, 0, 0.3);
        }
        .sidebar h2 {
            color: #ffcc00;
            text-align: center;
            margin-bottom: 20px;
        }
        .nav-links a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            transition: 0.3s;
        }
        .nav-links a:hover {
            background: #ffcc00;
            color: black;
        }

        /* Main Content */
        .main-content {
            margin-left: 270px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: calc(100% - 270px);
        }

        .container {
            width: 350px;
            padding: 25px;
            background: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 204, 0, 0.3);
            text-align: center;
        }
        h2 {
            color: #ffcc00;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #333;
            color: white;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        button {
            background: #ffcc00;
            color: black;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            margin-top: 10px;
            font-size: 16px;
        }
        button:hover {
            background: #d4a000;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>🏠 Kalasalingam HostelConnect</h2>
    <div class="nav-links">
        <a href="main.php">Home</a>
        <a href="student_login.php">🎓 Student Login</a>
        <a href="admin_login.php">🛡️ Admin Login</a>
        <a href="maintenance_login.php">🛠️ Maintenance Login</a>
        <a href="#">📞 Contact</a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h2>🔐 Student Login</h2>
        <form method="POST">
            <input type="email" name="college_mail" placeholder="College Email" required>
            <input type="date" name="dob" required>
            <button type="submit">Login</button>
        </form>
        <p class="error"><?php echo $login_error; ?></p>
    </div>
</div>

</body>
</html>
