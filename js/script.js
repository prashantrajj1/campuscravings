let cart = [];

function addToCart(name, price) {
    cart.push({ name, price });
    localStorage.setItem("cart", JSON.stringify(cart));
    alert(name + " added to cart");
}

function loadCart() {
    cart = JSON.parse(localStorage.getItem("cart")) || [];
    let list = document.getElementById("cart-items");
    let total = 0;

    cart.forEach(item => {
        let li = document.createElement("li");
        li.innerText = item.name + " - ₹" + item.price;
        list.appendChild(li);
        total += item.price;
    });

    document.getElementById("total").innerText = "Total: ₹" + total;
}

if (document.getElementById("cart-items")) {
    loadCart();
}

// Authentication check for protected routes
function getCookie(name) {
    let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) {
        return match[2];
    }
    return null;
}

document.addEventListener("DOMContentLoaded", () => {
    const isProtectedPage = window.location.pathname.includes('home.html') || window.location.pathname.includes('cart.html');
    const authCookie = getCookie('user_auth');

    if (isProtectedPage && !authCookie) {
        window.location.href = 'index.html';
    }
});