<?php
require_once 'php/db_connect.php';

// Fetch all restaurants
$stmt = $conn->prepare("SELECT * FROM restaurants");
$stmt->execute();
$restaurants = $res_stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Restaurants - CampusCravings</title>
    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background: #0d0d0d;">

    <div class="app-container">
        <header class="app-header">
            <div class="logo-desktop">
                <i class="fa-solid fa-utensils"></i> Campus<span>Cravings</span>
            </div>
            <nav class="desktop-nav">
                <a href="index.php">Home</a>
                <a href="explore.php" class="active">Explore</a>
                <a href="cart.html">Cart</a>
                <a href="profile.php">Account</a>
            </nav>
            <button class="notification-btn"><i class="fa-regular fa-bell"></i></button>
        </header>

        <main class="app-main">
            <div class="section-header" style="padding-top: 20px;">
                <h3>All Restaurants</h3>
            </div>

            <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                <?php foreach ($restaurants as $res): ?>
                <div class="product-card" style="min-width: unset;">
                    <div class="card-image-wrap">
                        <img src="<?php echo $res['image_url']; ?>" alt="<?php echo $res['name']; ?>">
                        <div class="card-badge" style="background: var(--neon-green); color: black;"><?php echo $res['rating']; ?> <i class="fa-solid fa-star"></i></div>
                    </div>
                    <div class="card-info">
                        <h4><?php echo htmlspecialchars($res['name']); ?></h4>
                        <p class="card-desc"><?php echo htmlspecialchars($res['description']); ?></p>
                        <p style="color: var(--neon-green); font-weight: 500;"><?php echo $res['cuisine_type']; ?></p>
                    </div>
                    <a href="restaurant_details.php?id=<?php echo $res['id']; ?>" class="add-btn" style="text-decoration: none;"><i class="fa-solid fa-chevron-right"></i></a>
                </div>
                <?php endforeach; ?>
            </div>
        </main>

        <nav class="bottom-nav">
            <a href="index.php" class="nav-item"><i class="fa-solid fa-house"></i><span>Home</span></a>
            <a href="explore.php" class="nav-item active"><div class="nav-icon-bg"><i class="fa-regular fa-compass"></i></div><span>Explore</span></a>
            <a href="cart.html" class="nav-item"><i class="fa-solid fa-basket-shopping"></i><span>Baskets</span></a>
            <a href="profile.php" class="nav-item"><i class="fa-regular fa-user"></i><span>Account</span></a>
        </nav>
    </div>

</body>
</html>
