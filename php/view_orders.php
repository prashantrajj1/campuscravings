<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Orders</title>
    
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header-top">
        <a href="../index.html" class="logo">
            <span class="campus">Campus</span><span class="cravings">Cravings</span>
        </a>
    </div>
    
    <div class="container">
        <h2 style="color: #006073; margin-bottom: 20px;">Customer Orders Dashboard</h2>
        
        
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email Address</th>
                    <th>Order Details</th>
                    <th>Total Amount</th>
                    <th>Date Reached</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $sql = "SELECT * FROM orders ORDER BY order_date DESC";
                $result = mysqli_query($conn, $sql);
                
                
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>#" . $row["id"] . "</td>";
                        echo "<td><strong>" . htmlspecialchars($row["customer_name"]) . "</strong></td>";
                        echo "<td>" . htmlspecialchars($row["customer_email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["food_details"]) . "</td>";
                        echo "<td style='color:#FF7300; font-weight:bold;'>₹" . $row["total_amount"] . "</td>";
                        echo "<td>" . $row["order_date"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No customer orders found yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="add_food.php" class="btn-primary" style="margin-right: 15px;">Add New Food Items</a>
            <a href="../login.php" class="btn-secondary">Log Out</a>
        </div>
    </div>
    
    <div class="footer">
        &copy; 2026 Campus Cravings. Admin Panel.
    </div>
</body>
</html>
<?php 

mysqli_close($conn); 
?>
