<?php
// campuscravings - home page
// this is the main dashboard after login

session_start();

// redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'php/db_connect.php';

// ----- fetch restaurants for the bottom section -----
// only showing 6 on homepage, rest on explore page
$r = mysqli_query($conn, "SELECT * FROM restaurants LIMIT 6");
$restList = [];
if ($r) {
    while ($row = mysqli_fetch_assoc($r)) {
        $restList[] = $row;
    }
}
// echo count($restList); // debug - was showing 0 earlier

// ----- fetch menu categories for filter buttons -----
$catResult = mysqli_query($conn, "SELECT * FROM menu_categories LIMIT 5");
$cats = [];
if ($catResult) {
    while ($c = mysqli_fetch_assoc($catResult)) {
        $cats[] = $c;
    }
}

// check which category filter is selected (from GET params)
$selCat = isset($_GET['category']) ? $_GET['category'] : 'all';

// ----- fetch menu items based on selected category -----
// TODO: add pagination later when we have more items
if ($selCat === 'all') {
    $itemsQuery = "SELECT m.*, r.name as restaurant_name, c.category_name 
        FROM menu_items m 
        JOIN restaurants r ON m.restaurant_id = r.id 
    JOIN menu_categories c ON m.category_id = c.id
        LIMIT 8";
}
else {
    // need to escape the category id for sql injection
    $catId = mysqli_real_escape_string($conn, $selCat);
    $itemsQuery = "SELECT m.*, r.name as restaurant_name, c.category_name 
    FROM menu_items m 
        JOIN restaurants r ON m.restaurant_id = r.id 
        JOIN menu_categories c ON m.category_id = c.id
    WHERE m.category_id = '$catId'
        LIMIT 8";
}

$itemsResult = mysqli_query($conn, $itemsQuery);
$foodItems = [];
if ($itemsResult) {
    while ($item = mysqli_fetch_assoc($itemsResult)) {
        $foodItems[] = $item;
    }
}
// var_dump($foodItems); // uncomment to debug
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusCravings - XIM University Food Ordering</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>

    <div class="wrapper">

        <!-- top navigation bar -->
        <header class="topbar">
            <div class="sitename">
                🍴 Campus<span>Cravings</span>
            </div>

            <!-- shows XIM University as location -->
            <div class="location">
                <p class="label">Location</p>
                <div class="loc-name">
                    <span>📍XIM University</span>
                </div>
            </div>

            <!-- desktop nav - hidden on mobile -->
            <nav class="links">
                <a href="home.php" class="active">Home</a>
                <a href="explore.php">Explore</a>
                <a href="checkout.php">Cart</a>
            </nav>

            <!-- profile picture / account link -->
            <a href="profile.php" class="profilepic" title="Account">
                <?php
// get user profile pic for navbar
// default is default.jpeg if they havent uploaded one
$navPfp = 'default.jpeg';
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $pfpQuery = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = '$uid'");
    if ($pfpQuery && mysqli_num_rows($pfpQuery) > 0) {
        $pfpData = mysqli_fetch_assoc($pfpQuery);
        if (!empty($pfpData['profile_picture']))
            $navPfp = $pfpData['profile_picture'];
    }
}
echo '<img src="assets/pfp/' . htmlspecialchars($navPfp) . '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">';
?>
            </a>
        </header>

        <main class="main">

            <!-- hero banner with food image -->
            <section class="banner">
                <div class="bgimage">
                </div>
                <div class="darken"></div>
                <div class="banner-text">
                    <h1>Hungry? <span class="orange">Get It Fast.</span></h1>
                    <p>Order from the best campus spots
                        right now. Fresh, hot, and delivered to your Campus Maingate.</p>
                    <div class="banner-btns">
                        <a href="explore.php" class="orange-btn">Order Now</a>
                    </div>
                </div>
            </section>

            <!-- category filter buttons - All Dishes, Indian Thali, etc -->
            <div class="filters">
                <form action="home.php" method="GET">
                    <div class="filter-list">
                        <label class="filteroption">
                            <input type="radio" name="category" value="all" <?php echo $selCat==='all' ? 'checked' : ''
                                ; ?>
                            onchange="this.form.submit()">
                            <span class="filterbtn">All Dishes</span>
                        </label>

                        <?php
// loop thru categories from db
foreach ($cats as $cat):
?>
                        <label class="filteroption">
                            <input type="radio" name="category" value="<?php echo $cat['id']; ?>" <?php echo
                                (string)$selCat===(string)$cat['id'] ? 'checked' : '' ; ?>
                            onchange="this.form.submit()">
                            <span class="filterbtn">
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </span>
                        </label>
                        <?php
endforeach; ?>
                    </div>
                </form>
            </div>

            <!-- popular food items section -->
            <div class="heading-row" id="popular">
                <h3>Popular on Campus</h3>
                <a href="explore.php" class="viewall">See all</a>
            </div>

            <div class="grid">
                <?php
// display each food item as a card
foreach ($foodItems as $item):
?>
                <div class="card">
                    <div class="imgbox">
                        <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['item_name']; ?>">
                    </div>
                    <div class="info">
                        <h4>
                            <?php echo htmlspecialchars($item['item_name']); ?>
                        </h4>
                        <div class="tag">
                            <?php echo $item['category_name']; ?>
                        </div>
                        <p>From
                            <?php echo htmlspecialchars($item['restaurant_name']); ?>
                        </p>
                        <div class="price-area">
                            <span class="price">₹
                                <?php echo number_format($item['price'], 0); ?>
                            </span>
                        </div>
                    </div>
                    <button class="plusbtn"
                        onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">+</button>
                </div>
                <?php
endforeach; ?>
            </div>

            <!-- restaurants section at the bottom -->
            <div class="heading-row">
                <h3>Featured Restaurants</h3>
                <a href="explore.php" class="viewall">View all restaurants</a>
            </div>

            <div class="grid">
                <?php foreach ($restList as $rest): ?>
                <a href="restaurant_details.php?id=<?php echo $rest['id']; ?>" class="rest-card">
                    <div class="imgbox">
                        <img src="<?php echo $rest['image_url']; ?>" alt="<?php echo $rest['name']; ?>">
                    </div>
                    <div class="info">
                        <h4>
                            <?php echo htmlspecialchars($rest['name']); ?>
                        </h4>
                        <p>
                            <?php echo $rest['cuisine_type']; ?>
                        </p>
                    </div>
                </a>
                <?php
endforeach; ?>
            </div>

        </main>

        <!-- mobile bottom nav - only shows on small screens -->
        <nav class="mobilenav">
            <a href="home.php" class="navlink active">
                <div class="icon-bg"><i class="fa-solid fa-house"></i></div>
                <span>Home</span>
            </a>
            <a href="explore.php" class="navlink">
                <i class="fa-regular fa-compass"></i>
                <span>Explore</span>
            </a>
            <a href="cart.html" class="navlink">
                <i class="fa-solid fa-basket-shopping"></i>
                <span>Cart</span>
            </a>
            <a href="profile.php" class="navlink">
                <i class="fa-regular fa-user"></i>
                <span>Account</span>
            </a>
        </nav>

    </div>

    <script src="js/script.js"></script>
</body>

</html>