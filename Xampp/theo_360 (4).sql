-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306
-- Generation Time: Jun 08, 2024 at 07:08 AM
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
CREATE DATABASE IF NOT EXISTS `theo_360` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `theo_360`;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  'user_id' int not null,
  'sevice_id' int not null,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `indoor_outdoor` varchar(50) DEFAULT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
); ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `username`, `firstname`, `lastname`, `email`, `phone`, `date`, `time`, `location`, `indoor_outdoor`, `event_title`, `package`, `payment_method`, `requests`, `status`) VALUES
(6, 'admin', 'asd', 'asd', 'asd@gmail.com', '123', '2024-06-21', '12:02:00', '213', 'indoor', '123124235', 'test1 - PHP 123.00', 'paycheque', '12313', 'finished'),
(7, 'admin', 'fsdgdfgdg', 'dfgdfgdf', 'gdfgdfg@gmail.com', '332', '2024-07-01', '12:03:00', '3244', 'indoor', '325346', 'qwerty - PHP 123434.00', 'pay cards', '56765465', 'finished'),
(8, 'admin', '123123', '1231231233', '13123123123@gmail.com', '123123', '2024-06-27', '12:05:00', '12313', 'indoor', '312321', 'qwerty - PHP 123434.00', 'direct deposit', '12312', 'finished');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `feedback` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
); ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_desc` text NOT NULL,
  `service_price` decimal(10,2) NOT NULL
); ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
); ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`) VALUES
(5, 'user1@gmail.com', 'user1', '$2y$10$VsTIEQBh.EcJrzLiRW2H6ef0PkMZ0tfQl88ZTg1a4Me7Xhw63mY3W', 'user'),
(6, '', 'admin', '$2y$10$rCYQcm1N7TLoGQaJXOpt9OcTv0Oz1Wfqvz67JSKZ4uHPysy74Jwrm', 'admin'),
(7, 'qwerty@gmail.com', 'qwerty', '$2y$10$D18KgXhu9Z8jxg0XizhQKOR2bI/FjGICFwAUsf9yrbJzHoV74nGTK', 'user'),
(8, 'user2@gmail.com', 'user2', '$2y$10$hzAn/gcb0YTsciCN0OsMJecUg5S0hn5ln0z8AlGtSTWbkeFzvlCxa', 'user'),
(9, 'user5@gmail.com', 'user5', '$2y$10$sP3.FMfLykccpQX11aiSgOxxGfyAq8fk6wp6yq4cu7EcpTT70QJ2W', 'user'),
(10, '', 'admin2', '$2y$10$n3zbkgOK4t3m9Xm4ZNS5gepXxS3wMnXuPqL2QFZn2Bt4EgPMt1HbO', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
