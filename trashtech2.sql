-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306:3306
-- Generation Time: Oct 25, 2024 at 01:58 PM
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
-- Database: `trashtech2`
--

-- --------------------------------------------------------

--
-- Table structure for table `collected_data`
--

CREATE TABLE `collected_data` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `material_category` enum('paper','plastic','metal','glass') NOT NULL,
  `collection_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `weight_kg` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collected_data`
--

INSERT INTO `collected_data` (`id`, `company_name`, `material_category`, `collection_date`, `weight_kg`) VALUES
(13, 'RiverSide', 'plastic', '2024-10-25 11:02:44', 7.00),
(14, 'RiverSide', 'metal', '2024-10-25 11:02:44', 5.00),
(15, 'RiverSide', 'paper', '2024-10-25 11:02:44', 7.00),
(16, 'RiverSide', 'paper', '2024-10-25 11:02:44', 6.00),
(17, 'RiverSide', 'paper', '2024-10-25 11:02:44', 12.00),
(18, 'RiverSide', 'paper', '2024-10-25 11:02:44', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `owner_names` text NOT NULL,
  `business_type` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `number_of_employees` int(11) NOT NULL,
  `contact_person_name` varchar(255) NOT NULL,
  `contact_person_phone` varchar(15) NOT NULL,
  `company_code` varchar(10) NOT NULL,
  `terms_accepted` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `company_address`, `contact_email`, `owner_names`, `business_type`, `phone_number`, `email_address`, `number_of_employees`, `contact_person_name`, `contact_person_phone`, `company_code`, `terms_accepted`, `created_at`) VALUES
