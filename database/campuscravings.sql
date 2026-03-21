-- This file was exported from phpmyadmin
--this doesnt have create database query, adding it

CREATE DATABASE campuscravings;
USE campuscravings;


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 21, 2026 at 12:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campuscravings`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('Open','Resolved') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `order_id`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 3, 5, 'my order is not delivered yet ??', 'what the hell !???', 'Open', '2026-03-21 11:36:51');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `category_name`) VALUES
(1, 'Indian Thali'),
(2, 'Rice'),
(3, 'Dal'),
(4, 'Veg'),
(5, 'Tandoor'),
(6, 'Rolls'),
(7, 'Chinese Combo'),
(8, 'Chicken'),
(9, 'Fish'),
(10, 'Mutton'),
(11, 'Biryani'),
(12, 'Soup'),
(13, 'Snacks'),
(14, 'Salad'),
(15, 'Paneer'),
(16, 'Chicken Curry'),
(17, 'Noodles'),
(18, 'Chinese Veg'),
(19, 'Chinese Chicken'),
(20, 'Starters'),
(21, 'Momos'),
(22, 'Shawarma'),
(23, 'Coolers'),
(24, 'Pasta'),
(25, 'Pizza'),
(26, 'Burgers'),
(27, 'Sandwiches'),
(28, 'Smoothies & Shakes'),
(29, 'Cold Coffee'),
(30, 'Hot Coffee');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `availability` tinyint(1) DEFAULT 1,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `restaurant_id`, `category_id`, `item_name`, `price`, `availability`, `description`, `image_url`) VALUES
(1, 1, 1, 'Veg Normal Thali', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(2, 1, 1, 'Fish Thali', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(3, 1, 1, 'Egg Thali', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(4, 1, 1, 'Paneer Thali', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(5, 1, 1, 'Mushroom Thali', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(6, 1, 1, 'Chicken Thali', 110.00, 1, NULL, 'assets/food/sandwich.jpg'),
(7, 1, 1, 'Mutton Thali', 220.00, 1, NULL, 'assets/food/sandwich.jpg'),
(8, 1, 2, 'Plain Rice', 25.00, 1, NULL, 'assets/food/sandwich.jpg'),
(9, 1, 2, 'Jeera Rice', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(10, 1, 2, 'Peas Palau', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(11, 1, 2, 'Veg Palau', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(12, 1, 2, 'Veg Fried Rice', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(13, 1, 2, 'Chicken Fried Rice', 80.00, 1, NULL, 'assets/food/sandwich.jpg'),
(14, 1, 2, 'Egg Fried Rice', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(15, 1, 2, 'Mixed Fried Rice', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(16, 1, 3, 'Dal Fry', 50.00, 1, NULL, 'assets/food/sandwich.jpg'),
(17, 1, 3, 'Dal Tadka', 50.00, 1, NULL, 'assets/food/sandwich.jpg'),
(18, 1, 3, 'Dal Makhani', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(19, 1, 3, 'Chana Masala', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(20, 1, 3, 'Egg Tadka', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(21, 1, 3, 'Double Egg Tadka', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(22, 1, 3, 'Egg Chicken Tadka', 90.00, 1, NULL, 'assets/food/sandwich.jpg'),
(23, 1, 4, 'Mix Veg', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(24, 1, 4, 'Veg Korma', 80.00, 1, NULL, 'assets/food/sandwich.jpg'),
(25, 1, 4, 'Veg Dopiaza', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(26, 1, 4, 'Veg Jhal Fry', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(27, 1, 4, 'Aloo Mattar', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(28, 1, 4, 'Aloo Capsicum', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(29, 1, 4, 'Corn Methi Malai', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(30, 1, 4, 'Mushroom Chatpata', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(31, 1, 4, 'Methi Aloo', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(32, 1, 4, 'Jeera Aloo', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(33, 1, 4, 'Aloo Kobi', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(34, 1, 5, 'Roti', 6.00, 1, NULL, 'assets/food/sandwich.jpg'),
(35, 1, 5, 'Plain Naan', 15.00, 1, NULL, 'assets/food/sandwich.jpg'),
(36, 1, 5, 'Butter Naan', 40.00, 1, NULL, 'assets/food/sandwich.jpg'),
(37, 1, 5, 'Kashmiri Kulcha', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(38, 1, 5, 'Masala Kulcha', 40.00, 1, NULL, 'assets/food/sandwich.jpg'),
(39, 1, 5, 'Paneer Kulcha', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(40, 1, 5, 'Chicken Tandoor (1 pc)', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(41, 1, 5, 'Chicken Tikka (5 pc)', 90.00, 1, NULL, 'assets/food/sandwich.jpg'),
(42, 1, 5, 'Plain Parota', 15.00, 1, NULL, 'assets/food/sandwich.jpg'),
(43, 1, 5, 'Lacha Parota', 25.00, 1, NULL, 'assets/food/sandwich.jpg'),
(44, 1, 5, 'Egg Paratha', 40.00, 1, NULL, 'assets/food/sandwich.jpg'),
(45, 1, 6, 'Egg Roll', 45.00, 1, NULL, 'assets/food/sandwich.jpg'),
(46, 1, 6, 'E.C Roll', 50.00, 1, NULL, 'assets/food/sandwich.jpg'),
(47, 1, 6, 'D.E.C Roll', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(48, 1, 6, 'Veg Roll Normal', 40.00, 1, NULL, 'assets/food/sandwich.jpg'),
(49, 1, 6, 'Veg Paneer Roll', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(50, 1, 6, 'Paneer Tikka Roll', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(51, 1, 6, 'Chicken Tikka Roll', 80.00, 1, NULL, 'assets/food/sandwich.jpg'),
(52, 1, 6, 'Bahubali Roll', 150.00, 1, NULL, 'assets/food/sandwich.jpg'),
(53, 1, 6, 'Shawarma Roll', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(54, 1, 11, 'Mutton Biryani', 220.00, 1, NULL, 'assets/food/sandwich.jpg'),
(55, 1, 11, 'Chicken Biryani', 110.00, 1, NULL, 'assets/food/sandwich.jpg'),
(56, 1, 11, 'Veg Biryani', 80.00, 1, NULL, 'assets/food/sandwich.jpg'),
(57, 1, 11, 'Egg Biryani', 80.00, 1, NULL, 'assets/food/sandwich.jpg'),
(58, 1, 15, 'Shahi Paneer', 110.00, 1, NULL, 'assets/food/sandwich.jpg'),
(59, 1, 15, 'Paneer Butter Masala', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(60, 1, 15, 'Matter Paneer', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(61, 1, 15, 'Paneer Tikka Masala', 120.00, 1, NULL, 'assets/food/sandwich.jpg'),
(62, 1, 15, 'Mushroom Masala', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(63, 1, 16, 'Chicken Butter Masala', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(64, 1, 16, 'Chicken Curry', 80.00, 1, NULL, 'assets/food/sandwich.jpg'),
(65, 1, 16, 'Chicken Bharta', 120.00, 1, NULL, 'assets/food/sandwich.jpg'),
(66, 1, 16, 'Chicken Kasa', 90.00, 1, NULL, 'assets/food/sandwich.jpg'),
(67, 1, 17, 'Veg Noodles', 40.00, 1, NULL, 'assets/food/sandwich.jpg'),
(68, 1, 17, 'Egg Noodles', 50.00, 1, NULL, 'assets/food/sandwich.jpg'),
(69, 1, 17, 'Chicken Noodles', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(70, 1, 17, 'Mix Noodles', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(71, 1, 18, 'Veg Manchurian', 60.00, 1, NULL, 'assets/food/sandwich.jpg'),
(72, 1, 18, 'Chilly Paneer', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(73, 1, 18, 'Chilly Mushroom', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(74, 1, 19, 'Chilly Chicken', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(75, 1, 19, 'Garlic Chicken', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(76, 1, 19, 'Lemon Chicken', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(77, 1, 20, 'Fish Fry (2 pc)', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(78, 1, 20, 'Fish Finger (6 pc)', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(79, 1, 20, 'Chicken Cutlet (1 pc)', 100.00, 1, NULL, 'assets/food/sandwich.jpg'),
(80, 1, 21, 'Steam Momos', 50.00, 1, NULL, 'assets/food/sandwich.jpg'),
(81, 1, 21, 'Fry Momos', 70.00, 1, NULL, 'assets/food/sandwich.jpg'),
(82, 2, 12, 'Hot & Sour Soup (Veg)', 245.00, 1, '', 'assets/food/sandwich.jpg'),
(83, 2, 12, 'Manchow Soup (Veg)', 56.00, 1, '', 'assets/food/sandwich.jpg'),
(84, 2, 12, 'Lemon Coriander Soup', 79.00, 1, '', 'assets/food/sandwich.jpg'),
(85, 2, 12, 'Chicken Clear Soup', 214.00, 1, '', 'assets/food/sandwich.jpg'),
(86, 2, 12, 'Chicken Hot & Sour Soup', 135.00, 1, '', 'assets/food/sandwich.jpg'),
(87, 2, 12, 'Chicken Manchow Soup', 73.00, 1, '', 'assets/food/sandwich.jpg'),
(88, 2, 20, 'Corn Corn', 118.00, 1, '', 'assets/food/sandwich.jpg'),
(89, 2, 20, 'Mushroom 65', 80.00, 1, '', 'assets/food/sandwich.jpg'),
(90, 2, 20, 'Paneer Chilli', 74.00, 1, '', 'assets/food/sandwich.jpg'),
(91, 2, 20, 'Mushroom Chilli', 205.00, 1, '', 'assets/food/sandwich.jpg'),
(92, 2, 20, 'Mushroom Manchurian', 97.00, 1, '', 'assets/food/sandwich.jpg'),
(93, 2, 20, 'Paneer Manchurian', 162.00, 1, '', 'assets/food/sandwich.jpg'),
(94, 2, 20, 'Paneer Tikka', 151.00, 1, '', 'assets/food/sandwich.jpg'),
(95, 2, 20, 'Paneer Malai Tikka', 151.00, 1, '', 'assets/food/sandwich.jpg'),
(96, 2, 20, 'Paneer Achari Tikka', 127.00, 1, '', 'assets/food/sandwich.jpg'),
(97, 2, 20, 'Paneer 65', 117.00, 1, '', 'assets/food/sandwich.jpg'),
(98, 2, 20, 'Egg Omelette', 129.00, 1, '', 'assets/food/sandwich.jpg'),
(99, 2, 20, 'Chicken Pakoda', 191.00, 1, '', 'assets/food/sandwich.jpg'),
(100, 2, 20, 'Chicken Salt & Pepper', 201.00, 1, '', 'assets/food/sandwich.jpg'),
(101, 2, 20, 'Schezwan Chicken', 192.00, 1, '', 'assets/food/sandwich.jpg'),
(102, 2, 20, 'Chicken Lollipop', 60.00, 1, '', 'assets/food/sandwich.jpg'),
(103, 2, 20, 'Dragon Chicken', 152.00, 1, '', 'assets/food/sandwich.jpg'),
(104, 2, 20, 'Chicken Manchurian', 172.00, 1, '', 'assets/food/sandwich.jpg'),
(105, 2, 20, 'Chicken 65', 191.00, 1, '', 'assets/food/sandwich.jpg'),
(106, 2, 20, 'Chicken Tikka', 147.00, 1, '', 'assets/food/sandwich.jpg'),
(107, 2, 20, 'Garlic Chicken', 95.00, 1, '', 'assets/food/sandwich.jpg'),
(108, 2, 20, 'Kalmi Kabab (2 Pc)', 109.00, 1, '', 'assets/food/sandwich.jpg'),
(109, 2, 20, 'Murga Achari Tikka', 76.00, 1, '', 'assets/food/sandwich.jpg'),
(110, 2, 20, 'Fish Tikka', 66.00, 1, '', 'assets/food/sandwich.jpg'),
(111, 2, 20, 'Chilli Prawns', 196.00, 1, '', 'assets/food/sandwich.jpg'),
(112, 2, 20, 'Tandoori Chicken (Half)', 175.00, 1, '', 'assets/food/sandwich.jpg'),
(113, 2, 20, 'Grill Chicken (Half)', 130.00, 1, '', 'assets/food/sandwich.jpg'),
(114, 2, 17, 'Veg Hakka Noodles', 146.00, 1, '', 'assets/food/sandwich.jpg'),
(115, 2, 17, 'Schezwan Veg Noodles', 76.00, 1, '', 'assets/food/sandwich.jpg'),
(116, 2, 17, 'Egg Noodles', 222.00, 1, '', 'assets/food/sandwich.jpg'),
(117, 2, 17, 'Mushroom Noodles', 114.00, 1, '', 'assets/food/sandwich.jpg'),
(118, 2, 17, 'Veg Shanghai Noodles', 53.00, 1, '', 'assets/food/sandwich.jpg'),
(119, 2, 17, 'Paneer Noodles', 214.00, 1, '', 'assets/food/sandwich.jpg'),
(120, 2, 17, 'Mix Veg Noodles', 151.00, 1, '', 'assets/food/sandwich.jpg'),
(121, 2, 17, 'Egg Chicken Noodles', 158.00, 1, '', 'assets/food/sandwich.jpg'),
(122, 2, 17, 'Schezwan Chicken Noodles', 181.00, 1, '', 'assets/food/sandwich.jpg'),
(123, 2, 17, 'Mix Non-Veg Noodles', 187.00, 1, '', 'assets/food/sandwich.jpg'),
(124, 2, 17, 'Non Veg Shanghai Noodles', 101.00, 1, '', 'assets/food/sandwich.jpg'),
(125, 2, 22, 'Shawarma Plate', 104.00, 1, '', 'assets/food/sandwich.jpg'),
(126, 2, 22, 'Shawarma Salad', 125.00, 1, '', 'assets/food/sandwich.jpg'),
(127, 2, 22, 'Special Shawarma Roll', 69.00, 1, '', 'assets/food/sandwich.jpg'),
(128, 2, 22, 'Peri Peri Shawarma Roll', 204.00, 1, '', 'assets/food/sandwich.jpg'),
(129, 2, 22, 'Schezwan Shawarma Roll', 85.00, 1, '', 'assets/food/sandwich.jpg'),
(130, 2, 22, 'Regular Shawarma Roll', 208.00, 1, '', 'assets/food/sandwich.jpg'),
(131, 2, 6, 'Egg Roll', 93.00, 1, '', 'assets/food/sandwich.jpg'),
(132, 2, 6, 'Egg Chicken Roll', 194.00, 1, '', 'assets/food/sandwich.jpg'),
(133, 2, 6, 'Mushroom Roll', 110.00, 1, '', 'assets/food/sandwich.jpg'),
(134, 2, 6, 'Paneer Roll', 58.00, 1, '', 'assets/food/sandwich.jpg'),
(135, 2, 6, 'Double Egg Chicken Roll', 182.00, 1, '', 'assets/food/sandwich.jpg'),
(136, 2, 6, 'Chilly Mushroom Roll', 198.00, 1, '', 'assets/food/sandwich.jpg'),
(137, 2, 6, 'Chilly Paneer Roll', 128.00, 1, '', 'assets/food/sandwich.jpg'),
(138, 2, 6, 'Mix Veg Roll', 83.00, 1, '', 'assets/food/sandwich.jpg'),
(139, 2, 11, 'Egg Biryani', 89.00, 1, '', 'assets/food/sandwich.jpg'),
(140, 2, 11, 'Mix Veg Biryani', 97.00, 1, '', 'assets/food/sandwich.jpg'),
(141, 2, 11, 'Hyderabadi Chicken Dum Biryani (Half)', 172.00, 1, '', 'assets/food/sandwich.jpg'),
(142, 2, 11, 'Hyderabadi Chicken Dum Biryani (Full)', 161.00, 1, '', 'assets/food/sandwich.jpg'),
(143, 2, 11, 'Mutton Biryani', 137.00, 1, '', 'assets/food/sandwich.jpg'),
(144, 2, 2, 'Egg Chicken Fried Rice', 75.00, 1, '', 'assets/food/sandwich.jpg'),
(145, 2, 2, 'Chicken Schezwan Fried Rice', 220.00, 1, '', 'assets/food/sandwich.jpg'),
(146, 2, 2, 'Hong Kong Chicken Fried Rice', 231.00, 1, '', 'assets/food/sandwich.jpg'),
(147, 2, 2, 'Hong Kong Veg Fried Rice', 79.00, 1, '', 'assets/food/sandwich.jpg'),
(148, 2, 2, 'Veg Schezwan Fried Rice', 153.00, 1, '', 'assets/food/sandwich.jpg'),
(149, 2, 2, 'Mix Veg Fried Rice', 57.00, 1, '', 'assets/food/sandwich.jpg'),
(150, 2, 2, 'Egg Fried Rice', 136.00, 1, '', 'assets/food/sandwich.jpg'),
(151, 2, 2, 'Jeera Rice', 245.00, 1, '', 'assets/food/sandwich.jpg'),
(152, 2, 2, 'Curd Rice', 91.00, 1, '', 'assets/food/sandwich.jpg'),
(153, 2, 2, 'Lemon Rice', 182.00, 1, '', 'assets/food/sandwich.jpg'),
(154, 2, 2, 'Plain Rice', 142.00, 1, '', 'assets/food/sandwich.jpg'),
(155, 2, 4, 'Dal Fry', 180.00, 1, '', 'assets/food/sandwich.jpg'),
(156, 2, 4, 'Veg Dal Tadka', 95.00, 1, '', 'assets/food/sandwich.jpg'),
(157, 2, 4, 'Chana Masala', 181.00, 1, '', 'assets/food/sandwich.jpg'),
(158, 2, 4, 'Veg Kadhai', 141.00, 1, '', 'assets/food/sandwich.jpg'),
(159, 2, 4, 'Aloo Matar', 102.00, 1, '', 'assets/food/sandwich.jpg'),
(160, 2, 4, 'Veg Kolhapure', 120.00, 1, '', 'assets/food/sandwich.jpg'),
(161, 2, 4, 'Mushroom Hyderabadi', 192.00, 1, '', 'assets/food/sandwich.jpg'),
(162, 2, 4, 'Mushroom Dopyaza', 207.00, 1, '', 'assets/food/sandwich.jpg'),
(163, 2, 4, 'Paneer Dopyaza', 89.00, 1, '', 'assets/food/sandwich.jpg'),
(164, 2, 4, 'Paneer Hyderabadi', 102.00, 1, '', 'assets/food/sandwich.jpg'),
(165, 2, 4, 'Paneer Bhurji', 95.00, 1, '', 'assets/food/sandwich.jpg'),
(166, 2, 4, 'Paneer Butter Masala', 228.00, 1, '', 'assets/food/sandwich.jpg'),
(167, 2, 16, 'Egg Bhurji', 244.00, 1, '', 'assets/food/sandwich.jpg'),
(168, 2, 16, 'Egg Masala', 111.00, 1, '', 'assets/food/sandwich.jpg'),
(169, 2, 16, 'Egg Tadka', 198.00, 1, '', 'assets/food/sandwich.jpg'),
(170, 2, 16, 'Fish Masala', 205.00, 1, '', 'assets/food/sandwich.jpg'),
(171, 2, 16, 'Chicken Kasa', 61.00, 1, '', 'assets/food/sandwich.jpg'),
(172, 2, 16, 'Chicken Masala', 172.00, 1, '', 'assets/food/sandwich.jpg'),
(173, 2, 16, 'Chicken Hyderabadi', 182.00, 1, '', 'assets/food/sandwich.jpg'),
(174, 2, 16, 'Chicken Kolhapure', 68.00, 1, '', 'assets/food/sandwich.jpg'),
(175, 2, 16, 'Chicken Korma', 191.00, 1, '', 'assets/food/sandwich.jpg'),
(176, 2, 16, 'Chicken Mughlai', 108.00, 1, '', 'assets/food/sandwich.jpg'),
(177, 2, 16, 'Chicken Lababdar', 91.00, 1, '', 'assets/food/sandwich.jpg'),
(178, 2, 16, 'Chicken Chettinad', 127.00, 1, '', 'assets/food/sandwich.jpg'),
(179, 2, 16, 'Kadhai Chicken', 160.00, 1, '', 'assets/food/sandwich.jpg'),
(180, 2, 16, 'Chicken Butter Masala', 71.00, 1, '', 'assets/food/sandwich.jpg'),
(181, 2, 16, 'Chicken Tikka Masala', 169.00, 1, '', 'assets/food/sandwich.jpg'),
(182, 2, 16, 'Chicken Bharta', 135.00, 1, '', 'assets/food/sandwich.jpg'),
(183, 2, 16, 'Tandoori Chicken Masala', 181.00, 1, '', 'assets/food/sandwich.jpg'),
(184, 2, 16, 'Chicken Patiala', 134.00, 1, '', 'assets/food/sandwich.jpg'),
(185, 2, 16, 'Mutton Rogan Josh', 198.00, 1, '', 'assets/food/sandwich.jpg'),
(186, 2, 16, 'Mutton Curry', 193.00, 1, '', 'assets/food/sandwich.jpg'),
(187, 2, 16, 'Prawns Masala', 130.00, 1, '', 'assets/food/sandwich.jpg'),
(188, 2, 5, 'Keema Naan', 74.00, 1, '', 'assets/food/sandwich.jpg'),
(189, 2, 5, 'Masala Naan', 91.00, 1, '', 'assets/food/sandwich.jpg'),
(190, 2, 5, 'Masala Kulcha', 223.00, 1, '', 'assets/food/sandwich.jpg'),
(191, 2, 5, 'Garlic Naan', 190.00, 1, '', 'assets/food/sandwich.jpg'),
(192, 2, 5, 'Butter Naan', 225.00, 1, '', 'assets/food/sandwich.jpg'),
(193, 2, 5, 'Rumali Roti', 61.00, 1, '', 'assets/food/sandwich.jpg'),
(194, 2, 5, 'Plain Naan', 132.00, 1, '', 'assets/food/sandwich.jpg'),
(195, 2, 5, 'Plain Kulcha', 124.00, 1, '', 'assets/food/sandwich.jpg'),
(196, 2, 5, 'Laccha Paratha', 185.00, 1, '', 'assets/food/sandwich.jpg'),
(197, 2, 5, 'Chapati', 246.00, 1, '', 'assets/food/sandwich.jpg'),
(198, 2, 23, 'Water Bottle', 201.00, 1, '', 'assets/food/sandwich.jpg'),
(199, 2, 23, 'Masala Cold Drink', 208.00, 1, '', 'assets/food/sandwich.jpg'),
(200, 3, 20, 'French Fries', 68.00, 1, '', 'assets/food/sandwich.jpg'),
(201, 3, 20, 'Peri Peri French Fries', 122.00, 1, '', 'assets/food/sandwich.jpg'),
(202, 3, 20, 'Crispy American Corn', 240.00, 1, '', 'assets/food/sandwich.jpg'),
(203, 3, 20, 'Crispy Baby Corn', 119.00, 1, '', 'assets/food/sandwich.jpg'),
(204, 3, 20, 'Babycorn Salt & Pepper', 219.00, 1, '', 'assets/food/sandwich.jpg'),
(205, 3, 20, 'Babycorn Chilli', 115.00, 1, '', 'assets/food/sandwich.jpg'),
(206, 3, 20, 'Mushroom Chilli', 227.00, 1, '', 'assets/food/sandwich.jpg'),
(207, 3, 20, 'Mushroom Popcorn', 238.00, 1, '', 'assets/food/sandwich.jpg'),
(208, 3, 20, 'Mushroom Salt & Pepper', 76.00, 1, '', 'assets/food/sandwich.jpg'),
(209, 3, 20, 'Mushroom Manchurian', 90.00, 1, '', 'assets/food/sandwich.jpg'),
(210, 3, 20, 'Paneer Chilli', 95.00, 1, '', 'assets/food/sandwich.jpg'),
(211, 3, 20, 'Paneer Popcorn', 202.00, 1, '', 'assets/food/sandwich.jpg'),
(212, 3, 20, 'Hot Garlic Paneer Popcorn', 53.00, 1, '', 'assets/food/sandwich.jpg'),
(213, 3, 20, 'Paneer Manchurian', 243.00, 1, '', 'assets/food/sandwich.jpg'),
(214, 3, 20, 'Paneer Pakora', 144.00, 1, '', 'assets/food/sandwich.jpg'),
(215, 3, 20, 'Chicken Pakora', 228.00, 1, '', 'assets/food/sandwich.jpg'),
(216, 3, 20, 'Chicken Nuggets', 191.00, 1, '', 'assets/food/sandwich.jpg'),
(217, 3, 20, 'Chilli Chicken', 194.00, 1, '', 'assets/food/sandwich.jpg'),
(218, 3, 20, 'Honey Chilli Chicken', 234.00, 1, '', 'assets/food/sandwich.jpg'),
(219, 3, 20, 'Chicken Popcorn', 61.00, 1, '', 'assets/food/sandwich.jpg'),
(220, 3, 20, 'Hot Garlic Chicken Popcorn', 102.00, 1, '', 'assets/food/sandwich.jpg'),
(221, 3, 20, 'Chicken 65', 126.00, 1, '', 'assets/food/sandwich.jpg'),
(222, 3, 20, 'Dragon Chicken', 85.00, 1, '', 'assets/food/sandwich.jpg'),
(223, 3, 20, 'Chicken Majestic', 153.00, 1, '', 'assets/food/sandwich.jpg'),
(224, 3, 20, 'Hong Kong Chicken', 205.00, 1, '', 'assets/food/sandwich.jpg'),
(225, 3, 20, 'Chicken Kakara', 176.00, 1, '', 'assets/food/sandwich.jpg'),
(226, 3, 20, 'Hot Sauce Garlic Chicken', 203.00, 1, '', 'assets/food/sandwich.jpg'),
(227, 3, 2, 'Veg Fried Rice', 234.00, 1, '', 'assets/food/sandwich.jpg'),
(228, 3, 2, 'Mix Veg Fried Rice', 187.00, 1, '', 'assets/food/sandwich.jpg'),
(229, 3, 2, 'Hong Kong Veg Rice', 93.00, 1, '', 'assets/food/sandwich.jpg'),
(230, 3, 2, 'Schezwan Fried Rice', 105.00, 1, '', 'assets/food/sandwich.jpg'),
(231, 3, 2, 'Chicken Fried Rice', 235.00, 1, '', 'assets/food/sandwich.jpg'),
(232, 3, 2, 'Egg Chicken Fried Rice', 180.00, 1, '', 'assets/food/sandwich.jpg'),
(233, 3, 2, 'Schezwan Chicken Fried Rice', 66.00, 1, '', 'assets/food/sandwich.jpg'),
(234, 3, 2, 'Plain Rice', 154.00, 1, '', 'assets/food/sandwich.jpg'),
(235, 3, 2, 'Jeera Rice', 164.00, 1, '', 'assets/food/sandwich.jpg'),
(236, 3, 2, 'Ghee Rice', 214.00, 1, '', 'assets/food/sandwich.jpg'),
(237, 3, 17, 'Veg Hakka Noodles', 159.00, 1, '', 'assets/food/sandwich.jpg'),
(238, 3, 17, 'Mix Veg Hakka Noodles', 179.00, 1, '', 'assets/food/sandwich.jpg'),
(239, 3, 17, 'Schezwan Veg Noodles', 87.00, 1, '', 'assets/food/sandwich.jpg'),
(240, 3, 17, 'Chicken Noodles', 144.00, 1, '', 'assets/food/sandwich.jpg'),
(241, 3, 17, 'Egg Chicken Noodles', 99.00, 1, '', 'assets/food/sandwich.jpg'),
(242, 3, 17, 'Schezwan Chicken Noodles', 59.00, 1, '', 'assets/food/sandwich.jpg'),
(243, 3, 3, 'Dal Fry', 182.00, 1, '', 'assets/food/sandwich.jpg'),
(244, 3, 3, 'Dal Tadka', 128.00, 1, '', 'assets/food/sandwich.jpg'),
(245, 3, 4, 'Mix Veg', 246.00, 1, '', 'assets/food/sandwich.jpg'),
(246, 3, 4, 'Aloo Dum', 250.00, 1, '', 'assets/food/sandwich.jpg'),
(247, 3, 4, 'Aloo Jeera', 244.00, 1, '', 'assets/food/sandwich.jpg'),
(248, 3, 4, 'Chana Masala', 118.00, 1, '', 'assets/food/sandwich.jpg'),
(249, 3, 4, 'Mushroom Masala', 116.00, 1, '', 'assets/food/sandwich.jpg'),
(250, 3, 4, 'Kadai Mushroom', 191.00, 1, '', 'assets/food/sandwich.jpg'),
(251, 3, 15, 'Paneer Masala', 78.00, 1, '', 'assets/food/sandwich.jpg'),
(252, 3, 15, 'Paneer Butter Masala', 170.00, 1, '', 'assets/food/sandwich.jpg'),
(253, 3, 15, 'Paneer Hyderabadi', 83.00, 1, '', 'assets/food/sandwich.jpg'),
(254, 3, 15, 'Punjabi Paneer', 229.00, 1, '', 'assets/food/sandwich.jpg'),
(255, 3, 15, 'Kadai Paneer', 101.00, 1, '', 'assets/food/sandwich.jpg'),
(256, 3, 16, 'Chicken Bharta', 243.00, 1, '', 'assets/food/sandwich.jpg'),
(257, 3, 16, 'Chicken Curry', 184.00, 1, '', 'assets/food/sandwich.jpg'),
(258, 3, 16, 'Chicken Butter Masala', 73.00, 1, '', 'assets/food/sandwich.jpg'),
(259, 3, 16, 'Kadai Chicken', 245.00, 1, '', 'assets/food/sandwich.jpg'),
(260, 3, 16, 'Chicken Hyderabadi', 183.00, 1, '', 'assets/food/sandwich.jpg'),
(261, 3, 16, 'Mughlai Chicken', 228.00, 1, '', 'assets/food/sandwich.jpg'),
(262, 3, 5, 'Tawa Roti', 50.00, 1, '', 'assets/food/sandwich.jpg'),
(263, 3, 5, 'Butter Roti', 226.00, 1, '', 'assets/food/sandwich.jpg'),
(264, 3, 5, 'Plain Paratha', 131.00, 1, '', 'assets/food/sandwich.jpg'),
(265, 3, 5, 'Laccha Paratha', 110.00, 1, '', 'assets/food/sandwich.jpg'),
(266, 3, 5, 'Garlic Laccha Paratha', 89.00, 1, '', 'assets/food/sandwich.jpg'),
(267, 3, 5, 'Aloo Paratha', 98.00, 1, '', 'assets/food/sandwich.jpg'),
(268, 3, 5, 'Paneer Paratha', 132.00, 1, '', 'assets/food/sandwich.jpg'),
(269, 3, 24, 'White Sauce Pasta', 53.00, 1, '', 'assets/food/sandwich.jpg'),
(270, 3, 24, 'Red Sauce Pasta', 211.00, 1, '', 'assets/food/sandwich.jpg'),
(271, 3, 24, 'Indian Style Pasta', 152.00, 1, '', 'assets/food/sandwich.jpg'),
(272, 3, 24, 'Mac & Cheese', 201.00, 1, '', 'assets/food/sandwich.jpg'),
(273, 3, 25, 'Veg Classic Pizza', 52.00, 1, '', 'assets/food/sandwich.jpg'),
(274, 3, 25, 'Paneer Loaded Pizza', 154.00, 1, '', 'assets/food/sandwich.jpg'),
(275, 3, 25, 'Peri Peri Paneer Pizza', 178.00, 1, '', 'assets/food/sandwich.jpg'),
(276, 3, 25, 'Mushroom Cheezy Pizza', 192.00, 1, '', 'assets/food/sandwich.jpg'),
(277, 3, 25, 'Chicken Cheese Pizza', 212.00, 1, '', 'assets/food/sandwich.jpg'),
(278, 3, 25, 'Peri Peri Chicken Pizza', 152.00, 1, '', 'assets/food/sandwich.jpg'),
(279, 3, 26, 'Aloo Tikki Burger', 129.00, 1, '', 'assets/food/sandwich.jpg'),
(280, 3, 26, 'Veg Cheese Burger', 144.00, 1, '', 'assets/food/sandwich.jpg'),
(281, 3, 26, 'Crispy Paneer Burger', 209.00, 1, '', 'assets/food/sandwich.jpg'),
(282, 3, 26, 'Crispy Chicken Burger', 129.00, 1, '', 'assets/food/sandwich.jpg'),
(283, 3, 27, 'Grilled Veg Mayo Sandwich', 127.00, 1, '', 'assets/food/sandwich.jpg'),
(284, 3, 27, 'Peri Peri Paneer Sandwich', 128.00, 1, '', 'assets/food/sandwich.jpg'),
(285, 3, 27, 'Cheezy Chicken Sandwich', 156.00, 1, '', 'assets/food/sandwich.jpg'),
(286, 3, 27, 'Peri Peri Chicken Sandwich', 100.00, 1, '', 'assets/food/sandwich.jpg'),
(287, 3, 28, 'Dry Fruit Milkshake', 79.00, 1, '', 'assets/food/sandwich.jpg'),
(288, 3, 28, 'Oreo Milkshake', 112.00, 1, '', 'assets/food/sandwich.jpg'),
(289, 3, 28, 'Chocolate Milkshake', 124.00, 1, '', 'assets/food/sandwich.jpg'),
(290, 3, 28, 'Kitkat Milkshake', 88.00, 1, '', 'assets/food/sandwich.jpg'),
(291, 3, 28, 'Apple Milkshake', 160.00, 1, '', 'assets/food/sandwich.jpg'),
(292, 3, 28, 'Banana Milkshake', 154.00, 1, '', 'assets/food/sandwich.jpg'),
(293, 3, 28, 'Strawberry Milkshake', 126.00, 1, '', 'assets/food/sandwich.jpg'),
(294, 3, 28, 'Hot Chocolate', 246.00, 1, '', 'assets/food/sandwich.jpg'),
(295, 3, 29, 'Cold Coffee', 188.00, 1, '', 'assets/food/sandwich.jpg'),
(296, 3, 29, 'Cold Coffee (with Ice Cream)', 101.00, 1, '', 'assets/food/sandwich.jpg'),
(297, 3, 30, 'Hot Coffee', 78.00, 1, '', 'assets/food/sandwich.jpg'),
(298, 3, 23, 'Tea', 84.00, 1, '', 'assets/food/sandwich.jpg'),
(299, 3, 23, 'Blue Lagoon', 78.00, 1, '', 'assets/food/sandwich.jpg'),
(300, 3, 23, 'Blueberry Lemon Fizz', 148.00, 1, '', 'assets/food/sandwich.jpg'),
(301, 3, 23, 'Blueberry Crush', 245.00, 1, '', 'assets/food/sandwich.jpg'),
(302, 3, 23, 'Virgin Mojito', 220.00, 1, '', 'assets/food/sandwich.jpg'),
(303, 3, 23, 'Lemonade Fizz', 190.00, 1, '', 'assets/food/sandwich.jpg'),
(304, 3, 23, 'Masala Cold Drink', 95.00, 1, '', 'assets/food/sandwich.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Preparing','Out for Delivery','Delivered','Cancelled') DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `restaurant_id`, `total_amount`, `status`, `order_date`) VALUES
(1, 3, 1, 140.00, 'Pending', '2026-03-20 15:07:04'),
(2, 3, 3, 408.00, 'Pending', '2026-03-20 15:12:37'),
(3, 3, NULL, 505.00, 'Pending', '2026-03-21 08:45:03'),
(4, 3, NULL, 220.00, 'Pending', '2026-03-21 08:50:37'),
(5, 3, NULL, 670.00, 'Pending', '2026-03-21 11:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `cuisine_type` varchar(50) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT 1,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `owner_id`, `name`, `description`, `cuisine_type`, `rating`, `image_url`, `is_open`, `location`) VALUES
(1, 2, 'Green Salad', 'Fresh, healthy, and a massive variety of campus favorites.', 'Indian & Chinese', 4.7, 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=400', 1, 'Near Hostel Gate 1'),
(2, 4, 'Shawarma Xpress-3', 'Amazing Shawarma and fast food', 'Fast Food', 4.5, 'https://images.unsplash.com/photo-1529042410759-befb1204b468?q=80&w=400', 1, 'Near Gate 3'),
(3, 5, 'Adventures Cafe', 'Best place to hang out and eat', 'Cafe', 4.6, 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=400', 1, 'Student Center');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `rollno` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','restaurant','admin') DEFAULT 'student',
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT 'default.jpeg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `course`, `rollno`, `password`, `role`, `phone`, `created_at`, `profile_picture`) VALUES
(1, 'Admin', 'admin@campuscravings.com', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, '2026-03-20 15:02:03', 'default.jpeg'),
(2, 'Green Salad Owner', 'owner@greensalad.com', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'restaurant', NULL, '2026-03-20 15:02:03', 'default.jpeg'),
(3, 'Ayush Jha', 'ucse24017@stu.xim.edu.in', NULL, NULL, '$2y$10$zm8NVD8b7opkNDz0GoGxd.wdbJDE5OYId.nQDWVWpTXuLGJKf2p1i', 'student', '77987997878', '2026-03-20 15:06:12', 'user_3_1774086474.jpeg'),
(4, 'Shawarma Xpress-3 Owner', 'shawarma@campuscravings.com', NULL, NULL, '$2y$10$Q6Kr6DU.FItCDhLXbP4yAuXzz9Ay5oCAjvXUe3YFYELYJqiTFm65C', 'restaurant', NULL, '2026-03-20 15:07:47', 'default.jpeg'),
(5, 'Adventures Cafe Owner', 'adventures@campuscravings.com', NULL, NULL, '$2y$10$Q6Kr6DU.FItCDhLXbP4yAuXzz9Ay5oCAjvXUe3YFYELYJqiTFm65C', 'restaurant', NULL, '2026-03-20 15:07:47', 'default.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_items_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
