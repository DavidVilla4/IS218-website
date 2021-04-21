-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: sql1.njit.edu
-- Generation Time: Apr 21, 2021 at 10:17 PM
-- Server version: 8.0.17
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nh279`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `fname` varchar(40) NOT NULL,
  `lname` varchar(40) NOT NULL,
  `oldpass1` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `oldpass2` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='User accounts';

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`username`, `email`, `password`, `fname`, `lname`, `oldpass1`, `oldpass2`) VALUES
('joem', 'jma@njit.edu', '111', 'Joe', 'Mama', '2345', '3456'),
('nhoffmann', 'nh279@njit.edu', '1234', 'Nick', 'Hoffmann', '2345', '3456');

-- --------------------------------------------------------

--
-- Table structure for table `complete_tasks`
--

CREATE TABLE IF NOT EXISTS `complete_tasks` (
  `username` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(2048) NOT NULL,
  `completed` datetime NOT NULL,
  `urgency` enum('low','med','high') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='All completed tasks';

-- --------------------------------------------------------

--
-- Table structure for table `incomplete_tasks`
--

CREATE TABLE IF NOT EXISTS `incomplete_tasks` (
  `username` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(2048) NOT NULL,
  `duedate` datetime NOT NULL,
  `urgency` enum('low','med','high') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Incomplete tasks for all users';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
 ADD PRIMARY KEY (`username`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `complete_tasks`
--
ALTER TABLE `complete_tasks`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `incomplete_tasks`
--
ALTER TABLE `incomplete_tasks`
 ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complete_tasks`
--
ALTER TABLE `complete_tasks`
ADD CONSTRAINT `complete table foreign key` FOREIGN KEY (`username`) REFERENCES `accounts` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `incomplete_tasks`
--
ALTER TABLE `incomplete_tasks`
ADD CONSTRAINT `foreign key username` FOREIGN KEY (`username`) REFERENCES `accounts` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
