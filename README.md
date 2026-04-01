# 🍴 CampusCravings

A campus food ordering web application built for **XIM University, Bhubaneswar** as a DBMS Lab Project.

Students can browse restaurants near campus, view menus, add items to cart, and place orders — all from one place.

---

## 👥 Team

- **Prashant Raj** 
- **Ayush Jha**

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP (Procedural) |
| Database | MySQL (via mysqli) |
| Server | XAMPP / Apache |

No frameworks used — everything is hand-coded from scratch.

---

## 📁 Project Structure

```
campuscravings/
├── index.html              # Landing / splash page
├── login.php               # Login page
├── register.php            # Registration page
├── logout.php              # Logout (clears session)
├── home.php                # Main dashboard with food items & restaurants
├── explore.php             # Browse all restaurants
├── restaurant_details.php  # Restaurant menu page
├── menu.php                # Full menu view
├── checkout.php            # Cart / order summary
├── payment.php             # QR payment & order confirmation
├── profile.php             # User profile, order history & complaints
│
├── css/
│   ├── splash.css          # Landing page styles
│   ├── login.css           # Login & register page styles
│   ├── home.css            # Main stylesheet (shared across pages)
│   ├── explore.css         # Explore page extras
│   ├── restaurant_details.css  # Restaurant page extras
│   ├── menu.css            # Menu page extras
│   ├── profile.css         # Profile page styles
│   ├── checkout.css        # Checkout page styles
│   └── payment.css         # Payment page styles
│
├── js/
│   └── script.js           # Cart logic, utility functions
│
├── php/
│   ├── db_connect.php      # Database connection
│   ├── submit_complaint.php    # Complaint form handler
│   ├── update_pfp.php      # Profile picture upload
│   ├── add_food.php        # Add menu items (admin)
│   └── view_orders.php     # View orders (admin)
│
├── database/
│   └── campuscravings.sql  # Full database dump (importable)
│
└── assets/
    ├── food/               # Food item images
    ├── pfp/                # User profile pictures
    └── restaurants/        # Restaurant images
```

---

## ⚙️ Setup Instructions

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) installed (Apache + MySQL + PHP)

### Steps

1. **Clone the repo** into your XAMPP htdocs folder:
   ```bash
   cd /path/to/xampp/htdocs/
   git clone https://github.com/prashantrajj1/campuscravings.git
   ```

2. **Start XAMPP** — run Apache and MySQL from the XAMPP control panel.

3. **Import the database:**
   - Open [phpMyAdmin](http://localhost/phpmyadmin)
   - Click **Import** tab
   - Select `database/campuscravings.sql`
   - Click **Go**
   
   This will automatically create the `campuscravings` database with all tables and sample data.

4. **Open the app** in your browser:
   ```
   http://localhost/campuscravings/
   ```

5. **Login** with the test account or register a new one:
   
   | Role | Email | Password |
   |------|-------|----------|
   | Student | `ucse24017@stu.xim.edu.in` | *(registered password)* |
   | Admin | `admin@campuscravings.com` | `password` |

---

## 🗄 Database Schema

The app uses **6 tables**:

| Table | Purpose |
|-------|---------|
| `users` | Student/restaurant owner/admin accounts |
| `restaurants` | Restaurant info (name, cuisine, location, image) |
| `menu_categories` | Food categories (Indian Thali, Rice, Biryani, etc.) |
| `menu_items` | Individual food items with prices |
| `orders` | Order records with status tracking |
| `complaints` | Student complaints linked to orders |

**ER Relationships:**
- `users` → `orders` (one to many)
- `restaurants` → `menu_items` (one to many)
- `menu_categories` → `menu_items` (one to many)
- `orders` → `complaints` (one to many)

---

## ✨ Features

- 🔐 **User Authentication** — Register, login, logout with password hashing
- 🏪 **Browse Restaurants** — View all campus restaurants with images
- 🍛 **View Menus** — Full menu with category filters and search
- 🛒 **Cart System** — Add items to cart (localStorage based)
- 💳 **Checkout & Payment** — Order summary with QR code payment
- 👤 **User Profile** — View order history, upload profile picture
- 📝 **Complaint System** — Submit and track complaints against orders
- 📱 **Responsive Design** — Works on both desktop and mobile

---

## 📸 Screenshots

### Landing Page
The splash page with the CampusCravings branding and login button.

### Home Page  
Dashboard showing popular food items, category filters, and featured restaurants.

### Restaurant Menu
Detailed menu view with search functionality and add-to-cart buttons.

### Profile Page
User profile with order history table and complaint submission form.

---

## 📝 Notes

- Cart data is stored in the browser's `localStorage` (no backend cart table)
- Profile pictures are uploaded to `assets/pfp/` folder
- The QR code on the payment page is a placeholder — no real UPI integration yet
- All passwords are hashed using PHP's `password_hash()` with `PASSWORD_DEFAULT`

---

## 📄 License

This project was built as an academic project for XIM University. Feel free to use it as a reference.
