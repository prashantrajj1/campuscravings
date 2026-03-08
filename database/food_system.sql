CREATE DATABASE IF NOT EXISTS food_system;
USE food_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS food_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(150) NOT NULL,
    customer_email VARCHAR(150) NOT NULL,
    food_details TEXT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample food items
INSERT INTO food_items (name, description, price, image_url) VALUES 
('Classic Burger', 'Juicy beef patty with fresh lettuce and tomatoes.', 150.00, 'images/burger.jpg'),
('Margherita Pizza', 'Wood-fired crust with fresh basil and mozzarella.', 350.00, 'images/pizza.jpg'),
('Green Salad', 'Fresh seasonal greens with a light vinaigrette.', 120.00, 'images/salad.jpg')
ON DUPLICATE KEY UPDATE name=name;
