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
(1, 'Green Salad', 'Fresh, healthy, and a massive variety of campus favorites.', 'Indian & Chinese', 4.7, 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=400', 1, 'Near Hostel Gate 1'),
(2, 'Adventures Cafe', 'A cozy spot for coffee, snacks, and gourmet campus bites.', 'Cafe & Continental', 4.5, 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=400', 1, 'Near Student Activity Center'),
(3, 'Shawarma Xpress-3', 'Authentic shawarma, biryani, and middle-eastern inspired fast food.', 'Arabic & Indian', 4.3, 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?q=80&w=400', 1, 'Food Court 2');

-- Insert Categories
INSERT INTO menu_categories (id, category_name) VALUES 
(1, 'Indian Thali'), (2, 'Rice'), (3, 'Dal'), (4, 'Veg'), (5, 'Tandoor'), 
(6, 'Rolls'), (7, 'Chinese Combo'), (8, 'Chicken'), (9, 'Fish'), (10, 'Mutton'), 
(11, 'Biryani'), (12, 'Soup'), (13, 'Snacks'), (14, 'Salad'), (15, 'Paneer'), 
(16, 'Chicken Curry'), (17, 'Noodles'), (18, 'Chinese Veg'), (19, 'Chinese Chicken'), 
(20, 'Starters'), (21, 'Momos'), (22, 'Smoothies & Shakes'), (23, 'Hot Coffee'), 
(24, 'Cold Coffee'), (25, 'Pasta'), (26, 'Pizza'), (27, 'Burgers'), 
(28, 'Sandwiches'), (29, 'Coolers'), (30, 'Shawarma');

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

-- Insert Menu Items for Adventures Cafe (Restaurant ID 2)
INSERT INTO menu_items (restaurant_id, category_id, item_name, price, image_url) VALUES 
-- Starters (Cat 20)
(2, 20, 'French Fries', 160, 'https://images.unsplash.com/photo-1630384066252-11e1edca07c9?q=80&w=400'),
(2, 20, 'Peri Peri French Fries', 180, 'https://images.unsplash.com/photo-1630384066252-11e1edca07c9?q=80&w=400'),
(2, 20, 'Crispy American Corn', 160, 'https://images.unsplash.com/photo-1546241072-48010ad2862c?q=80&w=400'),
(2, 20, 'Crispy Baby Corn', 180, 'https://images.unsplash.com/photo-1546241072-48010ad2862c?q=80&w=400'),
(2, 20, 'Babycorn Salt & Pepper', 180, 'https://images.unsplash.com/photo-1546241072-48010ad2862c?q=80&w=400'),
(2, 20, 'Babycorn Chilli', 180, 'https://images.unsplash.com/photo-1546241072-48010ad2862c?q=80&w=400'),
(2, 20, 'Mushroom Chilli', 180, 'https://images.unsplash.com/photo-1594950157572-851307397c23?q=80&w=400'),
(2, 20, 'Mushroom Popcorn', 190, 'https://images.unsplash.com/photo-1594950157572-851307397c23?q=80&w=400'),
(2, 20, 'Mushroom Salt & Pepper', 180, 'https://images.unsplash.com/photo-1594950157572-851307397c23?q=80&w=400'),
(2, 20, 'Mushroom Manchurian', 180, 'https://images.unsplash.com/photo-1594950157572-851307397c23?q=80&w=400'),
(2, 20, 'Paneer Chilli', 180, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(2, 20, 'Paneer Popcorn', 190, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(2, 20, 'Hot Garlic Paneer Popcorn', 210, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(2, 20, 'Paneer Manchurian', 180, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(2, 20, 'Paneer Pakora', 180, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(2, 20, 'Chicken Pakora', 180, 'https://images.unsplash.com/photo-1562967914-6cbb241c2a3d?q=80&w=400'),
(2, 20, 'Chicken Nuggets', 220, 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?q=80&w=400'),
(2, 20, 'Chilli Chicken', 180, 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=400'),
(2, 20, 'Honey Chilli Chicken', 199, 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=400'),
(2, 20, 'Chicken Popcorn', 190, 'https://images.unsplash.com/photo-1562967914-6cbb241c2a3d?q=80&w=400'),
(2, 20, 'Hot Garlic Chicken Popcorn', 210, 'https://images.unsplash.com/photo-1562967914-6cbb241c2a3d?q=80&w=400'),
(2, 20, 'Chicken 65', 180, 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?q=80&w=400'),
(2, 20, 'Dragon Chicken', 190, 'https://images.unsplash.com/photo-1562967914-6cbb241c2a3d?q=80&w=400'),
(2, 20, 'Chicken Majestic', 190, 'https://images.unsplash.com/photo-1562967914-6cbb241c2a3d?q=80&w=400'),
(2, 20, 'Hong Kong Chicken', 190, 'https://images.unsplash.com/photo-1562967914-6cbb241c2a3d?q=80&w=400'),
(2, 20, 'Chicken Kakara', 190, 'https://images.unsplash.com/photo-1562967914-6cbb241c2a3d?q=80&w=400'),
(2, 20, 'Hot Sauce Garlic Chicken', 190, 'https://images.unsplash.com/photo-1562967914-6cbb241c2a3d?q=80&w=400'),
-- Rice (Cat 2)
(2, 2, 'Veg Fried Rice', 120, 'https://images.unsplash.com/photo-1601050690597-df056fb4ce99?q=80&w=400'),
(2, 2, 'Mix Veg Fried Rice', 130, 'https://images.unsplash.com/photo-1601050690597-df056fb4ce99?q=80&w=400'),
(2, 2, 'Hong Kong Veg Rice', 140, 'https://images.unsplash.com/photo-1601050690597-df056fb4ce99?q=80&w=400'),
(2, 2, 'Schezwan Fried Rice', 150, 'https://images.unsplash.com/photo-1601050690597-df056fb4ce99?q=80&w=400'),
(2, 2, 'Chicken Fried Rice', 120, 'https://images.unsplash.com/photo-1601050690597-df056fb4ce99?q=80&w=400'),
(2, 2, 'Egg Chicken Fried Rice', 130, 'https://images.unsplash.com/photo-1601050690597-df056fb4ce99?q=80&w=400'),
(2, 2, 'Schezwan Chicken Fried Rice', 150, 'https://images.unsplash.com/photo-1601050690597-df056fb4ce99?q=80&w=400'),
(2, 2, 'Plain Rice', 80, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(2, 2, 'Jeera Rice', 99, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(2, 2, 'Ghee Rice', 110, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
-- Noodles (Cat 17)
(2, 17, 'Veg Hakka Noodles', 120, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(2, 17, 'Mix Veg Hakka Noodles', 130, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(2, 17, 'Schezwan Veg Noodles', 150, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(2, 17, 'Chicken Noodles', 120, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(2, 17, 'Egg Chicken Noodles', 130, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(2, 17, 'Schezwan Chicken Noodles', 150, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
-- Dal (Cat 3)
(2, 3, 'Dal Fry', 100, 'https://images.unsplash.com/photo-1546833998-877b37c2e5c6?q=80&w=400'),
(2, 3, 'Dal Tadka', 110, 'https://images.unsplash.com/photo-1546833998-877b37c2e5c6?q=80&w=400'),
-- Veg (Cat 4)
(2, 4, 'Mix Veg', 170, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(2, 4, 'Aloo Dum', 170, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(2, 4, 'Aloo Jeera', 170, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(2, 4, 'Chana Masala', 160, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(2, 4, 'Mushroom Masala', 180, 'https://images.unsplash.com/photo-1594950157572-851307397c23?q=80&w=400'),
(2, 4, 'Kadai Mushroom', 180, 'https://images.unsplash.com/photo-1594950157572-851307397c23?q=80&w=400'),
-- Paneer (Cat 15)
(2, 15, 'Paneer Masala', 180, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(2, 15, 'Paneer Butter Masala', 180, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(2, 15, 'Paneer Hyderabadi', 180, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(2, 15, 'Punjabi Paneer', 180, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(2, 15, 'Kadai Paneer', 180, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
-- Chicken Curry (Cat 16)
(2, 16, 'Chicken Bharta', 180, 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400'),
(2, 16, 'Chicken Curry', 180, 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400'),
(2, 16, 'Chicken Butter Masala', 190, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(2, 16, 'Kadai Chicken', 180, 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400'),
(2, 16, 'Chicken Hyderabadi', 180, 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400'),
(2, 16, 'Mughlai Chicken', 199, 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400'),
-- Tandoor (Cat 5)
(2, 5, 'Tawa Roti', 12, 'https://images.unsplash.com/photo-1588166524941-3bf61a9c41db?q=80&w=400'),
(2, 5, 'Butter Roti', 15, 'https://images.unsplash.com/photo-1588166524941-3bf61a9c41db?q=80&w=400'),
(2, 5, 'Plain Paratha', 25, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(2, 5, 'Laccha Paratha', 30, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(2, 5, 'Garlic Laccha Paratha', 40, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(2, 5, 'Aloo Paratha', 80, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(2, 5, 'Paneer Paratha', 120, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
-- Pasta (Cat 25)
(2, 25, 'White Sauce Pasta', 199, 'https://images.unsplash.com/photo-1473093226795-af9932fe5856?q=80&w=400'),
(2, 25, 'Red Sauce Pasta', 180, 'https://images.unsplash.com/photo-1473093226795-af9932fe5856?q=80&w=400'),
(2, 25, 'Indian Style Pasta', 180, 'https://images.unsplash.com/photo-1473093226795-af9932fe5856?q=80&w=400'),
(2, 25, 'Mac & Cheese', 199, 'https://images.unsplash.com/photo-1541745537411-b8046dc6d66c?q=80&w=400'),
-- Pizza (Cat 26)
(2, 26, 'Veg Classic Pizza', 160, 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=400'),
(2, 26, 'Paneer Loaded Pizza', 180, 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=400'),
(2, 26, 'Peri Peri Paneer Pizza', 199, 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=400'),
(2, 26, 'Mushroom Cheezy Pizza', 190, 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=400'),
(2, 26, 'Chicken Cheese Pizza', 199, 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=400'),
(2, 26, 'Peri Peri Chicken Pizza', 210, 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=400'),
-- Burgers (Cat 27)
(2, 27, 'Aloo Tikki Burger', 110, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=400'),
(2, 27, 'Veg Cheese Burger', 130, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=400'),
(2, 27, 'Crispy Paneer Burger', 160, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=400'),
(2, 27, 'Crispy Chicken Burger', 180, 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=400'),
-- Sandwiches (Cat 28)
(2, 28, 'Grilled Veg Mayo Sandwich', 140, 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?q=80&w=400'),
(2, 28, 'Peri Peri Paneer Sandwich', 150, 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?q=80&w=400'),
(2, 28, 'Cheezy Chicken Sandwich', 160, 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?q=80&w=400'),
(2, 28, 'Peri Peri Chicken Sandwich', 160, 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?q=80&w=400'),
-- Smoothies & Shakes (Cat 22)
(2, 22, 'Dry Fruit Milkshake', 140, 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=400'),
(2, 22, 'Oreo Milkshake', 130, 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=400'),
(2, 22, 'Chocolate Milkshake', 160, 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=400'),
(2, 22, 'Kitkat Milkshake', 150, 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=400'),
(2, 22, 'Apple Milkshake', 130, 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=400'),
(2, 22, 'Banana Milkshake', 130, 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=400'),
(2, 22, 'Strawberry Milkshake', 160, 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=400'),
(2, 22, 'Hot Chocolate', 120, 'https://images.unsplash.com/photo-1544787210-2213d44ad53e?q=80&w=400'),
-- Cold Coffee (Cat 24)
(2, 24, 'Cold Coffee', 99, 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=400'),
(2, 24, 'Cold Coffee (with Ice Cream)', 110, 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=400'),
-- Hot Coffee (Cat 23)
(2, 23, 'Hot Coffee', 60, 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=400'),
-- Coolers (Cat 29)
(2, 29, 'Tea', 40, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=400'),
(2, 29, 'Blue Lagoon', 99, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=400'),
(2, 29, 'Blueberry Lemon Fizz', 125, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=400'),
(2, 29, 'Blueberry Crush', 135, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=400'),
(2, 29, 'Virgin Mojito', 99, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=400'),
(2, 29, 'Lemonade Fizz', 89, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=400'),
(2, 29, 'Masala Cold Drink', 40, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=400');

-- Insert Menu Items for Shawarma Xpress-3 (Restaurant ID 3)
INSERT INTO menu_items (restaurant_id, category_id, item_name, price, image_url) VALUES 
-- Soup (Cat 12)
(3, 12, 'Hot & Sour Soup (Veg)', 50, 'https://images.unsplash.com/photo-1547592166-23ac45744acd?q=80&w=400'),
(3, 12, 'Manchow Soup (Veg)', 60, 'https://images.unsplash.com/photo-1547592166-23ac45744acd?q=80&w=400'),
(3, 12, 'Lemon Coriander Soup', 70, 'https://images.unsplash.com/photo-1547592166-23ac45744acd?q=80&w=400'),
(3, 12, 'Chicken Clear Soup', 60, 'https://images.unsplash.com/photo-1547592166-23ac45744acd?q=80&w=400'),
(3, 12, 'Chicken Hot & Sour Soup', 70, 'https://images.unsplash.com/photo-1547592166-23ac45744acd?q=80&w=400'),
(3, 12, 'Chicken Manchow Soup', 80, 'https://images.unsplash.com/photo-1547592166-23ac45744acd?q=80&w=400'),
-- Starters (Cat 20)
(3, 20, 'Corn Corn', 110, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Mushroom 65', 140, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Paneer Chilli', 150, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Mushroom Chilli', 150, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Mushroom Manchurian', 150, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Paneer Manchurian', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Paneer Tikka', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Paneer Malai Tikka', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Paneer Achari Tikka', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Paneer 65', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Egg Omelette', 40, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Chicken Pakoda', 120, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Chicken Salt & Pepper', 120, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Schezwan Chicken', 130, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Chicken Lollipop', 150, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Dragon Chicken', 150, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Chicken Manchurian', 150, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Chicken 65', 150, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Chicken Tikka', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Garlic Chicken', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Kalmi Kabab (2 Pc)', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Murga Achari Tikka', 160, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Fish Tikka', 200, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Chilli Prawns', 230, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Tandoori Chicken (Half)', 130, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
(3, 20, 'Grill Chicken (Half)', 130, 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=400'),
-- Noodles (Cat 17)
(3, 17, 'Veg Hakka Noodles', 60, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Schezwan Veg Noodles', 80, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Egg Noodles', 80, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Mushroom Noodles', 80, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Veg Shanghai Noodles', 80, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Paneer Noodles', 90, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Mix Veg Noodles', 100, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Egg Chicken Noodles', 100, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Schezwan Chicken Noodles', 120, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Mix Non-Veg Noodles', 120, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
(3, 17, 'Non Veg Shanghai Noodles', 120, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=400'),
-- Shawarma (Cat 30)
(3, 30, 'Shawarma Plate', 130, 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?q=80&w=400'),
(3, 30, 'Shawarma Salad', 110, 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?q=80&w=400'),
(3, 30, 'Special Shawarma Roll', 110, 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?q=80&w=400'),
(3, 30, 'Peri Peri Shawarma Roll', 100, 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?q=80&w=400'),
(3, 30, 'Schezwan Shawarma Roll', 100, 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?q=80&w=400'),
(3, 30, 'Regular Shawarma Roll', 80, 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?q=80&w=400'),
-- Rolls (Cat 6)
(3, 6, 'Egg Roll', 60, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 6, 'Egg Chicken Roll', 70, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 6, 'Mushroom Roll', 70, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 6, 'Paneer Roll', 70, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 6, 'Double Egg Chicken Roll', 90, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 6, 'Chilly Mushroom Roll', 90, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 6, 'Chilly Paneer Roll', 90, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 6, 'Mix Veg Roll', 100, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
-- Biryani (Cat 11)
(3, 11, 'Egg Biryani', 90, 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?q=80&w=400'),
(3, 11, 'Mix Veg Biryani', 100, 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?q=80&w=400'),
(3, 11, 'Hyderabadi Chicken Dum Biryani (Half)', 120, 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?q=80&w=400'),
(3, 11, 'Hyderabadi Chicken Dum Biryani (Full)', 160, 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?q=80&w=400'),
(3, 11, 'Mutton Biryani', 230, 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?q=80&w=400'),
-- Rice (Cat 2)
(3, 2, 'Egg Chicken Fried Rice', 130, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Chicken Schezwan Fried Rice', 130, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Hong Kong Chicken Fried Rice', 120, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Hong Kong Veg Fried Rice', 120, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Veg Schezwan Fried Rice', 120, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Mix Veg Fried Rice', 100, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Egg Fried Rice', 80, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Jeera Rice', 70, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Curd Rice', 70, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Lemon Rice', 70, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
(3, 2, 'Plain Rice', 50, 'https://images.unsplash.com/photo-1516684732162-798a0062be99?q=80&w=400'),
-- Veg (Cat 4)
(3, 4, 'Dal Fry', 80, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Veg Dal Tadka', 90, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Chana Masala', 90, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Veg Kadhai', 110, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Aloo Matar', 110, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Veg Kolhapure', 120, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Mushroom Hyderabadi', 150, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Mushroom Dopyaza', 150, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Paneer Dopyaza', 150, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Paneer Hyderabadi', 150, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Paneer Bhurji', 160, 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=400'),
(3, 4, 'Paneer Butter Masala', 160, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
-- Chicken Curry (Cat 16)
(3, 16, 'Egg Bhurji', 50, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Egg Masala', 80, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Egg Tadka', 80, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Fish Masala', 90, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Kasa', 110, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Masala', 150, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Hyderabadi', 150, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Kolhapure', 150, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Korma', 150, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Mughlai', 160, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Lababdar', 160, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Chettinad', 160, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Kadhai Chicken', 160, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Butter Masala', 170, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Tikka Masala', 170, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Bharta', 170, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Tandoori Chicken Masala', 180, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Chicken Patiala', 180, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Mutton Rogan Josh', 230, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Mutton Curry', 250, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
(3, 16, 'Prawns Masala', 250, 'https://images.unsplash.com/photo-1603894584104-18e3c1d4715f?q=80&w=400'),
-- Tandoor (Cat 5)
(3, 5, 'Keema Naan', 60, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Masala Naan', 40, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Masala Kulcha', 30, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Garlic Naan', 30, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Butter Naan', 25, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Rumali Roti', 25, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Plain Naan', 20, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Plain Kulcha', 20, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Laccha Paratha', 20, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
(3, 5, 'Chapati', 10, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=400'),
-- Coolers (Cat 29)
(3, 29, 'Water Bottle', 25, 'https://images.unsplash.com/photo-1544145945-89617d69288e?q=80&w=400'),
(3, 29, 'Masala Cold Drink', 40, 'https://images.unsplash.com/photo-1544145945-89617d69288e?q=80&w=400');
