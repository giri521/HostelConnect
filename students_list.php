<?php
session_start();
include 'database.php'; // Database connection

// Redirect to login if not logged in
if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit();
}

// Handle adding a new student
if (isset($_POST['add_student'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $register_number = mysqli_real_escape_string($conn, $_POST['register_number']);
    $college_mail = mysqli_real_escape_string($conn, $_POST['college_mail']);
    $personal_mail = mysqli_real_escape_string($conn, $_POST['personal_mail']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $parent_mobile = mysqli_real_escape_string($conn, $_POST['parent_mobile']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);

    $sql = "INSERT INTO students (name, register_number, college_mail, personal_mail, mobile_number, parent_mobile, dob, address, department, year) 
            VALUES ('$name', '$register_number', '$college_mail', '$personal_mail', '$mobile_number', '$parent_mobile', '$dob', '$address', '$department', '$year')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Student Added Successfully!'); window.location.href='students_list.php';</script>";
    } else {
        echo "<script>alert('Error adding student: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle student removal
if (isset($_POST['remove_student'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $sql = "DELETE FROM students WHERE id='$student_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Student Removed Successfully!'); window.location.href='students_list.php';</script>";
    } else {
        echo "<script>alert('Error removing student: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch students
$students = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List - HostelConnect</title>
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
            height: 100vh;
            background: #1e1e1e;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
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
            border-bottom: 1px solid #333;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
        }
        .sidebar ul li a:hover {
            background: #ffcc00;
            color: black;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
            width: 80%;
        }

        .container {
            padding: 20px;
            background: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #444;
        }
        th {
            background: #ffcc00;
            color: black;
        }
        .remove-btn, .edit-btn {
            padding: 5px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .remove-btn {
            background: red;
            color: white;
        }
        .edit-btn {
            background: #007bff;
            color: white;
        }
        .add-btn {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }
        #add_student_form {
            display: none;
        }
    </style>
    <script>
        function toggleAddStudentForm() {
            var form = document.getElementById("add_student_form");
            form.style.display = (form.style.display === "none") ? "block" : "none";
        }
    </script>
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
    <h3>📋 Students List</h3>

    <button class="add-btn" onclick="toggleAddStudentForm()">➕ Add Student</button>

    <table>
        <tr>
            <th>Name</th>
            <th>Register Number</th>
            <th>College Mail</th>
            <th>Mobile Number</th>
            <th>Date of Birth</th>
            <th>Department</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($students)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['register_number']; ?></td>
                <td><?php echo $row['college_mail']; ?></td>
                <td><?php echo $row['mobile_number']; ?></td>
                <td><?php echo $row['dob']; ?></td>
                <td><?php echo $row['department']; ?></td>
                <td><?php echo $row['year']; ?></td>
                <td>
                    <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="edit-btn">✏️ Edit</a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="remove_student" class="remove-btn">❌ Remove</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Add Student Form -->
    <div class="container" id="add_student_form">
        <h2>➕ Add Student</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required><br>
            <input type="text" name="register_number" placeholder="Register Number" required><br>
            <input type="email" name="college_mail" placeholder="College Email" required><br>
            <input type="text" name="mobile_number" placeholder="Mobile Number" required><br>
            <input type="text" name="department" placeholder="Department" required><br>
            <input type="number" name="year" placeholder="Year" required><br>
            <button type="submit" name="add_student" class="add-btn">Add Student</button>
        </form>
    </div>
</div>

</body>
</html>
