-- CampusCravings Complete Database Schema & Data

CREATE DATABASE IF NOT EXISTS campuscravings;
USE campuscravings;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    course VARCHAR(100),
    rollno VARCHAR(50),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Restaurants Table
CREATE TABLE IF NOT EXISTS restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    cuisine_type VARCHAR(50),
    rating DECIMAL(2,1),
    image_url VARCHAR(255),
    is_open BOOLEAN DEFAULT TRUE,
    location VARCHAR(100)
);

-- 3. Menu Categories Table
CREATE TABLE IF NOT EXISTS menu_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

-- 4. Menu Items Table
CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT,
    category_id INT,
    item_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    availability BOOLEAN DEFAULT TRUE,
    description TEXT,
    image_url VARCHAR(255),
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES menu_categories(id) ON DELETE CASCADE
);

-- 5. Orders & Complaints (Module III/IV/V Concepts)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'Preparing', 'Out for Delivery', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_id INT,
    subject VARCHAR(255),
    message TEXT,
    status ENUM('Open', 'Resolved') DEFAULT 'Open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- DATA INSERTION

-- Insert Restaurant: Green Salad
INSERT INTO restaurants (id, name, description, cuisine_type, rating, image_url, is_open, location) VALUES 
(1, 'Green Salad', 'Fresh, healthy, and a massive variety of campus favorites.', 'Indian & Chinese', 4.7, 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=400', 1, 'Near Hostel Gate 1');

-- Insert Categories
INSERT INTO menu_categories (id, category_name) VALUES 
(1, 'Indian Thali'), (2, 'Rice'), (3, 'Dal'), (4, 'Veg'), (5, 'Tandoor'), 
(6, 'Rolls'), (7, 'Chinese Combo'), (8, 'Chicken'), (9, 'Fish'), (10, 'Mutton'), 
(11, 'Biryani'), (12, 'Soup'), (13, 'Snacks'), (14, 'Salad'), (15, 'Paneer'), 
(16, 'Chicken Curry'), (17, 'Noodles'), (18, 'Chinese Veg'), (19, 'Chinese Chicken'), 
(20, 'Starters'), (21, 'Momos');

-- Insert Menu Items for Green Salad (Restaurant ID 1)
INSERT INTO menu_items (restaurant_id, category_id, item_name, price) VALUES 
-- Indian Thali (Cat 1)
(1, 1, 'Veg Normal Thali', 70), (1, 1, 'Fish Thali', 70), (1, 1, 'Egg Thali', 70), (1, 1, 'Paneer Thali', 100), (1, 1, 'Mushroom Thali', 100), (1, 1, 'Chicken Thali', 110), (1, 1, 'Mutton Thali', 220),
-- Rice (Cat 2)
(1, 2, 'Plain Rice', 25), (1, 2, 'Jeera Rice', 60), (1, 2, 'Peas Palau', 100), (1, 2, 'Veg Palau', 100), (1, 2, 'Veg Fried Rice', 60), (1, 2, 'Chicken Fried Rice', 80), (1, 2, 'Egg Fried Rice', 70), (1, 2, 'Mixed Fried Rice', 100),
-- Dal (Cat 3)
(1, 3, 'Dal Fry', 50), (1, 3, 'Dal Tadka', 50), (1, 3, 'Dal Makhani', 70), (1, 3, 'Chana Masala', 70), (1, 3, 'Egg Tadka', 60), (1, 3, 'Double Egg Tadka', 70), (1, 3, 'Egg Chicken Tadka', 90),
-- Veg (Cat 4)
(1, 4, 'Mix Veg', 60), (1, 4, 'Veg Korma', 80), (1, 4, 'Veg Dopiaza', 70), (1, 4, 'Veg Jhal Fry', 70), (1, 4, 'Aloo Mattar', 60), (1, 4, 'Aloo Capsicum', 60), (1, 4, 'Corn Methi Malai', 100), (1, 4, 'Mushroom Chatpata', 100), (1, 4, 'Methi Aloo', 60), (1, 4, 'Jeera Aloo', 60), (1, 4, 'Aloo Kobi', 60),
-- Tandoor (Cat 5)
(1, 5, 'Roti', 6), (1, 5, 'Plain Naan', 15), (1, 5, 'Butter Naan', 40), (1, 5, 'Kashmiri Kulcha', 60), (1, 5, 'Masala Kulcha', 40), (1, 5, 'Paneer Kulcha', 60), (1, 5, 'Chicken Tandoor (1 pc)', 100), (1, 5, 'Chicken Tikka (5 pc)', 90), (1, 5, 'Plain Parota', 15), (1, 5, 'Lacha Parota', 25), (1, 5, 'Egg Paratha', 40),
-- Rolls (Cat 6)
(1, 6, 'Egg Roll', 45), (1, 6, 'E.C Roll', 50), (1, 6, 'D.E.C Roll', 60), (1, 6, 'Veg Roll Normal', 40), (1, 6, 'Veg Paneer Roll', 60), (1, 6, 'Paneer Tikka Roll', 70), (1, 6, 'Chicken Tikka Roll', 80), (1, 6, 'Bahubali Roll', 150), (1, 6, 'Shawarma Roll', 60),
-- Biryani (Cat 11)
(1, 11, 'Mutton Biryani', 220), (1, 11, 'Chicken Biryani', 110), (1, 11, 'Veg Biryani', 80), (1, 11, 'Egg Biryani', 80),
-- Paneer (Cat 15)
(1, 15, 'Shahi Paneer', 110), (1, 15, 'Paneer Butter Masala', 100), (1, 15, 'Matter Paneer', 100), (1, 15, 'Paneer Tikka Masala', 120), (1, 15, 'Mushroom Masala', 100),
-- Chicken Curry (Cat 16)
(1, 16, 'Chicken Butter Masala', 100), (1, 16, 'Chicken Curry', 80), (1, 16, 'Chicken Bharta', 120), (1, 16, 'Chicken Kasa', 90),
-- Noodles (Cat 17)
(1, 17, 'Veg Noodles', 40), (1, 17, 'Egg Noodles', 50), (1, 17, 'Chicken Noodles', 60), (1, 17, 'Mix Noodles', 70),
-- Chinese Veg (Cat 18)
(1, 18, 'Veg Manchurian', 60), (1, 18, 'Chilly Paneer', 100), (1, 18, 'Chilly Mushroom', 100),
-- Chinese Chicken (Cat 19)
(1, 19, 'Chilly Chicken', 100), (1, 19, 'Garlic Chicken', 100), (1, 19, 'Lemon Chicken', 100),
-- Starters (Cat 20)
(1, 20, 'Fish Fry (2 pc)', 100), (1, 20, 'Fish Finger (6 pc)', 100), (1, 20, 'Chicken Cutlet (1 pc)', 100),
-- Momos (Cat 21)
(1, 21, 'Steam Momos', 50), (1, 21, 'Fry Momos', 70);
