<?php
// Authentication check
$user_id = null;
$user_email = "";
if (isset($_COOKIE['user_auth'])) {
    $decoded = json_decode(base64_decode($_COOKIE['user_auth']), true);
    $user_id = $decoded['id'];
    $user_email = $decoded['email'];
} else {
    header("Location: login.html");
    exit;
}

require_once 'php/db_connect.php';

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch orders
$order_stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC");
$order_stmt->bindParam(':user_id', $user_id);
$order_stmt->execute();
$orders = $order_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch complaints
$complaint_stmt = $conn->prepare("SELECT * FROM complaints WHERE user_id = :user_id ORDER BY created_at DESC");
$complaint_stmt->bindParam(':user_id', $user_id);
$complaint_stmt->execute();
$complaints = $complaint_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - CampusCravings</title>
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .profile-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            color: #333;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            background: #7cff1c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: #000;
        }
        
        .user-meta h1 { font-size: 1.8rem; margin: 0; }
        .user-meta p { color: #666; margin: 5px 0 0; }
        
        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 30px 0 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Table Styling (Module III) */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: #f9f9f9;
            color: #555;
            font-weight: 600;
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-delivered { background: #e6ffec; color: #1a7f37; }
        .status-pending { background: #fff8c5; color: #9a6700; }
        
        /* Form Styling (Module IV) */
        .complaint-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
        }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
        }
        
        .btn-submit {
            background: #ff7300;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body style="background: #0d0d0d; font-family: 'Outfit', sans-serif;">

    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($user['email'], 0, 1)); ?>
            </div>
            <div class="user-meta">
                <h1>Student Profile</h1>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
                <p><small>Roll No: <?php echo htmlspecialchars($user['rollno']); ?> | Course: <?php echo htmlspecialchars($user['course']); ?></small></p>
            </div>
        </div>

        <div class="section-title">
            <i class="fa-solid fa-clock-rotate-left"></i> Order History
        </div>
        
        <?php if (empty($orders)): ?>
            <p style="color: #888; text-align: center; padding: 20px;">No typical "foodie" history yet. Go grab a bite!</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo date('d M, Y', strtotime($order['order_date'])); ?></td>
                            <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td>
                                <span class="status-badge <?php echo 'status-' . strtolower(str_replace(' ', '-', $order['status'])); ?>">
                                    <?php echo $order['status']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="section-title">
            <i class="fa-solid fa-headset"></i> Support & Complaints
        </div>

        <div class="complaint-form">
            <form action="php/submit_complaint.php" method="POST">
                <div class="form-group">
                    <label for="order_id">Related Order (Optional)</label>
                    <select id="order_id" name="order_id" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                        <option value="">-- No specific order --</option>
                        <?php foreach ($orders as $o): ?>
                            <option value="<?php echo $o['id']; ?>">Order #<?php echo $o['id']; ?> (₹<?php echo $o['total_amount']; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required placeholder="Issue with last delivery">
                </div>
                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" rows="4" required placeholder="Describe your problem..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Submit Complaint</button>
            </form>
        </div>

        <?php if (!empty($complaints)): ?>
            <div class="section-title" style="font-size: 1.1rem;">Your Recent Complaints</div>
            <table style="font-size: 0.9rem;">
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
                            <td><?php echo htmlspecialchars($comp['subject']); ?></td>
                            <td><?php echo $comp['status']; ?></td>
                            <td><?php echo date('d M', strtotime($comp['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="index.php" style="color: #ff7300; text-decoration: none; font-weight: 500;"><i class="fa-solid fa-arrow-left"></i> Back to Explore</a>
            <span style="margin: 0 15px; color: #ddd;">|</span>
            <a href="logout.php" style="color: #dc3545; text-decoration: none; font-weight: 500;"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

</body>
</html>
