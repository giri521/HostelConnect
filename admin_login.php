<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hostelconnect");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$admin_code = "KLU360"; // Unique registration code
$register_error = "";
$login_error = "";

// Handle Admin Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = trim($_POST["reg_username"]);
    $password = password_hash(trim($_POST["reg_password"]), PASSWORD_DEFAULT);
    $code = trim($_POST["admin_code"]);

    if ($code === $admin_code) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $register_error = "Username already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            echo "<script>alert('Admin Registered Successfully!'); window.location='admin_login.php';</script>";
        }
    } else {
        $register_error = "Invalid Admin Code!";
    }
}

// Handle Admin Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["admin"] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $login_error = "Incorrect password!";
        }
    } else {
        $login_error = "Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - HostelConnect</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 204, 0, 0.3);
            width: 350px;
            text-align: center;
        }

        h2 {
            color: #ffcc00;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #333;
            color: white;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #ffcc00;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background: #d4a000;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .register-container {
            display: none;
            margin-top: 20px;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100%;
            background: #1e1e1e;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(255, 204, 0, 0.2);
        }

        .sidebar h2 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .nav-links {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .sidebar a {
            text-decoration: none;
            color: #ffcc00;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255, 204, 0, 0.2);
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
        <a href="contact.php">📞 Contact</a>
    </div>
</div>

<!-- Main Login Container -->
<div class="container">
    <h2>🔐 Admin Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p class="error"><?php echo $login_error; ?></p>

    <button onclick="showRegister()">Create New Account</button>

    <div class="register-container" id="registerForm">
        <h2>🛡️ Register Admin</h2>
        <form method="POST">
            <input type="text" name="reg_username" placeholder="New Admin Username" required>
            <input type="password" name="reg_password" placeholder="New Password" required>
            <input type="text" name="admin_code" placeholder="Enter Unique Code" required>
            <button type="submit" name="register">Register</button>
        </form>
        <p class="error"><?php echo $register_error; ?></p>
    </div>
</div>

<script>
    function showRegister() {
        document.getElementById("registerForm").style.display = "block";
    }
</script>

</body>
</html>
