<?php
require_once 'php/db_connect.php';

// Fetch all restaurants
$query = "SELECT * FROM restaurants";
$result = mysqli_query($conn, $query);
$restaurants = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $restaurants[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Restaurants - CampusCravings</title>
    <!-- External CSS -->


    <!-- Local CSS only -->
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/explore.css">
</head>

<body>

    <div class="app-container">
        <header class="app-header">
            <div class="logo-desktop">
                🍴 Campus<span>Cravings</span>
            </div>
            <nav class="desktop-nav">
                <a href="home.php">Home</a>
                <a href="explore.php" class="active">Explore</a>
                <a href="checkout.php">Cart</a>
            </nav>
            <a href="profile.php" class="account-btn" title="Account">
                <?php
$nav_pfp = 'default.jpeg';
if (isset($_SESSION['user_id']) && isset($conn)) {
    $uid_nav = $_SESSION['user_id'];
    $u_q_nav = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = '$uid_nav'");
    if ($u_q_nav && mysqli_num_rows($u_q_nav) > 0) {
        $u_d_nav = mysqli_fetch_assoc($u_q_nav);
        if (!empty($u_d_nav['profile_picture']))
            $nav_pfp = $u_d_nav['profile_picture'];
    }
}
echo '<img src="assets/pfp/' . htmlspecialchars($nav_pfp) . '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">';
?>
            </a>
        </header>

        <main class="app-main">
            <div class="section-header pt-20">
                <h3 class="explore-title">Explore Restaurants</h3>
            </div>

            <div class="products-grid">
                <?php foreach ($restaurants as $res): ?>
                <a href="restaurant_details.php?id=<?php echo $res['id']; ?>" class="product-card explore-card-link">
                    <div class="card-image-wrap explore-img-wrap">
                        <img src="<?php echo $res['image_url']; ?>" alt="<?php echo $res['name']; ?>">
                    </div>
                    <div class="card-info">
                        <h4 class="explore-card-h4">
                            <?php echo htmlspecialchars($res['name']); ?>
                        </h4>
                        <p class="explore-card-p">
                            <?php echo $res['cuisine_type']; ?>
                        </p>
                    </div>
                </a>
                <?php
endforeach; ?>
            </div>
        </main>


    </div>

</body>

</html>