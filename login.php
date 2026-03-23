<?php
session_start();
require_once 'php/db_connect.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email and Password are required.";
    }
    else {
        $query = "SELECT id, email, password FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header("Location: home.php");
            exit;
        }
        else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CampusCravings</title>
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>
    <div class="logo">
        <i class="fa-solid fa-utensils"></i> Campus<span>Cravings</span>
    </div>

    <div class="login-box">
        <div class="form">
            <?php if (!empty($error)): ?>
            <h2 id="errlogs" style="color:red; font-size:14px;">
                <?php echo $error; ?>
            </h2>
            <?php
else: ?>
            <h2 id="errlogs"></h2>
            <?php
endif; ?>

            <form action="login.php" method="POST">
                <label for="email">Email: </label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password: </label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>

                <button type="submit" class="btn">Login</button><br><br>
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </form>
        </div>
    </div>
</body>

</html>