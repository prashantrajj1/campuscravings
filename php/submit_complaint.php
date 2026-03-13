<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Authentication check via cookie as per existing pattern
    if (!isset($_COOKIE['user_auth'])) {
        header("Location: ../login.html");
        exit;
    }

    $decoded = json_decode(base64_decode($_COOKIE['user_auth']), true);
    $user_id = $decoded['id'];

    $order_id = !empty($_POST['order_id']) ? (int)$_POST['order_id'] : null;
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    if (empty($subject) || empty($message)) {
        die("Subject and message are required.");
    }

    try {
        // Validate order_id if it's provided
        if ($order_id !== null) {
            $check_stmt = $conn->prepare("SELECT id FROM orders WHERE id = :oid AND user_id = :uid");
            $check_stmt->execute(['oid' => $order_id, 'uid' => $user_id]);
            if ($check_stmt->rowCount() == 0) {
                // If it doesn't exist or doesn't belong to the user, set it to null
                $order_id = null;
            }
        }

        $stmt = $conn->prepare("INSERT INTO complaints (user_id, order_id, subject, message) VALUES (:user_id, :order_id, :subject, :message)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        
        if ($stmt->execute()) {
            header("Location: ../profile.php?msg=Complaint submitted successfully!");
        } else {
            echo "Failed to submit complaint.";
        }
    } catch(PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../profile.php");
}
?>
