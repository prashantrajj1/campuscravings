<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'php/db_connect.php';

$res_id = isset($_GET['id']) ? (int)mysqli_real_escape_string($conn, $_GET['id']) : 1; 

$stmt_query = "SELECT * FROM restaurants WHERE id = '$res_id'";
$stmt_result = mysqli_query($conn, $stmt_query);
$restaurant = mysqli_fetch_assoc($stmt_result);

if (!$restaurant) {
    die("Restaurant not found in database.");
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
    <title>Menu - <?php echo $restaurant['name']; ?></title>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>

<table width="100%" cellpadding="20" class="header-table">
    <tr>
        <td width="30%">
            <a href="home.php" class="logo-text">Campus<span>Cravings</span></a>
        </td>
        <td width="40%" align="center">
            <a href="home.php" class="nav-link">Home</a>
            <a href="explore.php" class="nav-link">Explore</a>
            <a href="checkout.php" class="nav-link">Cart</a>
        </td>
        <td width="30%" align="right">
            <a href="profile.php" class="nav-link">Account</a>
        </td>
    </tr>
</table>

<div class="layout-container">

    <div class="search-container">
        <input type="text" id="searchInput" class="search-bar" placeholder="Search in <?php echo $restaurant['name']; ?>..." onkeyup="searchMenu()">
    </div>

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
        <tr class="category-header" data-category="<?php echo $current_cat; ?>">
            <td colspan="4"><h2><?php echo $current_cat; ?></h2></td>
        </tr>
        <tr>
        <?php endif; 
            if ($count > 0 && $count % 4 == 0) echo "</tr><tr>";
        ?>
            <td width="25%" align="center" valign="top" class="product-card" data-name="<?php echo strtolower($item['item_name']); ?>">
                <div class="product-cell">
                    <?php if ($item['image_url']): ?>
                        <img src="<?php echo $item['image_url']; ?>" width="100%" height="150" class="product-img">
                    <?php else: ?>
                        <div style="height: 150px; background-color: #e9ecee;"></div>
                    <?php endif; ?>
                    <h4 class="product-title"><?php echo htmlspecialchars($item['item_name']); ?></h4>
                    <span class="badge">MENU</span>
                    <p class="product-desc">Delicious <?php echo strtolower($item['item_name']); ?> prepared fresh.</p>
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

    <div id="noResults" class="hidden" style="text-align: center; color: #686b78; padding: 80px 20px;">
        <h3>Dish not found</h3>
        <p>We couldn't find any items matching your search. Try something else!</p>
    </div>

    <!-- Dynamic Cart Counter -->
    <a href="checkout.php" style="text-decoration: none;">
        <div id="floatingCart" class="cart-count" style="display: none;">
            <span id="cartNumber">0</span> ITEMS - VIEW CART
        </div>
    </a>

    <br><br>
</div>

<script src="js/script.js"></script>
<script>
    function searchMenu() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const cards = document.getElementsByClassName('product-card');
        const headers = document.getElementsByClassName('category-header');
        let hasVisibleCards = false;

        for (let i = 0; i < cards.length; i++) {
            const name = cards[i].getAttribute('data-name');
            if (name.includes(filter)) {
                cards[i].classList.remove('hidden');
                hasVisibleCards = true;
            } else {
                cards[i].classList.add('hidden');
            }
        }

        for (let j = 0; j < headers.length; j++) {
            let categoryName = headers[j].getAttribute('data-category').toLowerCase();
            let nextElement = headers[j].nextElementSibling;
            let foundMatch = false;
            
            while (nextElement && !nextElement.classList.contains('category-header')) {
                let cells = nextElement.getElementsByClassName('product-card');
                for (let k = 0; k < cells.length; k++) {
                    if (!cells[k].classList.contains('hidden')) {
                        foundMatch = true;
                        break;
                    }
                }
                if (foundMatch) break;
                nextElement = nextElement.nextElementSibling;
            }
            
            if (foundMatch) {
                headers[j].classList.remove('hidden');
            } else {
                headers[j].classList.add('hidden');
            }
        }

        const noResults = document.getElementById('noResults');
        if (!hasVisibleCards && filter !== "") {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }

    function updateFloatingCart() {
        const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
        const floatingCart = document.getElementById('floatingCart');
        const cartNumber = document.getElementById('cartNumber');
        
        if (cartItems.length > 0) {
            floatingCart.style.display = 'block';
            cartNumber.innerText = cartItems.length;
        } else {
            floatingCart.style.display = 'none';
        }
    }

    const originalAddToCart = window.addToCart;
    window.addToCart = function(name, price) {
        originalAddToCart(name, price);
        updateFloatingCart();
    };

    document.addEventListener("DOMContentLoaded", updateFloatingCart);
</script>
</body>
</html>
