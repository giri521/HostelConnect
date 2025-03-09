<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostelConnect Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="sidebar">
    <h2>HostelConnect</h2>
    <ul>
        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="#"><i class="fas fa-user"></i> Student Login</a></li>
        <li><a href="#"><i class="fas fa-user-shield"></i> Admin Login</a></li>
        <li><a href="#"><i class="fas fa-tools"></i> Maintenance Login</a></li>
        <li><a href="#"><i class="fas fa-info-circle"></i> About</a></li>
        <li><a href="#"><i class="fas fa-envelope"></i> Contact</a></li>
    </ul>
</div>

<div class="login-container">
    <h2>Welcome to HostelConnect</h2>
    <p>Select your role to log in</p>

    <div class="login-options">
        <button class="login-btn student" onclick="showLoginForm('student')">
            <i class="fas fa-user-graduate"></i> Student Login
        </button>
        <button class="login-btn admin" onclick="showLoginForm('admin')">
            <i class="fas fa-user-shield"></i> Admin Login
        </button>
        <button class="login-btn maintenance" onclick="showLoginForm('maintenance')">
            <i class="fas fa-tools"></i> Maintenance Login
        </button>
    </div>

    <div id="login-form-container">
        <form id="login-form" action="authenticate.php" method="POST">
            <h3 id="login-title">Login</h3>
            <input type="hidden" id="role" name="role" value="">
            <input type="email" name="email" placeholder="University Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

<script>
function showLoginForm(role) {
    document.getElementById("role").value = role;
    document.getElementById("login-title").innerText = role.charAt(0).toUpperCase() + role.slice(1) + " Login";
    document.getElementById("login-form-container").style.display = "block";
}
</script>

<style>
/* Global Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #121212;
    color: white;
    display: flex;
}

/* Sidebar */
.side
