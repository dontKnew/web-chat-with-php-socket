-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2022 at 02:29 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socket-chat-app2`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatrooms`
--

CREATE TABLE `chatrooms` (
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `msg` varchar(200) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chatrooms`
--

INSERT INTO `chatrooms` (`chat_id`, `user_id`, `msg`, `timestamp`) VALUES
(124, 1, 'hey', '2022-07-31 06:23:46'),
(125, 1, 'hey', '2022-07-31 06:23:55'),
(126, 1, 'hey', '2022-07-31 06:24:03'),
(127, 1, 'nice wokr yaar', '2022-07-31 06:24:12'),
(128, 2, 'thanks bro :)', '2022-07-31 06:24:22'),
(129, 1, 'acchaa', '2022-07-31 06:26:36'),
(130, 1, 'good work but', '2022-07-31 06:26:42'),
(131, 1, 'oh awsome', '2022-07-31 06:27:28'),
(132, 2, 'kiya hoyga', '2022-07-31 06:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_activation` enum('Disabled','Enable') DEFAULT NULL,
  `user_verification_code` text NOT NULL,
  `user_password` text NOT NULL,
  `user_profile` text NOT NULL,
  `user_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_activation`, `user_verification_code`, `user_password`, `user_profile`, `user_timestamp`) VALUES
(1, 'sajid', 'israfil123.sa@gmail.com', 'Enable', '31d660814976a342d8bc3011f5e6ceeb', '1234', './public/images/avtar.webp', '2022-07-30 09:41:07'),
(2, 'Kamina', 'kamina@gmail.com', 'Enable', '343877f894734dcbc7fb011b5249a554', '1234', './public/images/avtar.webp', '2022-07-30 09:43:09'),
(3, 'Rahul', 'Gmail@gmail.com', '', '95524ff28e87219d1eb14da06ca64d89', '1234', './public/images/avtar.webp', '2022-07-30 09:45:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
