-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 26, 2024 at 03:55 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clubmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','SuperAdmin') NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `name`, `dob`, `gender`, `email`, `password`, `role`) VALUES
(2, 'abo ali', NULL, NULL, 'email@example.com', 'password', 'SuperAdmin'),
(7, 'Sarah', '2004-04-23', 'Male', 'sarah.sleiman03@lau.edu', '12345678', 'Admin'),
(4, 'ali abdallah', '2003-03-03', 'Female', 'ali@ali.com', 'passpass', 'SuperAdmin');

-- --------------------------------------------------------

--
-- Table structure for table `eventguides`
--

DROP TABLE IF EXISTS `eventguides`;
CREATE TABLE IF NOT EXISTS `eventguides` (
  `event_guide_id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  PRIMARY KEY (`event_guide_id`),
  KEY `event_id` (`event_id`),
  KEY `guide_id` (`guide_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventmembers`
--

DROP TABLE IF EXISTS `eventmembers`;
CREATE TABLE IF NOT EXISTS `eventmembers` (
  `event_member_id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  PRIMARY KEY (`event_member_id`),
  KEY `event_id` (`event_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `category_id` int DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `status` enum('Planned','Ongoing','Completed') NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `name`, `description`, `category_id`, `destination`, `date_from`, `date_to`, `cost`, `status`) VALUES
(2, 'another test', NULL, NULL, NULL, NULL, NULL, NULL, 'Ongoing'),
(3, 'third', NULL, NULL, NULL, NULL, NULL, NULL, 'Completed'),
(4, 'hike3', 'hike', 233, 'felugha', '2023-07-07', '2024-06-06', 1000.00, 'Planned');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

DROP TABLE IF EXISTS `guides`;
CREATE TABLE IF NOT EXISTS `guides` (
  `guide_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`guide_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`guide_id`, `full_name`, `email`, `password`, `dob`, `joining_date`, `profession`, `photo`) VALUES
(2, '[value-2]', 'val@email.com', '[value-4]', '0000-00-00', '0000-00-00', '[value-7]', '[value-8]'),
(3, 'Sarah Jihad Sleiman', 'sarah.sleiman03@lau.edu', '12345678', '0000-00-00', '0000-00-00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `lookups`
--

DROP TABLE IF EXISTS `lookups`;
CREATE TABLE IF NOT EXISTS `lookups` (
  `lookup_id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `display_order` int NOT NULL,
  PRIMARY KEY (`lookup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lookups`
--

INSERT INTO `lookups` (`lookup_id`, `code`, `name`, `display_order`) VALUES
(2, '13', 'name', 27);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `emergency_number` varchar(15) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `full_name`, `email`, `password`, `dob`, `gender`, `joining_date`, `mobile_number`, `emergency_number`, `photo`, `profession`, `nationality`) VALUES
(1, 'mohammed', 'example@example.com', 'passpass', '2004-04-23', 'Female', '2024-08-04', '76718526', '70953141', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
