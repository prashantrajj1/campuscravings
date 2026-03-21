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

// Fetch restaurant details
$query = "SELECT * FROM restaurants WHERE id = '$res_id'";
$result = mysqli_query($conn, $query);
$restaurant = mysqli_fetch_assoc($result);

if (!$restaurant) {
    echo "Restaurant not found.";
    exit;
}

// Fetch menu items with category names for this restaurant
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $restaurant['name']; ?> - CampusCravings</title>
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: var(--bg-main);">

    <div class="app-container">
        <header class="app-header">
            <a href="home.php" style="color: var(--text-main); text-decoration: none; font-weight: 700; white-space: nowrap;"><i class="fa-solid fa-arrow-left"></i> Home</a>
            
            <div class="search-bar" style="flex: 1; margin: 0 15px; position: relative; max-width: 400px;">
                <input type="text" placeholder="Search in menu..." style="width: 100%; padding: 10px 18px 10px 40px; border-radius: 20px; border: 1px solid var(--border-light); background: var(--bg-light); color: var(--text-main);">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
            </div>
            
            <div style="display: flex; gap: 15px;">
                <a href="checkout.php" class="account-btn" title="Cart"><i class="fa-solid fa-basket-shopping"></i></a>
                <a href="profile.php" class="account-btn" title="Account"><i class="fa-regular fa-user"></i></a>
            </div>
        </header>

        <main class="app-main">
            <div class="hero-section" style="min-height: 250px; padding: 0; box-shadow: var(--card-shadow); border: 1px solid var(--border-light); background: #fff;">
                <div class="hero-image-container">
                    <div class="hero-bg" style="background-image: url('<?php echo $restaurant['image_url']; ?>');"></div>
                    <div class="hero-overlay" style="background: linear-gradient(to top, rgba(255,255,255,0.9), transparent);"></div>
                </div>
                <div class="hero-content" style="text-align: left; padding: 30px; width: 100%; color: var(--text-main);">
                    <h1 style="margin-bottom: 8px; font-size: 2.2rem; text-shadow: none;"><?php echo htmlspecialchars($restaurant['name']); ?></h1>
                    <p style="margin-bottom: 5px; color: var(--swiggy-orange); font-weight: 800; font-size: 1.1rem; text-shadow: none;">
                        <?php echo $restaurant['cuisine_type']; ?>
                    </p>
                    <p style="color: var(--text-muted); text-shadow: none;"><?php echo htmlspecialchars($restaurant['description']); ?></p>
                </div>
            </div>

            <div class="section-header" style="margin-top: 40px; border-bottom: 1px solid var(--border-light); padding-bottom: 15px;">
                <h3 style="font-size: 1.6rem; font-weight: 800;">Recommended Dishes</h3>
            </div>

            <div class="products-grid">
                <?php if (empty($menu_items)): ?>
                    <div style="text-align: center; color: var(--text-muted); grid-column: 1/-1; padding: 50px;">
                        <p>No menu items found for this restaurant.</p>
                    </div>
                <?php else: ?>
                    <?php 
                    $current_cat = "";
                    foreach ($menu_items as $item): 
                        if ($current_cat != $item['category_name']):
                            $current_cat = $item['category_name'];
                    ?>
                        <div style="grid-column: 1 / -1; margin: 30px 0 15px;">
                            <h2 style="color: var(--text-main); font-size: 1.4rem; font-weight: 800; position: relative; display: inline-block;">
                                <?php echo $current_cat; ?>
                                <span style="position: absolute; bottom: -5px; left: 0; width: 50%; height: 3px; background: var(--swiggy-orange);"></span>
                            </h2>
                        </div>
                    <?php endif; ?>
                    <div class="product-card">
                        <div class="card-image-wrap" style="height: 160px; background: var(--bg-light);">
                            <?php if ($item['image_url']): ?>
                                <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['item_name']; ?>">
                            <?php else: ?>
                                <i class="fa-solid fa-pizza-slice" style="font-size: 3rem; color: var(--text-muted); opacity: 0.1;"></i>
                            <?php endif; ?>
                        </div>
                        <div class="card-info">
                            <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                            <div class="card-badge">NEW</div>
                            <p class="card-desc" style="margin-top: 8px;"><?php echo htmlspecialchars($item['description'] ?? 'A favorite among students for its authentic taste.'); ?></p>
                            <div class="price-row" style="margin-top: 15px;">
                                <span class="price">₹<?php echo number_format($item['price'], 0); ?></span>
                            </div>
                        </div>
                        <button class="add-btn" onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)" style="color: var(--swiggy-green);">+</button>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <nav class="bottom-nav">
            <a href="home.php" class="nav-item">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
            <a href="explore.php" class="nav-item">
                <i class="fa-regular fa-compass"></i>
                <span>Explore</span>
            </a>
            <a href="checkout.php" class="nav-item">
                <i class="fa-solid fa-basket-shopping"></i>
                <span>Cart</span>
            </a>
            <a href="profile.php" class="nav-item">
                <i class="fa-regular fa-user"></i>
                <span>Account</span>
            </a>
        </nav>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
