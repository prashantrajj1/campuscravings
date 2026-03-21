<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'php/db_connect.php';

$res_id = isset($_GET['id']) ? (int)mysqli_real_escape_string($conn, $_GET['id']) : 0;

if ($res_id === 0) {
    header("Location: home.php");
    exit;
}

$query = "SELECT * FROM restaurants WHERE id = '$res_id'";
$result = mysqli_query($conn, $query);
$restaurant = mysqli_fetch_assoc($result);

if (!$restaurant) {
    echo "Restaurant not found.";
    exit;
}

$menu_query = "
    SELECT m.*, c.category_name 
    FROM menu_items m 
    JOIN menu_categories c ON m.category_id = c.id 
    WHERE m.restaurant_id = '$res_id' 
    ORDER BY c.id ASC
";
$menu_result = mysqli_query($conn, $menu_query);
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
    <title><?php echo $restaurant['name']; ?> - CampusCravings</title>
    <link rel="stylesheet" href="css/restaurant_details.css">
</head>
<body>

<table width="100%" cellpadding="20" class="header-table">
    <tr>
        <td width="30%">
            <a href="home.php" class="logo-text">Campus<span>Cravings</span></a>
        </td>
        <td width="40%" align="center">
            <a href="home.php" class="nav-link">Home</a>
            <a href="explore.php" class="nav-link active">Explore</a>
            <a href="checkout.php" class="nav-link">Cart</a>
        </td>
        <td width="30%" align="right">
            <a href="profile.php" class="nav-link">Account</a>
        </td>
    </tr>
</table>

<div class="layout-container">

    <div class="restaurant-hero" style="background-image: url('<?php echo $restaurant['image_url']; ?>');">
        <div class="hero-overlay">
            <h1 class="hero-title"><?php echo htmlspecialchars($restaurant['name']); ?></h1>
            <p class="hero-subtitle"><?php echo $restaurant['cuisine_type']; ?></p>
            <p class="hero-desc"><?php echo htmlspecialchars($restaurant['description']); ?></p>
        </div>
    </div>

    <div class="section-title">Recommended Dishes</div>

    <?php if (empty($menu_items)): ?>
        <p>No menu items found for this restaurant.</p>
    <?php else: ?>
        <table width="100%" cellpadding="15">
            <?php 
            $current_cat = "";
            $count = 0;
            foreach ($menu_items as $item): 
                if ($current_cat != $item['category_name']):
                    if ($count > 0 && $count % 4 != 0) {
                        while ($count % 4 != 0) {
                            echo "<td width='25%'></td>";
                            $count++;
                        }
                        echo "</tr>";
                    }
                    $count = 0;
                    $current_cat = $item['category_name'];
            ?>
            <tr class="category-header">
                <td colspan="4">
                    <h2><?php echo $current_cat; ?></h2>
                    <div class="category-line"></div>
                </td>
            </tr>
            <tr>
            <?php endif; 
                if ($count > 0 && $count % 4 == 0) echo "</tr><tr>";
            ?>
                <td width="25%" align="center" valign="top">
                    <div class="product-cell">
                        <?php if ($item['image_url']): ?>
                            <img src="<?php echo $item['image_url']; ?>" width="100%" height="150" class="product-img">
                        <?php else: ?>
                            <div style="height: 150px; background-color: #e9ecee;"></div>
                        <?php endif; ?>
                        
                        <h4 class="product-title"><?php echo htmlspecialchars($item['item_name']); ?></h4>
                        <span class="badge">NEW</span>
                        <p class="product-desc"><?php echo htmlspecialchars($item['description'] ?? 'A favorite among students for its authentic taste.'); ?></p>
                        
                        <div class="price">₹<?php echo number_format($item['price'], 0); ?></div>
                        <button class="add-btn" onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">+ Add to Cart</button>
                    </div>
                </td>
            <?php 
                $count++;
            endforeach; 
            while ($count > 0 && $count % 4 != 0) {
                echo "<td width='25%'></td>";
                $count++;
            }
            if ($count > 0) echo "</tr>";
            ?>
        </table>
    <?php endif; ?>

    <br><br>
</div>

<script src="js/script.js"></script>
</body>
</html>
