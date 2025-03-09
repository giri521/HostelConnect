<?php
session_start();
include 'database.php';
require('vendor/autoload.php');

// Razorpay API Keys
$keyId = 'YOUR_KEY_ID';
$keySecret = 'YOUR_KEY_SECRET';

// Get payment details
$payment_id = $_GET['payment_id'];
$order_id = $_GET['order_id'];

// Initialize Razorpay API
use Razorpay\Api\Api;
$api = new Api($keyId, $keySecret);

// Fetch payment details
$payment = $api->payment->fetch($payment_id);

if ($payment->status == "captured") {
    // Update payment status in database
    mysqli_query($conn, "UPDATE payments SET status='confirmed', payment_id='$payment_id' WHERE order_id='$order_id'");

    echo "<script>alert('Payment Successful! Room Booked.'); window.location.href='student_dashboard.php';</script>";
} else {
    echo "<script>alert('Payment Failed! Try Again.'); window.location.href='book_room.php';</script>";
}
?>
