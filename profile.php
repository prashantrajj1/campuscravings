<?php
session_start();
$user_id = null;
$user_email = "";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['email'];
} else {
    header("Location: login.php");
    exit;
}

require_once 'php/db_connect.php';

$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

$order_query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
$order_result = mysqli_query($conn, $order_query);
$orders = [];
if ($order_result) {
    while ($row = mysqli_fetch_assoc($order_result)) {
        $orders[] = $row;
    }
}

$complaint_query = "SELECT * FROM complaints WHERE user_id = '$user_id' ORDER BY created_at DESC";
$complaint_result = mysqli_query($conn, $complaint_query);
$complaints = [];
if ($complaint_result) {
    while ($row = mysqli_fetch_assoc($complaint_result)) {
        $complaints[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - CampusCravings</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>

<table width="100%" cellpadding="20" class="header-table">
    <tr>
        <td width="30%">
            <a href="home.php" style="color: #282c3f; text-decoration: none; font-weight: bold;"> &lt; Home</a>
        </td>
        <td width="40%" align="center">
            <div class="logo-text">Campus<span>Cravings</span></div>
        </td>
        <td width="30%" align="right">
            <a href="checkout.php" style="color: #282c3f; text-decoration: none; font-weight: bold;">Cart</a>
        </td>
    </tr>
</table>

<div class="profile-container">

    <table width="100%" style="border-bottom: 1px solid #e9ecee; padding-bottom: 20px; margin-bottom: 30px;">
        <tr>
            <td width="20%" class="profile-avatar-container" valign="top">
                <?php 
                $pfp = !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'default.jpeg';
                ?>
                <img src="assets/pfp/<?php echo $pfp; ?>" class="profile-avatar-img">
                <br>
                <form action="php/update_pfp.php" method="POST" enctype="multipart/form-data" style="margin-top: 5px;">
                    <input type="file" name="pfp" accept="image/*" required style="font-size: 11px; width: 120px;">
                    <br>
                    <button type="submit" name="action" value="upload" class="upload-btn">Upload</button>
                </form>
                <?php if ($pfp !== 'default.jpeg'): ?>
                <form action="php/update_pfp.php" method="POST" style="margin-top: 5px;">
                    <button type="submit" name="action" value="remove" class="remove-btn">Remove</button>
                </form>
                <?php endif; ?>
            </td>
            <td width="80%" valign="top" class="user-meta" style="padding-left: 20px;">
                <h1>Active Student</h1>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
                <p>Roll No: <?php echo htmlspecialchars($user['rollno']); ?> | Course: <?php echo htmlspecialchars($user['course']); ?></p>
            </td>
        </tr>
    </table>

    <div class="section-title">Order History</div>
    
    <?php if (empty($orders)): ?>
        <p style="text-align: center; color: #686b78; padding: 30px;">No orders yet. Your food journey starts here!</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td style="font-weight: bold;">#<?php echo $order['id']; ?></td>
                        <td><?php echo date('d M, Y', strtotime($order['order_date'])); ?></td>
                        <td style="font-weight: bold;">₹<?php echo number_format($order['total_amount'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="section-title">Support & Complaints</div>

    <div class="complaint-form">
        <form action="php/submit_complaint.php" method="POST">
            <div class="form-group">
                <label for="order_id">Related Order (Optional)</label>
                <select id="order_id" name="order_id" class="form-input">
                    <option value="">-- No specific order --</option>
                    <?php foreach ($orders as $o): ?>
                        <option value="<?php echo $o['id']; ?>">Order #<?php echo $o['id']; ?> (₹<?php echo $o['total_amount']; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required placeholder="e.g. Missing items in my order" class="form-input">
            </div>
            <div class="form-group">
                <label for="message">Detailed Message</label>
                <textarea id="message" name="message" rows="4" required placeholder="Tell us what happened..." class="form-input"></textarea>
            </div>
            <button type="submit" class="btn-submit">Submit Complaint</button>
        </form>
    </div>

    <?php if (!empty($complaints)): ?>
        <div class="section-title" style="margin-top: 30px;">Your Recent Complaints</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $comp): ?>
                    <tr>
                        <td style="font-weight: bold; color: #282c3f;"><?php echo htmlspecialchars($comp['subject']); ?></td>
                        <td><span class="status-badge"><?php echo $comp['status']; ?></span></td>
                        <td><?php echo date('d M', strtotime($comp['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <a href="logout.php" class="btn-logout">LOGOUT</a>

</div>

</body>
</html>
