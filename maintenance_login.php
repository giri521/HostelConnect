<?php
session_start();
include 'database.php'; // Database connection file

// Check if the maintenance staff is already logged in
if (isset($_SESSION["maintenance_id"])) {
    header("Location: maintenance_dashboard.php"); // Redirect to dashboard
    exit();
}

// Handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query = "SELECT * FROM maintenance_team WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION["maintenance_id"] = $row["id"];
            $_SESSION["maintenance_name"] = $row["name"];
            $_SESSION["maintenance_email"] = $row["email"];
            header("Location: maintenance_dashboard.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No account found with this email!";
    }
}

// Handle Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $unique_number = mysqli_real_escape_string($conn, $_POST["unique_number"]);

    if ($unique_number === "KLU000") {
        // Check if email already exists
        $check_query = "SELECT * FROM maintenance_team WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $register_error = "Email already registered!";
        } else {
            // Insert new maintenance staff
            $query = "INSERT INTO maintenance_team (name, email, password) VALUES ('$name', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                $register_success = "Account created! You can now log in.";
            } else {
                $register_error = "Registration failed!";
            }
        }
    } else {
        $register_error = "Invalid Unique Number!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Login - HostelConnect</title>
    <style>
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
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
            text-align: center;
            width: 350px;
        }
        h2 {
            color: #ffcc00;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
            outline: none;
        }
        .btn {
            background-color: #ffcc00;
            color: black;
            font-weight: bold;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: none;
        }
        .btn:hover {
            background-color: #e6b800;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .success {
            color: limegreen;
            margin-top: 10px;
        }
        .toggle-btn {
            margin-top: 15px;
            background: none;
            border: none;
            color: #ffcc00;
            cursor: pointer;
        }
    </style>
</head>
<body>


<div class="container">
    <h2 id="form-title">Maintenance Login</h2>

    <!-- Login Form -->
    <form method="post" id="login-form">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit" class="btn" name="login">Login</button>
    </form>

    <!-- Registration Form -->
    <form method="post" id="register-form" style="display: none;">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <input type="text" name="unique_number" placeholder="Enter Unique Number" required>
        <button type="submit" class="btn" name="register">Create Account</button>
    </form>

    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <?php if (isset($register_error)) { echo "<p class='error'>$register_error</p>"; } ?>
    <?php if (isset($register_success)) { echo "<p class='success'>$register_success</p>"; } ?>

    <button class="toggle-btn" id="toggle-btn">Create an Account</button>
</div>

<script>
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const toggleBtn = document.getElementById("toggle-btn");
    const formTitle = document.getElementById("form-title");

    toggleBtn.addEventListener("click", () => {
        if (loginForm.style.display === "none") {
            loginForm.style.display = "block";
            registerForm.style.display = "none";
            formTitle.innerText = "Maintenance Login";
            toggleBtn.innerText = "Create an Account";
        } else {
            loginForm.style.display = "none";
            registerForm.style.display = "block";
            formTitle.innerText = "Create Maintenance Account";
            toggleBtn.innerText = "Back to Login";
        }
    });
</script>

</body>
</html>
