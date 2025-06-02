-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc36
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2025 at 01:38 PM
-- Server version: 10.5.18-MariaDB
-- PHP Version: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enterYourDatabase`
--
CREATE DATABASE IF NOT EXISTS `enterYourDatabase` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `enterYourDatabase`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(16, 1, 8, 3, '2025-05-30 20:16:44'),
(17, 1, 8, 2, '2025-05-30 20:16:56'),
(19, 3, 2, 2, '2025-05-31 10:55:55'),
(21, 4, 12, 2, '2025-05-31 11:11:40'),
(23, 4, 5, 1, '2025-05-31 11:17:24'),
(24, 4, 4, 1, '2025-05-31 11:17:33'),
(25, 4, 2, 2, '2025-05-31 11:17:44'),
(26, 4, 1, 3, '2025-05-31 11:17:57'),
(27, 3, 4, 1, '2025-05-31 11:20:21'),
(28, 3, 8, 1, '2025-05-31 13:44:17'),
(31, 3, 11, 1, '2025-06-01 08:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(1, 3, '2025-05-27 03:12:48', 89.98, 'delivered'),
(2, 3, '2025-05-30 03:12:48', 59.99, 'shipped'),
(3, 4, '2025-05-31 03:12:48', 120.50, 'processing');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 2, 2, 29.99),
(2, 1, 10, 1, 29.99),
(3, 2, 7, 1, 59.99),
(4, 3, 3, 1, 70.25),
(5, 3, 8, 1, 50.25);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` int(11) DEFAULT 0,
  `stock` int(11) DEFAULT 0,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `rating`, `description`) VALUES
(1, 'Football Shoes 1', 'assets/img/shoe1.png', 89.99, 4, 'Comfortable football shoes.'),
(2, 'Football Shoes 2', 'assets/img/shoe2.png', 99.99, 5, 'High-performance football gear.'),
(3, 'Training Ball', 'assets/img/banner1.jpeg', 39.99, 4, 'Official size training ball.'),
(4, 'SpeedX Football Shoes', 'assets/img/shoe1.png', 89.99, 4, 'High-quality football shoes for all weather.'),
(5, 'PowerKick Football Boots', 'assets/img/shoe2.png', 99.99, 5, 'Built for speed and power.'),
(6, 'ControlPro Cleats', 'assets/img/shoe3.jpg', 79.50, 3, 'Great grip and control on field.'),
(7, 'Endurance Run Shoes', 'assets/img/shoe5.png', 109.00, 4, 'Long-lasting comfort and performance.'),
(8, 'Tennis Smash 2000', 'assets/img/tennis1.jpg', 129.99, 5, 'Professional-grade tennis racket.'),
(9, 'AceControl Racket', 'assets/img/tennis2.png', 114.50, 4, 'Perfect for intermediate players.'),
(10, 'SpinMaster Series', 'assets/img/tennis3.jpg', 105.75, 4, 'Enhanced spin and control.'),
(11, 'Badminton Pro Lite', 'assets/img/badminton1.png', 79.00, 4, 'Lightweight and precise badminton racket.'),
(12, 'FeatherMax Racket', 'assets/img/badminton2.png', 82.25, 5, 'Top choice for pros and amateurs.');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 2, 5, 'Excellent quality, very comfortable to wear!', '2025-05-28 22:36:17'),
(2, 1, 1, 4, 'Good shoes but slightly tight at first.', '2025-05-28 22:36:17'),
(3, 2, 2, 3, 'Average quality, but decent for the price.', '2025-05-28 22:36:17'),
(4, 8, 1, 5, 'The racket is very light and powerful.', '2025-05-28 22:36:17'),
(5, 8, 2, 4, 'Great for intermediate tennis players.', '2025-05-28 22:36:17'),
(6, 11, 2, 5, 'Top choice for badminton! Loved the grip.', '2025-05-28 22:36:17'),
(7, 7, 3, 4, 'not bad', '2025-06-01 10:03:20'),
(10, 2, 3, 5, 'liked it', '2025-06-01 12:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'admin', 'admin', 'admin@lbsport.com', 'admin', '2025-05-28 20:56:20'),
(2, 'john', 'johnpass', 'john@example.com', 'customer', '2025-05-28 20:56:20'),
(3, 'bobtest', 'bob', 'bobtest@gmail.com', 'customer', '2025-05-31 04:42:32'),
(4, 'lao', '1', 'lao@gmail.com', 'customer', '2025-05-31 11:11:06'),
(5, 'user1', '1', 'user1@gmail.com', 'customer', '2025-05-31 23:02:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_review` (`product_id`,`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
