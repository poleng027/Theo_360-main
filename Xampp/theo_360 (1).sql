-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 02:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `theo_360`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `indoor_outdoor` varchar(50) DEFAULT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `package` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `requests` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `username`, `firstname`, `lastname`, `email`, `phone`, `date`, `time`, `location`, `indoor_outdoor`, `event_title`, `package`, `payment_method`, `requests`, `status`) VALUES
(8, 'admin', '123123', '1231231233', '13123123123@gmail.com', '123123', '2024-06-27', '12:05:00', '12313', 'indoor', '312321', 'qwerty - PHP 123434.00', 'direct deposit', '12312', 'approved'),
(9, 'pau', 'Ma. Paula', 'De Chavez', 'dechavezmaa@students.nu-lipa.edu.ph', '09951634465', '2024-06-19', '01:01:00', '123', 'outdoor', '123', 'test1 - PHP 123.00', 'cash', '', 'finished'),
(10, 'drei', 'Ma. Paula', 'De Chavez', 'dechavezmaa@students.nu-lipa.edu.ph', '09951634465', '2024-06-29', '11:11:00', '123', 'indoor', '123', 'test1 - PHP 123.00', 'cash', '', 'pending'),
(11, 'pau', 'Princess Coleen', 'Roxas', 'coleen@gmail.com', '09123456789', '2024-06-30', '11:11:00', 'basta nga', 'indoor', '123', 'test1 - PHP 123.00', 'cash', '', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `username`, `feedback`, `created_at`) VALUES
(1, 'user1', '5', '2024-06-07 12:52:10'),
(2, 'user1', '5', '2024-06-07 12:53:22'),
(3, 'user1', '4', '2024-06-07 12:53:25'),
(4, 'user1', '3', '2024-06-07 12:55:33'),
(5, 'user1', '5', '2024-06-07 13:23:04'),
(6, 'user2', '1', '2024-06-07 13:28:40'),
(7, 'admin', '4', '2024-06-08 05:02:33'),
(8, 'admin', '4', '2024-06-08 05:02:48'),
(9, 'admin', '4', '2024-06-08 05:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `request_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_desc` text NOT NULL,
  `service_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_desc`, `service_price`) VALUES
(6, 'test1', 'test1asdasdasd', 123.00),
(7, 'qwerty', 'qwerty', 123434.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `p_num` varchar(225) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `first_name`, `last_name`, `username`, `password`, `p_num`, `role`) VALUES
(11, 'dechavezmaa@students.nu-lipa.edu.ph', '', '', 'pau', '$2y$10$YNC4Ss26fm1jaGxzI2wrAe2l3Z45EGDt/BP/o8y9hiz3Uq1VOGKrS', '', 'user'),
(12, '', '', '', 'pia', '$2y$10$mFO2s6V0n93bNDNqDC6VT.Wm8nC.uKzYuhOZooE.h3lnxwbSnrwb.', '', 'admin'),
(13, 'tallado@gmail.com', 'Andrei', 'Tallado', 'drei', '$2y$10$z9poET6CS4vNjkPP8gWtq.9hHSpbVQRSIJ4Wf1.eOcPHIdBq1mwSC', '09123456789', 'user'),
(14, 'coleen@gmail.com', 'Princess Coleen', 'Roxas', 'coleen', '$2y$10$u7kIjRrkoSLPmjWatTUfJexLpzX1GzuQWMHlqO3r3g78iRU.t2jA2', '09123456789', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UC_Username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
