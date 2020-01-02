-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2019 at 12:12 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_wfu_userdata`
--

CREATE TABLE `wp_wfu_userdata` (
  `iduserdata` mediumint(9) NOT NULL,
  `uploadid` varchar(20) NOT NULL,
  `property` varchar(100) NOT NULL,
  `propkey` mediumint(9) NOT NULL,
  `propvalue` text,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_wfu_userdata`
--
ALTER TABLE `wp_wfu_userdata`
  ADD PRIMARY KEY (`iduserdata`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_wfu_userdata`
--
ALTER TABLE `wp_wfu_userdata`
  MODIFY `iduserdata` mediumint(9) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
