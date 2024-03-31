-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2024 at 12:44 PM
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
-- Database: `smarthelmet`
--

-- --------------------------------------------------------

--
-- Table structure for table `deviceassignment`
--

CREATE TABLE `deviceassignment` (
  `ctrno` int(11) NOT NULL,
  `userctr` int(12) DEFAULT NULL,
  `deviceid` varchar(12) NOT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deviceassignment`
--

INSERT INTO `deviceassignment` (`ctrno`, `userctr`, `deviceid`, `description`) VALUES
(1, 1, '001', 'Attached to helmet 1'),
(2, NULL, '002', 'dsfa'),
(3, NULL, '002', 'dasd'),
(4, NULL, '002', 'dfsad'),
(9, 1, '002', 'Motorcycle');

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
  `deviceid` varchar(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gpsinfo`
--

INSERT INTO `gpsinfo` (`counter`, `lon`, `lat`, `alert_date`, `alert_time`, `deviceid`) VALUES
(1114, '120.622857', '15.172185', '03-29-2024', '03:10:51', '001');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ctr` int(12) NOT NULL,
  `username` varchar(12) DEFAULT NULL,
  `password` varchar(12) DEFAULT NULL,
  `accessrights` varchar(12) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `bloodtype` varchar(5) DEFAULT NULL,
  `persontocontact` varchar(200) NOT NULL,
  `addrpersontocontact` text NOT NULL,
  `telnopersontocontact` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ctr`, `username`, `password`, `accessrights`, `lname`, `fname`, `address`, `bloodtype`, `persontocontact`, `addrpersontocontact`, `telnopersontocontact`) VALUES
(1, 'user01', '12345', 'user', 'Jose', 'Rizal', 'Manila', 'O', ' FSAD    ', 'FSD', 'FSDFSADFSADFSAD'),
(4, 'user02', '1111', 'user', '1', '2', '3', 'B', '4', '5', '6'),
(6, 'user03', '00000', 'user', 'Bonifacio', 'Andres', 'Luneta', 'AB', 'Jose Rizal', 'Manila', '111111');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deviceassignment`
--
ALTER TABLE `deviceassignment`
  ADD PRIMARY KEY (`ctrno`);

--
-- Indexes for table `gpsinfo`
--
ALTER TABLE `gpsinfo`
  ADD PRIMARY KEY (`counter`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ctr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deviceassignment`
--
ALTER TABLE `deviceassignment`
  MODIFY `ctrno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gpsinfo`
--
ALTER TABLE `gpsinfo`
  MODIFY `counter` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1115;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ctr` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
