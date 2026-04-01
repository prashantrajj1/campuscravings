// campuscravings cart + utility functions
// by ayush - handles adding items and loading cart
// using localStorage since we dont have backend cart (yet)

var cart = [];

console.log("script.js loaded!!");
console.log("page: " + window.location.pathname);

// adds a food item to cart (called when + button is clicked)
function addToCart(name, price) {
console.log("adding to cart: " + name);
    cart = JSON.parse(localStorage.getItem("cart")) || [];
        cart.push({ name, price });
    localStorage.setItem("cart", JSON.stringify(cart));
    console.log("cart now has " + cart.length + " items");
    console.log(cart); // check cart contents
    alert(name + " added to cart!");
}

// loads cart items on the checkout page
function loadCart() {
    console.log("loading cart from localStorage...");
cart = JSON.parse(localStorage.getItem("cart")) || [];
    var list = document.getElementById("cart-items");
var total = 0;

    console.log("found " + cart.length + " items in cart");

    cart.forEach(function(item) {
        var li = document.createElement("li");
    li.innerText = item.name + " - ₹" + item.price;
        list.appendChild(li);
total += item.price;
        console.log("  loaded: " + item.name + " ₹" + item.price);
    });

    document.getElementById("total").innerText = "Total: ₹" + total;
    console.log("total bill = ₹" + total);
}

// run loadCart if we're on the checkout page
if (document.getElementById("cart-items")) {
console.log("on checkout page - loading cart");
    loadCart();
}

// cookie helper - used for checking auth on static pages
// prashant found this on stackoverflow
function getCookie(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) {
    console.log("found cookie: " + name + " = " + match[2]);
        return match[2];
    }
console.log("cookie '" + name + "' not found");
    return null;
}

// page load - check if auth is needed
document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM ready");
    console.log("url: " + window.location.href);
    console.log("time: " + new Date().toLocaleString());

// these pages need login
var needsAuth = window.location.pathname.includes('home.html') || window.location.pathname.includes('cart.html');
    var authCookie = getCookie('user_auth');

    console.log("needs auth: " + needsAuth);
    console.log("has auth: " + (authCookie !== null));

    if (needsAuth && !authCookie) {
        console.log("not logged in! redirecting to login...");
        window.location.href = 'index.html';
    }
});