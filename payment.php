<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'php/db_connect.php';

$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0;

    if (isset($_POST['confirm_payment'])) {
        // Process the final order insertion
        $user_id = $_SESSION['user_id'];

        $insert_order = "INSERT INTO orders (user_id, total_amount, status) VALUES ('$user_id', '$total_amount', 'Pending')";

        if (mysqli_query($conn, $insert_order)) {
            $success = true;
            $order_id = mysqli_insert_id($conn);
        }
        else {
            $message = "Failed to place order. Try again.";
        }
    }
}
else {
    // If not POST, redirect back to home
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - CampusCravings</title>
    <link rel="stylesheet" href="css/home.css">
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/payment.css">
</head>

<body>

    <div class="app-container">
        <header class="app-header">
            <div class="logo-desktop">Campus<span>Cravings</span></div>
        </header>

        <div class="payment-box">
            <?php if ($success): ?>



            <h1 class="success-title">Order Placed Successfully!</h1>
            <p class="success-message">Your Order ID is <strong>#
                    <?php echo $order_id; ?>
                </strong>.</p>
            <p>We are preparing your food. You can track your order in your profile.</p>
            <a href="profile.php" class="btn-primary mt-30-block">View Order History</a>

            <script>
                // Clear the cart since the order was successful
                localStorage.removeItem('cart');
            </script>
            <?php
else: ?>
            <h2 class="qr-title">Scan to Pay</h2>
            <div class="qr-placeholder">
                <img src="assets/images/qr.png" alt="QR Code">
            </div>
            <p>Scan the QR code with any UPI app</p>
            <div class="total-pay">₹
                <?php echo number_format($total_amount, 2); ?>
            </div>

            <?php if ($message): ?>
            <p class="error-message">
                <?php echo $message; ?>
            </p>
            <?php
    endif; ?>

            <form action="payment.php" method="POST">
                <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">
                <button type="submit" name="confirm_payment" class="btn-confirm">I have completed payment</button>
            </form>
            <?php
endif; ?>
        </div>
    </div>

</body>

</html>