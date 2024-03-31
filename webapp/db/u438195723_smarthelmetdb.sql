-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 31, 2024 at 10:54 AM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u438195723_smarthelmetdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(3) NOT NULL,
  `date` int(100) NOT NULL DEFAULT current_timestamp(),
  `location` int(100) NOT NULL,
  `Link` int(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `date`, `location`, `Link`, `user_id`) VALUES
(2, 2, 2, 0, NULL),
(222, 222, 222, 0, NULL),
(0, 3, 0, 0, NULL),
(68, 3, 0, 0, 13),
(345, 0, 0, 0, 17),
(22, 22, 22, 0, NULL),
(1, 0, 0, 0, 15);

-- --------------------------------------------------------

--
-- Table structure for table `device_contacts`
--

CREATE TABLE `device_contacts` (
  `id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gpsinfo`
--

CREATE TABLE `gpsinfo` (
  `counter` int(12) NOT NULL,
  `lon` varchar(50) DEFAULT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `alert_date` varchar(15) DEFAULT NULL,
  `alert_time` varchar(50) DEFAULT NULL,
  `deviceid` varchar(12) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `local_emergency_hotline` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `device_id` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gpsinfo`
--

INSERT INTO `gpsinfo` (`counter`, `lon`, `lat`, `alert_date`, `alert_time`, `deviceid`, `emergency_contact`, `local_emergency_hotline`, `age`, `height`, `blood_type`, `user_id`, `device_id`) VALUES
(1152, '120.622833', '15.172295', '03-31-2024', '09:28:05', '001', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(1151, '', '', '03-31-2024', '09:27:13', '001', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(1150, '120.622900', '15.172133', '03-31-2024', '07:28:08', '001', NULL, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`) VALUES
(11, 'Pauloramosespanyol', 'espanyolpaulo@gmail.com', '$2y$10$gb1RDzX6njQMffkaQT/Gaux5TzdU8lyhQsdrH6QL/Wv5PvTuvHxoq'),
(12, 'Paulo espanyolpaulo', 'bumbumpao20@gmail.com', '$2y$10$BDq1Kp/uF9ee1mslxgjhPOQjOrHxGGzPwsg9e4/Z.eQdDb2H6FQ.S'),
(13, 'Jemuel Cordero', 'ccis.jemuel.cordero@gmail.com', '$2y$10$41XFp1/MsFJuzXORlvzoPeJTD6mc0ihJYjUeZjldN0AG5ztk9.Nnm'),
(14, 'Pauloramosespanyol', 'ccis.espanol.paulo@gmail.con', '$2y$10$GfD6fDLtfhGU4JKh35ghu.QI/jZO0UzbfkHKYCFfxo6t8zt8rf5Li'),
(15, 'Anne', 'lyanne.castaneda@gmail.com', '$2y$10$Itriw4O0ZED8YkD4qPHun.ElPOItnuhLqg0JqIN6Jwdr.RKUabov.'),
(16, 'dasd', 'rayinabox14@gmail.com', '$2y$10$Q0uEqqlF13tDesjpGwfstOXusbWm664fmdhTzk0j3n..7P1RvC0Sm'),
(17, 'Ysabela M. pangan', 'panganysabela7@gmail.com', '$2y$10$hASTHwr5D73RHFOT/0saveTBEI81pBjCu0FeRiocFCofJcD37pzEi'),
(18, 'Cordero Jemuel', 'corderojemuel8@gmail.com', '$2y$10$GvplvL8anpAqTqUc3PSe6O/kuki6HfhWdCgyn2P.b.DHQHsLjwWga'),
(19, 'Pyaw espanol', 'espanolpauloramos@spcf.edu.ph', '$2y$10$7ONCOWLisD4sJc3wB//A2eVqc4s4NgKrA6jNP/3V5PDj1eruVP1Zu'),
(20, 'anne', 'annervx@gmail.com', '$2y$10$2XFC54VFUmlLqQcWPWQuEeRLbxv7Ns.IZbO70SBByg.wTYuV6UBaG'),
(21, '', '', '$2y$10$e/7TGu04adWdaOGwqoVYROj1KXS1Sj2Wy7C5eXGwDD4FHGlpKno4y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_contacts`
--
ALTER TABLE `device_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gpsinfo`
--
ALTER TABLE `gpsinfo`
  ADD PRIMARY KEY (`counter`),
  ADD KEY `fk_user_gpsinfo` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device_contacts`
--
ALTER TABLE `device_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gpsinfo`
--
ALTER TABLE `gpsinfo`
  MODIFY `counter` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1153;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
