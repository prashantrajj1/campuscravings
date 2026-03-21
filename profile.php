<?php
session_start();
// Authentication check
$user_id = null;
$user_email = "";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['email'];
}
else {
    header("Location: login.php");
    exit;
}

require_once 'php/db_connect.php';

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch orders
$order_query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
$order_result = mysqli_query($conn, $order_query);
$orders = [];
if ($order_result) {
    while ($row = mysqli_fetch_assoc($order_result)) {
        $orders[] = $row;
    }
}

// Fetch complaints
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - CampusCravings</title>
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/profile.css">
</head>

<body style="background: #ffffff; font-family: 'Outfit', sans-serif;">

    <div class="app-container">
        <header class="app-header">
            <a href="home.php" class="back-link"> Home</a>
            <div class="logo-desktop">Campus<span>Cravings</span></div>
            <a href="checkout.php" class="cart-link"></a>
        </header>

        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        <?php
$pfp = !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'default.jpeg';
?>
                        <img src="assets/pfp/<?php echo $pfp; ?>" alt="Profile Picture" class="profile-img">
                    </div>
                    <form action="php/update_pfp.php" method="POST" enctype="multipart/form-data"
                        class="pfp-upload-form">
                        <input type="file" name="pfp" accept="image/*" required class="pfp-input">
                        <button type="submit" name="action" value="upload" class="btn-pfp-upload">Upload Pic</button>
                    </form>
                    <?php if ($pfp !== 'default.jpeg'): ?>
                    <form action="php/update_pfp.php" method="POST">
                        <button type="submit" name="action" value="remove" class="btn-pfp-remove">Remove</button>
                    </form>
                    <?php
endif; ?>
                </div>
                <div class="user-meta">
                    <h1>Active Student</h1>
                    <p>
                        <?php echo htmlspecialchars($user['email']); ?>
                    </p>
                    <p class="profile-student-info">
                        <?php echo htmlspecialchars($user['rollno']); ?> |
                        <?php echo htmlspecialchars($user['course']); ?>
                    </p>
                </div>
            </div>

            <div class="section-title">
                Order History
            </div>

            <?php if (empty($orders)): ?>
            <div class="empty-orders">
                <p>No orders yet. Your food journey starts here!</p>
            </div>
            <?php
else: ?>
            <table>
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
                        <td class="fw-bold">#
                            <?php echo $order['id']; ?>
                        </td>
                        <td>
                            <?php echo date('d M, Y', strtotime($order['order_date'])); ?>
                        </td>
                        <td class="fw-bold">₹
                            <?php echo number_format($order['total_amount'], 2); ?>
                        </td>
                    </tr>
                    <?php
    endforeach; ?>
                </tbody>
            </table>
            <?php
endif; ?>

            <div class="section-title">
                Support & Complaints
            </div>

            <div class="complaint-form">
                <form action="php/submit_complaint.php" method="POST">
                    <div class="form-group">
                        <label for="order_id">Related Order (Optional)</label>
                        <select id="order_id" name="order_id">
                            <option value="">-- No specific order --</option>
                            <?php foreach ($orders as $o): ?>
                            <option value="<?php echo $o['id']; ?>">Order #
                                <?php echo $o['id']; ?> (₹
                                <?php echo $o['total_amount']; ?>)
                            </option>
                            <?php
endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required
                            placeholder="e.g. Missing items in my order">
                    </div>
                    <div class="form-group">
                        <label for="message">Detailed Message</label>
                        <textarea id="message" name="message" rows="4" required class="complaint-textarea"
                            placeholder="Tell us what happened..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Submit Complaint</button>
                </form>
            </div>

            <?php if (!empty($complaints)): ?>
            <div class="section-title complaints-title">Your Recent Complaints</div>
            <table>
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
                        <td class="complaint-subject">
                            <?php echo htmlspecialchars($comp['subject']); ?>
                        </td>
                        <td><span class="status-badge status-default">
                                <?php echo $comp['status']; ?>
                            </span></td>
                        <td>
                            <?php echo date('d M', strtotime($comp['created_at'])); ?>
                        </td>
                    </tr>
                    <?php
    endforeach; ?>
                </tbody>
            </table>
            <?php
endif; ?>

            <div class="logout-wrapper">
                <a href="logout.php" class="btn-logout">LOGOUT</a>
            </div>
        </div>


    </div>

</body>

</html>