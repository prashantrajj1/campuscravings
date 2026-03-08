<?php
include 'connect.php';

$message = "";

// Dynamic Pages and $_POST variable processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["food_name"];
    $desc = $_POST["food_desc"];
    $price = $_POST["food_price"];
    
    // Insert statement into database (Module IV)
    $sql = "INSERT INTO food_items (name, description, price) VALUES ('$name', '$desc', '$price')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Food item successfully added to the database!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Add Food</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header-top">
        <a href="../index.html" class="logo">
            <span class="campus">Campus</span><span class="cravings">Cravings</span>
        </a>
    </div>
    
    <!-- Div styling and logical section -->
    <div class="container" style="max-width: 600px;">
        <h2 style="color: #006073;">Add New Food Item</h2>
        
        <?php if($message) { echo "<p style='color: #7BB21B; font-weight: bold; padding: 10px; background-color: #f1f8e9; border-radius: 5px;'>$message</p>"; } ?>
        
        <form action="add_food.php" method="POST">
            <div class="form-group">
                <label>Food Name</label>
                <input type="text" name="food_name" required placeholder="e.g. Classic Burger">
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="food_desc" rows="4" required style="width: 100%; border-radius: 10px; padding: 12px; border: 2px solid #ddd; box-sizing: border-box;"></textarea>
            </div>
            
            <div class="form-group">
                <label>Price (₹)</label>
                <!-- Input types -->
                <input type="number" step="0.01" name="food_price" required placeholder="e.g. 150.00">
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 10px;">Add Item to Database</button>
        </form>
        
        <hr style="border:0; height:1px; background-color:#ddd; margin: 25px 0;">
        <a href="view_orders.php" class="btn-secondary" style="display: block; text-align: center;">View All Orders</a>
    </div>
    
    <div class="footer">
        &copy; 2026 Campus Cravings. Admin Panel.
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>
