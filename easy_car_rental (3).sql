-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2025 at 10:31 AM
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
-- Database: `easy_car_rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `name`, `email`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', 'admin@easycarrental.com', '2025-07-22 15:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('pending','paid') DEFAULT 'pending',
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `car_id`, `booking_date`, `return_date`, `total_price`, `payment_status`, `is_read`) VALUES
(1, 1, 1, '2025-07-22', '2025-07-23', 120.00, 'paid', 1),
(3, 5, 3, '2025-07-26', '2025-07-27', 150.00, 'paid', 1),
(6, 6, 2, '2025-07-26', '2025-07-28', 200.00, 'paid', 1),
(8, 7, 1, '2025-07-30', '2025-07-30', 120.00, 'paid', 1),
(9, 5, 3, '2025-07-31', '2025-07-31', 150.00, 'paid', 1),
(10, 8, 2, '2025-09-01', '2025-07-02', 100.00, 'paid', 1),
(12, 7, 1, '2025-07-30', '2025-07-25', 120.00, 'paid', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_name` varchar(100) DEFAULT NULL,
  `car_model` varchar(100) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_name`, `car_model`, `price_per_day`, `image`) VALUES
(1, 'Myvi', '2024', 120.00, 'myvi.png'),
(2, 'Axia', '2024', 100.00, 'axia.png'),
(3, 'Bezza', '2024', 150.00, 'bezza.png');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `car_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 1, 5, 'love their services', '2025-07-22 14:25:36'),
(3, 5, 3, 5, 'love', '2025-07-22 17:45:57'),
(4, 6, 2, 3, 'nice', '2025-07-22 20:07:12'),
(5, 7, 1, 4, 'berbaloi', '2025-07-23 05:26:34'),
(6, 5, 3, 5, 'sangat berbaloi', '2025-07-23 05:49:48'),
(8, 7, 1, 3, 'nice', '2025-07-24 02:32:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'alis aqilah', 'alisaqilah0303@gmail.com', '$2y$10$DKQzbBFXK/V7mafusgYyo.o9f5h30kf/QlXDkDxU.hZ2Yw7u7EDzS', 'user', '2025-07-22 14:21:21'),
(5, 'nurulnisaa', 'nisaimanina@gmail.com', '$2y$10$vYPD4dHS1A4am4l60Y8nbO/QcMc12H6x92ZSKz3CDPmFRBaNLFA4O', 'user', '2025-07-22 17:45:21'),
(6, 'amnibasirah', 'amni@gmail.com', '$2y$10$DXDs66uZrz1O/Sez58gMjukB.L3VqN4sSEFK5neXR4RacStjNvzje', 'user', '2025-07-22 20:03:15'),
(7, 'haziqaiman', 'haziqaiman@gmail.com', '$2y$10$pzNmGrKg./AFU8FtAXVaQuSLMNicWLo5YGGJamrOkMu22MxWL2QZm', 'user', '2025-07-23 04:21:59'),
(8, 'zahrinamsyar', 'zahrinamsyar@gmail.com', '$2y$10$CJ20JcOqq1QoUsRm.bg4lOdczKy/1Q9W0OaWEfKHcm.VCinfkS/9S', 'user', '2025-07-23 07:24:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
