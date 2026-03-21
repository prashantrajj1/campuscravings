<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Authentication check via session
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $order_id = !empty($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    
    // Procedural sanitizer
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    if (empty($subject) || empty($message)) {
        die("Subject and message are required.");
    }

    // Validate order_id if it's provided
    if ($order_id !== 0) {
        $check_query = "SELECT id FROM orders WHERE id = $order_id AND user_id = $user_id";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) == 0) {
            // If it doesn't exist or doesn't belong to the user, set it to 0 or null logic
            $order_id = 0;
        }
    }

    // Insert complaint
    $order_val = ($order_id !== 0) ? $order_id : 'NULL';
    $insert_query = "INSERT INTO complaints (user_id, order_id, subject, message) VALUES ($user_id, $order_val, '$subject', '$message')";
    
    if (mysqli_query($conn, $insert_query)) {
        header("Location: ../profile.php?msg=" . urlencode("Complaint submitted successfully!"));
        exit;
    } else {
        echo "Failed to submit complaint. " . mysqli_error($conn);
    }
} else {
    header("Location: ../profile.php");
    exit;
}
?>
