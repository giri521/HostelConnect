<?php
session_start();
include 'database.php'; // Include database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);
        if (mysqli_stmt_execute($stmt)) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Error sending message. Please try again.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - HostelConnect</title>
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
        .contact-form {
            max-width: 500px;
            margin: auto;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
        }
        .contact-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffcc00;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            background: #333;
            color: white;
        }
        .contact-form textarea {
            height: 100px;
            resize: none;
        }
        .contact-form button {
            width: 100%;
            padding: 10px;
            background: #ffcc00;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .contact-form button:hover {
            background: #e6b800;
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
            
        <li><a href="main.php">🏠 Home</a></li>
            <li><a href="student_login.php">🎓 Student Login</a></li>

            <li><a href="admin_login.php">🛡️ Admin Login</a></li>

            <li><a href="maintenance_login.php">🛠️ Maintenance Login</a></li>

            <li><a href="contact.php">📞 Contact</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="contact-form">
            <h2>Contact Us</h2>
            
            <!-- Success or Error Messages -->
            <?php if (isset($success)) echo "<p class='message success'>$success</p>"; ?>
            <?php if (isset($error)) echo "<p class='message error'>$error</p>"; ?>

            <form method="POST" action="">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="subject" placeholder="Subject" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>

</body>
</html>
