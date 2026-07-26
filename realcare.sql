-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2026 at 02:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realcare`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_price` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `item`, `quantity`, `item_price`, `company`, `customer`, `date_added`) VALUES
(9, 1843, 1, 10500, 0, 6, NULL),
(15, 1513, 1, 15000, 13, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(25, 'Perfumes'),
(26, 'Cosmetics'),
(27, 'Soaps'),
(29, 'Supplements'),
(30, 'Wines'),
(31, 'Jewelries'),
(32, 'Children'),
(33, 'Books'),
(35, 'Body Spray'),
(37, 'DETERGENT'),
(38, 'Toileteries'),
(39, 'Snacks'),
(40, 'Fresh Food'),
(41, 'Household Essentials');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `messages` text NOT NULL,
  `chat_time` datetime NOT NULL DEFAULT current_timestamp(),
  `recipient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `item_id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `item_category` varchar(1024) NOT NULL,
  `item_name` varchar(1024) NOT NULL,
  `item_prize` int(11) NOT NULL,
  `previous_price` int(11) NOT NULL,
  `item_foto` varchar(1024) NOT NULL,
  `other_foto` varchar(1024) NOT NULL,
  `item_description` text NOT NULL,
  `payment_option` varchar(255) NOT NULL,
  `delivery_time` varchar(255) NOT NULL,
  `item_status` int(11) NOT NULL,
  `featured_item` int(12) NOT NULL,
  `daily_deal` int(11) NOT NULL,
  `time_created` datetime DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`item_id`, `company`, `item_category`, `item_name`, `item_prize`, `previous_price`, `item_foto`, `other_foto`, `item_description`, `payment_option`, `delivery_time`, `item_status`, `featured_item`, `daily_deal`, `time_created`, `status`) VALUES
(1848, 13, '31', 'ROLEX FOR MEN', 30000, 0, '1785050562_wrist_watch.jpg', '1785050562_wrist_wateches.jpg', 'The all in one rolex 500. with a face of glass and steeze', 'Full pyment', '1 to 7 days', 0, 0, 0, '2026-07-26 08:22:42', 0),
(1849, 13, '26', 'ROLLON 214', 3500, 0, '1785051552_deodorants.jpg', '1785051552_cream.webp', 'nothing much', 'Full pyment', '1 to 7 days', 0, 0, 0, '2026-07-26 08:39:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `subject` varchar(1024) NOT NULL,
  `details` text NOT NULL,
  `notification_date` datetime DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_price` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_number` varchar(50) NOT NULL,
  `order_status` int(11) NOT NULL,
  `dispense_date` datetime DEFAULT NULL,
  `delivery_option` varchar(50) NOT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `delivery_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan`) VALUES
(10, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `plan_package`
--

CREATE TABLE `plan_package` (
  `package_id` int(11) NOT NULL,
  `plan` int(255) NOT NULL,
  `package` varchar(255) NOT NULL,
  `package_price` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `features` text NOT NULL,
  `booth_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plan_package`
--

INSERT INTO `plan_package` (`package_id`, `plan`, `package`, `package_price`, `duration`, `features`, `booth_status`) VALUES
(15, 10, 'Weekly', 1000, 7, 'Add new item. ith store management. Manage delivery', 0),
(16, 10, 'Monthly', 3500, 30, '', 0),
(17, 10, 'Annually', 36000, 365, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `product_image` varchar(1024) NOT NULL,
  `report_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `full_name`, `phone_number`, `email_address`, `company`, `reason`, `item_name`, `description`, `product_image`, `report_date`) VALUES
(2, 'Kell Ikpefua', '09012478888', 'onostarkels@gmail.com', '', 'Poor product quality', 'maill', '\r\nspilt', 'bags.jpg', '2026-07-25 10:45:32'),
(3, 'Kell Ikpefua', '09012478888', 'onostarkels@gmail.com', '', 'Poor product quality', 'maill', '\r\nspilt', 'bags.jpg', '2026-07-25 10:52:31'),
(4, 'James Brown', '09807865', 'onostarkels@gmail.com', '', 'Incorrect pricing', 'pink alaba', '\r\njkhgjgjhgkjh', 'report_1784974039.jpg', '2026-07-25 11:07:19'),
(5, 'Pastor Jerry', '98678754', 'mail@mail.com', '', 'Damaged or defective product', 'akpu', 'damaged\r\n', 'report_1784974345.jpg', '2026-07-25 11:12:25'),
(6, 'Amaka Nwachukwu', '0901766555', 'amaka@mail.com', '', 'Late delivery', 'bed sheet', 'you delivered 10 days late\r\n', 'report_1784974500.jpg', '2026-07-25 11:15:00'),
(7, 'Hg786uih', '099879787686', 'mm@m.com', '', 'Incorrect pricing', 'jhjk', 'ljklj\r\n', 'report_1784975345.jpg', '2026-07-25 11:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `details` text NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoppers`
--

CREATE TABLE `shoppers` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_password` varchar(1024) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `reg_date` datetime DEFAULT NULL,
  `token` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shoppers`
--

INSERT INTO `shoppers` (`user_id`, `first_name`, `last_name`, `user_password`, `phone_number`, `email`, `address`, `city`, `reg_date`, `token`) VALUES
(8, 'Kelly', 'Ikpefua', '$2y$10$uFsxYZN7pQBcuc4tEb7TBuVILfDg5Wc9SD4z5/XGdpx7jZEh6Etw6', '07068897068', 'onostarkels@gmail.com', '1b Ogidan Street', 'Lagos', '2026-07-24 11:14:05', 0),
(9, 'Abraham', 'Lincoln', '$2y$10$Z5W7iaAJcBE8EgPqQqmvT.epYIMks6xjuxiTbmR8apusSYJzG.C72', '08012345678', 'onostarmedia@gmail.com', '76 Jhaghdcjb', 'Cross River', '2026-07-24 11:31:55', 0),
(10, 'James', 'Jim', '$2y$10$sD/YbwtapgZ7SQiYGJnu/eZ1uJ1UglAMyZjHMaTMv.FsEqIbu0C2y', '09012345687', 'onolunosepro@mail.com', 'Adfsd', 'Kogi', '2026-07-24 15:33:45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `store_payments`
--

CREATE TABLE `store_payments` (
  `payment_id` int(11) NOT NULL,
  `exhibitor` int(11) NOT NULL,
  `package` int(11) NOT NULL,
  `payment_slip` varchar(1024) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `company_name` varchar(1024) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `banner1` varchar(1024) NOT NULL,
  `banner_description` text NOT NULL,
  `banner2` varchar(1024) NOT NULL,
  `banner3` varchar(1024) NOT NULL,
  `banner4` varchar(1024) NOT NULL,
  `company_password` varchar(1024) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `reg_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `company_name`, `company_email`, `about`, `banner1`, `banner_description`, `banner2`, `banner3`, `banner4`, `company_password`, `reg_date`, `reg_status`) VALUES
(13, 'Admin', 'admin@rivicos.com', '', 'banner.png', '', 'anner5.png', 'banner6.png', 'banner4.png', '$2y$10$.PczyxNU0kXRC9aNBSnbju/b8KFi0kVtxAFQ0Aqon7vAgX9Bzv06y', '2024-01-03 18:02:07', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `plan_package`
--
ALTER TABLE `plan_package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `shoppers`
--
ALTER TABLE `shoppers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `store_payments`
--
ALTER TABLE `store_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1850;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `plan_package`
--
ALTER TABLE `plan_package`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shoppers`
--
ALTER TABLE `shoppers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `store_payments`
--
ALTER TABLE `store_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
