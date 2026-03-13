<?php
require_once 'php/db_connect.php';

$res_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($res_id === 0) {
    header("Location: index.php");
    exit;
}

// Fetch restaurant details
$stmt = $conn->prepare("SELECT * FROM restaurants WHERE id = :id");
$stmt->bindParam(':id', $res_id);
$stmt->execute();
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$restaurant) {
    echo "Restaurant not found.";
    exit;
}

// Fetch menu items with category names for this restaurant
$menu_stmt = $conn->prepare("
    SELECT m.*, c.category_name 
    FROM menu_items m 
    JOIN menu_categories c ON m.category_id = c.id 
    WHERE m.restaurant_id = :res_id 
    ORDER BY c.id ASC
");
$menu_stmt->bindParam(':res_id', $res_id);
$menu_stmt->execute();
$menu_items = $menu_stmt->fetchAll(PDO::FETCH_ASSOC);
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
<body style="background: #0d0d0d;">

    <div class="app-container">
        <header class="app-header">
            <a href="index.php" style="color: white; text-decoration: none; font-size: 1.2rem;"><i class="fa-solid fa-arrow-left"></i> Back</a>
            <div class="logo-desktop"><?php echo $restaurant['name']; ?></div>
            <button class="notification-btn"><i class="fa-solid fa-share-nodes"></i></button>
        </header>

        <main class="app-main">
            <div class="hero-section" style="min-height: 200px; padding: 0;">
                <div class="hero-image-container">
                    <div class="hero-bg" style="background-image: url('<?php echo $restaurant['image_url']; ?>');"></div>
                    <div class="hero-overlay" style="background: linear-gradient(to top, rgba(13,13,13,1), transparent);"></div>
                </div>
                <div class="hero-content" style="text-align: left; padding: 20px; width: 100%;">
                    <h1 style="margin-bottom: 5px;"><?php echo htmlspecialchars($restaurant['name']); ?></h1>
                    <p style="margin-bottom: 10px; color: var(--neon-green); font-weight: 600;"><?php echo $restaurant['cuisine_type']; ?> • <i class="fa-solid fa-star"></i> <?php echo $restaurant['rating']; ?></p>
                    <p><?php echo htmlspecialchars($restaurant['description']); ?></p>
                </div>
            </div>

            <div class="section-header">
                <h3>Menu</h3>
            </div>

            <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                <?php if (empty($menu_items)): ?>
                    <p style="color: #888;">No menu items found for this restaurant.</p>
                <?php else: ?>
                    <?php 
                    $current_cat = "";
                    foreach ($menu_items as $item): 
                        if ($current_cat != $item['category_name']):
                            $current_cat = $item['category_name'];
                    ?>
                        <div style="grid-column: 1 / -1; margin: 20px 0 10px; border-bottom: 2px solid var(--neon-green); padding-bottom: 5px;">
                            <h2 style="color: var(--neon-green); font-size: 1.4rem;"><?php echo $current_cat; ?></h2>
                        </div>
                    <?php endif; ?>
                    <div class="product-card">
                        <div class="card-image-wrap" style="height: 120px; background: #222; display: flex; align-items: center; justify-content: center;">
                            <?php if ($item['image_url']): ?>
                                <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['item_name']; ?>">
                            <?php else: ?>
                                <i class="fa-solid fa-utensils" style="font-size: 3rem; color: #444;"></i>
                            <?php endif; ?>
                        </div>
                        <div class="card-info">
                            <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                            <p class="card-desc"><?php echo htmlspecialchars($item['description'] ?? 'Delicious campus meal.'); ?></p>
                            <div class="price-row">
                                <span class="price">₹<?php echo number_format($item['price'], 0); ?></span>
                            </div>
                        </div>
                        <button class="add-btn" onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <nav class="bottom-nav">
            <a href="index.php" class="nav-item"><i class="fa-solid fa-house"></i><span>Home</span></a>
            <a href="cart.html" class="nav-item"><i class="fa-solid fa-basket-shopping"></i><span>Baskets</span></a>
            <a href="profile.php" class="nav-item"><i class="fa-regular fa-user"></i><span>Account</span></a>
        </nav>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
