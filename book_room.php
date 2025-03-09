<?php
session_start();
include 'database.php';

if (!isset($_SESSION["student"])) {
    header("Location: student_login.php");
    exit();
}

// Fetch student details
$student_id = $_SESSION["student"];
$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

// Room categories and capacities
$categories = [
    "AC Attached" => ["strength" => 4, "room_numbers" => range(1, 30)],
    "Attached" => ["strength" => 5, "room_numbers" => array_merge(range(101, 130), range(201, 230))],
    "Non-Attached" => ["strength" => 6, "room_numbers" => range(301, 330)]
];

// Fetch booked room counts
$room_vacancies = [];
foreach ($categories as $category => $details) {
    foreach ($details["room_numbers"] as $room) {
        $query = "SELECT COUNT(*) as booked FROM room_bookings WHERE room_number = '$room'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $vacancies = $details["strength"] - $row['booked'];
        $room_vacancies[$room] = max(0, $vacancies);
    }
}

// Handle Room Booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_category = $_POST['room_category'];
    $room_number = $_POST['room_number'];

    // Check if the student already booked a room
    $check_booking = "SELECT * FROM room_bookings WHERE student_id = '$student_id'";
    $booking_result = mysqli_query($conn, $check_booking);

    if (mysqli_num_rows($booking_result) > 0) {
        echo "<script>alert('You have already booked a room! You can only book one room.');</script>";
    } else {
        if ($room_vacancies[$room_number] > 0) {
            $payment_status = "Pending"; 

            $sql = "INSERT INTO room_bookings (student_id, room_category, room_number, payment_status) 
                    VALUES ('$student_id', '$room_category', '$room_number', '$payment_status')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Room booked successfully! Proceed to payment.'); window.location.href='payment.php?room=$room_number';</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('This room is fully occupied! Please select another room.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hostel Room</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .card {
            background: #1e1e1e;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
            margin-bottom: 20px;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
        }
        button {
            background: #ffcc00;
            color: black;
            cursor: pointer;
        }
        .sidebar {
            position: fixed;
            width: 250px;
            height: 100%;
            background: #1e1e1e;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(255, 204, 0, 0.3);
            top: 0;
            left: 0;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #ffcc00;
            color: black;
        }
    </style>
    <script>
        function updateRoomNumbers() {
            var category = document.getElementById("room_category").value;
            var roomSelect = document.getElementById("room_number");
            roomSelect.innerHTML = ""; 

            var roomData = <?php echo json_encode($room_vacancies); ?>;
            var rooms = {
                "AC Attached": <?php echo json_encode(range(1, 30)); ?>,
                "Attached": <?php echo json_encode(array_merge(range(101, 130), range(201, 230))); ?>,
                "Non-Attached": <?php echo json_encode(range(301, 330)); ?>
            };

            if (rooms[category]) {
                rooms[category].forEach(room => {
                    if (roomData[room] > 0) {
                        var option = document.createElement("option");
                        option.value = room;
                        option.textContent = "Room " + room + " (Vacancies: " + roomData[room] + ")";
                        roomSelect.appendChild(option);
                    }
                });
            }
        }
    </script>
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

<div class="container">
    <h3>Book a Hostel Room</h3>

    <?php foreach ($categories as $category => $details): ?>
        <div class="card">
            <h3><?= $category ?></h3>
            <p>Capacity: <?= $details['strength'] ?> per room</p>
        </div>
    <?php endforeach; ?>

    <form method="POST">
        <label for="room_category">Select Room Category:</label>
        <select id="room_category" name="room_category" onchange="updateRoomNumbers()" required>
            <option value="" disabled selected>Select Category</option>
            <?php foreach ($categories as $category => $details): ?>
                <option value="<?= $category ?>"><?= $category ?></option>
            <?php endforeach; ?>
        </select>

        <label for="room_number">Select Room Number:</label>
        <select id="room_number" name="room_number" required>
            <option value="" disabled selected>Select a Room</option>
        </select>

        <button type="submit">Proceed to Payment</button>
    </form>
</div>

</body>
</html>
