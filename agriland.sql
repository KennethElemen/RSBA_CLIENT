-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 08:11 AM
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
(33, 33, 'MIMAROPA Region', 'Occidental Mindoro', 'Magsaysay', 'Lourdes', 'PUROK 3', '123', 'home'),
(34, 34, 'Region VI (Western Visayas)', 'Antique', 'Patnongon', 'Igbobon', 'asda', 'asdasd', 'home'),
(35, 35, 'Region III (Central Luzon)', 'Nueva Ecija', 'Jaen', 'Pakol', '889', '89u696', 'home'),
(39, 43, 'Region X (Northern Mindanao)', 'Camiguin', 'Guinsiliban', 'Liong', 'asdasd', 'asd', 'home'),
(40, 44, 'Region X (Northern Mindanao)', 'Camiguin', 'Guinsiliban', 'Liong', 'asdasd', 'asd', 'home'),
(41, 45, 'Region X (Northern Mindanao)', 'Camiguin', 'Guinsiliban', 'Liong', 'asdasd', 'asd', 'home'),
(42, 46, 'Region X (Northern Mindanao)', 'Lanao del Norte', 'Magsaysay', 'Paclolo', 'asdas', 'dasdsd', 'home'),
(43, 47, 'Region X (Northern Mindanao)', 'Lanao del Norte', 'Magsaysay', 'Paclolo', 'asdas', 'dasdsd', 'home'),
(44, 48, 'Region VI (Western Visayas)', 'Antique', 'Patnongon', 'Igbobon', 'asd', 'asds', 'home'),
(47, 51, 'Region VIII (Eastern Visayas)', 'Leyte', 'Inopacan', 'Marao', 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'home'),
(48, 52, 'Region VIII (Eastern Visayas)', 'Leyte', 'Inopacan', 'Marao', 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'home'),
(49, 53, 'Region VIII (Eastern Visayas)', 'Leyte', 'Inopacan', 'Marao', 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'home'),
(51, 55, 'Region IX (Zamboanga Peninsula)', 'Zamboanga del Norte', 'Sibutad', 'Sibuloc', 'asda', 'asdas', 'home'),
(52, 56, 'Region XIII (Caraga)', 'Agusan del Sur', 'Santa Josefa', 'San Jose', '131', '231', 'home'),
(53, 57, 'Region XIII (Caraga)', 'Agusan del Sur', 'Santa Josefa', 'San Jose', '131', '231', 'home'),
(54, 58, 'Region XI (Davao Region)', 'Davao del Norte', 'Santo Tomas', 'Narvacan', '123', '123123', 'home'),
(55, 59, 'Region XI (Davao Region)', 'Davao del Norte', 'Santo Tomas', 'Narvacan', '123', '123123', 'home');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expiration_date` date DEFAULT NULL,
  `status` enum('active','inactive','expired') DEFAULT 'active',
  `attachment_url` varchar(255) DEFAULT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `role` enum('admin','staff') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `content`, `created_at`, `updated_at`, `expiration_date`, `status`, `attachment_url`, `posted_by`, `role`) VALUES
(42, 'Juslie', 'asedasdASD', '2024-10-11 13:42:17', '2024-10-11 13:42:17', '2024-10-11', 'active', '../assets/images/announcement/ACE MEETING BACKGROUND.png', 33, 'admin'),
(43, 'Juslie', 'asedasdASD', '2024-10-11 13:42:41', '2024-10-11 13:42:41', '2024-10-11', 'active', '../assets/images/announcement/ACE MEETING BACKGROUND.png', 33, 'admin'),
(44, 'Juslie', 'asedasdASD', '2024-10-11 13:42:49', '2024-10-11 13:42:49', '2024-10-11', 'active', '../assets/images/announcement/ACE MEETING BACKGROUND.png', 33, 'admin'),
(45, 'testing oct 12', 'daasd', '2024-10-12 13:00:45', '2024-10-12 13:00:45', '2024-10-12', 'active', '../assets/images/announcement/Logo.jpg', 33, 'admin'),
(46, 'testing oct 12', 'daasd', '2024-10-12 13:02:38', '2024-10-12 13:02:38', '2024-10-12', 'active', '../assets/images/announcement/Logo.jpg', 33, 'admin'),
(47, 'testing oct 12', 'daasd', '2024-10-12 13:02:42', '2024-10-12 13:02:42', '2024-10-12', 'active', '../assets/images/announcement/Logo.jpg', 33, 'admin'),
(50, 'testing announcement Staff', 'Staff staff', '2024-10-12 13:55:09', '2024-10-12 13:55:09', '2024-10-12', 'active', NULL, 35, 'staff'),
(54, 'Testing october 21', 'asdasdasdasdadasdasd', '2024-10-23 05:57:31', '2024-10-23 05:57:31', '2024-10-23', 'active', '../assets/images/announcement/Planet9_3840x2160.jpg', 35, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `contact_type` enum('personal','emergency') NOT NULL,
  `emergency_ContactName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `user_id`, `phone_number`, `contact_type`, `emergency_ContactName`) VALUES
