
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `complaints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('Open','Resolved') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `complaints_fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `complaints_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `complaints` WRITE;
/*!40000 ALTER TABLE `complaints` DISABLE KEYS */;
INSERT INTO `complaints` VALUES (1,3,5,'my order is not delivered yet ??','what the hell !???','Open','2026-03-21 06:06:51');
/*!40000 ALTER TABLE `complaints` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `menu_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `menu_categories` WRITE;
/*!40000 ALTER TABLE `menu_categories` DISABLE KEYS */;
INSERT INTO `menu_categories` VALUES (1,'Indian Thali');
INSERT INTO `menu_categories` VALUES (2,'Rice');
INSERT INTO `menu_categories` VALUES (3,'Dal');
INSERT INTO `menu_categories` VALUES (4,'Veg');
INSERT INTO `menu_categories` VALUES (5,'Tandoor');
INSERT INTO `menu_categories` VALUES (6,'Rolls');
INSERT INTO `menu_categories` VALUES (7,'Chinese Combo');
INSERT INTO `menu_categories` VALUES (8,'Chicken');
INSERT INTO `menu_categories` VALUES (9,'Fish');
INSERT INTO `menu_categories` VALUES (10,'Mutton');
INSERT INTO `menu_categories` VALUES (11,'Biryani');
INSERT INTO `menu_categories` VALUES (12,'Soup');
INSERT INTO `menu_categories` VALUES (13,'Snacks');
INSERT INTO `menu_categories` VALUES (14,'Salad');
INSERT INTO `menu_categories` VALUES (15,'Paneer');
INSERT INTO `menu_categories` VALUES (16,'Chicken Curry');
INSERT INTO `menu_categories` VALUES (17,'Noodles');
INSERT INTO `menu_categories` VALUES (18,'Chinese Veg');
INSERT INTO `menu_categories` VALUES (19,'Chinese Chicken');
INSERT INTO `menu_categories` VALUES (20,'Starters');
INSERT INTO `menu_categories` VALUES (21,'Momos');
INSERT INTO `menu_categories` VALUES (22,'Shawarma');
INSERT INTO `menu_categories` VALUES (23,'Coolers');
INSERT INTO `menu_categories` VALUES (24,'Pasta');
INSERT INTO `menu_categories` VALUES (25,'Pizza');
INSERT INTO `menu_categories` VALUES (26,'Burgers');
INSERT INTO `menu_categories` VALUES (27,'Sandwiches');
INSERT INTO `menu_categories` VALUES (28,'Smoothies & Shakes');
INSERT INTO `menu_categories` VALUES (29,'Cold Coffee');
INSERT INTO `menu_categories` VALUES (30,'Hot Coffee');
/*!40000 ALTER TABLE `menu_categories` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `availability` tinyint(1) DEFAULT 1,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `menu_items_fk_category` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_items_fk_restaurant` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=305 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,1,1,'Veg Normal Thali',70.00,1,NULL,'assets/food/veg normal thali.jpg');
INSERT INTO `menu_items` VALUES (2,1,1,'Fish Thali',70.00,1,NULL,'assets/food/fish thali.jpeg');
INSERT INTO `menu_items` VALUES (3,1,1,'Egg Thali',70.00,1,NULL,'assets/food/egg thali.jpg');
INSERT INTO `menu_items` VALUES (4,1,1,'Paneer Thali',100.00,1,NULL,'assets/food/paneer thali.jpeg');
INSERT INTO `menu_items` VALUES (5,1,1,'Mushroom Thali',100.00,1,NULL,'assets/food/mushroom thali.webp');
INSERT INTO `menu_items` VALUES (6,1,1,'Chicken Thali',110.00,1,NULL,'assets/food/chicken thali.jpg');
INSERT INTO `menu_items` VALUES (7,1,1,'Mutton Thali',220.00,1,NULL,'assets/food/mutton thali.jpg');
INSERT INTO `menu_items` VALUES (8,1,2,'Plain Rice',25.00,1,NULL,'assets/food/plain rice.jpg');
INSERT INTO `menu_items` VALUES (9,1,2,'Jeera Rice',60.00,1,NULL,'assets/food/jeera rice.jpg');
INSERT INTO `menu_items` VALUES (10,1,2,'Peas Palau',100.00,1,NULL,'assets/food/peas pulao.jpg');
INSERT INTO `menu_items` VALUES (11,1,2,'Veg Palau',100.00,1,NULL,'assets/food/veg palau.jpg');
INSERT INTO `menu_items` VALUES (12,1,2,'Veg Fried Rice',60.00,1,NULL,'assets/food/veg fried rice.jpg');
INSERT INTO `menu_items` VALUES (13,1,2,'Chicken Fried Rice',80.00,1,NULL,'assets/food/chicken fried rice.jpg');
INSERT INTO `menu_items` VALUES (14,1,2,'Egg Fried Rice',70.00,1,NULL,'assets/food/egg fried rice.jpg');
INSERT INTO `menu_items` VALUES (15,1,2,'Mixed Fried Rice',100.00,1,NULL,'assets/food/mixed fried rice.jpg');
INSERT INTO `menu_items` VALUES (16,1,3,'Dal Fry',50.00,1,NULL,'assets/food/dal fry.jpg');
INSERT INTO `menu_items` VALUES (17,1,3,'Dal Tadka',50.00,1,NULL,'assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (18,1,3,'Dal Makhani',70.00,1,NULL,'assets/food/dal makhani.jpg');
INSERT INTO `menu_items` VALUES (19,1,3,'Chana Masala',70.00,1,NULL,'assets/food/chana masala.jpg');
INSERT INTO `menu_items` VALUES (20,1,3,'Egg Tadka',60.00,1,NULL,'assets/food/egg tadka.jpg');
INSERT INTO `menu_items` VALUES (21,1,3,'Double Egg Tadka',70.00,1,NULL,'assets/food/double egg tadka.jpg');
INSERT INTO `menu_items` VALUES (22,1,3,'Egg Chicken Tadka',90.00,1,NULL,'assets/food/egg chicken tadka.jpg');
INSERT INTO `menu_items` VALUES (23,1,4,'Mix Veg',60.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (24,1,4,'Veg Korma',80.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (25,1,4,'Veg Dopiaza',70.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (26,1,4,'Veg Jhal Fry',70.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (27,1,4,'Aloo Mattar',60.00,1,NULL,'assets/food/aloo mattar.jpg');
INSERT INTO `menu_items` VALUES (28,1,4,'Aloo Capsicum',60.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (29,1,4,'Corn Methi Malai',100.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (30,1,4,'Mushroom Chatpata',100.00,1,NULL,'assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (31,1,4,'Methi Aloo',60.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (32,1,4,'Jeera Aloo',60.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (33,1,4,'Aloo Kobi',60.00,1,NULL,'assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (34,1,5,'Roti',6.00,1,NULL,'assets/food/roti.jpg');
INSERT INTO `menu_items` VALUES (35,1,5,'Plain Naan',15.00,1,NULL,'assets/food/plain naan.jpg');
INSERT INTO `menu_items` VALUES (36,1,5,'Butter Naan',40.00,1,NULL,'assets/food/butter naan.jpg');
INSERT INTO `menu_items` VALUES (37,1,5,'Kashmiri Kulcha',60.00,1,NULL,'assets/food/plain kulcha.jpg');
INSERT INTO `menu_items` VALUES (38,1,5,'Masala Kulcha',40.00,1,NULL,'assets/food/plain kulcha.jpg');
INSERT INTO `menu_items` VALUES (39,1,5,'Paneer Kulcha',60.00,1,NULL,'assets/food/plain kulcha.jpg');
INSERT INTO `menu_items` VALUES (40,1,5,'Chicken Tandoor (1 pc)',100.00,1,NULL,'assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (41,1,5,'Chicken Tikka (5 pc)',90.00,1,NULL,'assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (42,1,5,'Plain Parota',15.00,1,NULL,'assets/food/laccha parota.jpg');
INSERT INTO `menu_items` VALUES (43,1,5,'Lacha Parota',25.00,1,NULL,'assets/food/laccha parota.jpg');
INSERT INTO `menu_items` VALUES (44,1,5,'Egg Paratha',40.00,1,NULL,'assets/food/egg parota.jpg');
INSERT INTO `menu_items` VALUES (45,1,6,'Egg Roll',45.00,1,NULL,'assets/food/egg roll.jpg');
INSERT INTO `menu_items` VALUES (46,1,6,'E.C Roll',50.00,1,NULL,'assets/food/egg roll.jpg');
INSERT INTO `menu_items` VALUES (47,1,6,'D.E.C Roll',60.00,1,NULL,'assets/food/egg roll.jpg');
INSERT INTO `menu_items` VALUES (48,1,6,'Veg Roll Normal',40.00,1,NULL,'assets/food/paneer roll.jpg');
INSERT INTO `menu_items` VALUES (49,1,6,'Veg Paneer Roll',60.00,1,NULL,'assets/food/paneer roll.jpg');
INSERT INTO `menu_items` VALUES (50,1,6,'Paneer Tikka Roll',70.00,1,NULL,'assets/food/paneer roll.jpg');
INSERT INTO `menu_items` VALUES (51,1,6,'Chicken Tikka Roll',80.00,1,NULL,'assets/food/chicken roll.jpg');
INSERT INTO `menu_items` VALUES (52,1,6,'Bahubali Roll',150.00,1,NULL,'assets/food/chicken roll.jpg');
INSERT INTO `menu_items` VALUES (53,1,6,'Shawarma Roll',60.00,1,NULL,'assets/food/shawarma roll.jpg');
INSERT INTO `menu_items` VALUES (54,1,11,'Mutton Biryani',220.00,1,NULL,'assets/food/mutton biryani.jpg');
INSERT INTO `menu_items` VALUES (55,1,11,'Chicken Biryani',110.00,1,NULL,'assets/food/chicken biryani.jpg');
INSERT INTO `menu_items` VALUES (56,1,11,'Veg Biryani',80.00,1,NULL,'assets/food/veg biryani.jpg');
INSERT INTO `menu_items` VALUES (57,1,11,'Egg Biryani',80.00,1,NULL,'assets/food/egg biryani.jpg');
INSERT INTO `menu_items` VALUES (58,1,15,'Shahi Paneer',110.00,1,NULL,'assets/food/shahi paneer.jpg');
INSERT INTO `menu_items` VALUES (59,1,15,'Paneer Butter Masala',100.00,1,NULL,'assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (60,1,15,'Matter Paneer',100.00,1,NULL,'assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (61,1,15,'Paneer Tikka Masala',120.00,1,NULL,'assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (62,1,15,'Mushroom Masala',100.00,1,NULL,'assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (63,1,16,'Chicken Butter Masala',100.00,1,NULL,'assets/food/chicken butter masala.avif');
INSERT INTO `menu_items` VALUES (64,1,16,'Chicken Curry',80.00,1,NULL,'assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (65,1,16,'Chicken Bharta',120.00,1,NULL,'assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (66,1,16,'Chicken Kasa',90.00,1,NULL,'assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (67,1,17,'Veg Noodles',40.00,1,NULL,'assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (68,1,17,'Egg Noodles',50.00,1,NULL,'assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (69,1,17,'Chicken Noodles',60.00,1,NULL,'assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (70,1,17,'Mix Noodles',70.00,1,NULL,'assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (71,1,18,'Veg Manchurian',60.00,1,NULL,'assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (72,1,18,'Chilly Paneer',100.00,1,NULL,'assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (73,1,18,'Chilly Mushroom',100.00,1,NULL,'assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (74,1,19,'Chilly Chicken',100.00,1,NULL,'assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (75,1,19,'Garlic Chicken',100.00,1,NULL,'assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (76,1,19,'Lemon Chicken',100.00,1,NULL,'assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (77,1,20,'Fish Fry (2 pc)',100.00,1,NULL,'assets/food/fish thali.jpeg');
INSERT INTO `menu_items` VALUES (78,1,20,'Fish Finger (6 pc)',100.00,1,NULL,'assets/food/fish thali.jpeg');
INSERT INTO `menu_items` VALUES (79,1,20,'Chicken Cutlet (1 pc)',100.00,1,NULL,'assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (80,1,21,'Steam Momos',50.00,1,NULL,'assets/food/steam momos.jpg');
INSERT INTO `menu_items` VALUES (81,1,21,'Fry Momos',70.00,1,NULL,'assets/food/fry momos.jpg');
INSERT INTO `menu_items` VALUES (82,2,12,'Hot & Sour Soup (Veg)',245.00,1,'','assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (83,2,12,'Manchow Soup (Veg)',56.00,1,'','assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (84,2,12,'Lemon Coriander Soup',79.00,1,'','assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (85,2,12,'Chicken Clear Soup',214.00,1,'','assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (86,2,12,'Chicken Hot & Sour Soup',135.00,1,'','assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (87,2,12,'Chicken Manchow Soup',73.00,1,'','assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (88,2,20,'Corn Corn',118.00,1,'','assets/food/crispy baby corn.jpg');
INSERT INTO `menu_items` VALUES (89,2,20,'Mushroom 65',80.00,1,'','assets/food/mushroom 65.jpg');
INSERT INTO `menu_items` VALUES (90,2,20,'Paneer Chilli',74.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (91,2,20,'Mushroom Chilli',205.00,1,'','assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (92,2,20,'Mushroom Manchurian',97.00,1,'','assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (93,2,20,'Paneer Manchurian',162.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (94,2,20,'Paneer Tikka',151.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (95,2,20,'Paneer Malai Tikka',151.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (96,2,20,'Paneer Achari Tikka',127.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (97,2,20,'Paneer 65',117.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (98,2,20,'Egg Omelette',129.00,1,'','assets/food/egg tadka.jpg');
INSERT INTO `menu_items` VALUES (99,2,20,'Chicken Pakoda',191.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (100,2,20,'Chicken Salt & Pepper',201.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (101,2,20,'Schezwan Chicken',192.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (102,2,20,'Chicken Lollipop',60.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (103,2,20,'Dragon Chicken',152.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (104,2,20,'Chicken Manchurian',172.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (105,2,20,'Chicken 65',191.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (106,2,20,'Chicken Tikka',147.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (107,2,20,'Garlic Chicken',95.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (108,2,20,'Kalmi Kabab (2 Pc)',109.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (109,2,20,'Murga Achari Tikka',76.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (110,2,20,'Fish Tikka',66.00,1,'','assets/food/fish thali.jpeg');
INSERT INTO `menu_items` VALUES (111,2,20,'Chilli Prawns',196.00,1,'','assets/food/fish thali.jpeg');
INSERT INTO `menu_items` VALUES (112,2,20,'Tandoori Chicken (Half)',175.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (113,2,20,'Grill Chicken (Half)',130.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (114,2,17,'Veg Hakka Noodles',146.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (115,2,17,'Schezwan Veg Noodles',76.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (116,2,17,'Egg Noodles',222.00,1,'','assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (117,2,17,'Mushroom Noodles',114.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (118,2,17,'Veg Shanghai Noodles',53.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (119,2,17,'Paneer Noodles',214.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (120,2,17,'Mix Veg Noodles',151.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (121,2,17,'Egg Chicken Noodles',158.00,1,'','assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (122,2,17,'Schezwan Chicken Noodles',181.00,1,'','assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (123,2,17,'Mix Non-Veg Noodles',187.00,1,'','assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (124,2,17,'Non Veg Shanghai Noodles',101.00,1,'','assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (125,2,22,'Shawarma Plate',104.00,1,'','assets/food/shawarma roll.jpg');
INSERT INTO `menu_items` VALUES (126,2,22,'Shawarma Salad',125.00,1,'','assets/food/shawarma roll.jpg');
INSERT INTO `menu_items` VALUES (127,2,22,'Special Shawarma Roll',69.00,1,'','assets/food/shawarma roll.jpg');
INSERT INTO `menu_items` VALUES (128,2,22,'Peri Peri Shawarma Roll',204.00,1,'','assets/food/shawarma roll.jpg');
INSERT INTO `menu_items` VALUES (129,2,22,'Schezwan Shawarma Roll',85.00,1,'','assets/food/shawarma roll.jpg');
INSERT INTO `menu_items` VALUES (130,2,22,'Regular Shawarma Roll',208.00,1,'','assets/food/shawarma roll.jpg');
INSERT INTO `menu_items` VALUES (131,2,6,'Egg Roll',93.00,1,'','assets/food/egg roll.jpg');
INSERT INTO `menu_items` VALUES (132,2,6,'Egg Chicken Roll',194.00,1,'','assets/food/chicken roll.jpg');
INSERT INTO `menu_items` VALUES (133,2,6,'Mushroom Roll',110.00,1,'','assets/food/paneer roll.jpg');
INSERT INTO `menu_items` VALUES (134,2,6,'Paneer Roll',58.00,1,'','assets/food/paneer roll.jpg');
INSERT INTO `menu_items` VALUES (135,2,6,'Double Egg Chicken Roll',182.00,1,'','assets/food/egg roll.jpg');
INSERT INTO `menu_items` VALUES (136,2,6,'Chilly Mushroom Roll',198.00,1,'','assets/food/paneer roll.jpg');
INSERT INTO `menu_items` VALUES (137,2,6,'Chilly Paneer Roll',128.00,1,'','assets/food/paneer roll.jpg');
INSERT INTO `menu_items` VALUES (138,2,6,'Mix Veg Roll',83.00,1,'','assets/food/paneer roll.jpg');
INSERT INTO `menu_items` VALUES (139,2,11,'Egg Biryani',89.00,1,'','assets/food/egg biryani.jpg');
INSERT INTO `menu_items` VALUES (140,2,11,'Mix Veg Biryani',97.00,1,'','assets/food/veg biryani.jpg');
INSERT INTO `menu_items` VALUES (141,2,11,'Hyderabadi Chicken Dum Biryani (Half)',172.00,1,'','assets/food/chicken biryani.jpg');
INSERT INTO `menu_items` VALUES (142,2,11,'Hyderabadi Chicken Dum Biryani (Full)',161.00,1,'','assets/food/chicken biryani.jpg');
INSERT INTO `menu_items` VALUES (143,2,11,'Mutton Biryani',137.00,1,'','assets/food/mutton biryani.jpg');
INSERT INTO `menu_items` VALUES (144,2,2,'Egg Chicken Fried Rice',75.00,1,'','assets/food/egg fried rice.jpg');
INSERT INTO `menu_items` VALUES (145,2,2,'Chicken Schezwan Fried Rice',220.00,1,'','assets/food/chicken fried rice.jpg');
INSERT INTO `menu_items` VALUES (146,2,2,'Hong Kong Chicken Fried Rice',231.00,1,'','assets/food/chicken fried rice.jpg');
INSERT INTO `menu_items` VALUES (147,2,2,'Hong Kong Veg Fried Rice',79.00,1,'','assets/food/veg fried rice.jpg');
INSERT INTO `menu_items` VALUES (148,2,2,'Veg Schezwan Fried Rice',153.00,1,'','assets/food/veg fried rice.jpg');
INSERT INTO `menu_items` VALUES (149,2,2,'Mix Veg Fried Rice',57.00,1,'','assets/food/fried rice.jpg');
INSERT INTO `menu_items` VALUES (150,2,2,'Egg Fried Rice',136.00,1,'','assets/food/egg fried rice.jpg');
INSERT INTO `menu_items` VALUES (151,2,2,'Jeera Rice',245.00,1,'','assets/food/jeera rice.jpg');
INSERT INTO `menu_items` VALUES (152,2,2,'Curd Rice',91.00,1,'','assets/food/plain rice.jpg');
INSERT INTO `menu_items` VALUES (153,2,2,'Lemon Rice',182.00,1,'','assets/food/plain rice.jpg');
INSERT INTO `menu_items` VALUES (154,2,2,'Plain Rice',142.00,1,'','assets/food/plain rice.jpg');
INSERT INTO `menu_items` VALUES (155,2,4,'Dal Fry',180.00,1,'','assets/food/dal fry.jpg');
INSERT INTO `menu_items` VALUES (156,2,4,'Veg Dal Tadka',95.00,1,'','assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (157,2,4,'Chana Masala',181.00,1,'','assets/food/chana masala.jpg');
INSERT INTO `menu_items` VALUES (158,2,4,'Veg Kadhai',141.00,1,'','assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (159,2,4,'Aloo Matar',102.00,1,'','assets/food/aloo mattar.jpg');
INSERT INTO `menu_items` VALUES (160,2,4,'Veg Kolhapure',120.00,1,'','assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (161,2,4,'Mushroom Hyderabadi',192.00,1,'','assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (162,2,4,'Mushroom Dopyaza',207.00,1,'','assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (163,2,4,'Paneer Dopyaza',89.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (164,2,4,'Paneer Hyderabadi',102.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (165,2,4,'Paneer Bhurji',95.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (166,2,4,'Paneer Butter Masala',228.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (167,2,16,'Egg Bhurji',244.00,1,'','assets/food/egg tadka.jpg');
INSERT INTO `menu_items` VALUES (168,2,16,'Egg Masala',111.00,1,'','assets/food/egg tadka.jpg');
INSERT INTO `menu_items` VALUES (169,2,16,'Egg Tadka',198.00,1,'','assets/food/egg tadka.jpg');
INSERT INTO `menu_items` VALUES (170,2,16,'Fish Masala',205.00,1,'','assets/food/fish thali.jpeg');
INSERT INTO `menu_items` VALUES (171,2,16,'Chicken Kasa',61.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (172,2,16,'Chicken Masala',172.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (173,2,16,'Chicken Hyderabadi',182.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (174,2,16,'Chicken Kolhapure',68.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (175,2,16,'Chicken Korma',191.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (176,2,16,'Chicken Mughlai',108.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (177,2,16,'Chicken Lababdar',91.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (178,2,16,'Chicken Chettinad',127.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (179,2,16,'Kadhai Chicken',160.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (180,2,16,'Chicken Butter Masala',71.00,1,'','assets/food/chicken butter masala.avif');
INSERT INTO `menu_items` VALUES (181,2,16,'Chicken Tikka Masala',169.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (182,2,16,'Chicken Bharta',135.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (183,2,16,'Tandoori Chicken Masala',181.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (184,2,16,'Chicken Patiala',134.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (185,2,16,'Mutton Rogan Josh',198.00,1,'','assets/food/mutton thali.jpg');
INSERT INTO `menu_items` VALUES (186,2,16,'Mutton Curry',193.00,1,'','assets/food/mutton thali.jpg');
INSERT INTO `menu_items` VALUES (187,2,16,'Prawns Masala',130.00,1,'','assets/food/fish thali.jpeg');
INSERT INTO `menu_items` VALUES (188,2,5,'Keema Naan',74.00,1,'','assets/food/plain naan.jpg');
INSERT INTO `menu_items` VALUES (189,2,5,'Masala Naan',91.00,1,'','assets/food/plain naan.jpg');
INSERT INTO `menu_items` VALUES (190,2,5,'Masala Kulcha',223.00,1,'','assets/food/plain kulcha.jpg');
INSERT INTO `menu_items` VALUES (191,2,5,'Garlic Naan',190.00,1,'','assets/food/plain naan.jpg');
INSERT INTO `menu_items` VALUES (192,2,5,'Butter Naan',225.00,1,'','assets/food/butter naan.jpg');
INSERT INTO `menu_items` VALUES (193,2,5,'Rumali Roti',61.00,1,'','assets/food/roti.jpg');
INSERT INTO `menu_items` VALUES (194,2,5,'Plain Naan',132.00,1,'','assets/food/plain naan.jpg');
INSERT INTO `menu_items` VALUES (195,2,5,'Plain Kulcha',124.00,1,'','assets/food/plain kulcha.jpg');
INSERT INTO `menu_items` VALUES (196,2,5,'Laccha Paratha',185.00,1,'','assets/food/laccha parota.jpg');
INSERT INTO `menu_items` VALUES (197,2,5,'Chapati',246.00,1,'','assets/food/roti.jpg');
INSERT INTO `menu_items` VALUES (198,2,23,'Water Bottle',201.00,1,'','assets/food/plain rice.jpg');
INSERT INTO `menu_items` VALUES (199,2,23,'Masala Cold Drink',208.00,1,'','assets/food/tea.jpg');
INSERT INTO `menu_items` VALUES (200,3,20,'French Fries',68.00,1,'','assets/food/crispy baby corn.jpg');
INSERT INTO `menu_items` VALUES (201,3,20,'Peri Peri French Fries',122.00,1,'','assets/food/crispy baby corn.jpg');
INSERT INTO `menu_items` VALUES (202,3,20,'Crispy American Corn',240.00,1,'','assets/food/crispy baby corn.jpg');
INSERT INTO `menu_items` VALUES (203,3,20,'Crispy Baby Corn',119.00,1,'','assets/food/crispy baby corn.jpg');
INSERT INTO `menu_items` VALUES (204,3,20,'Babycorn Salt & Pepper',219.00,1,'','assets/food/crispy baby corn.jpg');
INSERT INTO `menu_items` VALUES (205,3,20,'Babycorn Chilli',115.00,1,'','assets/food/crispy baby corn.jpg');
INSERT INTO `menu_items` VALUES (206,3,20,'Mushroom Chilli',227.00,1,'','assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (207,3,20,'Mushroom Popcorn',238.00,1,'','assets/food/mushroom 65.jpg');
INSERT INTO `menu_items` VALUES (208,3,20,'Mushroom Salt & Pepper',76.00,1,'','assets/food/mushroom 65.jpg');
INSERT INTO `menu_items` VALUES (209,3,20,'Mushroom Manchurian',90.00,1,'','assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (210,3,20,'Paneer Chilli',95.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (211,3,20,'Paneer Popcorn',202.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (212,3,20,'Hot Garlic Paneer Popcorn',53.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (213,3,20,'Paneer Manchurian',243.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (214,3,20,'Paneer Pakora',144.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (215,3,20,'Chicken Pakora',228.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (216,3,20,'Chicken Nuggets',191.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (217,3,20,'Chilli Chicken',194.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (218,3,20,'Honey Chilli Chicken',234.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (219,3,20,'Chicken Popcorn',61.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (220,3,20,'Hot Garlic Chicken Popcorn',102.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (221,3,20,'Chicken 65',126.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (222,3,20,'Dragon Chicken',85.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (223,3,20,'Chicken Majestic',153.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (224,3,20,'Hong Kong Chicken',205.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (225,3,20,'Chicken Kakara',176.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (226,3,20,'Hot Sauce Garlic Chicken',203.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (227,3,2,'Veg Fried Rice',234.00,1,'','assets/food/veg fried rice.jpg');
INSERT INTO `menu_items` VALUES (228,3,2,'Mix Veg Fried Rice',187.00,1,'','assets/food/fried rice.jpg');
INSERT INTO `menu_items` VALUES (229,3,2,'Hong Kong Veg Rice',93.00,1,'','assets/food/veg fried rice.jpg');
INSERT INTO `menu_items` VALUES (230,3,2,'Schezwan Fried Rice',105.00,1,'','assets/food/fried rice.jpg');
INSERT INTO `menu_items` VALUES (231,3,2,'Chicken Fried Rice',235.00,1,'','assets/food/chicken fried rice.jpg');
INSERT INTO `menu_items` VALUES (232,3,2,'Egg Chicken Fried Rice',180.00,1,'','assets/food/egg fried rice.jpg');
INSERT INTO `menu_items` VALUES (233,3,2,'Schezwan Chicken Fried Rice',66.00,1,'','assets/food/chicken fried rice.jpg');
INSERT INTO `menu_items` VALUES (234,3,2,'Plain Rice',154.00,1,'','assets/food/plain rice.jpg');
INSERT INTO `menu_items` VALUES (235,3,2,'Jeera Rice',164.00,1,'','assets/food/jeera rice.jpg');
INSERT INTO `menu_items` VALUES (236,3,2,'Ghee Rice',214.00,1,'','assets/food/plain rice.jpg');
INSERT INTO `menu_items` VALUES (237,3,17,'Veg Hakka Noodles',159.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (238,3,17,'Mix Veg Hakka Noodles',179.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (239,3,17,'Schezwan Veg Noodles',87.00,1,'','assets/food/veg noodles.jpg');
INSERT INTO `menu_items` VALUES (240,3,17,'Chicken Noodles',144.00,1,'','assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (241,3,17,'Egg Chicken Noodles',99.00,1,'','assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (242,3,17,'Schezwan Chicken Noodles',59.00,1,'','assets/food/egg noodles.jpg');
INSERT INTO `menu_items` VALUES (243,3,3,'Dal Fry',182.00,1,'','assets/food/dal fry.jpg');
INSERT INTO `menu_items` VALUES (244,3,3,'Dal Tadka',128.00,1,'','assets/food/dal tadka.jpg');
INSERT INTO `menu_items` VALUES (245,3,4,'Mix Veg',246.00,1,'','assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (246,3,4,'Aloo Dum',250.00,1,'','assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (247,3,4,'Aloo Jeera',244.00,1,'','assets/food/mix veg.jpg');
INSERT INTO `menu_items` VALUES (248,3,4,'Chana Masala',118.00,1,'','assets/food/chana masala.jpg');
INSERT INTO `menu_items` VALUES (249,3,4,'Mushroom Masala',116.00,1,'','assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (250,3,4,'Kadai Mushroom',191.00,1,'','assets/food/mushroom masala.jpg');
INSERT INTO `menu_items` VALUES (251,3,15,'Paneer Masala',78.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (252,3,15,'Paneer Butter Masala',170.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (253,3,15,'Paneer Hyderabadi',83.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (254,3,15,'Punjabi Paneer',229.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (255,3,15,'Kadai Paneer',101.00,1,'','assets/food/paneer butter masala.jpg');
INSERT INTO `menu_items` VALUES (256,3,16,'Chicken Bharta',243.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (257,3,16,'Chicken Curry',184.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (258,3,16,'Chicken Butter Masala',73.00,1,'','assets/food/chicken butter masala.avif');
INSERT INTO `menu_items` VALUES (259,3,16,'Kadai Chicken',245.00,1,'','assets/food/chicken kasa.jpg');
INSERT INTO `menu_items` VALUES (260,3,16,'Chicken Hyderabadi',183.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (261,3,16,'Mughlai Chicken',228.00,1,'','assets/food/chicken curry.jpg');
INSERT INTO `menu_items` VALUES (262,3,5,'Tawa Roti',50.00,1,'','assets/food/tawa roti.jpg');
INSERT INTO `menu_items` VALUES (263,3,5,'Butter Roti',226.00,1,'','assets/food/tawa roti.jpg');
INSERT INTO `menu_items` VALUES (264,3,5,'Plain Paratha',131.00,1,'','assets/food/laccha parota.jpg');
INSERT INTO `menu_items` VALUES (265,3,5,'Laccha Paratha',110.00,1,'','assets/food/laccha parota.jpg');
INSERT INTO `menu_items` VALUES (266,3,5,'Garlic Laccha Paratha',89.00,1,'','assets/food/laccha parota.jpg');
INSERT INTO `menu_items` VALUES (267,3,5,'Aloo Paratha',98.00,1,'','assets/food/laccha parota.jpg');
INSERT INTO `menu_items` VALUES (268,3,5,'Paneer Paratha',132.00,1,'','assets/food/laccha parota.jpg');
INSERT INTO `menu_items` VALUES (269,3,24,'White Sauce Pasta',53.00,1,'','assets/food/white sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (270,3,24,'Red Sauce Pasta',211.00,1,'','assets/food/red sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (271,3,24,'Indian Style Pasta',152.00,1,'','assets/food/white sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (272,3,24,'Mac & Cheese',201.00,1,'','assets/food/white sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (273,3,25,'Veg Classic Pizza',52.00,1,'','assets/food/red sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (274,3,25,'Paneer Loaded Pizza',154.00,1,'','assets/food/red sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (275,3,25,'Peri Peri Paneer Pizza',178.00,1,'','assets/food/red sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (276,3,25,'Mushroom Cheezy Pizza',192.00,1,'','assets/food/red sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (277,3,25,'Chicken Cheese Pizza',212.00,1,'','assets/food/red sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (278,3,25,'Peri Peri Chicken Pizza',152.00,1,'','assets/food/red sauce pasta.jpg');
INSERT INTO `menu_items` VALUES (279,3,26,'Aloo Tikki Burger',129.00,1,'','assets/food/aloo tikka burger.jpg');
INSERT INTO `menu_items` VALUES (280,3,26,'Veg Cheese Burger',144.00,1,'','assets/food/aloo tikka burger.jpg');
INSERT INTO `menu_items` VALUES (281,3,26,'Crispy Paneer Burger',209.00,1,'','assets/food/aloo tikka burger.jpg');
INSERT INTO `menu_items` VALUES (282,3,26,'Crispy Chicken Burger',129.00,1,'','assets/food/aloo tikka burger.jpg');
INSERT INTO `menu_items` VALUES (283,3,27,'Grilled Veg Mayo Sandwich',127.00,1,'','assets/food/peri peri paneer sandwich.jpg');
INSERT INTO `menu_items` VALUES (284,3,27,'Peri Peri Paneer Sandwich',128.00,1,'','assets/food/peri peri paneer sandwich.jpg');
INSERT INTO `menu_items` VALUES (285,3,27,'Cheezy Chicken Sandwich',156.00,1,'','assets/food/peri peri chicken sandwich.jpg');
INSERT INTO `menu_items` VALUES (286,3,27,'Peri Peri Chicken Sandwich',100.00,1,'','assets/food/peri peri chicken sandwich.jpg');
INSERT INTO `menu_items` VALUES (287,3,28,'Dry Fruit Milkshake',79.00,1,'','assets/food/chocolate milkshake.jpg');
INSERT INTO `menu_items` VALUES (288,3,28,'Oreo Milkshake',112.00,1,'','assets/food/oreo shake.jpg');
INSERT INTO `menu_items` VALUES (289,3,28,'Chocolate Milkshake',124.00,1,'','assets/food/chocolate milkshake.jpg');
INSERT INTO `menu_items` VALUES (290,3,28,'Kitkat Milkshake',88.00,1,'','assets/food/chocolate milkshake.jpg');
INSERT INTO `menu_items` VALUES (291,3,28,'Apple Milkshake',160.00,1,'','assets/food/apple milkshake..jpg');
INSERT INTO `menu_items` VALUES (292,3,28,'Banana Milkshake',154.00,1,'','assets/food/chocolate milkshake.jpg');
INSERT INTO `menu_items` VALUES (293,3,28,'Strawberry Milkshake',126.00,1,'','assets/food/chocolate milkshake.jpg');
INSERT INTO `menu_items` VALUES (294,3,28,'Hot Chocolate',246.00,1,'','assets/food/hot chocolate.jpg');
INSERT INTO `menu_items` VALUES (295,3,29,'Cold Coffee',188.00,1,'','assets/food/cold coffee.jpg');
INSERT INTO `menu_items` VALUES (296,3,29,'Cold Coffee (with Ice Cream)',101.00,1,'','assets/food/cold coffee.jpg');
INSERT INTO `menu_items` VALUES (297,3,30,'Hot Coffee',78.00,1,'','assets/food/hot chocolate.jpg');
INSERT INTO `menu_items` VALUES (298,3,23,'Tea',84.00,1,'','assets/food/tea.jpg');
INSERT INTO `menu_items` VALUES (299,3,23,'Blue Lagoon',78.00,1,'','assets/food/blue lagoon.jpg');
INSERT INTO `menu_items` VALUES (300,3,23,'Blueberry Lemon Fizz',148.00,1,'','assets/food/blue lagoon.jpg');
INSERT INTO `menu_items` VALUES (301,3,23,'Blueberry Crush',245.00,1,'','assets/food/blue lagoon.jpg');
INSERT INTO `menu_items` VALUES (302,3,23,'Virgin Mojito',220.00,1,'','assets/food/blue lagoon.jpg');
INSERT INTO `menu_items` VALUES (303,3,23,'Lemonade Fizz',190.00,1,'','assets/food/blue lagoon.jpg');
INSERT INTO `menu_items` VALUES (304,3,23,'Masala Cold Drink',95.00,1,'','assets/food/tea.jpg');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Preparing','Out for Delivery','Delivered','Cancelled') DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `restaurant_id` (`restaurant_id`),
  CONSTRAINT `orders_fk_restaurant` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,3,1,140.00,'Pending','2026-03-20 09:37:04');
INSERT INTO `orders` VALUES (2,3,3,408.00,'Pending','2026-03-20 09:42:37');
INSERT INTO `orders` VALUES (3,3,NULL,505.00,'Pending','2026-03-21 03:15:03');
INSERT INTO `orders` VALUES (4,3,NULL,220.00,'Pending','2026-03-21 03:20:37');
INSERT INTO `orders` VALUES (5,3,NULL,670.00,'Pending','2026-03-21 06:06:07');
INSERT INTO `orders` VALUES (6,3,NULL,440.00,'Pending','2026-04-02 09:34:16');
INSERT INTO `orders` VALUES (7,3,NULL,440.00,'Pending','2026-04-02 09:34:20');
INSERT INTO `orders` VALUES (8,3,NULL,440.00,'Pending','2026-04-02 09:34:23');
INSERT INTO `orders` VALUES (9,3,NULL,440.00,'Pending','2026-04-02 09:34:30');
INSERT INTO `orders` VALUES (10,3,NULL,298.00,'Pending','2026-04-02 17:09:22');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `restaurants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `cuisine_type` varchar(50) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT 1,
  `location` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `restaurants` WRITE;
/*!40000 ALTER TABLE `restaurants` DISABLE KEYS */;
INSERT INTO `restaurants` VALUES (1,2,'Green Salad','Fresh, healthy, and a massive variety of campus favorites.','Indian & Chinese',4.7,'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=400',1,'Near Hostel Gate 1');
INSERT INTO `restaurants` VALUES (2,4,'Shawarma Xpress-3','Amazing Shawarma and fast food','Fast Food',4.5,'https://images.unsplash.com/photo-1529042410759-befb1204b468?q=80&w=400',1,'Near Gate 3');
INSERT INTO `restaurants` VALUES (3,5,'Adventures Cafe','Best place to hang out and eat','Cafe',4.6,'https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=400',1,'Student Center');
/*!40000 ALTER TABLE `restaurants` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `rollno` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','restaurant','admin') DEFAULT 'student',
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT 'default.jpeg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@campuscravings.com',NULL,NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin',NULL,'2026-03-20 09:32:03','default.jpeg');
INSERT INTO `users` VALUES (2,'Green Salad Owner','owner@greensalad.com',NULL,NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','restaurant',NULL,'2026-03-20 09:32:03','default.jpeg');
INSERT INTO `users` VALUES (3,'Ayush Jha','ucse24017@stu.xim.edu.in',NULL,NULL,'$2y$10$zm8NVD8b7opkNDz0GoGxd.wdbJDE5OYId.nQDWVWpTXuLGJKf2p1i','student','77987997878','2026-03-20 09:36:12','user_3_1775063978.jpg');
INSERT INTO `users` VALUES (4,'Shawarma Xpress-3 Owner','shawarma@campuscravings.com',NULL,NULL,'$2y$10$Q6Kr6DU.FItCDhLXbP4yAuXzz9Ay5oCAjvXUe3YFYELYJqiTFm65C','restaurant',NULL,'2026-03-20 09:37:47','default.jpeg');
INSERT INTO `users` VALUES (5,'Adventures Cafe Owner','adventures@campuscravings.com',NULL,NULL,'$2y$10$Q6Kr6DU.FItCDhLXbP4yAuXzz9Ay5oCAjvXUe3YFYELYJqiTFm65C','restaurant',NULL,'2026-03-20 09:37:47','default.jpeg');
INSERT INTO `users` VALUES (6,'Test Student','teststudent2026@xim.edu.in',NULL,NULL,'$2y$10$BcuOGGj7658iiqRSpQ7Jxe9XrxxVRiWvGwiVK9nzHuLbZOpMWtN3G','student','9876543210','2026-04-01 17:29:06','default.jpeg');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

