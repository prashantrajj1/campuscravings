<?php
session_start();
require_once 'php/db_connect.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];

    // PHP side validation
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = "All fields are required";
    } else {
        $check_query = "SELECT id FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);
        
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $error = "Email already registered";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashed_password')";
            
            if (mysqli_query($conn, $insert_query)) {
                // Auto login after success
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['email'] = $email;
                header("Location: home.php");
                exit;
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CampusCravings</title>
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            const errLogs = document.getElementById('errlogs');
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirm-password');

            const validate = () => {
                const password = passwordInput.value;
                const confirmPassword = confirmInput.value;

                if (confirmPassword !== "" && password !== confirmPassword) {
                    errLogs.textContent = "Passwords do not match";
                    errLogs.style.color = "red";
                    errLogs.style.fontSize = "14px";
                    return false;
                } else {
                    errLogs.textContent = "";
                    return true;
                }
            };

            passwordInput.addEventListener('input', validate);
            confirmInput.addEventListener('input', validate);

            form.addEventListener('submit', (e) => {
                if (!validate()) {
                    e.preventDefault();
                }
            });
        });
    </script>
</head>
<body>
    <div class="logo">
        <i class="fa-solid fa-utensils"></i> Campus<span>Cravings</span>
    </div>

    <div class="login-box" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="form">
            <?php if (!empty($error)): ?>
                <h2 id="errlogs" style="color:red; font-size:14px;"><?php echo $error; ?></h2>
            <?php else: ?>
                <h2 id="errlogs"></h2>
            <?php endif; ?>
            
            <form action="register.php" method="POST">
                <label for="name">Full Name: </label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Email: </label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                
                <label for="phone">Phone Number: </label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                
                <label for="confirm-password">Confirm Password: </label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm password" required>

                <button type="submit" class="btn">Register</button><br><br>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
