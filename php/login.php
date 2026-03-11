<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and Password are required']);
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set cookie for 30 days
            $cookie_name = "user_auth";
            // In a real app, generate a secure token and store it in DB.
            // For simplicity, we create a pseudo-token with the user's ID
            $cookie_value = base64_encode(json_encode(['id' => $user['id'], 'email' => $user['email']]));
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            
            echo json_encode(['status' => 'success', 'message' => 'Login successful', 'redirect' => 'home.html']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
        }
    } catch(PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>