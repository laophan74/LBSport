-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc36
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 03, 2025 at 05:03 AM
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
-- Database: `db_22121468`
--

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
(21, 4, 12, 2, '2025-05-31 11:11:40'),
(24, 4, 4, 1, '2025-05-31 11:17:33'),
(25, 4, 2, 2, '2025-05-31 11:17:44'),
(26, 4, 1, 3, '2025-05-31 11:17:57'),
(36, 1, 2, 1, '2025-06-02 03:24:35'),
(66, 14, 2, 3, '2025-06-02 18:59:44'),
(79, 9, 25, 4, '2025-06-02 22:04:41');

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
(2, 3, '2025-05-30 03:12:48', 59.99, 'shipped'),
(3, 4, '2025-05-31 03:12:48', 120.50, 'processing'),
(4, 3, '2025-06-02 09:17:41', 498.96, 'pending'),
(7, 9, '2025-06-02 17:00:01', 1078.93, 'cancelled'),
(8, 9, '2025-06-02 17:04:57', 259.98, 'pending'),
(10, 9, '2025-06-02 17:08:53', 89.99, 'cancelled'),
(12, 9, '2025-06-02 17:10:37', 89.99, 'processing'),
(15, 9, '2025-06-02 19:16:35', 434.47, 'pending'),
(16, 9, '2025-06-02 19:18:49', 965.96, 'processing'),
(17, 16, '2025-06-02 19:45:00', 819.93, 'pending'),
(18, 9, '2025-06-02 21:45:21', 1758.64, 'processing'),
(19, 3, '2025-06-03 05:00:54', 79.99, 'pending');

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
(6, 4, 2, 2, 99.99),
(7, 4, 4, 1, 89.99),
(9, 4, 11, 1, 79.00),
(14, 7, 4, 4, 89.99),
(15, 7, 12, 4, 82.25),
(18, 10, 1, 1, 89.99),
(20, 12, 1, 1, 89.99),
(23, 15, 1, 3, 89.99),
(24, 15, 12, 2, 82.25),
(25, 16, 12, 4, 82.25),
(27, 16, 11, 3, 79.00),
(29, 17, 2, 3, 99.99),
(30, 18, 4, 3, 89.99),
(31, 18, 21, 5, 74.99),
(32, 18, 18, 3, 129.99),
(33, 18, 22, 6, 82.00),
(34, 18, 24, 3, 77.25),
(35, 19, 3, 1, 79.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `type`, `image`, `price`, `rating`, `description`, `stock`) VALUES
(1, 'Football Shoes 3', 'football', 'assets/img/shoe1.png', 89.99, NULL, 'Comfortable football shoes.', 12),
(2, 'Football Shoes 2', 'football', 'assets/img/shoe2.png', 99.99, NULL, 'High-performance football gear.', 97),
(3, 'Football Shoes 6', 'football', 'assets/img/shoes6.png', 79.99, 4, 'Durable and lightweight design for agility.', 59),
(4, 'SpeedX Football Shoes', 'football', 'assets/img/shoe1.png', 89.99, 4, 'High-quality football shoes for all weather.', 15),
(6, 'Football Shoes 4', 'football', 'assets/img/shoes4.png', 92.50, 5, 'High-performance football shoes with ankle support.', 75),
(11, 'Badminton Pro Lite', 'badminton', 'assets/img/badminton1.png', 79.00, NULL, 'Lightweight and precise badminton racket.', 71),
(12, 'FeatherMax Racket', 'badminton', 'assets/img/badminton2.png', 82.25, NULL, 'Top choice for pros and amateurs.', 412),
(15, 'Football Shoes 7', 'football', 'assets/img/shoes7.png', 84.00, 3, 'Stylish football cleats with firm grip soles.', 90),
(16, 'Football Shoes 8', 'football', 'assets/img/shoes8.png', 88.95, 5, 'All-weather football boots with shock absorption.', 120),
(17, 'Football Shoes 9', 'football', 'assets/img/shoes9.png', 95.00, 4, 'Elite-level boots for competitive matches.', 50),
(18, 'Tennis Racket 4', 'tennis', 'assets/img/tennis4.png', 129.99, 5, 'Lightweight racket with excellent control.', 37),
(19, 'Tennis Racket 5', 'tennis', 'assets/img/tennis5.png', 114.50, 4, 'Durable frame ideal for intermediate players.', 55),
(20, 'Tennis Racket 6', 'tennis', 'assets/img/tennis6.png', 139.00, 5, 'Professional-grade racket for power and precision.', 30),
(21, 'Badminton Racket 3', 'badminton', 'assets/img/badminton3.png', 74.99, 4, 'Lightweight racket with high-tension strings for control.', 60),
(22, 'Badminton Racket 4', 'badminton', 'assets/img/badminton4.png', 82.00, 5, 'Graphite frame racket for advanced players.', 74),
(23, 'Badminton Racket 5', 'badminton', 'assets/img/badminton5.png', 68.50, 3, 'Sturdy and affordable racket for beginners.', 45),
(24, 'Badminton Racket 6', 'badminton', 'assets/img/badminton6.png', 77.25, 4, 'Balanced design with comfortable grip and control.', 67),
(25, 'Tennis Smash pro Plus Extra', 'tennis', 'assets/img/tennis5.png', 179.00, NULL, 'This is the best tennis smash in the world', 99);

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
(10, 2, 3, 5, 'liked it', '2025-06-01 12:20:17'),
(11, 1, 6, 1, 'overpriced', '2025-06-02 10:09:05'),
(12, 4, 6, 5, 'good', '2025-06-02 10:09:09'),
(14, 4, 9, 4, 'gggg', '2025-06-02 18:06:32'),
(15, 2, 9, 3, 'test', '2025-06-02 18:21:13'),
(16, 1, 9, 5, 'good', '2025-06-02 19:03:52'),
(18, 21, 9, 4, 'too expensive', '2025-06-02 21:45:59'),
(19, 22, 9, 2, 'dislike', '2025-06-02 21:46:29'),
(20, 24, 9, 5, 'pretty good', '2025-06-02 21:46:43'),
(21, 18, 9, 4, 'WWWWWWWWWW', '2025-06-02 21:46:54');

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
(1, 'admin', '1', 'admin@gmail.com', 'admin', '2025-05-28 20:56:20'),
(2, 'john', 'johnpass', 'john@example.com', 'customer', '2025-05-28 20:56:20'),
(3, 'bobtest', 'bob', 'bobtest@gmail.com', 'customer', '2025-05-31 04:42:32'),
(4, 'lao', '1', 'lao@gmail.com', 'customer', '2025-05-31 11:11:06'),
(5, 'user1', '1', 'user1@gmail.com', 'customer', '2025-05-31 23:02:42'),
(8, 'laophan', '1', 'laophan@gmail.com', 'customer', '2025-06-02 14:32:17'),
(9, '1', '1', '1@gmail.com', 'customer', '2025-06-02 14:35:15'),
(10, '2', '2', '2@gmail.com', 'customer', '2025-06-02 14:37:30'),
(11, '4', '1', '4@gmail.com', 'customer', '2025-06-02 14:45:55'),
(12, '5', '1', '5@gmail.com', 'customer', '2025-06-02 14:47:59'),
(13, '6', '1', '6@gmail.com', 'customer', '2025-06-02 14:50:25'),
(14, '3', '1', '3@gmail.com', 'customer', '2025-06-02 14:58:24'),
(15, '8', '1', '8@gmail.com', 'customer', '2025-06-02 16:39:02'),
(16, 'user9', '1', '9@gmail.com', 'customer', '2025-06-02 19:31:58');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
