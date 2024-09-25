-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2024 at 04:15 AM
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
-- Database: `agriland`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `region` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `street_number` varchar(255) DEFAULT NULL,
  `purok` varchar(255) DEFAULT NULL,
  `address_type` enum('home','farm') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `user_id`, `region`, `province`, `city_municipality`, `barangay`, `street_number`, `purok`, `address_type`) VALUES
(1, 1, '0300000000', '0304900000', '0304905000', '0304905048', 'asd', 'asdasd', 'home'),
(2, 2, '0300000000', '0304900000', '0304905000', '0304905048', 'asd', 'asdasd', 'home'),
(3, 3, 'Region VII (Central Visayas)', 'Cebu', 'Borbon', 'San Jose', 'da', '331231', 'home'),
(4, 4, '', '', '', '', 'da', '331231', 'home'),
(5, 5, '', '', '', '', 'da', '331231', 'home'),
(6, 6, 'Region III (Central Luzon)', 'Nueva Ecija', 'Cuyapo', 'Calancuasan Sur', 'da', '123123', 'home'),
(7, 7, 'Region VII (Central Visayas)', 'Cebu', 'Boljoon', 'Granada', 'asd', '1231', 'home'),
(8, 8, '', '', '', '', '', '', 'home'),
(9, 9, 'Region III (Central Luzon)', 'Nueva Ecija', 'Carranglan', 'Puncan', 'asd', '331231', 'home'),
(10, 10, 'Region III (Central Luzon)', 'Bulacan', 'Obando', 'Panghulo', 'asd', '091239121', 'home'),
(11, 11, 'Region III (Central Luzon)', 'Bulacan', 'Obando', 'Panghulo', 'asd', '091239121', 'home'),
(12, 12, 'Region III (Central Luzon)', 'Bulacan', 'Obando', 'Panghulo', 'asd', '091239121', 'home'),
(13, 13, 'Region III (Central Luzon)', 'Bulacan', 'Calumpit', 'Longos', 'asd', 'sdads', 'home'),
(14, 14, 'Region III (Central Luzon)', 'Bataan', 'Morong', 'Binaritan', 'asd', '232131', 'home'),
(15, 15, 'Region III (Central Luzon)', 'Bulacan', 'Hagonoy', 'San Pablo', 'sad', '123123', 'home'),
(16, 16, 'Region III (Central Luzon)', 'Bulacan', 'Bustos', 'Malawak', 'asd', '12414', 'home'),
(17, 17, 'Region III (Central Luzon)', 'Bulacan', 'City of Malolos ', 'Dakila', 'asd', '123123', 'home');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `contact_type` enum('personal','emergency') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `user_id`, `phone_number`, `contact_type`) VALUES
(1, 1, '1231', 'personal'),
(2, 1, '09129305198', 'emergency'),
(3, 2, '1231', 'personal'),
(4, 2, '09129305198', 'emergency'),
(5, 3, '2313', 'personal'),
(6, 3, '132123', 'emergency'),
(7, 4, '2313', 'personal'),
(8, 4, '132123', 'emergency'),
(9, 5, '2313', 'personal'),
(10, 5, '132123', 'emergency'),
(11, 6, '123414', 'personal'),
(12, 6, '09129305198', 'emergency'),
(13, 7, '12312', 'personal'),
(14, 7, '1231232', 'emergency'),
(15, 8, '', 'personal'),
(16, 8, '', 'emergency'),
(17, 9, '091239121', 'personal'),
(18, 9, '091239121', 'emergency'),
(19, 10, '091239121', 'personal'),
(20, 10, '091239121', 'emergency'),
(21, 11, '091239121', 'personal'),
(22, 11, '091239121', 'emergency'),
(23, 12, '091239121', 'personal'),
(24, 12, '091239121', 'emergency'),
(25, 13, '12312', 'personal'),
(26, 13, '12312', 'emergency'),
(27, 14, '2131231', 'personal'),
(28, 14, '123123', 'emergency'),
(29, 15, '12314', 'personal'),
(30, 15, '12412', 'emergency'),
(31, 16, '124124', 'personal'),
(32, 16, '124142', 'emergency'),
(33, 17, '12341', 'personal'),
(34, 17, '12414', 'emergency');

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

