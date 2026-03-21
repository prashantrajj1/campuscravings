<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'php/db_connect.php';

$res_query = "SELECT * FROM restaurants LIMIT 6";
$res_result = mysqli_query($conn, $res_query);
$restaurants = [];
if ($res_result) {
    while ($row = mysqli_fetch_assoc($res_result)) {
        $restaurants[] = $row;
    }
}

$cat_query = "SELECT * FROM menu_categories LIMIT 5";
$cat_result = mysqli_query($conn, $cat_query);
$categories = [];
if ($cat_result) {
    while ($row = mysqli_fetch_assoc($cat_result)) {
        $categories[] = $row;
    }
}

$selected_category = isset($_GET['category']) ? $_GET['category'] : 'all';

if ($selected_category === 'all') {
    $menu_query = "
        SELECT m.*, r.name as restaurant_name, c.category_name 
        FROM menu_items m 
        JOIN restaurants r ON m.restaurant_id = r.id 
        JOIN menu_categories c ON m.category_id = c.id
        LIMIT 8
    ";
    $menu_result = mysqli_query($conn, $menu_query);
} else {
    $cat_id = mysqli_real_escape_string($conn, $selected_category);
    $menu_query = "
        SELECT m.*, r.name as restaurant_name, c.category_name 
        FROM menu_items m 
        JOIN restaurants r ON m.restaurant_id = r.id 
        JOIN menu_categories c ON m.category_id = c.id
        WHERE m.category_id = '$cat_id'
        LIMIT 8
    ";
    $menu_result = mysqli_query($conn, $menu_query);
}
$menu_items = [];
if ($menu_result) {
    while ($row = mysqli_fetch_assoc($menu_result)) {
        $menu_items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CampusCravings - Home</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>

<table width="100%" cellpadding="20" class="header-table">
    <tr>
        <td width="30%">
            <a href="home.php" class="logo-text">Campus<span>Cravings</span></a>
        </td>
        <td width="40%" align="center">
            <a href="home.php" class="nav-link active">Home</a>
            <a href="explore.php" class="nav-link">Explore</a>
            <a href="checkout.php" class="nav-link">Cart</a>
        </td>
        <td width="30%" align="right">
            <a href="profile.php" class="nav-link">Account</a>
        </td>
    </tr>
</table>

<div class="layout-container">

    <div class="hero-box">
        <div class="hero-overlay">
            <h1 class="hero-title">Hungry? <span>Get It Fast.</span></h1>
            <p class="hero-desc">Order from the best campus spots. Fresh, hot, and delivered to your hostel.</p>
            <br>
            <a href="explore.php" class="btn-primary">Order Now</a>
        </div>
    </div>

    <!-- Category filter as a table -->
    <div class="category-table">
        <form action="home.php" method="GET">
            <table width="100%" cellpadding="10" border="1">
                <caption>Filter by Category</caption>
                <tr>
                    <td>
                        <input type="radio" name="category" value="all" <?php echo $selected_category === 'all' ? 'checked' : ''; ?> onchange="this.form.submit()"> All Dishes
                    </td>
                    <?php foreach ($categories as $cat): ?>
                    <td>
                        <input type="radio" name="category" value="<?php echo $cat['id']; ?>" <?php echo (string)$selected_category === (string)$cat['id'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                        <?php echo htmlspecialchars($cat['category_name']); ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </form>
    </div>

    <div>
        <a href="explore.php" class="see-all">See all items</a>
        <div class="section-title">Popular on Campus</div>
    </div>

    <table width="100%" cellpadding="15">
        <tr>
            <?php 
            $count = 0;
            foreach ($menu_items as $item): 
                if ($count > 0 && $count % 4 == 0) echo "</tr><tr>";
            ?>
            <td width="25%" align="center" valign="top">
                <div class="product-cell">
                    <img src="<?php echo $item['image_url']; ?>" width="100%" height="150" class="product-img">
                    <h4 class="product-title"><?php echo htmlspecialchars($item['item_name']); ?></h4>
                    <span class="badge"><?php echo $item['category_name']; ?></span>
                    <p class="product-desc">From <?php echo htmlspecialchars($item['restaurant_name']); ?></p>
                    <div class="price">₹<?php echo number_format($item['price'], 0); ?></div>
                    <button class="add-btn" onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">+ Add to Cart</button>
                </div>
            </td>
            <?php 
                $count++;
            endforeach; 
            // close table correctly
            while ($count % 4 != 0) {
                echo "<td width='25%'></td>";
                $count++;
            }
            ?>
        </tr>
    </table>

    <div>
        <a href="explore.php" class="see-all">View all restaurants</a>
        <div class="section-title">Featured Restaurants</div>
    </div>

    <table width="100%" cellpadding="15">
        <tr>
            <?php 
            $count = 0;
            foreach ($restaurants as $res): 
                if ($count > 0 && $count % 3 == 0) echo "</tr><tr>";
            ?>
            <td width="33%" align="center" valign="top">
                <a href="restaurant_details.php?id=<?php echo $res['id']; ?>">
                    <div class="product-cell">
                        <img src="<?php echo $res['image_url']; ?>" width="100%" height="180" class="product-img">
                        <h4 class="product-title"><?php echo htmlspecialchars($res['name']); ?></h4>
                        <p class="product-desc"><?php echo $res['cuisine_type']; ?></p>
                    </div>
                </a>
            </td>
            <?php 
                $count++;
            endforeach; 
            while ($count % 3 != 0) {
                echo "<td width='33%'></td>";
                $count++;
            }
            ?>
        </tr>
    </table>

    <br><br>
</div>

<script src="js/script.js"></script>
</body>
</html>