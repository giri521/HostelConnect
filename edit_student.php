<?php
session_start();
include 'database.php';

if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch student data
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id = '$student_id'");
    $student = mysqli_fetch_assoc($result);
}

// Handle student update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $register_number = $_POST['register_number'];
    $college_mail = $_POST['college_mail'];
    $personal_mail = $_POST['personal_mail'];
    $mobile_number = $_POST['mobile_number'];
    $parent_mobile = $_POST['parent_mobile'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $dob = $_POST['dob']; // New Date of Birth field

    $update_sql = "UPDATE students SET 
        name='$name', 
        register_number='$register_number', 
        college_mail='$college_mail', 
        personal_mail='$personal_mail', 
        mobile_number='$mobile_number', 
        parent_mobile='$parent_mobile', 
        address='$address', 
        department='$department', 
        year='$year',
        dob='$dob'
        WHERE id = '$student_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Student details updated!'); window.location.href='students_list.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        button {
            background: #ffcc00;
            color: black;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Student</h2>
    <form method="POST">
        <input type="text" name="name" value="<?= $student['name'] ?>" required>
        <input type="text" name="register_number" value="<?= $student['register_number'] ?>" required>
        <input type="email" name="college_mail" value="<?= $student['college_mail'] ?>" required>
        <input type="email" name="personal_mail" value="<?= $student['personal_mail'] ?>" required>
        <input type="text" name="mobile_number" value="<?= $student['mobile_number'] ?>" required>
        <input type="text" name="parent_mobile" value="<?= $student['parent_mobile'] ?>" required>
        <input type="text" name="address" value="<?= $student['address'] ?>" required>
        <input type="text" name="department" value="<?= $student['department'] ?>" required>
        <input type="text" name="year" value="<?= $student['year'] ?>" required>
        <input type="date" name="dob" value="<?= $student['dob'] ?>" required> <!-- New DOB input field -->
        <button type="submit">Save Changes</button>
    </form>
</div>

</body>
</html>