(57, 29, '12314', 'personal', ''),
(58, 29, '123123', 'emergency', ''),
(65, 33, '12312312', 'personal', ''),
(66, 33, '1231231', 'emergency', ''),
(67, 34, '1241412', 'personal', ''),
(68, 34, '123123', 'emergency', ''),
(77, 43, '1231231', 'personal', ''),
(78, 43, '23123', 'emergency', ''),
(79, 44, '1231231', 'personal', ''),
(80, 44, '23123', 'emergency', ''),
(81, 45, '1231231', 'personal', ''),
(82, 45, '23123', 'emergency', ''),
(83, 46, '131231231', 'personal', ''),
(84, 46, '23123123', 'emergency', ''),
(85, 47, '131231231', 'personal', ''),
(86, 47, '23123123', 'emergency', ''),
(87, 48, '123132', 'personal', ''),
(88, 48, '1312', 'emergency', ''),
(89, 49, '123123', 'personal', ''),
(90, 49, '123123', 'emergency', ''),
(91, 50, '123123', 'personal', ''),
(92, 50, '123', 'emergency', ''),
(93, 51, '123123', 'personal', ''),
(94, 53, '123123', 'personal', ''),
(95, 54, '123123', 'personal', ''),
(96, 54, '123123', 'emergency', 'Testing Emergency Contactname'),
(97, 55, '921323', 'personal', ''),
(98, 55, '12381923', 'emergency', ''),
(99, 56, '123123', 'personal', ''),
(100, 56, '12312', 'emergency', ''),
(101, 57, '123123', 'personal', ''),
(102, 57, '12312', 'emergency', ''),
(103, 58, '123123', 'personal', ''),
(104, 58, '1231231', 'emergency', ''),
(105, 59, '123123', 'personal', ''),
(106, 59, '1231231', 'emergency', ''),
(107, 60, 'asdas', 'personal', ''),
(108, 60, 'asda', 'emergency', '');

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
(46946233, 29, 29, 'Corn', 123123.00, 'Pending'),
(96421995, 33, 33, 'Mungbean', 12.00, 'qualified'),
(84951524, 34, 34, 'Mungbean', 1.00, 'qualified'),
(25925279, 35, 35, 'Garlic', 8.00, 'qualified'),
(61798865, 36, 49, 'Corn', 12.00, 'Pending'),
(27741075, 37, 50, 'Corn', 123.00, 'Pending'),
(96298857, 38, 54, 'Corn', 12312.00, 'Pending');

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
(29, 29, 'farmworker'),
(33, 33, 'farmworker'),
(34, 34, 'farmworker'),
(35, 35, 'farmworker'),
(36, 49, 'farmworker'),
(37, 50, 'fisherfolk'),
(38, 54, 'farmworker');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `reply` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` enum('sent','replied','closed') DEFAULT 'sent',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(33, 33, 'admin@gmail.com', '$2y$10$dqx79ViPmMILwKX3eK.zJevcjtqCxpL46nDisX582MbkxgqUz5V/2', 'accepted', 'admin'),
(34, 34, 'Kennethelemen31@gmail.com', '$2y$10$DClCKnLPp4fwotyEYGJUk.Xyd2hwkUh5MorHorgZkbTykVsXPJcsy', 'accepted', 'user'),
(35, 35, 'staff@gmail.com', '$2y$10$PYkc7lEsjsUWYUz2fN8lpuJkWqXexh5kyYBas6Ms.vmX16koHuFUK', 'accepted', 'staff'),
(39, 43, 'asd@gmail.com', '$2y$10$46nyY.pS.1XMGyB65HlvjeLkcSE0scUARP.ezTjhHReGkm.sO/wN6', 'Pending', 'staff'),
(42, 46, 'asdasd@gmail.com', '$2y$10$.njseaBSBtp0UrpAOPUokuRPpsO1KU0ljZoHyjrRG7Nq.za/RKxRS', 'accepted', 'staff'),
(44, 48, 'user12asdas3@gmail.com', '$2y$10$cdf26yw55vavDCN5Njqa.emi/6Vu3btXk1bmpN2eJEIdDhNS39O..', 'accepted', 'staff'),
(48, 55, 'kj@gmail.com', '$2y$10$oTKjMvHR.VFErQ1zD8iUP.EZrwSYG8gvs1GWj/cWaDGDEKggvIj6e', 'accepted', 'staff'),
(49, 56, 'asdasd213@gmail.com', '$2y$10$JJbaw1pa3m2HPYyCO3E/WuaYRMAu/IghQfcfQqDPFH68Y2s2lUcwe', 'accepted', 'staff'),
(51, 58, 'sdasda@gmail.comsasd', '$2y$10$P7HkOX/ABz9GOtqHBQK2CeC6TWV8Gk4ynuTknH4504iG/4MovwYxm', 'accepted', 'staff');

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
(29, 'sad23', 'aasd12', '12123', 'male', '2024-09-14', 'Orion', 'Bataan', '../../RSBSA/assets/images/profiles/profile_29.png'),
(33, 'admin', 'admin', '123', 'male', '2024-09-15', 'Dupax del Sur', 'Nueva Vizcaya', '../../RSBSA/assets/images/profiles/profile_33.png'),
(34, 'kenneth', 'kenneth', 'asdasd', 'male', '2024-09-20', 'Masantol', 'Pampanga', '../../RSBSA/assets/images/profiles/profile_34.png'),
(35, 'Staff', 'Staff', 'Staff', 'male', '2024-09-21', 'Kasibu', 'Nueva Vizcaya', '../../RSBSA/assets/images/profiles/profile_35.jpg'),
(43, 'asdasd', 'asd', 'asda', 'male', '2024-08-28', 'Laur', 'Nueva Ecija', NULL),
(44, 'asdasd', 'asd', 'asda', 'male', '2024-08-28', 'Laur', 'Nueva Ecija', NULL),
(45, 'asdasd', 'asd', 'asda', 'male', '2024-08-28', 'Laur', 'Nueva Ecija', NULL),
(46, 'dasda', 'sdasdasd', 'asdasd', 'female', '2024-09-11', 'Morong', 'Bataan', NULL),
(47, 'dasda', 'sdasdasd', 'asdasd', 'female', '2024-09-11', 'Morong', 'Bataan', NULL),
(48, 'Sasdaasd', 'asdasd', 'asdads', 'male', '2024-09-04', 'General Mamerto Natividad', 'Nueva Ecija', NULL),
(49, 'asd', 'asd', 'asd', 'male', '2024-09-15', 'Minalin', 'Pampanga', '../../RSBSA/assets/images/profiles/profile_49.png'),
(50, 'testingnga ngaun', 'asda', 'asdas', 'male', '2024-10-18', 'Pandi', 'Bulacan', '../../RSBSA/assets/images/profiles/profile_50.png'),
(51, 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'male', '2024-10-16', 'Pandi', 'Bulacan', '../../RSBSA/assets/images/profiles/profile_51.png'),
(52, 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'male', '2024-10-16', 'Pandi', 'Bulacan', '../../RSBSA/assets/images/profiles/profile_52.png'),
(53, 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'male', '2024-10-16', 'Pandi', 'Bulacan', '../../RSBSA/assets/images/profiles/profile_53.png'),
(54, 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'Testing Emergency Contactname', 'male', '2024-10-16', 'Pandi', 'Bulacan', '../../RSBSA/assets/images/profiles/profile_54.png'),
(55, 'Kenneth', 'asda', 'asd', 'male', '2024-11-07', 'San Marcelino', 'Zambales', NULL),
(56, 'asd', 'asd', 'asd', 'male', '2024-10-10', 'Bagulin', 'La Union', '../assets/images/profiles/profile_670a8639c91eb1.43945429.jpg'),
(57, 'asd', 'asd', 'asd', 'male', '2024-10-10', 'Bagulin', 'La Union', '../assets/images/profiles/profile_57.jpg'),
(58, 'asd', 'asda', 'sdasd', 'male', '2024-10-10', 'General Mamerto Natividad', 'Nueva Ecija', '../assets/images/profiles/profile_58.jpg'),
(59, 'asd', 'asda', 'sdasd', 'male', '2024-10-10', 'General Mamerto Natividad', 'Nueva Ecija', '../assets/images/profiles/profile_59.jpg'),
(60, 'asd', 'asd', 'asdas', 'male', '2024-10-16', 'San Manuel', 'Tarlac', '../assets/images/profiles/profile_60.png');

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
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `posted_by` (`posted_by`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_id` (`parent_id`);

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `crop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `jobroles`
--
ALTER TABLE `jobroles`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `useraccounts`
--
ALTER TABLE `useraccounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `useraccounts` (`user_id`);

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
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccounts` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `messages` (`id`);

--
-- Constraints for table `useraccounts`
--
ALTER TABLE `useraccounts`
  ADD CONSTRAINT `useraccounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
