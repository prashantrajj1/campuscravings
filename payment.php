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
        $user_id = $_SESSION['user_id'];
        
        $insert_order = "INSERT INTO orders (user_id, total_amount, status) VALUES ('$user_id', '$total_amount', 'Pending')";
        
        if (mysqli_query($conn, $insert_order)) {
            $success = true;
            $order_id = mysqli_insert_id($conn);
        } else {
            $message = "Failed to place order. Try again.";
        }
    }
} else {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment - CampusCravings</title>
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>

    <table width="100%" cellpadding="20" class="header-table">
        <tr>
            <td align="center">
                <div class="logo-text">Campus<span>Cravings</span></div>
            </td>
        </tr>
    </table>

    <div class="payment-box">
        <?php if ($success): ?>
            <h1 style="color: #60b246;">Order Placed Successfully!</h1>
            <p style="color: #686b78; margin: 20px 0;">Your Order ID is <strong>#<?php echo $order_id; ?></strong>.</p>
            <p>We are preparing your food. You can track your order in your profile.</p>
            <a href="profile.php" class="btn-primary">View Order History</a>
            
            <script>
                localStorage.removeItem('cart');
            </script>
        <?php else: ?>
            <h2>Scan to Pay</h2>
            <div class="qr-placeholder">
                <br><br><br><br>
                <span>[ UPI QR CODE ]</span>
            </div>
            <p>Scan the QR code with any UPI app</p>
            <div class="total-pay">₹<?php echo number_format($total_amount, 2); ?></div>
            
            <?php if($message): ?>
                <p style="color: red;"><?php echo $message; ?></p>
            <?php endif; ?>

            <form action="payment.php" method="POST">
                <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">
                <button type="submit" name="confirm_payment" class="btn-confirm">I have completed payment</button>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>
