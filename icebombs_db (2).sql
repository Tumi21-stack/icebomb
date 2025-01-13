-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2024 at 06:27 PM
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
-- Database: `icebombs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `reset_code` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `phone_number`, `reset_code`) VALUES
(1, 'admin', 'P@ssword123', 'ant@icebombs.co.za', '', 'ac6717ace982f5bcb8aa56b6790c71d8');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_communication`
--

CREATE TABLE `customer_communication` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_postal_code` varchar(20) DEFAULT NULL,
  `shipping_country` varchar(100) DEFAULT NULL,
  `item_list` text DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `order_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `province` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `customer_email`, `amount`, `status`, `shipping_address`, `shipping_city`, `shipping_postal_code`, `shipping_country`, `item_list`, `customer_phone`, `order_id`, `created_at`, `province`) VALUES
(31, 'INV-1728045857', 'tshoenyaneboitumelo@gmail.com', 300.00, 'FULFILLED', '34 alsation rd', 'Johannesburg', '1685', 'South Africa', 'Mixed Pack B - 2 of each Lemon, Mango, Pineapple, Granadilla, Strawberry (x1)', '0810753808', 'order_66ffe36ba82771.30025125', '2024-10-04 12:45:31', 'Gauteng'),
(32, 'INV-1728046233', 'tshoenyaneboitumelo@gmail.com', 300.00, 'FULFILLED', '55515 themba dr', 'Johannesburg', '1685', 'South Africa', '10x Pineapple Ice Bomb Real Fruit Lollies (x1)', '0810753808', 'order_66ffe4b0487c36.65133195', '2024-10-04 12:50:56', 'Gauteng'),
(35, 'INV-1728056137', 'tshoenyaneboitumelo@gmail.com', 300.00, 'FULFILLED', '34 alsation rd', 'Johannesburg', '1685', 'South Africa', '10x Pineapple Ice Bomb Real Fruit Lollies (x1)', '0810753808', 'order_67000b5e7762d1.14838969', '2024-10-04 15:35:58', 'Gauteng'),
(36, 'INV-1728056334', 'tshoenyaneboitumelo@gmail.com', 300.00, 'FULFILLED', '34 alsation rd', 'Johannesburg', '1685', 'South Africa', '10x Pineapple Ice Bomb Real Fruit Lollies (x1)', '0810753808', 'order_67000c5c790cc7.06282689', '2024-10-04 15:40:12', 'Gauteng'),
(37, 'INV-1728056922', 'tshoenyaneboitumelo@gmail.com', 300.00, 'FULFILLED', '34 alsation rd', 'Johannesburg', '1685', 'South Africa', '10x Pineapple Ice Bomb Real Fruit Lollies (x1)', '0810753808', 'order_67000f5982a7d6.40224584', '2024-10-04 15:52:57', 'Gauteng'),
(38, 'INV-1728066538', 'tshoenyaneboitumelo@gmail.com', 300.00, 'FULFILLED', '34 alsation rd', 'Johannesburg', '1685', 'South Africa', 'Mixed Pack B - 2 of each Lemon, Mango, Pineapple, Granadilla, Strawberry (x1)', '0810753808', 'ORDER-20241004-9127', '2024-10-04 18:29:18', 'Gauteng');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `quantity` text NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `ingredients`, `stock`, `quantity`, `product_id`) VALUES
(1, 'Mixed Pack A - 2 of each Mango, Strawberry, Litchi, Pineapple, Granadilla', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/MixedPackA.6ad51689.jpg', ' Strawberry: Water, strawberries (34%), sugar, strawberry juice concentrate (water, apple/pear concentrate, mango puree, strawberry puree, stabilizer, ascorbic acid, colourant, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n                    Lemon: Water, fresh lemon juice (30%), sugar, lemon juice concentrate (water, lemon concentrate, acidifying agent, colour, flavouring, preservatives (sodium benzoate, potassium sorbate).\r\n                Mango: Water, mango (20%), sugar, mango juice concentrate (water, apple/pear concentrate, mango puree, orange cells, orange concentrate, ascorbic acid, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n            Litchi: Water, litchi (33%), sugar, litchi juice concentrate (water, apple/pear concentrate, litchi puree, stabilizer, acids, cloudifier, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n            Granadilla: Water, sugar, fresh granadilla pulp (9%), lemon juice (water, lemon juice concentrate, preservatives (sodium benzoate, sulphur dioxide), granadilla concentrate (water, pear/apple concentrate, granadilla puree, orange concentrate, stabilizer, flavouring, preservatives (potassium sorbate, sodium benzoate, sulphur dioxide), flavouring.     ', 100, '2x Strawberry Ice Bomb Real Fruit Lollies, 2x Granadilla Ice Bomb Real Fruit Lollies, 2x Litchi Ice Bomb Real Fruit Lollies, 2x Mango Ice Bomb Real Fruit Lollies, 2x Lemon Ice Bomb Real Fruit Lollies', 1),
(2, 'Mixed Pack B - 2 of each Lemon, Mango, Pineapple, Granadilla, Strawberry', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/MixedPackB.77969c8a (1).jpg', 'Strawberry: Water, strawberries (34%), sugar, strawberry juice concentrate (water, apple/pear concentrate, mango puree, strawberry puree, stabilizer, ascorbic acid, colourant, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\nLemon: Water, fresh lemon juice (30%), sugar, lemon juice concentrate (water, lemon concentrate, acidifying agent, colour, flavouring, preservatives (sodium benzoate, potassium sorbate).\r\nMango: Water, mango (20%), sugar, mango juice concentrate (water, apple/pear concentrate, mango puree, orange cells, orange concentrate, ascorbic acid, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\nGranadilla: Water, sugar, fresh granadilla pulp (9%), lemon juice (water, lemon juice concentrate, preservatives (sodium benzoate, sulphur dioxide), granadilla concentrate (water, pear/apple concentrate, granadilla puree, orange concentrate, stabilizer, flavouring, preservatives (potassium sorbate, sodium benzoate, sulphur dioxide), flavouring. \r\nPineapple: Pineapple pulp (51%)\", \"sugar\", \"coconut milk (coconut milk, water, stabilizer, emulsifier, acidity regulator),flavouring.    ', 100, '2x Strawberry Ice Bomb Real Fruit Lollies, 2x Granadilla Ice Bomb Real Fruit Lollies, 2x Litchi Ice Bomb Real Fruit Lollies, 2x Mango Ice Bomb Real Fruit Lollies, 2x Pineapple Ice Bomb Real Fruit Lollies', 2),
(3, '10x Pineapple Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Pineapple-Product-360x250.11f43dbf.jpg', 'Pineapple: Pineapple pulp (51%)\", \"sugar\", \"coconut milk (coconut milk, water, stabilizer, emulsifier, acidity regulator),flavouring.', 100, '10x Pineapple Ice Bomb Real Fruit Lollies', 3),
(4, '10x Lemon Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Lemon-Product-2-360x250.07c6a361.jpg', 'Lemon: Water, fresh lemon juice (30%), sugar, lemon juice concentrate (water, lemon concentrate, acidifying agent, colour, flavouring, preservatives (sodium benzoate, potassium sorbate).           ', 100, '10x Lemon Ice Bomb Real Fruit Lollies', 4),
(5, '5x Lemon & 5x Pineapple Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Pineapple-Lemon-360x250.90138ef8.jpg', 'Lemon: Water, fresh lemon juice (30%), sugar, lemon juice concentrate (water, lemon concentrate, acidifying agent, colour, flavouring, preservatives (sodium benzoate, potassium sorbate).               \r\nPineapple: Pineapple pulp (51%)\", \"sugar\", \"coconut milk (coconut milk, water, stabilizer, emulsifier, acidity regulator),flavouring.    ', 100, '5x Lemon Ice Bomb Real Fruit Lollies, 5x Pineapple Ice Bomb Real Fruit Lollies', 5),
(6, '5x Litchi & 5x Strawberry Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Strawberry-Litchi-360x250.08a44b25.jpg', 'Strawberry: Water, strawberries (34%), sugar, strawberry juice concentrate (water, apple/pear concentrate, mango puree, strawberry puree, stabilizer, ascorbic acid, colourant, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n                   \r\nLitchi: Water, litchi (33%), sugar, litchi juice concentrate (water, apple/pear concentrate, litchi puree, stabilizer, acids, cloudifier, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n              ', 100, '5x Litchi Ice Bomb Real Fruit Lollies, 5x Strawberry Ice Bomb Real Fruit Lollies', 6),
(7, '10x Granadilla Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Granadilla-Product-4-360x250.22e64a40.jpg', 'Granadilla: Water, sugar, fresh granadilla pulp (9%), lemon juice (water, lemon juice concentrate, preservatives (sodium benzoate, sulphur dioxide), granadilla concentrate (water, pear/apple concentrate, granadilla puree, orange concentrate, stabilizer, flavouring, preservatives (potassium sorbate, sodium benzoate, sulphur dioxide), flavouring.    ', 100, '10x Granadilla Ice Bomb Real Fruit Lollies', 7),
(8, '10x Mango Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Mango-Product-360x250.04629afd.jpg', 'Mango: Water, mango (20%), sugar, mango juice concentrate (water, apple/pear concentrate, mango puree, orange cells, orange concentrate, ascorbic acid, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n            \r\n               ', 100, '10x Mango Ice Bomb Real Fruit Lollies', 8),
(9, '10x Litchi Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Litchi-Product-360x250.7a016837.jpg', 'Litchi: Water, litchi (33%), sugar, litchi juice concentrate (water, apple/pear concentrate, litchi puree, stabilizer, acids, cloudifier, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n              ', 100, '10x Litchi Ice Bomb Real Fruit Lollies', 9),
(10, '10x Strawberry Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Strawberry-Product-360x250.cecd1a47.jpg', 'Strawberry: Water, strawberries (34%), sugar, strawberry juice concentrate (water, apple/pear concentrate, mango puree, strawberry puree, stabilizer, ascorbic acid, colourant, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n                    ', 100, '10x Strawberry Ice Bomb Real Fruit Lollies', 10),
(11, '5 x Lemon & 5 x Mango Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Lemon-Mango-360x250.c6b1ad4a.jpg', 'Lemon: Water, fresh lemon juice (30%), sugar, lemon juice concentrate (water, lemon concentrate, acidifying agent, colour, flavouring, preservatives (sodium benzoate, potassium sorbate).\r\nMango: Water, mango (20%), sugar, mango juice concentrate (water, apple/pear concentrate, mango puree, orange cells, orange concentrate, ascorbic acid, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n            ', 100, '5x Lemon Ice Bomb Real Fruit Lollies, 5x Mango Ice Bomb Real Fruit Lollies', 11),
(12, '5 x Granadilla & 5 x Mango Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Granadilla-Mango-1-360x250.9e89f7ab.jpg', 'Mango: Water, mango (20%), sugar, mango juice concentrate (water, apple/pear concentrate, mango puree, orange cells, orange concentrate, ascorbic acid, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n\r\nGranadilla: Water, sugar, fresh granadilla pulp (9%), lemon juice (water, lemon juice concentrate, preservatives (sodium benzoate, sulphur dioxide), granadilla concentrate (water, pear/apple concentrate, granadilla puree, orange concentrate, stabilizer, flavouring, preservatives (potassium sorbate, sodium benzoate, sulphur dioxide), flavouring.    ', 100, '5x Granadilla Ice Bomb Real Fruit Lollies, 5x Mango Ice Bomb Real Fruit Lollies', 12),
(13, '5 x Granadilla & 5 x Litchi Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Litchi-Granadilla-360x250.c34ed0c9.jpg', 'Litchi: Water, litchi (33%), sugar, litchi juice concentrate (water, apple/pear concentrate, litchi puree, stabilizer, acids, cloudifier, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\nGranadilla: Water, sugar, fresh granadilla pulp (9%), lemon juice (water, lemon juice concentrate, preservatives (sodium benzoate, sulphur dioxide), granadilla concentrate (water, pear/apple concentrate, granadilla puree, orange concentrate, stabilizer, flavouring, preservatives (potassium sorbate, sodium benzoate, sulphur dioxide), flavouring.    ', 100, '5x Granadilla Ice Bomb Real Fruit Lollies, 5x Litchi Ice Bomb Real Fruit Lollies', 13),
(14, '5 x Litchi & 5 x Lemon Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Lemon-Litchi-360x250.1f9c0d73.jpg', 'Lemon: Water, fresh lemon juice (30%), sugar, lemon juice concentrate (water, lemon concentrate, acidifying agent, colour, flavouring, preservatives (sodium benzoate, potassium sorbate).\r\nLitchi: Water, litchi (33%), sugar, litchi juice concentrate (water, apple/pear concentrate, litchi puree, stabilizer, acids, cloudifier, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\n            .    ', 100, '5x Litchi Ice Bomb Real Fruit Lollies, 5x Lemon Ice Bomb Real Fruit Lollies', 14),
(15, '5 x Litchi & 5 x Strawberry Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Strawberry-Litchi-360x250.08a44b25.jpg', ' Strawberry: Water, strawberries (34%), sugar, strawberry juice concentrate (water, apple/pear concentrate, mango puree, strawberry puree, stabilizer, ascorbic acid, colourant, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\nLitchi: Water, litchi (33%), sugar, litchi juice concentrate (water, apple/pear concentrate, litchi puree, stabilizer, acids, cloudifier, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.  ', 100, '5x Litchi Ice Bomb Real Fruit Lollies, 5x Strawberry Ice Bomb Real Fruit Lollies', 15),
(16, '5 x Granadilla & 5 x Strawberry Ice Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Strawberry-Granadilla--360x250.38c04434.jpg', ' Strawberry: Water, strawberries (34%), sugar, strawberry juice concentrate (water, apple/pear concentrate, mango puree, strawberry puree, stabilizer, ascorbic acid, colourant, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring. \r\n\r\nGranadilla: Water, sugar, fresh granadilla pulp (9%), lemon juice (water, lemon juice concentrate, preservatives (sodium benzoate, sulphur dioxide), granadilla concentrate (water, pear/apple concentrate, granadilla puree, orange concentrate, stabilizer, flavouring, preservatives (potassium sorbate, sodium benzoate, sulphur dioxide), flavouring.', 100, '5x Granadilla Ice Bomb Real Fruit Lollies, 5x Strawberry Ice Bomb Real Fruit Lollies', 16),
(17, '5 x Strawberry & 5 x Lemon Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Lemon-Strawberry-360x250.993c6849.jpg', ' Strawberry: Water, strawberries (34%), sugar, strawberry juice concentrate (water, apple/pear concentrate, mango puree, strawberry puree, stabilizer, ascorbic acid, colourant, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\nLemon: Water, fresh lemon juice (30%), sugar, lemon juice concentrate (water, lemon concentrate, acidifying agent, colour, flavouring, preservatives (sodium benzoate, potassium sorbate).    ', 100, '5x Strawberry Ice Bomb Real Fruit Lollies, 5x Lemon Ice Bomb Real Fruit Lollies', 17),
(18, '5 x Litchi & 5 x Pineapple Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Pineapple-Litchi-360x250.7d8fa690.jpg', 'Litchi: Water, litchi (33%), sugar, litchi juice concentrate (water, apple/pear concentrate, litchi puree, stabilizer, acids, cloudifier, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\nPineapple pulp (51%),sugar,coconut milk (coconut milk, water, stabilizer, emulsifier, acidity regulator),flavouring.    ', 100, '5x Litchi Ice Bomb Real Fruit Lollies, 5x Pineapple Ice Bomb Real Fruit Lollies', 18),
(19, '5 x Litchi & 5 x Mango Ice Bomb Real Fruit Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Litchi-Mango--360x250.a7d70132.jpg', 'Mango: Water, mango (20%), sugar, mango juice concentrate (water, apple/pear concentrate, mango puree, orange cells, orange concentrate, ascorbic acid, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\nLitchi: Water, litchi (33%), sugar, litchi juice concentrate (water, apple/pear concentrate, litchi puree, stabilizer, acids, cloudifier, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.', 100, '5x Litchi Ice Bomb Real Fruit Lollies, 5x Mango Ice Bomb Real Fruit Lollies', 19),
(20, '5 x Strawberry & 5 x Pineapple Ice Lollies', 'All of the Ice Bombs are handmade in small batches, using locally-sourced, real sun-ripened fruit. Enjoy the taste of Summer all year round! Each Ice Bomb is a whopping 150g, and packed full of real fruity goodness.', 300.00, 'images/Pineapple-Strawberry-360x250.089d68ce.jpg', 'Strawberry: Water, strawberries (34%), sugar, strawberry juice concentrate (water, apple/pear concentrate, mango puree, strawberry puree, stabilizer, ascorbic acid, colourant, preservatives [sorbic acid, sodium benzoate, sulphur dioxide]), lemon juice, flavouring.\r\nPineapple: Pineapple pulp (51%)\", \"sugar\", \"coconut milk (coconut milk, water, stabilizer, emulsifier, acidity regulator),flavouring.\r\n                    \r\n                  ', 100, '5x Strawberry Ice Bomb Real Fruit Lollies, 5x Pineapple Ice Bomb Real Fruit Lollies', 20);

-- --------------------------------------------------------

--
-- Table structure for table `product_overview`
--

CREATE TABLE `product_overview` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_overview`
--

INSERT INTO `product_overview` (`id`, `product_id`, `name`, `price`, `image`) VALUES
(1, 1, 'Mixed Pack A - 2 of each Mango, Strawberry, Litchi, Pineapple, Granadilla', 300.00, 'images/MixedPackA.6ad51689.jpg'),
(2, 2, 'Mixed Pack B - 2 of each Lemon, Mango, Pineapple, Granadilla, Strawberry', 300.00, 'images/MixedPackB.77969c8a (1).jpg'),
(3, 3, '10x Pineapple Ice Bomb Real Fruit Lollies', 300.00, 'images/Pineapple-Product-360x250.11f43dbf.jpg'),
(4, 4, '10x Lemon Ice Bomb Real Fruit Lollies', 300.00, 'images/Lemon-Product-2-360x250.07c6a361.jpg'),
(5, 5, '5x Lemon & 5x Pineapple Ice Bomb Real Fruit Lollies', 300.00, 'images/Pineapple-Lemon-360x250.90138ef8.jpg'),
(6, 6, '5x Litchi & 5x Strawberry Ice Bomb Real Fruit Lollies', 300.00, 'images/Strawberry-Litchi-360x250.08a44b25.jpg'),
(7, 7, '10x Granadilla Ice Bomb Real Fruit Lollies', 300.00, 'images/Granadilla-Product-4-360x250.22e64a40.jpg'),
(8, 8, '10x Mango Ice Bomb Real Fruit Lollies', 300.00, 'images/Mango-Product-360x250.04629afd.jpg'),
(9, 9, '10x Litchi Ice Bomb Real Fruit Lollies', 300.00, 'images/Litchi-Product-360x250.7a016837.jpg'),
(10, 10, '10x Strawberry Ice Bomb Real Fruit Lollies', 300.00, 'images/Strawberry-Product-360x250.cecd1a47.jpg'),
(11, 11, '5 x Lemon & 5 x Mango Ice Bomb Real Fruit Lollies', 300.00, 'images/Lemon-Mango-360x250.c6b1ad4a.jpg'),
(12, 12, '5 x Granadilla & 5 x Mango Ice Bomb Real Fruit Lollies', 300.00, 'images/Granadilla-Mango-1-360x250.9e89f7ab.jpg'),
(13, 13, '5 x Granadilla & 5 x Litchi Ice Bomb Real Fruit Lollies', 300.00, 'images/Litchi-Granadilla-360x250.c34ed0c9.jpg'),
(14, 14, '5 x Litchi & 5 x Lemon Ice Bomb Real Fruit Lollies', 300.00, 'images/Lemon-Litchi-360x250.1f9c0d73.jpg'),
(15, 15, '5 x Litchi & 5 x Strawberry Ice Bomb Real Fruit Lollies', 300.00, 'images/Strawberry-Litchi-360x250.08a44b25.jpg'),
(16, 16, '5 x Granadilla & 5 x Strawberry Ice Lollies', 300.00, 'images/Strawberry-Granadilla--360x250.38c04434.jpg'),
(17, 17, '5 x Strawberry & 5 x Lemon Real Fruit Lollies', 300.00, 'images/Lemon-Strawberry-360x250.993c6849.jpg'),
(18, 18, '5 x Litchi & 5 x Pineapple Ice Bomb Real Fruit Lollies', 300.00, 'images/Pineapple-Litchi-360x250.7d8fa690.jpg'),
(19, 19, '5 x Litchi & 5 x Mango Ice Bomb Real Fruit Lollies', 300.00, 'images/Litchi-Mango--360x250.a7d70132.jpg'),
(20, 20, '5 x Strawberry & 5 x Pineapple Ice Lollies', 300.00, 'images/Pineapple-Strawberry-360x250.089d68ce.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `subscribed_at`) VALUES
(19, 'md.2022.x7f5q0@vossie.net', '2024-09-27 00:31:25'),
(20, 'tshoenyaneboitumelo@gmail.com', '2024-09-27 00:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `transaction_reference` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `customer_communication`
--
ALTER TABLE `customer_communication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_overview`
--
ALTER TABLE `product_overview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_communication`
--
ALTER TABLE `customer_communication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_overview`
--
ALTER TABLE `product_overview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_overview` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
