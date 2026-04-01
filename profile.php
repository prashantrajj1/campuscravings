<?php
// profile page - shows user info, orders, complaints
// campuscravings - prashant & ayush
session_start();

// auth check
$userId = null;
$userEmail = "";
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
$userEmail = $_SESSION['email'];
}
else {
    header("Location: login.php");
    exit;
}

require_once 'php/db_connect.php';

// get user details
$userData = mysqli_query($conn, "SELECT * FROM users WHERE id = '$userId'");
$usr = mysqli_fetch_assoc($userData);

// get order history (newest first)
$orderData = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$userId' ORDER BY order_date DESC");
$orderList = [];
if ($orderData) {
while ($o = mysqli_fetch_assoc($orderData)) {
        $orderList[] = $o;
    }
}
// echo "orders: " . count($orderList); // was using this to test

// get complaints
$compData = mysqli_query($conn, "SELECT * FROM complaints WHERE user_id = '$userId' ORDER BY created_at DESC");
$compList = [];
if ($compData) {
    while ($c = mysqli_fetch_assoc($compData)) {
    $compList[] = $c;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - CampusCravings</title>
    <link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/profile.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>

<div class="wrapper">
        <header class="topbar">
            <a href="home.php" class="back-link">Home</a>
        <div class="sitename">Campus<span>Cravings</span></div>
            <a href="checkout.php" class="cart-link"></a>
        </header>

        <div class="profile-box">

        <!-- user info section with profile pic -->
        <div class="profile-top">
                <div class="avatar-wrapper">
                    <div class="avatar">
                        <?php
// get profile pic filename, fallback to default
$pfp = !empty($usr['profile_picture']) ? htmlspecialchars($usr['profile_picture']) : 'default.jpeg';
?>
                    <img src="assets/pfp/<?php echo $pfp; ?>" alt="Profile Picture" class="profile-img">
                    </div>
                    <!-- upload new pic form -->
                    <form action="php/update_pfp.php" method="POST" enctype="multipart/form-data"
                        class="upload-form">
                    <input type="file" name="pfp" accept="image/*" required class="file-input">
                        <button type="submit" name="action" value="upload" class="upload-btn">Upload Pic</button>
                    </form>
                    <?php if ($pfp !== 'default.jpeg'): ?>
                <!-- remove pic button - only shows if they have a custom pic -->
                <form action="php/update_pfp.php" method="POST">
                        <button type="submit" name="action" value="remove" class="remove-btn">Remove</button>
                    </form>
                    <?php endif; ?>
            </div>
                <div class="userinfo">
                    <h1><?php echo htmlspecialchars($usr['name'] ?? 'User'); ?></h1>
                    <p><?php echo htmlspecialchars($usr['email']); ?></p>
                <p class="student-info"><?php echo htmlspecialchars($usr['phone'] ?? ''); ?></p>
                </div>
            </div>

            <!-- order history table -->
            <div class="section-heading">Order History</div>

            <?php if (empty($orderList)): ?>
            <div class="empty-msg">
                <p>No orders yet. Your food journey starts here!</p>
        </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                    <th>Order ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
            <tbody>
                    <?php foreach ($orderList as $ord): ?>
                    <tr>
                        <td class="bold">#<?php echo $ord['id']; ?></td>
                        <td><?php echo date('d M, Y', strtotime($ord['order_date'])); ?></td>
                    <td class="bold">₹ <?php echo number_format($ord['total_amount'], 2); ?></td>
                </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

        <!-- complaint form -->
        <div class="section-heading">Support & Complaints</div>

            <div class="complaint-box">
                <form action="php/submit_complaint.php" method="POST">
                <!-- order dropdown - optional, they can pick which order the complaint is about -->
                <div class="form-row">
                        <label for="order_id">Related Order (Optional)</label>
                        <select id="order_id" name="order_id">
                            <option value="">-- No specific order --</option>
                    <?php foreach ($orderList as $o): ?>
                            <option value="<?php echo $o['id']; ?>">
                                Order #<?php echo $o['id']; ?> (₹<?php echo $o['total_amount']; ?>)
                        </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                    <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required
                            placeholder="e.g. Missing items in my order">
                    </div>
                <div class="form-row">
                        <label for="message">Detailed Message</label>
                        <textarea id="message" name="message" rows="4" required class="complaint-textarea"
                            placeholder="Tell us what happened..."></textarea>
                </div>
                    <button type="submit" class="submit-btn">Submit Complaint</button>
                </form>
            </div>

        <!-- previous complaints table -->
        <?php if (!empty($compList)): ?>
            <div class="section-heading">Your Recent Complaints</div>
            <table>
                <thead>
                    <tr>
                    <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
            <tbody>
                    <?php foreach ($compList as $comp): ?>
                    <tr>
                        <td class="complaint-subject"><?php echo htmlspecialchars($comp['subject']); ?></td>
                        <td>
                            <span class="status-badge status-default"><?php echo $comp['status']; ?></span>
                    </td>
                        <td><?php echo date('d M', strtotime($comp['created_at'])); ?></td>
                </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

        <!-- logout -->
        <div class="logout-area">
                <a href="logout.php" class="logout-btn">LOGOUT</a>
            </div>
        </div>

</div>

</body>

</html>