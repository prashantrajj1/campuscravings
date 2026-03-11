<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $course = htmlspecialchars($_POST['course'] ?? '');
    $rollno = htmlspecialchars($_POST['rollno'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate email
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@stu\.xim\.edu\.in$/', $email)) {
        echo json_encode(['status' => 'error', 'message' => 'Please use your @stu.xim.edu.in email']);
        exit;
    }

    if (empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Password is required']);
        exit;
    }

    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
            exit;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (email, course, rollno, password) VALUES (:email, :course, :rollno, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':rollno', $rollno);
        $stmt->bindParam(':password', $hashed_password);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
        }
    } catch(PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
