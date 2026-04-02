<?php
// restaurant details page - shows menu for a specific restaurant
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'php/db_connect.php';

// get restaurant id from url
$rid = isset($_GET['id']) ? (int)mysqli_real_escape_string($conn, $_GET['id']) : 0;

// if no valid id, go back to home
if ($rid === 0) {
    header("Location: home.php");
    exit;
}

// fetch the restaurant info
$restData = mysqli_query($conn, "SELECT * FROM restaurants WHERE id = '$rid'");
$rest = mysqli_fetch_assoc($restData);

if (!$rest) {
    echo "Restaurant not found."; // this shouldnt happen n
    exit;
}

// fetch all menu items for this restau, sorted by cate
$menuSql = "SELECT m.*, c.category_name 
FROM menu_items m 
    JOIN menu_categories c ON m.category_id = c.id 
    WHERE m.restaurant_id = '$rid' 
    ORDER BY c.id ASC";
$menuData = mysqli_query($conn, $menuSql);

$menuList = [];
if ($menuData) {
    while ($row = mysqli_fetch_assoc($menuData)) {
        $menuList[] = $row;
    }
}
// echo "total itms: " . count($menuList); // debug line
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $rest['name']; ?> - CampusCravings</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/restaurant_details.css">
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍴</text></svg>">
</head>

<body>

    <div class="wrapper">
    <header class="topbar">
            <a href="home.php" class="backbtn">Home</a>

            <div class="sitename">Campus<span>Cravings</span></div>

        <div class="right-btns">
                <a href="checkout.php" class="backbtn" title="Cart">Cart</a>
                <a href="profile.php" class="profilepic" title="Account">
                    <?php
// navbar pfp - copied from home.php
$navPfp = 'default.jpeg';
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $pq = mysqli_query($conn, "SELECT profile_picture FROM users WHERE id = '$uid'");
    if ($pq && mysqli_num_rows($pq) > 0) {
        $pd = mysqli_fetch_assoc($pq);
        if (!empty($pd['profile_picture']))
            $navPfp = $pd['profile_picture'];
    }
}
echo '<img src="assets/pfp/' . htmlspecialchars($navPfp) . '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">';
?>
            </a>
            </div>
        </header>

    <main class="main">

            <!-- restaurant banner with image -->
            <div class="banner rest-banner">
                <div class="banner-bg">
                    <div class="bgimage"
                        style="background-image: url('<?php echo $rest['image_url']; ?>');">
                </div>
                    <div class="darken rest-darken"></div>
                </div>
            <div class="banner-text rest-info">
                    <h1 class="rest-name"><?php echo htmlspecialchars($rest['name']); ?></h1>
                    <p class="rest-type"><?php echo $rest['cuisine_type']; ?></p>
                    <p class="rest-desc"><?php echo htmlspecialchars($rest['description']); ?></p>
                </div>
            </div>

            <!-- search bar to filter menu items -->
            <div style="padding: 20px; text-align: center;">
                <div class="searchbox" style="margin: 0 auto; max-width: 600px;">
            <input type="text" id="searchBox" placeholder="Search in menu..."
                        class="searchinput" onkeyup="filterFood()">
                </div>
            </div>

        <div class="heading-row menu-heading">
                <h3 class="menu-title">Recommended Dishes</h3>
            </div>

            <!-- menu items grid -->
            <div class="grid">
                <?php if (empty($menuList)): ?>
            <div class="no-items">
                    <p>No menu items found for this restaurant.</p>
                </div>
                <?php
else: ?>
            <?php
    // group items by category with headers
    $currentCat = "";
    foreach ($menuList as $item):
        // show category header when category changes
        if ($currentCat != $item['category_name']):
            $currentCat = $item['category_name'];
?>
                <div class="cat-label">
                    <h2 class="cat-name"><?php echo $currentCat; ?></h2>
                </div>
                <?php
        endif; ?>

                <div class="card">
                <div class="imgbox food-img">
                        <?php if ($item['image_url']): ?>
                        <img src="<?php echo $item['image_url']; ?>"
                            alt="<?php echo $item['item_name']; ?>">
                        <?php
        endif; ?>
                    </div>
                    <div class="info">
                        <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                    <div class="tag">NEW</div>
                        <p class="desc food-desc">
                        <?php echo htmlspecialchars($item['description'] ?? 'A favorite among students for its authentic taste.'); ?>
                        </p>
                        <div class="price-area food-price">
                            <span class="price">₹ <?php echo number_format($item['price'], 0); ?></span>
                        </div>
                    </div>
                <button class="plusbtn food-addbtn"
                        onclick="addToCart('<?php echo addslashes($item['item_name']); ?>', <?php echo $item['price']; ?>)">+</button>
                </div>
                <?php
    endforeach; ?>
            <?php
endif; ?>
            </div>
        </main>

</div>

    <script src="js/script.js"></script>
    <script>
    // search/filter function for menu items
    // ayush wrote this - it hides cards that dont match the search text
function filterFood() {
        var searchText = document.getElementById('searchBox').value.toLowerCase();
    console.log("searching: " + searchText);

        var allCards = document.querySelectorAll('.card');

        allCards.forEach(function(card) {
            var name = card.querySelector('h4');
        var descEl = card.querySelector('.food-desc');

            // skip if elements not found (category headers dont have h4)
            if (!name) return;

        var nameText = name.innerText.toLowerCase();
            var descText = descEl ? descEl.innerText.toLowerCase() : "";

            console.log("checking: " + nameText);

        if (nameText.includes(searchText) || descText.includes(searchText)) {
                card.style.display = "flex";
            } else {
                card.style.display = "none";
        }
        });

        // also hide/show category headers based on visible cards
    var catHeaders = document.querySelectorAll('.cat-label');
        catHeaders.forEach(function(header) {
            var nextEl = header.nextElementSibling;
            var anyVisible = false;
        while (nextEl && nextEl.classList.contains('card')) {
                if (nextEl.style.display !== 'none') {
                    anyVisible = true;
                    break;
            }
                nextEl = nextEl.nextElementSibling;
            }
            header.style.display = anyVisible ? "block" : "none";
    });
    }
    </script>
</body>

</html>