(0, 'Bullshit Co.', 'Kwarto ni Jed, 19, Manuel Ave., Philippines', NULL, '[\"Camille O. Simbulan\"]', 'Sole Proprietorship', '09955034245', 'camille.olaliahf@gmail.com', 999, 'Camille O. Simbulan', '09955034245', '8226E900', 1, '2024-10-16 10:35:11'),
(1, 'Hello World', 'Villa Gloria angeles City Pampanga', NULL, '[\"Jed Simbulan\"]', 'Sole Proprietorship', '09624163425', 'jedbrionessimbulan@gmail.com', 15, 'Jed SImbulan', '09624163425', '5530FF37', 1, '2024-10-04 00:00:03'),
(3, 'Ratbu', 'angeles city', NULL, '[\"James Bituin\"]', 'Corporation', '+63 9166687708', 'anino.jamesharold@auf.edu.ph', 3, 'Lance Dabu', '+63 91223547913', '34C8E882', 1, '2024-10-07 06:38:44'),
(2, 'RiverSide', 'River Side USA', NULL, '[\"River\"]', 'Sole Proprietorship', '+638988898989', 'jedbrionessimbulan@gmail.com', 20, 'River Side', '+638988898989', '4EC5F34D', 1, '2024-10-04 08:15:15'),
(0, 'Skwater', 'gutad floridablanca', NULL, '[\"James Harold Anino\"]', 'Sole Proprietorship', '09166687708', 'jamesharold7503@gmail.com', 3, 'shaina', '09166687708', '84A6BCFE', 1, '2024-10-20 16:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`) VALUES
(6, 'What is the Automated Recyclable Materials Segregator System?', 'The Automated Recyclable Materials Segregator System is an innovative technology designed to automatically sort recyclable materials based on their type. It uses advanced sensors and algorithms to identify and separate materials such as plastic, paper, metal, and glass.'),
(7, 'How does the system work?', 'The system operates by scanning materials as they pass through a conveyor belt. Sensors detect the material type, and the system uses flaps to sort each item into the appropriate bin.'),
(8, 'What are the main benefits of the Automated Recyclable Materials Segregator System?', 'The main benefits include increased efficiency in waste sorting, reduction in labor costs, improved accuracy in recycling processes, and the ability to process large volumes of materials quickly.'),
(9, 'How does the system contribute to waste management and recycling efforts?', 'By automating the sorting process, the system helps reduce contamination in recyclable streams, improves the quality of recycled materials, and supports sustainable waste management practices.'),
(10, 'Is the system customizable to different waste management needs?', 'Yes, the system is highly customizable and can be tailored to meet specific waste management requirements, including handling different types of materials, processing capacities, and integration with existing waste management infrastructure.');

-- --------------------------------------------------------

--
-- Table structure for table `glass_level`
--

CREATE TABLE `glass_level` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `level` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `glass_weight`
--

CREATE TABLE `glass_weight` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `glass_weight`
--

INSERT INTO `glass_weight` (`id`, `company_name`, `weight`, `timestamp`) VALUES
(1, 'Skwater', 2.00, '2024-10-20 18:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Material_category` varchar(255) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `weight` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_tally`
--

CREATE TABLE `material_tally` (
  `id` int(11) NOT NULL,
  `tally_date` date NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `paper_weight` decimal(10,2) DEFAULT 0.00,
  `plastic_weight` decimal(10,2) DEFAULT 0.00,
  `metal_weight` decimal(10,2) DEFAULT 0.00,
  `glass_weight` decimal(10,2) DEFAULT 0.00,
  `period_type` enum('daily','weekly','monthly') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metal_level`
--

CREATE TABLE `metal_level` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `level` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metal_weight`
--

CREATE TABLE `metal_weight` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metal_weight`
--

INSERT INTO `metal_weight` (`id`, `company_name`, `weight`, `timestamp`) VALUES
(1, 'RiverSide', 5.00, '2024-10-24 09:21:57');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `notification_type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `notification_date` date NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `data_collected` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_collected`)),
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paper_level`
--

CREATE TABLE `paper_level` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `level` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paper_weight`
--

CREATE TABLE `paper_weight` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paper_weight`
--

INSERT INTO `paper_weight` (`id`, `company_name`, `weight`, `timestamp`) VALUES
(1, 'RiverSide', 12.00, '2024-09-01 09:58:39'),
(2, 'RiverSide', 6.00, '2024-09-11 09:59:16'),
(3, 'RiverSide', 7.00, '2024-09-30 09:59:33'),
(4, 'RiverSide', 20.00, '2024-08-14 10:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `plastic_level`
--

CREATE TABLE `plastic_level` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `level` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plastic_level`
--

INSERT INTO `plastic_level` (`id`, `company_name`, `level`, `date`, `timestamp`) VALUES
(1, 'RiverSide', 'red', '2024-10-22', '2024-10-21 16:07:07');

-- --------------------------------------------------------

--
-- Table structure for table `plastic_weight`
--

CREATE TABLE `plastic_weight` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plastic_weight`
--

INSERT INTO `plastic_weight` (`id`, `company_name`, `weight`, `timestamp`) VALUES
(1, 'RiverSide', 7.00, '2024-10-24 09:24:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `verification_code` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `email`, `company_name`, `company_address`, `full_name`, `contact_number`, `verification_code`) VALUES
(6, 'Burat', '$2y$10$n9ondYdHdyhhz6hdx4E40eyIy8sBeuxxWHtDJ6770I6FxTxtVLuZK', 'admin', '2024-10-07 08:05:11', 'mahabangulo@gmail.com', 'RiverSide', '', 'Burat', '+631212121212', NULL),
(7, 'Tarub', '$2y$10$HQo/ispgYEpJOldxLb4pq.slMbQzsODqleT5swKYJS.fRC7P75Uei', 'user', '2024-10-09 05:37:02', 'simbulan.josephderick@gmail.com', 'Ratbu', NULL, 'Tarub', '+631234567867', NULL),
(10, 'Hakdog', '$2y$10$iZn45aJbj4aznpj5v/Tj6.PteGraqgSBs4Mh7siV6g5YuaRTykOy2', 'user', '2024-10-14 16:36:02', 'hakdog@gmail.com', 'Ratbu', NULL, 'Hakdog', '+639958473625', NULL),
(11, 'Ratbu', '$2y$10$/I02PwXPTTQgoeyUJu1AnuuhiIEIXs5YUVkglFrL6sxwFwy82/rDa', 'admin', '2024-10-14 16:42:57', 'ratbu@gmail.com', 'Ratbu', NULL, 'Ratbu', '+631234567898', NULL),
(14, 'AaronBriones', '$2y$10$K2HQBng2uJS01Lp/qTadXu0O4OHzE4bEnvWI5PxjmZmHjchcc0RFO', 'admin', '2024-10-20 09:19:26', 'aaronbriones@gmail.com', 'RiverSide', NULL, 'Aaron Briones', '+639876789876', NULL),
(15, 'james', '$2y$10$fMHJKMQ8on1BJyTO.7kvpu3XtVrcfo5np3T.szZMZX5T12MKfIlZK', 'admin', '2024-10-20 16:53:43', 'anino.jamesharold@auf.edu.ph', 'Skwater', '', 'James Anino', '+639166687708', NULL),
(20, 'JedSimbulan', '$2y$10$wW6QhKj3FxAam6iGvCn5b.yYNwbc9hPOom0gyttxFBZUJE3bkU72i', 'admin', '2024-10-24 12:00:51', 'jedsimbulan@gmail.com', 'RiverSide', '', 'Jed Ski', '0987890987', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waste_statistics`
--

CREATE TABLE `waste_statistics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `company_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collected_data`
--
ALTER TABLE `collected_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_name`),
  ADD UNIQUE KEY `company_code` (`company_code`),
  ADD UNIQUE KEY `company_code_2` (`company_code`),
  ADD UNIQUE KEY `company_name` (`company_name`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `glass_level`
--
ALTER TABLE `glass_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `glass_weight`
--
ALTER TABLE `glass_weight`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `material_tally`
--
ALTER TABLE `material_tally`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tally_date` (`tally_date`,`company_name`,`period_type`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `metal_level`
--
ALTER TABLE `metal_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `metal_weight`
--
ALTER TABLE `metal_weight`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `paper_level`
--
ALTER TABLE `paper_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `paper_weight`
--
ALTER TABLE `paper_weight`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `plastic_level`
--
ALTER TABLE `plastic_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `plastic_weight`
--
ALTER TABLE `plastic_weight`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_name` (`company_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username_3` (`username`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `waste_statistics`
--
ALTER TABLE `waste_statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_company_name` (`company_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collected_data`
--
ALTER TABLE `collected_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `glass_level`
--
ALTER TABLE `glass_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `glass_weight`
--
ALTER TABLE `glass_weight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_tally`
--
ALTER TABLE `material_tally`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metal_level`
--
ALTER TABLE `metal_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metal_weight`
--
ALTER TABLE `metal_weight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paper_level`
--
ALTER TABLE `paper_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `paper_weight`
--
ALTER TABLE `paper_weight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plastic_level`
--
ALTER TABLE `plastic_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plastic_weight`
--
ALTER TABLE `plastic_weight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waste_statistics`
--
ALTER TABLE `waste_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `glass_level`
--
ALTER TABLE `glass_level`
  ADD CONSTRAINT `glass_level_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `glass_weight`
--
ALTER TABLE `glass_weight`
  ADD CONSTRAINT `glass_weight_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `material_tally`
--
ALTER TABLE `material_tally`
  ADD CONSTRAINT `material_tally_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`) ON DELETE CASCADE;

--
-- Constraints for table `metal_level`
--
ALTER TABLE `metal_level`
  ADD CONSTRAINT `metal_level_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `metal_weight`
--
ALTER TABLE `metal_weight`
  ADD CONSTRAINT `metal_weight_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `paper_level`
--
ALTER TABLE `paper_level`
  ADD CONSTRAINT `paper_level_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `paper_weight`
--
ALTER TABLE `paper_weight`
  ADD CONSTRAINT `paper_weight_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `plastic_level`
--
ALTER TABLE `plastic_level`
  ADD CONSTRAINT `plastic_level_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `plastic_weight`
--
ALTER TABLE `plastic_weight`
  ADD CONSTRAINT `plastic_weight_ibfk_1` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`);

--
-- Constraints for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_logs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `waste_statistics`
--
ALTER TABLE `waste_statistics`
  ADD CONSTRAINT `fk_company_name` FOREIGN KEY (`company_name`) REFERENCES `companies` (`company_name`) ON DELETE CASCADE,
  ADD CONSTRAINT `waste_statistics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
