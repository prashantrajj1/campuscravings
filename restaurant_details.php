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
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/restaurant_details.css">
</head>
<body>

    <div class="app-container">
        <header class="app-header">
            <a href="home.php" class="back-link-res"><i class="fa-solid fa-arrow-left"></i> Home</a>
            
            <div class="search-bar search-bar-res">
                <input type="text" placeholder="Search in menu..." class="search-input-res">
                <i class="fa-solid fa-magnifying-glass search-icon-res"></i>
            </div>
            
            <div class="account-actions-res">
                <a href="checkout.php" class="account-btn" title="Cart"><i class="fa-solid fa-basket-shopping"></i></a>
                <a href="profile.php" class="account-btn" title="Account"><?php
$nav_pfp = 'default.jpeg';
if(isset($_SESSION['user_id']) && isset($conn)) {
    $uid_nav = $_SESSION['user_id'];
    $u_q_nav = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = '$uid_nav'");
    if($u_q_nav && mysqli_num_rows($u_q_nav) > 0) {
        $u_d_nav = mysqli_fetch_assoc($u_q_nav);
        if(!empty($u_d_nav['profile_picture'])) $nav_pfp = $u_d_nav['profile_picture'];
    }
}
echo '<img src="assets/pfp/'.htmlspecialchars($nav_pfp).'" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">';
?></a>
            </div>
        </header>

        <main class="app-main">
            <div class="hero-section hero-section-res">
                <div class="hero-image-container">
                    <div class="hero-bg" style="background-image: url('<?php echo $restaurant['image_url']; ?>');"></div>
                    <div class="hero-overlay hero-overlay-res"></div>
                </div>
                <div class="hero-content hero-content-res">
                    <h1 class="hero-title-res"><?php echo htmlspecialchars($restaurant['name']); ?></h1>
                    <p class="hero-subtitle-res">
                        <?php echo $restaurant['cuisine_type']; ?>
                    </p>
                    <p class="hero-desc-res"><?php echo htmlspecialchars($restaurant['description']); ?></p>
                </div>
            </div>

            <div class="section-header section-header-res">
                <h3 class="section-title-res">Recommended Dishes</h3>
            </div>

            <div class="products-grid">
                <?php if (empty($menu_items)): ?>
                    <div class="no-menu-msg">
                        <p>No menu items found for this restaurant.</p>
                    </div>
                <?php else: ?>
                    <?php 
                    $current_cat = "";
                    foreach ($menu_items as $item): 
                        if ($current_cat != $item['category_name']):
                            $current_cat = $item['category_name'];
                    ?>
                        <div class="category-wrapper-res">
                            <h2 class="category-title-res">
                                <?php echo $current_cat; ?>
                                <span class="category-underline-res"></span>
                            </h2>
                        </div>
                    <?php endif; ?>
                    <div class="product-card">
                        <div class="card-image-wrap img-wrap-res">
                            <?php if ($item['image_url']): ?>
                                <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['item_name']; ?>">
                            <?php else: ?>
                                <i class="fa-solid fa-pizza-slice placeholder-res"></i>
                            <?php endif; ?>
                        </div>
                        <div class="card-info">
                            <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                            <div class="card-badge">NEW</div>
                            <p class="card-desc card-desc-res"><?php echo htmlspecialchars($item['description'] ?? 'A favorite among students for its authentic taste.'); ?></p>
                            <div class="price-row price-row-res">
                                <span class="price">₹<?php echo number_format($item['price'], 0); ?></span>
                            </div>
                        </div>
                        <button class="add-btn add-btn-res" onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">+</button>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        
    </div>

    <script src="js/script.js"></script>
</body>
</html>