CREATE TABLE `crops` (
  `reference` int(8) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crop_name` varchar(255) NOT NULL,
  `crop_area_hectares` decimal(10,2) DEFAULT NULL,
  `benefits` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`reference`, `crop_id`, `user_id`, `crop_name`, `crop_area_hectares`, `benefits`) VALUES
(0, 1, 1, 'Palay/Rice', 1231.00, NULL),
(0, 2, 2, 'Palay/Rice', 1231.00, NULL),
(0, 3, 3, 'Corn', 12312.00, NULL),
(0, 4, 4, 'Corn', 12312.00, NULL),
(0, 5, 5, 'Corn', 12312.00, NULL),
(0, 6, 6, 'Mungbean', 231.00, 'Pending'),
(0, 7, 7, 'Onion', 123123.00, 'Pending'),
(0, 8, 8, '', 0.00, 'Pending'),
(0, 9, 9, 'Corn', 123.00, 'Pending'),
(0, 10, 10, 'Corn', 123.00, 'Pending'),
(0, 11, 11, 'Corn', 123.00, 'Pending'),
(0, 12, 12, 'Corn', 123.00, 'Pending'),
(15543306, 13, 13, 'Palay/Rice', 1231.00, 'Pending'),
(68170509, 14, 14, 'corn', 3123.00, 'Pending'),
(24411066, 15, 15, 'Corn', 1231.00, 'Pending'),
(44326085, 16, 16, 'Corn', 12.00, 'Pending'),
(47895949, 17, 17, 'Corn', 12.00, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `jobroles`
--

CREATE TABLE `jobroles` (
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_role` enum('farmer','farmworker','fisherfolk','agri_youth') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobroles`
--

INSERT INTO `jobroles` (`job_id`, `user_id`, `job_role`) VALUES
(1, 1, 'farmworker'),
(2, 2, 'farmworker'),
(3, 3, 'farmworker'),
(4, 4, 'farmworker'),
(5, 5, 'farmworker'),
(6, 6, 'fisherfolk'),
(7, 7, 'farmworker'),
(8, 8, 'farmer'),
(9, 9, 'farmworker'),
(10, 10, 'farmworker'),
(11, 11, 'farmworker'),
(12, 12, 'farmworker'),
(13, 13, 'farmworker'),
(14, 14, 'farmworker'),
(15, 15, 'farmworker'),
(16, 16, 'farmworker'),
(17, 17, 'farmworker');

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

CREATE TABLE `useraccounts` (
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `accountStatus` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useraccounts`
--

INSERT INTO `useraccounts` (`account_id`, `user_id`, `email`, `password`, `accountStatus`, `role`) VALUES
(1, 1, 'Kennethelemen31@gmail.com', '$2y$10$YtP8jPR94Ip3AXlAIfgjWe4AUIahkaWePMU2Q9xSeDWQJVqk/ME5W', NULL, ''),
(3, 3, 'kenneth2131@gmail.com', '$2y$10$n7bzLr/vnhwpDI08TA3kXe/QJw4my4oU/VovdMjbiTIn3JqtCKVTy', NULL, ''),
(6, 6, 'Kennethelemen3223121@gmail.com', '$2y$10$s2DX0mZ/3fu5NOhEc/biXO3H83k82LS.bUd/gIa7RHgjcEDKKoX9S', 'Pending', 'user'),
(7, 7, 'n312@gmail.com', '$2y$10$XsHj9.4a9MQppguVoDE6DulUHsGoycuB6iRgwvU1Z9XxzqALEGJQ2', 'Pending', 'user'),
(8, 8, 'n31@gmail.com', '$2y$10$LXEWmMHAQIBsRC1U0G6lTeswqcBT8Kc/JHk8kMrlGelJMkfoDlyZW', 'Pending', 'user'),
(9, 9, 'julieroseassssssguilar@gmail.com', '$2y$10$as4qV5IweZZ0DgWwdCib.ethosFwh9PrDRQDhxSPhEPuOBPaLHb0C', 'Pending', 'user'),
(10, 10, '091239121@gmail.com', '$2y$10$IfiDhcpKBxBOwT3u2Gxza.tdb8t3eiR5IZnLujABf0apR5J6X8O22', 'Pending', 'user'),
(13, 13, 'Kenneasdasdthelemen31@gmail.com', '$2y$10$KUIutmAr4q8VkJCCUIvvpuqKvmiKKElxWud7sQrrchn8tMlEmqtya', 'Pending', 'user'),
(14, 14, '', '$2y$10$MmjwcyQNBp2.Y1wPpIkwUOrTDNwTs75Qexyl03RAmz0cdY.0yM2w2', 'Pending', 'user'),
(15, 15, 'staff123@gmail.com', '$2y$10$.Dz4CHuGmAeDvWLwCkMRj.9khqxeaITitqIS0w.JHOap7o3om304i', 'Pending', 'staff'),
(16, 16, 'admin123@gmail.com', '$2y$10$5WcwqlbaQxCWbBXYYgYMBOPPDosUK9wRkYhoorbKovA1wxKuQ9Qne', 'Pending', 'admin'),
(17, 17, 'user@gmail.com', '$2y$10$mJip5J5vvUDV8G.ODJq33u9Scsqx0KuVAow60OOa/DuuLiKpeLRb.', 'Pending', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `sur_name` varchar(255) NOT NULL,
  `sex` enum('male','female') NOT NULL,
  `date_of_birth` date NOT NULL,
  `birth_municipality` varchar(255) DEFAULT NULL,
  `birth_province` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `sur_name`, `sex`, `date_of_birth`, `birth_municipality`, `birth_province`, `profile_picture`) VALUES
(1, 'asd', 'asda', 'sdasd', 'male', '2024-09-13', 'adsda', 'dsasd', ''),
(2, 'asd', 'asda', 'sdasd', 'male', '2024-09-13', 'adsda', 'dsasd', ''),
(3, 'asdasdasd', 'dasdasd', 'asdasd', 'male', '2024-09-07', '1231', '2312312', ''),
(4, 'asdasdasd', 'dasdasd', 'asdasd', 'male', '2024-09-07', '1231', '2312312', ''),
(5, 'asdasdasd', 'dasdasd', 'asdasd', 'male', '2024-09-07', '1231', '2312312', ''),
(6, 'testing', 'asda', 'asdasd', 'male', '2024-09-08', 'asd', '1213', ''),
(7, 'asd', 'asd', 'asdasd', 'female', '2024-09-15', '12312', '3132', ''),
(8, 'asdasd', '', '', '', '0000-00-00', '', '', ''),
(9, 'kenneth ', 's', 'Elemen', 'male', '2024-09-19', 'adsda', 'asda', ''),
(10, 'elemen', 'sdasd', 'asdasd', 'male', '2024-09-20', '091239121', '091239121', ''),
(11, 'elemen', 'sdasd', 'asdasd', 'male', '2024-09-20', '091239121', '091239121', ''),
(12, 'elemen', 'sdasd', 'asdasd', 'male', '2024-09-20', '091239121', '091239121', ''),
(13, 'kenenth', 'asdasd', 'asdasd', 'male', '2024-09-20', 'asda', 'sdadsa', ''),
(14, 'asdasd', 'asd', 'asd', 'male', '2024-09-11', '3123', '1231231', ''),
(15, 'staff', 'staff', 'staff', 'male', '2024-09-19', '12312', '1213', ''),
(16, 'admin', 'admin', 'asd', 'male', '2024-09-15', '123123', '142124', ''),
(17, 'user', 'user', 'user', 'male', '2024-09-12', '1231', '32123', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `crops`
--
ALTER TABLE `crops`
  ADD PRIMARY KEY (`crop_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobroles`
--
ALTER TABLE `jobroles`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `useraccounts`
--
ALTER TABLE `useraccounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `crop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jobroles`
--
ALTER TABLE `jobroles`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `useraccounts`
--
ALTER TABLE `useraccounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `crops`
--
ALTER TABLE `crops`
  ADD CONSTRAINT `crops_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `jobroles`
--
ALTER TABLE `jobroles`
  ADD CONSTRAINT `jobroles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `useraccounts`
--
ALTER TABLE `useraccounts`
  ADD CONSTRAINT `useraccounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
