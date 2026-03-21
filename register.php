<?php
session_start();
require_once 'php/db_connect.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $rollno = mysqli_real_escape_string($conn, $_POST['rollno']);
    $password = $_POST['password'];

    // PHP side validation
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@stu\.xim\.edu\.in$/', $email)) {
        $error = "Please use your @stu.xim.edu.in email";
    } elseif (empty($password)) {
        $error = "Password is required";
    } else {
        $check_query = "SELECT id FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Email already registered";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (email, course, rollno, password) VALUES ('$email', '$course', '$rollno', '$hashed_password')";
            
            if (mysqli_query($conn, $insert_query)) {
                // Auto login after success
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['email'] = $email;
                header("Location: home.php");
                exit;
            } else {
                $error = "Registration failed";
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const emailRegex = /^[a-zA-Z0-9._%+-]+@stu\.xim\.edu\.in$/;
            const form = document.querySelector('form');
            const errLogs = document.getElementById('errlogs');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirm-password');

            const validate = () => {
                const email = emailInput.value;
                const password = passwordInput.value;
                const confirmPassword = confirmInput.value;

                if (email !== "" && !emailRegex.test(email)) {
                    errLogs.textContent = "Please use your @stu.xim.edu.in email";
                    errLogs.style.color = "red";
                    errLogs.style.fontSize = "14px";
                    return false;
                } else if (confirmPassword !== "" && password !== confirmPassword) {
                    errLogs.textContent = "Passwords do not match";
                    errLogs.style.color = "red";
                    errLogs.style.fontSize = "14px";
                    return false;
                } else {
                    errLogs.textContent = "";
                    return true;
                }
            };

            emailInput.addEventListener('input', validate);
            passwordInput.addEventListener('input', validate);
            confirmInput.addEventListener('input', validate);

            form.addEventListener('submit', (e) => {
                if (!validate() || !emailRegex.test(emailInput.value)) {
                    e.preventDefault();
                    if (!emailRegex.test(emailInput.value)) {
                        errLogs.textContent = "Please use your @stu.xim.edu.in email";
                        errLogs.style.color = "red";
                    }
                }
            });
        });
    </script>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>
<body>
    <div class="logo">
        <i class="fa-solid fa-utensils"></i> Campus<span>Cravings</span>
    </div>

    <div class="login-box">
        <div class="form">
            <?php if (!empty($error)): ?>
                <h2 id="errlogs" style="color:red; font-size:14px;"><?php echo $error; ?></h2>
            <?php else: ?>
                <h2 id="errlogs"></h2>
            <?php endif; ?>
            
            <form action="register.php" method="POST">
                <label for="email">Email: </label>
                <input type="email" id="email" name="email" placeholder="your college mail" required>
                
                <label for="course"> Course </label>
                <input type="text" id="course" name="course" placeholder="course" required>
                
                <label for="rollno">University Roll No.</label>
                <input type="text" id="rollno" name="rollno" placeholder="rollno" required>
                
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" placeholder="password" required>
                
                <label for="confirm-password">Confirm Password: </label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="password" required>

                <button type="submit" class="btn">Register</button><br><br>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
