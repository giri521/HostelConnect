<?php
session_start();
include 'database.php';

if (!isset($_SESSION["student"])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION["student"];
$room_number = isset($_GET['room']) ? $_GET['room'] : '';

if (!$room_number) {
    echo "<script>alert('Invalid room booking.'); window.location.href='book_room.php';</script>";
    exit();
}

// Fetch room details
$query = "SELECT room_category FROM room_bookings WHERE student_id = '$student_id' AND room_number = '$room_number'";
$result = mysqli_query($conn, $query);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    echo "<script>alert('Room booking not found.'); window.location.href='book_room.php';</script>";
    exit();
}

$room_category = $booking["room_category"];

// Define payment amount based on room category
$amounts = [
    "AC Attached" => 15000,
    "Attached" => 12000,
    "Non-Attached" => 10000
];

$payment_amount = $amounts[$room_category];

// UPI Details
$upi_id = "kalasalingamuniversity@upi";
$qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?data=upi://pay?pa=$upi_id&pn=Hostel&mc=0000&tid=000000&tr=$payment_amount&tn=Hostel%20Room%20Booking&am=$payment_amount&cu=INR";

// Handle payment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST["payment_method"];

    // Read the uploaded image as a blob
    $image = $_FILES['payment_screenshot']['tmp_name'];
    $image_data = addslashes(file_get_contents($image)); // Convert image to binary data

    $sql = "UPDATE room_bookings SET 
                payment_status='Pending', 
                payment_screenshot='$image_data' 
            WHERE student_id='$student_id' AND room_number='$room_number'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Payment uploaded successfully! Awaiting approval.'); window.location.href='student_dashboard.php';</script>";
    } else {
        echo "Database error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
        }
        select, button, input {
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
        .qr-box, .upi-box {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        img {
            width: 200px;
        }
    </style>
    <script>
        function showPaymentMethod() {
            var method = document.getElementById("payment_method").value;
            document.getElementById("qr-box").style.display = method === "QR Code" ? "block" : "none";
            document.getElementById("upi-box").style.display = method === "UPI ID" ? "block" : "none";
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Pay for Room Booking</h2>
    <p><strong>Room Category:</strong> <?= $room_category ?></p>
    <p><strong>Amount to Pay:</strong> ₹<?= $payment_amount ?></p>

    <form method="POST" enctype="multipart/form-data">
        <label>Select Payment Method:</label>
        <select id="payment_method" name="payment_method" onchange="showPaymentMethod()" required>
            <option value="" disabled selected>Select Payment Method</option>
            <option value="QR Code">QR Code</option>
            <option value="UPI ID">UPI ID</option>
        </select>

        <!-- QR Code Payment -->
        <div id="qr-box" class="qr-box">
            <p>Scan this QR Code to pay:</p>
            <img src="<?= $qr_code_url ?>" alt="QR Code">
        </div>

        <!-- UPI Payment -->
        <div id="upi-box" class="upi-box">
            <p>Pay using UPI ID:</p>
            <input type="text" value="<?= $upi_id ?>" readonly>
        </div>

        <label>Upload Payment Screenshot:</label>
        <input type="file" name="payment_screenshot" accept="image/*" required>

        <button type="submit">Submit Payment</button>
    </form>
</div>

</body>
</html>
